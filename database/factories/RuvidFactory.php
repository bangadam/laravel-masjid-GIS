<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ruvid;
use Illuminate\Database\Eloquent\Factories\Factory;

class RuvidFactory extends Factory
{
    protected $model = Ruvid::class;

    public function definition()
    {
        return [
            'title'       => $this->faker->word,
            'description' => $this->faker->sentence,
            'creator_id'  => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
