<?php

namespace App\Services;

use App\Models\Retur;
use App\Models\Product;
use App\Models\ProductReturn;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReturnService
{
    public function create(array $data): Retur
    {
        try {
            return DB::transaction(function () use ($data) {
                // Generate return number
                $today = date('dmY');
                $latestReturn = Retur::where('return_number', 'like', "SR-{$today}%")
                    ->orderBy('return_number', 'desc')
                    ->first();
                $nextNumber = $latestReturn ? intval(substr($latestReturn->return_number, -3)) + 1 : 1;
                $data['return_number'] = 'SR-' . $today . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                // Create return header
                $return = Retur::create($data);

                // Update transaction status
                Transaction::findOrFail($data['transaction_id'])
                    ->update(['status' => 'Retur']);

                // Process return products
                if (!empty($data['products'])) {
                    foreach ($data['products'] as $product) {
                        // Create return detail
                        ProductReturn::create([
                            'return_id' => $return->id,
                            'product_transaction_id' => $product['product_transaction_id'],
                            'product_id' => $product['product_id'],
                            'unit_id' => $product['unit_id'],
                            'qty_return' => $product['qty_return'],
                            'subtotal_return' => $product['subtotal_return'],
                        ]);

                        // Restore product stock
                        $this->restoreProductStock($product);
                    }
                }

                return $return;
            });
        } catch (\Exception $e) {
            Log::error('Failed to create return: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = Retur::query();

        // Filter by search
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('return_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Filter by date range
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [
                $filters['start_date'],
                $filters['end_date']
            ]);
        }

        // Include relationships and order
        $query->with(['createdBy', 'transaction', 'productReturns.product', 'productReturns.unit'])
            ->orderBy('created_at', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    private function restoreProductStock(array $productData): void
    {
        $product = Product::findOrFail($productData['product_id']);

        try {
            // Validate if unit is largest or smallest
            if ($product->largest_unit == $productData['unit_id']) {
                $this->restoreLargestUnitStock($product, $productData['qty_return']);
            } elseif ($product->smallest_unit == $productData['unit_id']) {
                $this->restoreSmallestUnitStock($product, $productData['qty_return']);
            } else {
                throw new \Exception("Invalid unit for product ID: {$product->id}");
            }

            $product->save();
        } catch (\Exception $e) {
            Log::error("Failed to restore product stock: " . $e->getMessage());
            throw $e;
        }
    }

    private function restoreLargestUnitStock(Product $product, float $qty): void
    {
        $product->largest_stock += $qty;
        $product->smallest_stock += ($qty * $product->conversion_value);
    }

    private function restoreSmallestUnitStock(Product $product, float $qty): void
    {
        $product->smallest_stock += $qty;
        $product->largest_stock += ($qty / $product->conversion_value);
    }
}
