<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class LanguagesController extends Controller
{
    public function set($lang)
    {
        if (array_key_exists($lang, Config::get('app.availableLanguages'))) {
            session()->put('locale', $lang);
        }
        return Redirect::back();
    }
}