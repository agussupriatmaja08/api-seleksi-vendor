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
     * Menampilkan semua data order
     * * Mengambil daftar semua transaksi order yang terdaftar.
     *
     * @authenticated
     */
    public function index()
    {
        $orders = $this->orderService->showOrders();

        return $this->sendResponse($orders);
    }

    /**
     * Menampilkan detail order
     * * Mengambil data satu order berdasarkan ID.
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
     * Membuat data order baru
     * * Menyimpan transaksi order baru.
     * * (Validasi `id_item` vs `id_vendor` ditangani di `StoreOrderRequest`).
     *
     * @authenticated
     */
    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->createOrder($request->validated());
        return $this->sendResponse($order);

    }

    /**
     * Memperbarui data order
     * * Memperbarui data order yang ada berdasarkan ID.
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
     * Menghapus data order
     * * Menghapus data order berdasarkan ID.
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