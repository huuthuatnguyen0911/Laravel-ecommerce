@extends('admins/masterlayoutadmin')

@section('main_title')
Thêm sản phẩm
@endsection

@section('status_avtive_nav')
active
@endsection

@section('status_activeShowDropdown')
activeShowDropdown
@endsection

@section('status_list_2')
active
@endsection

@section('main_content')
<div class="container-fluid box_main_prostatus_avtive_nav_product">
    <div class="page-head mt-5">
        <h4 class="my-2">Thêm sản phẩm</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{route('products.addproduct.addInfProduct')}}" method="post" enctype="multipart/form-data" id="formAddProduct">
                @csrf
                <div class="form-group">
                    <label for="inputIDProduct" class="font-weight-bold">ID sản phẩm</label>
                    <input type="text" class="form-control" id="inputIDProduct" name="IDProduct" autocomplete="off" placeholder="VD: ID_Tensanpham_002">
                    <span class="errorMessIDProduct"></span>
                </div>
                <div class="form-group">
                    <label for="inputIDArchives" class="font-weight-bold">ID Kho</label>
                    <input type="text" class="form-control" id="inputIDArchives" name="IDArchives" placeholder="VD: KH_IDSanPham">
                    <span class="errorMessIDArchives"></span>
                </div>
                <div class="form-group">
                    <label for="inputNameProduct" class="font-weight-bold">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="inputNameProduct" name="NameProduct" placeholder="VD: Điện thoại abc">
                    <span class="errorMessNameProduct"></span>
                </div>
                <div class="form-group">
                    <label for="inputListCategory" class="font-weight-bold">Thể loại</label>
                    <!-- <div class="mb-3" style="display: flex ;align-items: center; ">
                        <div class="form-check mr-3">
                            <input class="form-check-input" type="radio" name="radioCategory" id="thucungRadio1" value="thucungradio" checked >
                            <label class="form-check-label" for="thucungRadio1">
                                Thú cưng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioCategory" id="sanPhamRadio2" value="sanphamradio">
                            <label class="form-check-label" for="sanPhamRadio2">
                                Sản phẩm
                            </label>
                        </div>
                    </div> -->
                    <select class="form-control" name="inputListCategory" id="inputListCategory">
                        <!-- lựa chọn thể loại -->
                        @if( isset($listCategorys) )
                        @foreach($listCategorys as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                        @endif
                    </select>
                    <span class="errorMessListCategory"></span>
                </div>
                <div class="form-group">
                    <label for="inputPriceImport" class="font-weight-bold">Giá nhập</label>
                    <input type="text" class="form-control" id="inputPriceImport" name="PriceImport" placeholder="VD: 25,000,000 hoặc 25000000">
                    <span class="errorMessPriceImport"></span>
                </div>
                <div class="form-group">
                    <label for="inputPercentPrice" class="font-weight-bold">Phần trăm giá bán (giá nhập + (giá nhập * phần trăm)/100)</label>
                    <input type="text" class="form-control" id="inputPercentPrice" name="PercentPrice" placeholder="VD: 10%,20%,30%,... hoặc 10,20,30">
                    <span class="errorMessPercentPrice"></span>
                </div>
                <div class="form-group">
                    <label for="inputPriceProduct" class="font-weight-bold">Giá bán</label>
                    <input type="text" class="form-control" id="inputPriceProduct" name="PriceProduct" placeholder="VD: 25,000,000 hoặc 25000000">
                    <span class="errorMessPriceProduct"></span>
                </div>
                <div class="form-group">
                    <label for="inputQuantityProduct" class="font-weight-bold">Số lượng</label>
                    <input type="text" class="form-control" id="inputQuantityProduct" name="QuantityProduct" placeholder="VD: 20,10,100">
                    <span class="errorMessQuantityProduct"></span>
                </div>
                <div class="form-group">
                    <label for="inputDescription" class="font-weight-bold">Mô tả tóm tắt sản phẩm</label>
                    <textarea class="form-control" id="inputDescription" name="Description" rows="6" style="resize: none; width: 100%;" placeholder="VD: mô tả..."></textarea>
                    <span class="errorMessDescription"></span>
                </div>
                <div class="form-group">
                    <label for="inputSubDescription" class="font-weight-bold">Mô tả chi tiết sản phẩm</label>
                    <textarea class="form-control" id="inputSubDescription" name="SubDescription" rows="6" style="resize: none; width: 100%;" placeholder="VD: mô tả..."></textarea>
                    <span class="errorMessSubDescription"></span>
                </div>
                <div class="form-group">
                    <label for="inputImageProduct" class="font-weight-bold">Chọn ảnh sản phẩm</label>
                    <input type="file" class="form-control" id="inputImageProduct" name="ImageProduct[]" accept="image/*" multiple>
                    <span class="errorMessImageProduct"></span>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" name="switch1" id="switch1">
                    <label class="custom-control-label" for="switch1">Hiển thị sản phẩm</label>
                </div>

                <div class="form-group text-right">
                    <button type="submit" name="submit" value="submitAddProduct" class="btn btn-primary">Thêm</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript_page')
<script src="{{asset('plugins/tinymce/tinymce.min.js')}}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $("body").on('input', "#inputIDProduct", function(e) {
            e.preventDefault();
            let textMessage = $(this).val();
            $("#inputIDArchives").val('KH_' + textMessage);
            if ($(this).val() === '') {
                $("#inputIDArchives").val('');
            }
            $.ajax({
                url: "{{route('products.addproduct.checkExistProduct')}}",
                type: "POST",
                data: {
                    IdProduct: textMessage,
                },
                success: function(data) {
                    if (data.status == '304existsproduct') {
                        $('.errorMessIDProduct').text(data.title).css('color', 'red');
                    } else {
                        $('.errorMessIDProduct').text('')
                    }
                }
            })
        })
        $("body").on('input', '#inputIDArchives', function(e) {
            e.preventDefault();
            let textMessage = $(this).val();
            $.ajax({
                url: "{{route('products.addproduct.checkExistArchive')}}",
                type: "POST",
                data: {
                    IdCategory: textMessage,
                },
                success: function(data) {
                    if (data.status == '304existsarchive') {
                        $('.errorMessIDArchives').text(data.title).css('color', 'red');
                    } else {
                        $('.errorMessIDArchives').text('')
                    }
                }
            })
        })
        $("body").on('input', '#inputPriceImport', function(e) {
            e.preventDefault();
            let data = $(this).val();
            let newdata = data.split(/[.,,]/).join('');
            if (isNumber(Number(newdata)) == false) {
                $(".errorMessPriceImport").text("Không nhập kí tự chữ").css('color', 'red');
            } else {
                $(".errorMessPriceImport").text('');
            }
        })
        $("body").on('input', '#inputPriceProduct', function(e) {
            e.preventDefault();
            let data = $(this).val();
            let newdata = data.split(/[.,,]/).join('');
            if (isNumber(Number(newdata)) == false) {
                $(".errorMessPriceProduct").text("Không nhập kí tự chữ").css('color', 'red');
            } else {
                $(".errorMessPriceProduct").text('');
            }
        })
        $("body").on('input', '#inputQuantityProduct', function(e) {
            e.preventDefault();
            let data = $(this).val();
            if (isNumber(Number(data)) == false) {
                $(".errorMessQuantityProduct").text("Không nhập kí tự chữ").css('color', 'red');
            } else {
                $(".errorMessQuantityProduct").text('');
            }
        })
        $("body").on('input', '#inputPercentPrice', function(e) {
            e.preventDefault();
            let error = false;
            let data = $(this).val();
            let newdataArr = data.split(/[%]/);

            let dataJoin = newdataArr.join('');
            if (isNumber(Number(dataJoin)) == false) {
                error = true;
                $(".errorMessPercentPrice").text("Không nhập kí tự chữ").css('color', 'red');
            } else {
                $(".errorMessPercentPrice").text('');
            }

            if (_.includes(data, "%")) {
                if (newdataArr[1] != '') {
                    error = true;
                    $(".errorMessPercentPrice").text('Không được nhập kí tự sau dấu %').css('color', 'red');
                } else {
                    $(".errorMessPercentPrice").text("")
                }
            }

            if (error == false) {
                $(".errorMessPercentPrice").text("")
                let PriceImport = $("#inputPriceImport").val().split(/[.,,]/).join('');
                let giaBan = Number(PriceImport) + (Number(PriceImport) * Number(dataJoin)) / 100;
                // console.log(Number(PriceImport) * Number(dataJoin));
                $("#inputPriceProduct").val(giaBan);
            }
        })
        $("body").on('input', '#inputNameProduct', function(e) {
            e.preventDefault();
            $(".errorMessNameProduct").text("");
        })
        $("body").on('change', "#inputImageProduct", function(e) {
            e.preventDefault();
            let err = '';
            let files = $(this)[0].files;

            if (files.length > 4) {
                $(".errorMessImageProduct").text('Chỉ chọn tối đa 4 ảnh').css('color', 'red');
                $(this).val('')
            } else if (files.size > 2000000) {
                $(".errorMessImageProduct").text('Phải ảnh không dc lớn hơn 2MB').css('color', 'red');
                $(this).val('')
            } else {
                $(".errorMessImageProduct").text('');
            }
        })
        $("body").on('submit', '#formAddProduct', function(e) {
            if ($('#inputIDProduct').val() == '') {
                $('.errorMessIDProduct').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                e.preventDefault();
            }
            if ($('#inputIDArchives').val() == '') {
                $('.errorMessIDArchives').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                e.preventDefault();
            }
            if ($('#inputNameProduct').val() == '') {
                $('.errorMessNameProduct').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                e.preventDefault();
            }
            if ($('#inputPriceImport').val() == '') {
                $('.errorMessPriceImport').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                e.preventDefault();
            }
            if ($('#inputPriceProduct').val() == '') {
                $('.errorMessPriceProduct').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                e.preventDefault();
            }
            if ($('#inputPercentPrice').val() == '') {
                $('.errorMessPercentPrice').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                e.preventDefault();
            }
            if ($('#inputImageProduct').val() == '') {
                $('.errorMessImageProduct').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                e.preventDefault();
            }
            if ($('#inputQuantityProduct').val() == '') {
                $('.errorMessQuantityProduct').text("Cần nhập đầy đủ thông tin").css('color', 'red');
                e.preventDefault();
            }
        })

        if ($("#inputSubDescription").length > 0) {
            tinymce.init({
                selector: "textarea#inputSubDescription",
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

    })

    function isNumber(n) {
        let reg = /^-?[\d.]+(?:e-?\d+)?$/;
        if (reg.test(n) && typeof n === "number") {
            return true;
        }
        return false;
    }
</script>
@if(session()->has('successAddProduct'))
<script>
    $(document).ready(function() {
        $(".alert-success .text_msg").text("{{session()->get('successAddProduct')}}");
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
</script>
{{session()->forget('successAddProduct')}}
@endif
@endsection