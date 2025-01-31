<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PaymentType;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesTransactionController extends Controller
{
    protected $transactionSercive;

    public function __construct(TransactionService $transactionSercive)
    {
        $this->transactionSercive = $transactionSercive;
    }

    public function index(): View
    {
        return view('pages.inventory.transaction.sales-transaction.list', [
            'title' => 'Transaksi Penjualan',
        ]);
    }

    public function detailview(): View
    {
        $paymentTypes = PaymentType::all();

        return view('pages.inventory.transaction.sales-transaction.view', [
            'title' => 'Detail Transaksi Penjualan',
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function show(Transaction $salesTransaction): JsonResponse
    {
        $salesTransaction->load(['createdBy', 'productTransactions.product', 'productTransactions.unit', 'paymentType', 'recipe']);

        return response()->json([
            'success' => true,
            'data' => new TransactionResource($salesTransaction)
        ]);
    }

    public function updateStatusProsesToTerbayar(Transaction $salesTransaction): JsonResponse
    {
        try {
            $salesTransaction = $this->transactionSercive->updateStatusProsesToTerbayar($salesTransaction);
            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully',
                'data' => new TransactionResource($salesTransaction)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment status',
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
