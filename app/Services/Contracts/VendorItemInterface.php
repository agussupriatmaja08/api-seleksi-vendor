<?php
namespace App\Services\Contracts;

interface VendorItemInterface
{
    public function showVendorItems();
    public function showVendorItemById($id);
    public function createVendorItem($data);
    public function updateVendorItem($id, $data);
    public function deleteVendorItem($id);
}