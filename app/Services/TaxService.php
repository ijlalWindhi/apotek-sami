<?php

namespace App\Services;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaxService
{
    public function create(array $data): Tax
    {
        return Tax::create($data);
    }

    public function update(Tax $tax, array $data): Tax
    {
        $tax->update($data);
        return $tax->fresh();
    }

    public function delete(Tax $tax): bool
    {
        return $tax->delete();
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = Tax::query();

        // Filter berdasarkan nama
        if (!empty($filters['name'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['name'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['name'] . '%'); // tambahkan kolom lain jika perlu
            });
        }

        // Tambahkan pengurutan default
        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
