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
 * API untuk mengelola data master Vendor (Pemasok).
 */
class VendorController extends ApiController
{
    //
    protected $vendorService;
    public function __construct(VendorInterface $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    /**
     * Menampilkan semua data vendor
     * * Mengambil daftar semua vendor (pemasok) yang terdaftar.
     *
     * @authenticated
     * @response 200 {
     *  "success": true,
     *  "message": "Daftar vendor berhasil diambil",
     *  "data": [
     *    {"id_vendor":1,"kode_vendor":"VND0001","name_vendor":"PT Vendor Satu","created_at":"2025-10-30T00:00:00.000000Z","updated_at":"2025-10-30T00:00:00.000000Z"}
     *  ]
     * }
     */
    public function index()
    {
        $vendors = $this->vendorService->showVendors();
        return $this->sendResponse($vendors);
    }

    /**
     * Menampilkan detail vendor
     * * Mengambil data satu vendor berdasarkan ID.
     *
     * @authenticated
     * @urlParam id required ID dari vendor. Example: 1
     * @response 200 {
     *  "success": true,
     *  "message": "Detail vendor diperoleh",
     *  "data": {"id_vendor":1,"kode_vendor":"VND0001","name_vendor":"PT Vendor Satu"}
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Vendor tidak ditemukan"
     * }
     */
    public function show($id)
    {
        $vendor = $this->vendorService->showVendorById($id);
        return $this->sendResponse($vendor);
    }

    /**
     * Membuat data vendor baru
     * * Menyimpan data vendor (pemasok) baru.
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
     * Memperbarui data vendor
     * * Memperbarui data vendor yang ada berdasarkan ID.
     *
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
     * Menghapus data vendor
     * * Menghapus data vendor berdasarkan ID.
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