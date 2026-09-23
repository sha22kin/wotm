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
            <p style="margin:0 0 4px;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Full Name / পূর্ণ নাম</p>
            <p style="margin:0;color:#1e293b;font-size:15px;font-weight:600;">{{ $submission->full_name }}</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Phone & Email Row -->
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%" style="vertical-align:top;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
              <tr>
                <td style="padding:14px 18px;">
                  <p style="margin:0 0 4px;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Phone / ফোন</p>
                  <p style="margin:0;color:#1e293b;font-size:15px;font-weight:600;">{{ $submission->phone }}</p>
                </td>
              </tr>
            </table>
          </td>
          <td width="4%"></td>
          <td width="48%" style="vertical-align:top;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
              <tr>
                <td style="padding:14px 18px;">
                  <p style="margin:0 0 4px;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Email / ইমেইল</p>
                  <p style="margin:0;color:#1e293b;font-size:15px;font-weight:600;">{{ $submission->email ?? 'N/A' }}</p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Area of Interest -->
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#ecfdf5;border-radius:10px;border:1px solid #a7f3d0;">
        <tr>
          <td style="padding:14px 18px;">
            <p style="margin:0 0 4px;color:#065f46;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Area of Interest / আগ্রহের ক্ষেত্র</p>
            <p style="margin:0;color:#1e293b;font-size:15px;font-weight:600;">{{ $submission->area_of_interest }}</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Education & District Row -->
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%" style="vertical-align:top;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
              <tr>
                <td style="padding:14px 18px;">
                  <p style="margin:0 0 4px;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Education / শিক্ষা</p>
                  <p style="margin:0;color:#1e293b;font-size:14px;font-weight:600;">{{ $submission->education ?? 'N/A' }}</p>
                </td>
              </tr>
            </table>
          </td>
          <td width="4%"></td>
          <td width="48%" style="vertical-align:top;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
              <tr>
                <td style="padding:14px 18px;">
                  <p style="margin:0 0 4px;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">District / জেলা</p>
                  <p style="margin:0;color:#1e293b;font-size:14px;font-weight:600;">{{ $submission->district ?? 'N/A' }}</p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Facebook Link -->
  @if($submission->facebook_link)
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#eff6ff;border-radius:10px;border:1px solid #bfdbfe;">
        <tr>
          <td style="padding:14px 18px;">
            <p style="margin:0 0 4px;color:#1e40af;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:600;">Facebook</p>
            <a href="{{ $submission->facebook_link }}" style="color:#2563eb;font-size:14px;word-break:break-all;">{{ $submission->facebook_link }}</a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  @endif

  <!-- Message -->
  @if($submission->message)
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
  @endif

  <!-- Timestamp -->
  <tr>
    <td style="padding:8px 0;">
      <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td style="padding:8px 0;text-align:center;">
            <p style="margin:0;color:#94a3b8;font-size:12px;">
              ⏰ Submitted at: {{ $submission->created_at->format('d M Y, h:i A') }}
            </p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
@endsection
