<?php
namespace App\Services\Contracts;

interface OrderInterface
{
    public function showOrders();
    public function showOrderById($id);
    public function createOrder($data);
    public function updateOrder($id, $data);
    public function deleteOrder($id);
}