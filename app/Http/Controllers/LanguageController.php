<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function switchLang(Request $request)
    {
        session()->put('locale', $request->lang);
        App::setLocale($request->lang);
        return redirect()->back();
    }
}
