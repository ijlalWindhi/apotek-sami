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

        // Base query conditions
        $dateRange = [
            $startDate . ' 00:00:00',
            $endDate . ' 23:59:59'
        ];

        $productCondition = $productId ? ['product_id' => $productId] : [];

        // 1. Calculate Sales (Penjualan)
        $sales = ProductTransaction::join('m_transaction', 'm_transaction.id', '=', 'm_product_transaction.transaction_id')
            ->where('m_transaction.status', 'Terbayar')
            ->whereBetween('m_transaction.created_at', $dateRange)
            ->where($productCondition)
            ->sum(DB::raw('m_product_transaction.qty * m_product_transaction.price'));

        // 2. Calculate Tuslah Fee (Biaya Tuslah)
        $tuslahFee = ProductTransaction::join('m_transaction', 'm_transaction.id', '=', 'm_product_transaction.transaction_id')
            ->where('m_transaction.status', 'Terbayar')
            ->whereBetween('m_transaction.created_at', $dateRange)
            ->where($productCondition)
            ->sum(DB::raw('m_product_transaction.qty * m_product_transaction.tuslah'));

        // 3. Calculate Sales Discount (Diskon Penjualan)
        $salesDiscount = Transaction::where('status', 'Terbayar')
            ->whereBetween('created_at', $dateRange)
            ->when($productId, function ($query) use ($productId) {
                return $query->whereHas('productTransactions', function ($q) use ($productId) {
                    $q->where('product_id', $productId);
                });
            })
            ->sum('nominal_discount');

        // 4. Calculate Sales Returns (Retur Penjualan)
        // $salesReturns = ProductSalesReturn::join('m_sales_return', 'm_sales_return.id', '=', 'm_product_sales_return.sales_return_id')
        //     ->whereBetween('m_sales_return.created_at', $dateRange)
        //     ->where($productCondition)
        //     ->sum(DB::raw('m_product_sales_return.qty * m_product_sales_return.price'));

        // 5. Calculate Net Sales (Penjualan Bersih)
        $netSales = $sales - $salesDiscount /* - $salesReturns */;

        // 6. Calculate COGS (Harga Pokok Pembelian)
        $cogs = ProductPurchaseOrder::join('m_purchase_order', 'm_purchase_order.id', '=', 'm_product_purchase_order.purchase_order_id')
            ->where('m_purchase_order.payment_status', 'Lunas')
            ->whereBetween('m_purchase_order.order_date', $dateRange)
            ->where($productCondition)
            ->sum(DB::raw('m_product_purchase_order.qty * m_product_purchase_order.price'));

        // 7. Calculate Gross Profit (Laba Kotor)
        $grossProfit = $netSales - $cogs;

        // 8. Calculate Stock Adjustments (Penyesuaian Stock)
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
            'penjualan' => $sales,
            'diskon_penjualan' => $salesDiscount,
            // 'retur_penjualan' => $salesReturns,
            'retur_penjualan' => 0,
            'penjualan_bersih' => $netSales,
            'harga_pokok_pembelian' => $cogs,
            'laba_kotor' => $grossProfit,
            // 'penyesuaian_stock' => $stockAdjustments,
            'penyesuaian_stock' => 0,
            'keuntungan_apotek' => $pharmacyProfit,
            'tuslah' => $tuslahFee
        ];
    }
}
