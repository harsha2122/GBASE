<?php

namespace Database\Seeders;

use App\Models\ContactDetail;
use Illuminate\Database\Seeder;

class ContactDetailSeeder extends Seeder
{
    public function run(): void
    {
        ContactDetail::create([
            'type' => 'phone',
            'value' => '+91 9810384249',
            'icon' => 'fa-solid fa-phone',
            'order' => 1
        ]);

        ContactDetail::create([
            'type' => 'phone_alt',
            'value' => '+91 9878640088',
            'icon' => 'fa-solid fa-phone',
            'order' => 2
        ]);

        ContactDetail::create([
            'type' => 'email',
            'value' => 'info@gbase.co.in',
            'icon' => 'fa-solid fa-envelope',
            'order' => 3
        ]);

        ContactDetail::create([
            'type' => 'whatsapp',
            'value' => '+919315738621',
            'icon' => 'fa fa-whatsapp',
            'order' => 4
        ]);
    }
}
