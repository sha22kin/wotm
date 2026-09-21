@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<!-- Primary Key Metrics Grid -->
<div class="row g-3 mb-3">
  <!-- Metric 1: Volunteers -->
  <div class="col-xl-3 col-sm-6 col-12">
    <div class="adm-stat-card is-amber">
      <div>
        <div class="adm-stat-value">{{ $stats['joins'] }}</div>
        <div class="adm-stat-label">
          Volunteers 
          @if($stats['joins_pending'] > 0)
            <span class="adm-badge adm-badge-warning ms-1">{{ $stats['joins_pending'] }} pending</span>
          @endif
        </div>
      </div>
      <div class="adm-stat-icon">
        <i class="fa-solid fa-user-plus"></i>
      </div>
    </div>
  </div>

  <!-- Metric 2: Messages -->
  <div class="col-xl-3 col-sm-6 col-12">
    <div class="adm-stat-card is-sky">
      <div>
        <div class="adm-stat-value">{{ $stats['contacts'] }}</div>
        <div class="adm-stat-label">
          Messages 
          @if($stats['contacts_unread'] > 0)
            <span class="adm-badge adm-badge-primary ms-1">{{ $stats['contacts_unread'] }} unread</span>
          @endif
        </div>
      </div>
      <div class="adm-stat-icon">
        <i class="fa-solid fa-envelope"></i>
      </div>
    </div>
  </div>

  <!-- Metric 3: Posts -->
  <div class="col-xl-3 col-sm-6 col-12">
    <div class="adm-stat-card">
      <div>
        <div class="adm-stat-value">{{ $stats['posts'] }}</div>
        <div class="adm-stat-label">Published Articles</div>
      </div>
      <div class="adm-stat-icon">
        <i class="fa-solid fa-newspaper"></i>
      </div>
    </div>
  </div>

  <!-- Metric 4: Services -->
  <div class="col-xl-3 col-sm-6 col-12">
    <div class="adm-stat-card is-yellow">
      <div>
        <div class="adm-stat-value">{{ $stats['services'] }}</div>
        <div class="adm-stat-label">Activities & Services</div>
      </div>
      <div class="adm-stat-icon">
        <i class="fa-solid fa-hand-holding-heart"></i>
      </div>
    </div>
  </div>
</div>

<!-- Clean Secondary Metrics Strip -->
<div class="adm-metrics-strip">
  <div class="adm-metric-item">
    <i class="fa-solid fa-file-lines"></i>
    <span>Pages:</span>
    <strong>{{ $stats['pages'] }}</strong>
  </div>
  <div class="adm-metric-item">
    <i class="fa-solid fa-bullhorn"></i>
    <span>Notices:</span>
    <strong>{{ $stats['notices'] }}</strong>
  </div>
  <div class="adm-metric-item">
    <i class="fa-solid fa-photo-film"></i>
    <span>Gallery:</span>
    <strong>{{ $stats['gallery'] }} items</strong>
  </div>
  <div class="adm-metric-item">
    <i class="fa-solid fa-shield-halved text-success"></i>
    <span>System Status:</span>
    <span class="adm-badge adm-badge-success">Operational</span>
  </div>
</div>

<!-- Main Tables Row -->
<div class="row g-3">
  <!-- Recent Volunteer Submissions -->
  <div class="col-lg-7 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-user-plus"></i>
          <span>Recent Volunteers</span>
        </h2>
        <a href="{{ route('admin.joins.index') }}" class="adm-btn adm-btn-outline adm-btn-sm">View All</a>
      </div>
      <div class="adm-table-wrapper border-0">
        <table class="adm-table">
          <thead>
            <tr>
              <th>Applicant</th>
              <th>Contact</th>
              <th>Area</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentJoins as $join)
              <tr>
                <td class="fw-semibold">{{ $join->full_name }}</td>
                <td>{{ $join->phone }}</td>
                <td><span class="adm-badge adm-badge-primary">{{ ucfirst($join->area_of_interest) }}</span></td>
                <td>
                  @if($join->status === 'pending')
                    <span class="adm-badge adm-badge-warning">Pending</span>
                  @elseif($join->status === 'accepted')
                    <span class="adm-badge adm-badge-success">Accepted</span>
                  @elseif($join->status === 'reviewed')
                    <span class="adm-badge adm-badge-primary">Reviewed</span>
                  @else
                    <span class="adm-badge adm-badge-danger">Rejected</span>
                  @endif
                </td>
                <td class="text-muted">{{ $join->created_at->format('M d, Y') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">No volunteer submissions yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Recent Messages & Posts Column -->
  <div class="col-lg-5 col-12">
    <!-- Recent Messages -->
    <div class="adm-card mb-3">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-envelope"></i>
          <span>Recent Messages</span>
        </h2>
        <a href="{{ route('admin.contacts.index') }}" class="adm-btn adm-btn-outline adm-btn-sm">View All</a>
      </div>
      <div class="adm-table-wrapper border-0">
        <table class="adm-table">
          <thead>
            <tr>
              <th>From</th>
              <th>Subject</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentContacts as $contact)
              <tr>
                <td class="fw-semibold">{{ $contact->name }}</td>
                <td>
                  <div class="adm-truncate-sm text-muted">{{ $contact->subject ?: '(No Subject)' }}</div>
                </td>
                <td>
                  @if($contact->is_read)
                    <span class="adm-badge adm-badge-muted">Read</span>
                  @else
                    <span class="adm-badge adm-badge-primary">New</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center py-3 text-muted">No messages received yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Quick Article Links -->
    <div class="adm-card mb-0">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-newspaper"></i>
          <span>Recent Articles</span>
        </h2>
        <a href="{{ route('admin.posts.create') }}" class="adm-btn adm-btn-primary adm-btn-sm">
          <i class="fa-solid fa-plus"></i> New
        </a>
      </div>
      <div class="adm-table-wrapper border-0">
        <table class="adm-table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Category</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentPosts as $post)
              <tr>
                <td>
                  <div class="adm-truncate-sm fw-medium">{{ $post->title_en ?: $post->title_bn }}</div>
                </td>
                <td>
                  <span class="adm-badge adm-badge-muted">{{ $post->category->name_en ?? 'General' }}</span>
                </td>
                <td>
                  @if($post->is_published)
                    <span class="adm-badge adm-badge-success">Published</span>
                  @else
                    <span class="adm-badge adm-badge-muted">Draft</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center py-3 text-muted">No articles found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
