@extends('frontend/masterLayout')

@section('main_title')
Bài viết
@endsection

@section('main_active_site_community')
active-site
@endsection

@section('main_style_page')
<style>

</style>
@endsection

@section('main_content')
<div class="container mt-4 mb-5" id="boxMainCotentPosts">
    <div class="row">
        <div class="col-md-8">
            <div class="box_main_left">
                <!-- box post bài viết -->
                @if(Auth::check())
                <div class="box_form_post_news">
                    <div class="box_avatar">
                        <img src="{{Auth::user()->avatar ?  Auth::user()->avatar : asset('images/user_img.png')}}" alt="">
                    </div>
                    <div class="box_btn_create_post">
                        <a href="{{route('personal.post.create.index')}}" class="btnCreatePostNews">
                            <p>Bạn có muốn tạo một bài viết chứ ?</p>
                            <i class="fas fa-location-arrow"></i>
                        </a>
                    </div>
                </div>
                @endif

                @foreach ($dataPosts as $dataPost)
                <div class="Show_post_content_main">
                    <!-- header -->
                    <div class="header_box">
                        <div class="box_header_infor">
                            <div class="box_img">
                                <img src="{{asset($dataPost->getUser->avatar)}}" alt="">
                            </div>
                            <div class="box_name_time">
                                <a href="{{route('personal.page.index',$dataPost->getUser->id)}}">
                                    <h4>{{$dataPost->getUser->name}}</h4>
                                </a>
                                <p>{{ date_format($dataPost->updated_at, ' d/m/Y  H:i:s') }}</p>
                            </div>
                        </div>
                        <div class="box_header_sub" id="button_friend-{{$dataPost->getUser->id}}">
                            @if(Auth::check())
                            @if(Auth::user()->id != $dataPost->getUser->id)
                            @php
                            $checkFriends = false;
                            foreach(Auth::user()->getFridends as $friend){
                            if($friend->fs_id_friend == $dataPost->getUser->id) {
                            $checkFriends = true;
                            }
                            }
                            @endphp
                            @if($checkFriends == true)
                            <button class="btn_remove_friend" data-id="{{$dataPost->getUser->id}}">
                                <span>Bạn bè</span>
                                <i class="fas fa-user-friends" style="font-size:14px"></i>
                                <!-- <i class="fas fa-plus" style="font-size:14px"></i> -->
                            </button>
                            @else
                            <button class="btn_add_friend" data-id="{{$dataPost->getUser->id}}">
                                <span>Kết bạn</span>
                                <i class="fas fa-plus" style="font-size:14px"></i>
                            </button>
                            @endif
                            @endif
                            @else
                            <button class="btn_add_friend_not_login checkLoginAuth">
                                <span>Kết bạn</span>
                                <i class="fas fa-plus" style="font-size:14px"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    <!-- content -->
                    <div class="body_box mt-2 mb-2">
                        <!-- <div class="box_text_main_conent">
                            <p>Chào mừng các bạn đến với thế giới pet nơi chia sẽ gì gì đó</p>
                        </div> -->
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
                                    <div class="box_item check btn_like_post checkLoginAuth" id="box_like-{{$dataPost->id}}" data-id="{{$dataPost->id}}">
                                        @if(Auth::check())
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
                                        @else
                                        <i class="far fa-thumbs-up"></i>
                                        <p>Thích</p>
                                        @endif

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
                        <form action="" method="post" enctype="multipart/form-data" class="formCommentPost " data-id="{{$dataPost->id}}">
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
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
            <div class="box_main_right">
                <div class="sidebar-categories">
                    <h3 class="widget-title font-weight-bold text-center">Tác Giả mới nhất</h3>
                    <ul class="categories-list">
                        @foreach($newDataPostCounts as $newDataPostCount)
                        @if($loop->index <= 7) <li><a href="{{route('personal.page.index', $newDataPostCount->id)}}">{{$newDataPostCount->name}} <span>({{$newDataPostCount->id}})</span> </a></li>
                            @endif
                            @endforeach
                    </ul>
                </div>

                <!--Sidebar Tags Start-->
                <div class="sidebar-tags">
                    <h3 class="widget-title text-center">Thể loại</h3>

                    <ul class="tags-list">
                        @foreach($listCategoryPosts as $item)
                        <li>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('tagPost-{{$loop->index}}').submit(); " >{{$item->p_category}}</a>
                            <form action="{{route('community.search.tag.post')}}" id="tagPost-{{$loop->index}}" method="get">
                                <input type="hidden" name="tagName" value="{{$item->p_category}}">
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <!--Sidebar Tags End-->

            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript_page')
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> -->

<script>
    $(document).ready(function() {

        // Thêm bạn bè
        $('body').on('click', '.btn_add_friend', function(e) {
            let id_friend = $(this).data('id');
            $.ajax({
                url: '{{route("friend.add")}}',
                type: 'GET',
                data: {
                    id_friend,
                    codeCheck: "addFriend",
                },
                success: (data) => {
                    if (data.status == 'successAdd') {
                        showNotification('success', data.mess)
                        $('#button_friend-' + id_friend).html(data.buttonRemove)
                    }
                }
            })

        })

        // Xóa bạn bè
        $('body').on('click', '.btn_remove_friend', function(e) {
            let id_friend = $(this).data('id');
            $.ajax({
                url: '{{route("friend.add")}}',
                type: 'GET',
                data: {
                    id_friend,
                    codeCheck: "removeFriend",
                },
                success: (data) => {
                    if (data.status == 'successRemove') {
                        showNotification('success', data.mess)
                        $('#button_friend-' + id_friend).html(data.buttonAdd)
                    }
                }
            })

        })

        // cập nhật giỏ hàng nhỏ
        function cartSubCurrent() {
            if ('{{Auth::check()}}') {
                $.ajax({
                    url: '{{ route("cart.sub") }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id_user: ' {{ Auth::check() ? Auth::user()->id : "" }} ',
                    },
                    success: (data) => {
                        $('#showCartList').html(data.dataHtml);
                        $('#ShowTotalPrice').text(data.total);
                        $('#showQuantityCart').text(data.count);
                        // console.log(data);
                    }
                })
            }
        }
        cartSubCurrent()

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