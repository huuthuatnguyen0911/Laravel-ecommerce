@extends('frontend/masterLayout')

@section('main_title')
Giỏ hàng
@endsection

@section('main_style_page')
<style>
    .cart-table .table thead tr.header_table {
        background-color: #f34f3f;
    }

    .cart-table .table thead tr th {
        color: #fff;
    }

    #modalAddCompare .modal-body #navListProducts>li {
        margin: 10px 0;
        cursor: pointer;
        transition: 0.5s;
    }

    #modalAddCompare .modal-body #navListProducts>li:hover {
        background-color: #f2f2f2;
    }

    #modalAddCompare .modal-body #boxMainShowListProdut {}

    #modalAddCompare .modal-body .boxMainImageListproduct {
        width: 100%;
        height: 100%;
    }

    #modalAddCompare .modal-body .imgModalSearch {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #modalAddCompare .modal-body .box_main_content_modal h4 {
        margin: 0;
    }

    #modalAddCompare .modal-body .box_main_content_modal .description {
        margin: 0;
        overflow-wrap: break-word;
        font-size: 14px
    }
</style>
@endsection

@section('main_content')

<!-- wishlist header start -->
<div class="wishlist_header text-center pb-5 pt-5">
    <h1 class="text-uppercase" style="margin: 0; color: #f34f3f; "> Giỏ hàng của tôi </h1>
</div>
<!-- wishlist header end -->

