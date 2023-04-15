<?php

namespace App\Http\Controllers\Admins\Manages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PersonalItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PersonalItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listCategorys = Category::pluck('category_name', 'category_id');
        return view('admins.pages.product.itempersonal', compact('listCategorys'));
    }

    /**
     * getListData of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListDataItem(Request $request)
    {
        $data = PersonalItem::with('category', 'getMainImage');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '<a href="' . route('item.show', $data->item_id) . '" class="btn btn-outline-primary btn_edit_product"><i class="fa fa-edit"></i></a>  <a href="' . route('item.destroy', $data->item_id) . '" class="btn btn-outline-danger btn_delete_product" data-id="' . $data->item_id . '" ><i class="fa  fa-trash-o"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        // }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PersonalItem::where('item_id', $id)->with('getArchive')->first();
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
