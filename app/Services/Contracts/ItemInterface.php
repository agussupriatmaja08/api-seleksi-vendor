<?php

namespace App\Services\Contracts;

interface ItemInterface
{
    public function showItems();
    public function showItemById($id);
    public function createItem($data);
    public function updateItem($id, $data);
    public function deleteItem($id);
}
