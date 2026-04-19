<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::create([
            'slug' => 'home',
            'title' => 'Home',
            'meta_description' => 'GBASE Technologies - Food Processing Solutions',
            'content' => 'Welcome to GBASE Technologies',
            'breadcrumb' => 'Home'
        ]);

        Page::create([
            'slug' => 'equipments',
            'title' => 'Equipment',
            'meta_description' => 'Food Processing Equipment & Machines',
            'content' => 'Browse our complete range of food processing equipment',
            'breadcrumb' => 'Equipment'
        ]);

        Page::create([
            'slug' => 'consulting',
            'title' => 'Consulting',
            'meta_description' => 'Consulting Services',
            'content' => 'Professional consulting for food processing projects',
            'breadcrumb' => 'Consulting'
        ]);

        Page::create([
            'slug' => 'contact',
            'title' => 'Contact Us',
            'meta_description' => 'Get in touch with GBASE',
            'content' => 'Contact GBASE Technologies for inquiries',
            'breadcrumb' => 'Contact'
        ]);

        Page::create([
            'slug' => 'freezing',
            'title' => 'Freezing Solutions',
            'meta_description' => 'Freezing Equipment & Technology',
            'content' => 'Advanced freezing solutions for food processing',
            'breadcrumb' => 'Freezing'
        ]);

        Page::create([
            'slug' => 'heating',
            'title' => 'Heating Solutions',
            'meta_description' => 'Heating Equipment & Technology',
            'content' => 'Advanced heating solutions for food processing',
            'breadcrumb' => 'Heating'
        ]);

        Page::create([
            'slug' => 'service',
            'title' => 'Services',
            'meta_description' => 'Our Services',
            'content' => 'Complete food processing services',
            'breadcrumb' => 'Services'
        ]);

        Page::create([
            'slug' => 'knowledge-articles',
            'title' => 'Knowledge Articles',
            'meta_description' => 'Educational Articles',
            'content' => 'Learn about food processing',
            'breadcrumb' => 'Articles'
        ]);

        Page::create([
            'slug' => 'knowledge-videos',
            'title' => 'Knowledge Videos',
            'meta_description' => 'Video Tutorials',
            'content' => 'Watch our video tutorials',
            'breadcrumb' => 'Videos'
        ]);
    }
}
