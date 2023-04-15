<?php

namespace App\Http\Controllers\Admins\Manages;

use App\Http\Controllers\Controller;
use App\Models\MultiplePicture;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ImagesProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.pages.product.imageproduct');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllImage()
    {
        // ,'getItem'
        $data = MultiplePicture::with('getProduct');

        return DataTables::of($data)
            ->addColumn('image', function ($data) {
                return '<img src="' . asset($data->link_image ). '" alt=""  data-id="' . $data->id . '" style="height: 100px; object-fit: cover;" class="rounded float-left"> <input type="file" accept="image/*" name="edit_image" class="inputImageProduct" style="display: none;"> <span class="errorMessImage"></span>';
            })
            ->editColumn('alt_image', function ($data) {
                return ' <textarea name="textareaEdit" class="textareaMoTa" id="" cols="5" rows="3" style="width: 100%;" disabled >' . $data->alt_image . '</textarea>';
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . route('imageproduct.store') . '" data-id="' . $data->id . '" class="btn btn-outline-primary btn_edit_image_product"><i class="fa fa-edit"></i></a>  <a href="' . route('imageproduct.destroy', $data->id) . '" class="btn btn-outline-danger btn_delete_image"><i class="fa  fa-trash-o"></i></a>';
            })
            ->rawColumns(['image', 'action', 'alt_image'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // chỉnh ảnh
        $storedPath = "";
        if ($request->hasFile('fileData')) {
            $file = $request->file('fileData');
            $name = $file->getClientOriginalName();
            $storedPath = $file->move('images_upload/product_images', $name);

            $tableProduct = MultiplePicture::where('id', '=', $request->input('id'))
                ->update([
                    'link_image' => $storedPath,
                ]);

            if ($tableProduct == 1) {
                return response()->json([
                    'status' => 'successEdit',
                    'linkImage' => (string)$storedPath,
                    'Mess' => 'Sửa ảnh thành công'
                ]);
            }
        }

        // chỉnh mô tả ảnh
        if ($request->exists('contentEdit')) {
            $tableProduct = MultiplePicture::where('id', '=', $request->input('idEditText'))
                ->update([
                    'alt_image' => $request->input('contentEdit'),
                ]);
            return true;
        }

        // kiểm tra số lượng ảnh
        if ($request->exists('checkNumberImage')) {
            $idCheck = $request->input('checkNumberImage');
            $count = MultiplePicture::where('product_id', '=', $idCheck)->count();
            if ($count == 4) {
                return response()->json([
                    'status' => 'errorCount',
                    'mess' => 'Sản phẩm đã có đủ 4 ảnh',
                ]);
            }
            return true;
        }

        // thêm ảnh
        if ($request->hasFile('fileAddImage')) {
            $IDProduct = $request->input('idPrroduct');

            $existsCheck =  MultiplePicture::where('product_id', '=', $IDProduct)->exists();
            if ($existsCheck == true) {

                $file = $request->file('fileAddImage');
                $name = $file->getClientOriginalName();
                $storedPath = $file->move('images_upload/product_images', $name);

                $tableImage = new MultiplePicture();
                $tableImage->product_id = $IDProduct;
                $tableImage->link_image = $storedPath;
                $tableImage->alt_image = $request->input('altImageAdd');
                $tableImage->save();

                return response()->json([
                    'status' => 'successAddImage',
                    'mess' => 'Thêm ảnh thành công'
                ]);
            }
            return response()->json([
                'status' => 'errorAddImage',
                'mess' => 'Sản phẩm không tồn tại',
            ]);
        }

        return response()->json([
            'status' => 'errorsEdit',
            'Mess' => 'Sửa ảnh không thành công'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = MultiplePicture::where('id', '=', $id)->delete();
        return $result;

    }
}
