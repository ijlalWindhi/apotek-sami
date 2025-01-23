<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\ProductRecipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RecipeService
{
    public function create(array $data): Recipe
    {
        try {
            return DB::transaction(function () use ($data) {
                $recipe = Recipe::create($data);

                // Simpan produk jika ada
                if (!empty($data['products'])) {
                    foreach ($data['products'] as $product) {
                        ProductRecipe::create([
                            'recipe_id' => $recipe->id,
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

                return $recipe;
            });
        } catch (\Exception $e) {
            Log::error('Failed to create recipe: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = Recipe::query();

        // Filter berdasarkan search
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('customer_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('doctor_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('doctor_sip', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        // Include relationships
        $query->with(['staff', 'productRecipes.product', 'productRecipes.unit']);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
