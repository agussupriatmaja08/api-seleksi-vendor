<?php
namespace Database\Factories;

use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'tgl_order' => $this->faker->date(),
            'no_order' => $this->faker->unique()->regexify('ORD[0-9]{4}'),
            'id_vendor' => Vendor::inRandomOrder()->first()?->id_vendor ?? Vendor::factory(),
        ];
    }
}
