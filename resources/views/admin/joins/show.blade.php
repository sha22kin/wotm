@extends('admin.layouts.app')

@section('title', 'Volunteer Application Details')
@section('page_title', 'Volunteer Application: ' . $submission->full_name)

@section('content')
<div class="row g-4">
  <div class="col-lg-8 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-id-card"></i>
          <span>Applicant Profile</span>
        </h2>
        <span class="small text-muted">Received: {{ $submission->created_at->format('F d, Y \a\t h:i A') }}</span>
      </div>
      <div class="adm-card-body">
        <div class="row g-3">
          <div class="col-md-6 col-12">
            <label class="adm-label text-muted">Full Name</label>
            <div class="fs-6 fw-semibold">{{ $submission->full_name }}</div>
          </div>

          <div class="col-md-6 col-12">
            <label class="adm-label text-muted">Contact Phone / Mobile</label>
            <div class="fs-6 fw-semibold">{{ $submission->phone }}</div>
          </div>

          <div class="col-md-6 col-12">
            <label class="adm-label text-muted">Email Address</label>
            <div class="fs-6">{{ $submission->email ?: 'Not provided' }}</div>
          </div>

          <div class="col-md-6 col-12">
            <label class="adm-label text-muted">Area of Interest</label>
            <div><span class="adm-badge adm-badge-primary fs-6">{{ ucfirst($submission->area_of_interest) }}</span></div>
          </div>

          <div class="col-md-6 col-12">
            <label class="adm-label text-muted">Educational Background</label>
            <div>{{ $submission->education ?: 'Not specified' }}</div>
          </div>

          <div class="col-md-6 col-12">
            <label class="adm-label text-muted">District / Location</label>
            <div>{{ $submission->district ?: 'Not specified' }}</div>
          </div>

          <div class="col-12 mt-3">
            <label class="adm-label text-muted">Applicant Message / Motivation</label>
            <div class="p-3 bg-light border rounded">
              {{ $submission->message ?: 'No additional message provided.' }}
            </div>
          </div>
        </div>
      </div>
      <div class="adm-card-footer">
        <a href="{{ route('admin.joins.index') }}" class="adm-btn adm-btn-outline">
          <i class="fa-solid fa-arrow-left"></i> Back to All Applications
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-sliders"></i>
          <span>Update Application Status</span>
        </h2>
      </div>
      <form action="{{ route('admin.joins.status', $submission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="status">Application Status <span class="adm-req">*</span></label>
            <select name="status" id="status" class="adm-select" required>
              <option value="pending" {{ $submission->status === 'pending' ? 'selected' : '' }}>Pending Review</option>
              <option value="reviewed" {{ $submission->status === 'reviewed' ? 'selected' : '' }}>Reviewed / Contacted</option>
              <option value="accepted" {{ $submission->status === 'accepted' ? 'selected' : '' }}>Accepted as Volunteer</option>
              <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}>Rejected / Closed</option>
            </select>
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-label" for="notes">Internal Admin Notes</label>
            <textarea name="notes" id="notes" class="adm-textarea" placeholder="Add private notes regarding this volunteer...">{{ $submission->notes }}</textarea>
          </div>
        </div>
        <div class="adm-card-footer text-end">
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Update Status
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
