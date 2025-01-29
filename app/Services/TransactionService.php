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

        // Filter berdasarkan tanggal
        if (!empty($filters['date']) && $filters['date'] instanceof \Carbon\Carbon) {
            $dateString = $filters['date']->format('Y-m-d');
            $query->where(function ($q) use ($dateString) {
                $q->whereDate('created_at', '=', $dateString);
            });
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        // Include relationships
        $query->with(['created_by', 'productTransactions.product', 'productTransactions.unit', 'paymentType', 'recipe']);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
