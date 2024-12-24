<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Unit;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): View
    {
        $units = Unit::all();

        return view('pages.inventory.pharmacy.product.product', [
            'title' => 'Produk',
            'units' => $units
        ]);
    }

    public function create(): View
    {
        $units = Unit::all();

        return view('pages.inventory.pharmacy.product.product-create', [
            'title' => 'Tambah Produk',
            'units' => $units
        ]);
    }

    public function detail(): View
    {
        $units = Unit::all();

        return view('pages.inventory.pharmacy.product.product-detail', [
            'title' => 'Ubah Produk',
            'units' => $units
        ]);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $product = $this->productService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => new ProductResource($product)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new ProductResource($product)
        ]);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        try {
            $updatedProduct = $this->productService->update($product, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => new ProductResource($updatedProduct)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Product $product): JsonResponse
    {
        try {
            $this->productService->delete($product);
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $filters = [
                'search' => $request->input('search'), // parameter pencarian
            ];

            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);

            $productes = $this->productService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => ProductResource::collection($productes->items()),
                'meta' => [
                    'current_page' => $productes->currentPage(),
                    'per_page' => $productes->perPage(),
                    'total' => $productes->total(),
                    'last_page' => $productes->lastPage(),
                    'from' => $productes->firstItem(),
                    'to' => $productes->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
