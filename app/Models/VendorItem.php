<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class VendorItem extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_vendor_item';

    protected $fillable = [
        'harga_sebelum',
        'harga_sekarang',
        'id_item',
        'id_vendor',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}
