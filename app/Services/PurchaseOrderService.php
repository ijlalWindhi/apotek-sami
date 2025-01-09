<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\ProductPurchaseOrder;
use App\Models\Product;
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
                    'qty' => $product['qty'],
                    'price' => $product['price'],
                    'discount' => $product['discount'],
                    'discount_type' => $product['discount_type'],
                    'subtotal' => $product['subtotal'],
                    'description' => $product['description'] ?? null
                ]);

                // Update stok produk
                $productModel = Product::find($product['product']);
                $productModel->stock += $product['qty'];
                $productModel->save();
            }
        }

        return $purchaseOrder;
    }

    public function update(PurchaseOrder $purchaseOrder, array $data): PurchaseOrder
    {
        $purchaseOrder->update($data);

        // Update produk jika ada
        if (isset($data['products'])) {
            // Hapus produk yang lama
            $purchaseOrder->productPurchaseOrders()->delete();

            // Buat produk baru
            foreach ($data['products'] as $product) {
                $purchaseOrder->productPurchaseOrders()->create([
                    'product' => $product['product'],
                    'qty' => $product['qty'],
                    'price' => $product['price'],
                    'discount' => $product['discount'],
                    'discount_type' => $product['discount_type'],
                    'subtotal' => $product['subtotal'],
                    'description' => $product['description'] ?? null
                ]);
            }
        }

        return $purchaseOrder->fresh(['productPurchaseOrders']);
    }

    public function delete(PurchaseOrder $purchaseOrder): bool
    {
        return $purchaseOrder->delete();
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = PurchaseOrder::query();

        // Filter berdasarkan search
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('code', 'like', '%' . $filters['search'] . '%')
                    ->orWhereHas('supplier', function ($q) use ($filters) {
                        $q->where('name', 'like', '%' . $filters['search'] . '%');
                    });
            });
        }

        // Filter berdasarkan tanggal
        if (!empty($filters['start_date'])) {
            $query->where('order_date', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $query->where('order_date', '<=', $filters['end_date']);
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        // Include relationships
        $query->with(['supplier', 'tax', 'paymentType', 'productPurchaseOrders.product']);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
