<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryItem::with('galleryCategory')->orderBy('order', 'asc')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $catSlug = $request->category;
            $query->where(function ($q) use ($catSlug) {
                $q->where('category', $catSlug)
                  ->orWhereHas('galleryCategory', function ($cq) use ($catSlug) {
                      $cq->where('slug', $catSlug);
                  });
            });
        }

        if ($request->filled('search')) {
            $s = '%' . trim($request->search) . '%';
            $query->where(function ($q) use ($s) {
                $q->where('title_en', 'like', $s)
                  ->orWhere('title_bn', 'like', $s)
                  ->orWhere('category', 'like', $s)
                  ->orWhereHas('galleryCategory', function ($cq) use ($s) {
                      $cq->where('name_en', 'like', $s)
                        ->orWhere('name_bn', 'like', $s);
                  });
            });
        }

        $items = $query->paginate(16)->withQueryString();
        $categories = GalleryCategory::where('is_active', true)->orderBy('order', 'asc')->get();

        return view('admin.gallery.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = GalleryCategory::where('is_active', true)->orderBy('order', 'asc')->get();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:image,video',
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'category' => 'nullable|string|max:50',
            'video_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image' => ($request->input('type') === 'image' ? 'required|' : 'nullable|') . 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,avif|max:10240',
        ], [
            'image.required' => 'ফটো মিডিয়ার জন্য একটি ছবি আপলোড করা আবশ্যক (Image upload is required).',
            'image.image' => 'ফাইলটি অবশ্যই একটি সঠিক ছবি (JPG, PNG, WebP) হতে হবে।',
            'image.max' => 'ছবির সাইজ সর্বোচ্চ ১০ মেগাবাইটের মধ্যে হতে হবে।',
        ]);

        $defaultTitle = $request->input('type') === 'video' ? 'Video Item' : 'Gallery Photo';
        $validated['title_en'] = $validated['title_en'] ?: ($validated['title_bn'] ?: $defaultTitle);
        $validated['title_bn'] = $validated['title_bn'] ?: $validated['title_en'];
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        if (!empty($validated['gallery_category_id'])) {
            $catObj = GalleryCategory::find($validated['gallery_category_id']);
            if ($catObj) {
                $validated['category'] = $catObj->slug;
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('uploads/gallery', $filename, 'public');
            $validated['image_path'] = 'storage/' . $path;

            // Direct fallback copy for cPanel environments where symlink may not exist
            try {
                $targetDir = public_path('storage/uploads/gallery');
                if (!file_exists($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {
                // Silently continue if copy fails
            }
        }

        GalleryItem::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery media created successfully.');
    }

    public function edit(GalleryItem $gallery)
    {
        $categories = GalleryCategory::where('is_active', true)->orderBy('order', 'asc')->get();
        return view('admin.gallery.edit', ['item' => $gallery, 'categories' => $categories]);
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $validated = $request->validate([
            'type' => 'required|in:image,video',
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'category' => 'nullable|string|max:50',
            'video_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,avif|max:10240',
        ], [
            'image.image' => 'ফাইলটি অবশ্যই একটি সঠিক ছবি (JPG, PNG, WebP) হতে হবে।',
            'image.max' => 'ছবির সাইজ সর্বোচ্চ ১০ মেগাবাইটের মধ্যে হতে হবে।',
        ]);

        $defaultTitle = $request->input('type') === 'video' ? 'Video Item' : 'Gallery Photo';
        $validated['title_en'] = $validated['title_en'] ?: ($validated['title_bn'] ?: $defaultTitle);
        $validated['title_bn'] = $validated['title_bn'] ?: $validated['title_en'];
        $validated['is_active'] = $request->has('is_active');

        if (!empty($validated['gallery_category_id'])) {
            $catObj = GalleryCategory::find($validated['gallery_category_id']);
            if ($catObj) {
                $validated['category'] = $catObj->slug;
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('uploads/gallery', $filename, 'public');
            $validated['image_path'] = 'storage/' . $path;

            // Direct fallback copy for cPanel environments where symlink may not exist
            try {
                $targetDir = public_path('storage/uploads/gallery');
                if (!file_exists($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {
                // Silently continue if copy fails
            }
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery media updated successfully.');
    }

    public function destroy(GalleryItem $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery media deleted successfully.');
    }
}
