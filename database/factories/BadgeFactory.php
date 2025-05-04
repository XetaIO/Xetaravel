<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Xetaravel\Models\Badge;

class BadgeFactory extends Factory
{
    protected $model = Badge::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name' => ucfirst($name),
            'description' => $this->faker->optional()->sentence(),
            'icon' => 'fas-check',
            'color' => $this->faker->optional()->hexColor(),
            'type' => $this->faker->randomElement([
                'onComment',
                'onPost',
                'onPostSolved',
                'onExperience',
                'onRegister',
                'topLeaderboard'
            ]),
            'rule' => $this->faker->numberBetween(1, 100)
        ];
    }
}
