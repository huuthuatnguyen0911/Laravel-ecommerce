@extends('frontend/masterLayout')

@section('main_title')
{{$dataPost->p_title}}
@endsection

@section('main_style_page')
<style>
    .box_row_grid {
        display: flex;
        flex-wrap: wrap;
        margin-left: -15px;
        margin-right: -15px;
    }

    .item-grid {
        padding-left: 15px;
        padding-right: 15px;
    }

    .item-grid-8 {
        width: 70%;
    }

    .item-grid-5 {
        width: 30%;
    }

    .box_main_content_post .box_header_post {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding-bottom: 5px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.5);
    }

    .box_main_content_post .box_header_post .box_img {
        width: 60px;
        height: 60px;
        margin-right: 10px;
        overflow: hidden;
        border-radius: 50%;
    }

    .box_main_content_post .box_header_post .box_img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .box_main_content_post .box_header_post .box_user_post .time_post {
        font-size: 14px;
    }

    .box_new_post .box_header {
        /* margin: 0; */
        padding-bottom: 5px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.5);
        text-align: center;
    }

    .box_main_item_new_post{
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .box_main_item_new_post .box_img_post{
        width: 25%;
        margin-right: 10px;
    }

    .box_main_item_new_post .box_img_post img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .box_main_item_new_post .box_content_new_post .name_new_post{
        margin: 0;
    }

    .list_new_post .item_new_post{
        margin: 10px 0;
    }
</style>
@endsection

@section('main_content')

<!-- post detail start -->
<section class="post-detail-conent-main">
    <div class="container">
        <div class="post_detail-header mt-3 mb-5">
            <h1 class="text-uppercase text-center" style="margin: 0; color: #f34f3f; "> {{$dataPost->p_title}} </h1>
        </div>

        <div class="box_detail_body">
            <div class="box_row_grid">
                <div class="item-grid item-grid-8">
                    <div class="box_main_content_post">

                        <!-- thogno tin người viết -->
                        <div class="box_header_post">
                            <div class="box_img">
                                <img src="{{asset($dataPost->getUser->avatar)}}" alt="">
                            </div>
                            <div class="box_user_post">
                                <a href="{{route('personal.page.index',$dataPost->getUser->id)}}"><strong>{{$dataPost->getUser->name}}</strong></a>
                                <p class="time_post">{{date_format($dataPost->created_at, "d/m/Y  H:i:s")}}</p>
                            </div>
                        </div>

                        <div class="box_body_post mt-5 mb-5">
                            {!! $dataPost->p_content !!}
                        </div>

                    </div>
                </div>
                <div class="item-grid item-grid-5">
                    <!-- bài viết mới nhất -->
                    <div class="box_new_post">
                        <div class="box_header">
                            <h4>Bài viết mới nhất</h4>
                        </div>
                        <ul class="list_new_post">
                            @foreach($dataAllPosts as $dataAllPost)
                            <li class="item_new_post ">
                                <a href="{{ route('post.detail', $dataAllPost->id)}}" class="" style="display: block;">
                                    <div class="box_main_item_new_post">
                                        <div class="box_img_post">
                                            <img src="{{asset($dataAllPost->p_link_image)}}" alt="">
                                        </div>
                                        <div class="box_content_new_post">
                                            <p class="name_new_post"><strong>{{Str::limit($dataAllPost->p_title,20, '...')}}</strong></p>
                                            <p class="time_new_post">{{date_format($dataAllPost->created_at , "d/m/Y  H:i:s")}}</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>

<!-- post detail end -->
@endsection

@section('javascript_page')
<script>
    $(document).ready(function() {
        // thông báo
        function showNotification(attr, mess) {
            $(".alert-" + attr + " .text_msg").text(mess);
            $(".alert-" + attr + "").css({
                right: "30px",
                "z-index": "99999"
            });
            $(".alert-" + attr + " .btn-close").click(function() {
                $(".alert-" + attr + "").css({
                    right: "-999px"
                });
            });

            setTimeout(function() {
                $(".alert-" + attr + "").css({
                    right: "-999px"
                });
            }, 3000);
        }

    })
</script>
@endsection