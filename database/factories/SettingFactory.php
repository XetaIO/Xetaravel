<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Xetaravel\Models\Setting;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->slug,
            'value' => $this->faker->text,
            'model_type' => null,
            'model_id' => null,
            'text' => $this->faker->sentence,
            'label' => $this->faker->word,
            'label_info' => $this->faker->sentence,
            'last_updated_user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withModel(string $type, int $id): self
    {
        return $this->state(fn () => [
            'model_type' => $type,
            'model_id' => $id,
        ]);
    }

    public function withLastUpdater(int $userId): self
    {
        return $this->state(fn () => [
            'last_updated_user_id' => $userId,
        ]);
    }
}
