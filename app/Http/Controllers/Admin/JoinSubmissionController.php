<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JoinSubmission;
use Illuminate\Http\Request;

class JoinSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = JoinSubmission::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('area')) {
            $query->where('area_of_interest', $request->area);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $submissions = $query->paginate(15)->withQueryString();

        return view('admin.joins.index', compact('submissions'));
    }

    public function show(JoinSubmission $join)
    {
        return view('admin.joins.show', ['submission' => $join]);
    }

    public function updateStatus(Request $request, JoinSubmission $join)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        $join->update($validated);

        return back()->with('success', 'Submission status updated successfully.');
    }

    public function destroy(JoinSubmission $join)
    {
        $join->delete();
        return redirect()->route('admin.joins.index')->with('success', 'Submission deleted successfully.');
    }
}
