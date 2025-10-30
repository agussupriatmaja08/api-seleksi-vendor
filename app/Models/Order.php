<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_order';
    protected $fillable = [
        'tgl_order',
        'no_order',
        'id_vendor',
        'id_item',
    ];

    protected $casts = [
        'tgl_order' => 'date:Y-m-d',
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
