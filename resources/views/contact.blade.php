@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'Contact Us - WOTM' : 'যোগাযোগ - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))
@section('body_class', 'contact-page')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/contact.css?v=1.0') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="contact-hero-section" id="contactHero">
      <img src="{{ asset('images/hero2.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="contact-hero-bg-img">
      <div class="contact-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="contact-hero-pattern-img">

      <div class="container contact-hero-container">
        <nav class="contact-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="contact-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="contact-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="contact-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Contact' : 'যোগাযোগ' }}</span>
        </nav>

        <h1 class="contact-hero-title">{{ app()->getLocale() === 'en' ? 'Contact Us' : 'যোগাযোগ' }}</h1>
      </div>
    </section>

    <!-- ========================================================================
         3. MAIN CONTENT SECTION
         ======================================================================== -->
    <section class="contact-main-section">
      <div class="container">

        <!-- TOP SECTION: Contact Form & Address Info -->
        <div class="row g-4 g-lg-5">

          <!-- Column 1: Contact Form (Left) -->
          <div class="col-lg-6 col-12">
            <div class="contact-form-wrapper">
              <h2 class="contact-section-title">{{ app()->getLocale() === 'en' ? 'Send Us a Message' : 'যোগাযোগ ফর্ম' }}</h2>

              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <form id="contactForm" class="contact-form-inner" action="{{ route('contact.store') }}" method="POST">
                @csrf

                <!-- Field 1: Your Name -->
                <div class="contact-form-group">
                  <label for="contactName" class="contact-form-label">
                    {{ app()->getLocale() === 'en' ? 'Your Name' : 'আপনার নাম' }} <span class="contact-required">*</span>
                  </label>
                  <input type="text" id="contactName" name="name" class="contact-input" placeholder="{{ app()->getLocale() === 'en' ? 'Enter your name' : 'লিখুন' }}" required>
                </div>

                <!-- Field 2: Mobile / Email -->
                <div class="contact-form-group">
                  <label for="contactContact" class="contact-form-label">
                    {{ app()->getLocale() === 'en' ? 'Phone / Email' : 'মোবাইল / ইমেইল' }} <span class="contact-required">*</span>
                  </label>
                  <input type="text" id="contactContact" name="contact" class="contact-input" placeholder="{{ app()->getLocale() === 'en' ? 'Phone or email' : 'লিখুন' }}" required>
                </div>

                <!-- Field 3: Subject -->
                <div class="contact-form-group">
                  <label for="contactSubject" class="contact-form-label">
                    {{ app()->getLocale() === 'en' ? 'Subject' : 'বিষয়' }} <span class="contact-required">*</span>
                  </label>
                  <input type="text" id="contactSubject" name="subject" class="contact-input" placeholder="{{ app()->getLocale() === 'en' ? 'Subject' : 'লিখুন' }}" required>
                </div>

                <!-- Field 4: Message -->
                <div class="contact-form-group">
                  <label for="contactMessage" class="contact-form-label">
                    {{ app()->getLocale() === 'en' ? 'Message' : 'বার্তা' }} <span class="contact-required">*</span>
                  </label>
                  <textarea id="contactMessage" name="message" class="contact-textarea" rows="4" placeholder="{{ app()->getLocale() === 'en' ? 'Your message here...' : 'লিখুন' }}" required></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="contact-submit-btn" id="contactSubmitBtn">
                  {{ app()->getLocale() === 'en' ? 'Send Message' : 'প্রেরণ করুন' }} <i class="fa-solid fa-arrow-right-long"></i>
                </button>
              </form>
            </div>
          </div>

          <!-- Column 2: Address & Google Map (Right) -->
          <div class="col-lg-6 col-12">
            <div class="contact-address-block">
              <h2 class="contact-section-title">{{ app()->getLocale() === 'en' ? 'Our Address' : 'আমাদের ঠিকানা' }}</h2>

              <!-- Embedded Google Map -->
              <div class="contact-map-container">
                <iframe
                  title="WOTM কেন্দ্রীয় কার্যালয় অবস্থান ম্যাপ"
                  class="contact-map-frame"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14606.067929420087!2d90.3654215!3d23.764571!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c09f9ba3d447%3A0x1bab862135b694b6!2sDhaka%2C%20Bangladesh!5e0!3m2!1sen!2sbd!4v1710000000000!5m2!1sen!2sbd"
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade"
                  allowfullscreen>
                </iframe>
              </div>

              <!-- Contact Information List -->
              <div class="contact-info-list">
                <!-- Phone -->
                <div class="contact-info-item">
                  <i class="fa-solid fa-phone contact-info-icon" aria-hidden="true"></i>
                  <div class="contact-info-content">
                    <span class="contact-info-title">{{ app()->getLocale() === 'en' ? 'Phone' : 'ফোন' }}</span>
                    <a href="tel:{{ App\Models\Setting::get('site_phone', '+8801700000000') }}" class="contact-info-link contact-info-text">
                      {{ App\Models\Setting::get('site_phone', '+৮৮০ ১৭০০-০০০০০০') }}
                    </a>
                  </div>
                </div>

                <!-- Address -->
                <div class="contact-info-item">
                  <i class="fa-solid fa-location-dot contact-info-icon" aria-hidden="true"></i>
                  <div class="contact-info-content">
                    <span class="contact-info-title">{{ app()->getLocale() === 'en' ? 'Address' : 'ঠিকানা' }}</span>
                    <p class="contact-info-text">
                      {{ app()->getLocale() === 'en' ? App\Models\Setting::get('site_address_en', 'House #12, Road #05, Dhanmondi, Dhaka 1209, Bangladesh.') : App\Models\Setting::get('site_address_bn', 'বাড়ি #১২, রোড #০৫, ধানমন্ডি, ঢাকা ১২০৯, বাংলাদেশ।') }}
                    </p>
                  </div>
                </div>

                <!-- Email -->
                <div class="contact-info-item">
                  <i class="fa-solid fa-envelope contact-info-icon" aria-hidden="true"></i>
                  <div class="contact-info-content">
                    <span class="contact-info-title">{{ app()->getLocale() === 'en' ? 'Email' : 'ইমেইল' }}</span>
                    <a href="mailto:{{ App\Models\Setting::get('site_email', 'info@wotmbd.org') }}" class="contact-info-link contact-info-text">
                      {{ App\Models\Setting::get('site_email', 'info@wotmbd.org') }}
                    </a>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>

        <!-- MIDDLE SECTION: Frequently Asked Questions (FAQ) -->
        <section class="contact-faq-section mt-5" aria-label="সচরাচর জিজ্ঞাসিত প্রশ্ন">
          <h2 class="contact-section-title">{{ app()->getLocale() === 'en' ? 'Frequently Asked Questions' : 'সচরাচর জিজ্ঞাসিত প্রশ্ন' }}</h2>

          <div class="row g-4">
            <!-- FAQ Category Navigation Sidebar -->
            <div class="col-lg-4 col-12">
              <nav class="contact-faq-sidebar" aria-label="প্রশ্নোত্তর ক্যাটাগরি">
                <ul class="contact-faq-nav-list" role="tablist">
                  <li class="contact-faq-nav-item" role="presentation">
                    <button type="button" class="contact-faq-nav-btn is-active" role="tab" aria-selected="true" data-category="activities">
                      {{ app()->getLocale() === 'en' ? 'Activities' : 'কার্যক্রম' }}
                    </button>
                  </li>
                  <li class="contact-faq-nav-item" role="presentation">
                    <button type="button" class="contact-faq-nav-btn" role="tab" aria-selected="false" data-category="contact">
                      {{ app()->getLocale() === 'en' ? 'Contact' : 'যোগাযোগ' }}
                    </button>
                  </li>
                  <li class="contact-faq-nav-item" role="presentation">
                    <button type="button" class="contact-faq-nav-btn" role="tab" aria-selected="false" data-category="donation">
                      {{ app()->getLocale() === 'en' ? 'Donations' : 'দান ও যাকাত' }}
                    </button>
                  </li>
                </ul>
              </nav>
            </div>

            <!-- FAQ Accordion Items -->
            <div class="col-lg-8 col-12">
              <div class="accordion" id="faqAccordion">
                <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      {{ app()->getLocale() === 'en' ? 'How does WOTM spend its funds?' : 'WOTM কীভাবে অনুদানের অর্থ ব্যয় করে?' }}
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                      {{ app()->getLocale() === 'en' 
                          ? 'WOTM spends funds directly on designated charitable projects including education, emergency relief, livelihood empowerment and dawah with complete chartered accountant audit.' 
                          : 'WOTM-এর প্রতিটি তহবিল নির্ধারিত খাতে সরাসরি ব্যয়িত হয়। শিক্ষা, জরুরি ত্রাণ, স্বাবলম্বীকরণ ও দাওয়াহ কার্যক্রমে ব্যয়িত অর্থের বার্ষিক স্বচ্ছ নিরীক্ষা চার্টার্ড অ্যাকাউন্টেন্ট ফার্ম দ্বারা সম্পন্ন করা হয়।' }}
                    </div>
                  </div>
                </div>

                <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      {{ app()->getLocale() === 'en' ? 'Are donations tax-exempted?' : 'অনুদানে কি শতভাগ কর রেয়াত পাওয়া যায়?' }}
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                      {{ app()->getLocale() === 'en' 
                          ? 'Yes, WOTM is a government-registered institution and donations are 100% tax exempted under NBR statutory orders.' 
                          : 'হ্যাঁ, জাতীয় রাজস্ব বোর্ড (NBR) এর প্রজ্ঞাপন অনুযায়ী WOTM সরকার-নিবন্ধিত অনুমোদিত মানবকল্যাণ সংস্থা হওয়ায় যেকোনো দান শতভাগ কর রেয়াতযোগ্য এবং ডিজিটাল ই-মানিরিসিট তাৎক্ষণিক দেওয়া হয়।' }}
                    </div>
                  </div>
                </div>

                <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      {{ app()->getLocale() === 'en' ? 'How can I become a volunteer?' : 'আমি কীভাবে স্বেচ্ছাসেবক হিসেবে যুক্ত হতে পারি?' }}
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                      {{ app()->getLocale() === 'en' 
                          ? 'You can register online through our volunteer page. Our team will contact you based on your location and interest.' 
                          : 'আমাদের ওয়েবসাইটের "যুক্ত হোন" অথবা "স্বেচ্ছাসেবক" পেজে গিয়ে সহজ অনলাইন ফরমটি পূরণ করুন। আমাদের জেলা সমন্বয়কারী আপনার সাথে দ্রুত যোগাযোগ করবেন।' }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>
    </section>

@endsection
