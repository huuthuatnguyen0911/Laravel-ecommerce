@extends('frontend/masterLayout')

@section('main_title')
Yêu thích
@endsection

@section('main_style_page')
<style>
    .cart-table .table thead tr.header_table,
    .cart-table tbody tr {
        background-color: white;
        border-bottom: 2px solid rgba(0, 0, 0, 0.2);
    }

    .cart-table .table thead tr th,
    .cart-table tbody tr td {
        border: none !important;
    }
</style>
@endsection

@section('main_content')

<!-- wishlist header start -->
<div class="wishlist_header text-center pb-5 pt-5">
    <h1 class="text-uppercase" style="margin: 0; color: #f34f3f; "> Sản phẩm yêu thích </h1>
</div>
<!-- wishlist header end -->

<!--Wishlist Start-->
<div class="cart-page pb-5">
    <div class="container">
        <div class="cart-table mb-4">
            <table class="table ">
                <thead>
                    <tr class="header_table">
                        <th class="">
                            <label style="display: flex; align-items: center; justify-content: center;" class="font-weight-bold">
                                <input type="checkbox" class="mr-2" id="checkAll" />
                                Chọn tất cả
                            </label>
                        </th>
                        <th class="image font-weight-bold">Ảnh</th>
                        <th class="product font-weight-bold">Tên sản phẩm</th>
                        <th class="price font-weight-bold">Giá</th>
                        <th class="quantity font-weight-bold">Mô tả</th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody id="roW_wishlist">

                </tbody>
            </table>
        </div>
        <div class="box_add_to_cart_main " style="display: flex; justify-content: space-between; align-items: center; ">
            <div>
                <button type="button" class="btn btn-success" id="btnBackLink"> Trở lại </button>
            </div>
            <div>
                <button type="button" class="btn btn-orange checkLoginAuth " disabled id="btn_add_cart_product"> Thêm vào giỏ hàng </button>
                <button type="button" class="btn btn-warning " id="deletelAllProduct">Xóa tất cả</button>
            </div>
        </div>
    </div>
</div>
<!--Wishlist End-->

@endsection

@section('javascript_page')
<script>
    $(document).ready(function() {
        function view() {
            if (localStorage.getItem('data') != null) {
                let data = JSON.parse(localStorage.getItem('data'));
                data.reverse();

                for (let i = 0; i < data.length; i++) {
                    let id = data[i]['id']
                    let name = data[i]['name'];
                    let price = data[i]['price'];
                    let description = data[i]['description'];
                    let image = data[i]['image'];
                    let url = data[i]['url'];

                    let getPrice = price.split('>')[1];

                    $("#roW_wishlist").append(`
                    <tr>
                        <td>
                            <input type="checkbox" class="check_item" id="" value="${id}" />
                        </td>
                        <td class="image">
                            <img src="${image}" style="width: 90px; height: 100%; object-fit: cover;" alt="">
                        </td>
                        <td class="product text-center">
                            <a href="${url}" class="overfow_text" style="width: 200px; margin: auto;">${name}</a>
                        </td>
                        <td class="price">
                            <span class="amount">${getPrice}</span>
                        </td>
                        <td class="description ">
                            <p class="overfow_text" style="width: 300px; margin: auto;">${description}</p>
                        </td>
                        <td class="remove">
                            <button type="button" class="btn btn-outline-danger  deleteWishList" id="" data-id="${(data.length -1) - i}" style="border-color: #dc3545;"><i class="fa  fa-trash-o"></i></button>
                        </td>
                    </tr>
                    `)
                }
            }
        }
        view();

        $("#checkAll").click(function() {
            $('.check_item:checkbox').not(this).prop('checked', this.checked);
        });

        $('input:checkbox').change(function() {
            $('#btn_add_cart_product').prop('disabled', false);
            checkClickProduct();
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

        // thêm vào giỏ hàng
        $('#btn_add_cart_product').click(function() {
            let arrIdProduct = [];
            let dataCheckItems = $('.check_item:checkbox:checked');

            if ('{{Auth::check()}}') {
                if (dataCheckItems.length) {
                    for (let i = 0; i < dataCheckItems.length; i++) {
                        arrIdProduct.push($(dataCheckItems[i]).val());
                    }
                    $.ajax({
                        url: "{{route('cart.add.list')}}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            requestText: 'addListCartProduct',
                            id_user: ' {{ Auth::check() ? Auth::user()->id : "" }} ',
                            dataCartList: arrIdProduct,
                        },
                        success: (data) => {
                            if (data.success == 'themthanhcong') {
                                showNotification('success', data.mess);
                                cartSubCurrent();
                            }
                        }
                    })

                }
            }
        })

        // xóa yêu thích
        $("body").on('click', '.deleteWishList', function(e) {
            let id = $(this).data('id');

            let data = JSON.parse(localStorage.getItem('data'));

            const arr1 = data.slice(0, id);
            const arr2 = data.slice(id + 1, data.length);
            const newArr = [...arr1, ...arr2];

            localStorage.setItem('data', JSON.stringify(newArr));

            $(this).parent().parent().remove()
        })

        // xóa tất cả yêu thích
        $("body").on('click', '#deletelAllProduct', function(e) {
            if (localStorage.getItem('data') != null) {
                localStorage.removeItem('data');
                $('#roW_wishlist').children().remove();
            } else {
                $(".alert-warning .text_msg").text("Không có sản phẩm để xóa");
                $(".alert-warning").css({
                    right: "30px",
                    "z-index": "99999"
                });
                $(".alert-warning .btn-close").click(function() {
                    $(".alert-warning").css({
                        right: "-999px"
                    });
                });

                setTimeout(function() {
                    $(".alert-warning").css({
                        right: "-999px"
                    });
                }, 3000);
            }
        })

        $('#btnBackLink').click(function() {
            window.history.back();
        });

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

    })
</script>
@endsection