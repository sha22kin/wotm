@extends('admin.layouts.app')

@section('title', 'Posts / Blog')
@section('page_title', 'All Blog Posts')

@section('content')
<div class="adm-card mb-4">
  <div class="adm-card-body">
    <form action="{{ route('admin.posts.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-md-4 col-12">
        <input type="text" name="search" class="adm-input" placeholder="Search by post title..." value="{{ request('search') }}">
      </div>
      <div class="col-md-3 col-6">
        <select name="category_id" class="adm-select">
          <option value="">All Categories</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
              {{ $category->name_en }} ({{ $category->name_bn }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 col-6">
        <select name="status" class="adm-select">
          <option value="">All Statuses</option>
          <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
          <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
      </div>
      <div class="col-md-2 col-12 d-flex gap-2">
        <button type="submit" class="adm-btn adm-btn-primary w-100">
          <i class="fa-solid fa-filter"></i> Filter
        </button>
        @if(request()->anyFilled(['search', 'category_id', 'status']))
          <a href="{{ route('admin.posts.index') }}" class="adm-btn adm-btn-outline" title="Reset">
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
      <i class="fa-solid fa-newspaper"></i>
      <span>Post Articles ({{ $posts->total() }})</span>
    </h2>
    <a href="{{ route('admin.posts.create') }}" class="adm-btn adm-btn-primary">
      <i class="fa-solid fa-plus"></i> Write New Post
    </a>
  </div>
  <div class="adm-table-wrapper border-0">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Cover</th>
          <th>Title & Excerpt</th>
          <th>Category</th>
          <th>Author</th>
          <th>Status</th>
          <th>Published Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($posts as $post)
          <tr>
            <td>
              <img src="{{ $post->featured_image_url }}" alt="Thumb" class="adm-thumb" onerror="this.onerror=null;this.src='{{ asset('images/projects/featured_imam.jpg') }}';">
            </td>
            <td>
              <div class="fw-semibold adm-truncate-lg">
                {{ $post->title_en ?: $post->title_bn }}
              </div>
              <div class="small text-muted adm-truncate-lg">
                {{ $post->title_bn }}
              </div>
              @if($post->is_featured)
                <span class="adm-badge adm-badge-warning mt-1">Featured Post</span>
              @endif
            </td>
            <td>
              @if($post->category)
                <span class="adm-badge adm-badge-primary">{{ $post->category->name_en }}</span>
              @else
                <span class="text-muted small">Uncategorized</span>
              @endif
            </td>
            <td>{{ $post->author_name }}</td>
            <td>
              @if($post->status === 'published')
                <span class="adm-badge adm-badge-success">Published</span>
              @else
                <span class="adm-badge adm-badge-muted">Draft</span>
              @endif
            </td>
            <td>
              {{ $post->published_at ? $post->published_at->format('M d, Y') : '-' }}
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="adm-btn adm-btn-outline adm-btn-icon" title="View on site">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <a href="{{ route('admin.posts.edit', $post->id) }}" class="adm-btn adm-btn-primary adm-btn-icon" title="Edit">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
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
              <i class="fa-solid fa-newspaper fs-3 mb-2 d-block"></i>
              No blog posts found matching your criteria.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($posts->hasPages())
    <div class="adm-card-footer">
      {{ $posts->links('pagination::bootstrap-5') }}
    </div>
  @endif
</div>
@endsection
