<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupplierService
{
    private function generateCode(): string
    {
        $prefix = 'SPLR-';

        // Get the last supplier with the SPLR- prefix
        $lastSupplier = Supplier::where('code', 'like', $prefix . '%')
            ->orderBy('code', 'desc')
            ->first();

        if (!$lastSupplier) {
            // If no supplier exists yet, start with 0001
            return $prefix . '0001';
        }

        // Extract the number from the last code
        $lastNumber = intval(str_replace($prefix, '', $lastSupplier->code));

        // Increment and pad with zeros
        $newNumber = $lastNumber + 1;
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function create(array $data): Supplier
    {
        $data['code'] = $this->generateCode();
        return Supplier::create($data);
    }

    public function update(Supplier $product, array $data): Supplier
    {
        $product->update($data);
        return $product->fresh();
    }

    public function delete(Supplier $product): bool
    {
        return $product->delete();
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = Supplier::query();

        // Filter berdasarkan nama
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone_1', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone_2', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('code', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
