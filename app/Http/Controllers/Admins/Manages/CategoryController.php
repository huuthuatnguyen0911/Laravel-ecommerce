<?php

namespace App\Http\Controllers\Admins\Manages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return 
        // dd(request()->keySearchCategory);

        // $user_inf = Auth::user();
        // $role_inf = User::where('id', $user_inf->id)->with('getInfRole')->first();
        $categories = $this->categoryRepository->getPagination(20);
        if (request()->has('keySearchCategory')) {
            // return "có rồi";
            $keySearchCategory = request()->keySearchCategory;
            $categories = $this->categoryRepository->searchPaginationCondition($keySearchCategory, 20);
            // return $categories;
            return view('admins.pages.category.index', compact('categories', 'keySearchCategory'));
        }
        return view('admins.pages.category.index', compact('categories'));
    }

    /**
     * Display a listing saerch.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchCategory()
    {
        return "vào rồi";
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
        if ($request->hasFile('avatarCategory_n')) {

            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('avatarCategory_n');
            $extension = $files->getClientOriginalExtension();
            $name = $files->getClientOriginalName();

            if ($extension == 'jpg' || $extension == 'png'  || $extension == 'jpeg') {
                // kiem tra dã tồn tại hay chưa
                $checkExist = $this->categoryRepository->findWhere($request->input('idCategory_n'));
                if ($checkExist == true) {
                    $storedPath = $files->move('images_upload/category_images', $name);
                    $arrCreate = [
                        'category_id' => $request->input('idCategory_n'),
                        'category_name' => $request->input('nameCategory_n'),
                        'category_description' => $request->input('dsCategory_n'),
                        'category_avatar' => (string)$storedPath,
                    ];
                    $categories = $this->categoryRepository->create($arrCreate);
                } else {
                    return "tồn tại";
                }
            } else {
            }
        }
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
        $categories = $this->categoryRepository->deleteWhere($id);
        return redirect()->back();
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
        $categories = $this->categoryRepository->deleteWithAllProducts($id);
        if ($categories == true) {
            return response()->json([
                'status' => 'success',
            ]);
        }
        return response()->json([
            'status' => 'fail',
            'message' => "Xóa không thành công"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function updateUploadFile(Request $request, $id)
    {
        // return $id;
        $name = "";
        $storedPath = "";
        $arrUploadfile = array();

        if ($request->hasFile('fileData')) {
            $file = $request->file('fileData');
            $name = $file->getClientOriginalName();
            $storedPath = $file->move('images_upload/category_images/', $name);
            $arrUploadfile['category_avatar'] = (string)$storedPath;
            // return $storedPath;
        }
        $arrUploadfile['category_name'] = (string) $request->input('nameCategory');
        $arrUploadfile['category_description'] = (string) $request->input('dsCategory');
        $categories = $this->categoryRepository->updateWhere($id, $arrUploadfile);
        // return   $categories;
        if ($categories == 1) {
            return redirect()->back();
        }
    }
}
