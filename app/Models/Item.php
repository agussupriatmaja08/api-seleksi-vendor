<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_item';
    protected $fillable = [
        'kode_item',
        'nama_item'
    ];

    public function vendorItems()
    {
        return $this->hasMany(VendorItem::class, 'id_item', 'id_item');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_item', 'id_item');
    }
}
