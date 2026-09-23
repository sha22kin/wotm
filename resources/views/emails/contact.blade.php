@extends('emails.layout')

@section('content')
<!-- Info Cards -->
<table role="presentation" width="100%" cellspacing="0" cellpadding="0">
  <!-- Name -->
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
        <tr>
          <td style="padding:14px 18px;">
            <p style="margin:0 0 4px;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Name / নাম</p>
            <p style="margin:0;color:#1e293b;font-size:15px;font-weight:600;">{{ $submission->name }}</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Contact -->
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
        <tr>
          <td style="padding:14px 18px;">
            <p style="margin:0 0 4px;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Contact / যোগাযোগ</p>
            <p style="margin:0;color:#1e293b;font-size:15px;font-weight:600;">{{ $submission->contact }}</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Subject -->
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
        <tr>
          <td style="padding:14px 18px;">
            <p style="margin:0 0 4px;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Subject / বিষয়</p>
            <p style="margin:0;color:#1e293b;font-size:15px;font-weight:600;">{{ $submission->subject }}</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Message -->
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#fffbeb;border-radius:10px;border:1px solid #fde68a;">
        <tr>
          <td style="padding:14px 18px;">
            <p style="margin:0 0 4px;color:#92400e;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Message / বার্তা</p>
            <p style="margin:0;color:#1e293b;font-size:14px;line-height:1.7;">{{ $submission->message }}</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Timestamp -->
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td style="padding:8px 0;text-align:center;">
            <p style="margin:0;color:#94a3b8;font-size:12px;">
              ⏰ Received at: {{ $submission->created_at->format('d M Y, h:i A') }}
            </p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
@endsection
