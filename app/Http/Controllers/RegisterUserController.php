<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\RegisterUserResource;
use App\Services\RegisterUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterUserController extends Controller
{
    protected $registerUserService;

    public function __construct(RegisterUserService $registerUserService)
    {
        $this->registerUserService = $registerUserService;
    }

    public function index(): View
    {
        return view('pages.inventory.pharmacy.employee', [
            'title' => 'Pegawai',
        ]);
    }

    public function store(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = $this->registerUserService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => new RegisterUserResource($user)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(RegisterUserRequest $request, User $user): JsonResponse
    {
        try {
            $updatedUser = $this->registerUserService->update($user, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => new RegisterUserResource($updatedUser)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $this->registerUserService->delete($user);
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
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

            $taxes = $this->registerUserService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => RegisterUserResource::collection($taxes->items()),
                'meta' => [
                    'current_page' => $taxes->currentPage(),
                    'per_page' => $taxes->perPage(),
                    'total' => $taxes->total(),
                    'last_page' => $taxes->lastPage(),
                    'from' => $taxes->firstItem(),
                    'to' => $taxes->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tax list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
