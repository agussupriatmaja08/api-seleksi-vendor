<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Vendor extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_vendor';

    protected $fillable = [
        'kode_vendor',
        'nama_vendor'
    ];


    public function vendorItems()
    {
        return $this->hasMany(VendorItem::class, 'id_vendor', 'id_vendor');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_vendor', 'id_vendor');
    }
}
