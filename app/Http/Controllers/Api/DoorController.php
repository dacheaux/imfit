<?php

namespace App\Http\Controllers\Api;

use App\Door;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoorController extends Controller
{


    public function checkDoor()
    {

        if(is_numeric(request()->get('id'))){

            $door = Door::where('id', request()->get('id'))->first();

            if(!is_null($door)) {
                if ($door !== null && $door->door_state == 1 || $door->door_state == 2 || $door->door_state == 3) {
                    return response()->json(['door_state' => $door->door_state, 'updated_at' => $door->updated_at->timestamp]);
                }

                return response()->json(['door_state' => false, 'updated_at' => $door->updated_at->timestamp]);
            }

        }

        return response()->json(['door_state' => false]);
    }

    public function postDoor()
    {
        if(request()->get('door_state') == 0)
        {
            $door = Door::where('id', request()->get('id'))->first();
            if(!is_null($door)) {
                if ($door !== null && $door->door_state != 0) {
                    $door->door_state = 0;
                    $door->save();
                    return response()->json(['door_state' => true]);
                }
            }
            return response()->json(['door_state' => false]);
        }

        return response()->json(['door_state' => false]);
    }
}
