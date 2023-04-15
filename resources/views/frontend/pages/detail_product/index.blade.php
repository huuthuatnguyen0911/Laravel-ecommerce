@extends('frontend/masterLayout')

@section('head_main_page')
<meta property="og:url" content="{{$urlProduct}}" />
<meta property="og:type" content="product" />
<meta property="og:title" content="{{$productInf->product_name}}" />
<meta property="og:description" content="{{$productInf->product_description}}" />
<meta property="og:image" content="{{$urlImage}}" />
@endsection

@section('main_title')
@if($productInf != '')
{{$productInf->product_name}}
@else
sản phẩm không tồn tại
@endif
@endsection

@section('main_style_page')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<style>
    .box_not_exists {
        width: 100%;
        margin: 20px auto;
        display: flex;
        flex-direction: column-reverse;
        justify-content: center;
        align-items: center;
        /* border:  1px solid rgba(255, 255, 255,0.8); */
    }

    .box_not_exists h3 {
        color: red;
    }

    .box_not_exists img {
        width: 300px;
        height: 300px;
        object-fit: cover;
    }

    .box_image_main>.img_show_main {
        width: 100% !important;
        height: 550px !important;
        object-fit: cover;
    }

    .shop-single-content .product-action .action .btn {
        line-height: unset
    }

    .box_main_inf_user {
        display: flex;
        flex-direction: row;
        /* justify-content: ; */
        align-items: flex-start;
        margin: 20px 0;
    }

    .box_main_inf_user .box_avatar {
        width: 80px;
        height: 80px;
        margin-right: 10px;
        border-radius: 50%;
        overflow: hidden;
    }

    .box_main_inf_user .box_avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .box_main_inf_user .box_content {
        background-color: rgba(243, 79, 63, 0.1);
        padding: 10px;
        border-radius: 20px;
        width: 100%;
    }

    .box_main_inf_user-reply {
        margin-left: 80px;
    }
</style>
@endsection

@section('main_content')

@if($productInf != '')

