<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorItem;
use App\Models\Vendor;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;


class VendorItemSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 0; $i <= 40; $i++) {
            $vendor = Vendor::inRandomOrder()->first();
            $item = Item::inRandomOrder()->first();

            $exist = VendorItem::where('id_item', $item->id_item)->where('id_vendor', $vendor->id_vendor)->exists();
            if (!$exist) {
                VendorItem::create([
                    'harga_sebelum' => $this->faker->numberBetween(10000, 50000),
                    'harga_sekarang' => $this->faker->numberBetween(10000, 50000),
                    'id_item' => $item->id_item,
                    'id_vendor' => $vendor->id_vendor,
                ]);
            }

        }


    }
}
