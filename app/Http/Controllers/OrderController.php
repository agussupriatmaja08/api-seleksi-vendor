<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\OrderInterface;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Controllers\Response\ApiController;


/**
 * @group Order
 *
 * API untuk mengelola data Order (Transaksi Pemesanan).
 */
class OrderController extends ApiController
{
    //
    protected $orderService;
    public function __construct(OrderInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Get Semua Order
     *
     * @authenticated
     * @response 200 {
     * "success": true,
     * "message": "Data ditemukan",
     * "data": [
     * {
     * "id_order": 1,
     * "tgl_order": "2025-10-30",
     * "no_order": "ORD0001",
     * "id_vendor": 1,
     * "id_item": 1
     * }
     * ]
     * }
     */
    public function index()
    {
        $orders = $this->orderService->showOrders();

        return $this->sendResponse($orders);
    }

    /**
     * Get Detail Order
     *
     * @authenticated
     * @urlParam id required ID dari order. Example: 1
     */
    public function show($id)
    {
        $order = $this->orderService->showOrderById($id);
        return $this->sendResponse($order);
    }

    /**
     * Buat Order Baru
     *
     * @authenticated
     * @response 201 {
     * "success": true,
     * "message": "Order berhasil dibuat",
     * "data": {
     * "id_order": 1,
     * "tgl_order": "2025-10-30",
     * "no_order": "ORD0001",
     * "id_vendor": 1,
     * "id_item": 1
     * }
     * }
     * @response 422 {
     * "message": "The tgl_order field must match the format Y-m-d.",
     * "errors": {
     * "tgl_order": ["The tgl_order field must match the format Y-m-d."]
     * }
     * }
     */
    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->createOrder($request->validated());
        return $this->sendResponse($order);

    }

    /**
     * Update Order
     *
     * @authenticated
     * @urlParam id required ID dari order. Example: 1
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $order = $this->orderService->updateOrder($id, $request->validated());
        return $this->sendResponse($order);

    }

    /**
     * Hapus Order
     *
     * @authenticated
     * @urlParam id required ID dari order. Example: 1
     */
    public function destroy($id)
    {
        $order = $this->orderService->deleteOrder($id);
        return $this->sendResponse($order);

    }
}
