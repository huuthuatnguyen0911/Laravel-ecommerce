<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class InformationController extends Controller
{
    // Lấy thong tin của một pet
    public function getInfPet($id)
    {
        $request = Product::select('product_id', 'product_name', 'product_description')->where('product_id', $id)->with('getMainImage', 'getArchive')->first();
        return $request;
    }

    // chuyển tới wishlist
    public function showWishlist()
    {
        return view('frontend.pages.wishlist.index');
    }

    // chuyển hướng tới so sánh
    public function showCompare()
    {
        return view('frontend.pages.compare.index');
    }

    // Lấy thông tin danh sách sản phẩmm
    public function getListsProduct(request $request)
    {
        $dataRequest = $request->input('requestData');

        if ($dataRequest == 'danhSachTimKiem') {
            $dataSearch = $request->input('dataSearch');
            $results = Product::select('product_id', 'product_name', 'product_description')
                ->where('product_name', 'like', '%' . $dataSearch . '%')
                ->whereHas('getArchive', function ($query) {
                    $query->where('deploy', '=', 1);
                })
                ->orderBy('created_at', 'desc')
                ->with('getArchive', 'getMainImage')
                ->get();

            $output = '<ul id="navListProducts">';

            foreach ($results as $result) {
                $output .= '
                <li class="itemProduct" data-id="' . $result->product_id . '">
                <form action="">
                <input type="hidden" id="quantityProduct_' . $result->product_id . '" value="' . $result->getArchive->quantity . '">
                <input type="hidden" id="urlProduct_' . $result->product_id . '" value="' . route("product.detailproduct", $result->product_id) . '">
                </form>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="boxMainImageListproduct">
                                        <img class="imgModalSearch" id="imgModalSearch_' . $result->product_id . '" src="' . url('/' . $result->getMainImage->link_image) . '" alt="" style="">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="box_main_content_modal" style="margin: 0;">
                                        <h4 id="nameProduct_' . $result->product_id . '">' . $result->product_name . '</h4>
                                        <p class="description" id="descriptionProduct_' . $result->product_id . '" style="">' . $result->product_description . '</p>
                                        <p style="color: #f34f3f;" id="priceProduct_' . $result->product_id . '">' . number_format($result->getArchive->price) . '</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                ';
            }

            $output .= '</ul>';

            return $output;
        }

        return 0;
    }
}
