<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionService
{
    public function create(array $data): Transaction
    {
        try {
            return DB::transaction(function () use ($data) {
                $today = date('dmY');
                $latestTransaction = Transaction::where('invoice_number', 'like', "ST-{$today}%")
                    ->orderBy('invoice_number', 'desc')
                    ->first();
                $nextNumber = $latestTransaction ? intval(substr($latestTransaction->invoice_number, -3)) + 1 : 1;
                $data['invoice_number'] = 'ST-' . $today . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                $transaction = Transaction::create($data);

                // Simpan produk jika ada
                if (!empty($data['products'])) {
                    foreach ($data['products'] as $product) {
                        ProductTransaction::create([
                            'transaction_id' => $transaction->id,
                            'product_id' => $product['product'],
                            'unit_id' => $product['unit'],
                            'qty' => $product['qty'],
                            'price' => $product['price'],
                            'tuslah' => $product['tuslah'],
                            'discount' => $product['discount'],
                            'discount_type' => $product['discount_type'],
                            'subtotal' => $product['subtotal'],
                        ]);
                    }
                }

                return $transaction;
            });
        } catch (\Exception $e) {
            Log::error('Failed to create transaction: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = Transaction::query();

        // Filter berdasarkan search
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('invoice_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Filter berdasarkan status
        if (!empty($filters['status']) && $filters['status'] !== 'Semua') {
            $query->where('status', $filters['status']);
        }

        // Filter berdasarkan range tanggal
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [
                $filters['start_date'],
                $filters['end_date']
            ]);
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        // Include relationships
        $query->with(['createdBy', 'productTransactions.product', 'productTransactions.unit', 'paymentType', 'recipe']);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function updateStatusProsesToTerbayar(Transaction $salesTransaction): Transaction
    {
        $salesTransaction->status = "Terbayar";
        $salesTransaction->save();

        return $salesTransaction;
    }

    // TransactionService.php
    public function updateStatus(Transaction $transaction, array $data): Transaction
    {
        try {
            return DB::transaction(function () use ($transaction, $data) {
                // Update main transaction
                $transaction->update([
                    'customer_type' => $data['customer_type'],
                    'notes' => $data['notes'],
                    'payment_type_id' => $data['payment_type_id'],
                    'status' => $data['status'],
                    'discount' => $data['discount'],
                    'discount_type' => $data['discount_type'],
                    'nominal_discount' => $data['nominal_discount'],
                    'paid_amount' => $data['paid_amount'],
                    'change_amount' => $data['change_amount'],
                    'total_amount' => $data['total_amount'],
                    'total_before_discount' => $data['total_before_discount']
                ]);

                // Update or create product transactions
                if (!empty($data['products'])) {
                    // Get existing product transactions
                    $existingProducts = $transaction->productTransactions->keyBy('id');

                    foreach ($data['products'] as $index => $productData) {
                        $productTransaction = null;

                        // If we have an ID in the product data, try to find existing record
                        if (isset($productData['id'])) {
                            $productTransaction = $existingProducts->get($productData['id']);
                        }

                        if ($productTransaction) {
                            // Update existing product transaction
                            $productTransaction->update([
                                'product_id' => $productData['product'],
                                'unit_id' => $productData['unit'],
                                'qty' => $productData['qty'],
                                'price' => $productData['price'],
                                'tuslah' => $productData['tuslah'],
                                'discount' => $productData['discount'],
                                'discount_type' => $productData['discount_type'],
                                'subtotal' => $productData['subtotal'],
                            ]);

                            // Remove from existing products collection to track which ones to delete
                            $existingProducts->forget($productTransaction->id);
                        } else {
                            // Create new product transaction
                            ProductTransaction::create([
                                'transaction_id' => $transaction->id,
                                'product_id' => $productData['product'],
                                'unit_id' => $productData['unit'],
                                'qty' => $productData['qty'],
                                'price' => $productData['price'],
                                'tuslah' => $productData['tuslah'],
                                'discount' => $productData['discount'],
                                'discount_type' => $productData['discount_type'],
                                'subtotal' => $productData['subtotal'],
                            ]);
                        }
                    }

                    // Soft delete any remaining products that weren't in the update data
                    if ($existingProducts->isNotEmpty()) {
                        ProductTransaction::whereIn('id', $existingProducts->pluck('id'))->delete();
                    }
                }

                // Refresh the model to get the updated relations
                return $transaction->fresh(['productTransactions']);
            });
        } catch (\Exception $e) {
            Log::error('Failed to update transaction: ' . $e->getMessage());
            throw $e;
        }
    }
}
