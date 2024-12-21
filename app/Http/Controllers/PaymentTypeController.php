<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use App\Http\Requests\PaymentTypeRequest;
use App\Http\Resources\PaymentTypeResource;
use App\Services\PaymentTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentTypeController extends Controller
{
    protected $paymentTypeService;

    public function __construct(PaymentTypeService $paymentTypeService)
    {
        $this->paymentTypeService = $paymentTypeService;
    }

    public function index(): View
    {
        return view('pages.inventory.master.payment-type', [
            'title' => 'Master Tipe Pembayaran',
        ]);
    }

    public function store(PaymentTypeRequest $request): JsonResponse
    {
        try {
            $paymentType = $this->paymentTypeService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Payment Type created successfully',
                'data' => new PaymentTypeResource($paymentType)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(PaymentType $paymentType): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new PaymentTypeResource($paymentType)
        ]);
    }

    public function update(PaymentTypeRequest $request, PaymentType $paymentType): JsonResponse
    {
        try {
            $updatedPaymentType = $this->paymentTypeService->update($paymentType, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Payment type updated successfully',
                'data' => new PaymentTypeResource($updatedPaymentType)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(PaymentType $paymentType): JsonResponse
    {
        try {
            $this->paymentTypeService->delete($paymentType);
            return response()->json([
                'success' => true,
                'message' => 'Payment type deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payment type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $filters = [
                'name' => $request->input('search'), // parameter pencarian
            ];

            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);

            $paymentTypees = $this->paymentTypeService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => PaymentTypeResource::collection($paymentTypees->items()),
                'meta' => [
                    'current_page' => $paymentTypees->currentPage(),
                    'per_page' => $paymentTypees->perPage(),
                    'total' => $paymentTypees->total(),
                    'last_page' => $paymentTypees->lastPage(),
                    'from' => $paymentTypees->firstItem(),
                    'to' => $paymentTypees->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve payment type list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
