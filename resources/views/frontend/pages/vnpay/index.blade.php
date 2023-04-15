@extends('frontend/masterLayout')

@section('main_title')
Xác nhận thanh toán online
@endsection

@section('head_main_page')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta -name="author" content="">
@endsection

@section('main_style_page')
<style>
    .with_full_width {
        max-width: 100%;
        width: 100%;
    }
</style>
@endsection

@section('main_content')
<div class="container" style="max-width: 550px;">
    <div class="header clearfix">
        <h3 class="text-muted text-center">Xác nhận thanh toán online</h3>
    </div>
    <!-- <h3>Tạo mới đơn hàng</h3> -->
    <div class="table-responsive">
        <form action="{{route('payment.online')}}" id="create_form" method="post" class="">
            @csrf
            <div class="form-group">
                <label for="language">Loại hàng hóa </label>
                <select name="order_type" id="order_type" class="form-control with_full_width">
                    <!-- <option value="topup">Nạp tiền điện thoại</option> -->
                    <option value="billpayment">Thanh toán hóa đơn</option>
                    <!-- <option value="fashion">Thời trang</option> -->
                    <!-- <option value="other">Khác - Xem thêm tại VNPAY</option> -->
                </select>
            </div>
            <div class="form-group">
                <label for="order_id">Mã giao dịch</label>
                <input class="form-control" id="order_id" name="order_id" type="text" value="<?php echo date("YmdHis") ?>" />
            </div>
            <div class="form-group">
                <label for="amount">Số tiền</label>
                <input class="form-control" id="amount" name="amount" type="number" value="{{$totalPrice}}" />
            </div>
            <div class="form-group">
                <label for="order_desc">Nội dung thanh toán</label>
                <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2">Noi dung thanh toan</textarea>
            </div>
            <div class="form-group">
                <label for="bank_code">Ngân hàng</label>
                <select name="bank_code" id="bank_code" class="form-control with_full_width">
                    <option value="">Không chọn</option>
                    <option value="NCB"> Ngan hang NCB</option>
                    <option value="AGRIBANK"> Ngan hang Agribank</option>
                    <option value="SCB"> Ngan hang SCB</option>
                    <option value="SACOMBANK">Ngan hang SacomBank</option>
                    <option value="EXIMBANK"> Ngan hang EximBank</option>
                    <option value="MSBANK"> Ngan hang MSBANK</option>
                    <option value="NAMABANK"> Ngan hang NamABank</option>
                    <option value="VNMART"> Vi dien tu VnMart</option>
                    <option value="VIETINBANK">Ngan hang Vietinbank</option>
                    <option value="VIETCOMBANK"> Ngan hang VCB</option>
                    <option value="HDBANK">Ngan hang HDBank</option>
                    <option value="DONGABANK"> Ngan hang Dong A</option>
                    <option value="TPBANK"> Ngân hàng TPBank</option>
                    <option value="OJB"> Ngân hàng OceanBank</option>
                    <option value="BIDV"> Ngân hàng BIDV</option>
                    <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                    <option value="VPBANK"> Ngan hang VPBank</option>
                    <option value="MBBANK"> Ngan hang MBBank</option>
                    <option value="ACB"> Ngan hang ACB</option>
                    <option value="OCB"> Ngan hang OCB</option>
                    <option value="IVB"> Ngan hang IVB</option>
                    <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                </select>
            </div>
            <div class="form-group">
                <label for="language">Ngôn ngữ</label>
                <select name="language" id="language" class="form-control with_full_width">
                    <option value="vn">Tiếng Việt</option>
                    <option value="en">English</option>
                </select>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Xác nhận thanh toán</button>
                <button type="button" class="btn btn-warning" onclick="history.back()">Trở lại</button>
            </div>

        </form>
    </div>
    <p>
        &nbsp;
    </p>
    <!-- <footer class="footer">
        <p>&copy; VNPAY <?php echo date('Y') ?></p>
    </footer> -->
</div>
@endsection

@section('javascript_page')
<script>

</script>
@endsection