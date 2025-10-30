<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\VendorItem;
use Faker\Factory as Faker;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $totalData = 0;
        $maxData = 40;

        while ($totalData < $maxData) {
            $vendor = Vendor::inRandomOrder()->first();
            $item = Item::inRandomOrder()->first();

            $exist = VendorItem::where('id_item', $item->id_item)
                ->where('id_vendor', $vendor->id_vendor)
                ->exists();

            if ($exist) {
                $tgl = $faker->dateTimeBetween('2024-01-01', '2025-12-31')->format('Y-m-d');

                $attempt = 0;
                do {
                    $noOrder = 'ORD' . $faker->unique()->regexify('[0-9]{6}');
                    $attempt++;
                    if ($attempt > 5) {
                        $faker->unique($reset = true);
                    }
                } while (Order::where('no_order', $noOrder)->exists() && $attempt < 10);

                Order::create([
                    'tgl_order' => $tgl,
                    'no_order' => $noOrder,
                    'id_vendor' => $vendor->id_vendor,
                    'id_item' => $item->id_item,
                ]);
                $totalData++;

            }
        }
    }
}
