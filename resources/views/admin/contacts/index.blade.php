@extends('admin.layouts.app')

@section('title', 'Contact Inquiries')
@section('page_title', 'Contact Us Messages')

@section('content')
<div class="adm-card">
  <div class="adm-card-header">
    <h2 class="adm-card-title">
      <i class="fa-solid fa-envelope"></i>
      <span>Inbox Messages ({{ $messages->total() }})</span>
    </h2>
  </div>
  <div class="adm-table-wrapper border-0">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Sender Name</th>
          <th>Contact Info</th>
          <th>Subject</th>
          <th>Status</th>
          <th>Received Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($messages as $msg)
          <tr class="{{ !$msg->is_read ? 'fw-bold bg-light' : '' }}">
            <td>{{ $msg->name }}</td>
            <td>{{ $msg->contact }}</td>
            <td>
              <div class="adm-truncate-md">{{ $msg->subject ?: '(No Subject)' }}</div>
            </td>
            <td>
              @if($msg->is_read)
                <span class="adm-badge adm-badge-muted">Read</span>
              @else
                <span class="adm-badge adm-badge-warning"><i class="fa-solid fa-envelope me-1"></i> New</span>
              @endif
            </td>
            <td class="text-muted fw-normal">{{ $msg->created_at->format('M d, Y h:i A') }}</td>
            <td>
              <div class="d-flex gap-1">
                <a href="{{ route('admin.contacts.show', $msg->id) }}" class="adm-btn adm-btn-primary adm-btn-icon" title="Read Message">
                  <i class="fa-solid fa-envelope-open"></i>
                </a>
                <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="adm-btn adm-btn-danger adm-btn-icon" title="Delete">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <i class="fa-solid fa-inbox fs-2 mb-2 d-block"></i>
              No contact inquiries in your inbox.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($messages->hasPages())
    <div class="adm-card-footer">
      {{ $messages->links('pagination::bootstrap-5') }}
    </div>
  @endif
</div>
@endsection
