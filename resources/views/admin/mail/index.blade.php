@extends('admin.layouts.app')

@section('title', 'Mailing Settings')
@section('page_title', 'Mailing & SMTP Configuration')

@section('content')
<div class="row g-4 justify-content-center">
  <!-- SMTP Settings Form -->
  <div class="col-lg-8 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-server"></i>
          <span>Outgoing Mail Server (SMTP)</span>
        </h2>
      </div>
      <form action="{{ route('admin.mail.update') }}" method="POST">
        @csrf
        <div class="adm-card-body">
          <div class="row g-3">
            <div class="col-md-8 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="mail_host">SMTP Host <span class="adm-req">*</span></label>
                <input type="text" name="mail_host" id="mail_host" class="adm-input" value="{{ old('mail_host', $settings['mail_host'] ?? 'smtp.mailtrap.io') }}" required>
              </div>
            </div>

            <div class="col-md-4 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="mail_port">Port <span class="adm-req">*</span></label>
                <input type="number" name="mail_port" id="mail_port" class="adm-input" value="{{ old('mail_port', $settings['mail_port'] ?? 587) }}" required>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="mail_username">Username</label>
                <input type="text" name="mail_username" id="mail_username" class="adm-input" value="{{ old('mail_username', $settings['mail_username'] ?? '') }}">
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="mail_password">Password</label>
                <input type="password" name="mail_password" id="mail_password" class="adm-input" value="{{ old('mail_password', $settings['mail_password'] ?? '') }}">
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="mail_encryption">Encryption Protocol</label>
                <select name="mail_encryption" id="mail_encryption" class="adm-select">
                  <option value="tls" {{ ($settings['mail_encryption'] ?? '') === 'tls' ? 'selected' : '' }}>TLS (Default)</option>
                  <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                  <option value="" {{ empty($settings['mail_encryption']) ? 'selected' : '' }}>None</option>
                </select>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="mail_from_name">From Sender Name <span class="adm-req">*</span></label>
                <input type="text" name="mail_from_name" id="mail_from_name" class="adm-input" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? 'WOTM Foundation') }}" required>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="mail_from_address">From Email Address <span class="adm-req">*</span></label>
                <input type="email" name="mail_from_address" id="mail_from_address" class="adm-input" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? 'no-reply@wotm.org') }}" required>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="mail_admin_recipient">Admin Alert Notification Recipient</label>
                <input type="email" name="mail_admin_recipient" id="mail_admin_recipient" class="adm-input" value="{{ old('mail_admin_recipient', $settings['mail_admin_recipient'] ?? 'admin@wotm.org') }}">
                <div class="adm-input-hint">Receives new volunteer application and contact form notifications.</div>
              </div>
            </div>
          </div>
        </div>
        <div class="adm-card-footer text-end">
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Save Mail Settings
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Test Email Card -->
  <div class="col-lg-4 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-paper-plane"></i>
          <span>Send Test Email</span>
        </h2>
      </div>
      <form action="{{ route('admin.mail.test') }}" method="POST">
        @csrf
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="test_email">Recipient Email Address <span class="adm-req">*</span></label>
            <input type="email" name="test_email" id="test_email" class="adm-input" placeholder="you@domain.com" required>
            <div class="adm-input-hint">Test your SMTP connectivity and delivery settings.</div>
          </div>
        </div>
        <div class="adm-card-footer text-end">
          <button type="submit" class="adm-btn adm-btn-amber w-100">
            <i class="fa-solid fa-paper-plane"></i> Send Test Message
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
