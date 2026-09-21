@extends('admin.layouts.app')

@section('title', 'Notices')
@section('page_title', 'Notices & Circulars')

@section('content')
<div class="adm-card">
  <div class="adm-card-header">
    <h2 class="adm-card-title">
      <i class="fa-solid fa-bullhorn"></i>
      <span>All Notices & Circulars</span>
    </h2>
    <a href="{{ route('admin.notices.create') }}" class="adm-btn adm-btn-primary">
      <i class="fa-solid fa-plus"></i> New Notice
    </a>
  </div>
  <div class="adm-table-wrapper border-0">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Notice No.</th>
          <th>Title (EN / BN)</th>
          <th>Date</th>
          <th>Attachment</th>
          <th>Pinned</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($notices as $notice)
          <tr>
            <td>
              <code>{{ $notice->notice_number ?: 'N/A' }}</code>
            </td>
            <td>
              <div class="fw-semibold">{{ $notice->title_en }}</div>
              <div class="small text-muted">{{ $notice->title_bn }}</div>
            </td>
            <td>{{ $notice->notice_date ? $notice->notice_date->format('M d, Y') : '-' }}</td>
            <td>
              @if($notice->file_path)
                <a href="{{ asset($notice->file_path) }}" target="_blank" class="adm-btn adm-btn-outline adm-btn-sm">
                  <i class="fa-solid fa-file-arrow-down me-1"></i> {{ $notice->file_type ?: 'File' }} ({{ $notice->file_size ?: '' }})
                </a>
              @else
                <span class="text-muted small">No file</span>
              @endif
            </td>
            <td>
              @if($notice->is_pinned)
                <span class="adm-badge adm-badge-warning"><i class="fa-solid fa-thumbtack me-1"></i> Pinned</span>
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
            <td>
              @if($notice->is_active)
                <span class="adm-badge adm-badge-success">Published</span>
              @else
                <span class="adm-badge adm-badge-muted">Draft</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="{{ route('admin.notices.edit', $notice->id) }}" class="adm-btn adm-btn-primary adm-btn-icon" title="Edit">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('admin.notices.destroy', $notice->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this notice?');">
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
            <td colspan="7" class="text-center py-5 text-muted">No notices created yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
