<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckIdExists
{
    /**
     * Check if row with `id` exists in $table
     *
     * @param Request $request
     * @param Closure $next
     * @param string $table
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next, string $table) {
        $id = $request->route('id');
        if (DB::table($table)->where('id', $id)->doesntExist())
        {
            return response()->json(['error' => "Запись в {$table} не найдена!"], 404);
        }
        return $next($request);
    }
}