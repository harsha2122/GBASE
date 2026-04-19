<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        SocialLink::create([
            'platform' => 'Facebook',
            'url' => 'https://www.facebook.com/gbasetechnologies/',
            'icon' => 'fa-brands fa-facebook-f',
            'order' => 1
        ]);

        SocialLink::create([
            'platform' => 'Instagram',
            'url' => 'https://www.instagram.com/gbasetechnologies/',
            'icon' => 'fa-brands fa-instagram',
            'order' => 2
        ]);

        SocialLink::create([
            'platform' => 'YouTube',
            'url' => 'https://www.youtube.com/@gbasetechnologies',
            'icon' => 'fa-brands fa-youtube',
            'order' => 3
        ]);

        SocialLink::create([
            'platform' => 'LinkedIn',
            'url' => 'https://www.linkedin.com/company/gbase-technologiesfoodprocessingmachineries/',
            'icon' => 'fa-brands fa-linkedin-in',
            'order' => 4
        ]);
    }
}
