<?php namespace App\Http\Middleware;

use App\Http\Helpers\CONSTANTS;
use App\Http\Helpers\KeyParser;
use App\Http\Models\Logs;
use Illuminate\Contracts\Routing\Middleware;
use Closure;

class FiltersAfter implements Middleware {

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Do stuff
       
        return $response;
    }

}