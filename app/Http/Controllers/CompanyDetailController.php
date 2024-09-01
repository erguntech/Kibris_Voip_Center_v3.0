<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyDetailRequest;
use Illuminate\Http\Request;

class CompanyDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi|Şirket Kullanıcısı'],['only' => ['companyDetails', 'companyDetailsUpdate']]);
    }

    public function companyDetails()
    {
        return view('pages.company_details.company_details_index');
    }

    public function companyDetailsUpdate(CompanyDetailRequest $request)
    {
        return redirect()->route('CompanyDetails.Index')
            ->with('result','warning')
            ->with('title',__('messages.alerts.01'))
            ->with('content',__('messages.alerts.04'));
    }
}
