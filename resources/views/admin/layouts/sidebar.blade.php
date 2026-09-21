<aside class="adm-sidebar" id="admSidebar">
  <!-- Brand Header -->
  <div class="adm-sidebar-brand">
    <a href="{{ route('admin.dashboard') }}" class="adm-brand-link">
      <img src="{{ asset(App\Models\Setting::get('site_logo', 'images/logos/logo.webp')) }}" alt="Logo" class="adm-brand-logo">
      <span>WOTM CMS</span>
    </a>
    <button type="button" class="adm-sidebar-close" id="admSidebarClose" aria-label="Close sidebar">
      <i class="fa-solid fa-xmark"></i>
    </button>
  </div>

  <!-- Menu List -->
  <ul class="adm-sidebar-menu">
    <li class="adm-sidebar-heading">Overview</li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.dashboard') }}" class="adm-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
        <i class="fa-solid fa-gauge-high"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="adm-sidebar-heading">Content</li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.pages.index') }}" class="adm-nav-link {{ request()->routeIs('admin.pages.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-file-lines"></i>
        <span>Pages & SEO</span>
      </a>
    </li>
    <li class="adm-nav-item adm-has-submenu {{ (request()->routeIs('admin.posts.*') || request()->routeIs('admin.post-categories.*')) ? 'is-open' : '' }}">
      <a href="{{ route('admin.posts.index') }}" class="adm-nav-link {{ (request()->routeIs('admin.posts.*') || request()->routeIs('admin.post-categories.*')) ? 'is-active' : '' }}">
        <i class="fa-solid fa-newspaper"></i>
        <span>Posts</span>
        <span class="adm-submenu-arrow" title="Toggle Submenu">
          <i class="fa-solid fa-chevron-down"></i>
        </span>
      </a>
      <ul class="adm-submenu">
        <li class="adm-submenu-item">
          <a href="{{ route('admin.posts.index') }}" class="adm-submenu-link {{ (request()->routeIs('admin.posts.index') || request()->routeIs('admin.posts.edit')) ? 'is-active' : '' }}">
            <i class="fa-solid fa-list"></i>
            <span>All Posts</span>
          </a>
        </li>
        <li class="adm-submenu-item">
          <a href="{{ route('admin.post-categories.index') }}" class="adm-submenu-link {{ request()->routeIs('admin.post-categories.*') ? 'is-active' : '' }}">
            <i class="fa-solid fa-folder-tree"></i>
            <span>Categories</span>
          </a>
        </li>
        <li class="adm-submenu-item">
          <a href="{{ route('admin.posts.create') }}" class="adm-submenu-link {{ request()->routeIs('admin.posts.create') ? 'is-active' : '' }}">
            <i class="fa-solid fa-plus"></i>
            <span>Add New</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.services.index') }}" class="adm-nav-link {{ request()->routeIs('admin.services.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-hand-holding-heart"></i>
        <span>Services</span>
      </a>
    </li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.notices.index') }}" class="adm-nav-link {{ request()->routeIs('admin.notices.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-bullhorn"></i>
        <span>Notices</span>
      </a>
    </li>
    <li class="adm-nav-item adm-has-submenu {{ (request()->routeIs('admin.gallery.*') || request()->routeIs('admin.gallery-categories.*')) ? 'is-open' : '' }}">
      <a href="{{ route('admin.gallery.index') }}" class="adm-nav-link {{ (request()->routeIs('admin.gallery.*') || request()->routeIs('admin.gallery-categories.*')) ? 'is-active' : '' }}">
        <i class="fa-solid fa-photo-film"></i>
        <span>Media Gallery</span>
        <span class="adm-submenu-arrow" title="Toggle Submenu">
          <i class="fa-solid fa-chevron-down"></i>
        </span>
      </a>
      <ul class="adm-submenu">
        <li class="adm-submenu-item">
          <a href="{{ route('admin.gallery.index') }}" class="adm-submenu-link {{ (request()->routeIs('admin.gallery.index') && !request()->has('category')) ? 'is-active' : '' }}">
            <i class="fa-solid fa-images"></i>
            <span>All Media</span>
          </a>
        </li>
        <li class="adm-submenu-item">
          <a href="{{ route('admin.gallery-categories.index') }}" class="adm-submenu-link {{ request()->routeIs('admin.gallery-categories.*') ? 'is-active' : '' }}">
            <i class="fa-solid fa-folder-tree"></i>
            <span>Categories</span>
          </a>
        </li>
        <li class="adm-submenu-item">
          <a href="{{ route('admin.gallery.create') }}" class="adm-submenu-link {{ request()->routeIs('admin.gallery.create') ? 'is-active' : '' }}">
            <i class="fa-solid fa-plus"></i>
            <span>Add Media</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="adm-sidebar-heading">Inbox</li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.joins.index') }}" class="adm-nav-link {{ request()->routeIs('admin.joins.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-user-plus"></i>
        <span>Volunteers</span>
        @php
          $pendingJoins = App\Models\JoinSubmission::where('status', 'pending')->count();
        @endphp
        @if($pendingJoins > 0)
          <span class="adm-nav-badge">{{ $pendingJoins }}</span>
        @endif
      </a>
    </li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.contacts.index') }}" class="adm-nav-link {{ request()->routeIs('admin.contacts.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-envelope"></i>
        <span>Messages</span>
        @php
          $unreadContacts = App\Models\ContactSubmission::where('is_read', false)->count();
        @endphp
        @if($unreadContacts > 0)
          <span class="adm-nav-badge">{{ $unreadContacts }}</span>
        @endif
      </a>
    </li>

    <li class="adm-sidebar-heading">System</li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.navigation.index') }}" class="adm-nav-link {{ request()->routeIs('admin.navigation.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-bars-staggered"></i>
        <span>Navigation</span>
      </a>
    </li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.footer.index') }}" class="adm-nav-link {{ request()->routeIs('admin.footer.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-shoe-prints"></i>
        <span>Footer</span>
      </a>
    </li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.seo.index') }}" class="adm-nav-link {{ request()->routeIs('admin.seo.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-magnifying-glass-chart"></i>
        <span>Global SEO</span>
      </a>
    </li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.social.index') }}" class="adm-nav-link {{ request()->routeIs('admin.social.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-share-nodes"></i>
        <span>Social Links</span>
      </a>
    </li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.users.index') }}" class="adm-nav-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-users-gear"></i>
        <span>Users & Roles</span>
      </a>
    </li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.settings.index') }}" class="adm-nav-link {{ request()->routeIs('admin.settings.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-sliders"></i>
        <span>General Settings</span>
      </a>
    </li>
    <li class="adm-nav-item">
      <a href="{{ route('admin.mail.index') }}" class="adm-nav-link {{ request()->routeIs('admin.mail.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-at"></i>
        <span>Mailing</span>
      </a>
    </li>
  </ul>

  <!-- Sidebar Footer -->
  <div class="adm-sidebar-footer">
    <a href="{{ route('admin.profile.index') }}" class="adm-user-brief" title="Admin Profile">
      <div class="adm-user-avatar">
        @if(auth()->user()->avatar)
          <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="adm-user-avatar-img">
        @else
          {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        @endif
      </div>
      <div>
        <div class="adm-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
        <div class="adm-user-role">{{ auth()->user()->role_name ?? 'Super Admin' }}</div>
      </div>
    </a>
    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="adm-btn-logout" title="Logout">
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
      </button>
    </form>
  </div>
</aside>
