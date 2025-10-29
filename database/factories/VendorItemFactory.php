<?php
namespace Database\Factories;

use App\Models\VendorItem;
use App\Models\Vendor;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorItemFactory extends Factory
{
    protected $model = VendorItem::class;

    public function definition()
    {
        $item = Item::inRandomOrder()->first() ?? Item::factory();
        $vendor = Vendor::inRandomOrder()->first() ?? Vendor::factory();
        return [
            'harga_sebelum' => $this->faker->numberBetween(1, 100) * 10000,
            'harga_sekarang' => $this->faker->numberBetween(1, 100) * 10000,
            'id_vendor' => $vendor->id_vendor ?? $vendor,
            'id_item' => $item->id_item ?? $item,
        ];
    }
}
