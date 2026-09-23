<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::orderByRaw('COALESCE(notice_date, DATE(created_at)) DESC')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'notice_number' => 'nullable|string|max:100',
            'notice_date' => 'nullable|date',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'is_pinned' => 'nullable',
            'is_active' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:20480',
        ], [
            'file.mimes' => 'সংযুক্তি অবশ্যই PDF, DOC, DOCX, PNG অথবা JPG ফরম্যাটের হতে হবে।',
            'file.max' => 'সংযুক্ত ফাইলের সাইজ সর্বোচ্চ ২০ মেগাবাইট (20MB) হতে পারবে।',
        ]);

        if (empty($validated['title_en']) && empty($validated['title_bn'])) {
            return redirect()->back()->withInput()->withErrors([
                'title_en' => 'নোটিশের অন্তত একটি শিরোনাম (বাংলা বা ইংরেজি) আবশ্যক।',
            ]);
        }

        $validated['title_en'] = !empty($validated['title_en']) ? $validated['title_en'] : $validated['title_bn'];
        $validated['title_bn'] = !empty($validated['title_bn']) ? $validated['title_bn'] : $validated['title_en'];
        $validated['description_en'] = !empty($validated['description_en']) ? $validated['description_en'] : ($validated['description_bn'] ?? null);
        $validated['description_bn'] = !empty($validated['description_bn']) ? $validated['description_bn'] : ($validated['description_en'] ?? null);
        $validated['notice_date'] = !empty($validated['notice_date']) ? $validated['notice_date'] : now()->format('Y-m-d');
        $validated['is_pinned'] = $request->has('is_pinned');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'pdf');
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $path = $file->storeAs('uploads/notices', $filename, 'public');
            $validated['file_path'] = 'storage/' . $path;
            $validated['file_type'] = strtoupper($ext);
            $bytes = $file->getSize();
            $validated['file_size'] = $bytes > 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 0) . ' KB';

            try {
                $destDir = public_path('storage/uploads/notices');
                if (!file_exists($destDir)) {
                    @mkdir($destDir, 0755, true);
                }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {}
        }

        Notice::create($validated);

        return redirect()->route('admin.notices.index')->with('success', 'নোটিশ সফলভাবে তৈরি হয়েছে।');
    }

    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'notice_number' => 'nullable|string|max:100',
            'notice_date' => 'nullable|date',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'is_pinned' => 'nullable',
            'is_active' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:20480',
        ], [
            'file.mimes' => 'সংযুক্তি অবশ্যই PDF, DOC, DOCX, PNG অথবা JPG ফরম্যাটের হতে হবে।',
            'file.max' => 'সংযুক্ত ফাইলের সাইজ সর্বোচ্চ ২০ মেগাবাইট (20MB) হতে পারবে।',
        ]);

        if (empty($validated['title_en']) && empty($validated['title_bn'])) {
            return redirect()->back()->withInput()->withErrors([
                'title_en' => 'নোটিশের অন্তত একটি শিরোনাম (বাংলা বা ইংরেজি) আবশ্যক।',
            ]);
        }

        $validated['title_en'] = !empty($validated['title_en']) ? $validated['title_en'] : $validated['title_bn'];
        $validated['title_bn'] = !empty($validated['title_bn']) ? $validated['title_bn'] : $validated['title_en'];
        $validated['description_en'] = !empty($validated['description_en']) ? $validated['description_en'] : ($validated['description_bn'] ?? null);
        $validated['description_bn'] = !empty($validated['description_bn']) ? $validated['description_bn'] : ($validated['description_en'] ?? null);
        $validated['notice_date'] = !empty($validated['notice_date']) ? $validated['notice_date'] : ($notice->notice_date ? $notice->notice_date->format('Y-m-d') : now()->format('Y-m-d'));
        $validated['is_pinned'] = $request->has('is_pinned');
        $validated['is_active'] = $request->has('is_active');

        // Handle attachment removal request
        if ($request->boolean('remove_file')) {
            $validated['file_path'] = null;
            $validated['file_type'] = null;
            $validated['file_size'] = null;
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'pdf');
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $path = $file->storeAs('uploads/notices', $filename, 'public');
            $validated['file_path'] = 'storage/' . $path;
            $validated['file_type'] = strtoupper($ext);
            $bytes = $file->getSize();
            $validated['file_size'] = $bytes > 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 0) . ' KB';

            try {
                $destDir = public_path('storage/uploads/notices');
                if (!file_exists($destDir)) {
                    @mkdir($destDir, 0755, true);
                }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {}
        }

        $notice->update($validated);

        return redirect()->route('admin.notices.index')->with('success', 'নোটিশ সফলভাবে আপডেট হয়েছে।');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('admin.notices.index')->with('success', 'Notice deleted successfully.');
    }
}
