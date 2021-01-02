<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateRooms
{
    /**
     * Validate rooms parameters for create and update actions.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $action
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next, string $action) {
        switch ($action) {
            case 'create':
                $rules = [
                    'desc' => 'required',
                    'price' => 'required|numeric|gte:0',
                ];
                break;
            case 'update':
                $rules = [
                    'price' => 'numeric|gte:0'
                ];
                break;
            default:
                $rules = [];
        }
        $validator = Validator::make($request->all(), $rules, [
            'desc.required' => 'Поле desс обязательно к заполнению!',
            'price.required' => 'Поле price обязательно к заполнению!',
            'price.numeric' => 'Поле price должно быть числом!',
            'price.gte' => 'Поле price должно быть положительным!',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        return $next($request);
    }
}