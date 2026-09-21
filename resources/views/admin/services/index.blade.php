@extends('admin.layouts.app')

@section('title', 'Services / Activities')
@section('page_title', 'Activities & Services')

@section('content')
<div class="adm-card">
  <div class="adm-card-header">
    <h2 class="adm-card-title">
      <i class="fa-solid fa-hand-holding-heart"></i>
      <span>All Activities & Services</span>
    </h2>
    <a href="{{ route('admin.services.create') }}" class="adm-btn adm-btn-primary">
      <i class="fa-solid fa-plus"></i> Add New Activity
    </a>
  </div>
  <div class="adm-table-wrapper border-0">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Image</th>
          <th>Title (EN / BN)</th>
          <th>Category</th>
          <th>Impact Stats</th>
          <th>Order</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($services as $service)
          <tr>
            <td>
              @if($service->image)
                <img src="{{ asset($service->image) }}" alt="Thumb" class="adm-thumb">
              @else
                <div class="adm-thumb d-flex align-items-center justify-content-center text-muted">
                  <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
              @endif
            </td>
            <td>
              <div class="fw-semibold">{{ $service->title_en }}</div>
              <div class="small text-muted">{{ $service->title_bn }}</div>
            </td>
            <td>
              <span class="adm-badge adm-badge-primary">{{ ucfirst($service->category) }}</span>
            </td>
            <td>
              <div class="small"><i class="fa-solid fa-users me-1 text-muted"></i> {{ $service->beneficiaries_count ?: 'N/A' }}</div>
              <div class="small"><i class="fa-solid fa-location-dot me-1 text-muted"></i> {{ $service->districts_count ?: 'N/A' }}</div>
            </td>
            <td>{{ $service->order }}</td>
            <td>
              @if($service->is_active)
                <span class="adm-badge adm-badge-success">Active</span>
              @else
                <span class="adm-badge adm-badge-muted">Hidden</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="{{ route('activities.show', $service->slug) }}" target="_blank" class="adm-btn adm-btn-outline adm-btn-icon" title="View on site">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <a href="{{ route('admin.services.edit', $service->id) }}" class="adm-btn adm-btn-primary adm-btn-icon" title="Edit">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this activity?');">
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
            <td colspan="7" class="text-center py-5 text-muted">No activities or services created yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
