<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'student',
                'display_name' => 'Mahasiswa',
                'description' => 'Mahasiswa biasa dengan akses dasar'
            ],
            [
                'name' => 'komti',
                'display_name' => 'Ketua Kelas',
                'description' => 'Ketua kelas dengan akses tambahan untuk melaporkan absensi'
            ],
            [
                'name' => 'wakomti',
                'display_name' => 'Wakil Ketua Kelas',
                'description' => 'Wakil ketua kelas dengan akses tambahan untuk melaporkan absensi'
            ],
            [
                'name' => 'secretary',
                'display_name' => 'Sekretaris Kelas',
                'description' => 'Sekretaris kelas yang dapat mengisi absensi dosen'
            ],
            [
                'name' => 'pic_ppti',
                'display_name' => 'PIC PPTI',
                'description' => 'Person in Charge untuk program PPTI'
            ],
            [
                'name' => 'pic_ppbp',
                'display_name' => 'PIC PPBP',
                'description' => 'Person in Charge untuk program PPBP'
            ],
            [
                'name' => 'pic_shuttle',
                'display_name' => 'PIC Shuttle',
                'description' => 'Person in Charge untuk manajemen shuttle bus'
            ],
            [
                'name' => 'core_team',
                'display_name' => 'Core Team',
                'description' => 'Anggota core team asrama'
            ],
            [
                'name' => 'admin_core_team',
                'display_name' => 'Admin Core Team',
                'description' => 'Administrator core team asrama'
            ],
            [
                'name' => 'building_management',
                'display_name' => 'Building Management',
                'description' => 'Tim Building Management (PT Sentra Layanan Prima)'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
