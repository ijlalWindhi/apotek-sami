<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\PurchaseOrder;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getTotalSales(string $period = 'daily'): array
    {
        $startDate = Carbon::now();
        $endDate = $startDate->copy();

        if ($period === 'weekly') {
            $startDate = $startDate->startOfWeek();
            $endDate = $startDate->copy()->endOfWeek();
        }

        // Get current period sales
        $currentSales = Transaction::whereBetween('created_at', [
            $startDate->startOfDay(),
            $endDate->endOfDay()
        ])
            ->where('status', 'Terbayar')
            ->sum('total_amount');

        // Get previous period dates
        if ($period === 'weekly') {
            $previousStartDate = $startDate->copy()->subWeek()->startOfWeek();
            $previousEndDate = $previousStartDate->copy()->endOfWeek();
        } else {
            $previousStartDate = $startDate->copy()->subDay()->startOfDay();
            $previousEndDate = $previousStartDate->copy()->endOfDay();
        }

        // Get previous period sales
        $previousSales = Transaction::whereBetween('created_at', [
            $previousStartDate,
            $previousEndDate
        ])
            ->where('status', 'Terbayar')
            ->sum('total_amount');

        // Calculate percentage change
        $percentageChange = 0;
        if ($previousSales > 0) {
            $percentageChange = (($currentSales - $previousSales) / $previousSales) * 100;
        }

        return [
            'nominal' => $currentSales,
            'percentage' => round($percentageChange, 2) . '%',
            'status' => $percentageChange >= 0 ? 'profit' : 'lost',
            'range' => $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y')
        ];
    }

    public function getDuePurchaseOrders(): array
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays(7);

        return PurchaseOrder::where('payment_status', 'Belum Terbayar')
            ->whereBetween('payment_due_date', [$startDate, $endDate])
            ->select([
                'id',
                'code',
                'payment_due_date',
                'total',
                'supplier_id'
            ])
            ->with('supplier:id,name')
            ->get()
            ->toArray();
    }

    public function getLowStockItems(): array
    {
        return Product::where('is_active', true)
            ->whereRaw('smallest_stock <= minimum_smallest_stock')
            ->select([
                'id',
                'name',
                'sku',
                'minimum_smallest_stock',
                'smallest_stock',
                'supplier_id'
            ])
            ->with('supplier:id,name')
            ->get()
            ->toArray();
    }

    public function getSupplierBillingSummary()
    {
        return PurchaseOrder::select(
            'supplier_id',
            DB::raw('SUM(total) as total_billing'),
            DB::raw('COUNT(*) as total_invoices')
        )
            ->where('payment_status', 'Belum Terbayar')
            ->groupBy('supplier_id')
            ->with('supplier:id,name,code')
            ->orderByDesc('total_billing')
            ->get()
            ->map(function ($item) {
                return [
                    'supplier_id' => $item->supplier_id,
                    'supplier_name' => $item->supplier->name,
                    'supplier_code' => $item->supplier->code,
                    'total_billing' => $item->total_billing,
                    'total_invoices' => $item->total_invoices
                ];
            });
    }
}
