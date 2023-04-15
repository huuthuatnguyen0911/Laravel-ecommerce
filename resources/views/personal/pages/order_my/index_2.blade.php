@extends('personal/masterLayout')

@section('main_title')
Đơn hàng của tôi
@endsection

@section('active_page_main_order-my')
active
@endsection

@section('main_content_page')
<!-- section order -->

<!-- <section id="section-waiting-order" class=""> -->
    <div class="container">
        <div class="box_main_header text-center">
            <h2 class="change_light">Đơn hàng của tôi</h2>
        </div>
        <div class="box_main_content mb-5">
            <h3 class="change_light mb-5">Đang chờ nhận hàng...</h3>
            <div class="">
                <table class="table table-striped" id="product_table">
                    <thead>
                        <tr>
                            <!-- <th>NO</th> -->
                            <th class="change_light" style="color: #fff">Ảnh SP</th>
                            <th class="change_light" style="color: #fff">Tên SP</th>
                            <th class="change_light" style="color: #fff">Số lượng</th>
                            <th class="change_light" style="color: #fff">Giá</th>
                            <th class="change_light" style="color: #fff">Thành tiền</th>
                            <th class="change_light" style="color: #fff">Thanh toán</th>
                            <th class="change_light" style="color: #fff">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody ID="tableBodyOrder">

                        @foreach($dataOrderWattings as $dataOrderWatting)
                        @foreach($dataOrderWatting->getOrder as $item_product)
                        <tr class="category box_category_main" id="tr_box_order-{{$item_product->id}}">
                            <td class="change_light" style="color: #fff">
                                <a href="{{route('product.detailproduct',$item_product->od_product_id)}}">
                                    <div class="text-left">
                                        <img id="" src="{{asset($item_product->getMainImage->link_image)}}" style="height: 50px;" class="rounded" alt="img ">
                                    </div>
                                </a>
                            </td>
                            <td id=""><a class="change_light " style="color: #fff" href="{{route('product.detailproduct',$item_product->od_product_id)}}">{{$item_product->getProduct->product_name}}</a></td>
                            <td class="change_light" style="color: #fff" id="">{{$item_product->od_quantity}}</td>
                            <td class="change_light" style="color: #fff" id="" style="">{{number_format($item_product->od_price)}}</td>
                            <td class="" style="color: red" id="">{{number_format($item_product->od_price * $item_product->od_quantity)}}</td>
                            <td class="change_light " style="color: #fff" id="tt_pr_category_">
                                {{$dataOrderWatting->transactions_method}}
                            </td>
                            <td class="change_light" style="color: #fff">
                                @if($dataOrderWatting->transactions_status == 0)
                                <span class="badge badge-primary">Đang đợi xác nhận</span>
                                @elseif($dataOrderWatting->transactions_status == 1)
                                <span class="badge badge-warning">Đang giao hàng</span>
                                @else
                                <span class="badge badge-danger">Đã bị hủy</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

        <div class="box_main_content">
            <h3 class="change_light mb-5">Đã xử lý</h3>
            <div class="">
                <table class="table table-striped" id="product_table">
                    <thead>
                        <tr>
                            <!-- <th>NO</th> -->
                            <th class="change_light" style="color: #fff">Tên nhân viên</th>
                            <th class="change_light" style="color: #fff">Ảnh SP</th>
                            <th class="change_light" style="color: #fff">Tên SP</th>
                            <th class="change_light" style="color: #fff">Số lượng</th>
                            <th class="change_light" style="color: #fff">Giá</th>
                            <th class="change_light" style="color: #fff">Thành tiền</th>
                            <th class="change_light" style="color: #fff">Thanh toán</th>
                            <th class="change_light" style="color: #fff">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody ID="tableBodyOrder">
                        @foreach($dataTransports as $dataTransport)
                        @foreach ($dataTransport->getOrder as $item)
                        <tr class="category box_category_main" id="">
                            <td class="change_light" style="color: #fff" id="">{{$dataTransport->getStaff->name}}</td>
                            <td class="change_light" style="color: #fff">
                                <a href="{{route('product.detailproduct',$item->od_product_id)}}">
                                    <div class="text-left">
                                        <img id="" src="{{asset($item->getMainImage->link_image)}}" style="height: 50px;" class="rounded" alt="img ">
                                    </div>
                                </a>
                            </td>
                            <td id=""><a class="change_light " style="color: #fff" href="{{route('product.detailproduct',$item->od_product_id)}}">{{$item->getProduct->product_name}}</a></td>
                            <td class="change_light" style="color: #fff" id="">{{$item->od_quantity}}</td>
                            <td class="change_light" style="color: #fff" id="" style="">{{number_format($item->od_price)}}</td>
                            <td class="" style="color: red" id="">{{number_format($item->od_price * $item->od_quantity)}}</td>
                            <td class="change_light " style="color: #fff" id="tt_pr_category_">
                                {{$dataTransport->getTransaction->transactions_method}}
                            </td>
                            <td class="change_light" style="color: #fff">
                                @if($dataTransport->ts_status == 0)
                                <span class="badge badge-danger">Giao hàng thất bại</span>
                                @else
                                <span class="badge badge-success">Giao hàng thành công</span>
                                @endif
                            </td>
                            @endforeach
                            @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
<!-- </section> -->

@endsection

@section('main_js_page')
<script>
</script>
@endsection