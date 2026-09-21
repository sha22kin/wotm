@extends('layouts.frontend')

@section('meta_title', app()->getLocale() === 'en' ? 'Profile & Dashboard - WOTM' : 'প্রোফাইল ও ড্যাশবোর্ড - WOTM')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/user-profile.css?v=2.0') }}">
@endpush

@section('content')

  <!-- Hero Header -->
  <section class="pf-hero">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1 class="pf-hero-title">{{ app()->getLocale() === 'en' ? 'My Account' : 'আমার অ্যাকাউন্ট' }}</h1>
          <p class="pf-hero-sub">{{ app()->getLocale() === 'en' ? 'Manage your account information and security' : 'আপনার অ্যাকাউন্ট তথ্য ও নিরাপত্তা পরিচালনা করুন' }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Section -->
  <section class="pf-section">
    <div class="container">

      <!-- Alerts -->
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
          <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="row g-4">

        <!-- Left Sidebar: Profile Summary & Navigation -->
        <div class="col-lg-4 col-md-5 col-12">
          <div class="pf-sidebar">
            
            <!-- User Info Top with Instant Avatar Upload -->
            <div class="pf-user-top">
              <div class="pf-avatar-wrapper">
                @if($user->avatar)
                  <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="pf-avatar-img" id="sidebarAvatarImg" onerror="this.onerror=null;this.src='{{ asset('images/avatar-default.png') }}';">
                @else
                  <div class="pf-avatar-fallback" id="sidebarAvatarImg">
                    {{ mb_substr($user->name, 0, 1) }}
                  </div>
                @endif
                
                <!-- Camera Icon for Quick Avatar Update -->
                <label for="quickAvatarInput" class="pf-avatar-edit-label" title="{{ app()->getLocale() === 'en' ? 'Change Photo' : 'ছবি পরিবর্তন করুন' }}">
                  <i class="fa-solid fa-camera"></i>
                </label>
                <form id="quickAvatarForm" action="{{ route('user.profile.avatar') }}" method="POST" enctype="multipart/form-data" class="d-none">
                  @csrf
                  <input type="file" id="quickAvatarInput" name="avatar" accept="image/*" onchange="document.getElementById('quickAvatarForm').submit();">
                </form>
              </div>

              <h2 class="pf-user-name">{{ $user->name }}</h2>
              <p class="pf-user-email">{{ $user->email }}</p>
              
              <div>
                <span class="pf-badge {{ $user->isAdmin() ? 'pf-badge-admin' : '' }}">
                  {{ $user->isAdmin() ? $user->role_name : (app()->getLocale() === 'en' ? 'Member' : 'সদস্য') }}
                </span>
              </div>
            </div>

            <!-- Tab Navigation Links -->
            <ul class="pf-nav nav nav-pills flex-column" id="profileTab" role="tablist">
              <li class="pf-nav-item" role="presentation">
                <button class="pf-nav-link active" id="tab-overview-btn" data-bs-toggle="pill" data-bs-target="#tab-overview" type="button" role="tab" aria-controls="tab-overview" aria-selected="true">
                  <i class="fa-solid fa-user"></i>
                  <span>{{ app()->getLocale() === 'en' ? 'Overview' : 'ওভারভিউ' }}</span>
                </button>
              </li>
              <li class="pf-nav-item" role="presentation">
                <button class="pf-nav-link" id="tab-edit-btn" data-bs-toggle="pill" data-bs-target="#tab-edit" type="button" role="tab" aria-controls="tab-edit" aria-selected="false">
                  <i class="fa-solid fa-pen"></i>
                  <span>{{ app()->getLocale() === 'en' ? 'Edit Profile' : 'তথ্য পরিবর্তন' }}</span>
                </button>
              </li>
              <li class="pf-nav-item" role="presentation">
                <button class="pf-nav-link" id="tab-security-btn" data-bs-toggle="pill" data-bs-target="#tab-security" type="button" role="tab" aria-controls="tab-security" aria-selected="false">
                  <i class="fa-solid fa-lock"></i>
                  <span>{{ app()->getLocale() === 'en' ? 'Security' : 'পাসওয়ার্ড' }}</span>
                </button>
              </li>

              <!-- Admin Dashboard Navigation Link (Visible ONLY to Admins) -->
              @if($user->isAdmin())
                <li class="pf-nav-item">
                  <a href="{{ route('admin.dashboard') }}" class="pf-nav-link pf-nav-admin" target="_blank">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>{{ app()->getLocale() === 'en' ? 'Admin Dashboard' : 'অ্যাডমিন ড্যাশবোর্ড' }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square ms-auto pf-nav-arrow"></i>
                  </a>
                </li>
              @endif

              <li class="pf-nav-item pt-2 border-top mt-2">
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="pf-nav-link pf-nav-logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>{{ app()->getLocale() === 'en' ? 'Logout' : 'লগআউট' }}</span>
                  </button>
                </form>
              </li>
            </ul>

          </div>
        </div>

        <!-- Right Content Area -->
        <div class="col-lg-8 col-md-7 col-12">
          <div class="tab-content" id="profileTabContent">

            <!-- 1. OVERVIEW TAB -->
            <div class="tab-pane fade show active" id="tab-overview" role="tabpanel" aria-labelledby="tab-overview-btn">
              <div class="pf-content-card">
                <h3 class="pf-card-title">{{ app()->getLocale() === 'en' ? 'Account Overview' : 'অ্যাকাউন্ট ওভারভিউ' }}</h3>

                <!-- Clean Information Grid -->
                <div class="pf-info-grid">
                  <div class="pf-info-box">
                    <div class="pf-info-label">{{ app()->getLocale() === 'en' ? 'Full Name' : 'পূর্ণ নাম' }}</div>
                    <div class="pf-info-value">{{ $user->name }}</div>
                  </div>

                  <div class="pf-info-box">
                    <div class="pf-info-label">{{ app()->getLocale() === 'en' ? 'Email Address' : 'ইমেইল' }}</div>
                    <div class="pf-info-value">{{ $user->email }}</div>
                  </div>

                  <div class="pf-info-box">
                    <div class="pf-info-label">{{ app()->getLocale() === 'en' ? 'Mobile Number' : 'মোবাইল নম্বর' }}</div>
                    <div class="pf-info-value">{{ $user->phone ?: '—' }}</div>
                  </div>

                  <div class="pf-info-box">
                    <div class="pf-info-label">{{ app()->getLocale() === 'en' ? 'Account Role' : 'রোল' }}</div>
                    <div class="pf-info-value">{{ $user->isAdmin() ? $user->role_name : (app()->getLocale() === 'en' ? 'Member' : 'সদস্য') }}</div>
                  </div>

                  <div class="pf-info-box">
                    <div class="pf-info-label">{{ app()->getLocale() === 'en' ? 'Member Since' : 'নিবন্ধনের তারিখ' }}</div>
                    <div class="pf-info-value">{{ $user->created_at ? $user->created_at->format('d M, Y') : '—' }}</div>
                  </div>

                  <div class="pf-info-box">
                    <div class="pf-info-label">{{ app()->getLocale() === 'en' ? 'Status' : 'স্ট্যাটাস' }}</div>
                    <div class="pf-info-value text-success">{{ ucfirst($user->status ?? 'Active') }}</div>
                  </div>
                </div>

                <div class="d-flex gap-2">
                  <button type="button" class="btn btn-sm btn-primary" onclick="document.getElementById('tab-edit-btn').click();">
                    {{ app()->getLocale() === 'en' ? 'Edit Profile' : 'তথ্য পরিবর্তন করুন' }}
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('tab-security-btn').click();">
                    {{ app()->getLocale() === 'en' ? 'Change Password' : 'পাসওয়ার্ড পরিবর্তন' }}
                  </button>
                </div>
              </div>
            </div>

            <!-- 2. EDIT PROFILE TAB -->
            <div class="tab-pane fade" id="tab-edit" role="tabpanel" aria-labelledby="tab-edit-btn">
              <div class="pf-content-card">
                <h3 class="pf-card-title">{{ app()->getLocale() === 'en' ? 'Edit Information' : 'তথ্য পরিবর্তন' }}</h3>

                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <div class="pf-form-group">
                    <label for="inputName" class="pf-label">{{ app()->getLocale() === 'en' ? 'Full Name' : 'পূর্ণ নাম' }}</label>
                    <input type="text" name="name" id="inputName" class="pf-input" value="{{ old('name', $user->name) }}" required>
                  </div>

                  <div class="pf-form-group">
                    <label class="pf-label">{{ app()->getLocale() === 'en' ? 'Email Address' : 'ইমেইল' }}</label>
                    <input type="email" class="pf-input" value="{{ $user->email }}" disabled readonly>
                  </div>

                  <div class="pf-form-group">
                    <label for="inputPhone" class="pf-label">{{ app()->getLocale() === 'en' ? 'Mobile Number' : 'মোবাইল নম্বর' }}</label>
                    <input type="text" name="phone" id="inputPhone" class="pf-input" value="{{ old('phone', $user->phone) }}" placeholder="017xxxxxxxx">
                  </div>

                  <div class="pf-form-group">
                    <label for="inputAvatar" class="pf-label">{{ app()->getLocale() === 'en' ? 'Profile Picture' : 'প্রোফাইল ছবি' }}</label>
                    <input type="file" name="avatar" id="inputAvatar" class="pf-input" accept="image/*">
                  </div>

                  <button type="submit" class="pf-btn-submit">
                    {{ app()->getLocale() === 'en' ? 'Save Changes' : 'সংরক্ষণ করুন' }}
                  </button>
                </form>
              </div>
            </div>

            <!-- 3. SECURITY TAB -->
            <div class="tab-pane fade" id="tab-security" role="tabpanel" aria-labelledby="tab-security-btn">
              <div class="pf-content-card">
                <h3 class="pf-card-title">{{ app()->getLocale() === 'en' ? 'Change Password' : 'পাসওয়ার্ড পরিবর্তন' }}</h3>

                <form action="{{ route('user.profile.update') }}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="name" value="{{ $user->name }}">
                  <input type="hidden" name="phone" value="{{ $user->phone }}">

                  <div class="pf-form-group">
                    <label for="currPassword" class="pf-label">{{ app()->getLocale() === 'en' ? 'Current Password' : 'বর্তমান পাসওয়ার্ড' }}</label>
                    <input type="password" name="current_password" id="currPassword" class="pf-input" placeholder="••••••••" required autocomplete="current-password">
                  </div>

                  <div class="pf-form-group">
                    <label for="newPassword" class="pf-label">{{ app()->getLocale() === 'en' ? 'New Password' : 'নতুন পাসওয়ার্ড' }}</label>
                    <input type="password" name="password" id="newPassword" class="pf-input" placeholder="••••••••" required autocomplete="new-password">
                  </div>

                  <div class="pf-form-group">
                    <label for="confPassword" class="pf-label">{{ app()->getLocale() === 'en' ? 'Confirm New Password' : 'নতুন পাসওয়ার্ড নিশ্চিত করুন' }}</label>
                    <input type="password" name="password_confirmation" id="confPassword" class="pf-input" placeholder="••••••••" required autocomplete="new-password">
                  </div>

                  <button type="submit" class="pf-btn-submit">
                    {{ app()->getLocale() === 'en' ? 'Update Password' : 'পাসওয়ার্ড আপডেট করুন' }}
                  </button>
                </form>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </section>

@endsection
