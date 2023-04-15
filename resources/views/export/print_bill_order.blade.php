<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn thanh toán</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        * {
            font-family: DejaVu Sans !important;
        }

        p {
            margin: 0 !important;
        }
    </style>

</head>

<body>
    <div class="box_main_bill">
        <!-- <div class="container mt-5" style="width: 40%;"> -->
            <div class="box_header text-center">
                <h3><strong>SHOP SONGZIO</strong></h3>
                <p>470 Trần Đại Nghĩa, Ngũ Hành Sơn, Đà Nẵng</p>
                <p><strong>SĐT: </strong>0358559461</p>
                <hr style="border-top: 2px dashed; width: 30%;">
            </div>

            <div class="box_body mt-4 text-center">
                <h4><strong>HÓA ĐƠN THANH TOÁN</strong></h4>
                <div class="box_time_bill" >
                    <p style="margin: 0;"><strong>Ngày in</strong> {{Carbon\Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y')}} </p>
                    <p style="margin: 0;"><strong>Giờ in</strong> {{Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toTimeString()}}
                    </p>
                </div>
                <div class="box_infor_user text-left  mt-3">
                    <p><strong>Tên người nhận: </strong> {{$data->transactions_name}}</p>
                    <p><strong>Địa chỉ: </strong> {{$data->transactions_address}}</p>
                    <p><strong>Số điện thoại: </strong> {{$data->transactions_phone}}</p>
                    <p><strong>Email: </strong> {{$data->transactions_email}}</p>
                    <p><strong>Ngày đặt: </strong> {{$data->transactions_date}}</p>
                    <p><strong>Thanh toán: </strong> {{$data->transactions_method}}</p>
                </div>
                <table class="table table-sm mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">SL</th>
                            <th scope="col">Giá</th>
                            <th scope="col">T.tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->getOrder as $item)
                        <tr>
                            <th scope="row">{{$loop->index}}</th>
                            <td>
                                {{$item->getProduct->product_name}}
                            </td>
                            <td>{{$item->od_quantity}}</td>
                            <td>{{number_format($item->od_price)}}</td>
                            <td>{{number_format($item->od_price * $item->od_quantity)}}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <td colspan="2" class="text-left"><strong>Tổng tiền</strong></td>
                            <td colspan="3" class="text-right text-danger "><strong>{{number_format($data->transactions_price)}} VNĐ</strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="box_header mb-4" >
                    <h5 class="mr-3" style="margin: 0;"><strong>Thành tiền : </strong></h5>
                    <h5 class="text-danger" style="margin: 0;"><strong>{{number_format($data->transactions_price)}} VNĐ</strong></h5>
                </div>
                <hr style="border-top: 2px dashed; width: 100%;">
            </div>

            <div class="box_footer text-center">
                <p><strong>Cảm ơn quý khách - Hẹn gặp lại</strong></p>
            </div>

        <!-- </div> -->
    </div>
</body>

</html>