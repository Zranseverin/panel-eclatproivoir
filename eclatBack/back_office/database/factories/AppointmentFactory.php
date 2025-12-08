<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Appointment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_type' => $this->faker->randomElement(['Nettoyage', 'Entretien', 'Réparation']),
            'frequency' => $this->faker->randomElement(['Unique', 'Hebdomadaire', 'Mensuelle']),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'desired_date' => $this->faker->date(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}