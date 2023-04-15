<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataSlides = Slide::orderBy('created_at', 'DESC')->get();
        $dataNewPets = Product::select('product_id', 'product_name', 'product_description')->whereHas('getArchive', function ($query) {
            $query->where('deploy', '=', 1);
        })
            ->orderBy('created_at', 'desc')
            ->with('getArchive', 'getMainImage')
            ->limit(10)
            ->get();
        $dataarr2 = Product::select('product_id', 'product_name', 'product_description')->whereHas('getArchive', function ($query) {
            $query->where('deploy', '=', 1);
        })
            ->orderBy('created_at', 'desc')
            ->with('getArchive', 'getMainImage')
            ->skip(10)
            ->take(10)
            ->get();

        $arrlists = array();
        $accept = ['DTIPHONE_00', 'DTSAMSUNG_00','DTXIAOMI_00',];

        for ($i = 0; $i <= 16; $i += 2) {
            $data = Product::select('product_id', 'product_name', 'product_description')->whereHas('getArchive', function ($query) {
                $query->where('deploy', '=', 1);
            })
                ->orderBy('created_at', 'desc')
                ->whereIn('category_id', $accept)
                ->with('getArchive', 'getMainImage')
                ->skip($i)
                ->take(2)
                ->get();
            array_push($arrlists, $data);
        }

        $arrlistsNotPets = array(); 
        $except = ['DTIPHONE_00', 'DTSAMSUNG_00','DTXIAOMI_00',];

        for ($i = 0; $i <= 16; $i += 2) {
            $data = Product::select('product_id', 'product_name', 'product_description')->whereHas('getArchive', function ($query) {
                $query->where('deploy', '=', 1);
            })
                ->orderBy('created_at', 'desc')
                ->whereNotIn('category_id', $except)
                ->with('getArchive', 'getMainImage')
                ->skip($i)
                ->take(2)
                ->get();
            array_push($arrlistsNotPets, $data);
        }

        $posts = Post::where('p_status', '=', 0)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // return $posts;
        return view('frontend.pages.home.index', compact('dataSlides', 'dataNewPets', 'arrlists', 'arrlistsNotPets', 'posts'));
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
