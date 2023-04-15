<?php

namespace App\Http\Controllers\Admins\Manages;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Category;
use App\Models\MultiplePicture;
use App\Models\PersonalItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddProductController extends Controller
{
    public function index()
    {
        // $user_inf = Auth::user();
        // $role_inf = User::where('id', $user_inf->id)->with('getInfRole')->first();
        $listCategorys = Category::pluck('category_name', 'category_id');
        // return $listCategory;
        return view('admins.pages.product.addproduct', compact('listCategorys'));
    }

    public function checkExistProduct(request $request)
    {
        $idProduct = $request->input('IdProduct');
        $result = Product::where('product_id', '=', $idProduct)->exists();
        if ($result) return response()->json(['status' => '304existsproduct', 'title' => 'Mã sản phẩm đã tồn tại']);;
        return 0;
    }
    public function checkExistArchive(request $request)
    {
        $idArchive = $request->input('IdCategory');
        $result = Archive::where('id_archive', '=', $idArchive)->exists();
        if ($result) return response()->json(['status' => '304existsarchive', 'title' => 'Mã kho đã tồn tại']);;
        return 0;
    }
    public function addInfProduct(request $request)
    {
        // return $request->all();
        // return $request->all();

        $checkDeploy = 0;
        if ($request->input('switch1')) {
            $checkDeploy = 1;
        }
        $idProduct = $request->input('IDProduct');
        $get_image = $request->file('ImageProduct');

        $sub_description = "";
        if ($request->input('SubDescription') == '') {
            $sub_description = "Chưa có thông tin chi tiết sản phẩm";
        } else {
            $sub_description = $request->input('SubDescription');
        }

        $delimiters = array(".", ",");

        $keywords = str_replace($delimiters, $delimiters[0], $request->input('PriceImport'));
        $priceImportArr = explode($delimiters[0], $keywords);
        $priceImport = implode("", $priceImportArr);

        $keywords1 = str_replace($delimiters, $delimiters[0], $request->input('PriceProduct'));
        $PriceProducttArr = explode($delimiters[0], $keywords1);
        $priceProduct = implode("", $PriceProducttArr);

        if ($get_image) {
            foreach ($get_image as $image) {
                $get_name_image = $image->getClientOriginalName();
                $storedPath = $image->move('images_upload/product_images', $get_name_image);

                $tableImages = new MultiplePicture();
                $tableImages->product_id = $idProduct;
                $tableImages->link_image = $storedPath;
                $tableImages->save();
            }
        };

 
            $tableProduct = new Product();
            $tableProduct->product_id = $idProduct;
            $tableProduct->product_name = $request->input('NameProduct');
            $tableProduct->product_description = $request->input('Description');
            $tableProduct->product_sub_description = $sub_description;
            $tableProduct->category_id = $request->input('inputListCategory');
            $tableProduct->save();
        // } else if ($request->input('radioCategory') == 'sanphamradio') {
        //     $tableItem = new PersonalItem();
        //     $tableItem->item_id = $idProduct;
        //     $tableItem->item_name = $request->input('NameProduct');
        //     $tableItem->item_description = $request->input('Description');
        //     $tableItem->item_sub_description = $sub_description;
        //     $tableItem->category_id = $request->input('inputListCategory');
        //     $tableItem->save();
        // } else {
        //     return " vào cuối";
        // }



        $tableArchive = new Archive();
        $tableArchive->id_archive = $request->input('IDArchives');
        $tableArchive->product_id = $idProduct;
        $tableArchive->quantity = $request->input('QuantityProduct');
        $tableArchive->import_price = $priceImport;
        $tableArchive->price = $priceProduct;
        $tableArchive->deploy = $checkDeploy;
        $tableArchive->save();

        session()->put('successAddProduct', 'Thêm sản phẩm thành công');

        return redirect()->back();
    }
}
