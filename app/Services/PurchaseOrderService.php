<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\ProductPurchaseOrder;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PurchaseOrderService
{
    public function create(array $data): PurchaseOrder
    {
        $purchaseOrder = PurchaseOrder::create($data);

        // Simpan produk jika ada
        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                ProductPurchaseOrder::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $product['product'],
                    'unit_id' => $product['unit'],
                    'qty' => $product['qty'],
                    'price' => $product['price'],
                    'discount' => $product['discount'],
                    'discount_type' => $product['discount_type'],
                    'subtotal' => $product['subtotal'],
                ]);

                // Update stok produk
                $productModel = Product::find($product['product']);
                if ($productModel->largest_unit == $product['unit']) {
                    $productModel->largest_stock += $product['qty'];
                    $productModel->smallest_stock += ($product['qty'] * $productModel->conversion_value);
                } else {
                    $productModel->smallest_stock += $product['qty'];
                    $productModel->largest_stock += ($product['qty'] / $productModel->conversion_value);
                }
                $productModel->save();
            }
        }

        return $purchaseOrder;
    }

    public function updatePaymentStatus(PurchaseOrder $purchaseOrder): PurchaseOrder
    {
        $purchaseOrder->payment_status = "Lunas";
        $purchaseOrder->save();

        return $purchaseOrder;
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = PurchaseOrder::query();

        // Filter berdasarkan search
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('code', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('no_factur_supplier', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Filter berdasarkan tanggal
        if (!empty($filters['date']) && $filters['date'] instanceof \Carbon\Carbon) {
            $dateString = $filters['date']->format('Y-m-d');
            $query->where(function ($q) use ($dateString) {
                $q->whereDate('order_date', '=', $dateString)
                    ->orWhereDate('payment_due_date', '=', $dateString);
            });
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        // Include relationships
        $query->with(['supplier', 'tax', 'paymentType', 'productPurchaseOrders.product', 'productPurchaseOrders.unit']);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
