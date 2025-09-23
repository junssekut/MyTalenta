<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // Discussion rooms for BCA Learning Institute
        $discussionRooms = [
            [
                'name' => 'Ruang Diskusi A',
                'location' => 'Lantai 2 BCA Learning Institute',
                'capacity' => 8,
                'type' => 'discussion',
                'description' => 'Ruang diskusi dengan fasilitas proyektor dan whiteboard',
                'facilities' => ['proyektor', 'whiteboard', 'ac', 'wifi'],
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Diskusi B',
                'location' => 'Lantai 2 BCA Learning Institute',
                'capacity' => 12,
                'type' => 'discussion',
                'description' => 'Ruang diskusi dengan fasilitas lengkap',
                'facilities' => ['proyektor', 'whiteboard', 'ac', 'wifi', 'tv'],
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Diskusi C',
                'location' => 'Lantai 3 BCA Learning Institute',
                'capacity' => 6,
                'type' => 'discussion',
                'description' => 'Ruang diskusi kecil untuk grup study',
                'facilities' => ['whiteboard', 'ac', 'wifi'],
                'is_active' => true,
            ],
        ];

        // Dormitory rooms for Rumah Talenta BCA
        $dormitoryRooms = [
            [
                'name' => 'Ruang Serbaguna',
                'location' => 'Lantai 1 Rumah Talenta',
                'capacity' => 50,
                'type' => 'dormitory',
                'description' => 'Ruang serbaguna untuk acara besar',
                'facilities' => ['sound_system', 'proyektor', 'ac', 'kursi'],
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Meeting',
                'location' => 'Lantai 2 Rumah Talenta',
                'capacity' => 20,
                'type' => 'dormitory',
                'description' => 'Ruang meeting untuk diskusi internal',
                'facilities' => ['meja_bundar', 'ac', 'wifi', 'proyektor'],
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Rekreasi',
                'location' => 'Lantai 1 Rumah Talenta',
                'capacity' => 15,
                'type' => 'dormitory',
                'description' => 'Ruang rekreasi dengan fasilitas hiburan',
                'facilities' => ['tv', 'sofa', 'ac', 'games'],
                'is_active' => true,
            ],
        ];

        foreach ($discussionRooms as $room) {
            Room::create($room);
        }

        foreach ($dormitoryRooms as $room) {
            Room::create($room);
        }
    }
}
