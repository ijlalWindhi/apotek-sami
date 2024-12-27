<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function create(array $data): Product
    {
        if ($data['show_margin']) {
            $data['margin_percentage'] = $this->calculateMargin(
                $data['purchase_price'],
                $data['selling_price']
            );
        }

        $product = Product::create($data);

        // Simpan konversi unit jika ada
        if (isset($data['unit_conversions'])) {
            foreach ($data['unit_conversions'] as $conversion) {
                $product->unitConversions()->create([
                    'from_unit_id' => $conversion['from_unit_id'],
                    'to_unit_id' => $conversion['to_unit_id'],
                    'from_value' => $conversion['from_value'],
                    'to_value' => $conversion['to_value']
                ]);
            }
        }

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        // Update konversi unit jika ada
        if (isset($data['unit_conversions'])) {
            // Hapus konversi yang lama
            $product->unitConversions()->delete();

            // Buat konversi baru
            foreach ($data['unit_conversions'] as $conversion) {
                $product->unitConversions()->create([
                    'from_unit_id' => $conversion['from_unit_id'],
                    'to_unit_id' => $conversion['to_unit_id'],
                    'from_value' => $conversion['from_value'],
                    'to_value' => $conversion['to_value']
                ]);
            }
        }

        return $product->fresh(['unitConversions']);
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

    private function calculateMargin(float $purchasePrice, float $sellingPrice): float
    {
        return ($sellingPrice - $purchasePrice) / $sellingPrice;
    }
}
