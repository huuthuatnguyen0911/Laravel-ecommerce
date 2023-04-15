<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\InforUser;
use App\Models\Post;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //profile của admin
    public function indexMyProfileAdmin(Request $request)
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

        return view('admins.pages.profile.index', compact('provice', 'district', 'ward'));
    }

    // chỉnh sửa trang cá nhân admin
    public function MyProfileAdminEdit(request $request, $id)
    {
        $inputContent = $request->input('inputContent');
        $inputName = $request->input('inputName');
        $inputPhone = $request->input('inputPhone');
        $selectProvince = $request->input('selectProvince');
        $selectDistrict = $request->input('selectDistrict');
        $selectWard = $request->input('selectWard');
        $inputStreet = $request->input('inputStreet');

        $dataInforUser = InforUser::where('id_user', '=', $id)
            ->update([
                'id_province' => $selectProvince,
                'id_district' => $selectDistrict,
                'id_ward' => $selectWard,
                'street' => $inputStreet,
                'phone' => $inputPhone,
                'content' => $inputContent,
            ]);

        $dataUser = User::where('id', '=', $id)
            ->update([
                'name' => $inputName,
            ]);

        if ($dataUser == 1 && $dataInforUser == 1) {
            return redirect()->back();
        }

        return redirect()->back();
    }

    // trang thông tin cá nhân người dùng
    public function indexPersonalPage(Request $request, $id)
    {
        $user = User::where('id', '=', $id)->first();
        $dataPosts = Post::select('p_title', 'id', 'created_at', 'p_link_image', 'updated_at', 'p_id_user')
            ->where('p_id_user', '=', $id)
            ->where('p_status', '=', 0)
            ->with('getUser', 'getLike')
            ->orderBy('created_at', 'desc')
            ->get();

        // return $user;
        return view('frontend.pages.community.index_personal_page', compact('user','dataPosts'));
    }
}
