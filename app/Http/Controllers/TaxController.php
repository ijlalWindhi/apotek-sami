<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Http\Requests\TaxRequest;
use App\Http\Resources\TaxResource;
use App\Services\TaxService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaxController extends Controller
{
    protected $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    public function index(): View
    {
        return view('pages.inventory.master.tax', [
            'title' => 'Master Pajak',
        ]);
    }

    public function store(TaxRequest $request): JsonResponse
    {
        try {
            $tax = $this->taxService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Tax created successfully',
                'data' => new TaxResource($tax)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create tax',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Tax $tax): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new TaxResource($tax)
        ]);
    }

    public function update(TaxRequest $request, Tax $tax): JsonResponse
    {
        try {
            $updatedTax = $this->taxService->update($tax, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Tax updated successfully',
                'data' => new TaxResource($updatedTax)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update tax',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Tax $tax): JsonResponse
    {
        try {
            $this->taxService->delete($tax);
            return response()->json([
                'success' => true,
                'message' => 'Tax deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete tax',
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

            $taxes = $this->taxService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => TaxResource::collection($taxes->items()),
                'meta' => [
                    'current_page' => $taxes->currentPage(),
                    'per_page' => $taxes->perPage(),
                    'total' => $taxes->total(),
                    'last_page' => $taxes->lastPage(),
                    'from' => $taxes->firstItem(),
                    'to' => $taxes->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tax list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
