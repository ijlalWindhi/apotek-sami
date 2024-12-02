<?php

namespace App\Services;

use App\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorService
{
    public function create(array $data): Doctor
    {
        return Doctor::create($data);
    }

    public function update(Doctor $tax, array $data): Doctor
    {
        $tax->update($data);
        return $tax->fresh();
    }

    public function delete(Doctor $tax): bool
    {
        return $tax->delete();
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = Doctor::query();

        // Filter berdasarkan nama
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone_number', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('sip_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
