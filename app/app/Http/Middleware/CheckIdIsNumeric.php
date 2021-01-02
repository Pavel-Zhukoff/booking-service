<?php


namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

class CheckIdIsNumeric
{
    /**
     * Check if requested `id` is integer
     *
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next) {
        $id = $request->route('id');
        if (!is_numeric($id) && strpos($id, '.') !== false)
        {
            return response()->json(['error' => 'ID должен быть целым числом!'], 400);
        }
        return $next($request);
    }
}