<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Service;
use App\Models\Notice;
use App\Models\GalleryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@wotm.org'],
            [
                'name' => 'WOTM Administrator',
                'password' => Hash::make('password123'),
                'is_admin' => true,
                'phone' => '+880 1700-000000',
            ]
        );

        // 2. Global Settings
        $settings = [
            // General
            ['group' => 'general', 'key' => 'site_title_en', 'value' => 'WOTM'],
            ['group' => 'general', 'key' => 'site_title_bn', 'value' => 'WOTM'],
            ['group' => 'general', 'key' => 'site_tagline_en', 'value' => 'For the Ummah, with the Sunnah'],
            ['group' => 'general', 'key' => 'site_tagline_bn', 'value' => 'উম্মাহর স্বার্থে, সুন্নাহর সাথে'],
            ['group' => 'general', 'key' => 'site_description_en', 'value' => 'WOTM is a non-political, non-profit educational, dawah and purely humanitarian registered welfare organization. Registration No: S-13111/2019.'],
            ['group' => 'general', 'key' => 'site_description_bn', 'value' => 'WOTM একটি অরাজনৈতিক, অলাভজনক শিক্ষা, দাওয়াহ ও পূর্ণত মানবকল্যাণে নিবেদিত সেবামূলক সরকার-নিবন্ধিত প্রতিষ্ঠান। নিবন্ধন নম্বর: এস-১৩১১১/২০১৯।'],
            ['group' => 'general', 'key' => 'site_reg_no', 'value' => 'এস-১৩১১১/২০১৯'],
            ['group' => 'general', 'key' => 'site_logo', 'value' => 'images/logos/logo.webp'],
            ['group' => 'general', 'key' => 'site_favicon', 'value' => 'images/logos/logo.webp'],
            ['group' => 'general', 'key' => 'site_phone', 'value' => '+880 1700-000000'],
            ['group' => 'general', 'key' => 'site_phone_secondary', 'value' => '+880 1800-000000'],
            ['group' => 'general', 'key' => 'site_email', 'value' => 'info@wotm.org'],
            ['group' => 'general', 'key' => 'site_address_en', 'value' => 'House #12, Road #4, Dhanmondi, Dhaka-1205, Bangladesh'],
            ['group' => 'general', 'key' => 'site_address_bn', 'value' => 'বাড়ি #১২, রোড #৪, ধানমন্ডি, ঢাকা-১২০৫, বাংলাদেশ'],
            ['group' => 'general', 'key' => 'whatsapp_number', 'value' => '8801700000000'],

            // Social
            ['group' => 'social', 'key' => 'social_facebook', 'value' => 'https://facebook.com/wotm'],
            ['group' => 'social', 'key' => 'social_twitter', 'value' => 'https://twitter.com/wotm'],
            ['group' => 'social', 'key' => 'social_youtube', 'value' => 'https://youtube.com/@wotm'],
            ['group' => 'social', 'key' => 'social_instagram', 'value' => 'https://instagram.com/wotm'],
            ['group' => 'social', 'key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/wotm'],

            // Footer
            ['group' => 'footer', 'key' => 'footer_logo', 'value' => 'images/logos/logo4.webp'],
            ['group' => 'footer', 'key' => 'footer_about_en', 'value' => 'WOTM is a non-political, non-profit educational, dawah and purely humanitarian registered welfare organization working across Bangladesh.'],
            ['group' => 'footer', 'key' => 'footer_about_bn', 'value' => 'WOTM একটি অরাজনৈতিক, অলাভজনক শিক্ষা, দাওয়াহ ও পূর্ণত মানবকল্যাণে নিবেদিত সেবামূলক সরকার-নিবন্ধিত প্রতিষ্ঠান।'],
            ['group' => 'footer', 'key' => 'footer_copyright_en', 'value' => 'Copyright © 2026 WOTM - All Rights Reserved.'],
            ['group' => 'footer', 'key' => 'footer_copyright_bn', 'value' => 'স্বত্ব © ২০২৬ WOTM - সর্ব স্বত্ব সংরক্ষিত।'],

            // SEO
            ['group' => 'seo', 'key' => 'seo_meta_title', 'value' => 'WOTM | উম্মাহর স্বার্থে, সুন্নাহর সাথে'],
            ['group' => 'seo', 'key' => 'seo_meta_description', 'value' => 'মানবকল্যাণে নিবেদিত সেবামূলক সরকার-নিবন্ধিত প্রতিষ্ঠান। যাকাত, সাদাকাহ ও উন্নয়ন প্রকল্পে অনুদান দিন।'],
            ['group' => 'seo', 'key' => 'seo_meta_keywords', 'value' => 'WOTM, অনুদান, যাকাত, কুরবানী, ত্রাণ, শিক্ষা, দাওয়াহ, মানবকল্যাণ'],
            ['group' => 'seo', 'key' => 'seo_og_image', 'value' => 'images/hero.webp'],
            ['group' => 'seo', 'key' => 'google_analytics_id', 'value' => ''],

            // Mail
            ['group' => 'mail', 'key' => 'mail_host', 'value' => 'smtp.mailtrap.io'],
            ['group' => 'mail', 'key' => 'mail_port', 'value' => '2525'],
            ['group' => 'mail', 'key' => 'mail_username', 'value' => ''],
            ['group' => 'mail', 'key' => 'mail_password', 'value' => ''],
            ['group' => 'mail', 'key' => 'mail_encryption', 'value' => 'tls'],
            ['group' => 'mail', 'key' => 'mail_from_address', 'value' => 'no-reply@wotm.org'],
            ['group' => 'mail', 'key' => 'mail_from_name', 'value' => 'WOTM Foundation'],
            ['group' => 'mail', 'key' => 'mail_admin_recipient', 'value' => 'admin@wotm.org'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // 3. Navigation Items
        $navs = [
            ['title_en' => 'Home', 'title_bn' => 'হোম', 'url' => '/', 'order' => 1],
            ['title_en' => 'About Us', 'title_bn' => 'আমাদের সম্পর্কে', 'url' => '/about-us', 'order' => 2],
            ['title_en' => 'Activities', 'title_bn' => 'কার্যক্রমসমূহ', 'url' => '/activities', 'order' => 3, 'children' => [
                ['title_en' => 'Education & Dawah', 'title_bn' => 'শিক্ষা ও দাওয়াহ', 'url' => '/activities?cat=education', 'order' => 1],
                ['title_en' => 'Welfare & Rehabilitation', 'title_bn' => 'সেবা ও পুনর্বাসন', 'url' => '/activities?cat=welfare', 'order' => 2],
                ['title_en' => 'Emergency Relief', 'title_bn' => 'জরুরি ত্রাণ কার্যক্রম', 'url' => '/activities?cat=relief', 'order' => 3],
                ['title_en' => 'Livelihood Support', 'title_bn' => 'স্বাবলম্বীকরণ', 'url' => '/activities?cat=livelihood', 'order' => 4],
            ]],
            ['title_en' => 'Gallery', 'title_bn' => 'গ্যালারি', 'url' => '/gallery', 'order' => 4],
            ['title_en' => 'Join Us', 'title_bn' => 'যুক্ত হোন', 'url' => '/volunteer', 'order' => 5],
            ['title_en' => 'Blog', 'title_bn' => 'ব্লগ', 'url' => '/blog', 'order' => 6],
            ['title_en' => 'Notices', 'title_bn' => 'নোটিশ', 'url' => '/notice', 'order' => 7],
            ['title_en' => 'Contact', 'title_bn' => 'যোগাযোগ', 'url' => '/contact', 'order' => 8],
            ['title_en' => 'Login', 'title_bn' => 'লগইন', 'url' => '/login', 'order' => 9],
        ];

        foreach ($navs as $nav) {
            $children = $nav['children'] ?? [];
            unset($nav['children']);
            $parent = NavigationItem::updateOrCreate(['url' => $nav['url']], $nav);

            foreach ($children as $child) {
                $child['parent_id'] = $parent->id;
                NavigationItem::updateOrCreate(['url' => $child['url']], $child);
            }
        }

        // 4. Post Categories
        $catRelief = PostCategory::updateOrCreate(['slug' => 'relief'], ['name_en' => 'Relief & Emergency', 'name_bn' => 'ত্রাণ ও পুনর্বাসন']);
        $catEducation = PostCategory::updateOrCreate(['slug' => 'education'], ['name_en' => 'Education & Training', 'name_bn' => 'শিক্ষা ও প্রশিক্ষণ']);
        $catDawah = PostCategory::updateOrCreate(['slug' => 'dawah'], ['name_en' => 'Dawah & Reformation', 'name_bn' => 'দাওয়াহ ও সংস্কার']);
        $catWelfare = PostCategory::updateOrCreate(['slug' => 'welfare'], ['name_en' => 'Social Welfare', 'name_bn' => 'সমাজকল্যাণ']);

        // 5. Blog Posts
        $posts = [
            [
                'category_id' => $catEducation->id,
                'title_en' => "Khulna Division Imam Training Workshop: 'From Mosque Imam to Society Leader'",
                'title_bn' => "খুলনা বিভাগের ইমাম প্রশিক্ষণ কর্মশালা : 'মসজিদের ইমাম থেকে সমাজ সংস্কারক'",
                'slug' => 'khulna-imam-training-workshop',
                'excerpt_en' => "How an imam can rise from the mosque minbar to become an influential leader of the entire society.",
                'excerpt_bn' => "মসজিদের মিম্বর থেকে একজন ইমাম কীভাবে পুরো সমাজের নেতা হয়ে উঠতে পারেন—সেই চেতনায় উদ্দীপ্ত হয়ে বাড়ি ফিরছেন খুলনা বিভাগের ইমাম ও খতিবগণ।",
                'content_en' => "<p>Imams play an irreplaceable role in societal reformation and ethical awakening. The Khulna Division Imam Training Workshop gathered religious leaders from across the region to foster leadership, social welfare knowledge, and community management.</p><p>Through specialized sessions on contemporary challenges, crisis intervention, and modern communication tools, attendees learned how to engage the youth and drive positive communal development.</p>",
                'content_bn' => "<p>মসজিদের মিম্বর থেকে একজন ইমাম কীভাবে পুরো সমাজের নেতা হয়ে উঠতে পারেন—সেই চেতনায় উদ্দীপ্ত হয়ে বাড়ি ফিরছেন খুলনা বিভাগের ইমাম ও খতিবগণ। সমাজ সংস্কার ও নৈতিক জাগরণে ইমামদের ভূমিকা অনস্বীকার্য।</p><p>এই কর্মশালায় আধুনিক সামাজিক প্রেক্ষাপট, জরুরি সেবা ও তরুণদের সুপথে পরিচালনার বাস্তবমুখী দিকনির্দেশনা প্রদান করা হয়।</p>",
                'featured_image' => 'images/projects/featured_imam.jpg',
                'author_name' => 'মাওলানা মাহমুদ',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => '2023-08-10 10:00:00',
            ],
            [
                'category_id' => $catRelief->id,
                'title_en' => 'Flood Relief Distribution Completed in Greater Chittagong',
                'title_bn' => 'বৃহত্তর চট্টগ্রামে বন্যার্তদের মাঝে ত্রাণ বিতরণ সম্পন্ন',
                'slug' => 'chittagong-flood-relief-completed',
                'excerpt_en' => 'Severe floods devastated vast areas in Chittagong, Cox’s Bazar, and Bandarban. Emergency food and medical relief were successfully distributed.',
                'excerpt_bn' => 'চলতি মাসের প্রথম সপ্তাহে বয়ে গেল চট্টগ্রামের ভয়াবহ বন্যা। এতে চট্টগ্রাম, কক্সবাজার ও বান্দরবানের বিস্তীর্ণ এলাকা তলিয়ে যায়। ক্ষতিগ্রস্ত হন হাজার হাজার পরিবার।',
                'content_en' => "<p>Flash floods and mountain torrents submerged dozens of upazilas across southeastern Bangladesh. WOTM's dedicated emergency rescue and relief team reached remote cut-off communities, providing dry food rations, clean drinking water purification tablets, and urgent medical assistance to over 10,000 victims.</p>",
                'content_bn' => "<p>ভারী বর্ষণ ও পাহাড়ি ঢলে দক্ষিণ-পূর্বাঞ্চলের বিস্তীর্ণ জনপদ প্লাবিত হয়। WOTM জরুরি উদ্ধার ও ত্রাণ টিম দুর্গম এলাকায় পৌঁছে শুকনা খাবার, বিশুদ্ধ খাবার পানি, পানি বিশুদ্ধকরণ ট্যাবলেট এবং প্রয়োজনীয় জরুরি ওষুধ ১০,০০০+ পরিবারের কাছে হস্তান্তর করেছে।</p>",
                'featured_image' => 'images/projects/flood_relief.jpg',
                'author_name' => 'মুহাম্মাদ ইমরান',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => '2023-07-21 14:30:00',
            ],
            [
                'category_id' => $catEducation->id,
                'title_en' => 'Completion of 3rd National Imam Leadership Training Course',
                'title_bn' => '৩য় জাতীয় ইমাম নেতৃত্ব প্রশিক্ষণ সম্পন্ন',
                'slug' => 'third-national-imam-leadership-course',
                'excerpt_en' => 'Developing competent religious scholars capable of addressing contemporary societal challenges.',
                'excerpt_bn' => 'সমসাময়িক সমস্যা সমাধান ও আলোকিত সমাজ বিনির্মাণে ইমামদের দক্ষতা বৃদ্ধির লক্ষ্যে বিশেষ প্রশিক্ষণ সম্পন্ন।',
                'content_en' => "<p>The training focused on equipping mosque leaders with counseling skills, youth guidance strategies, and effective community organization tools.</p>",
                'content_bn' => "<p>প্রশিক্ষণে ইমামদের কাউন্সেলিং, যুবকদের সঠিক দিকনির্দেশনা ও সমাজসেবামূলক কর্মকাণ্ডের ব্যবস্থাপনা নিয়ে বিশদ আলোচনা অনুষ্ঠিত হয়।</p>",
                'featured_image' => 'images/projects/imam_course.jpg',
                'author_name' => 'ড. আবু বকর',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => '2023-06-15 09:00:00',
            ],
        ];

        foreach ($posts as $postData) {
            Post::updateOrCreate(['slug' => $postData['slug']], $postData);
        }

        // 6. Services / Activities
        $services = [
            [
                'title_en' => 'Self-Reliance Program for Working Poor',
                'title_bn' => 'কর্মক্ষম দরিদ্রদের স্বাবলম্বীকরণ কর্মসূচি',
                'slug' => 'livelihood-self-reliance',
                'category' => 'livelihood',
                'short_description_en' => 'Providing sewing machines, rickshaw-vans, and small trade capital to help underprivileged families achieve financial independence.',
                'short_description_bn' => 'এই কার্যক্রমের আওতায় কর্মক্ষম কিন্তু অসচ্ছল ব্যক্তিদের আত্মকর্মসংস্থানের জন্য সেলাই মেশিন, রিকশা-ভ্যান ও ক্ষুদ্র ব্যবসার উপকরণ বিতরণ করা হয়।',
                'description_en' => '<p>Financial independence is the most sustainable safeguard against destitution. Through our Livelihood Program, verified breadwinners receive income-generating assets accompanied by practical basic business mentoring.</p>',
                'description_bn' => '<p>ভিক্ষাবৃত্তি নিরসন ও কর্মক্ষম মানুষকে মর্যাদাপূর্ণ স্বাবলম্বী জীবনে ফিরিয়ে আনার লক্ষ্যে WOTM স্বাবলম্বীকরণ কর্মসূচি পরিচালনা করছে। প্রতিটি পরিবারকে যাচাই-বাছাই করে তাদের উপযুক্ত জীবিকার উপকরণ যেমন সেলাই মেশিন, রিকশা-ভ্যান বা ক্ষুদ্র ব্যবসার মূলধন হস্তান্তর করা হয়।</p>',
                'image' => '2.jpeg',
                'icon' => 'fa-seedling',
                'beneficiaries_count' => '২,৫০০+',
                'districts_count' => '২৫+',
                'order' => 1,
            ],
            [
                'title_en' => 'Regular Educational Scholarships',
                'title_bn' => 'নিয়মিত শিক্ষাবৃত্তি ও মেধা বিকাশ',
                'slug' => 'education-scholarship',
                'category' => 'education',
                'short_description_en' => 'Providing monthly stipends, books, and study materials to meritorious students from low-income families.',
                'short_description_bn' => 'দরিদ্র অথচ মেধাবী শিক্ষার্থীদের পড়াশোনা যেন আর্থিক অনটনের কারণে বন্ধ না হয়, সেজন্য মাসিক বৃত্তি ও শিক্ষা উপকরণ প্রদান করা হয়।',
                'description_en' => '<p>No student should drop out due to poverty. Our scholarship initiative covers tuition fees, textbooks, and examination costs for talented scholars nationwide.</p>',
                'description_bn' => '<p>দারিদ্র্য যেন কোনো শিক্ষার্থীর মেধার বিকাশে বাধা না হতে পারে, সেজন্য স্কুল, কলেজ ও মাদরাসা শিক্ষার্থীদের মাসিক বৃত্তি, বই ও শিক্ষা উপকরণ দেওয়া হয়।</p>',
                'image' => '3.jpeg',
                'icon' => 'fa-graduation-cap',
                'beneficiaries_count' => '৫,০০০+',
                'districts_count' => '৪০+',
                'order' => 2,
            ],
            [
                'title_en' => 'Emergency Disaster Relief & Rehabilitation',
                'title_bn' => 'জরুরি দুর্যোগ ত্রাণ ও পুনর্বাসন',
                'slug' => 'disaster-relief',
                'category' => 'relief',
                'short_description_en' => 'Swift rescue operations, dry food packs, and shelter rebuilding in cyclone and flood affected areas.',
                'short_description_bn' => 'বন্যা, ঘূর্ণিঝড় ও শীতে দুর্গত মানুষের পাশে দ্রুত খাদ্য, বস্ত্র, ওষুধ ও ঘর মেরামতের সামগ্রী পৌঁছে দেওয়া।',
                'description_en' => '<p>Disasters strike without warning. Our rapid-response teams provide immediate nutrition packs and reconstruct damaged shelters.</p>',
                'description_bn' => '<p>প্রাকৃতিক দুর্যোগে বিপন্ন মানুষের পাশে দাঁড়াতে জরুরি ত্রাণ, বিশুদ্ধ খাবার পানি এবং পরবর্তীতে ক্ষতিগ্রস্ত বাড়িঘর মেরামত ও পুনর্বাসন সহায়তা প্রদান করা হয়।</p>',
                'image' => '4.jpeg',
                'icon' => 'fa-hands-holding-child',
                'beneficiaries_count' => '৫০,০০০+',
                'districts_count' => '৩০+',
                'order' => 3,
            ],
            [
                'title_en' => 'Safe Drinking Water Tube-well Installation',
                'title_bn' => 'বিশুদ্ধ খাবার পানির গভীর নলকূপ স্থাপন',
                'slug' => 'clean-water-tubewell',
                'category' => 'welfare',
                'short_description_en' => 'Installing deep tube-wells in coastal and drought-prone regions to eradicate water-borne diseases.',
                'short_description_bn' => 'উপকূলীয় লবণাক্ত ও প্রত্যন্ত অঞ্চলে বিশুদ্ধ খাবার পানির অভাব দূরীকরণে গভীর ও অগভীর নলকূপ স্থাপন।',
                'description_en' => '<p>Access to safe water is a fundamental right. We install durable deep tube-wells serving entire villages.</p>',
                'description_bn' => '<p>পানির সংকট নিরসনে উপকূলীয় ও প্রত্যন্ত অঞ্চলে শত শত নিরাপদ গভীর নলকূপ স্থাপন করা হয়েছে যা হাজার হাজার মানুষের তৃষ্ণা নিবারণ করছে।</p>',
                'image' => '5.jpeg',
                'icon' => 'fa-faucet-drip',
                'beneficiaries_count' => '১,২০,০০০+',
                'districts_count' => '১৮+',
                'order' => 4,
            ],
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(['slug' => $srv['slug']], $srv);
        }

        // 7. Notices
        $notices = [
            [
                'notice_number' => 'WOTM/ADM/2026/014',
                'title_en' => 'Notice on Ramadan Food Relief Distribution Program 2026',
                'title_bn' => 'রমজান খাদ্য সহায়তা কর্মসূচি ২০২৬ সংক্রান্ত জরুরি বিজ্ঞপ্তি',
                'description_en' => 'Information on distribution schedules and volunteer coordination for the upcoming Ramadan food pack distribution.',
                'description_bn' => 'আসন্ন পবিত্র মাহে রমজানে দেশব্যাপী খাদ্যসামগ্রী বিতরণ ও স্বেচ্ছাসেবক সমন্বয়ের সময়সূচি ও দিকনির্দেশনা।',
                'notice_date' => '2026-03-01',
                'file_type' => 'PDF',
                'file_size' => '1.2 MB',
                'is_pinned' => true,
            ],
            [
                'notice_number' => 'WOTM/EDU/2026/009',
                'title_en' => 'Scholarship Application Form for Meritorious Students (Academic Year 2026)',
                'title_bn' => 'মেধাবী শিক্ষার্থী শিক্ষাবৃত্তি আবেদন বিজ্ঞপ্তি (শিক্ষাবর্ষ ২০২৬)',
                'description_en' => 'Eligibility guidelines and deadline for submitting financial scholarship requests.',
                'description_bn' => '২০২৬ শিক্ষাবর্ষে অসচ্ছল ও মেধাবী শিক্ষার্থীদের মাসিক শিক্ষাবৃত্তির আবেদন জমাদানের নিয়মাবলী।',
                'notice_date' => '2026-02-15',
                'file_type' => 'PDF',
                'file_size' => '850 KB',
                'is_pinned' => true,
            ],
            [
                'notice_number' => 'WOTM/GEN/2026/003',
                'title_en' => 'Annual Audit Report and Financial Transparency Statement 2025',
                'title_bn' => 'বার্ষিক নিরীক্ষা (অডিট) প্রতিবেদন ও আর্থিক বিবরণী ২০২৫',
                'description_en' => 'Official chartered accountant audited financial statement available for public review.',
                'description_bn' => 'চার্টার্ড অ্যাকাউন্ট্যান্টস কর্তৃক নিরীক্ষিত ২০২৫ সালের পূর্ণাঙ্গ আর্থিক অডিট রিপোর্ট।',
                'notice_date' => '2026-01-20',
                'file_type' => 'PDF',
                'file_size' => '2.4 MB',
                'is_pinned' => false,
            ],
        ];

        foreach ($notices as $notice) {
            Notice::updateOrCreate(['notice_number' => $notice['notice_number']], $notice);
        }

        // 8. Gallery Items
        $gallery = [
            ['type' => 'image', 'title_en' => 'Flood Relief Distribution', 'title_bn' => 'বন্যার্তদের মাঝে ত্রাণ বিতরণ', 'image_path' => '7.jpeg', 'category' => 'relief', 'order' => 1],
            ['type' => 'image', 'title_en' => 'Winter Blanket Distribution', 'title_bn' => 'শীতবস্ত্র ও কম্বল বিতরণ', 'image_path' => '8.jpeg', 'category' => 'relief', 'order' => 2],
            ['type' => 'image', 'title_en' => 'Tube-well Inauguration', 'title_bn' => 'বিশুদ্ধ পানির নলকূপ উদ্বোধন', 'image_path' => '9.jpeg', 'category' => 'welfare', 'order' => 3],
            ['type' => 'image', 'title_en' => 'Self-Reliance Sewing Machine Distribution', 'title_bn' => 'স্বাবলম্বীকরণ সেলাই মেশিন প্রদান', 'image_path' => '10.jpeg', 'category' => 'livelihood', 'order' => 4],
            ['type' => 'image', 'title_en' => 'Educational Scholarship Ceremony', 'title_bn' => 'শিক্ষাবৃত্তি সনদ ও উপকরণ বিতরণ', 'image_path' => '11.jpeg', 'category' => 'education', 'order' => 5],
            ['type' => 'image', 'title_en' => 'Community Iftar Program', 'title_bn' => 'গণইফতার ও খাদ্য সহায়তা', 'image_path' => '12.jpeg', 'category' => 'welfare', 'order' => 6],
            ['type' => 'video', 'title_en' => 'Documentary on WOTM Humanitarian Activities', 'title_bn' => 'WOTM-এর সার্বিক কার্যক্রমের প্রামাণ্যচিত্র', 'image_path' => 'video-thumb.jpg', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'category' => 'events', 'order' => 7],
        ];

        foreach ($gallery as $gItem) {
            GalleryItem::updateOrCreate(['title_en' => $gItem['title_en']], $gItem);
        }

        // 9. Static / Key Pages for Dynamic SEO & Titles
        $pages = [
            [
                'slug' => 'home',
                'title_en' => 'WOTM | For the Ummah, with the Sunnah',
                'title_bn' => 'WOTM | উম্মাহর স্বার্থে, সুন্নাহর সাথে',
                'subtitle_en' => 'A non-political, non-profit welfare organization',
                'subtitle_bn' => 'একটি অরাজনৈতিক, অলাভজনক মানবকল্যাণমূলক প্রতিষ্ঠান',
                'meta_title' => 'WOTM | উম্মাহর স্বার্থে, সুন্নাহর সাথে',
                'meta_description' => 'WOTM একটি অরাজনৈতিক, অলাভজনক শিক্ষা, দাওয়াহ ও পূর্ণত মানবকল্যাণে নিবেদিত সেবামূলক সরকার-নিবন্ধিত প্রতিষ্ঠান।',
                'meta_keywords' => 'WOTM, অনুদান, যাকাত, কুরবানী, ত্রাণ, শিক্ষা, দাওয়াহ, মানবকল্যাণ',
                'og_image' => 'images/hero.webp',
            ],
            [
                'slug' => 'about-us',
                'title_en' => 'About Us | WOTM',
                'title_bn' => 'আমাদের সম্পর্কে | WOTM',
                'subtitle_en' => 'Learn our history, mission, vision and governance',
                'subtitle_bn' => 'পরিচিতি, ভিশন, মিশন ও পরিচালনা পর্ষদ',
                'meta_title' => 'আমাদের সম্পর্কে | WOTM - উম্মাহর স্বার্থে, সুন্নাহর সাথে',
                'meta_description' => 'WOTM একটি অরাজনৈতিক, অলাভজনক শিক্ষা, দাওয়াহ ও পূর্ণত মানবকল্যাণে নিবেদিত সেবামূলক সরকার-নিবন্ধিত প্রতিষ্ঠান।',
                'meta_keywords' => 'আমাদের সম্পর্কে, পরিচিতি, লক্ষ্য, ভিশন, মিশন, পরিচালনা পর্ষদ, অডিট',
                'og_image' => 'images/hero.webp',
            ],
            [
                'slug' => 'activities',
                'title_en' => 'Activities & Services | WOTM',
                'title_bn' => 'কার্যক্রমসমূহ | WOTM',
                'subtitle_en' => 'All welfare, education and relief programs',
                'subtitle_bn' => 'সকল মানবকল্যাণমূলক, শিক্ষা ও পুনর্বাসন কর্মসূচি',
                'meta_title' => 'কার্যক্রমসমূহ | WOTM',
                'meta_description' => 'WOTM পরিচালিত সকল সেবা ও উন্নয়ন প্রকল্পের বিবরণী।',
                'meta_keywords' => 'কার্যক্রম, শিক্ষা, ত্রাণ, স্বাবলম্বীকরণ, সমাজসেবা',
                'og_image' => 'images/hero.webp',
            ],
            [
                'slug' => 'gallery',
                'title_en' => 'Media Gallery | WOTM',
                'title_bn' => 'গ্যালারি | WOTM',
                'subtitle_en' => 'Images and video documentary of ongoing projects',
                'subtitle_bn' => 'মাঠপর্যায়ের চিত্র ও ভিডিও প্রামাণ্যচিত্র',
                'meta_title' => 'গ্যালারি | WOTM',
                'meta_description' => 'WOTM মাঠপর্যায়ের কার্যক্রমের ছবি ও ভিডিও গ্যালারি।',
                'meta_keywords' => 'গ্যালারি, ছবি, ভিডিও, ত্রাণ বিতরণ চিত্র',
                'og_image' => 'images/hero.webp',
            ],
            [
                'slug' => 'volunteer',
                'title_en' => 'Join Now & Volunteer Application | WOTM',
                'title_bn' => 'যুক্ত হোন ও স্বেচ্ছাসেবক আবেদন | WOTM',
                'subtitle_en' => 'Be a proud part of our humanitarian mission',
                'subtitle_bn' => 'WOTM পরিবারের একজন সম্মানিত সদস্য বা ভলান্টিয়ার হোন',
                'meta_title' => 'যুক্ত হোন | WOTM',
                'meta_description' => 'WOTM-এ স্বেচ্ছাসেবক বা সদস্য হিসেবে যুক্ত হতে ফরম পূরণ করুন।',
                'meta_keywords' => 'স্বেচ্ছাসেবক, সদস্য, যুক্ত হোন, ভলান্টিয়ার',
                'og_image' => 'images/hero.webp',
            ],
            [
                'slug' => 'blog',
                'title_en' => 'Blog & News Updates | WOTM',
                'title_bn' => 'ব্লগ ও সংবাদ | WOTM',
                'subtitle_en' => 'Articles, stories from field and official announcements',
                'subtitle_bn' => 'মাঠপর্যায়ের প্রতিবেদন, অনুপ্রেরণামূলক গল্প ও খবর',
                'meta_title' => 'ব্লগ | WOTM',
                'meta_description' => 'WOTM-এর সর্বশেষ সংবাদ, নিবন্ধ ও কার্যক্রমের প্রতিবেদন পড়ুন।',
                'meta_keywords' => 'ব্লগ, সংবাদ, প্রতিবেদন, প্রবন্ধ',
                'og_image' => 'images/hero.webp',
            ],
            [
                'slug' => 'notice',
                'title_en' => 'Notices & Circulars | WOTM',
                'title_bn' => 'নোটিশ ও বিজ্ঞপ্তি | WOTM',
                'subtitle_en' => 'Official notices, circulars and reports',
                'subtitle_bn' => 'অফিসিয়াল বিজ্ঞপ্তি, সার্কুলার ও বিবরণী',
                'meta_title' => 'নোটিশ | WOTM',
                'meta_description' => 'WOTM-এর সকল সরকারি ও প্রাতিষ্ঠানিক বিজ্ঞপ্তি ও সার্কুলার ডাউনলোড করুন।',
                'meta_keywords' => 'নোটিশ, সার্কুলার, বিজ্ঞপ্তি, অডিট রিপোর্ট',
                'og_image' => 'images/hero.webp',
            ],
            [
                'slug' => 'contact',
                'title_en' => 'Contact Us | WOTM',
                'title_bn' => 'যোগাযোগ | WOTM',
                'subtitle_en' => 'Reach out to our head office and coordinators',
                'subtitle_bn' => 'আমাদের কেন্দ্রীয় কার্যালয় ও কর্মকর্তাদের সাথে যোগাযোগ করুন',
                'meta_title' => 'যোগাযোগ | WOTM',
                'meta_description' => 'যেকোনো পরামর্শ, অনুদান বা তথ্যের জন্য WOTM-এর সাথে যোগাযোগ করুন।',
                'meta_keywords' => 'যোগাযোগ, ফোন, ঠিকানা, ইমেইল, হটলাইন',
                'og_image' => 'images/hero.webp',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
