<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateReservations
{
    public function handle(Request $request, Closure $next) {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
            'room_id' => 'required|numeric'
        ], [
            'start_date.required' => 'Поле start_date обязательно к заполнению!',
            'end_date.required' => 'Поле end_date обязательно к заполнению!',
            'room_id.required' => 'Поле room_id обязательно к заполнению!',
            'room_id.numeric' => 'Поле price должно быть числом!',
            '*.date_format' => 'Поля start_date и end_date должны иметь формат "YYYY-MM-DD", напр. "2000-12-01"!',
            'end_date.after' => 'Дата окончания бронирования должна быть после даты начала бронирования!',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        return $next($request);
    }
}