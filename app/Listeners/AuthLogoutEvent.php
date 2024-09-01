<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class AuthLogoutEvent
{
    public function __construct()
    {
        //
    }

    public function handle(object $event): void
    {
        activity()
            ->causedBy(Auth::user())
            ->performedOn(Auth::user())
            ->withProperties(['Causer Name' => Auth::user()->getUserFullName()])
            ->log('Logout Activity');
    }
}
