<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Attendance;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Attendance::class;

    public function definition()
    {
    $startDate = '2023-01-01';
    $endDate = now()->format('Y-m-d');
    $date = $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d');
    $start_time = $this->faker->dateTimeBetween($date . ' 08:00:00', $date . ' 16:00:00');
    $end_time_max = new \DateTime($date . ' 23:59:59');
    $end_time = (clone $start_time)->modify('+' . rand(1, 8) . ' hours');

    if ($end_time > $end_time_max) {
        $end_time = $end_time_max;
    }

        return [
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];
    }
}
