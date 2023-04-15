    <div class="py-2 px-4 border-bottom d-none d-lg-block">
        <div class="d-flex align-items-center py-1">
            <div class="position-relative">
                <img src="{{asset($dataUser->avatar)}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
            </div>
            <div class="flex-grow-1 pl-3">
                <strong class="change_light">{{$dataUser->name}}</strong>
            </div>
            <div>
                <button class="btn btn-sm btn-primary btn-lg mr-1 px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone feather-lg">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </button>
                <button id="call_video_id" class="btn btn-sm btn-info btn-lg mr-1 px-3 d-none d-md-inline-block" data-friend_id="{{$dataUser->id}}" data-user_id="{{Auth::user()->id}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video feather-lg">
                        <polygon points="23 7 16 12 23 17 23 7"></polygon>
                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                    </svg>
                </button>
                <button class="btn btn-sm btn-light border btn-lg px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-lg">
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="19" cy="12" r="1"></circle>
                        <circle cx="5" cy="12" r="1"></circle>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="position-relative">
        <div class="chat-messages p-4" id="showAllMessage" data-current="{{$dataUser->id}}">

            @foreach($dataListMess as $message)
            @if($message->id_from == Auth::user()->id)
            <div class="chat-message-right pb-4" style="align-items: center;">
                <div class="flex-shrink-1 py-2 px-3 mr-3 box_text_message_you box_text_message ">
                    {{$message->content}}
                </div>
            </div>
            @else
            <div class="chat-message-left pb-4" style="align-items: center;">
                <div>
                    <img src="{{asset($dataUser->avatar)}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                    <div class="text-muted small text-nowrap mt-2">{{date_format($message->created_at, 'H:i')}}</div>
                </div>
                <div class="flex-shrink-1 py-2 px-3 ml-3  box_text_message box_text_message_friend change_light">
                    {{$message->content}}
                </div>
            </div>
            @endif
            @endforeach

        </div>
    </div>

    <div class="flex-grow-0 py-3 px-4 border-top">
        <form action="{{route('personal.messages.send')}}" id="formSendMessage" method="post">
            @csrf
            <div class="input-group">
                <input type="hidden" name='idUserTo' value="{{$dataUser->id}}">
                <input type="text" class="form-control box_input_mess" name='textMessasge' placeholder="Type your message">
                <button type="submit" class="btn btn-primary btnSendMessage">Gửi</button>
            </div>
        </form>
    </div>