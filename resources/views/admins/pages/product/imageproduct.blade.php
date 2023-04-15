@extends('admins/masterlayoutadmin')

@section('main_title')
Ảnh sản phẩm
@endsection

@section('status_avtive_nav')
active
@endsection

@section('status_activeShowDropdown')
activeShowDropdown
@endsection

@section('status_list_3')
active
@endsection

@section('main_content')
<div class="container-fluid box_main_prostatus_avtive_nav_product">
    <div class="page-head mt-5">
        <div class="row container_full" style="justify-content: space-between; align-items: center;">
            <div class="col-md-6">
                <h4 class="mt-2 mb-2">Ảnh sản phẩm sản phẩm</h4>

            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-info" style="background-color: orange;" data-toggle="modal" data-target="#addImage">
                    <i class="fa fa-image"></i>
                    Thêm ảnh
                </button>
                <a href="{{ route('products.addproduct') }}" class="btn btn-primary btn_add_product ">
                    <i class="fa fa-plus"></i>
                    Thêm Sản phẩm
                </a>
            </div>
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
                            <table class="table table-striped" id="product_image_table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <!-- <th>NO</th> -->
                                        <th>ID SP</th>
                                        <th>Tên SP</th>
                                        <th>Ảnh SP</th>
                                        <th>Mô tả ảnh</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodyImageProduct">
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

<!-- The Modal -->
<div class="modal fade" id="addImage">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thêm ảnh</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('imageproduct.store') }}" method='post' id='formAddImage' enctype='multipart/form-data' ">
                    <div class=" form-group">
                    <label for="inputIdProduct">Id sản phẩm:</label>
                    <input type="text" class="form-control" placeholder="VD: ID_SP_01" id="inputIdProduct" name="IdProduct">
                    <span class="errorIdProduct"></span>
            </div>
            <div class="form-group">
                <label for="inputImage">Chọn ảnh:</label>
                <input type="file" class="form-control" accept="image/*" id="inputImage" name="Image">
                <span class="errorImage"></span>
            </div>
            <div class="form-group">
                <label for="inputAltImage">Mô tả ảnh:</label>
                <textarea id="inputAltImage" name="AltImage" class="form-control" rows="10" style="width: 100%; resize: none;"></textarea>
                <span class="errorAltImage"></span>
            </div>

            </form>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button class="btn btn-info" id="btnAddInf">Thêm ảnh</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
        </div>


    </div>
</div>
</div>
@endsection

@section('javascript_page')
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(function() {
            let table = $('#product_image_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('imagesproduct.getallimage') }}",
                columns: [{
                    data: 'product_id',
                    name: 'product_id'
                }, {
                    data: 'get_product.product_name',
                    // data: 'get_item.item_name',
                    render: function(data, type, row, meta) {
                        var details = "";

                        for (var item in row.get_product) {
                            details = row.get_product.product_name
                        }
                        return details;
                    },
                }, {
                    data: "image",
                    render: function(data, type, row, meta) {
                        var details = "";

                        for (var item in row.image) {
                            details = row.image;
                        }
                        return details;
                    },
                }, {
                    data: "alt_image",
                    name: "alt_image"
                }, {
                    data: 'action',
                    name: 'action'
                }],

            });

            $("body").on('click', '#btnAddInf', function(e) {
                e.preventDefault();

                let table = $("#formAddImage");
                let idPrroduct = $("#formAddImage #inputIdProduct");
                let imageFiles = $("#formAddImage #inputImage");
                let altImage = $("#formAddImage #inputAltImage");

                let files = imageFiles[0].files[0];

                var form_data = new FormData();
                form_data.append("fileAddImage", files);
                form_data.append("idPrroduct", idPrroduct.val());
                form_data.append("altImageAdd", altImage.val());

                $.ajax({
                    type: "POST",
                    url: table.attr("action"),
                    data: form_data,
                    cache: false,
                    contentType: false,
                    mimeType: "multipart/form-data",
                    processData: false,
                    success: (data) => {
                        let jsondata = JSON.parse(data);
                        if (jsondata.status == 'successAddImage') {
                            $(".alert-success .text_msg").text(jsondata.mess);
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
                            $('#product_image_table').DataTable().ajax.reload();

                        }
                        if (jsondata.status == 'errorAddImage') {
                            $(".alert-danger .text_msg").text(jsondata.mess);
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
                        }
                    },
                    error: function(data) {},
                });
            })


        });



        let urledit = "";
        let idEdit = "";
        $("#tableBodyImageProduct").on("click", ".btn_edit_image_product", function(e) {
            e.preventDefault();
            urledit = $(this).attr("href");

            let inPutImage = $(this).parent().parent().find('.inputImageProduct');
            let textareaMoTa = $(this).parent().parent().find('.textareaMoTa');

            idEdit = $(this).data("id");
            inPutImage.toggle();

            if (inPutImage.css('display') == 'none') {
                $(this).addClass('btn-outline-primary');
                $(this).removeClass('btn-outline-danger');
                textareaMoTa.attr('disabled', true);
            } else {
                $(this).removeClass('btn-outline-primary');
                $(this).addClass('btn-outline-danger');
                textareaMoTa.attr('disabled', false);
            }
        })

        $("#tableBodyImageProduct").on('change', '.inputImageProduct', function(e) {
            e.preventDefault();

            let err = '';
            let files = $(this)[0].files[0];
            let imageChange = $(this).parent().find('img');

            var form_data = new FormData();
            form_data.append("fileData", files);
            form_data.append("id", imageChange.data('id'));

            $.ajax({
                type: "POST",
                url: urledit,
                data: form_data,
                cache: false,
                contentType: false,
                mimeType: "multipart/form-data",
                processData: false,
                success: (data) => {
                    let jsondata = JSON.parse(data);
                    if (jsondata.status == 'successEdit') {
                        $(".alert-success .text_msg").text(jsondata.Mess);
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

                        imageChange.attr("src", "http://127.0.0.1:8000/" + jsondata.linkImage);
                        $('#product_image_table').DataTable().ajax.reload();
                    }
                    if (jsondata.status == 'errorsEdit') {
                        $(".alert-danger .text_msg").text(jsondata.Mess);
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
                    }
                },
                error: function(data) {},
            });

        })

        $("#tableBodyImageProduct").on("input", '.textareaMoTa', function(e) {
            let dataInput = $(this).val();
            $.ajax({
                url: urledit,
                type: "POST",
                data: {
                    'idEditText': idEdit,
                    'contentEdit': dataInput,
                },
                success: function(data) {

                }
            })
        })

        $("body").on('input', '#inputIdProduct', function(e) {
            e.preventDefault();
            let valIdProduct = $(this).val();
            $.ajax({
                url: "{{ route('imageproduct.store') }}",
                type: "POST",
                data: {
                    'checkNumberImage': valIdProduct,
                },
                success: function(data) {
                    if (data.status == 'errorCount') {
                        $('.errorIdProduct').text(data.mess).css('color', 'red');
                    } else {
                        $('.errorIdProduct').text("");
                    }
                }
            })
        })

        $("body").on("click", ".btn_delete_image", function(e) {
            e.preventDefault();
            let $removeData = $(this).parent().parent();
            console.log($removeData);
            $.ajax({
                url: $(this).attr("href"),
                type: "DELETE",
                success: function(data) {
                    if (data == 1) {
                        $removeData.remove();
                    }
                }
            })
        })


    })
</script>
@endsection