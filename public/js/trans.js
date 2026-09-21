/**
 * WOTM Language Switcher using Google Translate & jQuery
 */

// Initialize Google Translate Element
function googleTranslateElementInit() {
  if (window.google && window.google.translate && window.google.translate.TranslateElement) {
    new window.google.translate.TranslateElement({
      pageLanguage: 'bn',
      includedLanguages: 'en,bn',
      autoDisplay: false
    }, 'google_translate_element');
  }
}

// Fallback in case Google Translate script loaded before this script
if (window.google && window.google.translate && window.google.translate.TranslateElement) {
  googleTranslateElementInit();
}

// Helper: Apply active styling to UI buttons
function updateSwitcherUI(lang) {
  $('.lang-switch button, .lang-switch .lang-btn').each(function() {
    var btnLang = $(this).attr('data-lang');
    var txt = $(this).text().trim();
    if (btnLang === lang || (lang === 'en' && txt === 'EN') || (lang === 'bn' && (txt === 'বাং' || txt === 'বা'))) {
      $(this).addClass('active');
    } else {
      $(this).removeClass('active');
    }
  });
}

// Restore Original Bengali text using Google's native restore button or combo
function restoreOriginalBengali() {
  var restored = false;

  // 1. Trigger the official Google Translate restore button in the container iframe
  var iframe = document.getElementById(':1.container') || document.querySelector('.goog-te-banner-frame');
  if (iframe) {
    try {
      var doc = iframe.contentDocument || iframe.contentWindow.document;
      if (doc) {
        var restoreBtn = doc.getElementById(':1.restore') || doc.querySelector('[id$="restore"]') || doc.querySelector('.goog-close-link');
        if (restoreBtn) {
          restoreBtn.click();
          restored = true;
        }
      }
    } catch(e) {}
  }

  // 2. Also reset the combo dropdown to original
  var combo = document.querySelector('.goog-te-combo');
  if (combo) {
    var hasBnOption = Array.from(combo.options).some(function(o) { return o.value === 'bn'; });
    combo.value = hasBnOption ? 'bn' : '';
    combo.dispatchEvent(new Event('change', { bubbles: true }));
    restored = true;
  }

  updateSwitcherUI('bn');
  return restored;
}

// Translate to English via combo dropdown
function translateToEnglish() {
  var combo = document.querySelector('.goog-te-combo');
  if (combo) {
    combo.value = 'en';
    combo.dispatchEvent(new Event('change', { bubbles: true }));
    updateSwitcherUI('en');
    return true;
  }
  return false;
}

// Apply selected language (supports repeated switching back and forth)
function applyLanguage(lang) {
  if (lang === 'bn') {
    return restoreOriginalBengali();
  } else {
    return translateToEnglish();
  }
}

// Set language and update UI + cookies
function setLanguage(lang) {
  // Update localStorage
  localStorage.setItem('wotm_lang', lang);

  // Update cookies for Google Translate
  var domain = window.location.hostname;
  if (lang === 'bn') {
    document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    if (domain && domain !== 'localhost') {
      document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=.' + domain + '; path=/;';
    }
  } else {
    document.cookie = 'googtrans=/bn/' + lang + '; path=/;';
    if (domain && domain !== 'localhost') {
      document.cookie = 'googtrans=/bn/' + lang + '; domain=.' + domain + '; path=/;';
    }
  }

  // Update UI immediately
  updateSwitcherUI(lang);

  // Enforce active class after any Google Translate DOM mutations
  setTimeout(function() { updateSwitcherUI(lang); }, 300);
  setTimeout(function() { updateSwitcherUI(lang); }, 1000);
  setTimeout(function() { updateSwitcherUI(lang); }, 2000);

  // Apply translation action
  if (!applyLanguage(lang)) {
    var attempts = 0;
    var interval = setInterval(function() {
      attempts++;
      if (applyLanguage(lang) || attempts > 25) {
        clearInterval(interval);
      }
    }, 200);
  }
}

$(document).ready(function() {
  // Check stored language preference
  var savedLang = localStorage.getItem('wotm_lang');
  if (!savedLang) {
    var match = document.cookie.match(/(^|;) ?googtrans=([^;]*)(;|$)/);
    if (match) {
      var parts = match[2].split('/');
      if (parts.length > 2 && parts[2] === 'en') {
        savedLang = 'en';
      }
    }
  }

  if (savedLang === 'en') {
    setLanguage('en');
  } else {
    // Default is Bangla
    updateSwitcherUI('bn');
  }

  // Bind click event for both desktop and mobile drawer
  $(document).on('click', '.lang-switch button, .lang-switch .lang-btn', function(e) {
    e.preventDefault();
    var btnLang = $(this).attr('data-lang');
    if (!btnLang) {
      var txt = $(this).text().trim();
      btnLang = (txt === 'EN') ? 'en' : 'bn';
    }
    setLanguage(btnLang);
  });
});
