<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Batch;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        // Create Programs
        $ppti = Program::create([
            'name' => 'ppti',
            'display_name' => 'Program Pendidikan Teknik Informatika',
            'description' => 'Program beasiswa untuk jurusan Teknik Informatika',
            'is_active' => true,
        ]);

        $ppbp = Program::create([
            'name' => 'ppbp',
            'display_name' => 'Program Pendidikan Bisnis dan Perbankan',
            'description' => 'Program beasiswa untuk jurusan Bisnis dan Perbankan',
            'is_active' => true,
        ]);

        // Create Batches for PPTI
        Batch::create([
            'program_id' => $ppti->id,
            'name' => '17',
            'year' => 2023,
            'display_name' => 'PPTI 17 (2023)',
            'is_active' => true,
        ]);

        Batch::create([
            'program_id' => $ppti->id,
            'name' => '18',
            'year' => 2024,
            'display_name' => 'PPTI 18 (2024)',
            'is_active' => true,
        ]);

        // Create Batches for PPBP
        Batch::create([
            'program_id' => $ppbp->id,
            'name' => '10',
            'year' => 2023,
            'display_name' => 'PPBP 10 (2023)',
            'is_active' => true,
        ]);

        Batch::create([
            'program_id' => $ppbp->id,
            'name' => '11',
            'year' => 2024,
            'display_name' => 'PPBP 11 (2024)',
            'is_active' => true,
        ]);
    }
}
