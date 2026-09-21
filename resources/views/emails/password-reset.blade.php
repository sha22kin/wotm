<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ app()->getLocale() === 'en' ? 'Password Reset' : 'পাসওয়ার্ড রিসেট' }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333333;">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7f6; padding: 40px 15px;">
    <tr>
      <td align="center">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 560px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
          
          <!-- Header Banner -->
          <tr>
            <td align="center" style="background-color: #006199; padding: 30px 20px; color: #ffffff;">
              <h1 style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 0.5px;">{{ $siteName }}</h1>
              <p style="margin: 6px 0 0 0; font-size: 13px; opacity: 0.85;">{{ app()->getLocale() === 'en' ? 'Account Security & Assistance' : 'অ্যাকাউন্ট নিরাপত্তা ও সহায়তা' }}</p>
            </td>
          </tr>

          <!-- Body Content -->
          <tr>
            <td style="padding: 35px 30px;">
              <p style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #1e293b;">
                {{ app()->getLocale() === 'en' ? 'Hello ' . $user->name . ',' : 'আসসালামু আলাইকুম ' . $user->name . ',' }}
              </p>
              <p style="margin: 0 0 20px 0; font-size: 14px; line-height: 1.6; color: #475569;">
                {{ app()->getLocale() === 'en'
                  ? 'We received a request to reset your account password. Click the button below to choose a new password:'
                  : 'আমরা আপনার অ্যাকাউন্টের পাসওয়ার্ড রিসেট করার একটি অনুরোধ পেয়েছি। নিচের বাটনে ক্লিক করে নতুন পাসওয়ার্ড সেট করুন:' }}
              </p>

              <!-- Call to Action Button -->
              <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 28px 0;">
                <tr>
                  <td align="center">
                    <a href="{{ $resetUrl }}" target="_blank" style="display: inline-block; background-color: #009B4D; color: #ffffff; text-decoration: none; padding: 14px 32px; font-size: 15px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 155, 77, 0.25);">
                      {{ app()->getLocale() === 'en' ? 'Reset Password' : 'পাসওয়ার্ড রিসেট করুন' }}
                    </a>
                  </td>
                </tr>
              </table>

              <p style="margin: 0 0 12px 0; font-size: 13px; line-height: 1.5; color: #64748b;">
                {{ app()->getLocale() === 'en'
                  ? 'This password reset link will expire in 5 minutes. If you did not request a password reset, no further action is required.'
                  : 'এই পাসওয়ার্ড রিসেট লিঙ্কটির মেয়াদ ৫ মিনিট। আপনি যদি পাসওয়ার্ড রিসেটের অনুরোধ না করে থাকেন, তবে কোনো পদক্ষেপের প্রয়োজন নেই।' }}
              </p>

              <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 24px 0 16px 0;">

              <!-- Fallback Plain URL -->
              <p style="margin: 0; font-size: 12px; color: #94a3b8; line-height: 1.4; word-break: break-all;">
                {{ app()->getLocale() === 'en' ? 'If the button does not work, copy and paste this link into your browser:' : 'বাটন কাজ না করলে এই লিংকটি কপি করে ব্রাউজারে পেস্ট করুন:' }}<br>
                <a href="{{ $resetUrl }}" style="color: #006199;">{{ $resetUrl }}</a>
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align="center" style="background-color: #f8fafc; padding: 20px; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
              &copy; {{ date('Y') }} {{ $siteName }}. {{ app()->getLocale() === 'en' ? 'All rights reserved.' : 'সর্বস্বত্ব সংরক্ষিত।' }}
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
