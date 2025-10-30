<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\Contracts\ItemInterface;
use App\Http\Controllers\Response\ApiController;


/**
 * @group Item
 *
 * API untuk mengelola data Item (Produk).
 */
class ItemController extends ApiController
{
    protected $itemService;
    public function __construct(ItemInterface $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * Get Semua Item
     *
     * @authenticated
     * @response 200 {
     *  "success": true,
     *  "message": "Data ditemukan",
     *  "data": [
     *    {
     *      "id_item": 1,
     *      "kode_item": "ITM0001",
     *      "nama_item": "Buku Tulis"
     *    }
     *  ]
     * }
     */
    public function index()
    {
        $items = $this->itemService->showItems();
        return $this->sendResponse($items);
    }

    /**
     * Get Detail Item
     *
     * @authenticated
     * @urlParam id required ID dari item. Example: 1
     */
    public function show($id)
    {
        $item = $this->itemService->showItemById($id);
        return $this->sendResponse($item);
    }

    /**
     * Buat data item 
     *
     * @authenticated
     * @response 201 {
     *  "success": true,
     *  "message": "Item berhasil dibuat",
     *  "data": {"id_item":2,"kode_item":"ITM0002","name_item":"Produk B"}
     * }
     * @response 422 {
     *  "success": false,
     *  "message": "Data validasi tidak valid.",
     *  "errors": {"kode_item":["The kode_item field is required."]}
     * }
     */
    public function store(StoreItemRequest $request)
    {
        $item = $this->itemService->createItem($request->validated());
        return $this->sendResponse($item);
    }

    /**
     * Update data item
     *
     * @authenticated
     * @urlParam id required ID dari item. Example: 1
     * @response 200 {
     *  "success": true,
     *  "message": "Item berhasil diperbarui",
     *  "data": {"id_item":1,"kode_item":"ITM0001","name_item":"Produk A Update"}
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Item tidak ditemukan"
     * }
     */
    public function update(UpdateItemRequest $request, $id)
    {
        $item = $this->itemService->updateItem($id, $request->validated());
        return $this->sendResponse($item);
    }

    /**
     * Hapus data item
     *
     * @authenticated
     * @urlParam id required ID dari item. Example: 1
     * @response 200 {
     *  "success": true,
     *  "message": "Item berhasil dihapus",
     *  "data": null
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Item tidak ditemukan"
     * }
     */
    public function destroy($id)
    {
        $item = $this->itemService->deleteItem($id);
        return $this->sendResponse($item);
    }
}