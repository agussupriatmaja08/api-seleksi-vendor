<?php
namespace App\Services\Contracts;
interface VendorInterface
{
    public function showVendors();
    public function showVendorById($id);
    public function createVendor($data);
    public function updateVendor($id, $data);
    public function deleteVendor($id);
}