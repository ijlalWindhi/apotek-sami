<?php

namespace App\Services;

use App\Models\Unit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UnitService
{
    public function create(array $data): Unit
    {
        return Unit::create($data);
    }

    public function update(Unit $unit, array $data): Unit
    {
        $unit->update($data);
        return $unit->fresh();
    }

    public function delete(Unit $unit): bool
    {
        return $unit->delete();
    }

    public function getList(array $filters = [], int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = Unit::query();

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
