<?php

namespace App\Http\Controllers\Admins\Manages;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.pages.archive.index');
    }

    public function getListArchive()
    {
        $data = Archive::with('getProduct');
        return DataTables::of($data)
            ->editColumn('import_price', function ($data) {
                return  number_format($data->import_price);
            })
            ->editColumn('price', function ($data) {
                return  number_format($data->price);
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . route('archive.show', $data->id_archive) . '" data-id="' . $data->id_archive . '" class="btn btn-outline-primary btn_edit_archive"><i class="fa fa-edit"></i></a>';
            })
            ->editColumn('deploy', function ($data) {
                if ($data->deploy == '1') {
                    return '<span class="badge badge-success">Đang hiển thị</span>';
                } else {
                    return '<span class="badge badge-secondary">Không hiển thị</span>';
                }
            })
            ->rawColumns(['import_price', 'price', 'action', 'deploy'])
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
        $check = 0;
        if ($request->has('switch1')) {
            $check = 1;
        }

        $delimiters = array(".", ",");

        $keywords = str_replace($delimiters, $delimiters[0], $request->input('PriceImport'));
        $priceImportArr = explode($delimiters[0], $keywords);
        $priceImport = implode("", $priceImportArr);

        $keywords1 = str_replace($delimiters, $delimiters[0], $request->input('PriceProduct'));
        $PriceProducttArr = explode($delimiters[0], $keywords1);
        $priceProduct = implode("", $PriceProducttArr);

        $result = Archive::where('id_archive', '=', $request->input('IDArchives'))
            ->update([
                'quantity' => $request->input('QuantityProduct'),
                'import_price' => $priceImport,
                'price' => $priceProduct,
                'deploy' => $check,
            ]);

        if($result == 1){
            return response()->json([
                'status' => 'successEditArchive',
                'message' => 'Sửa thành công',
            ]);
        }
        return response()->json([
            'status' => 'errorEditArchive',
            'message' => 'Sửa không thành công',
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
        $request = Archive::where('id_archive', '=', $id)->with('getProduct')->first();
        return $request;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
