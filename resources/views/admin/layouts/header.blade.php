<header class="adm-header">
  <div class="adm-header-left">
    <button type="button" class="adm-toggle-btn" id="admToggleBtn" aria-label="Toggle sidebar">
      <i class="fa-solid fa-bars"></i>
    </button>
    <h1 class="adm-page-title">@yield('page_title', 'Dashboard')</h1>
  </div>

  <div class="adm-header-right">
    <a href="{{ route('home') }}" target="_blank" class="adm-view-site-btn">
      <i class="fa-solid fa-arrow-up-right-from-square"></i>
      <span>View Website</span>
    </a>
  </div>
</header>
