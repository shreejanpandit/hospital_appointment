<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Departments
        $departments = [
            'Cardiology',
            'Orthopedics',
            'Neurology',
            'Pediatrics',
            'Oncology',
            'Internal Medicine',
            'Emergency Medicine',
            'Radiology',
            'Anesthesiology',
            'Dermatology',
            'Gastroenterology',
            'Obstetrics and Gynecology',
            'Urology',
            'Ophthalmology',
            'Pulmonology',
            'Rheumatology',
            'Nephrology',
            'Hematology',
            'Infectious Diseases',
            'Endocrinology',
        ];

        // Insert departments if not already present
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

        // Days of the week
        $daysOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        // Seed doctors and schedules
        foreach ($departmentIds as $departmentName => $departmentId) {
            for ($i = 1; $i <= 4; $i++) {
                $userId = DB::table('users')->insertGetId([
                    'name' => "Doctor $departmentName $i",
                    'email' => "doctor$departmentId$i@example.com",
                    'role' => 'doctor',
                    'password' => Hash::make('password'),
                ]);

                DB::table('doctors')->insert([
                    'user_id' => $userId,
                    'department_id' => $departmentId,
                    'contact' => '123-456-7890',
                    'bio' => 'Bio of Doctor ' . $i,
                ]);

                // Get a random day off for this doctor
                $dayOff = $daysOfWeek[array_rand($daysOfWeek)];

                // Assign schedules for each day of the week
                foreach ($daysOfWeek as $day) {
                    if ($day === $dayOff) {
                        // No schedule for the day off
                        continue;
                    }

                    foreach ($timeSlots as $slot) {
                        DB::table('schedules')->insert([
                            'doctor_id' => $userId,
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
