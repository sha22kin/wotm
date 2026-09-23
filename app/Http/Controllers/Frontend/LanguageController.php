<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        if (in_array($locale, ['en', 'bn'])) {
            $request->session()->put('locale', $locale);
            $request->session()->save();
            cookie()->queue('locale', $locale, 60 * 24 * 365); // 1 year cookie persistence
            app()->setLocale($locale);
        }

        $previousUrl = url()->previous();
        if (!$previousUrl || str_contains($previousUrl, '/lang/')) {
            return redirect()->route('home');
        }

        return redirect()->to($previousUrl);
    }
}
