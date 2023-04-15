<?php

namespace App\Http\Controllers\Golobal;

use App\Http\Controllers\Controller;
use App\Models\FriendShip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    // Thên bạn bè
    public function addFriend(Request $request)
    {
        $id_friend = $request->input('id_friend');
        $codeCheck = $request->input('codeCheck');
        $id_user = Auth::user()->id;

        $buttonRemoveFriend = '
        <button class="btn_remove_friend" data-id="'.$id_friend.'">
            <span>Bạn bè</span>
            <i class="fas fa-user-friends" style="font-size:14px"></i>
            <!-- <i class="fas fa-plus" style="font-size:14px"></i> -->
        </button>
        ';

        $buttonAddFriend = '
        <button class="btn_add_friend" data-id="'.$id_friend.'">
            <span>Kết bạn</span>
            <i class="fas fa-plus" style="font-size:14px"></i>
        </button>
        ';

        if ($codeCheck == 'addFriend') {
            $tableFriendShip = new FriendShip();
            $tableFriendShip->fs_id_user = $id_user;
            $tableFriendShip->fs_id_friend = $id_friend;
            $tableFriendShip->save();

            $tableFriendShip2 = new FriendShip();
            $tableFriendShip2->fs_id_user = $id_friend;
            $tableFriendShip2->fs_id_friend = $id_user;
            $tableFriendShip2->save();

            return response()->json([
                'status' => 'successAdd',
                'mess' => 'Thêm bạn thành công',
                'buttonRemove' => $buttonRemoveFriend,
            ]);
        }

        if($codeCheck == 'removeFriend'){
            FriendShip::where('fs_id_user', '=', $id_user)
            ->where('fs_id_friend', '=', $id_friend)
            ->delete();

            FriendShip::where('fs_id_user', '=', $id_friend)
            ->where('fs_id_friend', '=', $id_user)
            ->delete();

            return response()->json([
                'status' => 'successRemove',
                'mess' => 'Hủy kết bạn thành công',
                'buttonAdd' => $buttonAddFriend,
            ]);

        }

        return $codeCheck;
    }
}
