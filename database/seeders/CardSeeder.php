<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            ['title' => 'Expert Consulting', 'description' => 'Professional consulting services for food processing projects', 'page' => 'home', 'order' => 1],
            ['title' => 'Advanced Equipment', 'description' => 'State-of-the-art food processing machinery', 'page' => 'home', 'order' => 2],
            ['title' => 'Full Support', 'description' => 'Complete support throughout your project lifecycle', 'page' => 'home', 'order' => 3],
            ['title' => 'Freezing Solutions', 'description' => 'Advanced freezing technology for optimal preservation', 'page' => 'freezing', 'order' => 1],
            ['title' => 'Heating Solutions', 'description' => 'Precise heating systems for food processing', 'page' => 'heating', 'order' => 1],
        ];

        foreach ($cards as $card) {
            Card::create($card);
        }
    }
}
