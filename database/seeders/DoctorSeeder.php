<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // Departments
        $departments = [
            'Cardiology', 'Orthopedics', 'Neurology', 'Pediatrics',
            'Oncology', 'Internal Medicine', 'Emergency Medicine', 'Radiology',
            'Anesthesiology', 'Dermatology', 'Gastroenterology', 'Obstetrics and Gynecology',
            'Urology', 'Ophthalmology', 'Pulmonology', 'Rheumatology',
            'Nephrology', 'Hematology', 'Infectious Diseases', 'Endocrinology',
        ];

        // Insert departments
        foreach ($departments as $department) {
            DB::table('departments')->updateOrInsert(
                ['name' => $department],
                ['name' => $department]
            );
        }

        $departmentIds = DB::table('departments')->pluck('id', 'name');

        // Time slots
        $timeSlots = [
            ['start_time' => '05:00:00', 'end_time' => '10:00:00'],
            ['start_time' => '10:00:00', 'end_time' => '15:00:00'],
            ['start_time' => '15:00:00', 'end_time' => '20:00:00'],
            ['start_time' => '20:00:00', 'end_time' => '05:00:00'], // Crosses midnight
        ];

        $daysOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        foreach ($departmentIds as $departmentName => $departmentId) {
            for ($i = 1; $i <= 2; $i++) {
                // Create user
                $userId = DB::table('users')->insertGetId([
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'role' => 'doctor',
                    'password' => Hash::make('password'),
                ]);

                // Insert doctor and get doctor_id
                $doctorId = DB::table('doctors')->insertGetId([
                    'user_id' => $userId,
                    'department_id' => $departmentId,
                    'contact' => '123-456-7890',
                    'bio' => 'Bio of Doctor ' . $i,
                ]);

                $dayOff = $daysOfWeek[array_rand($daysOfWeek)];

                foreach ($daysOfWeek as $day) {
                    if ($day === $dayOff) continue;

                    foreach ($timeSlots as $slot) {
                        DB::table('schedules')->insert([
                            'doctor_id' => $doctorId,
                            'week_day' => $day,
                            'start_time' => $slot['start_time'],
                            'end_time' => $slot['end_time'],
                        ]);
                    }
                }
            }
        }
    }
}
