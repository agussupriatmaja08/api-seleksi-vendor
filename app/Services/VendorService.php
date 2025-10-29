<?php
namespace App\Services;
use App\Helpers\ServiceResponse;
use App\Models\Vendor;
use App\Services\Contracts\VendorInterface;
class VendorService implements VendorInterface
{
    public function showVendors()
    {
        $vendors = Vendor::all();
        return ServiceResponse::success($vendors, 'Data ditemukan', 200);
    }
    public function showVendorById($id)
    {
        $vendor = Vendor::find($id);
        if (!$vendor) {
            return ServiceResponse::error('Data vendor tidak ditemukan', 404);
        }
        return ServiceResponse::success($vendor, 'Data ditemukan', 200);

    }
    public function createVendor($data)
    {
        $vendor = Vendor::create($data);
        if (!$vendor) {
            return ServiceResponse::error('Gagal menambahkan data vendor', 500);
        }
        return ServiceResponse::success($vendor, 'Data berhasil ditambahkan', 201);

    }
    public function updateVendor($id, $data)
    {
        $vendor = Vendor::find($id);
        if (!$vendor) {
            return ServiceResponse::error('Data vendor tidak ditemukan', 404);
        }
        $vendor->update($data);
        return ServiceResponse::success($vendor, 'Data berhasil diperbarui', 200);
    }
    public function deleteVendor($id)
    {
        $vendor = Vendor::find($id);
        if (!$vendor) {
            return ServiceResponse::error('Data vendor tidak ditemukan', 404);
        }
        $vendor->delete();
        return ServiceResponse::success(null, 'Data berhasil dihapus', 200);
    }

}