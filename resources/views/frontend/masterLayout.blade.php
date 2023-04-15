<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend/includes/head')
    <title>@yield('main_title')</title>
    @include('frontend/includes/link_style')
    @yield('main_style_page')
    <style>
        .body_master .alert {
            position: fixed;
            z-index: 222;
            top: 100px;
            right: -999px;
            transition: 0.5s;
        }

        .active-site {
            color: #f34f3f !important;
        }

        .page-pagination .pagination .page-item.active .page-link {
            background-color: #f34f3f !important;
            color: #fff
        }

        .overfow_text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>

<body class="body_master">

    @include('frontend/includes/notification/alerts')
    <div class="main-wrapper">
        @include('frontend/includes/header')

        @yield('main_content')

        @include('frontend/includes/footer')
        @include('frontend/includes/copyRight')
        <!--Back To Start-->
        <!-- <a href="#" class="back-to-top">
            <i class="fa fa-angle-double-up"></i>
        </a> -->
        <!--Back To End-->
        @include('frontend/includes/quick_view')
    </div>

    <!-- JS -->
    @include('frontend/includes/link_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.js"></script> -->
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "103389455510771");
        chatbox.setAttribute("attribution", "biz_inbox");

        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v12.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF_TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            $("body").on('click', '.icon_show_inf_pet', function(e) {
                e.preventDefault();

                // let idPet = $(this).data('id');
                let dataUrl = $(this).attr('href');
                $('#modalShowPet').modal('toggle')
                $.ajax({
                    url: dataUrl,
                    type: 'GET',
                    success: function(data) {
                        $("#modalShowPet .quick-view-image img").attr('src', "{{URL('')}}" + "/" + data.get_main_image.link_image);
                        $('#modalShowPet .product-title').text(data.product_name);
                        $('#modalShowPet .current-price').text(number_format(Number(data.get_archive.price)));
                        $('#modalShowPet .description_product').text(data.product_description);
                    }
                })

            })

            // Xoas cart trên khung nhỏ
            $('body').on('click', '.itemDeleteCart', function(e) {
                e.preventDefault();

                let url = $(this).attr('href');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: (data) => {
                        if (data == 1) {
                            cartSubCurrent()
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


            function number_format(number, decimals, dec_point, thousands_sep) {
                // Strip all characters but numerical ones.
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }

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

            $("body").on('click', '.checkLoginAuth', function(e) {
                if ('{{Auth::check()}}') {

                } else {
                    e.preventDefault();
                    showNotification('warning', 'Bạn phải đăng nhập mới sử dụng tính năng này!!!');
                    //  setTimeout(() => {
                    //      window.location.href = "{{route('login')}}";
                    //  }, 3000);
                }
            })

            $('#btnBackLink').click(function() {
                window.history.back();
            });
            if ('{{Auth::check()}}') {
                function JoiningOnlineUser() {

                    Echo.join('joining')
                        .joining((user) => {
                            $.ajax({
                                url: '{{route("status.user.online")}}',
                                type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    dateUser: user,
                                },
                            });
                        })
                        .leaving((user) => {
                            $.ajax({
                                url: '{{route("status.user.offline")}}',
                                type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    dateUser: user,
                                },
                            });
                        })
                    // .listen('UserOnline', (e) => {
                    // })
                    // .listen('UserOffline', (e) => {
                    // });
                }
                JoiningOnlineUser()
            }

        })
    </script>
    <script>
        $(document).ready(function() {

            // xem comment
            $('body').on('click', '.btn_view_comment', function(e) {
                let id_post = $(this).data('id');
                showCommentPost(id_post);
            })

            // like bài viết
            $('body').on('click', '.btn_like_post', function(e) {
                let id_post = $(this).data('id');
                let id_user = '{{Auth::check() ? Auth::user()->id : "" }}';
                let checkLike = $(this).children().hasClass('fas');

                if (checkLike == true) {
                    likePost(id_post, id_user, 'removelike');
                } else {
                    likePost(id_post, id_user, 'addlike');
                }

                // console.log(checkLike);

            })

            // Gửi comment
            $('body').on('submit', '.formCommentPost', function(e) {
                if ('{{Auth::check()}}') {
                    e.preventDefault();
                    let id_port = $(this).data('id');
                    let id_user = '{{Auth::check() ? Auth::user()->id : "" }}';
                    let valueComment = $('#idValuePost-' + id_port).val();

                    $.ajax({
                        url: '{{route("post.comment")}}',
                        type: 'POST',
                        data: {
                            id_user: id_user,
                            id_port: id_port,
                            valueComment: valueComment,
                            "_token": $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function(data) {
                            $('#view_comment-' + id_port).html(data);
                            showCommentPost(id_port);
                        }
                    })
                } else {
                    e.preventDefault();
                    showNotification('warning', 'Bạn phải đăng nhập mới sử dụng tính năng này!!!');
                }
            })

            // show comment post
            function showCommentPost(id_post) {

                $.ajax({
                    url: '{{route("post.comment.show.all")}}',
                    type: 'get',
                    data: {
                        id_post: id_post,
                        "_token": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: (data) => {
                        $('#list-comment-' + id_post).html(data);
                    }
                })
            }

            // show like post
            function likePost(id_post, id_user, codeCheck) {
                $.ajax({
                    url: '{{route("post.like")}}',
                    type: 'get',
                    data: {
                        id_post: id_post,
                        id_user: id_user,
                        codeCheck,
                        "_token": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: (data) => {
                        // console.log(JSON.parse(data));
                        $('#view_like-' + id_post).html(data[0]);
                        $('#box_like-' + id_post).html(data[1]);
                        // console.log($('#box_like-' + id_post))
                        // console.log(data[1])
                    }
                })
            }

            // Xoas cart trên khung nhỏ
            $('body').on('click', '.itemDeleteCart', function(e) {
                e.preventDefault();

                let url = $(this).attr('href');

                $.ajax({
                    url: url,
                    type: 'GET',

                    success: (data) => {
                        if (data == 1) {
                            cartSubCurrent()
                        }
                    }
                })
            })

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
    @yield('javascript_page')
</body>

</html>