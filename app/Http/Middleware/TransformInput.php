<?php

namespace App\Http\Middleware;

use Closure;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $transformer)
    {

        $transformInput = [];

        foreach ($request->request->all() as $input => $value) {
            $transformInput[$transformer::originalAttribute($input)] = $value;
        }

        $request->replace($transformInput);

        return $next($request);
    }
}
