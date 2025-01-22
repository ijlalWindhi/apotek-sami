<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\ProductPurchaseOrder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PurchaseOrderService
{
    public function create(array $data): PurchaseOrder
    {
        try {
            return DB::transaction(function () use ($data) {
                $data['payment_status'] = $data['payment_term'] == "Tunai" ? "Lunas" : "Belum Terbayar";
                $purchaseOrder = PurchaseOrder::create($data);

                // Simpan produk jika ada
                if (!empty($data['products'])) {
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
                        $this->updateProductStock($product);
                    }
                }

                return $purchaseOrder;
            });
        } catch (\Exception $e) {
            Log::error('Failed to create purchase order: ' . $e->getMessage());
            throw $e;
        }
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

    private function updateProductStock(array $productData): void
    {
        $product = Product::findOrFail($productData['product']);

        if ($product->largest_unit == $productData['unit']) {
            $this->updateLargestUnitStock($product, $productData['qty']);
        } else {
            $this->updateSmallestUnitStock($product, $productData['qty']);
        }

        $product->save();
    }

    private function updateLargestUnitStock(Product $product, float $qty): void
    {
        $product->largest_stock += $qty;
        $product->smallest_stock += ($qty * $product->conversion_value);
    }

    private function updateSmallestUnitStock(Product $product, float $qty): void
    {
        $product->smallest_stock += $qty;
        $product->largest_stock += ($qty / $product->conversion_value);
    }
}
