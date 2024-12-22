<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\PaymentType;
use App\Http\Requests\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index(): View
    {
        return view('pages.inventory.master.supplier.supplier', [
            'title' => 'Master Supplier',
        ]);
    }

    public function createview(): View
    {
        $payment_type = PaymentType::all();

        return view('pages.inventory.master.supplier.supplier-create', [
            'title' => 'Create Master Supplier',
            'payment_type' => $payment_type
        ]);
    }

    public function detailview(): View
    {
        $payment_type = PaymentType::all();

        return view('pages.inventory.master.supplier.supplier-edit', [
            'title' => 'Edit Master Supplier',
            'payment_type' => $payment_type
        ]);
    }

    public function detail(): View
    {
        $payment_type = PaymentType::all();

        return view('pages.inventory.master.supplier', [
            'title' => 'Detail Supplier',
            'payment_type' => $payment_type
        ]);
    }

    public function store(SupplierRequest $request): JsonResponse
    {
        try {
            $supplier = $this->supplierService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Supplier created successfully',
                'data' => new SupplierResource($supplier)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create supplier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Supplier $supplier): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new SupplierResource($supplier)
        ]);
    }

    public function update(SupplierRequest $request, Supplier $supplier): JsonResponse
    {
        try {
            $updatedSupplier = $this->supplierService->update($supplier, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Supplier updated successfully',
                'data' => new SupplierResource($updatedSupplier)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update supplier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Supplier $supplier): JsonResponse
    {
        try {
            $this->supplierService->delete($supplier);
            return response()->json([
                'success' => true,
                'message' => 'Supplier deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete supplier',
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

            $supplieres = $this->supplierService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => SupplierResource::collection($supplieres->items()),
                'meta' => [
                    'current_page' => $supplieres->currentPage(),
                    'per_page' => $supplieres->perPage(),
                    'total' => $supplieres->total(),
                    'last_page' => $supplieres->lastPage(),
                    'from' => $supplieres->firstItem(),
                    'to' => $supplieres->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve supplier list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
