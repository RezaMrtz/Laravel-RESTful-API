<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser
{
    /* Success Response */
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    /* Error Response */
    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /* Show All */
    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->transformData($collection, $transformer);

        return $this->successResponse($collection, $code);
    }

    /* Show One */
    protected function showOne(Model $instance, $code = 200)
    {
        $transformer = $instance->transformer;

        $instance =  $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }
    /* Show Message */
    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    /* Transform Data Method */
    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }
}
