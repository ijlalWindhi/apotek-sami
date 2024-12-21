<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Requests\DoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Services\DoctorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    // public function index(): View
    // {
    //     return view('pages.inventory.master.doctor', [
    //         'title' => 'Master Pajak',
    //     ]);
    // }

    public function store(DoctorRequest $request): JsonResponse
    {
        try {
            $doctor = $this->doctorService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Doctor created successfully',
                'data' => new DoctorResource($doctor)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create doctor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Doctor $doctor): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new DoctorResource($doctor)
        ]);
    }

    public function update(DoctorRequest $request, Doctor $doctor): JsonResponse
    {
        try {
            $updatedDoctor = $this->doctorService->update($doctor, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Doctor updated successfully',
                'data' => new DoctorResource($updatedDoctor)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update doctor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Doctor $doctor): JsonResponse
    {
        try {
            $this->doctorService->delete($doctor);
            return response()->json([
                'success' => true,
                'message' => 'Doctor deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete doctor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $filters = [
                'search' => $request->input('search'), // parameter pencarian
            ];

            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);

            $doctores = $this->doctorService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => DoctorResource::collection($doctores->items()),
                'meta' => [
                    'current_page' => $doctores->currentPage(),
                    'per_page' => $doctores->perPage(),
                    'total' => $doctores->total(),
                    'last_page' => $doctores->lastPage(),
                    'from' => $doctores->firstItem(),
                    'to' => $doctores->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve doctor list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
