<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order', 'asc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'category' => 'required|string|max:50',
            'short_description_en' => 'nullable|string',
            'short_description_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'beneficiaries_count' => 'nullable|string|max:50',
            'districts_count' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:3072',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title_en']);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/services', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Activity / Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $service->id,
            'category' => 'required|string|max:50',
            'short_description_en' => 'nullable|string',
            'short_description_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'beneficiaries_count' => 'nullable|string|max:50',
            'districts_count' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:3072',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title_en']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/services', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Activity / Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Activity / Service deleted successfully.');
    }
}
