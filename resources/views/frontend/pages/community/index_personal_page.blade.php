@extends('frontend/masterLayout')

@section('main_title')
{{$user->name}}
@endsection

<!-- @section('main_active_site_community')
active-site
@endsection -->

@section('main_style_page')
<style>
    .box_content_left i {
        font-size: 16px;
    }
</style>
<style>

</style>
@endsection

@section('main_content')
<div class="container mt-4 mb-5" id="boxMainMyPage">

    <div class="row pb-4 border-bottom" style="align-items: flex-end; justify-content: space-between;">
        <div class="col-md-6" style="text-align: left">
            <div class="box_inf_name" style="display: inline-block; text-align: center;">
                <img src="{{asset($user->avatar)}}" alt="" class="rounded-circle" style="width: 150px; height:150px">
                <h5 class="mb-0">{{$user->name}}</h5>
            </div>
        </div>
        <div class="col-md-6" style="text-align: right">
            <div class="box_add_friend" style="display: inline-block; text-align: center;">
                <div class="box_header_sub" id="button_friend-{{$user->id}}">
                    @if(Auth::user()->id != $user->id)
                    @php
                    $checkFriends = false;
                    foreach(Auth::user()->getFridends as $friend){
                    if($friend->fs_id_friend == $user->id) {
                    $checkFriends = true;
                    }
                    }
                    @endphp
                    @if($checkFriends == true)
                    <button class="btn_remove_friend" data-id="{{$user->id}}">
                        <span>Bạn bè</span>
                        <i class="fas fa-user-friends" style="font-size:14px"></i>
                        <!-- <i class="fas fa-plus" style="font-size:14px"></i> -->
                    </button>
                    @else
                    <button class="btn_add_friend" data-id="{{$user->id}}">
                        <span>Kết bạn</span>
                        <i class="fas fa-plus" style="font-size:14px"></i>
                    </button>
                    @endif
                    @else
                    <!-- <a class="btn_add_friend" href="{{route('personal.setting.index')}}">
                        <span>Thiết lập</span>
                    </a> -->
                    @endif
                </div>
                <!-- <div class=" align-self-center">
                    <p class="profile-count mb-0 mr-1">{{$user->getFridends->count()}} Bạn bè</p>
                </div> -->
            </div>
        </div>
        <!-- <button class="btn btn-orange mb-3">Kết bạn</button> -->

    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="box_content_left">
                <h3 class="font-weight-bold mb-2">Giới thiệu</h3>
                @if($user->getInfor->content != null)
                <p class="">
                    <i class="fas fa-info mr-2"></i>
                    {{$user->getInfor->content}}
                </p>
                @endif
                @if($user->getInfor->phone != null)
                <p class="">
                    <i class="fas fa-phone mr-2"></i>
                    {{$user->getInfor->phone}}
                </p>
                @endif
                <p class="">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    @isset($user->getInfor->street)
                    {{$user->getInfor->street}} -
                    @endisset
                    @isset($user->getInfor->getWard->_name)
                    {{$user->getInfor->getWard->_name}} -
                    @endisset
                    @isset($user->getInfor->getDistrict->_name)
                    {{$user->getInfor->getDistrict->_name}} -
                    @endisset
                    @isset($user->getInfor->getProvince->_name)
                    {{$user->getInfor->getProvince->_name}}
                    @endisset
                </p>
                <p class="">
                    <i class="fas fa-pen mr-2"></i>
                    {{$user->getPosts->count()}} bài viết
                </p>

            </div>
        </div>
        <div class="col-md-8">
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