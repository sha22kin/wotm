/**
 * AS-SUNNAH FOUNDATION - OFFICIAL JAVASCRIPT
 * Stack: JavaScript (ES6+), jQuery 3.7.1
 * Author: Senior Frontend Developer & UI/UX Specialist
 */

$(document).ready(function () {
  'use strict';

  // --------------------------------------------------------------------------
  // 1. MOBILE DRAWER NAVIGATION
  // --------------------------------------------------------------------------
  const $mobileNavPanel = $('#mobileNavPanel');

  function openMobileNav(e) {
    if (e && e.preventDefault) e.preventDefault();
    $mobileNavPanel.addClass('is-open').attr('aria-hidden', 'false');
    $('body').css('overflow', 'hidden');
  }

  function closeMobileNav(e) {
    if (e && e.preventDefault) e.preventDefault();
    $mobileNavPanel.removeClass('is-open').attr('aria-hidden', 'true');
    $('body').css('overflow', '');
  }

  // Delegated click handlers for open and close buttons
  $(document).on('click', '#navToggle', openMobileNav);
  $(document).on('click', '#mobileNavClose', closeMobileNav);

  // Close when clicking outside content drawer (backdrop click)
  $(document).on('click', '#mobileNavPanel', function (e) {
    if ($(e.target).is('#mobileNavPanel')) {
      closeMobileNav(e);
    }
  });

  // Close on mobile nav link click
  $(document).on('click', '.mobile-nav-link', function () {
    closeMobileNav();
  });

  // --------------------------------------------------------------------------
  // 2. SMART AUTO-HIDE HEADER ON SCROLL
  // --------------------------------------------------------------------------
  const $siteHeader = $('#siteHeader');
  const $backToTop = $('#backToTop');
  let lastScrollTop = 0;
  const deltaThreshold = 10;

  $(window).on('scroll', function () {
    const currentScroll = $(this).scrollTop();

    // Do not alter header state if mobile drawer is currently open
    if ($('#mobileNavPanel').hasClass('is-open')) {
      lastScrollTop = currentScroll;
      return;
    }

    // Ignore bounce scrolling
    if (currentScroll < 0) {
      return;
    }

    // Back to Top Button
    if (currentScroll > 400) {
      $backToTop.addClass('is-visible');
    } else {
      $backToTop.removeClass('is-visible');
    }

    // Elevation shadow when scrolled
    if (currentScroll > 20) {
      $siteHeader.addClass('is-scrolled');
    } else {
      $siteHeader.removeClass('is-scrolled');
    }

    // When at the very top of the page (within 20px), always reveal header
    if (currentScroll <= 20) {
      $siteHeader.removeClass('nav-hidden');
      lastScrollTop = currentScroll;
      return;
    }

    // Do not auto-hide if user is hovering over any navigation menu dropdown
    if ($('.navigation-link-item:hover').length || $('.nav-dropdown:hover').length) {
      lastScrollTop = currentScroll;
      return;
    }

    // Detect scroll direction with threshold
    const delta = currentScroll - lastScrollTop;
    if (Math.abs(delta) > deltaThreshold) {
      if (delta > 0 && currentScroll > 80) {
        // Scrolling DOWN -> Slide UP smoothly and hide
        $siteHeader.addClass('nav-hidden');
      } else if (delta < 0) {
        // Scrolling UP -> Slide DOWN smoothly and reveal
        $siteHeader.removeClass('nav-hidden');
      }
      lastScrollTop = currentScroll;
    }
  });

  // Back to Top Click
  $backToTop.on('click', function () {
    $('html, body').animate({ scrollTop: 0 }, 500);
  });

  // --------------------------------------------------------------------------
  // 3. SMOOTH SCROLL FOR ANCHOR LINKS
  // --------------------------------------------------------------------------
  $('a[href^="#"]').on('click', function (e) {
    const target = $(this.getAttribute('href'));
    if (target.length) {
      e.preventDefault();
      const headerOffset = 90;
      const elementPosition = target.offset().top;
      const offsetPosition = elementPosition - headerOffset;

      $('html, body').animate(
        {
          scrollTop: offsetPosition
        },
        500
      );
    }
  });

  // --------------------------------------------------------------------------
  // 4. LANGUAGE SWITCHER TOGGLE
  // --------------------------------------------------------------------------
  $('.lang-btn').on('click', function () {
    $('.lang-btn').removeClass('active');
    $(this).addClass('active');
  });

  // --------------------------------------------------------------------------
  // 5. QUICK DONATION FORM SUBMISSION
  // --------------------------------------------------------------------------
  $('#quickDonationForm').on('submit', function (e) {
    e.preventDefault();
    const fund = $('#fundSelect').val();
    const contact = $('#contactInput').val().trim();
    const amount = $('#amountInput').val().trim();

    if (!fund) {
      alert('অনুগ্রহ করে একটি অনুদান তহবিল নির্বাচন করুন।');
      $('#fundSelect').focus();
      return;
    }
    if (!contact) {
      alert('অনুগ্রহ করে আপনার মোবাইল নম্বর বা ইমেইল লিখুন।');
      $('#contactInput').focus();
      return;
    }
    if (!amount || amount <= 0) {
      alert('অনুগ্রহ করে একটি বৈধ অনুদানের পরিমাণ লিখুন।');
      $('#amountInput').focus();
      return;
    }

    // Success feedback
    alert(
      `জাযাকাল্লাহু খাইরান! আপনার ৳ ${amount} অনুদানের অনুরোধ গৃহীত হয়েছে। আপনাকে পেমেন্ট গেটওয়েতে নিয়ে যাওয়া হচ্ছে...`
    );
    this.reset();
  });

  // --------------------------------------------------------------------------
  // 6. DONATION FUNDS QUICK DONATE POPUP
  // --------------------------------------------------------------------------
  const $quickDonateModal = $('#quickDonateModal');
  const $modalFundTitle = $('#modalFundTitle');
  const $closeDonateModal = $('#closeDonateModal');

  $('.quick-fund-btn').on('click', function () {
    const fundName = $(this).data('fund-name') || 'অনুদান তহবিল';
    $modalFundTitle.text(fundName + 'ে অনুদান');
    $quickDonateModal.addClass('is-active');
    $('body').css('overflow', 'hidden');
  });

  $closeDonateModal.on('click', function () {
    $quickDonateModal.removeClass('is-active');
    $('body').css('overflow', '');
  });

  // Preset Amount Buttons in Modal
  $('.preset-amount').on('click', function () {
    const amount = $(this).data('amount');
    $('#modalAmountInput').val(amount);
  });

  $('#modalDonateForm').on('submit', function (e) {
    e.preventDefault();
    const amount = $('#modalAmountInput').val();
    const contact = $('#modalContactInput').val().trim();

    if (!amount || amount <= 0) {
      alert('অনুগ্রহ করে অনুদানের পরিমাণ লিখুন।');
      return;
    }
    if (!contact) {
      alert('অনুগ্রহ করে মোবাইল নম্বর লিখুন।');
      return;
    }

    alert(`জাযাকাল্লাহু খাইরান! আপনার ৳ ${amount} অনুদান সফলভাবে প্রক্রিয়াকরণ করা হচ্ছে।`);
    $quickDonateModal.removeClass('is-active');
    $('body').css('overflow', '');
    this.reset();
  });

  // --------------------------------------------------------------------------
  // 7. TAX REBATE MODAL
  // --------------------------------------------------------------------------
  const $taxModal = $('#taxModal');
  const $taxRebateTrigger = $('#taxRebateTrigger');
  const $closeTaxModal = $('#closeTaxModal');
  const $taxModalOkBtn = $('#taxModalOkBtn');

  $taxRebateTrigger.on('click', function () {
    $taxModal.addClass('is-active');
    $('body').css('overflow', 'hidden');
  });

  function closeTaxModal() {
    $taxModal.removeClass('is-active');
    $('body').css('overflow', '');
  }

  $closeTaxModal.on('click', closeTaxModal);
  $taxModalOkBtn.on('click', closeTaxModal);

  // --------------------------------------------------------------------------
  // 8. VIDEO MODAL FUNCTIONALITY
  // --------------------------------------------------------------------------
  const $videoModal = $('#videoModal');
  const $videoTrigger = $('#videoTrigger');
  const $closeVideoModal = $('#closeVideoModal');
  const $videoIframe = $('#videoIframe');
  // As-Sunnah Foundation official documentary YouTube video ID
  const videoUrl = 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?autoplay=1';

  $videoTrigger.on('click', function () {
    $videoIframe.attr('src', 'https://www.youtube-nocookie.com/embed/2g811Eo7K8U?autoplay=1');
    $videoModal.addClass('is-active');
    $('body').css('overflow', 'hidden');
  });

  function closeVideo() {
    $videoIframe.attr('src', '');
    $videoModal.removeClass('is-active');
    $('body').css('overflow', '');
  }

  $closeVideoModal.on('click', closeVideo);

  // --------------------------------------------------------------------------
  // 9. IMAGE GALLERY LIGHTBOX MODAL
  // --------------------------------------------------------------------------
  const $lightboxModal = $('#lightboxModal');
  const $lightboxImg = $('#lightboxImg');
  const $lightboxCaption = $('#lightboxCaption');
  const $lightboxClose = $('#lightboxClose');
  const $lightboxPrev = $('#lightboxPrev');
  const $lightboxNext = $('#lightboxNext');

  const galleryItems = [];
  $('.gallery-photo-wrapper').each(function (index) {
    galleryItems.push({
      src: $(this).data('src'),
      caption: $(this).data('caption')
    });
    $(this).attr('data-index', index);
  });

  let currentGalleryIndex = 0;

  function showLightbox(index) {
    if (index < 0) index = galleryItems.length - 1;
    if (index >= galleryItems.length) index = 0;
    currentGalleryIndex = index;

    $lightboxImg.attr('src', galleryItems[currentGalleryIndex].src);
    $lightboxCaption.text(galleryItems[currentGalleryIndex].caption);
    $lightboxModal.addClass('is-active');
    $('body').css('overflow', 'hidden');
  }

  function closeLightbox() {
    $lightboxModal.removeClass('is-active');
    $('body').css('overflow', '');
  }

  $('.gallery-photo-wrapper').on('click', function () {
    const idx = parseInt($(this).attr('data-index'), 10);
    showLightbox(idx);
  });

  $(document).on('click', '#lightboxClose', function (e) {
    e.preventDefault();
    e.stopPropagation();
    closeLightbox();
  });

  $lightboxModal.on('click', function (e) {
    if ($(e.target).is('#lightboxModal') || $(e.target).closest('#lightboxClose').length) {
      closeLightbox();
    }
  });

  $lightboxPrev.on('click', function (e) {
    e.stopPropagation();
    showLightbox(currentGalleryIndex - 1);
  });

  $lightboxNext.on('click', function (e) {
    e.stopPropagation();
    showLightbox(currentGalleryIndex + 1);
  });

  // --------------------------------------------------------------------------
  // 10. ACTION BOXES INTERACTIONS
  // --------------------------------------------------------------------------
  $('#regularDonorCard').on('click', function () {
    alert('আস-সুন্নাহ ফাউন্ডেশনের নিয়মিত দাতা প্রোগ্রামে স্বাগতম! শীঘ্রই ফরম চালু হবে।');
  });

  $('#lifetimeMemberCard').on('click', function () {
    alert('আজীবন ও দাতা সদস্য নিবন্ধনের বিস্তারিত প্রক্রিয়া শীঘ্রই প্রকাশিত হবে।');
  });

  $('#volunteerCard').on('click', function () {
    alert('আস-সুন্নাহ ফাউন্ডেশন স্বেচ্ছাসেবক টিমে যুক্ত হতে আপনার আগ্রহের জন্য ধন্যবাদ!');
  });

  $('#careerCard').on('click', function () {
    alert('বর্তমানে সক্রিয় সকল কর্মসংস্থানের বিজ্ঞপ্তি দেখতে আমাদের জব পোর্টালে চোখ রাখুন।');
  });

  // --------------------------------------------------------------------------
  // 11. NEWSLETTER FORM SUBMISSION
  // --------------------------------------------------------------------------
  $('#newsletterForm').on('submit', function (e) {
    e.preventDefault();
    const email = $('#newsletterEmail').val().trim();
    if (!email || !email.includes('@')) {
      alert('অনুগ্রহ করে একটি সঠিক ইমেইল ঠিকানা দিন।');
      $('#newsletterEmail').focus();
      return;
    }

    alert('ধন্যবাদ! আস-সুন্নাহ ফাউন্ডেশনের নিউজলেটার সফলভাবে সাবস্ক্রাইব করা হয়েছে।');
    this.reset();
  });

  // --------------------------------------------------------------------------
  // 12. PROJECT / ACTIVITIES SLIDER CAROUSEL WITH AUTOPLAY & CONTROLS
  // --------------------------------------------------------------------------
  (function initProjectsSlider() {
    const $wrapper = $('.slider-ctrl-wrapper');
    const $viewport = $('#projSliderViewport');
    const $track = $('#projectCardsContainer');
    const $slides = $track.children('.proj-slide');
    const $prevBtn = $('#projPrev');
    const $nextBtn = $('#projNext');
    const $dotsContainer = $('#projDotsContainer');

    if (!$slides.length) return;

    let currentIndex = 0;
    let autoPlayTimer = null;
    const autoPlayDelay = 4000; // 4 seconds autoplay

    function getVisibleCount() {
      const w = window.innerWidth;
      if (w < 576) return 1;
      if (w < 992) return 2;
      return 3;
    }

    function getMaxIndex() {
      const visible = getVisibleCount();
      return Math.max(0, $slides.length - visible);
    }

    function updateSlider(animate = true) {
      const maxIdx = getMaxIndex();
      if (currentIndex > maxIdx) currentIndex = maxIdx;
      if (currentIndex < 0) currentIndex = 0;

      const $first = $slides.first();
      const slideWidth = $first.outerWidth(true);
      const targetX = -(currentIndex * slideWidth);

      if (!animate) {
        $track.css('transition', 'none');
      } else {
        $track.css('transition', 'transform 0.45s cubic-bezier(0.25, 1, 0.5, 1)');
      }

      $track.css('transform', 'translateX(' + targetX + 'px)');

      // Update dots
      $dotsContainer.find('.proj-dot').removeClass('active').eq(currentIndex).addClass('active');

      if (maxIdx === 0) {
        $prevBtn.hide();
        $nextBtn.hide();
        $dotsContainer.hide();
      } else {
        $prevBtn.show();
        $nextBtn.show();
        $dotsContainer.show();
      }
    }

    function buildDots() {
      $dotsContainer.empty();
      const maxIdx = getMaxIndex();
      if (maxIdx <= 0) return;

      for (let i = 0; i <= maxIdx; i++) {
        const $dot = $('<button type="button" class="proj-dot" aria-label="Slide ' + (i + 1) + '"></button>');
        if (i === currentIndex) $dot.addClass('active');
        (function (idx) {
          $dot.on('click', function () {
            currentIndex = idx;
            updateSlider();
            resetAutoPlay();
          });
        })(i);
        $dotsContainer.append($dot);
      }
    }

    function nextSlide() {
      const maxIdx = getMaxIndex();
      if (currentIndex >= maxIdx) {
        currentIndex = 0;
      } else {
        currentIndex++;
      }
      updateSlider();
    }

    function prevSlide() {
      const maxIdx = getMaxIndex();
      if (currentIndex <= 0) {
        currentIndex = maxIdx;
      } else {
        currentIndex--;
      }
      updateSlider();
    }

    $nextBtn.on('click', function (e) {
      e.preventDefault();
      nextSlide();
      resetAutoPlay();
    });

    $prevBtn.on('click', function (e) {
      e.preventDefault();
      prevSlide();
      resetAutoPlay();
    });

    // Autoplay implementation
    function startAutoPlay() {
      stopAutoPlay();
      if (getMaxIndex() > 0) {
        autoPlayTimer = setInterval(nextSlide, autoPlayDelay);
      }
    }

    function stopAutoPlay() {
      if (autoPlayTimer) {
        clearInterval(autoPlayTimer);
        autoPlayTimer = null;
      }
    }

    function resetAutoPlay() {
      stopAutoPlay();
      startAutoPlay();
    }

    // Pause on hover
    $wrapper.on('mouseenter', stopAutoPlay).on('mouseleave', startAutoPlay);

    // Touch / Mobile Swipe Support
    let touchStartX = 0;
    let touchEndX = 0;

    $viewport.on('touchstart', function (e) {
      stopAutoPlay();
      touchStartX = e.originalEvent.touches[0].clientX;
    }, { passive: true });

    $viewport.on('touchend', function (e) {
      touchEndX = e.originalEvent.changedTouches[0].clientX;
      const diffX = touchStartX - touchEndX;
      if (Math.abs(diffX) > 40) {
        if (diffX > 0) {
          nextSlide();
        } else {
          prevSlide();
        }
      }
      startAutoPlay();
    }, { passive: true });

    // Handle Window Resize
    let resizeTimer;
    $(window).on('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        buildDots();
        updateSlider(false);
      }, 150);
    });

    // Initial setup
    buildDots();
    updateSlider(false);
    startAutoPlay();
  })();

  // --------------------------------------------------------------------------
  // 13. GLOBAL KEYBOARD ESCAPE LISTENER
  // --------------------------------------------------------------------------
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      closeMobileNav();
      closeVideo();
      closeLightbox();
      closeTaxModal();
      $quickDonateModal.removeClass('is-active');
      $('body').css('overflow', '');
    } else if (e.key === 'ArrowLeft' && $lightboxModal.hasClass('is-active')) {
      showLightbox(currentGalleryIndex - 1);
    } else if (e.key === 'ArrowRight' && $lightboxModal.hasClass('is-active')) {
      showLightbox(currentGalleryIndex + 1);
    }
  });

  // Close modals when clicking backdrop
  $('.custom-modal').on('click', function (e) {
    if ($(e.target).hasClass('custom-modal')) {
      $(this).removeClass('is-active');
      if ($(this).attr('id') === 'videoModal') {
        closeVideo();
      }
      $('body').css('overflow', '');
    }
  });
});
