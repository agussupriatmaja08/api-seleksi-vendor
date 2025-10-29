<?php

namespace App\Services;
use App\Models\Item;
use App\Helpers\ServiceResponse;
use App\Services\Contracts\ItemInterface;
class ItemService implements ItemInterface
{
    public function showItems()
    {
        $items = Item::all();
        return ServiceResponse::success($items, 'Data ditemukan', 200);
    }
    public function showItemById($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return ServiceResponse::error('Data tidak ditemukan', 404);
        }
        return ServiceResponse::success($item, 'Data ditemukan', 200);


    }
    public function createItem($data)
    {
        $item = Item::create($data);
        return ServiceResponse::success($item, 'Data berhasil disimpan', 201);

    }
    public function updateItem($id, $data)
    {
        $item = Item::find($id);

        if ($item) {
            $item->update($data);
            return ServiceResponse::success($item, 'Data berhasil diupdate', 200);
        }

        return ServiceResponse::error('Item tidak ditemukan', 404);
    }
    public function deleteItem($id)
    {
        //
        $item = Item::find($id);
        if ($item) {
            $item->delete();
            return ServiceResponse::success(null, 'Data berhasil dihapus', 200);
        }
        return ServiceResponse::error('Item tidak ditemukan', 404);
    }

}