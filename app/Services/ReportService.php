<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\ProductTransaction;
use App\Models\PurchaseOrder;
use App\Models\ProductPurchaseOrder;
use App\Models\SalesReturn;
use App\Models\ProductSalesReturn;
use App\Models\StockAdjustment;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function generateReport(array $filters)
    {
        $startDate = $filters['start_date'];
        $endDate = $filters['end_date'];
        $productId = $filters['product_id'] ?? null;

        if ($productId === 'Semua') {
            $productId = null;
        }

        // Base query conditions
        $dateRange = [
            $startDate,
            $endDate
        ];

        $productCondition = [];
        if ($productId) {
            $productCondition = ['m_product_transaction.product_id' => $productId];
        }

        // 1. Calculate Sales (Penjualan + Tuslah)
        $sales = ProductTransaction::join('m_transaction', 'm_transaction.id', '=', 'm_product_transaction.transaction_id')
            ->where('m_transaction.status', 'Terbayar')
            ->whereBetween('m_transaction.created_at', $dateRange)
            ->where($productCondition)
            ->select(DB::raw('
        SUM(m_product_transaction.qty * m_product_transaction.price) as total_sales,
        SUM(m_product_transaction.qty * m_product_transaction.tuslah) as total_tuslah
    '))
            ->first();
        $totalSales = $sales->total_sales ?? 0;
        $totalTuslah = $sales->total_tuslah ?? 0;

        // 2. Calculate Sales Discount (Diskon Penjualan)
        $salesDiscount = Transaction::where('status', 'Terbayar')
            ->whereBetween('created_at', $dateRange)
            ->when($productId, function ($query) use ($productId) {
                return $query->whereHas('productTransactions', function ($q) use ($productId) {
                    $q->where('product_id', $productId);
                });
            })
            ->sum('nominal_discount');

        // 3. Calculate Sales Returns (Retur Penjualan)
        // $salesReturns = ProductSalesReturn::join('m_sales_return', 'm_sales_return.id', '=', 'm_product_sales_return.sales_return_id')
        //     ->whereBetween('m_sales_return.created_at', $dateRange)
        //     ->where($productCondition)
        //     ->sum(DB::raw('m_product_sales_return.qty * m_product_sales_return.price'));

        // 4. Calculate Net Sales (Penjualan Bersih)
        $netSales = ($totalSales + $totalTuslah) - $salesDiscount;

        // 5. Calculate COGS (Harga Pokok Pembelian)
        $cogs = ProductTransaction::join('m_transaction', 'm_transaction.id', '=', 'm_product_transaction.transaction_id')
            ->join('m_product', 'm_product.id', '=', 'm_product_transaction.product_id')
            ->where('m_transaction.status', 'Terbayar')
            ->whereBetween('m_transaction.created_at', $dateRange)
            ->where($productCondition)
            ->select(DB::raw('
                SUM(
                    CASE 
                        WHEN m_product_transaction.unit_id = m_product.smallest_unit 
                        THEN (m_product_transaction.qty * m_product.purchase_price / m_product.conversion_value)
                        ELSE (m_product_transaction.qty * m_product.purchase_price)
                    END
                ) as total_cogs
            '))
            ->first();
        $totalCogs = $cogs->total_cogs ?? 0;

        // 6. Calculate Gross Profit (Laba Kotor)
        $grossProfit = $netSales - $totalCogs;

        // 7. Calculate Stock Adjustments (Penyesuaian Stock)
        // $stockAdjustments = StockAdjustment::whereBetween('created_at', $dateRange)
        //     ->where($productCondition)
        //     ->get()
        //     ->reduce(function ($carry, $adjustment) {
        //         $value = $adjustment->qty * $adjustment->product->purchase_price;
        //         return $carry + ($adjustment->type === 'Addition' ? $value : -$value);
        //     }, 0);

        // 9. Calculate Pharmacy Profit (Keuntungan Apotek)
        $pharmacyProfit = $grossProfit /* + $stockAdjustments */;

        return [
            'penjualan' => round($totalSales, 2),
            'tuslah' => round($totalTuslah, 2),
            'diskon_penjualan' => round($salesDiscount, 2),
            // 'retur_penjualan' => round($salesReturns, 2),
            'retur_penjualan' => 0,
            'penjualan_bersih' => round($netSales, 2),
            'harga_pokok_pembelian' => round($totalCogs, 2),
            'laba_kotor' => round($grossProfit, 2),
            // 'penyesuaian_stock' => round($stockAdjustments, 2),
            'penyesuaian_stock' => 0,
            'keuntungan_apotek' => round($pharmacyProfit, 2),
        ];
    }
}
