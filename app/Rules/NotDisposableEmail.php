<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotDisposableEmail implements ValidationRule
{
    /**
     * Popular disposable / temporary email service domains.
     */
    protected static array $disposableDomains = [
        'mailinator.com', '10minutemail.com', 'tempmail.com', 'temp-mail.org',
        'guerrillamail.com', 'yopmail.com', 'sharklasers.com', 'throwawaymail.com',
        'trashmail.com', 'dispostable.com', 'getnada.com', 'maildrop.cc',
        'inboxkitten.com', 'tempmailo.com', 'mohmal.com', 'crazymailing.com',
        'generator.email', 'emailondeck.com', 'fakeinbox.com', 'burnermail.io',
        'mytemp.email', 'dropmail.me', 'minutemailbox.com', 'clipmail.eu',
        'guerrillamail.net', 'guerrillamail.biz', 'guerrillamail.org',
        'trashmail.net', 'tempinbox.com', 'fakemailgenerator.com'
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || !str_contains($value, '@')) {
            return;
        }

        $parts = explode('@', strtolower(trim($value)));
        $domain = end($parts);

        if (in_array($domain, self::$disposableDomains, true)) {
            $fail(app()->getLocale() === 'en'
                ? 'Temporary or disposable email addresses are not permitted. Please use a permanent email.'
                : 'ডিসপোজেবল বা অস্থায়ী ইমেইল গ্রহণযোগ্য নয়। অনুগ্রহ করে আপনার স্থায়ী ইমেইল ব্যবহার করুন।');
        }
    }
}
