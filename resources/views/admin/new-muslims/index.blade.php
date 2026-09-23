@extends('admin.layouts.app')

@section('title', 'Manage New Muslims (নবমুসলিম)')
@section('page_title', 'New Muslims (নবমুসলিম)')

@section('content')
<div class="adm-card">
  <div class="adm-card-header d-flex justify-content-between align-items-center">
    <h2 class="adm-card-title"><i class="fa-solid fa-list"></i> All New Muslims</h2>
    <a href="{{ route('admin.new-muslims.create') }}" class="adm-btn adm-btn-primary">
      <i class="fa-solid fa-plus"></i> Add New
    </a>
  </div>

  <div class="adm-card-body p-0">
    <div class="table-responsive">
      <table class="adm-table">
        <thead>
          <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Facebook</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($newMuslims as $person)
            <tr>
              <td>
                @if($person->photo_path)
                  <img src="{{ asset('storage/' . $person->photo_path) }}" alt="Photo" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                @else
                  <div style="width: 40px; height: 40px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-user text-muted"></i>
                  </div>
                @endif
              </td>
              <td class="fw-semibold">{{ $person->name }}</td>
              <td>{{ $person->mobile ?: '-' }}</td>
              <td>{{ $person->email ?: '-' }}</td>
              <td>
                @if($person->facebook_link)
                  <a href="{{ $person->facebook_link }}" target="_blank"><i class="fa-brands fa-facebook"></i> Profile</a>
                @else
                  -
                @endif
              </td>
              <td class="text-end">
                <a href="{{ route('admin.new-muslims.edit', $person) }}" class="adm-btn-icon adm-btn-edit" title="Edit">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <form action="{{ route('admin.new-muslims.destroy', $person) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this person?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="adm-btn-icon adm-btn-delete" title="Delete">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="adm-empty-state">
                <i class="fa-solid fa-users text-muted fs-1 mb-3"></i>
                <p>No new muslims found.</p>
                <a href="{{ route('admin.new-muslims.create') }}" class="adm-btn adm-btn-primary mt-2">Add First Entry</a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
