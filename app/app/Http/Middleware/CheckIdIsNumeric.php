<?php


namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

class CheckIdIsNumeric
{
    public function handle(Request $request, Closure $next, int $index) {
        $id = $request->segment($index);
        if (!is_numeric($id))
        {
            return response()->json(['error' => 'ID должен быть целым числом!']);
        }
        return $next($request);
    }
}