<!--Shop Single Start-->
<div class="shop-single-page  pb-4">
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=585310486133799&autoLogAppEvents=1" nonce="tu2zxNUK"></script>
    <div class="container">

        <!--Shop Single Start-->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="shop-image">
                    <div class="shop-single-preview-image box_image_main">
                        <img class="img_show_main" src="../{{$productInf->getAllImage[0]->link_image}}" alt="">

                        <!-- <span class="sticker-new label-sale">-34%</span> -->
                    </div>
                    <div id="gallery_01" class="shop-single-thumb-image shop-thumb-active swiper-container">
                        <div class="swiper-wrapper box_main_slide_product">
                            @foreach($productInf->getAllImage as $image)
                            <div class="swiper-slide single-product-thumb">
                                <a class=" @if($loop->index == 0) active @endif  link_image_item " href="#">
                                    <img src="{{asset($image->link_image)}}" alt="" style="width: 100%; height:150px; object-fit: cover;">
                                </a>
                            </div>
                            @endforeach
                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-thumb-next"><i class="fa fa-angle-right"></i></div>
                        <div class="swiper-thumb-prev"><i class="fa fa-angle-left"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shop-single-content">
                    <h3 class="title">{{$productInf->product_name}}</h3>
                    <span class="product-sku">SKU: <span>{{$productInf->product_id}}</span></span>
                    <p style="margin: 0;">Còn lại :
                        @if($productInf->getArchive->quantity == 0)
                        <span class="badge badge-danger">đã hết hàng</span>
                        @else
                        <span>{{$productInf->getArchive->quantity}}</span> sản phẩm
                        @endif
                    </p>
                    <div class="product-rating">
                        <ul class="rating-star">
                            @for($i = 0; $i < 5 ; $i++) 
                                @php if($i < $rating) 
                                    { $classStar='rating-on' ; }else{ $classStar='' ; } 
                                @endphp 
                                <li class="{{$classStar}}"><i class="fa fa-star"></i></li>
                            @endfor
                        </ul>
                        <!-- <span>No reviews</span> -->
                    </div>
                    <div class="thumb-price">
                        <span class="current-price">{{number_format($productInf->getArchive->price)}} VNĐ</span>
                        <!-- <span class="old-price">$29.00</span>
                        <span class="discount">-34%</span> -->
                    </div>
                    <p>{{$productInf->product_description}}</p>

                    <!-- <ul class="product-additional-information">
                        <li><button><i class="ti-ruler-pencil"></i> Size Guide</button></li>
                        <li><button><i class="fa fa-truck"></i> Shipping</button></li>
                        <li><button><i class="ti-email"></i> Ask About This product </button></li>
                    </ul> -->
                    <form action="{{route('cart.add')}}" method="post" id="formMainAddCart">
                        @csrf
                        <input type="hidden" name="id_product" value="{{$productInf->product_id}}">
                        <input type="hidden" name="id_User" value="{{Auth::check() ? Auth::user()->id : '' }}">

                        <div class="product-quantity d-flex flex-wrap align-items-center">
                            <span class="quantity-title">Số lượng: </span>

                            <div class="quantity d-flex">
                                <button type="button" class="sub"><i class="ti-minus"></i></button>
                                <input type="text" id="id_quantity_main_product" name="quantity" value="1" />
                                <button type="button" class="add"><i class="ti-plus"></i></button>
                            </div>

                        </div>

                        <div class="product-action d-flex flex-wrap">
                            <div class="action">
                                @php
                                $disabledQuantity = '';
                                if( $productInf->getArchive->quantity == 0){
                                $disabledQuantity = 'disabled';
                                };
                                @endphp
                                <button type="submit" name="submitFormAddCart" {{$disabledQuantity}} value="Thêm giỏ hàng" class="btn btn-orange checkLoginAuth">Thêm vào giỏ hàng</button>
                            </div>
                    </form>
                    <div class="action">
                        <form>
                            @csrf
                            <input type="hidden" id="wishlist_url_{{$productInf->product_id}}" value="{{route('product.detailproduct', $productInf->product_id )}}">
                            <input type="hidden" id="wishlist_name_{{$productInf->product_id}}" value="{{$productInf->product_name}}">
                            <input type="hidden" id="wishlist_price_{{$productInf->product_id}}" value="{{number_format($productInf->getArchive->price)}}">
                            <input type="hidden" id="wishlist_description_{{$productInf->product_id}}" value="{{ $productInf->product_description }}">
                            <input type="hidden" id="wishlist_image_{{$productInf->product_id}}" value="{{asset($productInf->getAllImage[0]->link_image)}}">
                            <input type="hidden" id="wishlist_quantity_{{$productInf->product_id}}" value="{{$productInf->getArchive->quantity}}">
                        </form>

                        <a id="{{$productInf->product_id}}" class="checkLoginAuth wishlistButton"><i class="fa fa-heart"></i></a>
                    </div>
                </div>

                <!-- <div class="dynamic-checkout-button disabled">
                    <div class="checkout-checkbox">
                        <input type="checkbox" id="disabled">
                        <label for="disabled"><span></span> Tôi đồng ý với các điều khoản và điều kiện </label>
                    </div>
                    <div class="checkout-btn">
                        <button class="btn btn-orange checkLoginAuth" style="line-height: unset;">Mua ngay</button>
                    </div>
                </div> -->

                <!-- <div class="custom-payment-options">
                    <p>Đảm bảo thanh toán an toàn</p>

                    <ul class="payment-options">
                        <li><img src="{{asset('assets/frontends/images/payment-icon/payment-1.svg')}}" alt=""></li>
                        <li><img src="{{asset('assets/frontends/images/payment-icon/payment-2.svg')}}" alt=""></li>
                        <li><img src="{{asset('assets/frontends/images/payment-icon/payment-3.svg')}}" alt=""></li>
                        <li><img src="{{asset('assets/frontends/images/payment-icon/payment-4.svg')}}" alt=""></li>
                        <li><img src="{{asset('assets/frontends/images/payment-icon/payment-5.svg')}}" alt=""></li>
                        <li><img src="{{asset('assets/frontends/images/payment-icon/payment-7.svg')}}" alt=""></li>
                    </ul>
                </div> -->

                <div class="social-share">
                    <span class="share-title mr-2">Chia sẻ:</span>
                    <ul class="social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                    </ul>
                    <div class="fb-share-button" style="margin-left: 30px;" data-href="{{$urlProduct}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$urlProduct}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                </div>
            </div>
        </div>
    </div>
    <!--Shop Single End-->

    <!--Shop Single info Start-->
    <div class="shop-single-info" style="border: none; border-bottom: 1px solid #e1e1e1; ">
        <div class="shop-info-tab">
            <ul class="nav justify-content-center" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">Mô tả</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2" role="tab">Đánh giá</a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                <div class="description text_inf_sub_description">
                    {!! $productInf->product_sub_description !!}
                </div>
            </div>
            <div class="tab-pane fade " id="tab2" role="tabpanel">
                <div class="reviews" style="border: none;">
                    <div style="display: flex; flex-direction: row; align-items: center;">
                        <h3 class=" review-title font-weight-bold mr-2">Đánh giá của bạn</h3>
                        <p>0 <span>đánh giá</span></p>
                    </div>

                    <div class="reviews-form">
                        <form action="#" method="post" id="form_evaluate">
                            <input type="hidden" name="value_star" id="value_star_id" value="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="reviews-rating">
                                        <label class="font-weight-bold" style="font-size: 16px;">Xếp hạng</label>
                                        <ul id="rating" class="rating">
                                            <li class="star" title='Poor' data-value='1'><i class="fa fa-star-o"></i></li>
                                            <li class="star" title='Poor' data-value='2'><i class="fa fa-star-o"></i></li>
                                            <li class="star" title='Poor' data-value='3'><i class="fa fa-star-o"></i></li>
                                            <li class="star" title='Poor' data-value='4'><i class="fa fa-star-o"></i></li>
                                            <li class="star" title='Poor' data-value='5'><i class="fa fa-star-o"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single-form">
                                        <label class="font-weight-bold" style="font-size: 16px;">Nội dung đánh giá (255)</label>
                                        <textarea id="inputTextComment" placeholder="Viết đánh giá của bạn ở đây..." style="height: 150px; border-radius: 10px; "></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single-form">
                                        <button type="submit" class="btn btn-orange checkLoginAuth" id="btnSendComment">Gửi đánh giá</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <ul class="reviews-items" id="box_ul_show_comment">

                    </ul>

                </div>
            </div>
        </div>
    </div>
    <!--Shop Single info End-->

    <!--New Product Start-->
    <div class="new-product-area section-padding-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-9 col-sm-11">
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm tương tự</h2>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="swiper-container product-active">
                    <div class="swiper-wrapper">
                        @foreach($similarProducts as $similarProduct)
                        <div class="swiper-slide">
                            <div class="single-product">
                                <div class="product-image">
                                    <a href="{{route('product.detailproduct', $similarProduct->product_id )}}">
                                        <img style="height: 340px; width: 100%; object-fit: cover; " src="../{{$similarProduct->getMainImage->link_image}}" alt="{{$similarProduct->getMainImage->alt_image}}">
                                    </a>
                                    <!-- <span class="sticker-new soldout-title view_new_pet">New</span> -->

                                    <div class="action-links">
                                        <form>
                                            @csrf
                                            <input type="hidden" id="wishlist_url_{{$similarProduct->product_id}}" value="{{route('product.detailproduct', $similarProduct->product_id )}}">
                                            <input type="hidden" id="wishlist_name_{{$similarProduct->product_id}}" value="{{$similarProduct->product_name}}">
                                            <input type="hidden" id="wishlist_price_{{$similarProduct->product_id}}" value="{{number_format($similarProduct->getArchive->price)}}">
                                            <input type="hidden" id="wishlist_description_{{$similarProduct->product_id}}" value="{{ $similarProduct->product_description }}">
                                            <input type="hidden" id="wishlist_image_{{$similarProduct->product_id}}" value="{{asset($similarProduct->getMainImage->link_image)}}">
                                            <input type="hidden" id="wishlist_quantity_{{$similarProduct->product_id}}" value="{{$similarProduct->getArchive->quantity}}">
                                        </form>
                                        <ul>
                                            <li><a id="{{$similarProduct->product_id}}" data-tooltip="tooltip" data-placement="left" title="Thêm" class="checkLoginAuth addCartItem"><i class="icon-shopping-bag"></i></a></li>
                                            <li><a id="{{$similarProduct->product_id}}" data-tooltip="tooltip" data-placement="left" title="So sánh" class="compareButton"><i class="icon-sliders"></i></a></li>
                                            <li><a id="{{$similarProduct->product_id}}" data-tooltip="tooltip" data-placement="left" title="Yêu thích" class="checkLoginAuth wishlistButton"><i class="icon-heart"></i></a></li>
                                            <li><a href="{{ route('infor.getInfPet',$similarProduct->product_id) }}" data-tooltip="tooltip" data-placement="left" data-id="{{$similarProduct->product_id}}" title="Xem nhanh" class="icon_show_inf_pet"><i class="icon-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content text-center">
                                    <ul class="rating">
                                        @for($i = 0; $i < 5 ; $i++) @php if($similarProduct->avgRating->first() != ''){
                                            if($i < round($similarProduct->avgRating->first()->aggregate))
                                                {
                                                $classStar = 'rating-on';
                                                }else{
                                                $classStar = '';
                                                }
                                                }else{
                                                $classStar = '';
                                                }

                                                @endphp

                                                <li class="{{$classStar}}"><i class="fa fa-star"></i></li>
                                                @endfor

                                    </ul>
                                    <h4 class="product-name"><a href="{{route('product.detailproduct', $similarProduct->product_id )}}" class="font-weight-bold" style="font-size:1.1rem">{{$similarProduct->product_name}}</a></h4>
                                    <p class="text-break m-0 lh-base">
                                        @php
                                        $truncated = Str::limit($similarProduct->product_description,61, '...');
                                        @endphp
                                        {{$truncated}}
                                    </p>
                                    <div class="price-box">
                                        <span class="current-price">{{number_format($similarProduct->getArchive->price)}}</span>
                                        <!-- <span class="old-price">$29.00</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Add Arrows -->
                    <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                    <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
                </div>
            </div>
        </div>
    </div>
    <!--New Product End-->


