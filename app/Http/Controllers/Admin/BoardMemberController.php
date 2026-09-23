<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BoardMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = BoardMember::query();

        if ($request->filled('type') && in_array($request->type, ['chairman', 'director', 'advisor'])) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name_en', 'like', "%{$s}%")
                  ->orWhere('name_bn', 'like', "%{$s}%")
                  ->orWhere('designation_en', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        $members = $query->orderBy('order', 'asc')->orderBy('id', 'asc')->paginate(20)->withQueryString();

        $counts = [
            'all' => BoardMember::count(),
            'chairman' => BoardMember::where('type', 'chairman')->count(),
            'director' => BoardMember::where('type', 'director')->count(),
            'advisor' => BoardMember::where('type', 'advisor')->count(),
        ];
        $type = $request->get('type', 'all');
        $search = $request->get('search', '');

        return view('admin.board_members.index', compact('members', 'counts', 'type', 'search'));
    }

    public function create()
    {
        $maxOrder = BoardMember::max('order') ?? 0;
        $nextOrder = $maxOrder + 1;
        return view('admin.board_members.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'nullable|string|max:255',
            'designation_en' => 'required|string|max:255',
            'designation_bn' => 'nullable|string|max:255',
            'type' => 'required|in:chairman,director,advisor',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'bio_en' => 'nullable|string',
            'bio_bn' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['name_bn'] = $validated['name_bn'] ?: $validated['name_en'];
        $validated['designation_bn'] = $validated['designation_bn'] ?: $validated['designation_en'];
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $socialLinks = $request->input('social_links', []);
        $validated['social_facebook'] = !empty($socialLinks['facebook']) ? trim($socialLinks['facebook']) : null;
        $validated['social_linkedin'] = !empty($socialLinks['linkedin']) ? trim($socialLinks['linkedin']) : null;
        $validated['social_twitter'] = !empty($socialLinks['twitter']) ? trim($socialLinks['twitter']) : null;
        $validated['social_instagram'] = !empty($socialLinks['instagram']) ? trim($socialLinks['instagram']) : null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/members', 'public');
            $validated['image'] = 'storage/' . $path;

            try {
                $destDir = public_path('storage/uploads/members');
                if (!file_exists($destDir)) {
                    @mkdir($destDir, 0755, true);
                }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {
                // Ignore fallback copy error
            }
        }

        BoardMember::create($validated);

        return redirect()->route('admin.board-members.index')
            ->with('success', 'Member added successfully.');
    }

    public function edit(BoardMember $boardMember)
    {
        $member = $boardMember;
        return view('admin.board_members.edit', compact('member', 'boardMember'));
    }

    public function update(Request $request, BoardMember $boardMember)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'nullable|string|max:255',
            'designation_en' => 'required|string|max:255',
            'designation_bn' => 'nullable|string|max:255',
            'type' => 'required|in:chairman,director,advisor',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'bio_en' => 'nullable|string',
            'bio_bn' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['name_bn'] = $validated['name_bn'] ?: $validated['name_en'];
        $validated['designation_bn'] = $validated['designation_bn'] ?: $validated['designation_en'];
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? $boardMember->order;

        $socialLinks = $request->input('social_links', []);
        $validated['social_facebook'] = !empty($socialLinks['facebook']) ? trim($socialLinks['facebook']) : null;
        $validated['social_linkedin'] = !empty($socialLinks['linkedin']) ? trim($socialLinks['linkedin']) : null;
        $validated['social_twitter'] = !empty($socialLinks['twitter']) ? trim($socialLinks['twitter']) : null;
        $validated['social_instagram'] = !empty($socialLinks['instagram']) ? trim($socialLinks['instagram']) : null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/members', 'public');
            $validated['image'] = 'storage/' . $path;

            try {
                $destDir = public_path('storage/uploads/members');
                if (!file_exists($destDir)) {
                    @mkdir($destDir, 0755, true);
                }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {
                // Ignore fallback copy error
            }
        }

        $boardMember->update($validated);

        return redirect()->route('admin.board-members.index')
            ->with('success', 'Member details updated successfully.');
    }

    public function destroy(BoardMember $boardMember)
    {
        $boardMember->delete();
        return redirect()->route('admin.board-members.index')
            ->with('success', 'Member deleted successfully.');
    }
}
