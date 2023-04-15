<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('notice.{idUser}',function ($user, $idUser) {
    return $user->id == $idUser;
});

// gửi tin nhắn
Broadcast::channel('chat.{idUser}',function ($user, $idUser) {
    return $user->id == $idUser;
});

// gửi kiểm tra tham gia nhóm
Broadcast::channel('joining',function ($user) {
    return $user;
});
