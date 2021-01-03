<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class CheckSortingParams
{
    private $sorts = ['desc', 'asc'];
    private $fields = ['price', 'created_at'];

    public function handle(Request $request, Closure $next) {
        $sortParams = $request->input('param');
        $sortTypes = $request->input('type');
        if ($sortParams !== null)
        {
            $sortParams = array_map('strtolower',
                strpos($sortParams, ',')===false ? [$sortParams] : explode(',', $sortParams));
            foreach($sortParams as $param)
            {
                if (!in_array($param, $this->fields))
                {
                    return response()->json(['error' => "Указан неверный параметр: {$param}."], 400);
                }
            }
        }
        else {
            return response()->json(['error' => 'Не указано поле для сортировки!'], 400);
        }
        if ($sortTypes !== null && !empty($sortTypes))
        {
            $sortTypes = array_map('strtolower',
                strpos($sortTypes, ',')===false ? [$sortTypes] : explode(',', $sortTypes));
            foreach ($sortTypes as $type)
            {
                if (!in_array($type, $this->sorts))
                {
                    return response()->json(['error' => "Неверный тип сортировки: {$type}."], 400);
                }
            }
        }
        return $next($request);
    }
}