<!-- cart start -->
<div class="cart-page pb-5">
    <div class="container">
        <div class="cart-table mb-4">
            <table class="table ">
                <thead>
                    <tr class="header_table">
                        <th class="">
                            <label style="display: flex; align-items: center; justify-content: center;" class="font-weight-bold">
                                <input type="checkbox" class="mr-2" id="checkAll" />
                                Tất cả
                            </label>
                        </th>
                        <th class="image font-weight-bold">Ảnh</th>
                        <th class="product font-weight-bold">Tên sản phẩm</th>
                        <th class="price font-weight-bold">Giá</th>
                        <th class="quantity font-weight-bold">Số lượng</th>
                        <th class="quantity font-weight-bold">Thành tiền</th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody id="row_Cart">
                    @foreach($dataCats as $dataCat)
                    <tr>
                        <!-- Thông tin cart -->
                        <input type="hidden" id="quantity_{{$dataCat->id}}" value="{{$dataCat->quantity}}">
                        <input type="hidden" id="price_{{$dataCat->id}}" value="{{$dataCat->getProduct->getArchivePrice->price}}">
                        <input type="hidden" id="totalPrice_{{$dataCat->id}}" value="{{$dataCat->getProduct->getArchivePrice->price * $dataCat->quantity}}">

                        <td>
                            <input type="checkbox" class="check_item" id="" value="{{$dataCat->id}}" />
                        </td>
                        <td class="image">
                            <img src="{{asset($dataCat->getProduct->getMainImage->link_image)}}" style="width: 90px; height: 100%; object-fit: cover;" alt="">
                        </td>
                        <td class="product text-center">
                            <a href="{{route('product.detailproduct', $dataCat->id_product)}}" class="overfow_text" style="width: 200px; margin: auto;">{{$dataCat->getProduct->product_name}}</a>
                        </td>
                        <td class="price">
                            <span class="amount">{{number_format($dataCat->getProduct->getArchivePrice->price)}}</span>
                        </td>
                        <td style="width: 100px;">
                            <form action="#" class="formUpdateCart" data-id="{{$dataCat->id}}">
                                <input type="hidden" name="idCartUpdate" value="{{$dataCat->id}}">
                                <div class="shop-single-content mb-2">
                                    <div class="quantity d-flex">
                                        <button type="button" data-id="{{$dataCat->id}}" class="sub"><i class="ti-minus"></i></button>
                                        <input type="text" id="id_quantity_main_product_{{$dataCat->id}}" name="quantityUpdate" value="{{$dataCat->quantity}}" />
                                        <button type="button" data-id="{{$dataCat->id}}" class="add"><i class="ti-plus"></i></button>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary btn-sm btnSubmitFormCart" name="submitFormCartUpdate" value="Áp dụng">
                            </form>
                        </td>
                        <td class="totalPrice ">
                            <p class="">{{ number_format($dataCat->getProduct->getArchivePrice->price * $dataCat->quantity) }}</p>
                        </td>
                        <td class="remove">
                            <button type="button" class="btn btn-outline-danger  deleteCart" data-link="{{route('cart.delete', $dataCat->id)}}" data-id="{{$dataCat->id}}" style="border-color: #dc3545;"><i class="fa  fa-trash-o"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="box_add_to_cart_main " style="display: flex; justify-content: space-between; align-items: center; ">
            <div>
                <button type="button" class="btn btn-success" id="btnBackLink"> Trở lại </button>
            </div>
            <div>
                <button type="button" class="btn btn-primary" id="btnAddProduct" data-toggle="modal" data-target="#modalAddCompare">Thêm sản phẩm</button>
                <!-- <button type="button" class="btn btn-orange checkLoginAuth " value="" disabled id="btn_payment_cart"> Thanh toán </button>  -->
                <a href="{{route('cart.delete.all')}}" class="btn btn-warning " id="deletelAllCart">Xóa tất cả</a>
            </div>
        </div>

        <div id="box_Main_Show_Infor_Payment " class="mt-3 text-center" style=" width: 500px; margin: 0 auto; ">
            <form action="{{route('payment.create')}}" id="formOrderMain" method="GET">
                @csrf

                <h3>Thông tin đặt hàng</h3>
                <!-- tên người nhận -->
                <div class="form-group  text-left mb-3">
                    <label for="nameReceiver" class="font-weight-bold" style="font-size:1rem">Tên người nhận</label>
                    <input type="text" name="nameReceiverOrder" class="form-control" id="nameReceiver" placeholder="VD: Nguễn Văn A" value="{{Auth::user()->name}}" >
                    <small id="errorNameReceiver" class="form-text text-muted"></small>
                </div>
                <!-- số diện thoại -->
                <div class="form-group  text-left mb-3">
                    <label for="phonenumber" class="font-weight-bold" style="font-size:1rem">Số điện thoại</label>
                    <input type="text" name="phonenumbeOrder" class="form-control" id="phonenumber" placeholder="VD: 081812xxx" value="{{$dataUser->phone}}">
                    <small id="errorPhonenumber" class="form-text text-muted"></small>
                </div>
                <!-- địa chỉ -->
                <div class="form-group  text-left mb-3">
                    <label for="address" class="font-weight-bold" style="font-size:1rem">Địa chỉ</label>
                    <input type="text" name="addressOrder" class="form-control" id="address" placeholder="VD: đường Phố Núi - Nha trang - khánh Hòa" 
                    @if($dataUser->id_province != null)
                    value="{{$dataUser->street}} - {{$dataUser->id_ward}} - {{$dataUser->id_district}} -{{$dataUser->id_province}}"
                    @endif
                    >
                    <small id="errorAddress" class="form-text text-muted"></small>
                </div>
                <!-- Email -->
                <div class="form-group  text-left mb-3">
                    <label for="email" class="font-weight-bold" style="font-size:1rem">Email</label>
                    <input type="email" name="emailOrder" class="form-control" id="email" placeholder="VD: nguyenvana@gmail.com" value="{{Auth::user()->email}}">
                    <small id="errorEmail" class="form-text text-muted"></small>
                </div>
                <!-- ghi chú -->
                <div class="form-group  text-left mb-3">
                    <label for="note" class="font-weight-bold" style="font-size:1rem">Ghi chú</label>
                    <textarea name="noteOrder" class="form-control" id="note" style="width: 100%; height: 100px;"></textarea>
                    <small id="errorNote" class="form-text text-muted"></small>
                </div>
                <!-- tổng số tiền thành toán -->
                <div class="form-group text-left mb-3">
                    <h4>Tổng tiền: <span style="color: #f34f3f;" id="totalCartMain">0</span></h4>
                </div>
                <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; flex-direction: row;">
                    <button type="submit" type="button" class="btn btn-orange checkLoginAuth btn_payment_cart" disabled id="btn_payment_cart-online">Thanh toán khi nhận hàng</button>
                    <input type="hidden" name="pricePayment" value="" id="pricePayment">
                    <input type="hidden" name="user_id_payment" value="{{ Auth::check() ? Auth::user()->id : '' }}" id="">
                    <button type="submit" name="payment" value="2" class="btn btn-orange checkLoginAuth btn_payment_cart" disabled id="btn_payment_cart-offline">Thanh toán online</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- cart end -->

