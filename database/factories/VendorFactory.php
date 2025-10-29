<?php
namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition()
    {
        return [
            'kode_vendor' => $this->faker->unique()->regexify('VND[0-9]{4}'),
            'nama_item' => $this->faker->company,
        ];
    }
}
