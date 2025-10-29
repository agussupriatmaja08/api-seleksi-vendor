<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\VendorItemInterface;
use App\Http\Requests\StoreVendorItemRequest;
use App\Http\Requests\UpdateVendorItemRequest;

class VendorItemController extends Controller
{
    protected $vendorItemService;

    public function __construct(VendorItemInterface $vendorItemService)
    {
        $this->vendorItemService = $vendorItemService;
    }

    public function index()
    {
        $vendorItems = $this->vendorItemService->showVendorItems();
        return response()->json([
            'success' => $vendorItems->success,
            'message' => $vendorItems->message,
            'data' => $vendorItems->data,
        ], $vendorItems->status);
    }

    public function show($id)
    {
        $vendorItem = $this->vendorItemService->showVendorItemById($id);
        return response()->json([
            'success' => $vendorItem->success,
            'message' => $vendorItem->message,
            'data' => $vendorItem->data,
        ], $vendorItem->status);
    }

    public function store(StoreVendorItemRequest $request)
    {
        $vendorItem = $this->vendorItemService->createVendorItem($request->validated());

        return response()->json([
            'success' => $vendorItem->success,
            'message' => $vendorItem->message,
            'data' => $vendorItem->data,
        ], $vendorItem->status);

    }

    public function update(UpdateVendorItemRequest $request, $id)
    {
        $vendorItem = $this->vendorItemService->updateVendorItem($id, $request->validated());
        return response()->json([
            'success' => $vendorItem->success,
            'message' => $vendorItem->message,
            'data' => $vendorItem->data,
        ], $vendorItem->status);
    }

    public function destroy($id)
    {
        $vendorItem = $this->vendorItemService->deleteVendorItem($id);

        return response()->json([
            'success' => $vendorItem->success,
            'message' => $vendorItem->message,
            'data' => $vendorItem->data,
        ], $vendorItem->status);
    }

}
