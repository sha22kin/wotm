<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        $items = NavigationItem::with('children')
            ->whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->get();
        $parents = NavigationItem::whereNull('parent_id')->orderBy('order', 'asc')->get();
        $pages = Page::where('is_active', true)->orderBy('title_en')->get(['id', 'title_en', 'title_bn', 'slug']);
        $postCategories = PostCategory::where('is_active', true)->orderBy('name_en')->get(['id', 'name_en', 'name_bn', 'slug']);

        return view('admin.navigation.index', compact('items', 'parents', 'pages', 'postCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'order' => 'nullable|integer',
            'target' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['title_bn'])) {
            $validated['title_bn'] = $validated['title_en'];
        }
        $validated['target'] = $validated['target'] ?? '_self';
        $validated['is_active'] = $request->has('is_active');

        $parentId = $validated['parent_id'] ?? null;
        if (!isset($validated['order']) || $validated['order'] === null || (int)$validated['order'] === 0) {
            $max = NavigationItem::where('parent_id', $parentId)->max('order') ?? 0;
            $validated['order'] = $max + 1;
        }

        NavigationItem::create($validated);

        return back()->with('success', 'Menu item added successfully.');
    }

    public function edit(NavigationItem $navigation)
    {
        $navigation->load(['children' => function($q) {
            $q->orderBy('order', 'asc')->orderBy('id', 'asc');
        }]);
        $pages = Page::where('is_active', true)->orderBy('title_en')->get(['id', 'title_en', 'title_bn', 'slug']);
        $postCategories = PostCategory::where('is_active', true)->orderBy('name_en')->get(['id', 'name_en', 'name_bn', 'slug']);

        return view('admin.navigation.edit', compact('navigation', 'pages', 'postCategories'));
    }

    public function update(Request $request, NavigationItem $navigation)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'order' => 'nullable|integer',
            'target' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['title_bn'])) {
            $validated['title_bn'] = $validated['title_en'];
        }
        $validated['target'] = $validated['target'] ?? '_self';
        $validated['is_active'] = $request->has('is_active');

        $navigation->update($validated);

        return back()->with('success', 'Navigation item updated successfully.');
    }

    public function move(NavigationItem $navigation, string $direction)
    {
        $parentId = $navigation->parent_id;

        $siblings = NavigationItem::where('parent_id', $parentId)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->values();

        $currentIndex = $siblings->search(fn($item) => $item->id === $navigation->id);

        if ($currentIndex === false) {
            return back()->with('error', 'Menu item not found.');
        }

        if ($direction === 'up' && $currentIndex > 0) {
            $targetIndex = $currentIndex - 1;
            $siblings->splice($currentIndex, 1);
            $siblings->splice($targetIndex, 0, [$navigation]);

            foreach ($siblings as $idx => $item) {
                $item->update(['order' => $idx + 1]);
            }

            return back()->with('success', "'{$navigation->title_en}' moved up successfully.");
        }

        if ($direction === 'down' && $currentIndex < $siblings->count() - 1) {
            $targetIndex = $currentIndex + 1;
            $siblings->splice($currentIndex, 1);
            $siblings->splice($targetIndex, 0, [$navigation]);

            foreach ($siblings as $idx => $item) {
                $item->update(['order' => $idx + 1]);
            }

            return back()->with('success', "'{$navigation->title_en}' moved down successfully.");
        }

        return back()->with('info', 'Item is already at the limit.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:navigation_items,id',
        ]);

        foreach ($request->order as $index => $id) {
            NavigationItem::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['status' => 'success', 'message' => 'Menu order updated successfully.']);
    }

    public function destroy(NavigationItem $navigation)
    {
        $navigation->delete();
        return redirect()->route('admin.navigation.index')->with('success', 'Navigation item deleted successfully.');
    }
}
