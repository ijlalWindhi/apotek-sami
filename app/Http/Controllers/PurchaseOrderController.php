<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\PaymentType;
use App\Models\Unit;
use App\Http\Requests\PurchaseOrderRequest;
use App\Http\Resources\PurchaseOrderResource;
use App\Services\PurchaseOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    protected $purchaseOrderService;

    public function __construct(PurchaseOrderService $purchaseOrderService)
    {
        $this->purchaseOrderService = $purchaseOrderService;
    }

    public function index(): View
    {
        $suppliers = Supplier::all();
        $taxes = Tax::all();
        $paymentTypes = PaymentType::all();

        return view('pages.inventory.transaction.purchase-order.list', [
            'title' => 'Purchase Order',
            'suppliers' => $suppliers,
            'taxes' => $taxes,
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function createview(): View
    {
        $suppliers = Supplier::all();
        $taxes = Tax::all();
        $paymentTypes = PaymentType::all();

        return view('pages.inventory.transaction.purchase-order.create', [
            'title' => 'Tambah Purchase Order',
            'suppliers' => $suppliers,
            'taxes' => $taxes,
            'paymentTypes' => $paymentTypes,
            'units' => Unit::all()
        ]);
    }

    public function detailview(): View
    {
        $suppliers = Supplier::all();
        $taxes = Tax::all();
        $paymentTypes = PaymentType::all();

        return view('pages.inventory.transaction.purchase-order.edit', [
            'title' => 'Ubah Purchase Order',
            'suppliers' => $suppliers,
            'taxes' => $taxes,
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function store(PurchaseOrderRequest $request): JsonResponse
    {
        try {
            $purchaseOrder = $this->purchaseOrderService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Purchase order created successfully',
                'data' => new PurchaseOrderResource($purchaseOrder)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create purchase order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(PurchaseOrder $purchaseOrder): JsonResponse
    {
        $purchaseOrder->load(['supplier', 'tax', 'paymentType', 'productPurchaseOrders.product']);

        return response()->json([
            'success' => true,
            'data' => new PurchaseOrderResource($purchaseOrder)
        ]);
    }

    public function update(PurchaseOrderRequest $request, PurchaseOrder $purchaseOrder): JsonResponse
    {
        try {
            $updatedPurchaseOrder = $this->purchaseOrderService->update($purchaseOrder, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Purchase order updated successfully',
                'data' => new PurchaseOrderResource($updatedPurchaseOrder)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update purchase order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(PurchaseOrder $purchaseOrder): JsonResponse
    {
        try {
            $this->purchaseOrderService->delete($purchaseOrder);
            return response()->json([
                'success' => true,
                'message' => 'Purchase order deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete purchase order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $filters = [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date')
            ];

            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);

            $purchaseOrders = $this->purchaseOrderService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => PurchaseOrderResource::collection($purchaseOrders->items()),
                'meta' => [
                    'current_page' => $purchaseOrders->currentPage(),
                    'per_page' => $purchaseOrders->perPage(),
                    'total' => $purchaseOrders->total(),
                    'last_page' => $purchaseOrders->lastPage(),
                    'from' => $purchaseOrders->firstItem(),
                    'to' => $purchaseOrders->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve purchase order list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}