<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GalleryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name_en' => 'Tree Plantation', 'name_bn' => 'বৃক্ষরোপণ', 'slug' => 'tree', 'order' => 1],
            ['name_en' => 'Iftar Distribution', 'name_bn' => 'ইফতার বিতরণ', 'slug' => 'iftar', 'order' => 2],
            ['name_en' => 'Relief Distribution', 'name_bn' => 'ত্রাণ বিতরণ', 'slug' => 'relief', 'order' => 3],
            ['name_en' => 'Winter Clothing', 'name_bn' => 'শীতবস্ত্র বিতরণ', 'slug' => 'winter', 'order' => 4],
            ['name_en' => 'Safe Water', 'name_bn' => 'নিরাপদ পানি', 'slug' => 'water', 'order' => 5],
            ['name_en' => 'Qurbani for All', 'name_bn' => 'সবার জন্য কুরবানী', 'slug' => 'qurbani', 'order' => 6],
            ['name_en' => 'Education & Dawah', 'name_bn' => 'শিক্ষা ও দাওয়াহ', 'slug' => 'education', 'order' => 7],
            ['name_en' => 'Welfare & Rehabilitation', 'name_bn' => 'সেবা ও পুনর্বাসন', 'slug' => 'welfare', 'order' => 8],
        ];

        foreach ($categories as $cat) {
            GalleryCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name_en' => $cat['name_en'],
                    'name_bn' => $cat['name_bn'],
                    'order' => $cat['order'],
                    'is_active' => true,
                ]
            );
        }

        foreach (GalleryItem::all() as $item) {
            if ($item->category) {
                $match = GalleryCategory::where('slug', $item->category)->first();
                if ($match) {
                    $item->gallery_category_id = $match->id;
                    $item->save();
                }
            }
        }
    }
}
