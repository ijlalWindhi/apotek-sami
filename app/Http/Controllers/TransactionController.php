<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PaymentType;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    protected $transactionSercive;

    public function __construct(TransactionService $transactionSercive)
    {
        $this->transactionSercive = $transactionSercive;
    }

    public function detailview(): View
    {
        $paymentTypes = PaymentType::all();

        return view('pages.inventory.transaction.sales-transaction.view', [
            'title' => 'Detail Transaksi Penjualan',
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function store(TransactionRequest $request): JsonResponse
    {
        try {
            $transaction = $this->transactionSercive->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data' => new TransactionResource($transaction)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Transaction $transaction): JsonResponse
    {
        $transaction->load(['staff', 'productTransactions.product', 'productTransactions.unit']);

        return response()->json([
            'success' => true,
            'data' => new TransactionResource($transaction)
        ]);
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $filters = [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
                'start_date' => $request->input('start_date')
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('start_date'))->startOfDay()
                    : null,
                'end_date' => $request->input('end_date')
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('end_date'))->endOfDay()
                    : null
            ];

            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);

            $transactions = $this->transactionSercive->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => TransactionResource::collection($transactions),
                'meta' => [
                    'current_page' => $transactions->currentPage(),
                    'per_page' => $transactions->perPage(),
                    'total' => $transactions->total(),
                    'last_page' => $transactions->lastPage(),
                    'from' => $transactions->firstItem(),
                    'to' => $transactions->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transaction list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
