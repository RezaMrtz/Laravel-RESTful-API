<?php

namespace App\Http\Middleware;

use Closure;
use Dotenv\Exception\ValidationException;

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

        if (isset(response()->exception) && response()->exception instanceof ValidationException) {

            $data = response()->getDate();

            $transformedErrors = [];

            foreach ($data->error as $field => $error) {

                $transformedField = $transformer::transformedAttribute($field);

                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);

            }

            $data->error = $transformedErrors;

            response()->setData($data);
        }

        return response();
    }
}
