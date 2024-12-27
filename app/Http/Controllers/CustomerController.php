<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    // public function index(): View
    // {
    //     return view('pages.inventory.master.customer', [
    //         'title' => 'Master Pajak',
    //     ]);
    // }

    public function store(CustomerRequest $request): JsonResponse
    {
        try {
            $customer = $this->customerService->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Customer created successfully',
                'data' => new CustomerResource($customer)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Customer $customer): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer)
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer): JsonResponse
    {
        try {
            $updatedCustomer = $this->customerService->update($customer, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully',
                'data' => new CustomerResource($updatedCustomer)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Customer $customer): JsonResponse
    {
        try {
            $this->customerService->delete($customer);
            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete customer',
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

            $customeres = $this->customerService->getList($filters, $page, $perPage);

            return response()->json([
                'success' => true,
                'data' => CustomerResource::collection($customeres->items()),
                'meta' => [
                    'current_page' => $customeres->currentPage(),
                    'per_page' => $customeres->perPage(),
                    'total' => $customeres->total(),
                    'last_page' => $customeres->lastPage(),
                    'from' => $customeres->firstItem(),
                    'to' => $customeres->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve customer list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