</div>
</div>
<!--Shop Single End-->

@else

<div class="container">
    <div class="box_not_exists">
        <h3>Sản phẩm không tồn tại</h3>
        <img src="{{asset('images/bg_khong_ton_tai.png')}}" alt="">
    </div>
</div>

@endif

@endsection

@section('javascript_page')
<script type="text/javascript">
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                "X-CSRF_TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        $('.box_main_slide_product').on('click', '.link_image_item', function(e) {
            e.preventDefault();
            let getLinkImage = $(this).children().attr('src');
            $(".box_main_slide_product").find('.active').removeClass('active');
            $(this).addClass('active');

            $('.box_image_main .img_show_main').attr('src', getLinkImage);
        })

        $("body").on('click', '.icon_show_inf_pet', function(e) {
            e.preventDefault();

            // let idPet = $(this).data('id');
            let dataUrl = $(this).attr('href');
            $('#modalShowPet').modal('toggle')
            $.ajax({
                url: dataUrl,
                type: 'GET',
                success: function(data) {
                    // console.log(data);
                    $("#modalShowPet .quick-view-image img").attr('src', "../" + data.get_main_image.link_image);
                    $('#modalShowPet .product-title').text(data.product_name);
                    $('#modalShowPet .current-price').text(number_format(Number(data.get_archive.price)));
                    $('#modalShowPet .description_product').text(data.product_description);
                }
            })

        })

        // sản phẩm yêu thích
        $("body").on('click', '.wishlistButton', function(e) {

            let id = $(this).attr('id');
            if ('{{Auth::check()}}') {
                add_wishList(id);
            }
        });

        // thêm so sánh
        $('body').on('click', '.compareButton', function(e) {
            e.preventDefault();

            let number_compare = 3;

            let id = $(this).attr('id');
            let name = $('#wishlist_name_' + id).val();
            let price = $('#wishlist_price_' + id).val();
            let image = $('#wishlist_image_' + id).val();
            let description = $('#wishlist_description_' + id).val();
            let dataUrl = $('#wishlist_url_' + id).val();
            let quantity = $('#wishlist_quantity_' + id).val();

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
                    // showNotification('success', "Đã thêm sản phẩm vào mục yêu thích");
                    localStorage.setItem('compareData', JSON.stringify(old_data));
                    window.location = '{{route("compare.index")}}'
                } else {
                    showNotification('warning', "Đã đủ số lượng so sánh");
                }
                //  
            }
        })

        // Gui form add cart
        $('body').on('submit', '#formMainAddCart', function(e) {
            e.preventDefault();

            let url = $(this).attr('action');
            let dataForm = $(this).serialize();

            if ('{{Auth::check()}}') {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: dataForm,
                    success: (data) => {
                        if (data.success == 'tontai') {
                            showNotification('warning', data.mess);
                        }

                        if (data.success == 'themthanhcong') {
                            showNotification('success', data.mess);
                            cartSubCurrent();
                        }
                    }
                })
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

        // thêm cart ở list
        $('body').on('click', '.addCartItem', function(e) {
            e.preventDefault();

            let data_id = $(this).attr('id');

            if ('{{Auth::check()}}') {
                $.ajax({
                    url: "{{route('cart.add')}}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id_User': '{{Auth::check() ? Auth::user()->id : "" }}',
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
                        }
                    }
                })
            }
            console.log(data_id)
        });

        // Gửi comment
        $('body').on('click', '#btnSendComment', function(e) {
            e.preventDefault();
            let id_product = '{{$productInf->product_id}}';
            let id_user = '{{Auth::check() ? Auth::user()->id : "" }}';
            let valueComment = $('#inputTextComment').val();
            let value_rating = $('#value_star_id').val();

            $.ajax({
                url: '{{route("comments.send")}}',
                type: 'POST',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr("content"),
                    id_product: id_product,
                    id_user: id_user,
                    valueComment: valueComment,
                    value_rating: value_rating
                },
                success: function(data) {
                    if (data != null) {
                        showComment()
                    }
                }
            })

        })

        //lấy giá trị đánh giá
        $('#form_evaluate').on('click', '.rating .star', function(e) {
            let star = $(this).data('value');
            $('#value_star_id').val(star);
        })

        // show comment
        function showComment() {
            let id_product = '{{$productInf->product_id}}';
            $.ajax({
                url: '{{route("comments.showall")}}',
                type: 'get',
                data: {
                    id_product: id_product
                },
                success: (data) => {
                    $('#box_ul_show_comment').html(data);
                }
            })
        }
        showComment();

        // Thêm vào yêu thích
        function add_wishList(id) {

            let name = $('#wishlist_name_' + id).val();
            let price = $('#wishlist_price_' + id).val();
            let image = $('#wishlist_image_' + id).val();
            let description = $('#wishlist_description_' + id).val();
            let dataUrl = $('#wishlist_url_' + id).val();

            let newItem = {
                'url': dataUrl,
                'id': id,
                'name': name,
                'price': price,
                'description': description,
                'image': image,
            }

            if (localStorage.getItem('data') == null) {
                localStorage.setItem('data', '[]');
            }

            let old_data = JSON.parse(localStorage.getItem('data'));

            let matches = $.grep(old_data, function(obj) {
                return obj.id == id;
            });

            if (matches.length) {
                showNotification('warning', "Sản phẩm đã có trong danh mục yêu thích");
            } else {
                old_data.push(newItem)
                showNotification('success', "Đã thêm sản phẩm vào mục yêu thích");

            }

            localStorage.setItem('data', JSON.stringify(old_data));
        }

        // thấy đổi số lượng
        function changeQuantity() {

            let number = 1;

            $('body').on('click', '.sub', function(e) {
                e.preventDefault();

                let value = Number($('#id_quantity_main_product').val());
                let newvalue = value - number;

                $('#id_quantity_main_product').val(newvalue);
            })

            $('body').on('click', '.add', function(e) {
                e.preventDefault();

                let value = Number($('#id_quantity_main_product').val());
                let newvalue = value + number;

                $('#id_quantity_main_product').val(newvalue);
            })
        }
        changeQuantity();

        // cập nhật giỏ hàng nhỏ
        function cartSubCurrent() {
            if ('{{Auth::check()}}') {
                $.ajax({
                    url: '{{ route("cart.sub") }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id_user: '{{Auth::check() ? Auth::user()->id : "" }}',
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

        // Thông báo
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