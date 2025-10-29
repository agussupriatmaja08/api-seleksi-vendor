<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\OrderInterface;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    //
    protected $orderService;
    public function __construct(OrderInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->showOrders();
        return response()->json([
            'success' => $orders->success,
            'message' => $orders->message,
            'data' => $orders->data,
        ], $orders->status);
    }
    public function show($id)
    {
        $order = $this->orderService->showOrderById($id);

        return response()->json([
            'success' => $order->success,
            'message' => $order->message,
            'data' => $order->data,
        ], $order->status);
    }
    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->createOrder($request->validated());
        return response()->json([
            'success' => $order->success,
            'message' => $order->message,
            'data' => $order->data,
        ], $order->status);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $order = $this->orderService->updateOrder($id, $request->validated());
        return response()->json([
            'success' => $order->success,
            'message' => $order->message,
            'data' => $order->data,
        ], $order->status);
    }
    public function destroy($id)
    {
        $order = $this->orderService->deleteOrder($id);
        return response()->json([
            'success' => $order->success,
            'message' => $order->message,
            'data' => $order->data,
        ], $order->status);
    }
}
