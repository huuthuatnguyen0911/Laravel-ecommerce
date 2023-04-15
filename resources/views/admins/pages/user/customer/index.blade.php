@extends('admins/masterlayoutadmin')

@section('main_title')
Đơn hàng
@endsection

@section('status_avtive_nav_user')
active
@endsection

@section('status_activeShowDropdown_user')
activeShowDropdown
@endsection

@section('status_list_user_1')
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
                <h4 class="mt-2 mb-2">Quản lí Khách hàng</h4>

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
                            <!-- <div class="col-md-4">
                                <h3 class="text-muted">Đơn chưa xác nhận</h3>
                            </div> -->
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4 text-right ">
                                <!-- Button to Open the Modal add -->

                            </div>
                        </div>
                        <div class="">
                            <table class="table table-striped" id="tableCustomerInfor">
                                <thead>
                                    <tr>
                                        <!-- <th>NO</th> -->
                                        <th>Ảnh</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>SĐT</th>
                                        <th>Đơn hàng</th>
                                        <th>Bài viết</th>
                                        <th>Ngày Tạo</th>
                                        <th>Xử lý</th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodyCustomer">
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

            let table1 = $('#tableCustomerInfor').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.customer.index') }}",
                columns: [{
                        data: 'avatar',
                        name: 'avatar'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'countOrder',
                        name: 'countOrder'
                    },
                    {
                        data: 'posts',
                        name: 'posts'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });

            // $('#tableStaffInfor').on('click', '.btn_delete_staff' ,function (e) {
            //     e.preventDefault();
            //     let url = $(this).attr('href');
            //     console.log(url);
            // })

        })
    </script>
    @endsection