<?php

namespace App\Http\Controllers\Personal;

use App\Events\SendMessages;
use App\Http\Controllers\Controller;
use App\Models\FriendShip;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;

class MessagesController extends Controller
{
    // trang index tin nhắn
    public function indexMessages()
    {
        $idUser = Auth::user()->id;

        $listFriends = FriendShip::where('fs_id_user', '=', $idUser)
            ->where('fs_status', '=', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->get();


        return view('personal.pages.messages.index', compact('listFriends'));
    }

    // show boxchat
    public function showBoxChat($id)
    {

        $dataUser = User::where('id', '=', $id)->first();

        Message::where('id_from', '=', $id)
            ->where('id_to', '=', Auth::user()->id)
            ->update([
                'seen' => 0
            ]);

        $dataListMess = Message::whereIn('id_from', [Auth::user()->id, $id])
            ->whereIn('id_to', [Auth::user()->id, $id])
            ->get();

        // return $dataListMess;

        return view('personal.pages.messages.view_box_chat', compact('dataUser', 'dataListMess'));
    }

    // gửi tin nhắn
    public function sendMessages(Request $request)
    {
        $id_user_from = Auth::user()->id;
        $id_user_to = $request->input('idUserTo');
        $textMess = $request->input('textMessasge');
        $avatar = asset(Auth::user()->avatar);

        $messages = new Message();
        $messages->id_from = $id_user_from;
        $messages->id_to = $id_user_to;
        $messages->content = $textMess;
        $messages->save();

        $dateCurrent = date_format($messages->created_at, 'H:i');

        $countSeenMess = Message::where('id_from', '=', $id_user_from)
            ->where('id_to', '=', $id_user_to)
            ->where('seen', '=', 1)->count();

        event(new SendMessages([
            'text' => $textMess,
            'idUserTo' => $id_user_to,
            'idUserFrom' => $id_user_from,
            'avatar' => $avatar,
            'timeSend' => $dateCurrent,
            'countSeen' => $countSeenMess,
        ]));


        return $textMess;
    }

    // lấy token video call
    public function getToken(Request $request)
    {
        $apiKeySid = 'SK9cyDyFdz5GAtozSC36a62IJodQZNgVVt';
        $apiKeySecret = "aGI0bk8yRWwxY0VWTFhEeWxUb0VsMjRYSWtaUVFETw==";

        $now = time();
        $exp = $now + 3600;

        $username =  $request->input('callerid');

        if (!$username) {
            $jwt = '';
        } else {
            $header = array('cty' => "stringee-api;v=1");
            $payload = array(
                "jti" => $apiKeySid . "-" . $now,
                "iss" => $apiKeySid,
                "exp" => $exp,
                "userId" => $username
            );

            $jwt = JWT::encode($payload, $apiKeySecret, 'HS256', null, $header);
        }

        // $res = array(
        //     'access_token' => $jwt
        // );

        header('Access-Control-Allow-Origin: *');

        return $jwt;
    }

    public function getInforCallee(Request $request)
    {
        $calleeId = $request->input('calleeid');

        $dataUser = User::select('id', 'name', 'avatar')->where('id', '=', $calleeId)->first();

        return $dataUser;
    }
}
