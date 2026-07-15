<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        static $invoice = 1000;
        $invoice++;

        $status = fake()->randomElement(array_keys(Order::STATUSES));

        return [
            'invoice_number'    => 'INV-' . str_pad((string) $invoice, 4, '0', STR_PAD_LEFT),
            'customer_name'     => fake()->company(),
            'customer_number'   => 'CUST-' . fake()->unique()->numberBetween(100, 9999),
            'fiscal_data'       => fake()->company() . "\nRFC: " . strtoupper(fake()->bothify('???######???')) . "\n" . fake()->address(),
            'order_datetime'    => fake()->dateTimeBetween('-2 months', 'now'),
            'delivery_address'  => fake()->address(),
            'notes'             => fake()->optional()->sentence(),
            'status'            => $status,
            'status_changed_at' => now(),
            'created_by'        => User::inRandomOrder()->value('id'),
        ];
    }

    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Order::STATUS_DELIVERED,
        ]);
    }
}
