@extends('personal/masterLayout')

@section('main_title')
{{ Auth::user()->name }}
@endsection

@section('active_page_main_home')
active
@endsection

@section('main_style_page')
<style>
    :root {
        --main_color_post: rgba(36, 37, 38, 0.5);
        --main_text: #222222;
        --main_highlight: #f34f3f;
    }

    /* Phần cộng đồng */
    #section-my-post-home {}

    /* phần bài viết */
    .show_post_content_main {
        padding: 10px 20px;
        border-radius: 10px;
        background-color: var(--main_color_post);
        margin: 25px auto;
        box-shadow: 0 0 8px aliceblue;
        width: 70%;
    }

    .show_post_content_main .header_box {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }

    .show_post_content_main .header_box .box_header_infor {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .show_post_content_main .header_box .box_header_infor .box_img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
        overflow: hidden;
        border-radius: 50%;
    }

    .show_post_content_main .header_box .box_header_infor .box_img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .show_post_content_main .header_box .box_header_infor .box_name_time {}

    .show_post_content_main .header_box .box_header_infor .box_name_time h4 {
        margin: 0;
    }

    .show_post_content_main .header_box .box_header_infor .box_name_time p {
        font-size: 14px;
        margin: 0;
    }

    .show_post_content_main .body_box .box_main_img {
        width: 100%;
        height: 450px;
        border-radius: 20px;
        overflow: hidden;
        margin: 6px 0;
    }

    .show_post_content_main .body_box .box_main_img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .show_post_content_main .body_box .box_main_link_post {
        background-color: rgba(207, 90, 90, 0.1);
        padding: 10px 10px;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.2);
    }

    .show_post_content_main .body_box .box_main_link_post p {
        margin: 0;
        font-size: 14px;
    }

    .show_post_content_main .body_box .box_main_link_post .name_link_post {
        margin: 0;
        font-size: 18px;
    }

    .show_post_content_main .footer_box .box_count_view {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .show_post_content_main .footer_box .box_operation {
        padding: 8px 0;
        border-top: 1px solid rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(0, 0, 0, 0.2);
        margin: 10px 0;
    }

    .show_post_content_main .footer_box .box_operation .box_item {
        display: flex;
        align-items: center;
        flex-direction: row;
        justify-content: center;
        cursor: pointer;
        border-radius: 20px;
        transition: 0.5s;
    }

    .show_post_content_main .footer_box .box_operation .box_item:hover {
        background-color: rgba(243, 79, 63, 0.5);
        color: #fff
    }

    .show_post_content_main .footer_box .box_operation .box_item i {
        margin-right: 10px;
    }

    .show_post_content_main .footer_box .box_operation .box_item p {
        margin: 0;
    }

    .show_post_content_main .footer_box .box_input_comment {
        display: flex;
        align-items: center;
        flex-direction: row;
        border: 1px solid rgba(0, 0, 0, 0.2);
        padding: 0 10px;
        border-radius: 36px;
        overflow: hidden;
        justify-content: space-between;
    }

    .show_post_content_main .footer_box .box_input_comment .inputComment {
        background: 0;
        border: 0;
        outline: none;
        color: #fff;
        width: 100%;
    }


    .show_post_content_main .box_show_comment .single-comment-post .box_main_inf_user {
        display: flex;
        align-items: flex-start;
        flex-direction: row;
    }

    .show_post_content_main .box_show_comment .list-comment,
    .show_post_content_main .box_show_comment .list-comment .single-comment-post ul {
        list-style: none;
    }

    .show_post_content_main .box_show_comment .single-comment-post .box_main_inf_user .box_avatar {
        width: 60px;
        height: auto;
        margin-right: 10px;
        overflow: hidden;
        border-radius: 50%;
    }

    .show_post_content_main .box_show_comment .single-comment-post .box_main_inf_user .box_avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .show_post_content_main .box_show_comment .single-comment-post .box_main_inf_user .box_content {
        padding: 8px;
        border-radius: 20px;
        background-color: rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    .show_post_content_main .box_show_comment .single-comment-post .box_main_inf_user-children {
        margin-top: 8px;
        margin-left: 50px;
    }
</style>
@endsection

@section('main_content_page')
<section id="section-hero" class="vertical-center text-light" data-bgimage="url({{asset('assets/personal/images/background/4.jpg')}}) top" data-stellar-background-ratio=".5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-md-2 text-center">
                <h4 class="id-color">Welcome</h4>
                <div class="spacer-10"></div>

                <div class="h1_big text-white">
                    I Am
                    <div class="typed-strings">
                        <p>Designer</p>
                        <p>Programmer</p>
                        <p>Photographer</p>
                        <p>José Smith</p>
                    </div>
                    <div class="typed"></div>
                </div>
            </div>

            <div class="spacer-30"></div>

            <div class="col-md-6 offset-md-3 text-center">
                <p class="lead wow fadeInUp" data-wow-delay=".75s">Lorem ipsum dolor sit amet,
                    consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                    magna aliqua.</p>
                <div class="spacer-20"></div>
                <a class="btn-custom scroll-to wow fadeInUp" data-wow-delay="1s" href="#section-about">About Me</a>
            </div>
        </div>
    </div>
</section>

<section id="section-my-post-home">
    <div class="container">
        <ul style="list-style: none;">
            @foreach($dataPosts as $dataPost)
            <li>
                <div class="show_post_content_main">
                    <!-- header -->
                    <div class="header_box">
                        <div class="box_header_infor">
                            <div class="box_img">
                                <img src="{{asset($dataPost->getUser->avatar)}}" alt="">
                            </div>
                            <div class="box_name_time">
                                <a href="#">
                                    <h4 class="">{{$dataPost->getUser->name}}</h4>
                                </a>
                                <p class="">{{ date_format($dataPost->updated_at, ' d/m/Y  H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- content -->
                    <div class="body_box mt-2 mb-2">
                        <div class="box_main_img">
                            <img src="{{asset($dataPost->p_link_image)}}" alt="">
                        </div>

                        <a href="{{route('post.detail', $dataPost->id)}}" style="display: block">
                            <div class="box_main_link_post">
                                <p>{{ date_format($dataPost->created_at, ' d/m/Y  H:i:s') }}</p>
                                <h4 class="name_link_post">{{$dataPost->p_title}}</h4>
                            </div>
                        </a>

                    </div>
                    <!-- footer -->
                    <div class="footer_box">
                        <div class="box_count_view">
                            <p id="view_like-{{$dataPost->id}}" style="margin: 0;">{{$dataPost->getLike->count()}} thích</p>
                            <p id="view_comment-{{$dataPost->id}}" style="margin: 0;">{{$dataPost->getComment->count()}} bình luận</p>
                        </div>
                        <div class="box_operation">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box_item btn_like_post" id="box_like-{{$dataPost->id}}" data-id="{{$dataPost->id}}">
                                        @php
                                        $ckechLike = false;
                                        foreach($dataPost->getLike as $like){
                                        if($like->like_id_user == Auth::user()->id){
                                        $ckechLike = true;
                                        }
                                        }
                                        @endphp
                                        @if($ckechLike == true)
                                        <i class="fas fa-thumbs-up"></i>
                                        @else
                                        <i class="far fa-thumbs-up"></i>
                                        @endif
                                        <p>Thích</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box_item btn_view_comment" data-id="{{$dataPost->id}}">
                                        <i class="far fa-comments"></i>
                                        <p>Bình luận</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box_item">
                                        <i class="fas fa-share-alt"></i>
                                        <p>Chia sẽ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data" class="formCommentPost" data-id="{{$dataPost->id}}">
                            @csrf
                            <div class="box_input_comment">
                                <input type="text" class="inputComment" name="inputComment" id="idValuePost-{{$dataPost->id}}" placeholder="Nhập bình luận của bạn vào đây..">
                                <!-- <button type="submit" class="btn_submit_post_comment">
                                    <i class="fas fa-location-arrow"></i>
                                </button> -->
                            </div>
                        </form>
                    </div>
                    <div class="box_show_comment mt-3">
                        <ul class="list-comment" id="list-comment-{{$dataPost->id}}">

                        </ul>
                        <!-- <p><a href="#">Xem thêm</a></p> -->
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>

@endsection

@section('main_js_page')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                "X-CSRF_TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
    })
</script>
@endsection