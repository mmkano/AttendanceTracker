<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $userCount = 105;
        User::factory($userCount)->create()->each(function ($user) use ($faker) {
        $startDate = Carbon::create(2024, 4, 1);
        $endDate = Carbon::today();

        while ($startDate->lte($endDate)) {
            $date = $startDate->toDateString();
            $weekDay = $startDate->format('N');
            $isHoliday = $this->isHoliday($date);
            $defaultTime = $date . ' 00:00:00';
            $startTime = $endTime = $defaultTime;

            if (!($weekDay >= 6 || $isHoliday)) {
                $startTime = $faker->dateTimeBetween($date . ' 08:00:00', $date . ' 16:00:00')->format('Y-m-d H:i:s');
                $endTime = $faker->dateTimeBetween($date . ' 17:00:00', $date . ' 23:59:59')->format('Y-m-d H:i:s');
            }

            $attendance = Attendance::factory()->create([
                'user_id' => $user->id,
                'date' => $date,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

            if (!($weekDay >= 6 || $isHoliday)) {
                $totalWorkMinutes = Carbon::parse($endTime)->diffInMinutes(Carbon::parse($startTime));
                $totalBreakMinutes = 0;
                $breakTimeCount = random_int(1, 3);

                for ($i = 0; $i < $breakTimeCount; $i++) {
                    $breakStartTime = Carbon::instance($faker->dateTimeBetween($startTime, $endTime));
                    $breakEndTime = Carbon::instance(clone $breakStartTime)->modify('+'.rand(5, min(60, $totalWorkMinutes - $totalBreakMinutes)).' minutes');
                    $breakMinutes = $breakEndTime->diffInMinutes($breakStartTime);

                    if ($totalBreakMinutes + $breakMinutes > $totalWorkMinutes || $totalBreakMinutes + $breakMinutes > 120) {
                        break;
                    }

                    $totalBreakMinutes += $breakMinutes;

                    BreakTime::create([
                        'attendance_id' => $attendance->id,
                        'break_start_time' => $breakStartTime->format('Y-m-d H:i:s'),
                        'break_end_time' => $breakEndTime->format('Y-m-d H:i:s'),
                    ]);
                }
            }
            $startDate->addDay();
        }
    });
    }

    private function isHoliday($date)
    {
        $holidays = [
            '2024-04-29',
            '2024-05-03',
            '2024-05-04',
            '2024-05-05',
            '2024-05-06',
        ];

        return in_array($date, $holidays);
    }
}

