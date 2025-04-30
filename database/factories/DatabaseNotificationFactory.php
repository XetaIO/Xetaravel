<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Xetaravel\Models\DatabaseNotification;
use Xetaravel\Models\Model;

class DatabaseNotificationFactory extends Factory
{
    protected $model = DatabaseNotification::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'type' => null,
            'notifiable_type' => null,
            'notifiable_id' => null,
            'data' => ['type' => 'mention', 'message' => $this->faker->sentence, 'link' => $this->faker->url],
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function type($type): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => $type,
        ]);
    }

    public function notifiable(Model $notifiable): static
    {
        return $this->state(fn (array $attributes) => [
            'notifiable_type' => $notifiable::class,
            'notifiable_id' => get_class($notifiable)
        ]);
    }

    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => now(),
        ]);
    }

    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => null,
        ]);
    }
}
