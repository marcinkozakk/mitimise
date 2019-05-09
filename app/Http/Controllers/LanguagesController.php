<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

/**
 * This controller is responsible for switching user language
 *
 * Class LanguagesController
 * @package App\Http\Controllers
 */
class LanguagesController extends Controller
{
    /**
     * Set site language
     *
     * @param $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set($lang)
    {
        if (array_key_exists($lang, Config::get('app.availableLanguages'))) {
            session()->put('locale', $lang);
        }
        return Redirect::back();
    }
}