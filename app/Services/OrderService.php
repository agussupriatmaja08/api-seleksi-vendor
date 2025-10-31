<?php
namespace App\Services;
use App\Models\Order;
use App\Helpers\ServiceResponse;
use App\Models\VendorItem;
use App\Services\Contracts\OrderInterface;
class OrderService implements OrderInterface
{
    public function showOrders()
    {
        $orders = Order::all();
        return ServiceResponse::success($orders, 'Data ditemukan', 200);
    }
    public function showOrderById($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return ServiceResponse::error('Data tidak ditemukan', 404);
        }
        return ServiceResponse::success($order, 'Data ditemukan', 200);

    }
    public function createOrder($data)
    {
        $isValidOffer = VendorItem::where('id_vendor', $data['id_vendor'])
            ->where('id_item', $data['id_item'])
            ->exists();
        if (!$isValidOffer) {
            return ServiceResponse::error('Order Gagal: Vendor tidak menawarkan item ini.', 422);
        }
        $order = Order::create($data);
        return ServiceResponse::success($order, 'Order berhasil dibuat', 201);

    }
    public function updateOrder($id, $data)
    {
        $order = Order::find($id);
        if (!$order) {
            return ServiceResponse::error('Data order tidak ditemukan', 404);
        }
        $isValidOrder = VendorItem::where('id_vendor', $data['id_vendor'])->where('id_item', $data['id_item'])->exists();
        if (!$isValidOrder) {
            return ServiceResponse::error('Order Gagal: Vendor tidak menawarkan item ini.', 422);
        }
        $order->update($data);

        return ServiceResponse::success($order, 'Order berhasil diubah', 200);
    }
    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return ServiceResponse::error('Order tidak ditemukan', 404);
        }
        $order->delete();
        return ServiceResponse::success(null, 'Order berhasil dihapus', 200);
    }

}