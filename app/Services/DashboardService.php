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

    public function getProductSalesSummary(string $period = 'daily'): array
    {
        $startDate = Carbon::now();
        $endDate = $startDate->copy();

        // Adjust date range based on period
        switch ($period) {
            case 'weekly':
                $startDate = $startDate->startOfWeek();
                $endDate = $startDate->copy()->endOfWeek();
                break;
            case 'monthly':
                $startDate = $startDate->startOfMonth();
                $endDate = $startDate->copy()->endOfMonth();
                break;
            default:
                $startDate = $startDate->startOfDay();
                $endDate = $startDate->copy()->endOfDay();
                break;
        }

        // Get product sales with conversion to smallest unit
        $productSales = Transaction::join('m_product_transaction', 'm_transaction.id', '=', 'm_product_transaction.transaction_id')
            ->join('m_product', 'm_product_transaction.product_id', '=', 'm_product.id')
            ->join('m_unit as smallest_unit', 'm_product.smallest_unit', '=', 'smallest_unit.id')
            ->whereBetween('m_transaction.created_at', [$startDate, $endDate])
            ->where('m_transaction.status', 'Terbayar')
            ->select(
                'm_product.id',
                'm_product.name',
                'm_product.sku',
                'm_product.conversion_value',
                'm_product.drug_group',
                'm_product.largest_unit',
                'm_product.smallest_unit',
                'smallest_unit.symbol as smallest_unit_name',
                DB::raw('SUM(m_product_transaction.qty *
                    CASE
                        WHEN m_product_transaction.unit_id = m_product.largest_unit
                        THEN m_product.conversion_value
                        ELSE 1
                    END
                ) as total_qty_sold'),
                DB::raw('SUM(m_product_transaction.subtotal) as total_sales')
            )
            ->groupBy(
                'm_product.id',
                'm_product.name',
                'm_product.sku',
                'm_product.conversion_value',
                'm_product.drug_group',
                'm_product.largest_unit',
                'm_product.smallest_unit',
                'smallest_unit.name'
            )
            ->orderByDesc('total_qty_sold')
            ->get()
            ->map(function ($item) {
                return [
                    'product_id' => $item->id,
                    'name' => $item->name,
                    'sku' => $item->sku,
                    'drug_group' => $item->drug_group,
                    'smallest_unit' => $item->smallest_unit_name,
                    'total_qty_sold' => $item->total_qty_sold,
                    'total_sales' => $item->total_sales
                ];
            });

        return [
            'products' => $productSales,
            'range' => $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y')
        ];
    }
}
