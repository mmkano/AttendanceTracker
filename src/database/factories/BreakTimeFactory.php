<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attendance;
use App\Models\BreakTime;
use DateTime;

class BreakTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
{
    $attendance = Attendance::inRandomOrder()->first() ?? Attendance::factory()->create();
    $format = 'Y-m-d H:i:s';
    $attendanceStartTime = new \DateTime($attendance->start_time);
    $attendanceEndTime = new \DateTime($attendance->end_time);

    $breakStartTime = $this->faker->dateTimeBetween($attendanceStartTime, $attendanceEndTime);
    $breakEndTime = (clone $breakStartTime)->modify('+'.rand(5, 120).' minutes');

    if ($breakEndTime > $attendanceEndTime) {
        $breakEndTime = $attendanceEndTime;
    }

    return [
        'attendance_id' => $attendance->id,
        'break_start_time' => $breakStartTime->format($format),
        'break_end_time' => $breakEndTime->format($format),
    ];
}
}
