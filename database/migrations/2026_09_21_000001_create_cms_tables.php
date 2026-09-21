<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Modify users table if needed
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('password');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('is_admin');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
        });

        // 2. Settings table (Key-Value)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 50)->default('general');
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        // 3. Navigation Items table
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_bn');
            $table->string('url');
            $table->foreignId('parent_id')->nullable()->constrained('navigation_items')->nullOnDelete();
            $table->integer('order')->default(0);
            $table->string('target', 20)->default('_self');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Pages table
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_bn');
            $table->string('subtitle_en')->nullable();
            $table->string('subtitle_bn')->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('content_bn')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Post Categories
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bn');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Posts
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('post_categories')->nullOnDelete();
            $table->string('title_en');
            $table->string('title_bn');
            $table->string('slug')->unique();
            $table->text('excerpt_en')->nullable();
            $table->text('excerpt_bn')->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('content_bn')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('author_name')->default('WOTM');
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->boolean('is_featured')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();
        });

        // 7. Services / Activities
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_bn');
            $table->string('slug')->unique();
            $table->string('category')->default('welfare'); // education, welfare, relief, livelihood
            $table->text('short_description_en')->nullable();
            $table->text('short_description_bn')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_bn')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('beneficiaries_count')->nullable();
            $table->string('districts_count')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 8. Notices
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('notice_number')->nullable();
            $table->string('title_en');
            $table->string('title_bn');
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();
            $table->date('notice_date')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_size')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 9. Gallery Items
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('title_en')->nullable();
            $table->string('title_bn')->nullable();
            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('category')->nullable(); // relief, education, dawah, etc.
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 10. Join / Volunteer Submissions
        Schema::create('join_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('area_of_interest');
            $table->string('education')->nullable();
            $table->string('district')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 11. Contact Submissions
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->dateTime('replied_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
        Schema::dropIfExists('join_submissions');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('notices');
        Schema::dropIfExists('services');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('navigation_items');
        Schema::dropIfExists('settings');

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
