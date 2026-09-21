<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin Panel') | WOTM CMS</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ App\Models\Setting::getImageUrl('site_favicon', 'images/logos/logo.webp') }}">

  <!-- Bootstrap 5.3.3 Grid & Utilities -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <!-- Font Awesome 6.5.1 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Quill Rich Text Editor CSS -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <!-- Custom Admin Panel External Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/admin.css?v=1.0') }}">
  @stack('styles')
</head>
<body>

  <div class="adm-wrapper">
    <!-- Backdrop for mobile sidebar drawer -->
    <div class="adm-backdrop" id="admBackdrop"></div>

    <!-- Sidebar -->
    @include('admin.layouts.sidebar')

    <!-- Main Content Area -->
    <div class="adm-main">
      <!-- Top Navigation Header -->
      @include('admin.layouts.header')

      <!-- Content Body -->
      <main class="adm-body">
        <!-- Flash Messages -->
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
            <div>
              <strong>Please check the errors below:</strong>
              <ul class="mb-0 ps-3 mt-1">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif

        @yield('content')
      </main>

      <!-- Admin Footer -->
      <footer class="adm-footer">
        <div>&copy; {{ date('Y') }} WOTM CMS. All rights reserved.</div>
        <div>Built for high performance and clean management.</div>
      </footer>
    </div>
  </div>

  <!-- jQuery & Bootstrap 5 Bundle JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Quill Rich Text Editor JS -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

  <!-- Admin Panel Custom JS -->
  <script src="{{ asset('js/admin.js?v=1.0') }}"></script>
  @stack('scripts')
</body>
</html>
