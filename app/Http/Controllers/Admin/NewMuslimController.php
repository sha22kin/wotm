<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewMuslim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewMuslimController extends Controller
{
    public function index()
    {
        $newMuslims = NewMuslim::latest()->get();
        return view('admin.new-muslims.index', compact('newMuslims'));
    }

    public function create()
    {
        return view('admin.new-muslims.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'facebook_link' => 'nullable|url|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('uploads/new_muslims', 'public');
            $validated['photo_path'] = $path;
        }

        NewMuslim::create($validated);

        return redirect()->route('admin.new-muslims.index')->with('success', 'New Muslim added successfully.');
    }

    public function edit(NewMuslim $newMuslim)
    {
        return view('admin.new-muslims.edit', compact('newMuslim'));
    }

    public function update(Request $request, NewMuslim $newMuslim)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'facebook_link' => 'nullable|url|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($newMuslim->photo_path && Storage::disk('public')->exists($newMuslim->photo_path)) {
                Storage::disk('public')->delete($newMuslim->photo_path);
            }
            $path = $request->file('photo')->store('uploads/new_muslims', 'public');
            $validated['photo_path'] = $path;
        }

        $newMuslim->update($validated);

        return redirect()->route('admin.new-muslims.index')->with('success', 'New Muslim updated successfully.');
    }

    public function destroy(NewMuslim $newMuslim)
    {
        if ($newMuslim->photo_path && Storage::disk('public')->exists($newMuslim->photo_path)) {
            Storage::disk('public')->delete($newMuslim->photo_path);
        }
        $newMuslim->delete();
        return redirect()->route('admin.new-muslims.index')->with('success', 'New Muslim deleted successfully.');
    }
}
