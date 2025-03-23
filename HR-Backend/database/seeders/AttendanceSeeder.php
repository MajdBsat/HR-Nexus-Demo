<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found to attach attendance records!');
            return;
        }

        // Generate attendance records for the past 30 days
        for ($day = 0; $day < 30; $day++) {
            $date = Carbon::now()->subDays($day);

            // Skip weekends (Saturday and Sunday)
            if ($date->isWeekend()) {
                continue;
            }

            foreach ($users as $user) {
                // Randomize if user was present (90% chance of presence)
                if (rand(1, 100) <= 90) {
                    // Create clock in time (between 8:00 AM and 9:30 AM)
                    $clockInHour = rand(8, 9);
                    $clockInMinute = $clockInHour == 9 ? rand(0, 30) : rand(0, 59);
                    $clockInTime = Carbon::parse($date->format('Y-m-d') . ' ' . $clockInHour . ':' . $clockInMinute . ':00');

                    // Create clock out time (between 5:00 PM and 7:00 PM)
                    $clockOutHour = rand(17, 19);
                    $clockOutMinute = rand(0, 59);
                    $clockOutTime = Carbon::parse($date->format('Y-m-d') . ' ' . $clockOutHour . ':' . $clockOutMinute . ':00');

                    // Calculate total hours
                    $totalHours = $clockOutTime->diffInSeconds($clockInTime) / 3600;

                    // Create attendance record
                    Attendance::create([
                        'user_id' => $user->id,
                        'date_of_attendance' => $date->format('Y-m-d'),
                        'location' => rand(0, 1) ? 'Office' : 'Remote',
                        'clock_in_time' => $clockInTime,
                        'clock_out_time' => $clockOutTime,
                        'total_hours' => round($totalHours, 2),
                    ]);
                }
            }
        }

        $this->command->info('Attendance records seeded successfully!');
    }
}
