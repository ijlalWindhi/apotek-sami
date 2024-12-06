<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function create(array $data): Product
    {
        if ($data['show_markup_margin']) {
            $data['markup_percentage'] = $this->calculateMarkup(
                $data['purchase_price'],
                $data['selling_price']
            );

            $data['margin_percentage'] = $this->calculateMargin(
                $data['purchase_price'],
                $data['selling_price']
            );
        }

        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->fresh();
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

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        // Include unit relationship
        $query->with('unit');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    private function calculateMarkup(float $purchasePrice, float $sellingPrice): float
    {
        return (($sellingPrice - $purchasePrice) / $purchasePrice) * 100;
    }

    private function calculateMargin(float $purchasePrice, float $sellingPrice): float
    {
        return (($sellingPrice - $purchasePrice) / $sellingPrice) * 100;
    }
}
