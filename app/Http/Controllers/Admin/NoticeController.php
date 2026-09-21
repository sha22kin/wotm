<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest('notice_date')->get();
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'notice_number' => 'nullable|string|max:100',
            'notice_date' => 'required|date',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'is_pinned' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
        ]);

        $validated['is_pinned'] = $request->has('is_pinned');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads/notices', 'public');
            $validated['file_path'] = 'storage/' . $path;
            $validated['file_type'] = strtoupper($file->getClientOriginalExtension());
            $bytes = $file->getSize();
            $validated['file_size'] = $bytes > 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 0) . ' KB';
        }

        Notice::create($validated);

        return redirect()->route('admin.notices.index')->with('success', 'Notice created successfully.');
    }

    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'notice_number' => 'nullable|string|max:100',
            'notice_date' => 'required|date',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'is_pinned' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
        ]);

        $validated['is_pinned'] = $request->has('is_pinned');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads/notices', 'public');
            $validated['file_path'] = 'storage/' . $path;
            $validated['file_type'] = strtoupper($file->getClientOriginalExtension());
            $bytes = $file->getSize();
            $validated['file_size'] = $bytes > 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 0) . ' KB';
        }

        $notice->update($validated);

        return redirect()->route('admin.notices.index')->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('admin.notices.index')->with('success', 'Notice deleted successfully.');
    }
}
