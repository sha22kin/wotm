@extends('admin.layouts.app')

@section('title', 'Message from: ' . $message->name)
@section('page_title', 'View Contact Message')

@section('content')
<div class="adm-card">
  <div class="adm-card-header">
    <h2 class="adm-card-title">
      <i class="fa-solid fa-envelope-open-text"></i>
      <span>{{ $message->subject ?: 'Message from ' . $message->name }}</span>
    </h2>
    <span class="small text-muted">{{ $message->created_at->format('F d, Y \a\t h:i A') }}</span>
  </div>
  <div class="adm-card-body">
    <div class="row g-3 mb-4">
      <div class="col-md-6 col-12">
        <label class="adm-label text-muted">Sender Name</label>
        <div class="fs-6 fw-semibold">{{ $message->name }}</div>
      </div>
      <div class="col-md-6 col-12">
        <label class="adm-label text-muted">Contact Info (Phone / Email)</label>
        <div class="fs-6 fw-semibold">{{ $message->contact }}</div>
      </div>
    </div>

    <div class="adm-form-group">
      <label class="adm-label text-muted">Message Body</label>
      <div class="p-3 bg-light border rounded adm-msg-body">{{ $message->message }}</div>
    </div>
  </div>
  <div class="adm-card-footer d-flex justify-content-between">
    <a href="{{ route('admin.contacts.index') }}" class="adm-btn adm-btn-outline">
      <i class="fa-solid fa-arrow-left"></i> Back to Messages
    </a>
    <form action="{{ route('admin.contacts.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Delete this message permanently?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="adm-btn adm-btn-danger">
        <i class="fa-solid fa-trash"></i> Delete Message
      </button>
    </form>
  </div>
</div>
@endsection
