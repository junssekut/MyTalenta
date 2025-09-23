<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Facility booking limits
            [
                'key' => 'max_washing_machine_male',
                'value' => '2',
                'description' => 'Maksimal slot mesin cuci pria per waktu',
            ],
            [
                'key' => 'max_washing_machine_female', 
                'value' => '2',
                'description' => 'Maksimal slot mesin cuci wanita per waktu',
            ],
            [
                'key' => 'max_kitchen_users',
                'value' => '4', 
                'description' => 'Maksimal pengguna dapur per slot waktu',
            ],

            // Attendance settings
            [
                'key' => 'attendance_start_time',
                'value' => '07:00',
                'description' => 'Jam mulai absensi masuk',
            ],
            [
                'key' => 'attendance_end_time',
                'value' => '17:00',
                'description' => 'Jam batas absensi pulang',
            ],
            [
                'key' => 'late_threshold_minutes',
                'value' => '15',
                'description' => 'Batas keterlambatan dalam menit',
            ],

            // Shuttle booking settings
            [
                'key' => 'shuttle_booking_deadline_hours',
                'value' => '48',
                'description' => 'Batas waktu booking shuttle dalam jam sebelum keberangkatan',
            ],
            [
                'key' => 'shuttle_friday_deadline_day',
                'value' => 'wednesday',
                'description' => 'Hari batas booking shuttle Jumat',
            ],
            [
                'key' => 'shuttle_friday_deadline_time',
                'value' => '17:00',
                'description' => 'Jam batas booking shuttle Jumat',
            ],

            // Room booking settings
            [
                'key' => 'room_booking_max_advance_days',
                'value' => '14',
                'description' => 'Maksimal hari ke depan untuk booking ruangan',
            ],
            [
                'key' => 'room_booking_min_duration_hours',
                'value' => '1',
                'description' => 'Durasi minimal booking ruangan dalam jam',
            ],
            [
                'key' => 'room_booking_max_duration_hours',
                'value' => '8',
                'description' => 'Durasi maksimal booking ruangan dalam jam',
            ],

            // Kios Talenta status
            [
                'key' => 'kios_talenta_status',
                'value' => 'open',
                'description' => 'Status Kios Talenta (open/closed)',
            ],

            // Notification settings
            [
                'key' => 'email_notifications_enabled',
                'value' => 'true',
                'description' => 'Enable email notifications',
            ],
            [
                'key' => 'sms_notifications_enabled',
                'value' => 'false',
                'description' => 'Enable SMS notifications',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::create($setting);
        }
    }
}
