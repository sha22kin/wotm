<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | WOTM CMS</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ App\Models\Setting::getImageUrl('site_favicon', 'images/logos/logo.webp') }}">

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Admin Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/admin.css?v=1.0') }}">
</head>
<body class="adm-login-page">

  <div class="adm-login-card">
    <div class="adm-login-brand">
      <img src="{{ App\Models\Setting::getImageUrl('site_logo', 'images/logos/logo.webp') }}" alt="Logo" class="adm-login-logo" onerror="this.onerror=null;this.src='{{ asset('images/logos/logo.webp') }}';">
      <h1 class="adm-login-title">WOTM CMS</h1>
      <p class="adm-login-subtitle">Sign in to manage website content</p>
    </div>

    @if(session('success'))
      <div class="adm-alert adm-alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @if(session('error'))
      <div class="adm-alert adm-alert-danger">
        <i class="fa-solid fa-circle-exclamation"></i>
        <span>{{ session('error') }}</span>
      </div>
    @endif

    @if($errors->any())
      <div class="adm-alert adm-alert-danger">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span>{{ $errors->first() }}</span>
      </div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST" novalidate>
      @csrf

      <div class="adm-form-group">
        <label for="email" class="adm-label">Email Address <span class="adm-req">*</span></label>
        <input type="email" name="email" id="email" class="adm-input" value="{{ old('email') }}" placeholder="admin@wotm.org" required autofocus autocomplete="username">
      </div>

      <div class="adm-form-group">
        <label for="password" class="adm-label">Password <span class="adm-req">*</span></label>
        <input type="password" name="password" id="password" class="adm-input" placeholder="••••••••" required autocomplete="current-password">
      </div>

      <div class="d-flex align-items-center justify-content-between mb-4">
        <label class="adm-switch">
          <input type="checkbox" name="remember" value="1">
          <span class="adm-switch-slider"></span>
          <span>Remember Me</span>
        </label>
      </div>

      <button type="submit" class="adm-btn adm-btn-primary w-100 py-2">
        <i class="fa-solid fa-right-to-bracket"></i>
        <span>Sign In to Dashboard</span>
      </button>
    </form>

    <div class="text-center mt-4">
      <a href="{{ route('home') }}" class="text-muted small">
        <i class="fa-solid fa-arrow-left me-1"></i> Return to Homepage
      </a>
    </div>
  </div>

</body>
</html>
