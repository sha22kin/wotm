<!DOCTYPE html>
<html lang="bn" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $subject ?? 'WOTM Notification' }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f0f4f8;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f0f4f8;padding:30px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

          <!-- Header -->
          <tr>
            <td style="background:linear-gradient(135deg,#166534 0%,#15803d 50%,#22c55e 100%);padding:32px 40px;text-align:center;">
              <h1 style="margin:0;color:#ffffff;font-size:24px;font-weight:700;letter-spacing:0.5px;">
                {{ $settings['site_title_bn'] ?? 'WOTM' }}
              </h1>
              <p style="margin:8px 0 0;color:rgba(255,255,255,0.85);font-size:13px;">
                {{ $settings['site_tagline_bn'] ?? 'Way of Truthful Muslim' }}
              </p>
            </td>
          </tr>

          <!-- Badge -->
          <tr>
            <td align="center" style="padding:24px 40px 0;">
              <table role="presentation" cellspacing="0" cellpadding="0">
                <tr>
                  <td style="background-color:{{ $badgeColor ?? '#dcfce7' }};color:{{ $badgeTextColor ?? '#166534' }};padding:6px 20px;border-radius:50px;font-size:13px;font-weight:600;">
                    {{ $badge ?? 'New Notification' }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Title -->
          <tr>
            <td style="padding:16px 40px 8px;text-align:center;">
              <h2 style="margin:0;color:#1e293b;font-size:20px;font-weight:700;">
                {{ $title ?? 'New Message Received' }}
              </h2>
              <p style="margin:8px 0 0;color:#64748b;font-size:14px;">
                {{ $subtitle ?? '' }}
              </p>
            </td>
          </tr>

          <!-- Divider -->
          <tr>
            <td style="padding:16px 40px;">
              <hr style="border:none;border-top:1px solid #e2e8f0;margin:0;">
            </td>
          </tr>

          <!-- Content -->
          <tr>
            <td style="padding:0 40px;">
              @yield('content')
            </td>
          </tr>

          <!-- Divider -->
          <tr>
            <td style="padding:20px 40px;">
              <hr style="border:none;border-top:1px solid #e2e8f0;margin:0;">
            </td>
          </tr>

          <!-- Action Button -->
          @if(isset($actionUrl))
          <tr>
            <td align="center" style="padding:0 40px 24px;">
              <a href="{{ $actionUrl }}" style="display:inline-block;background:linear-gradient(135deg,#166534,#22c55e);color:#ffffff;text-decoration:none;padding:12px 32px;border-radius:8px;font-size:14px;font-weight:600;letter-spacing:0.3px;">
                {{ $actionText ?? 'View in Admin Panel' }}
              </a>
            </td>
          </tr>
          @endif

          <!-- Footer -->
          <tr>
            <td style="background-color:#f8fafc;padding:24px 40px;text-align:center;border-top:1px solid #e2e8f0;">
              <p style="margin:0 0 4px;color:#94a3b8;font-size:12px;">
                © {{ date('Y') }} {{ $settings['site_title_en'] ?? 'WOTM' }}. All rights reserved.
              </p>
              <p style="margin:0;color:#cbd5e1;font-size:11px;">
                This is an automated notification from your website.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
