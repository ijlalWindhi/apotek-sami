<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Http\Requests\RecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Services\RecipeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
    protected $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    public function list(): View
    {
        return view('pages.inventory.pharmacy.recipe.list', [
            'title' => 'Resep'
        ]);
    }

    public function detailview(): View
    {
        return view('pages.inventory.pharmacy.recipe.view', [
            'title' => 'Detail Resep',
        ]);
    }

    public function store(RecipeRequest $request): JsonResponse
    {
        try {
            $recipe = $this->recipeService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Recipe created successfully',
                'data' => new RecipeResource($recipe)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create recipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Recipe $recipe): JsonResponse
    {
        $recipe->load(['staff', 'productRecipes.product', 'productRecipes.unit']);

        return response()->json([
            'success' => true,
            'data' => new RecipeResource($recipe)
        ]);
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $filters = [
                'search' => $request->input('search'),
            ];

            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);

            $recipes = $this->recipeService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => RecipeResource::collection($recipes),
                'meta' => [
                    'current_page' => $recipes->currentPage(),
                    'per_page' => $recipes->perPage(),
                    'total' => $recipes->total(),
                    'last_page' => $recipes->lastPage(),
                    'from' => $recipes->firstItem(),
                    'to' => $recipes->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve recipe list',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Recipe $recipe): JsonResponse
    {
        try {
            $this->recipeService->delete($recipe);
            return response()->json([
                'success' => true,
                'message' => 'Recipe deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete recipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
