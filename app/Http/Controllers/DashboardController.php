<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function getTotalSales(Request $request): JsonResponse
    {
        try {
            $period = $request->input('period', 'daily');
            $data = $this->dashboardService->getTotalSales($period);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve total sales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDuePurchaseOrders(): JsonResponse
    {
        try {
            $data = $this->dashboardService->getDuePurchaseOrders();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve due purchase orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getLowStockItems(): JsonResponse
    {
        try {
            $data = $this->dashboardService->getLowStockItems();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve low stock items',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getSupplierBillingSummary(): JsonResponse
    {
        try {
            $billingData = $this->dashboardService->getSupplierBillingSummary();

            return response()->json([
                'success' => true,
                'data' => $billingData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve supplier billing summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductSalesSummary(Request $request): JsonResponse
    {
        try {
            $period = $request->input('period', 'daily');
            $data = $this->dashboardService->getProductSalesSummary($period);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product sales summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