<!-- The Modal -->
<div class="modal fade" id="modalAddCompare">
    <div class="modal-dialog" style="width: 750px;">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thêm sản phẩm so sánh</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <input type="text" class="form-control" id="searchInfProduct" name="searchInfProduct" placeholder="Nhập thêm sản phẩm bạn muốn tìm... vd: bull dog">
                <div id="boxMainShowListProdut">
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('javascript_page')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                "X-CSRF_TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        // chọn tất cả
        $("#checkAll").click(function() {
            $('.check_item:checkbox').not(this).prop('checked', this.checked);
            let check = $(this).prop('checked');
            let dataCheck = 0

            if (check == true) {
                dataCheck = 1
            } else {
                dataCheck = 0
            }

            let listItemChecks = $('.check_item:checkbox');

            for (let i = 0; i < listItemChecks.length; i++) {

                let id = $(listItemChecks[i]).val()

                $.ajax({
                    url: '{{route("cart.update.check")}}',
                    type: 'get',
                    data: {
                        dataCheck,
                        id
                    },
                    success: (data) => {
                        // 
                    }
                })
            }

        });

        // check từng cái
        $('input:checkbox').change(function() {
            $('#btn_add_cart_product').prop('disabled', false);
            checkClickProduct();
        })

        // kiểm tra ô đó check hay bỏ check
        $('body').on('change', '.check_item:checkbox', function(e) {

            let check = $(this).prop('checked');
            let id = $(this).val();
            let dataCheck = 0

            if (check == true) {
                dataCheck = 1
                checkClickProduct();
            } else {
                dataCheck = 0
            }

            $.ajax({
                url: '{{route("cart.update.check")}}',
                type: 'get',
                data: {
                    dataCheck,
                    id
                },
                success: (data) => {
                    // 
                }
            })

        })

        // Cộng số tiền cần thành toán
        $('body').on('change', 'input:checkbox', function(e) {

            let id = $(this).val();
            let checkItems = $('.check_item:checkbox:checked');
            let toltalPrice = 0;

            for (let i = 0; i < checkItems.length; i++) {
                let idCart = $(checkItems[i]).val();
                let price = $('#totalPrice_' + idCart).val();
                toltalPrice += Number(price);
            }
            $('#pricePayment').val(toltalPrice);
            $('#totalCartMain').text(number_format(toltalPrice))
            $('#totalCartMain').val(toltalPrice)

        })

        $('body').on('click', '.deleteCart', function(e) {

            let urlDelete = $(this).data('link');

            // $(this).parent().parent().remove();
            $.ajax({
                url: urlDelete,
                type: 'GET',
                success: (data) => {
                    if (data == 1) {
                        cartMainProduct()
                        cartSubCurrent()
                    }
                }
            })

        })

        // search sản phẩmm
        $("body").on('input', '#searchInfProduct', function(e) {
            e.preventDefault();

            let valueSearch = $(this).val();

            $.ajax({
                url: '{{route("compare.listsproduct")}}',
                data: {
                    requestData: 'danhSachTimKiem',
                    dataSearch: valueSearch,
                },
                success: (data) => {

                    if (data) {
                        $('#boxMainShowListProdut').css({
                            'overflow-x': 'hidden',
                            'overflow-y': 'scroll',
                            'height': '600px',
                        })
                        $('#boxMainShowListProdut').html(data);
                    }
                }
            })
        })

        // chọn sản phẩm
        $("body").on('click', '.itemProduct', function(e) {
            e.preventDefault();

            let data_id = $(this).data('id');

            if ('{{Auth::check()}}') {
                $.ajax({
                    url: "{{route('cart.add')}}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id_User': ' {{ Auth::check() ? Auth::user()->id : "" }} ',
                        'id_product': data_id,
                        'quantity': 1
                    },
                    success: (data) => {
                        if (data.success == 'tontai') {
                            showNotification('warning', data.mess);
                        }

                        if (data.success == 'themthanhcong') {
                            showNotification('success', data.mess);
                            cartSubCurrent();
                            cartMainProduct();
                        }
                    }
                })
            }


        })

        // // thấy đổi số lượng
        // function changeQuantity() {

        //     let number = 1;

        //     $('body').on('click', '.sub', function(e) {
        //         e.preventDefault();

        //         let id = $(this).data('id');
        //         let value = Number($('#id_quantity_main_product_' + id).val());
        //         let newvalue = value - number;

        //         if (value > 1) {
        //             $('#id_quantity_main_product_' + id).val(newvalue);
        //         }

        //     })

        //     $('body').on('click', '.add', function(e) {
        //         e.preventDefault();

        //         let id = $(this).data('id');
        //         let value = Number($('#id_quantity_main_product_' + id).val());
        //         let newvalue = value + number;

        //         $('#id_quantity_main_product_' + id).val(newvalue);
        //     })
        // }
        // changeQuantity();

        // kiểm tra nút thêm giỏ hàng
        function checkClickProduct() {
            let dataCheckItems = $('.check_item:checkbox:checked');
            if (dataCheckItems.length) {
                $('.btn_payment_cart').prop('disabled', false);
            } else {
                $('.btn_payment_cart').prop('disabled', true);
            }
        }

        // gửi form update cart
        $('body').on('submit', '.formUpdateCart', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let quantity = $("#id_quantity_main_product_" + id).val();

            $.ajax({
                url: '{{route("cart.update")}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                    quantity: quantity,
                },
                success: (data) => {
                    if (data == 1) {
                        cartMainProduct()
                        cartSubCurrent()
                    }
                }
            })

        })

        // Xoas cart trên khung nhỏ
        $('body').on('click', '.itemDeleteCart', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                success: (data) => {
                    if (data == 1) {
                        cartMainProduct()
                        cartSubCurrent()
                    }
                }
            })
        })

        // Cập nhật giỏ hàng chính
        function cartMainProduct() {
            if ('{{Auth::check()}}') {
                $.ajax({
                    url: '{{ route("cart.main.list.update") }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id_user: ' {{ Auth::check() ? Auth::user()->id : "" }} ',
                    },
                    success: (data) => {
                        $('#row_Cart').html(data.dataHtml);
                    }
                })
            }
        }

        // Xoas cart trên khung nhỏ
        $('body').on('click', '.itemDeleteCart', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                success: (data) => {
                    if (data == 1) {
                        cartSubCurrent()
                    }
                }
            })
        })

        // cập nhật giỏ hàng nhỏ
        function cartSubCurrent() {
            if ('{{Auth::check()}}') {
                $.ajax({
                    url: '{{ route("cart.sub") }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id_user: ' {{ Auth::check() ? Auth::user()->id : "" }} ',
                    },
                    success: (data) => {
                        $('#showCartList').html(data.dataHtml);
                        $('#ShowTotalPrice').text(data.total);
                        $('#showQuantityCart').text(data.count);
                        // console.log(data);
                    }
                })
            }
        }
        cartSubCurrent()

        // thông báo
        function showNotification(attr, mess) {
            $(".alert-" + attr + " .text_msg").text(mess);
            $(".alert-" + attr + "").css({
                right: "30px",
                "z-index": "99999"
            });
            $(".alert-" + attr + " .btn-close").click(function() {
                $(".alert-" + attr + "").css({
                    right: "-999px"
                });
            });

            setTimeout(function() {
                $(".alert-" + attr + "").css({
                    right: "-999px"
                });
            }, 3000);
        }

        // format number
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
    })
</script>
@endsection