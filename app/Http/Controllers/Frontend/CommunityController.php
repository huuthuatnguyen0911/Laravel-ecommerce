<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    // index
    public function index()
    {
        $dataPosts = Post::select('p_title', 'id', 'created_at', 'p_link_image', 'updated_at', 'p_id_user')
            ->where('p_status', '=', 0)
            ->with('getUser', 'getLike')
            ->orderBy('created_at', 'desc')
            ->get();

        $dataUserPostCount = User::select('id', 'name')->withCount('getPosts')->get();

        $newDataPostCounts = $dataUserPostCount->filter(function ($value, $key) {
            return $value->get_posts_count >= 1;
        });

        $listCategoryPosts = Post::select('p_category')->groupBy('p_category')->get();

        return view('frontend.pages.community.index', compact('dataPosts', 'newDataPostCounts', 'listCategoryPosts'));
    }

    // Hiển thị với thả trong bài viết
    public function searchTagPost(Request $request)
    {
        // return $request->all();
        $tagName = $request->input('tagName');

        $dataPosts = Post::select('p_title', 'id', 'created_at', 'p_link_image', 'updated_at', 'p_id_user', 'p_category')
            ->where('p_status', '=', 0)
            ->where('p_category', $tagName)
            ->with('getUser', 'getLike')
            ->orderBy('created_at', 'desc')
            ->get();

        // return $dataPosts;

        $dataUserPostCount = User::select('id', 'name')->withCount('getPosts')->get();

        $newDataPostCounts = $dataUserPostCount->filter(function ($value, $key) {
            return $value->get_posts_count >= 1;
        });

        $listCategoryPosts = Post::select('p_category')->groupBy('p_category')->get();

        return view('frontend.pages.community.index_post_tag', compact('dataPosts', 'newDataPostCounts', 'listCategoryPosts'));
    }
}
