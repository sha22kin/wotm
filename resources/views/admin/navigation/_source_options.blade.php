<optgroup label="Core Pages (ওয়েবসাইটের প্রধান পেজসমূহ)">
  <option value="home" data-title-en="Home" data-title-bn="হোম" data-url="/">Home (/)</option>
  <option value="about" data-title-en="About Us" data-title-bn="আমাদের সম্পর্কে" data-url="/about-us">About Us (/about-us)</option>
  <option value="activities" data-title-en="Activities" data-title-bn="কার্যক্রম" data-url="/activities">Activities (/activities)</option>
  <option value="gallery" data-title-en="Gallery" data-title-bn="গ্যালারি" data-url="/gallery">Gallery (/gallery)</option>
  <option value="blog" data-title-en="Blog" data-title-bn="ব্লগ" data-url="/blog">Blog (/blog)</option>
  <option value="notice" data-title-en="Notice Board" data-title-bn="নোটিশ বোর্ড" data-url="/notice">Notice Board (/notice)</option>
  <option value="volunteer" data-title-en="Join as Volunteer" data-title-bn="স্বেচ্ছাসেবক" data-url="/volunteer">Volunteer (/volunteer)</option>
  <option value="contact" data-title-en="Contact Us" data-title-bn="যোগাযোগ" data-url="/contact">Contact Us (/contact)</option>
</optgroup>
<optgroup label="Activity Categories (কার্যক্রম ক্যাটাগরি)">
  <option value="act-edu" data-title-en="Education & Dawah" data-title-bn="শিক্ষা ও দাওয়াহ" data-url="/activities?cat=education">Education & Dawah (/activities?cat=education)</option>
  <option value="act-wel" data-title-en="Social Welfare" data-title-bn="সমাজকল্যাণ" data-url="/activities?cat=welfare">Social Welfare (/activities?cat=welfare)</option>
  <option value="act-rel" data-title-en="Relief & Rehabilitation" data-title-bn="ত্রাণ ও পুনর্বাসন" data-url="/activities?cat=relief">Relief & Rehabilitation (/activities?cat=relief)</option>
  <option value="act-liv" data-title-en="Self-Reliance & Livelihood" data-title-bn="স্বাবলম্বন ও কর্মসংস্থান" data-url="/activities?cat=livelihood">Self-Reliance & Livelihood (/activities?cat=livelihood)</option>
</optgroup>
@if(isset($pages) && $pages->count() > 0)
<optgroup label="Dynamic Custom Pages (ডাইনামিক পেজসমূহ)">
  @foreach($pages as $pg)
    <option value="page-{{ $pg->id }}" data-title-en="{{ $pg->title_en }}" data-title-bn="{{ $pg->title_bn }}" data-url="/page/{{ $pg->slug }}">{{ $pg->title_en }} ({{ $pg->title_bn }})</option>
  @endforeach
</optgroup>
@endif
@if(isset($postCategories) && $postCategories->count() > 0)
<optgroup label="Blog Categories (ব্লগ ক্যাটাগরি)">
  @foreach($postCategories as $pcat)
    <option value="cat-{{ $pcat->id }}" data-title-en="{{ $pcat->name_en }}" data-title-bn="{{ $pcat->name_bn }}" data-url="/blog?category={{ $pcat->slug }}">{{ $pcat->name_en }} ({{ $pcat->name_bn }})</option>
  @endforeach
</optgroup>
@endif
