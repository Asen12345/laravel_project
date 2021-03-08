<?php

namespace App\Http\Middleware;

use Closure;

class isAdminInvestor
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (in_array(auth()->user()->role, ['admin', 'investor'])) {
			return $next($request);
		}

		return redirect('dashboard');
	}
}
