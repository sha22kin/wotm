@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'Volunteer Registration - WOTM' : 'স্বেচ্ছাসেবক নিবন্ধন - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/volunteer.css?v=1.0') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="vol-hero-section" id="volHero">
      <img src="{{ asset('images/hero2.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="vol-hero-bg-img">
      <div class="vol-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="vol-hero-pattern-img">

      <div class="container vol-hero-container">
        <nav class="vol-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="vol-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="vol-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="vol-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Volunteer Registration' : 'স্বেচ্ছাসেবক নিবন্ধন' }}</span>
        </nav>

        <h1 class="vol-hero-title">{{ app()->getLocale() === 'en' ? 'Join as a Volunteer' : 'স্বেচ্ছাসেবক হিসেবে যুক্ত হোন' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. VOLUNTEER BENEFITS / HIGHLIGHTS SECTION
         ====================================================================== -->
    <section class="vol-highlights-section">
      <div class="container">
        <div class="row g-4">
          <!-- Highlight 1 -->
          <div class="col-lg-3 col-md-6 col-12">
            <div class="vol-highlight-card">
              <div class="vol-highlight-icon-box"><i class="fa-solid fa-hand-holding-heart"></i></div>
              <div>
                <h3 class="vol-highlight-title">{{ app()->getLocale() === 'en' ? 'Fieldwork Opportunity' : 'মাঠপর্যায়ে সেবার সুযোগ' }}</h3>
                <p class="vol-highlight-desc">{{ app()->getLocale() === 'en' ? 'Stand directly by vulnerable people during relief and social services.' : 'বন্যা, শীতবস্ত্র বিতরণ ও ত্রাণ কার্যক্রমে সরাসরি মানুষের পাশে দাঁড়ানোর সুযোগ।' }}</p>
              </div>
            </div>
          </div>

          <!-- Highlight 2 -->
          <div class="col-lg-3 col-md-6 col-12">
            <div class="vol-highlight-card">
              <div class="vol-highlight-icon-box"><i class="fa-solid fa-users-gear"></i></div>
              <div>
                <h3 class="vol-highlight-title">{{ app()->getLocale() === 'en' ? 'Skill & Leadership' : 'দক্ষতা ও নেতৃত্ব বিকাশ' }}</h3>
                <p class="vol-highlight-desc">{{ app()->getLocale() === 'en' ? 'Hands-on experience in teamwork, event execution and community leadership.' : 'টিমওয়ার্ক, ইভেন্ট ম্যানেজমেন্ট এবং ইতিবাচক সামাজিক নেতৃত্ব গড়ে তোলার প্রশিক্ষণ।' }}</p>
              </div>
            </div>
          </div>

          <!-- Highlight 3 -->
          <div class="col-lg-3 col-md-6 col-12">
            <div class="vol-highlight-card">
              <div class="vol-highlight-icon-box"><i class="fa-solid fa-certificate"></i></div>
              <div>
                <h3 class="vol-highlight-title">{{ app()->getLocale() === 'en' ? 'Certificate of Merit' : 'স্বীকৃতি ও সার্টিফিকেট' }}</h3>
                <p class="vol-highlight-desc">{{ app()->getLocale() === 'en' ? 'Official volunteer certificates and appreciation letters from registered NGO.' : 'সরকারি নিবন্ধিত প্রতিষ্ঠানের পক্ষ থেকে অফিশিয়াল অভিজ্ঞতা ও প্রশংসাপত্র প্রদান।' }}</p>
              </div>
            </div>
          </div>

          <!-- Highlight 4 -->
          <div class="col-lg-3 col-md-6 col-12">
            <div class="vol-highlight-card">
              <div class="vol-highlight-icon-box"><i class="fa-solid fa-kaaba"></i></div>
              <div>
                <h3 class="vol-highlight-title">{{ app()->getLocale() === 'en' ? 'Sadaqah Jariyah' : 'সাদাকায়ে জারিয়ার সাওয়াব' }}</h3>
                <p class="vol-highlight-desc">{{ app()->getLocale() === 'en' ? 'Earn immense eternal rewards by dedicating time to serving humanity in Sunnah way.' : 'সুন্নাহর আলোকে নিঃস্বার্থ মানবসেবায় সময় দিয়ে আখেরাতের অফুরন্ত নেকি অর্জন।' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         4. VOLUNTEER REGISTRATION FORM SECTION
         ====================================================================== -->
    <section class="vol-main-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-8 col-lg-10 col-12">
            <div class="vol-form-card">

              <!-- Card Header -->
              <div class="vol-card-header">
                <div class="vol-badge-icon"><i class="fa-solid fa-user-plus"></i></div>
                <h2 class="vol-card-title">{{ app()->getLocale() === 'en' ? 'Volunteer Application Form' : 'স্বেচ্ছাসেবক আবেদন ফরম' }}</h2>
                <p class="vol-card-subtitle">{{ app()->getLocale() === 'en' ? 'Fill in the form below to join our mission as an active volunteer' : 'WOTM পরিবারের একজন সম্মানিত ভলান্টিয়ার হতে নিচের ফরমটি পূরণ করুন' }}</p>
              </div>

              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <!-- Volunteer Form -->
              <form id="volunteerJoinForm" action="{{ route('volunteer.store') }}" method="POST">
                @csrf

                <!-- 1. PERSONAL INFORMATION -->
                <div class="vol-form-section-title">
                  <i class="fa-solid fa-id-card"></i> {{ app()->getLocale() === 'en' ? 'Personal Information' : 'ব্যক্তিগত তথ্য' }}
                </div>

                <div class="row g-3">
                  <!-- Full Name -->
                  <div class="col-md-6 col-12">
                    <div class="vol-form-group">
                      <label for="volFullName" class="vol-label">{{ app()->getLocale() === 'en' ? 'Full Name' : 'পূর্ণ নাম' }} <span class="req">*</span></label>
                      <div class="vol-input-wrapper">
                        <input type="text" name="full_name" class="vol-input-field" id="volFullName" placeholder="{{ app()->getLocale() === 'en' ? 'Enter full name' : 'আপনার পূর্ণ নাম লিখুন' }}" required>
                        <i class="fa-solid fa-user vol-input-icon"></i>
                      </div>
                    </div>
                  </div>

                  <!-- Mobile Number -->
                  <div class="col-md-6 col-12">
                    <div class="vol-form-group">
                      <label for="volPhone" class="vol-label">{{ app()->getLocale() === 'en' ? 'Mobile Number' : 'মোবাইল নম্বর' }} <span class="req">*</span></label>
                      <div class="vol-input-wrapper">
                        <input type="tel" name="phone" class="vol-input-field" id="volPhone" placeholder="01XXXXXXXXX" required>
                        <i class="fa-solid fa-phone vol-input-icon"></i>
                      </div>
                    </div>
                  </div>

                  <!-- Email Address -->
                  <div class="col-md-6 col-12">
                    <div class="vol-form-group">
                      <label for="volEmail" class="vol-label">{{ app()->getLocale() === 'en' ? 'Email Address' : 'ইমেইল ঠিকানা' }}</label>
                      <div class="vol-input-wrapper">
                        <input type="email" name="email" class="vol-input-field" id="volEmail" placeholder="example@mail.com">
                        <i class="fa-solid fa-envelope vol-input-icon"></i>
                      </div>
                    </div>
                  </div>

                  <!-- Location / District -->
                  <div class="col-md-6 col-12">
                    <div class="vol-form-group">
                      <label for="volDistrict" class="vol-label">{{ app()->getLocale() === 'en' ? 'District / Location' : 'বর্তমান জেলা ও থানা' }} <span class="req">*</span></label>
                      <div class="vol-input-wrapper">
                        <input type="text" name="district" class="vol-input-field" id="volDistrict" placeholder="{{ app()->getLocale() === 'en' ? 'e.g. Dhaka, Mirpur' : 'যেমন: ঢাকা, মিরপুর' }}" required>
                        <i class="fa-solid fa-location-dot vol-input-icon"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 2. LOCATION & PROFESSION -->
                <div class="vol-form-section-title">
                  <i class="fa-solid fa-graduation-cap"></i> {{ app()->getLocale() === 'en' ? 'Profession / Education' : 'পেশা ও শিক্ষা' }}
                </div>

                <div class="row g-3">
                  <div class="col-md-6 col-12">
                    <div class="vol-form-group">
                      <label for="volProfession" class="vol-label">{{ app()->getLocale() === 'en' ? 'Profession / Institution' : 'পেশা অথবা শিক্ষাপ্রতিষ্ঠান' }}</label>
                      <div class="vol-input-wrapper">
                        <input type="text" name="education" class="vol-input-field" id="volProfession" placeholder="{{ app()->getLocale() === 'en' ? 'e.g. Student / Teacher / Job' : 'যেমন: শিক্ষার্থী / শিক্ষক / চাকরিজীবী' }}">
                        <i class="fa-solid fa-graduation-cap vol-input-icon"></i>
                      </div>
                    </div>
                  </div>

                  <!-- Area of Interest -->
                  <div class="col-md-6 col-12">
                    <div class="vol-form-group">
                      <label for="volInterest" class="vol-label">{{ app()->getLocale() === 'en' ? 'Area of Interest' : 'আগ্রহের ক্ষেত্র' }} <span class="req">*</span></label>
                      <div class="vol-input-wrapper">
                        <select name="area_of_interest" class="vol-select-field" id="volInterest" required>
                          <option value="" selected disabled>{{ app()->getLocale() === 'en' ? 'Select Area' : 'ক্ষেত্র নির্বাচন করুন' }}</option>
                          <option value="relief">{{ app()->getLocale() === 'en' ? 'Emergency Relief & Disaster' : 'জরুরি ত্রাণ ও দুর্যোগ ব্যবস্থাপনা' }}</option>
                          <option value="education">{{ app()->getLocale() === 'en' ? 'Education & Dawah' : 'শিক্ষা ও দাওয়াহ কার্যক্রম' }}</option>
                          <option value="medical">{{ app()->getLocale() === 'en' ? 'Medical & Health Camp' : 'চিকিৎসা ও স্বাস্থ্যসেবা ক্যাম্প' }}</option>
                          <option value="it_media">{{ app()->getLocale() === 'en' ? 'IT, Media & Social Media' : 'আইটি, কনটেন্ট ও সামাজিক যোগাযোগমাধ্যম' }}</option>
                          <option value="field_ops">{{ app()->getLocale() === 'en' ? 'Field Operations' : 'লজিস্টিকস ও মাঠপর্যায়ের কার্যক্রম' }}</option>
                          <option value="all">{{ app()->getLocale() === 'en' ? 'Any Needed Area' : 'প্রয়োজনে যেকোনো বিভাগে' }}</option>
                        </select>
                        <i class="fa-solid fa-handshake-angle vol-input-icon"></i>
                      </div>
                    </div>
                  </div>

                  <!-- Message / Availability -->
                  <div class="col-12">
                    <div class="vol-form-group">
                      <label for="volMessage" class="vol-label">{{ app()->getLocale() === 'en' ? 'Skills or Availability Message' : 'আপনার অভিজ্ঞতা বা বক্তব্য (ঐচ্ছিক)' }}</label>
                      <textarea name="message" class="form-control" id="volMessage" rows="3" placeholder="{{ app()->getLocale() === 'en' ? 'Tell us how you would like to contribute...' : 'কীভাবে সাহায্য করতে চান সংক্ষেপে লিখুন...' }}"></textarea>
                    </div>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4 text-center">
                  <button type="submit" class="btn-solid-green px-5 py-3 fs-5" id="volSubmitBtn">
                    <i class="fa-solid fa-paper-plane me-2"></i> {{ app()->getLocale() === 'en' ? 'Submit Application' : 'আবেদন জমা দিন' }}
                  </button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
