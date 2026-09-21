@extends('admin.layouts.app')

@section('title', 'Volunteer Submissions')
@section('page_title', 'Join Now & Volunteer Submissions')

@section('content')
<div class="adm-card mb-4">
  <div class="adm-card-body">
    <form action="{{ route('admin.joins.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-md-4 col-12">
        <input type="text" name="search" class="adm-input" placeholder="Search by name, phone or email..." value="{{ request('search') }}">
      </div>
      <div class="col-md-3 col-6">
        <select name="status" class="adm-select">
          <option value="">All Statuses</option>
          <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
          <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
          <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
      </div>
      <div class="col-md-3 col-6">
        <select name="area" class="adm-select">
          <option value="">All Interest Areas</option>
          <option value="education" {{ request('area') === 'education' ? 'selected' : '' }}>Education (শিক্ষা)</option>
          <option value="relief" {{ request('area') === 'relief' ? 'selected' : '' }}>Relief (ত্রাণ)</option>
          <option value="welfare" {{ request('area') === 'welfare' ? 'selected' : '' }}>Welfare (সেবা)</option>
          <option value="livelihood" {{ request('area') === 'livelihood' ? 'selected' : '' }}>Livelihood (স্বাবলম্বীকরণ)</option>
        </select>
      </div>
      <div class="col-md-2 col-12 d-flex gap-2">
        <button type="submit" class="adm-btn adm-btn-primary w-100">
          <i class="fa-solid fa-filter"></i> Filter
        </button>
        @if(request()->anyFilled(['search', 'status', 'area']))
          <a href="{{ route('admin.joins.index') }}" class="adm-btn adm-btn-outline" title="Reset">
            <i class="fa-solid fa-rotate-left"></i>
          </a>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="adm-card">
  <div class="adm-card-header">
    <h2 class="adm-card-title">
      <i class="fa-solid fa-user-plus"></i>
      <span>Applications Received ({{ $submissions->total() }})</span>
    </h2>
  </div>
  <div class="adm-table-wrapper border-0">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Applicant Name</th>
          <th>Contact Info</th>
          <th>Area of Interest</th>
          <th>District / Location</th>
          <th>Status</th>
          <th>Date Submitted</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($submissions as $sub)
          <tr>
            <td class="fw-semibold">{{ $sub->full_name }}</td>
            <td>
              <div><i class="fa-solid fa-phone me-1 text-muted"></i> {{ $sub->phone }}</div>
              @if($sub->email)
                <div class="small text-muted"><i class="fa-solid fa-envelope me-1"></i> {{ $sub->email }}</div>
              @endif
            </td>
            <td>
              <span class="adm-badge adm-badge-primary">{{ ucfirst($sub->area_of_interest) }}</span>
            </td>
            <td>{{ $sub->district ?: '-' }}</td>
            <td>
              @if($sub->status === 'pending')
                <span class="adm-badge adm-badge-warning">Pending</span>
              @elseif($sub->status === 'accepted')
                <span class="adm-badge adm-badge-success">Accepted</span>
              @elseif($sub->status === 'reviewed')
                <span class="adm-badge adm-badge-primary">Reviewed</span>
              @else
                <span class="adm-badge adm-badge-danger">Rejected</span>
              @endif
            </td>
            <td>{{ $sub->created_at->format('M d, Y h:i A') }}</td>
            <td>
              <div class="d-flex gap-1">
                <a href="{{ route('admin.joins.show', $sub->id) }}" class="adm-btn adm-btn-primary adm-btn-icon" title="View & Manage">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <form action="{{ route('admin.joins.destroy', $sub->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this application record?');">
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
            <td colspan="7" class="text-center py-5 text-muted">
              <i class="fa-solid fa-inbox fs-2 mb-2 d-block"></i>
              No volunteer submissions found matching your search.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($submissions->hasPages())
    <div class="adm-card-footer">
      {{ $submissions->links('pagination::bootstrap-5') }}
    </div>
  @endif
</div>
@endsection
