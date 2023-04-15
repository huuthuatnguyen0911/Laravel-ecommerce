@extends('admins/masterlayoutadmin')

@section('main_title')
Chi tiết đơn hàng
@endsection

<!-- @section('status_avtive_nav_order')
active
@endsection

@section('status_activeShowDropdown_order')
activeShowDropdown
@endsection

@section('status_list_order_0')
active
@endsection -->

@section('style_page_main')
<style>
</style>
@endsection

@section('main_content')
<div class="container mt-5 mb-5">
    <h3 class="text-center">Thông tin đơn hàng</h3>

    <div class="infor_user_order mt-5">
        <div class="box_header mb-4">
            <h3>Thông tin người đặt hàng</h3>
        </div>
        <div class="row text-left">
            <div class="col-md-6">
                <div class="box_show_infor box_infor_user">
                    <p class="row_infor">
                        <strong>Tên người đặt:</strong>
                        {{$data->getUser->name}}
                    </p>
                    <p class="row_infor">
                        <strong>Email:</strong>
                        {{$data->getUser->email}}
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box_show_infor box_infor_receiver">
                    <p class="row_infor">
                        <strong>Tên người nhận:</strong>
                        {{$data->transactions_name}}
                    </p>
                    <p class="row_infor">
                        <strong>Số điện thoại:</strong>
                        {{$data->transactions_phone}}
                    </p>
                    <p class="row_infor">
                        <strong>Email:</strong>
                        {{$data->transactions_email}}
                    </p>
                    <p class="row_infor">
                        <strong>Địa chỉ:</strong>
                        {{$data->transactions_address}}
                    </p>
                    <p class="row_infor">
                        <strong>Ghi chú:</strong>
                        {{$data->transactions_note}}
                    </p>
                    <p class="row_infor">
                        <strong>Thanh toán:</strong>
                        {{$data->transactions_method}}
                    </p>
                    <p class="row_infor">
                        <strong>Tổng tiền:</strong>
                        {{number_format($data->transactions_price)}} VNĐ
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="box_table_show_product_order mt-3 mb-3">
        <div class="box_header mb-4">
            <h3>Thông tin sản phẩm</h3>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->getOrder as $item)
                <tr>
                    <th scope="row">{{$loop->index}}</th>
                    <td>
                        <img src="{{asset($item->getMainImage->link_image)}}" alt="" style="height: 50px; object-fit: cover;" class="rounded float-left">;
                    </td>
                    <td>
                        <a href="{{route('product.detailproduct',$item->od_product_id)}}">
                            {{$item->getProduct->product_name}}
                        </a>
                    </td>
                    <td>{{$item->od_quantity}}</td>
                    <td>{{number_format($item->od_price)}}</td>
                    <td>{{number_format($item->od_price * $item->od_quantity)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="box_total_price">
        <div class="box_header mb-4" style="display: flex; align-items: center; ">
            <h4 class="mr-3" style="margin: 0;"><strong>Thành tiền : </strong></h4>
            <h5 class="text-danger" style="margin: 0;">{{number_format($data->transactions_price)}} VNĐ</h5>
        </div>
    </div>

    <div class="box_button_handle" style="display: flex; align-items: center; justify-content: space-between;">
        <div class="btn_back">
            <a href="{{route('order.index.new')}}" type="button" class="btn btn-primary">
                Trở lại
            </a>
        </div>
        <div class="btn_export">
            <a href="{{route('order.export.bill',$data->id)}}" class="btn btn-warning">
                In hóa đơn
            </a>
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
    })
</script>
@endsection