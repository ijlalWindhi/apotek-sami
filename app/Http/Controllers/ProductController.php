<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): View
    {
        return view('pages.inventory.pharmacy.product.product', [
            'title' => 'Produk',
        ]);
    }

    public function createview(): View
    {
        $units = Unit::all();
        $suppliers = Supplier::all();

        return view('pages.inventory.pharmacy.product.product-create', [
            'title' => 'Tambah Produk',
            'units' => $units,
            'suppliers' => $suppliers
        ]);
    }

    public function detailview(): View
    {
        $units = Unit::all();
        $suppliers = Supplier::all();

        return view('pages.inventory.pharmacy.product.product-edit', [
            'title' => 'Ubah Produk',
            'units' => $units,
            'suppliers' => $suppliers
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
        $product->load(['supplier', 'largestUnit', 'smallestUnit']);

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
                'is_active' => $request->input('is_active') // parameter is_active
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

    public function updateStock(Product $product, Request $request): JsonResponse
    {
        try {
            $quantityLargest = $request->input('qty_largest');
            $quantitySmallest = $request->input('qty_smallest');
            $updatedProduct = $this->productService->updateStock($product, $quantitySmallest, $quantityLargest);

            return response()->json([
                'success' => true,
                'message' => 'Stock opname success',
                'data' => new ProductResource($updatedProduct)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to stock opname',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function export()
    {
        try {
            $fileName = 'daftar_produk_' . date('Y-m-d') . '.xlsx';

            // Cek data sebelum export
            $products = Product::with(['supplier', 'largestUnit', 'smallestUnit'])->get();
            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data produk untuk diexport'
                ], 404);
            }

            $excelFile = Excel::raw(new ProductExport(), \Maatwebsite\Excel\Excel::XLSX);
            $base64File = base64_encode($excelFile);

            return response()->json([
                'success' => true,
                'data' => [
                    'file' => $base64File,
                    'filename' => $fileName
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengexport data produk',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString() // Untuk debugging
            ], 500);
        }
    }
}
