<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\VendorItemInterface;
use App\Http\Requests\StoreVendorItemRequest;
use App\Http\Requests\UpdateVendorItemRequest;
use App\Http\Controllers\Response\ApiController;


/**
 * @group VendorItem
 *
 * API untuk mengelola harga item per vendor.
 */
class VendorItemController extends ApiController
{
    protected $vendorItemService;

    public function __construct(VendorItemInterface $vendorItemService)
    {
        $this->vendorItemService = $vendorItemService;
    }

    /**
     * Get Semua Item Vendor
     *
     * @authenticated
     * @response 200 {
     *  "success": true,
     *  "message": "Data ditemukan",
     *  "data": [
     *    {
     *      "id": 1,
     *      "id_vendor": 1,
     *      "id_item": 1,
     *      "harga_sebelum": "10000.00",
     *      "harga_sekarang": "9000.00"
     *    }
     *  ]
     * }
     */
    public function index()
    {
        $vendorItems = $this->vendorItemService->showVendorItems();
        return $this->sendResponse($vendorItems);

    }

    /**
     * Get Detail Item Vendor
     *
     * @authenticated
     * @urlParam id required ID dari harga item. Example: 1
     */
    public function show($id)
    {
        $vendorItem = $this->vendorItemService->showVendorItemById($id);
        return $this->sendResponse($vendorItem);

    }

    /**
     * Buat Item Vendor
     * @authenticated
     * @response 201 {
     *  "success": true,
     *  "message": "Vendor item berhasil dibuat",
     *  "data": {"id":2,"item_id":1,"id_vendor":2,"harga_sebelum":"12000.00","harga_sekarang":"11000.00"}
     * }
     * @response 422 {
     *  "success": false,
     *  "message": "Data validasi tidak valid.",
     *  "errors": {"harga_sekarang":["The harga_sekarang must be a number."]}
     * }
     */
    public function store(StoreVendorItemRequest $request)
    {
        $vendorItem = $this->vendorItemService->createVendorItem($request->validated());
        return $this->sendResponse($vendorItem);

    }

    /**
     * Update Vendor Item
     * @authenticated
     * @urlParam id required ID dari relasi vendor-item. Example: 1
     * @response 200 {
     *  "success": true,
     *  "message": "Harga vendor item berhasil diperbarui",
     *  "data": {"id":1,"item_id":1,"id_vendor":1,"harga_sebelum":"15000.00","harga_sekarang":"14000.00"}
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Relasi vendor-item tidak ditemukan"
     * }
     */
    public function update(UpdateVendorItemRequest $request, $id)
    {
        $vendorItem = $this->vendorItemService->updateVendorItem($id, $request->validated());
        return $this->sendResponse($vendorItem);

    }

    /**
     * Hapus Vendor Item
     *
     * @authenticated
     * @urlParam id required ID dari relasi vendor-item. Example: 1
     * @response 200 {
     *  "success": true,
     *  "message": "Vendor item berhasil dihapus",
     *  "data": null
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Relasi vendor-item tidak ditemukan"
     * }
     */
    public function destroy($id)
    {
        $vendorItem = $this->vendorItemService->deleteVendorItem($id);
        return $this->sendResponse($vendorItem);

    }
}