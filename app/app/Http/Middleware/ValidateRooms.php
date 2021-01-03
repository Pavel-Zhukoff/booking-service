<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateRooms
{
    /**
     * Validate rooms parameters for create action.
     *
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next) {

        $validator = Validator::make($request->all(), [
            'desc' => 'required',
            'price' => 'required|numeric|gte:0|lt:1000000',
        ], [
            'desc.required' => 'Поле desс обязательно к заполнению!',
            'price.required' => 'Поле price обязательно к заполнению!',
            'price.numeric' => 'Поле price должно быть числом!',
            'price.gte' => 'Поле price должно быть положительным!',
            'price.lt' => 'Поле price должно быть меньше чем 1000000!',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        return $next($request);
    }
}