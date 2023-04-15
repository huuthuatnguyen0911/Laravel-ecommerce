<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Models\CommentPost;
use App\Models\LikePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    // trang quản lí admin bài viết 
    public function indexPostManage(Request $request)
    {
        if ($request->ajax()) {
            $data = Post::select('p_id_user', 'id', 'p_category', 'p_title', 'p_status', 'created_at')->orderBy('created_at', 'desc')->get();

            return DataTables::of($data)
                // ->editColumn('p_status', function ($data) {
                //     if ($data->p_status == 0) {
                //         return '<a href="' . route('personal.change.post', $data->id) . '" class="btn btn-primary btn-sm btnChangePostPrivate">Cá nhận</a>';
                //     }

                //     if ($data->p_status == 1) {
                //         return '<a href="' . route('personal.change.post', $data->id) . '" class="btn btn-warning btn-sm btnChangePostPublic">Công khai</a>';
                //     }
                // })
                ->addColumn('name_user', function ($data) {
                    return '<p>' . $data->getUser->name . '</p>';
                })
                ->editColumn('created_at', function ($data) {
                    return ' <p class="">' . date_format($data->created_at, "d/m/Y  H:i") . '</p> ';
                })
                ->editColumn('p_category', function ($data) {
                    return ' <p class="">' . $data->p_category . '</p> ';
                })
                ->editColumn('p_title', function ($data) {
                    return ' <p class="">' . $data->p_title . '</p> ';
                })
                ->addColumn('p_action', function ($data) {
                    return '
                <a href="' . route('post.detail', $data->id) . '"  class="btn btn-success btn-sm btnViewPost"><i class="fa fa-eye"></i></a>
                <a href="' . route('personal.delete.post', $data->id) . '" class="btn btn-danger btn-sm btnDeletePost"><i class="fa fa-trash-o"></i></a>
                ';
                })
                // 'p_status', 
                ->rawColumns(['p_action', 'created_at', 'p_category', 'p_title', 'name_user'])
                ->make(true);
        }
        return view('admins.pages.posts.index');
    }

    // vào trang bài viết của tôi
    public function indexPostsMy(Request $request)
    {
        $id_user = Auth::user()->id;

        if ($request->ajax()) {
            $data = Post::where('p_id_user', '=', $id_user);

            return DataTables::of($data)
                ->editColumn('p_status', function ($data) {
                    if ($data->p_status == 0) {
                        return '<a href="' . route('personal.change.post', $data->id) . '" class="btn btn-primary btn-sm btnChangePostPrivate">Cá nhận</a>';
                    }

                    if ($data->p_status == 1) {
                        return '<a href="' . route('personal.change.post', $data->id) . '" class="btn btn-warning btn-sm btnChangePostPublic">Công khai</a>';
                    }
                })
                ->editColumn('created_at', function ($data) {
                    return ' <p class="change_light">' . date_format($data->created_at, "d/m/Y  H:i") . '</p> ';
                })
                ->editColumn('p_category', function ($data) {
                    return ' <p class="change_light">' . $data->p_category . '</p> ';
                })
                ->editColumn('p_title', function ($data) {
                    return ' <p class="change_light">' . $data->p_title . '</p> ';
                })
                ->addColumn('p_action', function ($data) {
                    return '
                <a href="' . route('post.detail', $data->id) . '"  class="btn btn-success btn-sm btnViewPost"><i class="fas fa-eye"></i></a>
                <a href="' . route('personal.post.edit.index', $data->id) . '" class="btn btn-info btn-sm btnEditPost"><i class="fas fa-pen"></i></a>
                <a href="' . route('personal.delete.post', $data->id) . '" class="btn btn-danger btn-sm btnDeletePost"><i class="fas fa-trash-alt"></i></a>
                ';
                })
                ->rawColumns(['p_status', 'p_action', 'created_at', 'p_category', 'p_title'])
                ->make(true);
        }

        return view('personal.pages.posts.index');
    }

    // tạo bài viết
    public function indexCreatePost(Request $request)
    {
        return view('personal.pages.posts.create_post');
    }

    // lưu bài viết
    public function inforCreatePost(Request $request)
    {
        $status_input = $request->input('status_input');
        $inpuTitle = $request->input('inpuTitle');
        $inpuCategory = $request->input('inpuCategory');
        $inputcontent = $request->input('inputcontent');
        $id_user = Auth::user()->id;

        if ($request->hasFile('inpuImage')) {

            $files = $request->file('inpuImage');
            $name = $files->getClientOriginalName();

            $storedPath = $files->move('images_upload/posts', $name);

            $tablePost = new Post();
            $tablePost->p_id_user = $id_user;
            $tablePost->p_category = $inpuCategory;
            $tablePost->p_title = $inpuTitle;
            $tablePost->p_link_image = $storedPath;
            $tablePost->p_content = $inputcontent;
            $tablePost->p_status = $status_input;
            $tablePost->save();

            return redirect()->route('personal.post.index');
        }

        return redirect()->route('personal.post.index');
    }

    // chuyển hướng Chinh sửa bài biết
    public function indexEditPost(Request $request, $id)
    {
        $dataPost = Post::find($id);
        // return $dataPost;
        return view('personal.pages.posts.edit_post', compact('dataPost'));
    }

    // lưu chỉnh sửa
    public function EditPost(Request $request, $id)
    {

        $status_input = $request->input('status_input');
        $inpuTitle = $request->input('inpuTitle');
        $inpuCategory = $request->input('inpuCategory');
        $inputcontent = $request->input('inputcontent');

        if ($request->hasFile('inpuImage')) {

            $files = $request->file('inpuImage');
            $name = $files->getClientOriginalName();

            $storedPath = $files->move('images_upload/posts', $name);

            $tablePost = Post::find($id);
            $tablePost->p_category = $inpuCategory;
            $tablePost->p_title = $inpuTitle;
            $tablePost->p_link_image = $storedPath;
            $tablePost->p_content = $inputcontent;
            $tablePost->p_status = $status_input;
            $tablePost->save();

            return redirect()->route('personal.post.index');
        }

        return redirect()->route('personal.post.index');
    }

    // xóa bài viết
    public function deletePost($id)
    {
        Post::find($id)->delete();
        CommentPost::where('comments_p_Post_id', '=', $id)->delete();
        return redirect()->back();
    }

    // Chuyển đổi hiển thị bài viết
    public function changePost(Request $request, $id)
    {
        $changeStatus = $request->input('changeStatus');

        $tablePost = Post::find($id);
        $tablePost->p_status = $changeStatus;
        $tablePost->save();
        return true;
    }

    // xem bài viết chi tiết công khai
    public function seenDetailPost(request $request, $id)
    {
        $dataPost = Post::where('id', '=', $id)->with('getUser')->first();
        $dataAllPosts = Post::select('id', 'p_title', 'p_link_image', 'created_at')
            ->where('p_status', '=', '0')
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        // return $dataAllPosts;
        return view('frontend.pages.post.detail_post', compact('dataPost', 'dataAllPosts'));
    }

    // Comment bài viết
    public function addCommentPost(Request $request)
    {
        $idPost = $request->input('id_port');
        $idUser = $request->input('id_user');
        $valueComment = $request->input('valueComment');

        $dataTable = new CommentPost();
        $dataTable->comments_p_user_id = $idUser;
        $dataTable->comments_p_Post_id = $idPost;
        $dataTable->comments_p_text = $valueComment;
        $dataTable->comments_p_parent = 0;
        $dataTable->comments_p_status = 0;
        $dataTable->save();

        $countComment = CommentPost::where('comments_p_Post_id', '=', $idPost)->count();

        $outputTextBinhLuan = $countComment . ' bình luận';


        return $outputTextBinhLuan;
    }

    // tất cả comment bài viết
    public function showAllCommentPost(Request $request)
    {
        $id_post = $request->input('id_post');
        $comments = CommentPost::where('comments_p_Post_id', '=', $id_post)
            ->orderBy('created_at', 'desc')
            ->get();

        $output = '';


        if ($comments->count() != 0) {

            foreach ($comments as $comment) {
                $output .= '
                <li class="item-list-comment mt-4">
                    <div class="single-comment-post" style="border: none;">
                        <div class="box_main_inf_user">
                            <div class="box_avatar">
                                <img src="' . asset($comment->getUser->avatar) . '" alt="">
                            </div>
                            <div class="box_content">
                                <div class="box_infor_user">
                                    <a href="#"><h6 class="name" style="margin: 0;">' . $comment->getUser->name . '</h6></a>
                                    <span>' . date_format($comment->created_at, 'd-m-Y H:i:s') . '</span>
                                </div>
                                <p style="line-height: 1.4; ">' . $comment->comments_p_text . '</p>
                            </div>
                        </div>
                    </div>
                </li>
                
                ';
            }
        } else {
            $output .=  '
            <li class="item-list-comment mt-4 text-center ">
                <p >Không có bình luận nào</p>
            </li>
            ';
        }

        return $output;
    }

    // like bài viết
    public function likePost(Request $request)
    {
        $id_post = $request->input('id_post');
        $id_user = $request->input('id_user');
        $codeCheck = $request->input('codeCheck');

        $outputItem = '';

        if ($codeCheck == 'addlike') {
            $tableLikePost = new LikePost();
            $tableLikePost->like_id_user = $id_user;
            $tableLikePost->like_id_post = $id_post;
            $tableLikePost->save();
            $outputItem .= '
            <i class="fas fa-thumbs-up"></i>
            <p>Thích</p>
            ';
        }

        if ($codeCheck == 'removelike') {
            LikePost::where('like_id_post', '=', $id_post)
                ->where('like_id_user', '=', $id_user)
                ->delete();
            $outputItem .= '
            <i class="far fa-thumbs-up"></i>
            <p>Thích</p>
            ';
        }

        $countLikePost = LikePost::where('like_id_post', '=', $id_post)->count();
        $html = $countLikePost . " thích";



        return response()->json([
            $html,
            $outputItem
        ]);
    }
}
