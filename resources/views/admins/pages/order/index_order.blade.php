@extends('admins/masterlayoutadmin')

@section('main_title')
Đơn hàng
@endsection

@section('status_avtive_nav_order')
active
@endsection

@section('status_activeShowDropdown_order')
activeShowDropdown
@endsection

@section('status_list_order_0')
active
@endsection

@section('style_page_main')
<style>
</style>
@endsection

@section('main_content')
<div class="container-fluid box_main_prostatus_avtive_nav_product">
    <div class="page-head mt-5">
        <div class="row container_full" style="justify-content: space-between; align-items: center;">
            <div class="col-md-6">
                <h4 class="mt-2 mb-2">Đơn đặt hàng</h4>

            </div>
        </div>
    </div>

    <!-- đơn chưa xác nhận -->
    <div class="edit-table mt-5">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3" style=" align-items: center; ">
                            <div class="col-md-4">
                                <h3 class="text-muted">Đơn chưa xác nhận</h3>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4 text-right ">
                                <!-- Button to Open the Modal add -->

                            </div>
                        </div>
                        <div class="">
                            <table class="table table-striped" id="order_not_confirm_table">
                                <thead>
                                    <tr>
                                        <!-- <th>NO</th> -->
                                        <th>Người đặt</th>
                                        <th>Người nhận</th>
                                        <th>SĐT</th>
                                        <th>Thành tiền</th>
                                        <th>Email</th>
                                        <th>Note</th>
                                        <th>Ngày đặt</th>
                                        <th>Số lượng</th>
                                        <th>Xử lý</th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodyOrder">
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

    <!-- đơn vận chuyển -->
    <div class="edit-table mt-5">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3" style=" align-items: center; ">
                            <div class="col-md-4">
                                <h3 class="text-muted">Vận chuyển</h3>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4 text-right ">
                                <!-- Button to Open the Modal add -->

                            </div>
                        </div>
                        <div class="">
                            <table class="table table-striped" id="transport_table">
                                <thead>
                                    <tr>
                                        <!-- <th>NO</th> -->
                                        <th>Người nhận</th>
                                        <th>Địa chỉ</th>
                                        <th>SĐT</th>
                                        <th>Email</th>
                                        <th>Note</th>
                                        <th>Thanh toán</th>
                                        <th>Thành tiền</th>
                                        <th>Xử lý</th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodyOrder">
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

    <!-- đơn đã giao -->
    <div class="edit-table mt-5">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3" style=" align-items: center; ">
                            <div class="col-md-4">
                                <h3 class="text-muted">Đã giao</h3>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4 text-right ">
                                <!-- Button to Open the Modal add -->

                            </div>
                        </div>
                        <div class="">
                            <table class="table table-striped" id="delivered_table">
                                <thead>
                                    <tr>
                                        <!-- <th>NO</th> -->
                                        <th>Người giao</th>
                                        <th>Người nhận</th>
                                        <th>Địa chỉ</th>
                                        <th>SĐT</th>
                                        <th>Email</th>
                                        <th>Thành tiền</th>
                                        <th>Ngày giao</th>
                                        <th>Trạng thái</th>
                                        <th>Xử lý</th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodyOrder">
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
    <div class="modal fade" id="modalCancellation" tabindex="-1" role="dialog" aria-labelledby="1`" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" id="formCancellation">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Lý do hủy đơn</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idProductOrder" name="idProductOrder" value="">
                        <input type="hidden" id="idUser" name="idUser" value="">
                        <input type="hidden" id="idOrder" name="idOrder" value="">
                        <input type="hidden" id="linkImage" name="linkImage" value="">
                        <input type="hidden" id="codeMessage" name="codeMessage" value="">
                        <input type="hidden" id="name_product" name="name_product" value="">
                        <div class="form-group">
                            <input type="text" class="form-control" name="messageCancel" id="inputMessage" placeholder="Nhập lý do hủy đơn ...">
                            <span id="errorInputMessage"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('javascript_page')

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(function() {
            var table1 = $('#order_not_confirm_table').DataTable({
                "language": {
                    "processing": "Đang xử lý...",
                    "infoFiltered": "(được lọc từ _MAX_ mục)",
                    "aria": {
                        "sortAscending": ": Sắp xếp thứ tự tăng dần",
                        "sortDescending": ": Sắp xếp thứ tự giảm dần"
                    },
                    "autoFill": {
                        "cancel": "Hủy",
                        "fill": "Điền tất cả ô với <i>%d<\/i>",
                        "fillHorizontal": "Điền theo hàng ngang",
                        "fillVertical": "Điền theo hàng dọc"
                    },
                    "buttons": {
                        "collection": "Chọn lọc <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                        "colvis": "Hiển thị theo cột",
                        "colvisRestore": "Khôi phục hiển thị",
                        "copy": "Sao chép",
                        "copyKeys": "Nhấn Ctrl hoặc u2318 + C để sao chép bảng dữ liệu vào clipboard.<br \/><br \/>Để hủy, click vào thông báo này hoặc nhấn ESC",
                        "copySuccess": {
                            "1": "Đã sao chép 1 dòng dữ liệu vào clipboard",
                            "_": "Đã sao chép %d dòng vào clipboard"
                        },
                        "copyTitle": "Sao chép vào clipboard",
                        "csv": "File CSV",
                        "excel": "File Excel",
                        "pageLength": {
                            "-1": "Xem tất cả các dòng",
                            "_": "Hiển thị %d dòng"
                        },
                        "pdf": "File PDF",
                        "print": "In ấn"
                    },
                    "infoThousands": "`",
                    "select": {
                        "cells": {
                            "1": "1 ô đang được chọn",
                            "_": "%d ô đang được chọn"
                        },
                        "columns": {
                            "1": "1 cột đang được chọn",
                            "_": "%d cột đang được được chọn"
                        },
                        "rows": {
                            "1": "1 dòng đang được chọn",
                            "_": "%d dòng đang được chọn"
                        }
                    },
                    "thousands": "`",
                    "searchBuilder": {
                        "title": {
                            "_": "Thiết lập tìm kiếm (%d)",
                            "0": "Thiết lập tìm kiếm"
                        },
                        "button": {
                            "0": "Thiết lập tìm kiếm",
                            "_": "Thiết lập tìm kiếm (%d)"
                        },
                        "value": "Giá trị",
                        "clearAll": "Xóa hết",
                        "condition": "Điều kiện",
                        "conditions": {
                            "date": {
                                "after": "Sau",
                                "before": "Trước",
                                "between": "Nằm giữa",
                                "empty": "Rỗng",
                                "equals": "Bằng với",
                                "not": "Không phải",
                                "notBetween": "Không nằm giữa",
                                "notEmpty": "Không rỗng"
                            },
                            "number": {
                                "between": "Nằm giữa",
                                "empty": "Rỗng",
                                "equals": "Bằng với",
                                "gt": "Lớn hơn",
                                "gte": "Lớn hơn hoặc bằng",
                                "lt": "Nhỏ hơn",
                                "lte": "Nhỏ hơn hoặc bằng",
                                "not": "Không phải",
                                "notBetween": "Không nằm giữa",
                                "notEmpty": "Không rỗng"
                            },
                            "string": {
                                "contains": "Chứa",
                                "empty": "Rỗng",
                                "endsWith": "Kết thúc bằng",
                                "equals": "Bằng",
                                "not": "Không phải",
                                "notEmpty": "Không rỗng",
                                "startsWith": "Bắt đầu với"
                            },
                            "array": {
                                "equals": "Bằng",
                                "empty": "Trống",
                                "contains": "Chứa",
                                "not": "Không",
                                "notEmpty": "Không được rỗng",
                                "without": "không chứa"
                            }
                        },
                        "logicAnd": "Và",
                        "logicOr": "Hoặc",
                        "add": "Thêm điều kiện",
                        "data": "Dữ liệu",
                        "deleteTitle": "Xóa quy tắc lọc"
                    },
                    "searchPanes": {
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Không có phần tìm kiếm",
                        "clearMessage": "Xóa hết",
                        "loadMessage": "Đang load phần tìm kiếm",
                        "collapse": {
                            "0": "Phần tìm kiếm",
                            "_": "Phần tìm kiếm (%d)"
                        },
                        "title": "Bộ lọc đang hoạt động - %d",
                        "count": "{total}"
                    },
                    "datetime": {
                        "hours": "Giờ",
                        "minutes": "Phút",
                        "next": "Sau",
                        "previous": "Trước",
                        "seconds": "Giây"
                    },
                    "emptyTable": "Không có dữ liệu",
                    "info": "Hiển thị _START_ tới _END_ của _TOTAL_ dữ liệu",
                    "infoEmpty": "Hiển thị 0 tới 0 của 0 dữ liệu",
                    "lengthMenu": "Hiển thị _MENU_ dữ liệu",
                    "loadingRecords": "Đang tải...",
                    "paginate": {
                        "first": "Đầu tiên",
                        "last": "Cuối cùng",
                        "next": "Sau",
                        "previous": "Trước"
                    },
                    "search": "Tìm kiếm:",
                    "zeroRecords": "Không tìm thấy kết quả",
                    "searchPlaceholder": "Tìm kiếm"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('order.index.new') }}",
                columns: [{
                        data: 'transactions_user_order',
                        name: 'transactions_user_order'
                    },
                    {
                        data: 'transactions_name',
                        name: 'transactions_name'
                    },
                    {
                        data: 'transactions_phone',
                        name: 'transactions_phone'
                    },
                    {
                        data: 'transactions_price',
                        name: 'transactions_price'
                    },
                    {
                        data: 'transactions_email',
                        name: 'transactions_email'
                    },
                    {
                        data: 'transactions_note',
                        name: 'transactions_note'
                    },
                    {
                        data: 'transactions_date',
                        name: 'transactions_date'
                    },
                    {
                        data: 'transactions_total_order',
                        name: 'transactions_total_order'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    },
                ],

            });

            var table2 = $('#transport_table').DataTable({
                "language": {
                    "processing": "Đang xử lý...",
                    "infoFiltered": "(được lọc từ _MAX_ mục)",
                    "aria": {
                        "sortAscending": ": Sắp xếp thứ tự tăng dần",
                        "sortDescending": ": Sắp xếp thứ tự giảm dần"
                    },
                    "autoFill": {
                        "cancel": "Hủy",
                        "fill": "Điền tất cả ô với <i>%d<\/i>",
                        "fillHorizontal": "Điền theo hàng ngang",
                        "fillVertical": "Điền theo hàng dọc"
                    },
                    "buttons": {
                        "collection": "Chọn lọc <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                        "colvis": "Hiển thị theo cột",
                        "colvisRestore": "Khôi phục hiển thị",
                        "copy": "Sao chép",
                        "copyKeys": "Nhấn Ctrl hoặc u2318 + C để sao chép bảng dữ liệu vào clipboard.<br \/><br \/>Để hủy, click vào thông báo này hoặc nhấn ESC",
                        "copySuccess": {
                            "1": "Đã sao chép 1 dòng dữ liệu vào clipboard",
                            "_": "Đã sao chép %d dòng vào clipboard"
                        },
                        "copyTitle": "Sao chép vào clipboard",
                        "csv": "File CSV",
                        "excel": "File Excel",
                        "pageLength": {
                            "-1": "Xem tất cả các dòng",
                            "_": "Hiển thị %d dòng"
                        },
                        "pdf": "File PDF",
                        "print": "In ấn"
                    },
                    "infoThousands": "`",
                    "select": {
                        "cells": {
                            "1": "1 ô đang được chọn",
                            "_": "%d ô đang được chọn"
                        },
                        "columns": {
                            "1": "1 cột đang được chọn",
                            "_": "%d cột đang được được chọn"
                        },
                        "rows": {
                            "1": "1 dòng đang được chọn",
                            "_": "%d dòng đang được chọn"
                        }
                    },
                    "thousands": "`",
                    "searchBuilder": {
                        "title": {
                            "_": "Thiết lập tìm kiếm (%d)",
                            "0": "Thiết lập tìm kiếm"
                        },
                        "button": {
                            "0": "Thiết lập tìm kiếm",
                            "_": "Thiết lập tìm kiếm (%d)"
                        },
                        "value": "Giá trị",
                        "clearAll": "Xóa hết",
                        "condition": "Điều kiện",
                        "conditions": {
                            "date": {
                                "after": "Sau",
                                "before": "Trước",
                                "between": "Nằm giữa",
                                "empty": "Rỗng",
                                "equals": "Bằng với",
                                "not": "Không phải",
                                "notBetween": "Không nằm giữa",
                                "notEmpty": "Không rỗng"
                            },
                            "number": {
                                "between": "Nằm giữa",
                                "empty": "Rỗng",
                                "equals": "Bằng với",
                                "gt": "Lớn hơn",
                                "gte": "Lớn hơn hoặc bằng",
                                "lt": "Nhỏ hơn",
                                "lte": "Nhỏ hơn hoặc bằng",
                                "not": "Không phải",
                                "notBetween": "Không nằm giữa",
                                "notEmpty": "Không rỗng"
                            },
                            "string": {
                                "contains": "Chứa",
                                "empty": "Rỗng",
                                "endsWith": "Kết thúc bằng",
                                "equals": "Bằng",
                                "not": "Không phải",
                                "notEmpty": "Không rỗng",
                                "startsWith": "Bắt đầu với"
                            },
                            "array": {
                                "equals": "Bằng",
                                "empty": "Trống",
                                "contains": "Chứa",
                                "not": "Không",
                                "notEmpty": "Không được rỗng",
                                "without": "không chứa"
                            }
                        },
                        "logicAnd": "Và",
                        "logicOr": "Hoặc",
                        "add": "Thêm điều kiện",
                        "data": "Dữ liệu",
                        "deleteTitle": "Xóa quy tắc lọc"
                    },
                    "searchPanes": {
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Không có phần tìm kiếm",
                        "clearMessage": "Xóa hết",
                        "loadMessage": "Đang load phần tìm kiếm",
                        "collapse": {
                            "0": "Phần tìm kiếm",
                            "_": "Phần tìm kiếm (%d)"
                        },
                        "title": "Bộ lọc đang hoạt động - %d",
                        "count": "{total}"
                    },
                    "datetime": {
                        "hours": "Giờ",
                        "minutes": "Phút",
                        "next": "Sau",
                        "previous": "Trước",
                        "seconds": "Giây"
                    },
                    "emptyTable": "Không có dữ liệu",
                    "info": "Hiển thị _START_ tới _END_ của _TOTAL_ dữ liệu",
                    "infoEmpty": "Hiển thị 0 tới 0 của 0 dữ liệu",
                    "lengthMenu": "Hiển thị _MENU_ dữ liệu",
                    "loadingRecords": "Đang tải...",
                    "paginate": {
                        "first": "Đầu tiên",
                        "last": "Cuối cùng",
                        "next": "Sau",
                        "previous": "Trước"
                    },
                    "search": "Tìm kiếm:",
                    "zeroRecords": "Không tìm thấy kết quả",
                    "searchPlaceholder": "Tìm kiếm"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('order.transport.index') }}",
                columns: [{
                        data: 'transactions_name',
                        name: 'transactions_name'
                    },
                    {
                        data: 'transactions_address',
                        name: 'transactions_address'
                    },
                    {
                        data: 'transactions_phone',
                        name: 'transactions_phone'
                    },
                    {
                        data: 'transactions_email',
                        name: 'transactions_email'
                    },
                    {
                        data: 'transactions_note',
                        name: 'transactions_note'
                    },
                    {
                        data: 'transactions_method',
                        name: 'transactions_method'
                    },
                    {
                        data: 'transactions_price',
                        name: 'transactions_price'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    },
                ],

            });

            var table3 = $('#delivered_table').DataTable({
                "language": {
                    "processing": "Đang xử lý...",
                    "infoFiltered": "(được lọc từ _MAX_ mục)",
                    "aria": {
                        "sortAscending": ": Sắp xếp thứ tự tăng dần",
                        "sortDescending": ": Sắp xếp thứ tự giảm dần"
                    },
                    "autoFill": {
                        "cancel": "Hủy",
                        "fill": "Điền tất cả ô với <i>%d<\/i>",
                        "fillHorizontal": "Điền theo hàng ngang",
                        "fillVertical": "Điền theo hàng dọc"
                    },
                    "buttons": {
                        "collection": "Chọn lọc <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                        "colvis": "Hiển thị theo cột",
                        "colvisRestore": "Khôi phục hiển thị",
                        "copy": "Sao chép",
                        "copyKeys": "Nhấn Ctrl hoặc u2318 + C để sao chép bảng dữ liệu vào clipboard.<br \/><br \/>Để hủy, click vào thông báo này hoặc nhấn ESC",
                        "copySuccess": {
                            "1": "Đã sao chép 1 dòng dữ liệu vào clipboard",
                            "_": "Đã sao chép %d dòng vào clipboard"
                        },
                        "copyTitle": "Sao chép vào clipboard",
                        "csv": "File CSV",
                        "excel": "File Excel",
                        "pageLength": {
                            "-1": "Xem tất cả các dòng",
                            "_": "Hiển thị %d dòng"
                        },
                        "pdf": "File PDF",
                        "print": "In ấn"
                    },
                    "infoThousands": "`",
                    "select": {
                        "cells": {
                            "1": "1 ô đang được chọn",
                            "_": "%d ô đang được chọn"
                        },
                        "columns": {
                            "1": "1 cột đang được chọn",
                            "_": "%d cột đang được được chọn"
                        },
                        "rows": {
                            "1": "1 dòng đang được chọn",
                            "_": "%d dòng đang được chọn"
                        }
                    },
                    "thousands": "`",
                    "searchBuilder": {
                        "title": {
                            "_": "Thiết lập tìm kiếm (%d)",
                            "0": "Thiết lập tìm kiếm"
                        },
                        "button": {
                            "0": "Thiết lập tìm kiếm",
                            "_": "Thiết lập tìm kiếm (%d)"
                        },
                        "value": "Giá trị",
                        "clearAll": "Xóa hết",
                        "condition": "Điều kiện",
                        "conditions": {
                            "date": {
                                "after": "Sau",
                                "before": "Trước",
                                "between": "Nằm giữa",
                                "empty": "Rỗng",
                                "equals": "Bằng với",
                                "not": "Không phải",
                                "notBetween": "Không nằm giữa",
                                "notEmpty": "Không rỗng"
                            },
                            "number": {
                                "between": "Nằm giữa",
                                "empty": "Rỗng",
                                "equals": "Bằng với",
                                "gt": "Lớn hơn",
                                "gte": "Lớn hơn hoặc bằng",
                                "lt": "Nhỏ hơn",
                                "lte": "Nhỏ hơn hoặc bằng",
                                "not": "Không phải",
                                "notBetween": "Không nằm giữa",
                                "notEmpty": "Không rỗng"
                            },
                            "string": {
                                "contains": "Chứa",
                                "empty": "Rỗng",
                                "endsWith": "Kết thúc bằng",
                                "equals": "Bằng",
                                "not": "Không phải",
                                "notEmpty": "Không rỗng",
                                "startsWith": "Bắt đầu với"
                            },
                            "array": {
                                "equals": "Bằng",
                                "empty": "Trống",
                                "contains": "Chứa",
                                "not": "Không",
                                "notEmpty": "Không được rỗng",
                                "without": "không chứa"
                            }
                        },
                        "logicAnd": "Và",
                        "logicOr": "Hoặc",
                        "add": "Thêm điều kiện",
                        "data": "Dữ liệu",
                        "deleteTitle": "Xóa quy tắc lọc"
                    },
                    "searchPanes": {
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Không có phần tìm kiếm",
                        "clearMessage": "Xóa hết",
                        "loadMessage": "Đang load phần tìm kiếm",
                        "collapse": {
                            "0": "Phần tìm kiếm",
                            "_": "Phần tìm kiếm (%d)"
                        },
                        "title": "Bộ lọc đang hoạt động - %d",
                        "count": "{total}"
                    },
                    "datetime": {
                        "hours": "Giờ",
                        "minutes": "Phút",
                        "next": "Sau",
                        "previous": "Trước",
                        "seconds": "Giây"
                    },
                    "emptyTable": "Không có dữ liệu",
                    "info": "Hiển thị _START_ tới _END_ của _TOTAL_ dữ liệu",
                    "infoEmpty": "Hiển thị 0 tới 0 của 0 dữ liệu",
                    "lengthMenu": "Hiển thị _MENU_ dữ liệu",
                    "loadingRecords": "Đang tải...",
                    "paginate": {
                        "first": "Đầu tiên",
                        "last": "Cuối cùng",
                        "next": "Sau",
                        "previous": "Trước"
                    },
                    "search": "Tìm kiếm:",
                    "zeroRecords": "Không tìm thấy kết quả",
                    "searchPlaceholder": "Tìm kiếm"
                },
                processing: true,
                serverSide: true,
                "order": [
                    [6, "desc"]
                ],
                ajax: "{{ route('order.transport.delivered') }}",
                columns: [{
                        data: 'ts_name_staff',
                        name: 'ts_name_staff'
                    },
                    {
                        data: 'ts_name_order',
                        name: 'ts_name_order'
                    },
                    {
                        data: 'ts_address',
                        name: 'ts_address'
                    },
                    {
                        data: 'ts_phone',
                        name: 'ts_phone'
                    },
                    {
                        data: 'ts_email',
                        name: 'ts_email'
                    },
                    {
                        data: 'ts_total_price',
                        name: 'ts_total_price'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'ts_status',
                        name: 'ts_status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],

            });

        });

        // xác nhận đơn hàng
        $('#order_not_confirm_table').on('click', '.btn_confirm_order', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    statusCode: '123',
                },
                success: (data) => {
                    if (data == 1) {
                        $('#order_not_confirm_table').DataTable().ajax.reload();
                        $('#transport_table').DataTable().ajax.reload();
                    }
                }
            })
        })

        // hủy xác nhận đơn hàng
        $('#order_not_confirm_table').on('click', '.btn_no_confirm_order', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    statusCode: '345',
                },
                success: (data) => {
                    if (data == 1) {
                        $('#order_not_confirm_table').DataTable().ajax.reload();
                    }
                }
            })
        })

        // xac nhận vận chuyển
        $('#transport_table').on('click', '.btn_transport', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');
            let idStaff = '{{Auth::check() ? Auth::user()->id : "" }}';

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    statusCode: 'tp_123',
                    idStaff,
                },
                success: (data) => {
                    if (data == 1) {
                        $('#transport_table').DataTable().ajax.reload();
                        $('#delivered_table').DataTable().ajax.reload();
                    }
                }
            })

        })

        // giao không không thành công
        $('#transport_table').on('click', '.btn_no_transport', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');
            let idStaff = '{{Auth::check() ? Auth::user()->id : "" }}';

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    statusCode: 'tp_345',
                    idStaff,
                },
                success: (data) => {
                    if (data == 1) {
                        $('#transport_table').DataTable().ajax.reload();
                        $('#delivered_table').DataTable().ajax.reload();
                    }
                }
            })

        })

    })
</script>
@endsection