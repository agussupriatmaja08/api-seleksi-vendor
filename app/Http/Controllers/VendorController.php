<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use Illuminate\Http\Request;
use App\Services\Contracts\VendorInterface;
use App\Http\Controllers\Response\ApiController;

/**
 * @group Vendor
 *
 * API untuk mengelola data Vendor (Pemasok).
 */
class VendorController extends ApiController
{
    protected $vendorService;
    public function __construct(VendorInterface $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    /**
     * Get Semua Vendor
     *
     * @authenticated
     * @response 200 {
     *  "success": true,
     *  "message": "Data ditemukan",
     *  "data": [
     *    {
     *      "id_vendor": 1,
     *      "kode_vendor": "VND0001",
     *      "nama_vendor": "PT ABC"
     *    }
     *  ]
     * }
     */
    public function index()
    {
        $vendors = $this->vendorService->showVendors();
        return $this->sendResponse($vendors);
    }

    /**
     * Get Detail Vendor
     *
     * @authenticated
     * @urlParam id required ID dari vendor. Example: 1
     */
    public function show($id)
    {
        $vendor = $this->vendorService->showVendorById($id);
        return $this->sendResponse($vendor);
    }

    /**
     * Buat data vendor 
     *
     * @authenticated
     * @response 201 {
     *  "success": true,
     *  "message": "Vendor berhasil dibuat",
     *  "data": {"id_vendor":2,"kode_vendor":"VND0002","name_vendor":"PT Vendor Dua"}
     * }
     */
    public function store(StoreVendorRequest $request)
    {
        $vendor = $this->vendorService->createVendor($request->validated());
        return $this->sendResponse($vendor);
    }

    /**
     * Update data vendor

     * @authenticated
     * @urlParam id required ID dari vendor. Example: 1
     * @response 200 {
     *  "success": true,
     *  "message": "Vendor berhasil diperbarui",
     *  "data": {"id_vendor":1,"kode_vendor":"VND0001","name_vendor":"PT Vendor Satu Updated"}
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Vendor tidak ditemukan"
     * }
     */
    public function update(UpdateVendorRequest $request, $id)
    {
        $vendor = $this->vendorService->updateVendor($id, $request->validated());
        return $this->sendResponse($vendor);
    }

    /**
     * Hapus data vendor
     *
     * @authenticated
     * @urlParam id required ID dari vendor. Example: 1
     * @response 200 {
     *  "success": true,
     *  "message": "Vendor berhasil dihapus",
     *  "data": null
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Vendor tidak ditemukan"
     * }
     */
    public function destroy($id)
    {
        $vendor = $this->vendorService->deleteVendor($id);
        return $this->sendResponse($vendor);
    }
}