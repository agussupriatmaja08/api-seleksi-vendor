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
 * API untuk mengelola relasi dan harga item per vendor.
 * (Mengelola tabel 'vendor_items')
 */
class VendorItemController extends ApiController
{
    protected $vendorItemService;

    public function __construct(VendorItemInterface $vendorItemService)
    {
        $this->vendorItemService = $vendorItemService;
    }

    /**
     * Menampilkan semua relasi harga vendor-item
     * * Mengambil daftar semua penawaran item dan harganya.
     *
     * @authenticated
     * @response 200 {
     *  "success": true,
     *  "message": "Daftar vendor item berhasil diambil",
     *  "data": [
     *    {"id":1,"item_id":1,"id_vendor":1,"harga_sebelum":"10000.00","harga_sekarang":"9000.00"}
     *  ]
     * }
     */
    public function index()
    {
        $vendorItems = $this->vendorItemService->showVendorItems();
        return $this->sendResponse($vendorItems);

    }

    /**
     * Menampilkan detail relasi harga
     * * Mengambil detail satu penawaran (harga) berdasarkan ID relasi.
     *
     * @authenticated
     * @urlParam id required ID dari relasi vendor-item. Example: 1
     * @response 200 {
     *  "success": true,
     *  "message": "Detail vendor item diperoleh",
     *  "data": {"id":1,"item_id":1,"id_vendor":1,"harga_sebelum":"10000.00","harga_sekarang":"9000.00"}
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Relasi vendor-item tidak ditemukan"
     * }
     */
    public function show($id)
    {
        $vendorItem = $this->vendorItemService->showVendorItemById($id);
        return $this->sendResponse($vendorItem);

    }

    /**
     * Membuat relasi harga vendor-item baru
     * * Mendaftarkan item ke vendor beserta harga awalnya.
     *
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
     * Memperbarui relasi harga vendor-item
     * * Endpoint kunci untuk memperbarui harga (harga_sebelum & harga_sekarang).
     *
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
     * Menghapus relasi harga vendor-item
     * * Menghapus penawaran item dari vendor.
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