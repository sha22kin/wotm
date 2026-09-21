<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $messages = ContactSubmission::latest()->paginate(15);
        return view('admin.contacts.index', compact('messages'));
    }

    public function show(ContactSubmission $contact)
    {
        $contact->update(['is_read' => true]);
        return view('admin.contacts.show', ['message' => $contact]);
    }

    public function destroy(ContactSubmission $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Message deleted successfully.');
    }
}
