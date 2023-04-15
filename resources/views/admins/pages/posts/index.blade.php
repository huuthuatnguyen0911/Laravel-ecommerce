@extends('admins/masterlayoutadmin')

@section('main_title')
Đơn hàng
@endsection

@section('status_avtive_nav_post')
active
@endsection

@section('status_activeShowDropdown_post')
activeShowDropdown
@endsection

@section('status_list_post_1')
active
@endsection

@section('style_page_main')
<style>
</style>
@endsection

@section('main_content')
<div class="container-fluid box_main_prostatus_avtive_nav_product">
    <div class="page-head mt-3">
        <div class="row container_full" style="justify-content: space-between; align-items: center;">
            <div class="col-md-6">
                <h4 class="mt-2 mb-2">Bài viết người dùng</h4>

            </div>
        </div>
    </div>

    <!-- Bảng quản lí bài viết -->
    <div class="edit-table mt-5">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3" style=" align-items: center; ">
                            <!-- <div class="col-md-4">
                                <h3 class="text-muted">Đơn chưa xác nhận</h3>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4 text-right ">
                                Button to Open the Modal add

                            </div> -->
                        </div>
                        <div class="">
                            <table class="table table-striped" id="table_posts">
                                <thead>
                                    <tr>
                                        <!-- <th>NO</th> -->
                                        <!-- <th>Duyệt</th> -->
                                        <th>Tác giả</th>
                                        <th>Bài viết</th>
                                        <th>Thể loại</th>
                                        <th>Thời gian</th>
                                        <th>Xử lý</th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodyPosts">
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
<script src="//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(function() {
            var table1 = $('#table_posts').DataTable({
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
                ajax: "{{ route('admin.post.index') }}",
                columns: [{
                        data: 'name_user',
                        name: 'name_user'
                    },
                    {
                        data: 'p_title',
                        name: 'p_title'
                    },
                    {
                        data: 'p_category',
                        name: 'p_category'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'p_action',
                        name: 'p_action'
                    },
                ],

            });
        });

    })
</script>
@endsection