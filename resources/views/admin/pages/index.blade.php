@extends('admin.layouts.app')

@section('title', 'Pages & SEO')
@section('page_title', 'Manage Pages & SEO')

@section('content')
<div class="adm-card">
  <div class="adm-card-header">
    <h2 class="adm-card-title">
      <i class="fa-solid fa-file-lines"></i>
      <span>All Website Pages</span>
    </h2>
  </div>
  <div class="adm-table-wrapper border-0">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Page Title (EN / BN)</th>
          <th>Slug / Route</th>
          <th>SEO Title</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pages as $page)
          <tr>
            <td>
              <div class="fw-semibold">{{ $page->title_en }}</div>
              <div class="small text-muted">{{ $page->title_bn }}</div>
            </td>
            <td>
              <code>/{{ $page->slug === 'home' ? '' : $page->slug }}</code>
            </td>
            <td class="adm-truncate-md">
              {{ $page->meta_title ?: 'Default' }}
            </td>
            <td>
              @if($page->is_active)
                <span class="adm-badge adm-badge-success">Active</span>
              @else
                <span class="adm-badge adm-badge-muted">Hidden</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.pages.edit', $page->id) }}" class="adm-btn adm-btn-primary adm-btn-sm">
                <i class="fa-solid fa-pen-to-square"></i> Edit & SEO
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
