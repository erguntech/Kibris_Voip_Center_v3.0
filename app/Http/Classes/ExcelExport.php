<?php

namespace App\Http\Classes;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExport implements FromCollection
{
    public function collection()
    {
        return User::all();
    }
}
