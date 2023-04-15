<!DOCTYPE html>
<html lang="en">

<head>
    @include('personal/includes/head')
    <title>@yield('main_title')</title>
    <style>
        html,
        body {
            height: 100%;
            /* background-color: #252525; */
        }

        #ModelVideoCall video {
            background: #dee;
        }

        #ModelVideoCall #localVideo {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 120px;
            width: 120px;
            z-index: 10;
            background: #333;
            min-height: 120px;
            height: 120px;
        }

        #ModelVideoCall #remoteVideo {
            width: 100%;
        }

        #ModelVideoCall .overLayConnent {
            background-color: rgba(0, 0, 0, 0.2);
            display: none;
            width: 100%;
            height: 300px;
        }

        #ModelVideoCall .overLayConnent .box_grid_call {
            height: 100%;
            align-items: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #ModelVideoCall .overLayConnent .box_grid_call .avatar_callee {
            width: 100px;
            height: auto;
            object-fit: cover;
            border-radius: 50%;
        }

        #ModelVideoCall .overLayConnent .box_grid_call .text_name_call {
            margin: 0;
        }
    </style>
    @include('personal/includes/style')
    @yield('main_style_page')
</head>

<body class="side-layout" id="main_body_side_layout" style="margin: 0; ">
    <!-- wrapper -->
    <div id="" style="height: 100%;" class=" sc-bg-body" data-bgcolor="#252525">
        <div class="page-overlay">
            <div class="preloader-wrap">
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
        </div>

        <!-- header desktop -->
        @include('personal/includes/header')
        <!-- data-bgcolor="#252525" -->
        <!-- main content -->
        <div id="main-content" class="no-bottom no-top text-light sc-bg-body" data-bgcolor="#252525">
            <!-- <div class="no-bottom no-top text-light sc-bg-body" id="content" > -->
            <!-- <div id="top"></div> -->

            @yield('main_content_page')

            <!-- </div> -->
        </div>

        <a href="#" id="back-to-top"></a>

        <div id="preloader">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>

        <!-- model video call -->
        <!-- Modal -->
        <div class="modal fade" id="ModelVideoCall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 700px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Video call petpet</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="position: relative;">
                        <div class="overLayConnent">
                            <div class="box_grid_call">
                                <div class="item_grid_call mr-3">
                                    <div class="box_animation_scale">
                                        <img class="avatar_callee" id="imagAvatarCallee" src="http://windows79.com/wp-content/uploads/2021/02/Thay-the-hinh-dai-dien-tai-khoan-nguoi-dung-mac.png" alt="">
                                    </div>
                                </div>
                                <div class="item_grid_call">
                                    <h3 class="text_name_call"><span id="nameCalleeId">thành thiện</span> đang gọi cho bạn</h3>
                                </div>
                            </div>
                        </div>
                        <video id="localVideo" autoplay muted></video>
                        <video id="remoteVideo" autoplay></video>
                    </div>
                    <div class="modal-footer">
                        <button id="callButton" class="btn btn-success">Gọi</button>
                        <button id="answerCallButton" class="btn btn-info hidden-first">Nghe máy</button>
                        <button id="rejectCallButton" class="btn btn-warning hidden-first">Từ chối</button>
                        <button id="endCallButton" class="btn btn-danger hidden-first" data-dismiss="modal">Kết thúc</button>
                        <button id="closeButton" hidden class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('personal/includes/Javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            Pusher.logToConsole = true;

            function pusherMessage() {

                Echo.private('chat.{{ Auth::check() ? Auth::user()->id : "" }}')
                    .listen('SendMessages', (data) => {
                        let boxChatCurrent = $('#showAllMessage').data('current');
                        if (boxChatCurrent == data.messages.idUserFrom) {
                            $('#showAllMessage').append(`
                            <div class="chat-message-left pb-4" style="align-items: center;">
                                <div>
                                    <img src="${data.messages.avatar}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">${data.messages.timeSend}</div>
                                </div>
                                <div class="flex-shrink-1 py-2 px-3 ml-3  box_text_message box_text_message_friend change_light">
                                ${data.messages.text}
                                </div>
                            </div>   
                            `);
                        } else {
                            $('#viewCountSeen-' + data.messages.idUserFrom).text(data.messages.countSeen);
                        }
                        scrollMainMessage()
                    })
            }
            pusherMessage();

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
                        $('#status_user-' + user.id).html(`
                        <span class="fas fa-circle chat-online"></span> Online
                        `)
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
                        $('#status_user-' + user.id).html(`
                        <span class="fas fa-circle chat-offline"></span> Offine
                        `)
                    })
                // .listen('UserOnline', (e) => {
                // })
                // .listen('UserOffline', (e) => {
                // });
            }
            JoiningOnlineUser()

            function scrollMainMessage() {
                var element = document.getElementById("showAllMessage");
                element.scrollTop = element.scrollHeight;
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
        })
    </script>

    <script>
        $(document).ready(function() {

            function settingCallEvent(call1, localVideo, remoteVideo, callButton, answerCallButton, endCallButton, rejectCallButton, closeButton) {
                call1.on('addremotestream', function(stream) {
                    // reset srcObject to work around minor bugs in Chrome and Edge.
                    // console.log('addremotestream');
                    remoteVideo.srcObject = null;
                    remoteVideo.srcObject = stream;
                });

                call1.on('addlocalstream', function(stream) {
                    // reset srcObject to work around minor bugs in Chrome and Edge.
                    // console.log('addlocalstream');
                    localVideo.srcObject = null;
                    localVideo.srcObject = stream;
                });

                call1.on('signalingstate', function(state) {
                    // console.log('signalingstate ', state);

                    if (state.code === 6 || state.code === 5) //end call or callee rejected
                    {
                        $('#ModelVideoCall').modal('hide');
                        closeButton.show();
                        callButton.hide();
                        endCallButton.hide();
                        rejectCallButton.hide();
                        answerCallButton.hide();

                        localVideo.srcObject = null;
                        remoteVideo.srcObject = null;
                        // $('#incoming-call-notice').hide();
                    }
                });

                call1.on('mediastate', function(state) {
                    console.log('mediastate ', state);
                });

                call1.on('info', function(info) {
                    console.log('on info:' + JSON.stringify(info));
                });

                call1.upgradeToVideoCall();

            }

            let prefixName = 'user'
            var callerId = `${prefixName}{{Auth::user()->id}}`;
            var calleeId = '';
            var token = '';
            let client;
            var currentCall = null;

            // lấy tooken
            function getVideoCall(callerID) {
                axios.get('https://shopthucungpetpet.com/video-call/get_token?callerid=' + callerID)
                    .then((response) => {
                        return response.data;
                    })
                    .then((token) => {
                        client = new StringeeClient();
                        client.connect(token);

                        client.on('connect', function() {
                            console.log('+++ connected!');
                        });

                        client.on('authen', function(res) {
                            console.log('+++ on authen: ', res);
                        });

                        client.on('disconnect', function(res) {
                            console.log('+++ disconnected');
                        });

                        return client;
                    })
                    .then((client) => {
                        let localVideo = document.getElementById('localVideo');
                        let remoteVideo = document.getElementById('remoteVideo');

                        let callButton = $('#callButton');
                        let answerCallButton = $('#answerCallButton');
                        let rejectCallButton = $('#rejectCallButton');
                        let endCallButton = $('#endCallButton');
                        let closeButton = $('#closeButton');

                        $('body').on('click', '#call_video_id', function(e) {

                            calleeId = prefixName + $(this).data('friend_id');

                            $('#ModelVideoCall').modal({
                                backdrop: 'static',
                                keyboard: false
                            });

                            currentCall = new StringeeCall(client, callerId, calleeId, true);

                            // settingCallEvent(currentCall, localVideo, remoteVideo, callButton, answerCallButton, endCallButton, rejectCallButton);
                            settingCallEvent(currentCall, localVideo, remoteVideo, endCallButton, closeButton);

                            callButton.hide();
                            rejectCallButton.hide();
                            answerCallButton.hide();
                            $('.overLayConnent').hide();

                            // $(localVideo).hide();
                            // $(remoteVideo).hide();

                            currentCall.makeCall(function(res) {
                                console.log('+++ call callback: ', res);
                                if (res.message === 'SUCCESS') {
                                    document.dispatchEvent(new Event('connect_ok'));
                                }
                            });
                        })

                        //RECEIVE CALL
                        client.on('incomingcall', function(incomingcall) {

                            $('#ModelVideoCall').modal({
                                backdrop: 'static',
                                keyboard: false
                            });

                            currentCall = incomingcall;

                            let calleeID = currentCall.fromNumber.split(prefixName)[1];

                            axios.get('https://shopthucungpetpet.com/video-call/get_infor_callee?calleeid=' + calleeID)
                                .then((response) => {
                                    let ourSubstring = "http";
                                    let urlAvatar = '';

                                    if (response.data.avatar.includes(ourSubstring)) {
                                        urlAvatar = response.data.avatar;
                                    } else {
                                        urlAvatar = 'https://shopthucungpetpet.com/' + response.data.avatar;
                                    }

                                    let name = response.data.name;

                                    $('#imagAvatarCallee').attr('src', urlAvatar);
                                    $('#nameCalleeId').text(name);
                                    return true;
                                })
                                .then((data) => {
                                    console.log('người nhận', calleeID)

                                    settingCallEvent(currentCall, localVideo, remoteVideo, callButton, answerCallButton, endCallButton, rejectCallButton);

                                    callButton.hide();
                                    answerCallButton.show();
                                    rejectCallButton.show();
                                    endCallButton.hide();
                                    $(localVideo).hide();
                                    $(remoteVideo).hide();
                                    $('.overLayConnent').show();
                                })

                        });

                        //Event handler for buttons
                        answerCallButton.on('click', function() {
                            $(this).hide();
                            rejectCallButton.hide();
                            endCallButton.show();
                            callButton.hide();
                            $(localVideo).show();
                            $(remoteVideo).show();
                            $('.overLayConnent').hide();
                            console.log('current call ', currentCall, typeof currentCall);
                            if (currentCall != null) {
                                currentCall.answer(function(res) {
                                    console.log('+++ answering call: ', res);
                                });
                            }

                        });

                        rejectCallButton.on('click', function() {
                            if (currentCall != null) {
                                currentCall.reject(function(res) {
                                    console.log('+++ reject call: ', res);
                                });
                            }
                            $(localVideo).show();
                            $(remoteVideo).show();
                            $('.overLayConnent').hide();
                            callButton.show();
                            $(this).hide();
                            answerCallButton.hide();
                            // closeButton.show();
                            $('#ModelVideoCall').modal('hide');

                        });

                        endCallButton.on('click', function() {
                            if (currentCall != null) {
                                currentCall.hangup(function(res) {
                                    console.log('+++ hangup: ', res);
                                });
                            }

                            callButton.show();
                            endCallButton.hide();

                        });

                        //event listener to show and hide the buttons
                        document.addEventListener('connect_ok', function() {
                            callButton.hide();
                            endCallButton.show();
                        });
                    })

            }
            getVideoCall(callerId);


        })
    </script>

    @yield('main_js_page')
</body>

</html>