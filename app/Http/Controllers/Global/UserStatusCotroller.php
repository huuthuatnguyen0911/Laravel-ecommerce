<?php

namespace App\Http\Controllers\Global;

use App\Events\UserOffline;
use App\Events\UserOnline;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserStatusCotroller extends Controller
{
    public function UserOnline(Request $request)
    {
        $dataUser = $request->input('dateUser');

        User::where('id','=', $dataUser['id'])
        ->update([
            'active_status' => 0,
        ]);

        // $dataUser = User::select('id','active_status')->where('id', '=', $idUser)->first();

        event(new UserOnline($dataUser));
        return true;
    }

    public function UserOffline(Request $request)
    {
        $dataUser = $request->input('dateUser');

        User::where('id','=', $dataUser['id'])
        ->update([
            'active_status' => 1,
        ]);

        event(new UserOffline($dataUser));
        return true;
    }

    
}
