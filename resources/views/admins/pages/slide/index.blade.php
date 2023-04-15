@extends('admins/masterlayoutadmin')

@section('main_title')
Slide
@endsection

@section('status_avtive_nav_slide')
active
@endsection

@section('status_activeShowDropdown_slide')
activeShowDropdown
@endsection

@section('status_list_slide_1')
active
@endsection

@section('style_page_main')
<style>
    #tableBodySlide td {
        vertical-align: middle;
    }
</style>
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-head mt-5">
        <div class="row container_full" style="justify-content: space-between; align-items: center;">
            <div class="col-md-6">
                <h4 class="mt-2 mb-2">Quản lí slide</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="" class="btn btn-primary btn_add_slide ">
                    <i class="fa fa-plus"></i>
                    Thêm slide
                </a>
            </div>
        </div>
    </div>
    <div class="edit-table mt-5">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="">
                            <table class="table table-striped" id="archive_table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <!-- <th>NO</th> -->
                                        <th>No</th>
                                        <th>Ảnh slide</th>
                                        <th>Tiêu đề phụ</th>
                                        <th>Nội dung phụ</th>
                                        <th>Tiêu đề chính</th>
                                        <th>Nội dung chính</th>
                                        <th>Nội dung nút</th>
                                        <th>Đường dẫn</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodySlide">
                                    @isset($dataSlides)
                                    @foreach($dataSlides as $dataSlide)
                                    <tr class="box_category_main  ">
                                        <td>{{$loop->index +1}}</td>
                                        <td>
                                            <div class="text-left">
                                                <img id="" src="{{asset($dataSlide->image)}}" style="height:50px;" class="rounded" alt="">
                                            </div>
                                        </td>
                                        <td id="">{{$dataSlide->sub_title}}</td>
                                        <td id="">{{$dataSlide->sub_title_text}}</td>
                                        <td id="">{{$dataSlide->main_title}}</td>
                                        <td id="">{{$dataSlide->main_title_text}}</td>
                                        <td id="">{{$dataSlide->text_button}}</td>
                                        <td id="">{{$dataSlide->link_button}}</td>
                                        <td>
                                            <div class="text-center">
                                                <a href="{{route('slide.show',$dataSlide->id)}}" data-id="{{$dataSlide->id}}" name="seenCategory" class="btn btn-outline-primary btn_edit_slide"><i class="fa fa-edit"></i></a>
                                                <a href="{{route('slide.destroy',$dataSlide->id)}}" data-id="{{$dataSlide->id}}" onclick="event.preventDefault();
                                        document.getElementById('formDeleteSlide').submit();" name="deleteCategory" class="btn btn-outline-danger btn_delete_slide"> <i class="fa  fa-trash-o"></i> </a>
                                                <form id="formDeleteSlide" action="{{route('slide.destroy',$dataSlide->id)}}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                    @endisset
                                </tbody>
                            </table>

                        </div>
                        <!-- tao phần phân trang -->
                        <div class="box_pagination_main">
                            @isset($dataSlides)
                            {{ $dataSlides->appends(request()->all())->links() }}
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modelSlide" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa slide</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('slide.store')}}" method="post" enctype="multipart/form-data" id="formEditSlide">
                        @csrf
                        <div class="form-group">
                            <label for="inputImage">Ảnh slide</label>
                            <img src="" alt="" id="imginputImage" style="width: 100%; height:300px; object-fit: contain;">
                            <input type="file" class="form-control" id="inputImage" name="Image" accept="image/*" placeholder="Password">
                            <span id="errorImage"></span>
                        </div>
                        <div class="form-group">
                            <label for="inputSubTitle">Tiêu đề phụ</label>
                            <input type="text" class="form-control" id="inputSubTitle" name="SubTitle" placeholder="VD: 20% sản phẩm">
                            <span id="errorSubTitle"></span>
                        </div>
                        <div class="form-group">
                            <label for="inputSubTitleText">Nội dung phụ</label>
                            <input type="text" class="form-control" id="inputSubTitleText" name="SubTitleText" placeholder="...">
                            <span id="errorSubTitleText"></span>
                        </div>
                        <div class="form-group">
                            <label for="inputMainTitle">Tiêu đề chính</label>
                            <input type="text" class="form-control" id="inputMainTitle" name="MainTitle" placeholder="...">
                            <span id="errorMainTitle"></span>
                        </div>
                        <div class="form-group">
                            <label for="inputMainTitleText">Nội dung chính</label>
                            <input type="text" class="form-control" id="inputMainTitleText" name="MainTitleText" placeholder="...">
                            <span id="errorMainTitleText"></span>
                        </div>
                        <div class="form-group">
                            <label for="inputTitleButton">Nội dung nút</label>
                            <input type="text" class="form-control" id="inputTitleButton" name="TitleButton" placeholder="...">
                            <span id="errorTitleButton"></span>
                        </div>
                        <div class="form-group">
                            <label for="inputLinkButton">Đường dẫn</label>
                            <input type="text" class="form-control" id="inputLinkButton" name="LinkButtonLinkButton" placeholder="...">
                            <span id="errorLinkButton"></span>
                        </div>
                        <input type="hidden" name="idSlide" id="inputIdSlide" value="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript_page')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        })
        let idSlide = '';

        $('body').on('submit', '#formEditSlide', function(e) {
            if ($('#inputImage')[0].files.length == 0) {
                e.preventDefault();
                $('#errorImage').text('Hãy chọn một ảnh').css('color', 'red');
            }
        })

        $("body").on('click', '.btn_edit_slide', function(e) {
            e.preventDefault();
            $('#modelSlide').modal('toggle')
            let urldata = $(this).attr('href');
            $.ajax({
                url: urldata,
                type: 'GET',
                success: function(data) {
                    // console.log(window.location.href('public'));
                    $('#inputIdSlide').val(data.id);
                    $('#imginputImage').attr('src', 'http://shopthucungpetpet.com/' + data.image);
                    $('#inputSubTitle').val(data.sub_title);
                    $('#inputSubTitleText').val(data.sub_title_text);
                    $('#inputMainTitle').val(data.main_title);
                    $('#inputMainTitleText').val(data.main_title_text);
                    $('#inputTitleButton').val(data.text_button);
                    $('#inputLinkButton').val(data.link_button);
                }
            })
        })

        $("body").on('click', '.btn_add_slide', function(e) {
            e.preventDefault();
            $('#modelSlide').modal('toggle');
            $('#imginputImage').hide();
            removeValModel();
        })

        function removeValModel() {
            $('#inputIdSlide').val('');
            $('#imginputImage').attr('');
            $('#inputSubTitle').val('');
            $('#inputSubTitleText').val('');
            $('#inputMainTitle').val('');
            $('#inputMainTitleText').val('');
            $('#inputTitleButton').val('');
            $('#inputLinkButton').val('');
        }

        if ('{{session()->has("editSuccess")}}') {
            $(document).ready(function() {
                $(".alert-success .text_msg").text("{{session()->get('editSuccess')}}");
                $(".alert-success").css({
                    right: "30px",
                    "z-index": "99999"
                });
                $(".alert-success .close").click(function() {
                    $(".alert-success").css({
                        right: "-999px"
                    });
                });

                setTimeout(function() {
                    $(".alert-success").css({
                        right: "-999px"
                    });
                }, 3000);
            })

            '{{session()->forget("editSuccess")}}'
        }
        if ('{{session()->has("addSuccess")}}') {
            $(document).ready(function() {
                $(".alert-success .text_msg").text("{{session()->get('addSuccess')}}");
                $(".alert-success").css({
                    right: "30px",
                    "z-index": "99999"
                });
                $(".alert-success .close").click(function() {
                    $(".alert-success").css({
                        right: "-999px"
                    });
                });

                setTimeout(function() {
                    $(".alert-success").css({
                        right: "-999px"
                    });
                }, 3000);
            })

            '{{session()->forget("addSuccess")}}'
        }
        if ('{{session()->has("errorSlide")}}') {
            $(document).ready(function() {
                $(".alert-danger .text_msg").text("{{session()->get('errorSlide')}}");
                $(".alert-danger").css({
                    right: "30px",
                    "z-index": "99999"
                });
                $(".alert-danger .close").click(function() {
                    $(".alert-danger").css({
                        right: "-999px"
                    });
                });

                setTimeout(function() {
                    $(".alert-danger").css({
                        right: "-999px"
                    });
                }, 3000);
            })

            '{{session()->forget("errorSlide")}}'
        }
    })
</script>
@endsection