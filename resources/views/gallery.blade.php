@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'Gallery - WOTM' : 'গ্যালারি - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
  <link rel="stylesheet" href="{{ asset('css/gallery.css?v=1.3') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="gallery-hero-section" id="galleryHero">
      <img src="{{ asset('images/hero2.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="gallery-hero-bg-img">
      <div class="gallery-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="gallery-hero-pattern-img">

      <div class="container gallery-hero-container">
        <nav class="gallery-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="gallery-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="gallery-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="gallery-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Gallery' : 'গ্যালারি' }}</span>
        </nav>

        <h1 class="gallery-hero-title">{{ app()->getLocale() === 'en' ? 'Media Gallery' : 'গ্যালারি' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. MAIN GALLERY SECTION (TABS, SIDEBAR, MEDIA GRID & PAGINATION)
         ====================================================================== -->
    <section class="gallery-main-section" id="galleryMain">
      <div class="container">

        <!-- Top Centered Image / Video Tabs Switcher -->
        <div class="gallery-tabs-container">
          <div class="gallery-tabs-box" role="tablist" aria-label="গ্যালারি মিডিয়া নির্বাচন">
            <button class="gallery-tab-btn is-active" id="tabImagesBtn" type="button" role="tab" aria-selected="true" aria-controls="galleryImagesPanel" data-tab="images">
              {{ app()->getLocale() === 'en' ? 'Photos' : 'ছবি' }}
            </button>
            <button class="gallery-tab-btn" id="tabVideosBtn" type="button" role="tab" aria-selected="false" aria-controls="galleryVideosPanel" data-tab="videos">
              {{ app()->getLocale() === 'en' ? 'Videos' : 'ভিডিও' }}
            </button>
          </div>
        </div>

        <!-- Main Layout Grid -->
        <div class="row g-4">

          <!-- Left Column: Gallery Categories Sidebar -->
          <div class="col-lg-3 col-md-4 col-12">
            <aside class="gallery-sidebar-card" aria-label="গ্যালারি ক্যাটাগরি">
              <div class="gallery-sidebar-header">
                <h2 class="gallery-sidebar-title">
                  <i class="fa-solid fa-layer-group"></i> {{ app()->getLocale() === 'en' ? 'Categories' : 'ক্যাটাগরি' }}
                </h2>
              </div>
              <ul class="gallery-category-list" role="tablist">
                <li class="gallery-category-item is-active" data-filter="all">
                  <button class="gallery-category-btn" type="button">
                    <span>{{ app()->getLocale() === 'en' ? 'All' : 'সবগুলো' }}</span>
                  </button>
                </li>
                @forelse($categories as $cat)
                  <li class="gallery-category-item" data-filter="{{ $cat->slug }}">
                    <button class="gallery-category-btn" type="button">
                      <span>{{ $cat->name }}</span>
                    </button>
                  </li>
                @empty
                  <li class="gallery-category-item" data-filter="tree">
                    <button class="gallery-category-btn" type="button">
                      <span>{{ app()->getLocale() === 'en' ? 'Tree Plantation' : 'বৃক্ষরোপণ' }}</span>
                    </button>
                  </li>
                  <li class="gallery-category-item" data-filter="relief">
                    <button class="gallery-category-btn" type="button">
                      <span>{{ app()->getLocale() === 'en' ? 'Relief Distribution' : 'বন্যার্তদের মধ্যে ত্রাণ বিতরণ' }}</span>
                    </button>
                  </li>
                @endforelse
              </ul>
            </aside>
          </div>

          <!-- Right Column: Media Content Area -->
          <div class="col-lg-9 col-md-8 col-12">
            <div class="gallery-content-area">

              <!-- A. PHOTO GALLERY PANEL -->
              <div class="gallery-tab-panel is-active" id="galleryImagesPanel" role="tabpanel" aria-labelledby="tabImagesBtn">
                <div class="row g-4" id="galleryImagesRow">
                  @forelse($images as $img)
                    <div class="col-md-6 col-12" data-category="{{ $img->category_slug }}">
                      <a href="{{ asset($img->image_path ?: $img->file_path) }}" class="gallery-media-card text-decoration-none d-block" data-fancybox="gallery" data-caption="{{ $img->title }}">
                        <div class="gallery-image-frame">
                          <img src="{{ asset($img->image_path ?: $img->file_path) }}" alt="{{ $img->title }}" class="gallery-card-img" loading="lazy">
                          <div class="gallery-image-overlay">
                            <span class="gallery-overlay-badge">{{ $img->category_name }}</span>
                            <h3 class="gallery-overlay-caption">{{ $img->title }}</h3>
                          </div>
                          <div class="gallery-eye-btn" aria-hidden="true">
                            <i class="fa-solid fa-eye"></i>
                          </div>
                        </div>
                      </a>
                    </div>
                  @empty
                    <!-- Default images if empty -->
                    <div class="col-md-6 col-12" data-category="tree">
                      <a href="{{ asset('12.jpeg') }}" class="gallery-media-card text-decoration-none d-block" data-fancybox="gallery" data-caption="ফলদ ও বনজ বৃক্ষরোপণ কর্মসূচি">
                        <div class="gallery-image-frame">
                          <img src="{{ asset('12.jpeg') }}" alt="বৃক্ষরোপণ কর্মসূচি" class="gallery-card-img" loading="lazy">
                          <div class="gallery-image-overlay">
                            <span class="gallery-overlay-badge">বৃক্ষরোপণ</span>
                            <h3 class="gallery-overlay-caption">ফলদ ও বনজ বৃক্ষরোপণ কর্মসূচি</h3>
                          </div>
                          <div class="gallery-eye-btn" aria-hidden="true"><i class="fa-solid fa-eye"></i></div>
                        </div>
                      </a>
                    </div>
                    <div class="col-md-6 col-12" data-category="qurbani">
                      <a href="{{ asset('3.jpeg') }}" class="gallery-media-card text-decoration-none d-block" data-fancybox="gallery" data-caption="সবার জন্য কুরবানী প্রকল্প">
                        <div class="gallery-image-frame">
                          <img src="{{ asset('3.jpeg') }}" alt="সবার জন্য কুরবানী" class="gallery-card-img" loading="lazy">
                          <div class="gallery-image-overlay">
                            <span class="gallery-overlay-badge">সবার জন্য কুরবানী</span>
                            <h3 class="gallery-overlay-caption">সবার জন্য কুরবানী প্রকল্প</h3>
                          </div>
                          <div class="gallery-eye-btn" aria-hidden="true"><i class="fa-solid fa-eye"></i></div>
                        </div>
                      </a>
                    </div>
                  @endforelse
                </div>

                <div class="gallery-empty-state d-none" id="galleryImageEmptyState">
                  <div class="gallery-empty-icon"><i class="fa-solid fa-images"></i></div>
                  <p class="gallery-empty-text">{{ app()->getLocale() === 'en' ? 'No photos found in this category.' : 'এই ক্যাটাগরিতে বর্তমানে কোনো ছবি পাওয়া যায়নি।' }}</p>
                </div>
              </div>

              <!-- B. VIDEO GALLERY PANEL -->
              <div class="gallery-tab-panel" id="galleryVideosPanel" role="tabpanel" aria-labelledby="tabVideosBtn">
                <div class="row g-4" id="galleryVideosRow">
                  @forelse($videos as $vid)
                    <div class="col-md-6 col-12" data-category="{{ $vid->category_slug }}">
                      <a href="{{ $vid->video_url }}" class="gallery-video-card text-decoration-none d-block" data-fancybox="video-gallery" data-caption="{{ $vid->title }}">
                        <div class="gallery-video-frame">
                          <img src="{{ $vid->image_path ? asset($vid->image_path) : ($vid->file_path ? asset($vid->file_path) : asset('WhatsApp Image 2026-09-07 at 12.06.17 PM.jpeg')) }}" alt="{{ $vid->title }}" class="gallery-video-thumb" loading="lazy">
                          <div class="gallery-video-play-btn"><i class="fa-solid fa-play"></i></div>
                        </div>
                        <div class="gallery-video-info">
                          <span class="gallery-video-category">{{ $vid->category_name }}</span>
                          <h3 class="gallery-video-title">{{ $vid->title }}</h3>
                        </div>
                      </a>
                    </div>
                  @empty
                    <div class="col-md-6 col-12" data-category="qurbani">
                      <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="gallery-video-card text-decoration-none d-block" data-fancybox="video-gallery" data-caption="সবার জন্য কুরবানী কার্যক্রমের প্রামাণ্যচিত্র">
                        <div class="gallery-video-frame">
                          <img src="{{ asset('WhatsApp Image 2026-09-07 at 12.06.17 PM.jpeg') }}" alt="কুরবানী প্রামাণ্যচিত্র" class="gallery-video-thumb" loading="lazy">
                          <div class="gallery-video-play-btn"><i class="fa-solid fa-play"></i></div>
                        </div>
                        <div class="gallery-video-info">
                          <span class="gallery-video-category">সবার জন্য কুরবানী</span>
                          <h3 class="gallery-video-title">সবার জন্য কুরবানী কার্যক্রমের প্রামাণ্যচিত্র</h3>
                        </div>
                      </a>
                    </div>
                  @endforelse
                </div>

                <div class="gallery-empty-state d-none" id="galleryVideoEmptyState">
                  <div class="gallery-empty-icon"><i class="fa-solid fa-film"></i></div>
                  <p class="gallery-empty-text">{{ app()->getLocale() === 'en' ? 'No videos found in this category.' : 'এই ক্যাটাগরিতে বর্তমানে কোনো ভিডিও পাওয়া যায়নি।' }}</p>
                </div>
              </div>

              <!-- C. DYNAMIC PAGINATION -->
              <nav class="gallery-pagination-wrapper" aria-label="গ্যালারি পেজিনেশন" id="galleryPagination">
                <ul class="gallery-pagination-list" id="paginationList"></ul>
              </nav>

            </div>
          </div>

        </div>
      </div>
    </section>

@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
  <script>
    (function () {
      'use strict';

      if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox="gallery"]', {
          loop: true,
          protect: true,
          Wheel: false,
          Thumbs: { autoStart: true },
          Toolbar: {
            display: {
              left: ['infobar'],
              middle: ['zoomIn', 'zoomOut', 'toggle1to1', 'rotateCCW', 'rotateCW', 'flipX', 'flipY'],
              right: ['slideshow', 'thumbs', 'close'],
            },
          },
        });

        Fancybox.bind('[data-fancybox="video-gallery"]', {
          loop: true,
          Wheel: false,
          Toolbar: { display: { right: ['close'] } },
        });
      }

      const tabImagesBtn = document.getElementById('tabImagesBtn');
      const tabVideosBtn = document.getElementById('tabVideosBtn');
      const galleryImagesPanel = document.getElementById('galleryImagesPanel');
      const galleryVideosPanel = document.getElementById('galleryVideosPanel');

      const ITEMS_PER_PAGE = 6;
      let currentPage = 1;
      let currentFilter = 'all';

      function switchTab(target) {
        if (target === 'images') {
          tabImagesBtn.classList.add('is-active');
          tabImagesBtn.setAttribute('aria-selected', 'true');
          tabVideosBtn.classList.remove('is-active');
          tabVideosBtn.setAttribute('aria-selected', 'false');
          galleryImagesPanel.classList.add('is-active');
          galleryVideosPanel.classList.remove('is-active');
        } else {
          tabVideosBtn.classList.add('is-active');
          tabVideosBtn.setAttribute('aria-selected', 'true');
          tabImagesBtn.classList.remove('is-active');
          tabImagesBtn.setAttribute('aria-selected', 'false');
          galleryVideosPanel.classList.add('is-active');
          galleryImagesPanel.classList.remove('is-active');
        }
        currentPage = 1;
        updateGallery();
      }

      tabImagesBtn.addEventListener('click', () => switchTab('images'));
      tabVideosBtn.addEventListener('click', () => switchTab('videos'));

      const categoryItems = document.querySelectorAll('.gallery-category-item');
      categoryItems.forEach(item => {
        item.addEventListener('click', function () {
          categoryItems.forEach(el => el.classList.remove('is-active'));
          this.classList.add('is-active');
          currentFilter = this.getAttribute('data-filter') || 'all';
          currentPage = 1;
          updateGallery();
        });
      });

      const paginationList = document.getElementById('paginationList');
      const paginationWrapper = document.getElementById('galleryPagination');

      function toBengaliNumber(num) {
        const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return String(num).replace(/[0-9]/g, digit => bengaliDigits[digit]);
      }

      function updateGallery() {
        const isImagesActive = galleryImagesPanel.classList.contains('is-active');
        const activeContainer = isImagesActive ? galleryImagesPanel : galleryVideosPanel;
        const allItems = Array.from(activeContainer.querySelectorAll('[data-category]'));
        const emptyState = activeContainer.querySelector('.gallery-empty-state');

        const matchingItems = allItems.filter(item => {
          const categories = item.getAttribute('data-category') || '';
          return currentFilter === 'all' || categories.split(' ').includes(currentFilter);
        });

        const totalItems = matchingItems.length;
        const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE) || 1;
        if (currentPage > totalPages) currentPage = totalPages;

        const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
        const endIndex = startIndex + ITEMS_PER_PAGE;

        allItems.forEach(item => item.classList.add('d-none'));
        matchingItems.forEach((item, index) => {
          if (index >= startIndex && index < endIndex) {
            item.classList.remove('d-none');
          }
        });

        if (emptyState) {
          if (totalItems === 0) {
            emptyState.classList.remove('d-none');
          } else {
            emptyState.classList.add('d-none');
          }
        }

        renderPagination(totalPages);
      }

      function renderPagination(totalPages) {
        if (totalPages <= 1) {
          paginationWrapper.classList.add('d-none');
          paginationList.innerHTML = '';
          return;
        }

        paginationWrapper.classList.remove('d-none');
        let html = '';
        const isPrevDisabled = currentPage === 1 ? 'disabled' : '';
        html += `
          <li class="gallery-page-item">
            <button class="gallery-page-btn prev-btn ${isPrevDisabled}" type="button" aria-label="পূর্ববর্তী" data-page="${currentPage - 1}">
              <i class="fa-solid fa-chevron-left"></i> <span>পূর্ববর্তী</span>
            </button>
          </li>
        `;

        for (let i = 1; i <= totalPages; i++) {
          const isActive = i === currentPage ? 'is-active' : '';
          html += `
            <li class="gallery-page-item">
              <button class="gallery-page-btn ${isActive}" type="button" data-page="${i}">
                ${toBengaliNumber(i)}
              </button>
            </li>
          `;
        }

        const isNextDisabled = currentPage === totalPages ? 'disabled' : '';
        html += `
          <li class="gallery-page-item">
            <button class="gallery-page-btn next-btn ${isNextDisabled}" type="button" aria-label="পরবর্তী" data-page="${currentPage + 1}">
              <span>পরবর্তী</span> <i class="fa-solid fa-chevron-right"></i>
            </button>
          </li>
        `;

        paginationList.innerHTML = html;

        paginationList.querySelectorAll('.gallery-page-btn:not(.disabled)').forEach(btn => {
          btn.addEventListener('click', function () {
            const pageNum = parseInt(this.getAttribute('data-page'), 10);
            if (!isNaN(pageNum) && pageNum >= 1 && pageNum <= totalPages) {
              currentPage = pageNum;
              updateGallery();
            }
          });
        });
      }

      updateGallery();
    })();
  </script>
@endpush
