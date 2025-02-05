<?php

namespace App\Services;

use App\Models\ProductTransaction;
use App\Models\Retur;
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
        $dateRange = [$startDate, $endDate];
        $productCondition = $productId ? ['product_id' => $productId] : [];

        // 1. Calculate Sales (Penjualan + Tuslah)
        $sales = $this->calculateSales($dateRange, $productCondition);
        $totalSales = $sales->total_sales ?? 0;
        $totalTuslah = $sales->total_tuslah ?? 0;

        // 2. Calculate Sales Discount (Diskon Penjualan)
        $discount = $this->calculateSalesDiscount($dateRange, $productCondition);
        $salesDiscount = $discount->total_sales_discount ?? 0;

        // 3. Calculate Sales Returns (Retur Penjualan)
        $salesReturns = $this->calculateSalesReturns($dateRange, $productId);
        $totalReturns = $salesReturns->total_return ?? 0;

        // 4. Calculate Net Sales (Penjualan Bersih)
        // Net Sales = (Total Sales + Tuslah) - (Sales Discount + Returns)
        $netSales = ($totalSales + $totalTuslah) - ($salesDiscount + $totalReturns);

        // 5. Calculate COGS (Harga Pokok Pembelian)
        $cogs = $this->calculateCOGS($dateRange, $productCondition);
        $totalCogs = $cogs->total_cogs ?? 0;

        // 6. Calculate COGS for Returns
        $cogsReturns = $this->calculateCOGSReturns($dateRange, $productCondition);
        $totalCogsReturns = $cogsReturns->total_cogs_returns ?? 0;

        // 7. Calculate Final COGS
        $finalCogs = $totalCogs - $totalCogsReturns;

        // 8. Calculate Gross Profit (Laba Kotor)
        $grossProfit = $netSales - $finalCogs;

        return [
            'penjualan' => round($totalSales, 2),
            'tuslah' => round($totalTuslah, 2),
            'diskon_penjualan' => round($salesDiscount, 2),
            'retur_penjualan' => round($totalReturns, 2),
            'penjualan_bersih' => round($netSales, 2),
            'harga_pokok_pembelian' => round($finalCogs, 2),
            'laba_kotor' => round($grossProfit, 2),
            'keuntungan_apotek' => round($grossProfit, 2),
        ];
    }

    private function calculateSales(array $dateRange, array $productCondition)
    {
        return ProductTransaction::join('m_transaction', 'm_transaction.id', '=', 'm_product_transaction.transaction_id')
            ->whereIn('m_transaction.status', ['Terbayar', 'Retur'])
            ->whereBetween('m_transaction.created_at', $dateRange)
            ->where($productCondition)
            ->select(DB::raw('
                SUM(m_product_transaction.qty * m_product_transaction.price) as total_sales,
                SUM(m_product_transaction.qty * m_product_transaction.tuslah) as total_tuslah
            '))
            ->first();
    }

    private function calculateSalesDiscount(array $dateRange, array $productCondition)
    {
        return ProductTransaction::join('m_transaction', 'm_transaction.id', '=', 'm_product_transaction.transaction_id')
            ->whereIn('m_transaction.status', ['Terbayar', 'Retur'])
            ->whereBetween('m_transaction.created_at', $dateRange)
            ->where($productCondition)
            ->select(DB::raw('COALESCE(SUM(m_product_transaction.nominal_discount), 0) as total_sales_discount'))
            ->first();
    }

    private function calculateSalesReturns(array $dateRange, ?string $productId)
    {
        return Retur::join('m_product_return', 'm_return.id', '=', 'm_product_return.return_id')
            ->join('m_transaction', 'm_transaction.id', '=', 'm_return.transaction_id')
            ->when($productId, function ($query) use ($productId) {
                return $query->where('m_product_return.product_id', $productId);
            })
            ->whereBetween('m_return.created_at', $dateRange)
            ->select(DB::raw('SUM(m_product_return.subtotal_return) as total_return'))
            ->first();
    }

    private function calculateCOGS(array $dateRange, array $productCondition)
    {
        return ProductTransaction::join('m_transaction', 'm_transaction.id', '=', 'm_product_transaction.transaction_id')
            ->join('m_product', 'm_product.id', '=', 'm_product_transaction.product_id')
            ->where('m_transaction.status', ['Terbayar', 'Retur'])
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
    }

    private function calculateCOGSReturns(array $dateRange, array $productCondition)
    {
        return Retur::join('m_product_return', 'm_return.id', '=', 'm_product_return.return_id')
            ->join('m_product', 'm_product.id', '=', 'm_product_return.product_id')
            ->whereBetween('m_return.created_at', $dateRange)
            ->where($productCondition)
            ->select(DB::raw('
                SUM(
                    CASE 
                        WHEN m_product_return.unit_id = m_product.smallest_unit 
                        THEN (m_product_return.qty_return * m_product.purchase_price / m_product.conversion_value)
                        ELSE (m_product_return.qty_return * m_product.purchase_price)
                    END
                ) as total_cogs_returns
            '))
            ->first();
    }
}
