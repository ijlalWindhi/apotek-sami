<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use App\Models\PaymentType;
use App\Http\Requests\ReturnRequest;
use App\Http\Resources\ReturnResource;
use App\Services\ReturnService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnController extends Controller
{
    protected $returnService;

    public function __construct(ReturnService $returnService)
    {
        $this->returnService = $returnService;
    }

    public function index(): View
    {
        $paymentTypes = PaymentType::all();

        return view('pages.pos.return', [
            'title' => 'Retur Transaction',
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function list(): View
    {
        return view('pages.inventory.transaction.return.list', [
            'title' => 'Retur Transaction'
        ]);
    }

    public function store(ReturnRequest $request): JsonResponse
    {
        try {
            $return = $this->returnService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Return created successfully',
                'data' => new ReturnResource($return)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create return',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Retur $return): JsonResponse
    {
        $return->load(['createdBy', 'transaction', 'productReturns.product', 'productReturns.unit']);

        return response()->json([
            'success' => true,
            'data' => new ReturnResource($return)
        ]);
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $filters = [
                'search' => $request->input('search'),
                'start_date' => $request->input('start_date')
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('start_date'))->startOfDay()
                    : null,
                'end_date' => $request->input('end_date')
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('end_date'))->endOfDay()
                    : null
            ];

            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);

            $returns = $this->returnService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => ReturnResource::collection($returns),
                'meta' => [
                    'current_page' => $returns->currentPage(),
                    'per_page' => $returns->perPage(),
                    'total' => $returns->total(),
                    'last_page' => $returns->lastPage(),
                    'from' => $returns->firstItem(),
                    'to' => $returns->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve return list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
