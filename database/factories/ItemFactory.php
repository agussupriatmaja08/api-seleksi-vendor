<?php
namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'kode_item' => $this->faker->unique()->regexify('ITM[0-9]{4}'),
            'nama_item' => $this->faker->words(2, true),
        ];
    }
}
