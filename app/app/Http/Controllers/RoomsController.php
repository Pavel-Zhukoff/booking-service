<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkidisnumeric', ['only' => [
            'showById',
            'delete',
        ]]);

        $this->middleware('checkidexists:rooms', ['only' => [
            'showById',
            'delete',
        ]]);

        $this->middleware('validaterooms', ['only' => [
            'create',
        ]]);

        $this->middleware('checksortingparams', ['only' => [
            'sortBy',
        ]]);
    }

    /**
     * Returns all rooms
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAll()
    {
        $result = DB::table('rooms')->get();
        return response()->json($result);
    }

    /**
     * Return room with id=$id
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showById(int $id)
    {
        $result = DB::table('rooms')->find($id);
        return response()->json($result);
    }

    /**
     * Sort values by params send in $request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortBy(Request $request)
    {
        $sortParams = $request->input('param');
        $sortTypes = $request->input('type');
        $sortParams = array_map('strtolower',
            strpos($sortParams, ',')===false ? [$sortParams] : explode(',', $sortParams));
        $sorted = DB::table('rooms');
        if ($sortTypes !== null && !empty($sortTypes))
        {
            $sortTypes = array_map('strtolower',
                strpos($sortTypes, ',')===false ? [$sortTypes] : explode(',', $sortTypes));
        }
        else {
            $sortTypes = array_fill(0, count($sortParams)-1, 'asc');
        }
        foreach ($sortParams as $i => $sortParam) {
            if (key_exists($i, $sortTypes))
            {
                $sorted->orderBy($sortParam, $sortTypes[$i]);
            }
            else {
                $sorted->orderBy($sortParam);
            }
        }
        return response()->json($sorted->get());
    }

    /**
     * Create new room
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $desc = $request->input('desc');
        $price = $request->input('price');
        $id = DB::table('rooms')->insertGetId(['description' => $desc, 'price' => $price]);
        return response()->json(['room_id' => $id], 201);
    }

    /**
     * Delete room with id=$id
     *
     * @param int $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function delete(int $id)
    {
        DB::table('rooms')->delete($id);
        return response('');
    }
}