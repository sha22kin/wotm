@extends('admin.layouts.app')

@section('title', 'Board of Directors & Advisory Council')
@section('page_title', 'Board of Directors & Advisory Council')

@section('content')
<div class="adm-card mb-4">
  <div class="adm-card-header flex-wrap gap-3">
    <div class="d-flex align-items-center gap-2">
      <i class="fa-solid fa-users-gear text-primary fs-5"></i>
      <h2 class="adm-card-title mb-0">Management & Advisory Members</h2>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('board.directors') }}" target="_blank" class="adm-btn adm-btn-outline" title="View Frontend Page">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> View Page
      </a>
      <a href="{{ route('admin.board-members.create', ['type' => $type !== 'all' ? $type : 'director']) }}" class="adm-btn adm-btn-primary">
        <i class="fa-solid fa-user-plus"></i> Add New Member
      </a>
    </div>
  </div>

  <div class="adm-card-body pb-0">
    <!-- Filter Tabs & Search -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.board-members.index') }}" 
           class="adm-btn {{ $type === 'all' ? 'adm-btn-primary' : 'adm-btn-outline' }} btn-sm">
          All ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.board-members.index', ['type' => 'chairman']) }}" 
           class="adm-btn {{ $type === 'chairman' ? 'adm-btn-primary' : 'adm-btn-outline' }} btn-sm">
          <i class="fa-solid fa-user-tie me-1"></i> Chairman ({{ $counts['chairman'] }})
        </a>
        <a href="{{ route('admin.board-members.index', ['type' => 'director']) }}" 
           class="adm-btn {{ $type === 'director' ? 'adm-btn-primary' : 'adm-btn-outline' }} btn-sm">
          <i class="fa-solid fa-id-badge me-1"></i> Directors ({{ $counts['director'] }})
        </a>
        <a href="{{ route('admin.board-members.index', ['type' => 'advisor']) }}" 
           class="adm-btn {{ $type === 'advisor' ? 'adm-btn-primary' : 'adm-btn-outline' }} btn-sm">
          <i class="fa-solid fa-lightbulb me-1"></i> Advisors ({{ $counts['advisor'] }})
        </a>
      </div>

      <form action="{{ route('admin.board-members.index') }}" method="GET" class="d-flex gap-2">
        @if($type !== 'all')
          <input type="hidden" name="type" value="{{ $type }}">
        @endif
        <input type="text" name="search" class="adm-input py-1 px-3" style="width: 240px; font-size: 0.875rem;" 
               placeholder="Search by name, title..." value="{{ $search }}">
        @if($search)
          <a href="{{ route('admin.board-members.index', $type !== 'all' ? ['type' => $type] : []) }}" class="adm-btn adm-btn-outline py-1 px-2" title="Clear search">
            <i class="fa-solid fa-xmark"></i>
          </a>
        @endif
        <button type="submit" class="adm-btn adm-btn-outline py-1 px-3">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>
    </div>
  </div>

  <div class="adm-table-wrapper border-0">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Photo</th>
          <th>Name & Designation</th>
          <th>Role / Council</th>
          <th>Contact Channels</th>
          <th>Socials</th>
          <th>Order</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($members as $member)
          <tr>
            <td>
              <img src="{{ $member->image_url }}" alt="{{ $member->name_en }}" class="adm-thumb rounded-circle" style="width: 48px; height: 48px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset('images/avatar-placeholder.png') }}';">
            </td>
            <td>
              <div class="fw-bold text-dark">{{ $member->name_en }}</div>
              @if($member->name_bn)
                <div class="small text-muted mb-1">{{ $member->name_bn }}</div>
              @endif
              <span class="badge bg-light text-secondary border">{{ $member->designation_en }}</span>
              @if($member->designation_bn)
                <span class="small text-muted d-block mt-1">{{ $member->designation_bn }}</span>
              @endif
            </td>
            <td>
              @if($member->type === 'chairman')
                <span class="adm-badge adm-badge-warning" style="background:#fef3c7; color:#92400e; font-weight:600;">
                  <i class="fa-solid fa-crown me-1"></i> Chairman
                </span>
              @elseif($member->type === 'director')
                <span class="adm-badge adm-badge-primary">
                  <i class="fa-solid fa-id-badge me-1"></i> Board Director
                </span>
              @else
                <span class="adm-badge adm-badge-info" style="background:#e0e7ff; color:#3730a3; font-weight:600;">
                  <i class="fa-solid fa-lightbulb me-1"></i> Advisory Council
                </span>
              @endif
            </td>
            <td>
              @if($member->phone)
                <div class="small text-nowrap"><i class="fa-solid fa-phone me-1 text-primary"></i> {{ $member->phone }}</div>
              @endif
              @if($member->email)
                <div class="small text-nowrap"><i class="fa-solid fa-envelope me-1 text-muted"></i> {{ $member->email }}</div>
              @endif
              @if(!$member->phone && !$member->email)
                <span class="text-muted small">N/A</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-2">
                @if(!empty($member->social_links['facebook']))
                  <a href="{{ $member->social_links['facebook'] }}" target="_blank" class="text-primary" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
                @endif
                @if(!empty($member->social_links['linkedin']))
                  <a href="{{ $member->social_links['linkedin'] }}" target="_blank" class="text-info" title="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                @endif
                @if(!empty($member->social_links['twitter']))
                  <a href="{{ $member->social_links['twitter'] }}" target="_blank" class="text-dark" title="Twitter/X"><i class="fa-brands fa-x-twitter"></i></a>
                @endif
                @if(!empty($member->social_links['instagram']))
                  <a href="{{ $member->social_links['instagram'] }}" target="_blank" class="text-danger" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                @endif
                @if(empty($member->social_links) || count(array_filter($member->social_links)) === 0)
                  <span class="text-muted small">—</span>
                @endif
              </div>
            </td>
            <td>
              <span class="badge bg-light text-dark border">{{ $member->order }}</span>
            </td>
            <td>
              @if($member->is_active)
                <span class="adm-badge adm-badge-success">Active</span>
              @else
                <span class="adm-badge adm-badge-muted">Hidden</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="{{ route('admin.board-members.edit', $member->id) }}" class="adm-btn adm-btn-primary adm-btn-icon" title="Edit Member">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('admin.board-members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete {{ addslashes($member->name_en) }}?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="adm-btn adm-btn-danger adm-btn-icon" title="Delete Member">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center py-5 text-muted">
              <i class="fa-solid fa-users fs-1 mb-3 d-block text-secondary"></i>
              No board members found matching this criteria.
              <div class="mt-3">
                <a href="{{ route('admin.board-members.create') }}" class="adm-btn adm-btn-primary btn-sm">
                  <i class="fa-solid fa-plus"></i> Add First Member
                </a>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($members->hasPages())
    <div class="adm-card-footer">
      {{ $members->links() }}
    </div>
  @endif
</div>
@endsection
