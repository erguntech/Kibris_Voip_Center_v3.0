<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyNumbersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi'],['only' => ['index']]);
    }

    public function index()
    {
        return view('pages.my_numbers.my_numbers_index');
    }
}
