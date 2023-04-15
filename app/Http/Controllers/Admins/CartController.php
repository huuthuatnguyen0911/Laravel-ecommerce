<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    // view user cart
    public function indexViewUser()
    {

        $dataCats = Cart::where('id_user', '=', Auth::user()->id)->with('getProduct')->get();
        $dataUser = Auth::user()->getInfor;
        // return $dataUser;
        return view('frontend.pages.cart.index', compact('dataCats','dataUser'));
    }

    // Thêm cart
    public function addCart(Request $request)
    {
        $idUser = $request->input('id_User');
        $idProduct = $request->input('id_product');
        $quantity = $request->input('quantity');


        $exist = Cart::where('id_user', '=', $idUser)->where('id_product', '=', $idProduct)->exists();
        if ($exist) {
            return response()->json([
                'success' => 'tontai',
                'mess' => 'Sản phẩm đã có trong giỏ hàng',
            ]);
        } else {
            $result = Cart::create([
                'id_user' => $idUser,
                'id_product' => $idProduct,
                'quantity' => $quantity,
            ]);

            return response()->json([
                'success' => 'themthanhcong',
                'mess' => 'Đã thêm vào giỏ hàng',
                'data' => $result,
            ]);
        }
        return 0;
    }

    // Thêm nhiều cart
    public function addListCart(Request $request)
    {
        $id_user = $request->input('id_user');
        $dataIdListCarts = $request->input('dataCartList');

        foreach ($dataIdListCarts as $dataIdListCart) {
            $exist = Cart::where('id_user', '=', $id_user)->where('id_product', '=', $dataIdListCart)->exists();
            if (!$exist) {
                $result = Cart::create([
                    'id_user' => $id_user,
                    'id_product' => $dataIdListCart,
                    'quantity' => 1,
                ]);
            }
        }
        return response()->json([
            'success' => 'themthanhcong',
            'mess' => 'Đã thêm vào giỏ hàng',
            'data' => $result,
        ]);
    }

    // Lấy danh sách cart khung nhỏ
    public function subCart(request $request)
    {
        $idUser = $request->input('id_user');
        $datas = Cart::where('id_user', '=', $idUser)->with('getProduct')->get();

        $html = '';
        $totalPrice = 0;

        foreach ($datas as $data) {

            $totalPrice += $data->getProduct->getArchivePrice->price * $data->quantity;

            $html .= '
            <div class="single-cart-box">
                <div class="cart-img">
                    <a href="' . route('product.detailproduct', $data->id_product) . '"><img src="' . asset($data->getProduct->getMainImage->link_image) . '" alt=""></a>
                    <span class="pro-quantity">' . $data->quantity . 'x</span>
                </div>
                <div class="cart-content">
                    <h6 class="title"><a href="' . route('product.detailproduct', $data->id_product) . '">' . $data->getProduct->product_name . '</a></h6>
                    <div class="cart-price">
                        <span class="sale-price">' . number_format($data->getProduct->getArchivePrice->price) . '</span>
                    </div>
                </div>
                <a href="' . route('cart.delete', $data->id) . '" data-id="' . $data->id . '" class="del-icon itemDeleteCart"><i class="fa fa-trash"></i></a>
            </div>
            ';
        };

        return response()->json([
            'dataHtml' => $html,
            'total' => number_format($totalPrice),
            'count' =>  $datas->count(),
        ]);
    }

    // lấy dánh sách cập nhật giỏ hàng chính
    public function mainCartUpdate(request $request)
    {
        $idUser = $request->input('id_user');
        $dataCats = Cart::where('id_user', '=', $idUser)->with('getProduct')->get();

        $html = '';
        // $totalPrice = 0;

        foreach ($dataCats as $dataCat) {

            // $totalPrice += $dataCat->getProduct->getArchivePrice->price * $dataCat->quantity;

            $html .= '
            <tr>
                <input type="hidden" id="quantity_'.$dataCat->id.'" value="'.$dataCat->quantity.'">
                <input type="hidden" id="price_'.$dataCat->id.'" value="'.$dataCat->getProduct->getArchivePrice->price.'">
                <input type="hidden" id="totalPrice_'.$dataCat->id.'" value="'.$dataCat->getProduct->getArchivePrice->price * $dataCat->quantity.'">

                <td>
                    <input type="checkbox" class="check_item" id="" value="' . $dataCat->id . '" />
                </td>
                <td class="image">
                    <img src="' . asset($dataCat->getProduct->getMainImage->link_image) . '" style="width: 90px; height: 100%; object-fit: cover;" alt="">
                </td>
                <td class="product text-center">
                    <a href="' . route('product.detailproduct', $dataCat->id_product) . '" class="overfow_text" style="width: 200px; margin: auto;">' . $dataCat->getProduct->product_name . '</a>
                </td>
                <td class="price">
                    <span class="amount">' . number_format($dataCat->getProduct->getArchivePrice->price) . '</span>
                </td>
                <td style="width: 100px;">
                    <form action="#" class="formUpdateCart" data-id="' . $dataCat->id . '">
                        <input type="hidden" name="idCartUpdate" value="' . $dataCat->id . '">
                        <div class="shop-single-content mb-2">
                            <div class="quantity d-flex">
                                <button type="button"  data-id="' . $dataCat->id . '" class="sub"><i class="ti-minus"></i></button>
                                <input type="text" id="id_quantity_main_product_' . $dataCat->id . '" name="quantityUpdate" value="' . $dataCat->quantity . '" />
                                <button type="button" data-id="' . $dataCat->id . '" class="add"><i class="ti-plus"></i></button>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary btn-sm btnSubmitFormCart"name="submitFormCartUpdate" value="Áp dụng">
                    </form>
                </td>
                <td class="totalPrice ">
                    <p class="">' . number_format($dataCat->getProduct->getArchivePrice->price * $dataCat->quantity) . '</p>
                </td>
                <td class="remove">
                    <button type="button" class="btn btn-outline-danger  deleteCart" data-link="' . route('cart.delete', $dataCat->id) . '" data-id="' . $dataCat->id . '" style="border-color: #dc3545;"><i class="fa  fa-trash-o"></i></button>
                </td>
            </tr>
            ';
        };

        return response()->json([
            'dataHtml' => $html,
            // 'total' => number_format($totalPrice),
        ]);
    }

    // Cập nhật lại giỏ hàng
    public function updateInforCart(request $request)
    {
        $idCart = $request->input('id');
        $quantity = $request->input('quantity');

        $result = Cart::find($idCart)->update([
            'quantity' => $quantity,
        ]);

        return$result;
    }

    // cập nhật lại trang thái chọn cart
    public function updateCheckCart(Request $request)
    {
        $check = $request->input('dataCheck');
        $id = $request->input('id');

        $result = Cart::find($id)->update([
            'check' => (string)$check,
        ]);

        return $result;

    }

    // Xóa cart
    public function deleteCart($id)
    {
        $result = Cart::where('id', $id)->delete();
        return $result;
    }

    // xóa tất cả cart
    public function deleteAllCart()
    {
        Cart::truncate();
        return redirect()->back();
    }
}
