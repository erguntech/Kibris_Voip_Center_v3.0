<?php

namespace App\Http\Middleware;

use App\Models\PaymentOrder;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(@Auth::user()->user_type == 3 || @Auth::user()->user_type == 4)
        {
            $paymentOrder = PaymentOrder::where('client_id', Auth::user()->linkedClient->id)->orderBy('created_at', 'desc')->first();

            if(Auth::user()->linkedClient->linkedClientModules->pbx_module == false || !$paymentOrder)
            {
                return redirect('authentication/module/deactivated');
            }
        }

        return $next($request);
    }
}
