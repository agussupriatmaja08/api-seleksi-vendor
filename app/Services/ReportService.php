<?php
namespace App\Services;
use App\Models\Vendor;
use App\Helpers\ServiceResponse;

use App\Services\Contracts\ReportInterface;
class ReportService implements ReportInterface
{
    public function getReportItemVendor()
    {
        $vendors = Vendor::with('vendorItems.item')->get();

        $data = $vendors->map(function ($vendor) {

            $itemsData = $vendor->vendorItems->map(function ($vendorItem) {
                if ($vendorItem->item) {
                    return [
                        "id_item" => $vendorItem->item->id_item,
                        "kode_item" => $vendorItem->item->kode_item,
                        "nama_item" => $vendorItem->item->nama_item
                    ];
                }
                return null;
            })->filter()->values();

            return [
                "id_vendor" => $vendor->id_vendor,
                "kode_vendor" => $vendor->kode_vendor,
                "nama_vendor" => $vendor->nama_vendor,
                "item" => $itemsData
            ];
        });
        return ServiceResponse::success($data->toArray(), 'Data ditemukan', 200);
    }

    public function getMostTransacted()
    {

        $vendors = Vendor::withCount('orders')
            ->orderByDesc('orders_count')
            ->get();

        $data = $vendors->map(function ($vendor) {
            return [
                "id_vendor" => $vendor->id_vendor,
                "kode_vendor" => $vendor->kode_vendor,
                "nama_vendor" => $vendor->nama_vendor,
                "jumlah_transaksi" => (float) $vendor->orders_count,
            ];
        });

        return ServiceResponse::success($data->toArray(), 'Data ditemukan', 200);
    }

    public function getRateReport()
    {
        $vendors = Vendor::with('vendorItems.item')->get();

        $data = $vendors->map(function ($vendor) {

            $itemsDatas = $vendor->vendorItems->map(function ($vendorItem) {

                if (!$vendorItem->item) {
                    return null;
                }
                $harga_sebelum = (float) $vendorItem->harga_sebelum;
                $harga_sekarang = (float) $vendorItem->harga_sekarang;
                $selisih = $harga_sekarang - $harga_sebelum;

                $rate = $harga_sebelum != 0
                    ? round(($selisih / $harga_sebelum) * 100, 2)
                    : 0;

                if ($selisih > 0) {
                    $status = "up";
                } elseif ($selisih < 0) {
                    $status = "down";
                } else {
                    $status = "stable";
                }

                return [
                    "id_item" => $vendorItem->item->id_item,
                    "kode_item" => $vendorItem->item->kode_item,
                    "nama_item" => $vendorItem->item->nama_item,
                    "harga_sebelum" => $harga_sebelum,
                    "harga_sekarang" => $harga_sekarang,
                    "selisih" => abs($selisih),
                    "rate" => abs($rate),
                    "status" => $status
                ];
            })->filter()->values();

            return [
                "id_vendor" => $vendor->id_vendor,
                "kode_vendor" => $vendor->kode_vendor,
                "nama_vendor" => $vendor->nama_vendor,
                "item" => $itemsDatas
            ];
        });
        return ServiceResponse::success($data->toArray(), 'Data ditemukan', 200);

    }
}