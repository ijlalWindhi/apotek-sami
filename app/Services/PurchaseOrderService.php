<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PurchaseOrderService
{
    public function create(array $data): PurchaseOrder
    {
        $data = $this->calculateTotals($data);
        
        $purchaseOrder = PurchaseOrder::create($data);

        // Simpan produk jika ada
        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                $purchaseOrder->productPurchaseOrders()->create([
                    'product' => $product['product'],
                    'qty' => $product['qty'],
                    'price' => $product['price'],
                    'discount' => $product['discount'],
                    'discount_type' => $product['discount_type'],
                    'tax' => $product['tax'],
                    'subtotal' => $this->calculateSubtotal($product),
                    'description' => $product['description'] ?? null
                ]);
            }
        }

        return $purchaseOrder;
    }

    public function update(PurchaseOrder $purchaseOrder, array $data): PurchaseOrder
    {
        $data = $this->calculateTotals($data);
        
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
                    'tax' => $product['tax'],
                    'subtotal' => $this->calculateSubtotal($product),
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

        // Filter berdasarkan status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
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
        $query->with(['supplier', 'tax', 'paymentType']);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    private function calculateSubtotal(array $product): float
    {
        $baseSubtotal = $product['price'] * $product['qty'];
        
        // Hitung diskon
        if ($product['discount_type'] === 'Percentage') {
            $discount = $baseSubtotal * ($product['discount'] / 100);
        } else {
            $discount = $product['discount'] * $product['qty'];
        }
        
        return $baseSubtotal - $discount;
    }

    private function calculateDiscount(array $product): float
    {
        $baseSubtotal = $product['price'] * $product['qty'];
        
        if ($product['discount_type'] === 'Percentage') {
            return $baseSubtotal * ($product['discount'] / 100);
        } else {
            return $product['discount'] * $product['qty'];
        }
    }

    private function calculateTotals(array $data): array
    {
        $qtyTotal = 0;
        $totalBeforeTaxDiscount = 0;
        $discountTotal = 0;
        $taxTotal = 0;

        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                $qtyTotal += $product['qty'];
                $baseSubtotal = $product['price'] * $product['qty'];
                $itemDiscount = $this->calculateDiscount($product);
                $subtotalAfterDiscount = $baseSubtotal - $itemDiscount;
                
                $discountTotal += $itemDiscount;
                $totalBeforeTaxDiscount += $baseSubtotal;
                $taxTotal += $subtotalAfterDiscount * ($product['tax'] / 100);
            }
        }

        $data['qty_total'] = $qtyTotal;
        $data['total_before_tax_discount'] = $totalBeforeTaxDiscount;
        $data['tax_total'] = $taxTotal;
        $data['discount_total'] = $discountTotal;
        $data['total'] = $totalBeforeTaxDiscount - $discountTotal + $taxTotal;

        return $data;
    }
}