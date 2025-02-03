<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(): View
    {
        $products = Product::all();

        return view('pages.inventory.transaction.report.index', [
            'title' => 'Laporan Transaksi',
            'products' => $products
        ]);
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $filters = [
                'product_id' => $request->input('product_id'),
                'start_date' => $request->input('start_date')
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('start_date'))->startOfDay()
                    : null,
                'end_date' => $request->input('end_date')
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('end_date'))->endOfDay()
                    : null
            ];
            $report = $this->reportService->generateReport($filters);

            return response()->json([
                'success' => true,
                'data' => $report,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve report',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
