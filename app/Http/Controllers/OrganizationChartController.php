<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizationChartController extends Controller
{
    public function index()
    {
        return view('pages.organization_charts.organization_charts_index');
    }
}
