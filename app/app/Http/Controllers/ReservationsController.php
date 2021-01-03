<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkidisnumeric', ['only' => [
            'showByRoomId',
            'delete',
        ]]);

        $this->middleware('checkidexists:rooms', ['only' => [
            'showByRoomId',
        ]]);

        $this->middleware('checkidexists:reservations', ['only' => [
            'delete',
        ]]);

        $this->middleware('validatereservations', ['only' => [
            'create',
        ]]);

    }

    /**
     * Return all reservations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAll()
    {
        $result = DB::table('reservations')
            ->select()
            ->orderBy('start_date', 'desc')
            ->get();
        return response()->json($result);
    }

    /**
     * Return reservations with room_id=$room_id
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByRoomId(int $id)
    {
        $result = DB::table('reservations')
            ->select('id', 'start_date', 'end_date')
            ->where(['room_id' => $id])
            ->orderBy('start_date', 'desc')
            ->get();
        return response()->json($result);
    }

    public function create(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $roomId = $request->input('room_id');
        $id = DB::table('reservations')
            ->insertGetId(['start_date' => $startDate, 'end_date' => $endDate, 'room_id' => $roomId]);
        return response()->json(['reservation_id' => $id], 201);
    }

    /**
     * Delete reservation with id=$id
     *
     * @param int $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function delete(int $id)
    {
        DB::table('reservations')->delete($id);
        return response('');
    }
}