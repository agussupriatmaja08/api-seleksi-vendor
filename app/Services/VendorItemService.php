<?php
namespace App\Services;
use App\Models\VendorItem;
use App\Helpers\ServiceResponse;
use App\Services\Contracts\VendorItemInterface;
class VendorItemService implements VendorItemInterface
{
    public function showVendorItems()
    {
        $datas = VendorItem::all();
        return ServiceResponse::success($datas, 'Data ditemukan', 200);
    }
    public function showVendorItemById($id)
    {
        $data = VendorItem::find($id);
        if (!$data) {
            return ServiceResponse::error('Data vendor item tidak ditemukan', 404);
        }
        return ServiceResponse::success($data, 'Data ditemukan', 200);
    }
    public function createVendorItem($data)
    {
        $vendorItem = VendorItem::firstOrCreate(
            [
                'id_vendor' => $data['id_vendor'],
                'id_item' => $data['id_item']
            ],
            $data
        );

        if (!$vendorItem->wasRecentlyCreated) {
            return ServiceResponse::error('Data item sudah ada dalam vendor', 422);
        }

        return ServiceResponse::success($vendorItem, 'Data berhasil ditambahkan');
    }
    public function updateVendorItem($id, $data)
    {
        $vendorItem = VendorItem::find($id);
        $exists = VendorItem::where('id_vendor', $data['id_vendor'])
            ->where('id_item', $data['id_item'])
            ->where('id_vendor_item', '!=', $id)
            ->exists();

        if ($exists) {
            return ServiceResponse::error('Data item sudah ada dalam vendor', 422);
        }
        if ($vendorItem) {
            $vendorItem->updateOrFail($data);
            return ServiceResponse::success($vendorItem, 'Data berhasil diupdate');

        }
        return ServiceResponse::error('Vendor Item tidak ditemukan', 404);
    }
    public function deleteVendorItem($id)
    {
        $vendorItem = VendorItem::find($id);
        if ($vendorItem) {
            $vendorItem->delete();
            return ServiceResponse::success(null, 'Data berhasil dihapus');
        }
        return ServiceResponse::error('Vendor Item tidak ditemukan', 404);
    }
}