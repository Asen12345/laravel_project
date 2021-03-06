<?php

namespace App\Http\Middleware;

use Closure;

class isManager
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
		if (auth()->user()->role == 'manager') {
			return $next($request);
		}

		return redirect('dashboard');
	}
}
