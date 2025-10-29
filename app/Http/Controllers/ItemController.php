<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\Contracts\ItemInterface;

class ItemController extends Controller
{
    //
    protected $itemService;
    public function __construct(ItemInterface $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {
        $items = $this->itemService->showItems();
        return response()->json([
            'success' => $items->success,
            'message' => $items->message,
            'data' => $items->data,
        ], $items->status);
    }

    public function show($id)
    {
        $item = $this->itemService->showItemById($id);
        return response()->json([
            'success' => $item->success,
            'message' => $item->message,
            'data' => $item->data,
        ], $item->status);
    }

    public function store(StoreItemRequest $request)
    {
        $item = $this->itemService->createItem($request->validated());
        return response()->json([
            'success' => $item->success,
            'message' => $item->message,
            'data' => $item->data,
        ], $item->status);
    }

    public function update(UpdateItemRequest $request, $id)
    {
        $item = $this->itemService->updateItem($id, $request->validated());
        return response()->json([
            'success' => $item->success,
            'message' => $item->message,
            'data' => $item->data,
        ], $item->status);
    }
    public function destroy($id)
    {
        $item = $this->itemService->deleteItem($id);
        return response()->json([
            'success' => $item->success,
            'message' => $item->message,
            'data' => $item->data,
        ], $item->status);
    }
}
