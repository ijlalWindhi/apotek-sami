<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\UnitRequest;
use App\Http\Resources\UnitResource;
use App\Services\UnitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UnitController extends Controller
{
    protected $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index(): View
    {
        return view('pages.inventory.master.unit', [
            'title' => 'Master Pajak',
        ]);
    }

    public function store(UnitRequest $request): JsonResponse
    {
        try {
            $unit = $this->unitService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Unit created successfully',
                'data' => new UnitResource($unit)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create unit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Unit $unit): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new UnitResource($unit)
        ]);
    }

    public function update(UnitRequest $request, Unit $unit): JsonResponse
    {
        try {
            $updatedUnit = $this->unitService->update($unit, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Unit updated successfully',
                'data' => new UnitResource($updatedUnit)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update unit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Unit $unit): JsonResponse
    {
        try {
            $this->unitService->delete($unit);
            return response()->json([
                'success' => true,
                'message' => 'Unit deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete unit',
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

            $unites = $this->unitService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => UnitResource::collection($unites->items()),
                'meta' => [
                    'current_page' => $unites->currentPage(),
                    'per_page' => $unites->perPage(),
                    'total' => $unites->total(),
                    'last_page' => $unites->lastPage(),
                    'from' => $unites->firstItem(),
                    'to' => $unites->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve unit list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
