<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    public function run(): void
    {
        $machines = [
            ['name' => 'Cutting Machine', 'category' => 'Pre-Process', 'slug' => 'cutting', 'page' => 'equipments', 'order' => 1],
            ['name' => 'Dicing Machine', 'category' => 'Pre-Process', 'slug' => 'dicing', 'page' => 'equipments', 'order' => 2],
            ['name' => 'Slicing Machine', 'category' => 'Pre-Process', 'slug' => 'slicing', 'page' => 'equipments', 'order' => 3],
            ['name' => 'Peeling Machine', 'category' => 'Pre-Process', 'slug' => 'peeling', 'page' => 'equipments', 'order' => 4],
            ['name' => 'Washing Machine', 'category' => 'Pre-Process', 'slug' => 'washing', 'page' => 'equipments', 'order' => 5],
            ['name' => 'Blanching Machine', 'category' => 'Pre-Process', 'slug' => 'blanching', 'page' => 'equipments', 'order' => 6],
            ['name' => 'Chilling Machine', 'category' => 'Pre-Process', 'slug' => 'chilling', 'page' => 'equipments', 'order' => 7],
            ['name' => 'De-watering Machine', 'category' => 'Pre-Process', 'slug' => 'dewatering', 'page' => 'equipments', 'order' => 8],
        ];

        foreach ($machines as $machine) {
            Machine::create($machine);
        }
    }
}
