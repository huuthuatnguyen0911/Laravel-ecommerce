<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{
    // index hiển thị sản phẩm
    public function index($id)
    {
        return $id;
    }

    // show tất các comment của 1 sản phẩm
    public function showAllComment(Request $request)
    {
        $idProduct = $request->input('id_product');
        $comments = Comment::where('comments_product_id', '=', $idProduct)->get();
        $commentsMains = Comment::where('comments_product_id', '=', $idProduct)
            ->where('comments_status', '=', 0)
            ->where('comments_parent', '=', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $commentsChildrens = Comment::where('comments_product_id', '=', $idProduct)
            ->where('comments_parent', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $output = '';
        foreach ($commentsMains as $commentsMain) {
            $output .= '
                <li>
                    <div class="single-review" style="border: none; padding:12px 0">
                        <div class="box_main_inf_user">
                            <div class="box_avatar">
                                <img src="' . asset($commentsMain->getUser->avatar == '' ? 'images/user_img.png' : $commentsMain->getUser->avatar) . '" alt="">
                            </div>
                            <div class="box_content">
                                <h6 class="name" style="margin: 0;">' . $commentsMain->getUser->name . '</h6>
                                <div class="rating-date">
                                    <ul class="rating">';

            for ($i = 0; $i < 5; $i++) {
                if ($commentsMain->comments_rating_id != null) {
                    if ($i  < $commentsMain->getRating->rt_star) {
                        $classStar = 'rating-on';
                    } else {
                        $classStar = '';
                    }
                } else {
                    $classStar = '';
                }

                $output .= '<li class="' . $classStar . '"><i class="fa fa-star"></i></li>';
            }

            $output .= '</ul>
                                    <span class="date">' . date_format($commentsMain->created_at, "d/m/Y  H:i") . '</span>
                                </div>
                                <p style="line-height: 1.4;">' . $commentsMain->comments_text . '</p>
                            </div>
                        </div>

                    ';
            foreach ($commentsChildrens as $commentsChildren) {
                if ($commentsChildren->comments_parent == $commentsMain->id && $commentsChildren->comments_product_id == $commentsMain->comments_product_id) {
                    $output .= '
                            <div class="box_main_inf_user box_main_inf_user-reply">
                                <div class="box_avatar">
                                    <img src="' . asset($commentsChildren->getUser->avatar == '' ? 'images/user_img.png' : $commentsChildren->getUser->avatar) . '" alt="">
                                </div>
                                <div class="box_content">
                                    <h6 class="name" style="margin: 0;">' . $commentsChildren->getUser->name . '</h6>
                                    <div class="rating-date">
                                        <ul class="rating">';
                    for ($i = 0; $i < 5; $i++) {
                        if ($commentsChildren->comments_rating_id != null) {
                            if ($i  < $commentsChildren->getRating->rt_star) {
                                $classStar = 'rating-on';
                            } else {
                                $classStar = '';
                            }
                        } else {
                            $classStar = '';
                        }
                        $output .= '<li class="' . $classStar . '"><i class="fa fa-star"></i></li>';
                    }

                    $output .= '</ul>
                                        <span class="date">' . date_format($commentsChildren->created_at, "d/m/Y  H:i") . '</span>
                                    </div>
                                    <p style="line-height: 1.4;">' . $commentsChildren->comments_text . '</p>
                                </div>
                            </div>
                        
                        ';
                }
            }
            $output .= '
                </div>
                </li>
                ';
        }
        return  $output;
    }

    // nhận và tạo một comment mới
    public function sendComment(Request $request)
    {
        // return $request->all();
        $idProduct = $request->input('id_product');
        $idUser = $request->input('id_user');
        $valueComment = $request->input('valueComment');
        $value_rating = $request->input('value_rating');

        if ($value_rating != null) {
            $insertGetIDRating = Rating::insertGetId([
                'rt_user_id' => $idUser,
                'rt_product_id' => $idProduct,
                'rt_star' => $value_rating,
            ]);
        }

        $dataTable = new Comment();
        $dataTable->comments_user_id = $idUser;
        $dataTable->comments_product_id = $idProduct;
        $dataTable->comments_text = $valueComment;
        $dataTable->comments_parent = 0;
        $dataTable->comments_status = 0;
        if ($value_rating != null) {
            $dataTable->comments_rating_id =  $insertGetIDRating;
        }
        $dataTable->save();

        return $dataTable;
    }
}
