<?php

namespace App\Http\Controllers\Admins\Manages;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listCategorys = Category::pluck('category_name', 'category_id');
        return view('admins.pages.product.index', compact('listCategorys'));
    }

    /**
     * getListData of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListData(Request $request)
    {
        $data = Product::with('category', 'getMainImage');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '<a href="' . route('products.show', $data->product_id) . '" class="btn btn-outline-primary btn_edit_product"><i class="fa fa-edit"></i></a>  <a href="' . route('products.destroy', $data->product_id) . '" class="btn btn-outline-danger btn_delete_product" data-id="' . $data->product_id . '" ><i class="fa  fa-trash-o"></i></a>';
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
        $checkDeploy = 0;
        if ($request->input('switch1')) {
            $checkDeploy = 1;
        }
        $idProduct = $request->input('IDProduct');

        $delimiters = array(".", ",");

        $keywords = str_replace($delimiters, $delimiters[0], $request->input('PriceImport'));
        $priceImportArr = explode($delimiters[0], $keywords);
        $priceImport = implode("", $priceImportArr);

        $keywords1 = str_replace($delimiters, $delimiters[0], $request->input('PriceProduct'));
        $PriceProducttArr = explode($delimiters[0], $keywords1);
        $priceProduct = implode("", $PriceProducttArr);

        $tableProduct = Product::where('product_id', '=', $idProduct)
            ->update([
                'product_name' => $request->input('NameProduct'),
                'product_description' => $request->input('Description'),
                'product_sub_description' => $request->input('SubDescription'),
                'category_id' => $request->input('inputListCategory'),
            ]);

        $tableArchive = Archive::where('id_archive', '=', $request->input('IDArchives'))
            ->update([
                'quantity' => $request->input('QuantityProduct'),
                'import_price' => $priceImport,
                'price' => $priceProduct,
                'deploy' => $checkDeploy,
            ]);
        if ($tableArchive == 1 && $tableProduct == 1) {
            session()->put('successEditProduct', 'Sửa sản phẩm thành công');
            return redirect()->back();
        }
        session()->put('errEditProduct', 'Sửa sản phẩmm không thành công');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::where('product_id', $id)->with('getArchive')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $id;
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
        $result = Product::where('product_id', '=', $id)->first();
        $result->getAllImage()->delete();
        $result->getArchive()->delete();
        Product::where('product_id', '=', $id)->delete();

        return $result;
    }

    // lấy chi tiết sản phẩm
    public function detailProduct(request $request, $id)
    {
        $productInf = Product::where('product_id', '=', $id)->with('category', 'getAllImage', 'getArchive')->first();
        $category = $productInf->category_id;
        $similarProducts = Product::select('product_id', 'product_name', 'product_description')->whereHas('getArchive', function ($query) {
            $query->where('deploy', '=', 1);
        })
            ->where('category_id', '=', $category)
            ->orderBy('created_at', 'desc')
            ->with('getArchive', 'getMainImage','avgRating')
            ->limit(10)
            ->get();
        // return $productInf->getAllImage[0]->link_image;
        $urlProduct = $request->url();
        $urlImage = url($productInf->getAllImage[0]->link_image);

        $rating = Rating::where('rt_product_id', '=', $id)->avg('rt_star');
        $rating = round($rating);

        // return $similarProducts;
        return view('frontend.pages.detail_product.index', compact('productInf','similarProducts', 'urlProduct', 'urlImage', 'rating'));
    }

    

}
