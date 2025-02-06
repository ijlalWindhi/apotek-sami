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

    public function delete(Recipe $recipe): bool
    {
        return $recipe->delete();
    }

    public function update(Recipe $recipe, array $data): Recipe
    {
        try {
            return DB::transaction(function () use ($recipe, $data) {
                // Update recipe data
                $recipe->update([
                    'name' => $data['name'],
                    'staff_id' => $data['staff_id'],
                    'customer_name' => $data['customer_name'],
                    'customer_age' => $data['customer_age'],
                    'customer_address' => $data['customer_address'],
                    'doctor_name' => $data['doctor_name'],
                    'doctor_sip' => $data['doctor_sip'],
                ]);

                // Get existing product recipes
                $existingProductRecipes = $recipe->productRecipes()->pluck('id')->toArray();

                // Initialize array to track product recipes to be deleted
                $productRecipesToDelete = $existingProductRecipes;

                // Process each product in the request
                if (!empty($data['products'])) {
                    foreach ($data['products'] as $product) {
                        if (isset($product['id'])) {
                            // Update existing product recipe
                            $recipe->productRecipes()->where('id', $product['id'])->update([
                                'product_id' => $product['product'],
                                'unit_id' => $product['unit'],
                                'qty' => $product['qty'],
                                'price' => $product['price'],
                                'tuslah' => $product['tuslah'],
                                'discount' => $product['discount'],
                                'discount_type' => $product['discount_type'],
                                'subtotal' => $product['subtotal'],
                            ]);

                            // Remove this ID from the delete list
                            $productRecipesToDelete = array_diff($productRecipesToDelete, [$product['id']]);
                        } else {
                            // Add new product recipe
                            $recipe->productRecipes()->create([
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
                }

                // Delete product recipes that are no longer in the request
                if (!empty($productRecipesToDelete)) {
                    $recipe->productRecipes()->whereIn('id', $productRecipesToDelete)->delete();
                }

                return $recipe;
            });
        } catch (\Exception $e) {
            Log::error('Failed to update recipe: ' . $e->getMessage());
            throw $e;
        }
    }
}
