@extends('personal/masterLayout')

@section('main_title')
Messages
@endsection

@section('active_page_main_messages')
active
@endsection

@section('main_style_page')
<style>
   
</style>
@endsection

@section('main_content_page')
<main class="content" id="main_content_page_messages">
    <div class="container p-0">

        <h1 class="h3 mb-3">Messages</h1>

        <div class="card">
            <div class="row g-0 sc-bg-body">
                <div class="col-12 col-lg-5 col-xl-3 border-right">

                    <div class="px-4 d-none d-md-block">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <input type="text" class="form-control my-3" placeholder="Search...">
                            </div>
                        </div>
                    </div>

                    <div class="box_list_friends">
                        @foreach($listFriends as $friend)
                        <a href="{{route('personal.messages.box.chat',$friend->getUser->id)}}" data-id_friend="{{$friend->getUser->id}}" class="show_chat_message change_bg_color_list list-group-item list-group-item-action border-0">
                            <div class="badge bg-success float-right" id="viewCountSeen-{{$friend->getUser->id}}"></div>
                            <div class="d-flex align-items-start">
                                <img src="{{asset($friend->getUser->avatar)}}" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                                <div class="flex-grow-1 ml-3 change_light">
                                    {{$friend->getUser->name}}
                                    <div class="small change_light" id="status_user-{{$friend->getUser->id}}" >
                                        @if($friend->getUser->active_status == 0)
                                        <span class="fas fa-circle chat-online"></span> Online
                                        @else
                                        <span class="fas fa-circle chat-offline"></span> Offine
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach

                    </div>

                    <hr class="d-block d-lg-none mt-1 mb-0">
                </div>
                <div class="col-12 col-lg-7 col-xl-9" id="box_chat_show_main_message">
                    <!-- noiw show box chat -->
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('main_js_page')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                "X-CSRF_TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        // Chọn người để nhắn tin
        $('#main_content_page_messages').on('click', '.show_chat_message', function(e) {
            e.preventDefault();
            let url = $(this).attr("href");
            let idUser = $(this).data("id_friend");

            $('#viewCountSeen-' + idUser).text('');

            $.ajax({
                url: url,
                type: "get",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr("content")
                },
                success: (data) => {
                    // console.log(data);
                    $("#box_chat_show_main_message").html(data);
                    scrollMainMessage()
                }
            })
        })

        // gửi tin nhắn
        $('#box_chat_show_main_message').on('submit', '#formSendMessage', function(e) {
            e.preventDefault();

            let url = $(this).attr("action");
            let dataSend = $(this).serialize();
            $('.box_input_mess').val('');

            $.ajax({
                url: url,
                type: "POST",
                data: dataSend,
                success: (data) => {
                    $youMessages = `
                    <div class="chat-message-right pb-4" style="align-items: center;">
                        <div class="flex-shrink-1 py-2 px-3 mr-3 box_text_message_you box_text_message ">
                            ${data}
                        </div>
                    </div>
                    `;

                    $('#showAllMessage').append($youMessages);
                    scrollMainMessage()

                }
            })
        })

        function scrollMainMessage() {
            var element = document.getElementById("showAllMessage");
            element.scrollTop = element.scrollHeight;
        }
        scrollMainMessage();

    })
</script>
@endsection