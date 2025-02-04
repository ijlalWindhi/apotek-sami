<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function create(array $data): Product
    {
        $data['margin_percentage'] = $this->calculateMargin(
            $data['purchase_price'],
            $data['selling_price']
        );

        $product = Product::create($data);

        return $product->load(['supplier', 'largestUnit', 'smallestUnit']);
    }

    public function update(Product $product, array $data): Product
    {
        if (isset($data['purchase_price']) && isset($data['selling_price'])) {
            $data['margin_percentage'] = $this->calculateMargin(
                $data['purchase_price'],
                $data['selling_price']
            );
        }

        $product->update($data);

        return $product->fresh(['supplier', 'largestUnit', 'smallestUnit']);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = Product::query();

        // Filter berdasarkan nama
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('sku', 'like', '%' . $filters['search'] . '%');
            });
        }
        if (!empty($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        // Tambahkan pengurutan default
        $query->orderBy('name', 'asc');

        // Include relationships
        $query->with(['supplier', 'largestUnit', 'smallestUnit']);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function updateStock(Product $product, float $quantitySmallest, float $quantityLargest): Product
    {
        $product->smallest_stock = $quantitySmallest;
        $product->largest_stock = $quantityLargest;
        $product->save();

        return $product->fresh(['supplier', 'largestUnit', 'smallestUnit']);
    }

    private function calculateMargin(float $purchasePrice, float $sellingPrice): float
    {
        return (($sellingPrice - $purchasePrice) / $sellingPrice) * 100;
    }
}
