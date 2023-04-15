<?php

namespace App\Http\Controllers\Admins\Manages;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\InforUser;
use App\Models\Post;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // nhân viên
    public function indexStaff(request $request)
    {
        $data = User::select('id', 'name', 'email', 'address', 'phone', 'avatar', 'created_at')->where('role_id', '=', 2);

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('avatar', function ($data) {
                    return '<img src="' . asset($data->avatar) . '" alt="" style="height: 50px; object-fit: cover;" class="rounded float-left">';
                })
                ->editColumn('created_at', function ($data) {
                    return date_format($data->created_at, 'd-m-Y H:i:s');
                })
                ->addColumn('phone', function ($data) {
                    if ($data->getInfor->phone == '') {
                        return 'Chưa cập nhật';
                    } else {

                        return $data->getInfor->phone;
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('user.staff.view', $data->id) . '" class="btn btn-outline-success btn_edit_product"><i class="mdi mdi-eye"></i></a>  
                <a href="' . route('user.delete', $data->id) . '" class="btn btn-outline-danger btn_delete_staff" ><i class="fa  fa-trash-o"></i></a>';
                })
                ->addColumn('countOrder', function ($data) {
                    return $data->getTransport->count();
                })
                ->rawColumns(['action', 'avatar', 'countOrder', 'created_at'])
                ->make(true);
        }

        return view('admins.pages.user.staff.index');
    }

    // xem hồ đồ sơ nhân viên
    public function view_infor_staff($id)
    {
        $user = User::find($id);

        return view('admins.pages.user.staff.view_profile', compact('user'));
    }

    // khách hàng 
    public function indexCustomer(request $request)
    {
        $data = User::select('id', 'name', 'email', 'address', 
        'phone'
        , 'avatar', 'created_at')->where('role_id', '=', 0);

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('avatar', function ($data) {
                    return '<img src="' . asset($data->avatar) . '" alt="" style="height: 50px; object-fit: cover;" class="rounded float-left">';
                })
                ->editColumn('created_at', function ($data) {
                    return date_format($data->created_at, 'd-m-Y H:i:s');
                })
                // ->addColumn('phone', function ($data) {
                //     if ($data->getInfor->phone == '') {
                //         return 'Chưa cập nhật';
                //     } 
                //     else {

                //         return $data->getInfor->phone;
                //     }
                // })
                ->addColumn('posts', function ($data) {
                    return $data->getPosts->count();
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('personal.page.index', $data->id) . '" class="btn btn-outline-success btn_edit_product"><i class="mdi mdi-eye"></i></a>  
                <a href="' . route('user.delete', $data->id) . '" class="btn btn-outline-danger btn_delete_staff" ><i class="fa  fa-trash-o"></i></a>';
                })
                ->addColumn('countOrder', function ($data) {
                    return $data->getTransport->count();
                })
                ->rawColumns(['action', 'avatar', 'countOrder', 'created_at', 'posts'])
                ->make(true);
        }
        return view('admins.pages.user.customer.index');
    }

    // xóa user
    public function deleteUser($id)
    {
        User::where('id', '=', $id)->delete();
        InforUser::where('id_user', '=', $id)->delete();
        Post::where('p_id_user', '=', $id)->delete();
        return redirect()->back();
    }
}
