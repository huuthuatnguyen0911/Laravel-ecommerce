@extends('frontend/masterLayout')

@section('main_title')
So sánh
@endsection

@section('main_style_page')
<style>
    #modalAddCompare {}

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
    <h1 class="text-uppercase" style="margin: 0; color: #f34f3f; "> So sánh </h1>
</div>
<!-- wishlist header end -->
<!--Compare Start-->
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
                        <th class="quantity font-weight-bold">Mô tả</th>
                        <!-- <th class="quantity font-weight-bold">Đánh giá</th> -->
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody id="row_compare">

                </tbody>
            </table>
        </div>
        <div class="box_add_to_cart_main " style="display: flex; justify-content: space-between; align-items: center; ">
            <div>
                <button type="button" class="btn btn-success" id="btnBackLink"> Trở lại </button>
            </div>
            <div>
                <button type="button" class="btn btn-primary" id="btnAddProduct" data-toggle="modal" data-target="#modalAddCompare">Thêm sản phẩm</button>
                <button type="button" class="btn btn-orange checkLoginAuth " disabled id="btn_add_cart_product"> Thêm vào giỏ hàng </button>
                <button type="button" class="btn btn-warning " id="deletelAllProduct">Xóa tất cả</button>
            </div>
        </div>
    </div>
</div>
<!--Compare End-->

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

        function view() {
            if (localStorage.getItem('compareData') != null) {
                let data = JSON.parse(localStorage.getItem('compareData'));
                data.reverse();

                for (let i = 0; i < data.length; i++) {
                    let id = data[i]['id']
                    let name = data[i]['name'];
                    let price = data[i]['price'];
                    let description = data[i]['description'];
                    let image = data[i]['image'];
                    let url = data[i]['url'];
                    let quantity = data[i]['quantity'];

                    let getPrice = price.split('>')[1];
                    $("#row_compare").append(`
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
                        <td>
                            <span>${quantity}</span>
                        </td>
                        <td class="description ">
                            <p class="overfow_text" style="width: 300px; margin: auto;">${description}</p>
                        </td>
                        <td class="remove">
                            <button type="button" class="btn btn-outline-danger  deleteCompare" id="" data-id="${(data.length -1) - i}" style="border-color: #dc3545;"><i class="fa  fa-trash-o"></i></button>
                        </td>
                    </tr>
                    `)
                }
            }
        }
        view();
        // <td>
        //                     <ul class="rating">
        //                         <li class="rating-on"><i class="fa fa-star"></i></li>
        //                         <li class="rating-on"><i class="fa fa-star"></i></li>
        //                         <li class="rating-on"><i class="fa fa-star"></i></li>
        //                         <li class="rating-on"><i class="fa fa-star"></i></li>
        //                         <li class=""><i class="fa fa-star"></i></li>
        //                     </ul>
        //                 </td>
        // chọn tất cả
        $("#checkAll").click(function() {
            $('.check_item:checkbox').not(this).prop('checked', this.checked);
        });

        // check từng cái
        $('input:checkbox').change(function() {
            $('#btn_add_cart_product').prop('disabled', false);
            checkClickProduct();
        })

        // kiểm tra nút thêm giỏ hàng
        function checkClickProduct() {
            let dataCheckItems = $('.check_item:checkbox:checked');
            if (dataCheckItems.length) {
                $('#btn_add_cart_product').prop('disabled', false);
            } else {
                $('#btn_add_cart_product').prop('disabled', true);
            }
        }

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
        
        // xóa theo sản phẩm
        $("body").on('click', '.deleteCompare', function(e) {
            let id = $(this).data('id');

            let data = JSON.parse(localStorage.getItem('compareData'));

            const arr1 = data.slice(0, id);
            const arr2 = data.slice(id + 1, data.length);
            const newArr = [...arr1, ...arr2];

            localStorage.setItem('compareData', JSON.stringify(newArr));

            $(this).parent().parent().remove()
        })

        // xóa tất cả
        $("body").on('click', '#deletelAllProduct', function(e) {
            if (localStorage.getItem('compareData') != null) {
                localStorage.removeItem('compareData');
                $('#row_compare').children().remove();
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

            console.log();
        })

        // chọn sản phẩm
        $("body").on('click', '.itemProduct', function(e) {
            let id = $(this).data('id');

            let quantity = $('#quantityProduct_' + id).val();
            let dataUrl = $('#urlProduct_' + id).val();
            let image = $('#imgModalSearch_' + id).attr('src');
            let description = $('#descriptionProduct_' + id).text();
            let price = $('#priceProduct_' + id).text();
            let name = $('#nameProduct_' + id).text();

            let newItem = {
                'url': dataUrl,
                'id': id,
                'name': name,
                'price': price,
                'description': description,
                'image': image,
                'quantity': quantity,
            }

            if (localStorage.getItem('compareData') == null) {
                localStorage.setItem('compareData', '[]');
            }

            let old_data = JSON.parse(localStorage.getItem('compareData'));

            let matches = $.grep(old_data, function(obj) {
                return obj.id == id;
            });

            if (matches.length) {
                showNotification('warning', "Sản phẩm đã có trong so sánh");
            } else {
                if (old_data.length < 3) {
                    old_data.push(newItem)
                    showNotification('success', "Đã thêm sản phẩm vào mục yêu thích");
                    localStorage.setItem('compareData', JSON.stringify(old_data));
                    let data = JSON.parse(localStorage.getItem('compareData'))
                    $("#row_compare").append(`
                    <tr>
                            <td>
                                <input type="checkbox" class="check_item" id="" value="${id}" />
                            </td>
                            <td class="image">
                                <img src="${image}" style="width: 90px; height: 100%; object-fit: cover;" alt="">
                            </td>
                            <td class="product text-center">
                                <a href="${dataUrl}" class="overfow_text" style="width: 200px; margin: auto;">${name}</a>
                            </td>
                            <td class="price">
                                <span class="amount">${price}</span>
                            </td>
                            <td>
                                <span>${quantity}</span>
                            </td>
                            <td class="description ">
                                <p class="overfow_text" style="width: 300px; margin: auto;">${description}</p>
                            </td>
                            <td>
                                <ul class="rating">
                                    <li class="rating-on"><i class="fa fa-star"></i></li>
                                    <li class="rating-on"><i class="fa fa-star"></i></li>
                                    <li class="rating-on"><i class="fa fa-star"></i></li>
                                    <li class="rating-on"><i class="fa fa-star"></i></li>
                                    <li class=""><i class="fa fa-star"></i></li>
                                </ul>
                            </td>
                            <td class="remove">
                                <button type="button" class="btn btn-outline-danger  deleteCompare" id="" data-id="${data.length -1}" style="border-color: #dc3545;"><i class="fa  fa-trash-o"></i></button>
                            </td>
                    </tr>
                    `)
                } else {
                    showNotification('warning', "Đã đủ số lượng so sánh");
                }
                //  
            }

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