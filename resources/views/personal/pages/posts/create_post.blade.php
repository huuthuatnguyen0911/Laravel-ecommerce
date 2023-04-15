<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo bài viết</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/personal/css/main_style.css')}}">

</head>

<body>

    <div class="main_box_page_posts">
        <!-- <div class="container-fluid"> -->
        <header id="header_main">
            <div class="box_to_bacK">
                <a class="btn_bacK-home" href="{{route('personal.post.index')}}">
                    <i class="fas fa-chevron-left"></i>
                    <span>Trang chủ</span>
                </a>
            </div>
        </header>

        <section id="content_main" class=" mt-5 mb-5">
            <div class="container-fluid">
                <form action="{{route('personal.post.infor')}}" id="formCreatePost" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="box_submit_post">
                            <select name="status_input" class="mr-3" id="inputStatusPost">
                                <option value="0">Công khai</option>
                                <option value="1">Cá nhân</option>
                            </select>
                            <input type="submit" class="btn btn-primary" id="inputSubmitPost" name="submitPost" value="Tạo">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Tiêu đề" id="inpuTitlePost" name="inpuTitle">
                        <span id="errorInputTitlePost" class=""></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Thể loại" id="inpuCategoryPost" name="inpuCategory">
                        <span id="errorInputCategoryPost" class=""></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Ảnh đại diện:</label>
                        <input type="file" class="form-control" accept="image/*" id="inpuImagePost" name="inpuImage">
                        <span id="errorImagePost" class=""></span>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="inputContentPost" name="inputcontent" style=" width: 100%; height: 500px;" placeholder="Nhập nội dung bài viết..."></textarea>
                        <span id="errorInputContentPost" class=""></span>
                    </div>

                </form>
            </div>
        </section>

        <footer id="footer_main">

        </footer>
        <!-- </div> -->
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{asset('plugins/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/personal/js/main_js.js')}}"></script>

    <script>
        $(document).ready(function() {

            if ($("#inputContentPost").length > 0) {
                tinymce.init({
                    selector: "textarea#inputContentPost",
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    language: 'vi_VN',
                    image_title: true,
                    automatic_uploads: true,
                    file_picker_types: 'image',
                    file_picker_callback: function(cb, value, meta) {
                        var input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');
                        input.onchange = function() {
                            var file = this.files[0];
                            var reader = new FileReader();

                            reader.onload = function() {
                                var id = 'blobid' + (new Date()).getTime();
                                var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                var base64 = reader.result.split(',')[1];
                                var blobInfo = blobCache.create(id, file, base64);
                                blobCache.add(blobInfo);
                                cb(blobInfo.blobUri(), {
                                    title: file.name
                                });
                            };
                            reader.readAsDataURL(file);
                        };
                        input.click();
                    },
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                            title: 'Bold text',
                            inline: 'b'
                        },
                        {
                            title: 'Red text',
                            inline: 'span',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Red header',
                            block: 'h1',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Example 1',
                            inline: 'span',
                            classes: 'example1'
                        },
                        {
                            title: 'Example 2',
                            inline: 'span',
                            classes: 'example2'
                        },
                        {
                            title: 'Table styles'
                        },
                        {
                            title: 'Table row 1',
                            selector: 'tr',
                            classes: 'tablerow1'
                        }
                    ]
                });
            }

            $("body").on('submit', '#formCreatePost', function(e) {

                let files = $('#inpuImagePost')[0].files.length;

                if ($('#inpuTitlePost').val() == '') {
                    $('#errorInputTitlePost').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                    e.preventDefault();
                }
                if ($('#inpuCategoryPost').val() == '') {
                    $('#errorInputCategoryPost').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                    e.preventDefault();
                }
                if (files == 0) {
                    $('#errorImagePost').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                    e.preventDefault();
                }
                if ($('#inputContentPost').val() == '') {
                    $('#errorInputContentPost').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                    e.preventDefault();
                }
            })
        })
    </script>

</body>

</html>