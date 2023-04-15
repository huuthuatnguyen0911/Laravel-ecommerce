<?php

namespace App\Listeners;

use App\Models\InforUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class LogRegisteredUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // return $event;
        // $id = Auth::user()->id;
        // InforUser::where('id_user', '=', $id);
        // $dataInfor = new InforUser();
        // $dataInfor->id_user = $id;
        // $dataInfor->save();       
    }
}
