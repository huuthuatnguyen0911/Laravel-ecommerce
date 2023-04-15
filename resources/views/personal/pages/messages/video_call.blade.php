<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User 1</title>

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
    <style>
        #video-container {
            position: relative;
            margin: auto;
            width: 640px;
        }

        video {
            background: #dee;
        }

        #localVideo {
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            z-index: 10;
            background: #333;
        }

        #remoteVideo {
            width: 100%;
        }

        #action-buttons {
            margin: auto;
            text-align: center;
        }

        .hidden-first {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="jumbotron">
                    <div class="container">
                        <h2>Video call Demo - User 1</h2>
                        <p>By <a href="https://developer.stringee.com/">stringee.com</a></p>
                        <div id="incoming-call-notice" style="display: none;">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="sr-only">Incoming call...</span>
                            </div>
                            <h3>Incoming call...</h3>
                        </div>
                    </div>

                </div>

                <div id="video-container">
                    <video id="localVideo" autoplay muted></video>
                    <video id="remoteVideo" autoplay style="height: 360px;"></video>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col" id="action-buttons">
                <button id="callButton" class="btn btn-success">Call</button>
                <button id="answerCallButton" class="btn btn-info hidden-first">Answer Call</button>
                <button id="rejectCallButton" class="btn btn-warning hidden-first">Reject Call</button>
                <button id="endCallButton" class="btn btn-danger hidden-first">End Call</button>
            </div>

        </div>
    </div>


    @include('personal/includes/Javascript')

    <script>
        var token = '{{$token}}';
        var callerId = '{{$user_id}}';
        var calleeId = '{{$friend_id}}';

        console.log(callerId, calleeId);

        function settingCallEvent(call1, localVideo, remoteVideo, callButton, answerCallButton, endCallButton, rejectCallButton) {
            call1.on('addremotestream', function(stream) {
                // reset srcObject to work around minor bugs in Chrome and Edge.
                console.log('addremotestream');
                remoteVideo.srcObject = null;
                remoteVideo.srcObject = stream;
            });

            call1.on('addlocalstream', function(stream) {
                // reset srcObject to work around minor bugs in Chrome and Edge.
                console.log('addlocalstream');
                localVideo.srcObject = null;
                localVideo.srcObject = stream;
            });

            call1.on('signalingstate', function(state) {
                console.log('signalingstate ', state);

                if (state.code === 6 || state.code === 5) //end call or callee rejected
                {
                    callButton.show();
                    endCallButton.hide();
                    rejectCallButton.hide();
                    answerCallButton.hide();
                    localVideo.srcObject = null;
                    remoteVideo.srcObject = null;
                    $('#incoming-call-notice').hide();
                }
            });

            call1.on('mediastate', function(state) {
                console.log('mediastate ', state);
            });

            call1.on('info', function(info) {
                console.log('on info:' + JSON.stringify(info));
            });
        }

        jQuery(function() {

            var localVideo = document.getElementById('localVideo');
            var remoteVideo = document.getElementById('remoteVideo');

            var callButton = $('#callButton');
            var answerCallButton = $('#answerCallButton');
            var rejectCallButton = $('#rejectCallButton');
            var endCallButton = $('#endCallButton');

            var currentCall = null;

            var client = new StringeeClient();
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

            function makeCall() {
                currentCall = new StringeeCall(client, callerId, calleeId, true);
                console.log(currentCall);

                settingCallEvent(currentCall, localVideo, remoteVideo, callButton, answerCallButton, endCallButton, rejectCallButton);

                currentCall.makeCall(function(res) {
                    console.log('+++ call callback: ', res);
                    if (res.message === 'SUCCESS') {
                        document.dispatchEvent(new Event('connect_ok'));
                    }
                });
            }
            makeCall()

            // //RECEIVE CALL
            // client.on('incomingcall', function(incomingcall) {

            //     $('#incoming-call-notice').show();
            //     currentCall = incomingcall;
            //     settingCallEvent(currentCall, localVideo, remoteVideo, callButton, answerCallButton, endCallButton, rejectCallButton);

            //     callButton.hide();
            //     answerCallButton.show();
            //     rejectCallButton.show();

            // });

            // //Event handler for buttons
            // answerCallButton.on('click', function() {
            //     $(this).hide();
            //     rejectCallButton.hide();
            //     endCallButton.show();
            //     callButton.hide();
            //     console.log('current call ', currentCall, typeof currentCall);
            //     if (currentCall != null) {
            //         currentCall.answer(function(res) {
            //             console.log('+++ answering call: ', res);
            //         });
            //     }

            // });

            // rejectCallButton.on('click', function() {
            //     if (currentCall != null) {
            //         currentCall.reject(function(res) {
            //             console.log('+++ reject call: ', res);
            //         });
            //     }

            //     callButton.show();
            //     $(this).hide();
            //     answerCallButton.hide();

            // });

            // endCallButton.on('click', function() {
            //     if (currentCall != null) {
            //         currentCall.hangup(function(res) {
            //             console.log('+++ hangup: ', res);
            //         });
            //     }

            //     callButton.show();
            //     endCallButton.hide();

            // });



            // //event listener to show and hide the buttons
            // document.addEventListener('connect_ok', function() {
            //     callButton.hide();
            //     endCallButton.show();
            // });

        });
    </script>

</body>

</html>