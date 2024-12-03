<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function update(Customer $tax, array $data): Customer
    {
        $tax->update($data);
        return $tax->fresh();
    }

    public function delete(Customer $tax): bool
    {
        return $tax->delete();
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = Customer::query();

        // Filter berdasarkan nama
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone_number', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
