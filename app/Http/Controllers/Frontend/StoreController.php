<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // 
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by');

        $tableCategorys = Category::select('category_id', 'category_name')->get();
        $dataSlides = Slide::orderBy('created_at', 'DESC')->get();

        $minPrice = Archive::min('price');
        $maxPrice = Archive::max('price');

        // return $minPrice;

        if (isset($_GET['sort_by'])) {
            if ($sortBy == 'newest') {
                $dataPets = Product::select('product_id', 'product_name', 'product_description')
                    ->whereHas('getArchive', function ($query) {
                        $query->where('deploy', '=', 1);
                    })
                    ->orderBy('created_at', 'desc')
                    ->with('getArchive', 'getMainImage')
                    ->paginate(9)->appends(request()->query());
            } elseif ($sortBy == 'oldest') {
                $dataPets = Product::select('product_id', 'product_name', 'product_description')
                    ->whereHas('getArchive', function ($query) {
                        $query->where('deploy', '=', 1);
                    })
                    ->orderBy('created_at', 'asc')
                    ->with('getArchive', 'getMainImage')
                    ->paginate(9)->appends(request()->query());
            } elseif ($sortBy == 'kytu_az') {
                // return "đã vào";
                $dataPets = Product::select('product_id', 'product_name', 'product_description')
                    ->whereHas('getArchive', function ($query) {
                        $query->where('deploy', '=', 1);
                        // ->orderBy('price', 'desc');
                    })
                    ->orderBy('product_name', 'asc')
                    ->with('getArchive', 'getMainImage')
                    ->paginate(9)->appends(request()->query());
            } elseif ($sortBy == 'kytu_za') {
                $dataPets = Product::select('product_id', 'product_name', 'product_description')
                    ->whereHas('getArchive', function ($query) {
                        $query->where('deploy', '=', 1);
                        // ->orderBy('price', 'desc');
                    })
                    ->orderBy('product_name', 'desc')
                    ->with('getArchive', 'getMainImage')
                    ->paginate(9)->appends(request()->query());
            }
        } elseif (isset($_GET['start_price']) && isset($_GET['end_price'])) {

            $dataPets = Product::select('product_id', 'product_name', 'product_description')
                ->whereHas('getArchive', function ($query) {

                    $start_price = $_GET['start_price'];
                    $end_price = $_GET['end_price'];

                    $query->where('deploy', '=', 1)
                        ->whereBetween('price', [$start_price, $end_price]);
                })
                ->orderBy('created_at', 'asc')
                ->with('getArchive', 'getMainImage')
                ->paginate(9)->appends(request()->query());
        } else {
            $dataPets = Product::select('product_id', 'product_name', 'product_description')
                ->whereHas('getArchive', function ($query) {
                    $query->where('deploy', '=', 1);
                })
                ->with('getArchive', 'getMainImage')
                ->paginate(9)->appends(request()->query());
        }

        // return $dataPets;
        return view('frontend.pages.store.indexStore', compact('tableCategorys', 'dataSlides', 'minPrice', 'maxPrice', 'dataPets'));
    }

    // lấy sản phẩm theo danh mục
    public function getProductsCategory(Request $request, $id)
    {

        $sortBy = $request->input('sort_by');

        $tableCategorys = Category::select('category_id', 'category_name')->get();
        $dataSlides = Slide::orderBy('created_at', 'DESC')->get();
        $nameCategory = Category::select('category_name')->where('category_id', '=', $id)->first();

        $minPrice = Archive::min('price');
        $maxPrice = Archive::max('price');

        if (isset($_GET['sort_by'])) {
            if ($sortBy == 'newest') {
                $dataPets = Product::select('product_id', 'product_name', 'product_description')
                    ->where('category_id', '=', $id)
                    ->whereHas('getArchive', function ($query) {
                        $query->where('deploy', '=', 1);
                    })
                    ->orderBy('created_at', 'desc')
                    ->with('getArchive', 'getMainImage')
                    ->paginate(9)->appends(request()->query());
            } elseif ($sortBy == 'oldest') {
                $dataPets = Product::select('product_id', 'product_name', 'product_description')
                    ->where('category_id', '=', $id)
                    ->whereHas('getArchive', function ($query) {
                        $query->where('deploy', '=', 1);
                    })
                    ->orderBy('created_at', 'asc')
                    ->with('getArchive', 'getMainImage')
                    ->paginate(9)->appends(request()->query());
            } elseif ($sortBy == 'kytu_az') {
                $dataPets = Product::select('product_id', 'product_name', 'product_description')
                    ->where('category_id', '=', $id)
                    ->whereHas('getArchive', function ($query) {
                        $query->where('deploy', '=', 1);
                        // ->orderBy('price', 'desc');
                    })
                    // ->orderBy('product_name', 'asc')
                    ->with('getArchive', 'getMainImage')
                    ->paginate(9)->appends(request()->query());
            } elseif ($sortBy == 'kytu_za') {
                $dataPets = Product::select('product_id', 'product_name', 'product_description')
                    ->where('category_id', '=', $id)
                    ->whereHas('getArchive', function ($query) {
                        $query->where('deploy', '=', 1);
                        // ->orderBy('price', 'desc');
                    })
                    ->orderBy('product_name', 'desc')
                    ->with('getArchive', 'getMainImage')
                    ->paginate(9)->appends(request()->query());
            }
        } elseif (isset($_GET['start_price']) && isset($_GET['end_price'])) {

            $dataPets = Product::select('product_id', 'product_name', 'product_description')
                ->where('category_id', '=', $id)
                ->whereHas('getArchive', function ($query) {

                    $start_price = $_GET['start_price'];
                    $end_price = $_GET['end_price'];

                    $query->where('deploy', '=', 1)
                        ->whereBetween('price', [$start_price, $end_price]);
                })
                ->orderBy('created_at', 'asc')
                ->with('getArchive', 'getMainImage')
                ->paginate(9)->appends(request()->query());
        } else {
            $dataPets = Product::select('product_id', 'product_name', 'product_description')
                ->where('category_id', '=', $id)
                ->whereHas('getArchive', function ($query) {
                    $query->where('deploy', '=', 1);
                })
                ->with('getArchive', 'getMainImage')
                ->paginate(9)->appends(request()->query());
        }

        // return $dataPets;
        return view('frontend.pages.store.categoryShow.indexStore',  compact('tableCategorys', 'nameCategory','minPrice', 'maxPrice', 'dataSlides', 'dataPets'));
    }
}
