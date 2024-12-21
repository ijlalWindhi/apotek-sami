<?php

namespace App\Services;

use App\Models\PaymentType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaymentTypeService
{
    public function create(array $data): PaymentType
    {
        return PaymentType::create($data);
    }

    public function update(PaymentType $paymentType, array $data): PaymentType
    {
        $paymentType->update($data);
        return $paymentType->fresh();
    }

    public function delete(PaymentType $paymentType): bool
    {
        return $paymentType->delete();
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = PaymentType::query();

        // Filter berdasarkan nama
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%'); // tambahkan kolom lain jika perlu
            });
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
