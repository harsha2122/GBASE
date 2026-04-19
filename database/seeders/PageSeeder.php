<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            // Root Pages
            ['slug' => 'home', 'title' => 'Home', 'meta_description' => 'GBASE - Food Processing Solutions', 'content' => 'Welcome to GBASE', 'breadcrumb' => 'Home'],
            ['slug' => 'equipments', 'title' => 'Equipment', 'meta_description' => 'Food Processing Equipment', 'content' => 'Browse equipment', 'breadcrumb' => 'Equipment'],
            ['slug' => 'consulting', 'title' => 'Consulting', 'meta_description' => 'Consulting Services', 'content' => 'Professional consulting', 'breadcrumb' => 'Consulting'],
            ['slug' => 'contact', 'title' => 'Contact Us', 'meta_description' => 'Contact GBASE', 'content' => 'Contact us', 'breadcrumb' => 'Contact'],
            ['slug' => 'freezing', 'title' => 'Freezing', 'meta_description' => 'Freezing Solutions', 'content' => 'Freezing technology', 'breadcrumb' => 'Freezing'],
            ['slug' => 'heating', 'title' => 'Heating', 'meta_description' => 'Heating Solutions', 'content' => 'Heating technology', 'breadcrumb' => 'Heating'],
            ['slug' => 'service', 'title' => 'Services', 'meta_description' => 'Services', 'content' => 'Our services', 'breadcrumb' => 'Services'],
            ['slug' => 'knowledge-articles', 'title' => 'Articles', 'meta_description' => 'Knowledge Articles', 'content' => 'Articles', 'breadcrumb' => 'Articles'],
            ['slug' => 'knowledge-videos', 'title' => 'Videos', 'meta_description' => 'Knowledge Videos', 'content' => 'Videos', 'breadcrumb' => 'Videos'],
            ['slug' => 'spare-parts', 'title' => 'Spare Parts', 'meta_description' => 'Spare Parts', 'content' => 'Spare parts', 'breadcrumb' => 'Spare Parts'],

            // Freezing Subcategories
            ['slug' => 'freezing-impingement', 'title' => 'Impingement Freezing', 'meta_description' => 'Impingement', 'content' => 'Impingement freezing', 'breadcrumb' => 'Impingement'],
            ['slug' => 'freezing-spiral', 'title' => 'Spiral Freezing', 'meta_description' => 'Spiral', 'content' => 'Spiral freezing', 'breadcrumb' => 'Spiral'],

            // Heating Subcategories
            ['slug' => 'heating-filteration', 'title' => 'Filteration', 'meta_description' => 'Filteration Heating', 'content' => 'Filteration', 'breadcrumb' => 'Filteration'],
            ['slug' => 'heating-grill', 'title' => 'Grill', 'meta_description' => 'Grilling Equipment', 'content' => 'Grill', 'breadcrumb' => 'Grill'],
            ['slug' => 'heating-oven', 'title' => 'Oven', 'meta_description' => 'Industrial Ovens', 'content' => 'Oven', 'breadcrumb' => 'Oven'],

            // Pre-Processing
            ['slug' => 'process-cutting', 'title' => 'Cutting', 'meta_description' => 'Cutting Machines', 'content' => 'Cutting', 'breadcrumb' => 'Cutting'],
            ['slug' => 'process-dicing', 'title' => 'Dicing', 'meta_description' => 'Dicing Machines', 'content' => 'Dicing', 'breadcrumb' => 'Dicing'],
            ['slug' => 'process-slicing', 'title' => 'Slicing', 'meta_description' => 'Slicing Machines', 'content' => 'Slicing', 'breadcrumb' => 'Slicing'],
            ['slug' => 'process-peeling', 'title' => 'Peeling', 'meta_description' => 'Peeling Machines', 'content' => 'Peeling', 'breadcrumb' => 'Peeling'],
            ['slug' => 'process-washing', 'title' => 'Washing', 'meta_description' => 'Washing Systems', 'content' => 'Washing', 'breadcrumb' => 'Washing'],
            ['slug' => 'process-blanching', 'title' => 'Blanching', 'meta_description' => 'Blanching Equipment', 'content' => 'Blanching', 'breadcrumb' => 'Blanching'],
            ['slug' => 'process-more-machines', 'title' => 'More Machines', 'meta_description' => 'More Equipment', 'content' => 'More machines', 'breadcrumb' => 'More Machines'],
            ['slug' => 'process-used-equipment', 'title' => 'Used Equipment', 'meta_description' => 'Used Equipment', 'content' => 'Used equipment', 'breadcrumb' => 'Used Equipment'],

            // Services
            ['slug' => 'service-equipment-audits', 'title' => 'Equipment Audits', 'meta_description' => 'Audits', 'content' => 'Audits', 'breadcrumb' => 'Audits'],
            ['slug' => 'service-onsite-support', 'title' => 'Onsite Support', 'meta_description' => 'Onsite Support', 'content' => 'Onsite support', 'breadcrumb' => 'Onsite'],
            ['slug' => 'service-online-support', 'title' => 'Online Support', 'meta_description' => 'Online Support', 'content' => 'Online support', 'breadcrumb' => 'Online'],

            // Sorting
            ['slug' => 'sorting', 'title' => 'Sorting', 'meta_description' => 'Sorting Equipment', 'content' => 'Sorting', 'breadcrumb' => 'Sorting'],
            ['slug' => 'sorting-conveyors', 'title' => 'Conveyors', 'meta_description' => 'Conveyor Systems', 'content' => 'Conveyors', 'breadcrumb' => 'Conveyors'],
            ['slug' => 'sorting-others', 'title' => 'Other Equipment', 'meta_description' => 'Other Equipment', 'content' => 'Other equipment', 'breadcrumb' => 'Other Equipment'],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
