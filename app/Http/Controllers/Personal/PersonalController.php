<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Post;
use App\Models\Province;
use App\Models\Transaction;
use App\Models\Transport;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PersonalController extends Controller
{
    public function indexHome()
    {
        $dataPosts = Post::select('p_title', 'id', 'created_at', 'p_link_image', 'updated_at', 'p_id_user')
            ->where('p_id_user', '=', Auth::user()->id)
            ->where('p_status', '=', 0)
            ->with('getUser', 'getLike')
            ->orderBy('created_at', 'desc')
            ->get();
        // return $dataPosts;

        return view('personal.pages.home.index_2', compact('dataPosts'));
    }

    public function indexOrderMy()
    {
        $id = Auth::user()->id;

        $dataOrderWattings = Transaction::where('transactions_user_id', '=', $id)
            ->where('transactions_status', '!=', 3)
            ->with('getOrder')
            ->get();

        $dataTransports = Transport::whereHas('getTransaction', function ($query) {
            $id = Auth::user()->id;
            $query->where('transactions_user_id', '=', $id)
                ->where('transactions_status', '=', 3);
        })
            ->with('getOrder')
            ->get();
        // return $data;

        // return $dataTransport;
        return view('personal.pages.order_my.index_2', compact('dataOrderWattings', 'dataTransports'));
    }

    // index thiết lập
    public function indexSetting(Request $request)
    {
        $id = Auth::user()->id;
        $provice = Province::orderBy('_name', 'ASC')->get();
        $district = District::where('_province_id', '=', Auth::user()->getInfor->id_province)->orderBy('_name', 'ASC')->get();
        $ward = Ward::where('_district_id', '=', Auth::user()->getInfor->id_district)
            ->where('_province_id', '=', Auth::user()->getInfor->id_province)
            ->orderBy('_name', 'ASC')
            ->get();

        if ($request->ajax()) {
            $codeRequest = $request->input('code');
            if ($codeRequest == 'searchProvince') {
                $idProvince = $request->input('idProvince');

                $subDistrict = District::where('_province_id', '=', $idProvince)->orderBy('_name', 'ASC')->get();

                $outputDistrict = '';
                foreach ($subDistrict as $item) {
                    $outputDistrict .= '<option value="' . $item->id . '" selected>' . $item->_name . '</option>';
                }

                $subWard = Ward::where('_district_id', '=', $subDistrict[0]->id)
                    ->where('_province_id', '=', $idProvince)
                    ->orderBy('_name', 'ASC')
                    ->get();

                $outputWard = '';
                foreach ($subWard as $item) {
                    $outputWard .= '<option value="' . $item->id . '" selected>' . $item->_name . '</option>';
                }

                return response()->json([
                    $outputDistrict,
                    $outputWard,
                ]);
            }

            if ($codeRequest == 'searchDistrict') {
                $idProvince = $request->input('idProvince');
                $idDistrict = $request->input('idDistrict');

                $subWard = Ward::where('_district_id', '=', $idDistrict)
                    ->where('_province_id', '=', $idProvince)
                    ->orderBy('_name', 'ASC')
                    ->get();

                $outputWard = '';
                foreach ($subWard as $item) {
                    $outputWard .= '<option value="' . $item->id . '" selected>' . $item->_name . '</option>';
                }

                return $outputWard;
            }
            return $request->all();
        }
        return view('personal.pages.setting.index', compact('provice', 'district', 'ward'));
    }

    // đặt lại mật khẩu
    public function settingPassword(Request $request)
    {
        $id = $request->input('idUser');

        $user = User::find($id);
        $user->password = Hash::make($request->input('inputPassword'));
        $user->save();

        return redirect()->back();
    }
}
