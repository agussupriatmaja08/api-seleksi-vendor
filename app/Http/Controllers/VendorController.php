<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use Illuminate\Http\Request;
use App\Services\Contracts\VendorInterface;

class VendorController extends Controller
{
    //
    protected $vendorService;
    public function __construct(VendorInterface $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function index()
    {
        $vendors = $this->vendorService->showVendors();
        return response()->json([
            'success' => $vendors->success,
            'message' => $vendors->message,
            'data' => $vendors->data,
        ], $vendors->status);
    }
    public function show($id)
    {
        $vendor = $this->vendorService->showVendorById($id);
        return response()->json([
            'success' => $vendor->success,
            'message' => $vendor->message,
            'data' => $vendor->data,
        ], $vendor->status);
    }
    public function store(StoreVendorRequest $request)
    {
        $vendor = $this->vendorService->createVendor($request->validated());
        return response()->json([
            'success' => $vendor->success,
            'message' => $vendor->message,
            'data' => $vendor->data,
        ], $vendor->status);
    }
    public function update(UpdateVendorRequest $request, $id)
    {
        $vendor = $this->vendorService->updateVendor($id, $request->validated());
        return response()->json([
            'success' => $vendor->success,
            'message' => $vendor->message,
            'data' => $vendor->data,
        ], $vendor->status);
    }
    public function destroy($id)
    {
        $vendor = $this->vendorService->deleteVendor($id);
        return response()->json([
            'success' => $vendor->success,
            'message' => $vendor->message,
            'data' => $vendor->data,
        ], $vendor->status);
    }

}
