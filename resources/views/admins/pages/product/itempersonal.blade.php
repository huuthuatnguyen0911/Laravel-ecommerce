@extends('admins/masterlayoutadmin')

@section('main_title')
Sản phẩm
@endsection

@section('status_avtive_nav')
active
@endsection

@section('status_activeShowDropdown')
activeShowDropdown
@endsection

@section('status_list_4')
active
@endsection

@section('main_content')
<div class="container-fluid box_main_prostatus_avtive_nav_product">
    <div class="page-head mt-5">
        <div class="row container_full" style="justify-content: space-between; align-items: center;">
            <div class="col-md-6">
                <h4 class="mt-2 mb-2">Danh sách sản phẩm</h4>

            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('products.addproduct') }}" class="btn btn-primary btn_add_product ">
                    <i class="fa fa-plus"></i>
                    Thêm Sản phẩm
                </a>
            </div>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data" id="formAddProduct">
                @csrf
                <div class="form-group">
                    <label for="inputIDProduct" class="font-weight-bold">ID sản phẩm</label>
                    <input type="text" class="form-control" id="inputIDProduct" readonly name="IDProduct" placeholder="VD: ID_Tensanpham_002">
                    <span class="errorMessIDProduct"></span>
                </div>
                <div class="form-group">
                    <label for="inputIDArchives" class="font-weight-bold">ID Kho</label>
                    <input type="text" class="form-control" id="inputIDArchives" readonly name="IDArchives" placeholder="VD: KH_IDSanPham">
                    <span class="errorMessIDArchives"></span>
                </div>
                <div class="form-group">
                    <label for="inputNameProduct" class="font-weight-bold">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="inputNameProduct" name="NameProduct" placeholder="VD: Điện thoại abc">
                    <span class="errorMessNameProduct"></span>
                </div>
                <div class="form-group">
                    <label for="inputListCategory" class="font-weight-bold">Thể loại</label>
                    <select class="form-control" name="inputListCategory" id="inputListCategory">
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
                    <label for="inputDescription" class="font-weight-bold">Mô tả tóm tắtsản phẩm</label>
                    <textarea class="form-control" id="inputDescription" name="Description" rows="6" style="resize: none; width: 100%;" placeholder="VD: mô tả..."></textarea>
                    <span class="errorMessDescription"></span>
                </div>
                <div class="form-group">
                    <label for="inputSubDescription" class="font-weight-bold">Mô tả chi tiết sản phẩm</label>
                    <textarea class="form-control" id="inputSubDescription" name="SubDescription" rows="6" style="resize: none; width: 100%;" placeholder="VD: mô tả..."></textarea>
                    <span class="errorMessSubDescription"></span>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" name="switch1" id="checkswitch1">
                    <label class="custom-control-label" for="checkswitch1">Hiển thị sản phẩm</label>
                </div>

                <div class="form-group text-right">
                    <button type="submit" name="submit" value="submitEditProduct" class="btn btn-primary">Sửa</button>
                </div>

            </form>
        </div>
    </div>
    <div class="edit-table mt-5">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3" style=" align-items: center; ">
                            <div class="col-md-4">
                                <!--<p class="text-muted">Add toolbar column with edit and delete buttons.</p> -->
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4 text-right ">
                                <!-- Button to Open the Modal add -->

                            </div>
                        </div>
                        <div class="">
                            <table class="table table-striped" id="product_table">
                                <thead>
                                    <tr>
                                        <!-- <th>NO</th> -->
                                        <th>ID SP</th>
                                        <th>Tên SP</th>
                                        <th>Mô tả</th>
                                        <th>Ảnh SP</th>
                                        <th>Thể loại</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodyProduct">
                                </tbody>
                            </table>

                        </div>
                        <!-- tao phần phân trang -->
                        <div class="box_pagination_main">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>

</div>
@endsection

@section('javascript_page')
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

<script src="{{asset('plugins/tinymce/tinymce.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            var table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('item.listData') }}",
                columns: [{
                        data: 'item_id',
                        name: 'item_id'
                    },
                    {
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'item_description',
                        name: 'item_description'
                    },
                    {
                        data: 'getMainImage.link_image',
                        render: function(data, type, row, meta) {
                            var details = "";
                            for (var item in row.get_main_image) {
                                if (row.get_main_image != null) {
                                    details = row.get_main_image.link_image;
                                }
                            }
                            return '<img src="../../' + details + '" alt="" style="height: 50px; object-fit: cover;" class="rounded float-left">';
                        },
                    },
                    {
                        data: 'category.category_name',
                        render: function(data, type, row, meta) {
                            var details = "";

                            for (var item in row.category) {
                                details = row.category.category_name;
                            }
                            return details;


                        },
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],

            });

            $("#tableBodyProduct ").on("click", ".btn_delete_product", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                let $removeData = $(this).parent().parent();
                $.ajax({
                    url: $(this).attr("href"),
                    type: "DELETE",
                    data: $(this).data("id"),
                    success: function(data) {
                        $removeData.remove();
                    }
                })
            })
        });

        $("body").on("click", ".btn_edit_product", function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: $(this).attr("href"),
                type: "GET",
                data: $(this).data("id"),
                success: function(data) {
                    // console.log(data);

                    $("#inputIDProduct").val(data.item_id);
                    $("#inputListCategory option[value='" + data.category_id + "']").attr("selected", "selected");
                    if (data.get_archive != null) {
                        $("#inputIDArchives").val(data.get_archive.id_archive);
                        $("#inputPriceImport").val(number_format(Number(data.get_archive.import_price)));
                        $("#inputPriceProduct").val(number_format(Number(data.get_archive.price)));
                        $("#inputQuantityProduct").val(data.get_archive.quantity);
                        if (data.get_archive.deploy == 1) {
                            $("#checkswitch1").attr('checked', true);
                        }
                    } else {
                        $("#inputIDArchives").val("");
                        $("#inputPriceImport").val("");
                        $("#inputPriceProduct").val("");
                        $("#inputQuantityProduct").val("");
                        $("#checkswitch1").attr('checked', false);
                    }
                    $("#inputNameProduct").val(data.item_name);
                    $("#inputDescription").val(data.item_description);
                    // $('#inputSubDescription').data("wysihtml5").editor.setValue(data.item_sub_description);
                    // // $("#inputSubDescription").val(data.item_sub_description);
                    tinymce.activeEditor.execCommand('mceInsertContent', false, data.item_sub_description);
                }
            })
        })

        // kiểm tra form
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
        $("body").on('input', '#inputNameProduct', function(e) {
            e.preventDefault();
            $(".errorMessNameProduct").text("");
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
                    "save table contextmenu directionality emoticons template paste textcolor code "
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

    function isNumber(n) {
        let reg = /^-?[\d.]+(?:e-?\d+)?$/;
        if (reg.test(n) && typeof n === "number") {
            return true;
        }
        return false;
    }
</script>

@if(session()->has('successEditProduct'))
<script>
    $(document).ready(function() {
        $(".alert-success .text_msg").text("{{session()->get('successEditProduct')}}");
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
{{session()->forget('successEditProduct')}}
@endif
@if(session()->has('errEditProduct'))
<script>
    $(document).ready(function() {
        $(".alert-danger .text_msg").text("{{session()->get('errEditProduct')}}");
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
</script>
{{session()->forget('errEditProduct')}}
@endif
@endsection