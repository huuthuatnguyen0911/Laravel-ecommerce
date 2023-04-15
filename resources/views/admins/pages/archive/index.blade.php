@extends('admins/masterlayoutadmin')

@section('main_title')
Kho
@endsection

@section('status_avtive_nav_archive')
active
@endsection

@section('status_activeShowDropdown_archive')
activeShowDropdown
@endsection

@section('status_list_archive_1')
active
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-head mt-5">
        <div class="row container_full" style="justify-content: space-between; align-items: center;">
            <div class="col-md-6">
                <h4 class="mt-2 mb-2">Kho sản phẩm</h4>
            </div>
            <div class="col-md-6 text-right">
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
                        <div class="">
                            <table class="table table-striped" id="archive_table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <!-- <th>NO</th> -->
                                        <th>ID kho</th>
                                        <th>ID sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá nhập</th>
                                        <th>Giá bán</th>
                                        <th>Tồn kho</th>
                                        <th>Hiển thị</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodyArchive">
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

    <!-- Modal -->
    <div class="modal fade" id="ModelEditArchive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa kho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('archive.store')}}" method="post" enctype="multipart/form-data" id="formEditArchive">
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
                            <label for="inputQuantityProduct" class="font-weight-bold">Tồn kho</label>
                            <input type="text" class="form-control" id="inputQuantityProduct" name="QuantityProduct" placeholder="VD: 20,10,100">
                            <span class="errorMessQuantityProduct"></span>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="switch1" id="checkswitch1">
                            <label class="custom-control-label" for="checkswitch1">Hiển thị sản phẩm</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary btnSaveArchive">Lưu</button>
                </div>
            </div>
        </div>

    </div>
    @endsection

    @section('javascript_page')
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

    <!-- <script src="{{asset('plugins/tinymce/tinymce.min.js')}}" type="text/javascript"></script> -->

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $(function() {
                var table = $('#archive_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('archive.listarchive') }}",
                    columns: [{
                        data: 'id_archive',
                        name: 'id_archive',
                    }, {
                        data: 'product_id',
                        name: 'product_id',
                    }, {
                        data: 'getProduct.product_name',
                        render: function(data, type, row, meta) {
                            var details = "";
                            for (var item in row.get_product) {
                                details = row.get_product.product_name;
                            }
                            return details;
                        },
                    }, {
                        data: 'import_price',
                        name: 'import_price',
                    }, {
                        data: 'price',
                        name: 'price',
                    }, {
                        data: 'quantity',
                        name: 'quantity',
                    }, {
                        data: 'deploy',
                        name: 'deploy',
                    }, {
                        data: 'action',
                        name: 'action',
                    }],

                });

                $("body").on('click', '.btnSaveArchive', function(e) {
                    e.preventDefault();
                    let dataForm = $("#formEditArchive").serialize();
                    let urldata = $('#formEditArchive').attr('action');
                    $.ajax({
                        url: urldata,
                        type: 'POST',
                        data: dataForm,
                        success: function(data) {
                            if (data.status == "successEditArchive") {
                                $(".alert-success .text_msg").text(data.message);
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
                                $('#archive_table').DataTable().ajax.reload();
                            }
                            if (data.status == 'errorEditArchive') {
                                $(".alert-danger .text_msg").text("data.message");
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
                        }
                    })
                })

            });

            $("body").on('click', '.btn_edit_archive', function(e) {
                e.preventDefault();

                let $url = $(this).attr('href');
                $('#ModelEditArchive').modal('toggle')
                $.ajax({
                    url: $url,
                    type: 'GET',
                    success: function(data) {
                        console.log(data)
                        $("#inputIDProduct").val(data.get_product.product_id);
                        $("#inputIDArchives").val(data.id_archive);
                        $("#inputPriceImport").val(number_format(Number(data.import_price)));
                        $("#inputPriceProduct").val(number_format(Number(data.price)));
                        $("#inputQuantityProduct").val(data.quantity);
                        if (data.deploy == 1) {
                            $("#checkswitch1").attr('checked', true);
                        }
                        $("#inputNameProduct").val(data.get_product.product_name);
                    },
                })
            })


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
    </script>
    @endsection