@extends('frontend/masterLayout')

@section('main_title')
Trang chủ
@endsection

@section('main_active_site_home')
active-site
@endsection

@section('main_style_page')
<style>
    @keyframes scaleAnimation {
        from {
            opacity: 0;
            transform: scale(0);
        }

        to {
            opacity: 1;
            transform: scale(1.2);
        }
    }

    .swiper-slide .view_new_pet {
        animation: scaleAnimation 1s ease infinite;
    }
</style>
@endsection

@section('main_content')
<!--Slider Start-->
<div class="slider-area">
    <div class="swiper-container slider-active">
        <div class="swiper-wrapper">

            @isset($dataSlides)
            @foreach($dataSlides as $dataSlide)
            <!--Single Slider Start-->
            <div class="single-slider swiper-slide animation-style-01" style="background-image: url('{{ $dataSlide->image }}');">
                <div class="container">
                    <div class="slider-content">
                        @if($dataSlide->sub_title)
                        <h5 style="color: azure;" class="sub-title">{{$dataSlide->sub_title}}<br>{{$dataSlide->sub_title_text}}</h5>
                        @endif
                        @if ($dataSlide->main_title != null)
                        <h2 class="main-title">{{$dataSlide->main_title}}</h2>
                        @endif
                        @if($dataSlide->main_title_text != null)
                        <p style="color: azure;">{{$dataSlide->main_title_text}}</p>
                        @endif

                        @if($dataSlide->text_button != null)
                        <ul class="slider-btn">
                            <li><a href="{{$dataSlide->link_button}}" class="btn btn-orange btn-round ">{{$dataSlide->text_button}}</a></li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
            <!--Single Slider End-->
            @endforeach
            @endisset
        </div>
        <!--Swiper Wrapper End-->

        <!-- Add Arrows -->
        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>

        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>

    </div>
    <!--Swiper Container End-->
</div>
<!--Slider End-->

<!--Shipping Start-->
<div class="shipping-area section-padding-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="{{asset('assets/frontends/images/shipping-icon/Free-Delivery.png')}}" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Giao hàng miễn phí</h5>
                        <p>Giao hàng miễn phí trên địa bàn Đà Nẵng</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="{{asset('assets/frontends/images/shipping-icon/Online-Order.png')}}" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Đặt hàng online</h5>
                        <p>Bạn có thể đặt hàng trực tuyến trên web của chúng tôi</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="{{asset('assets/frontends/images/shipping-icon/Freshness.png')}}" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Dịch vụ tại nhà</h5>
                        <p>Dịch vụ chăm sóc khách hàng tại chỗ</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="{{asset('assets/frontends/images/shipping-icon/Made-By-Artists.png')}}" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Chất lượng sản phẩm</h5>
                        <p>Với chúng tôi chất lượng là hàng đầu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Shipping End-->

<!--New Product Start-->
<div class="new-product-area section-padding-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Sản phẩm và phụ kiện điện thoại mới về</h2>
                    <p>Những chiếc điện thoại thông minh và phụ kiện sẽ là những trợ thủ đắc lực của bạn trong cuộc sống và công việc.</p>
                </div>
            </div>
        </div>
        <div class="product-wrapper">
            <div class="swiper-container product-active">
                <div class="swiper-wrapper">

                    @isset($dataNewPets)
                    @foreach($dataNewPets as $dataNewPet)
                    <div class="swiper-slide">
                        <div class="single-product">
                            <div class="product-image">
                                <a href="{{route('product.detailproduct', $dataNewPet->product_id )}}">
                                    <img style="height: 340px; width: 100%; object-fit: cover; " src="{{$dataNewPet->getMainImage->link_image}}" alt="{{$dataNewPet->getMainImage->alt_image}}">
                                </a>
                                <span class="sticker-new soldout-title view_new_pet">Mới</span>

                                <div class="action-links">
                                    <form>
                                        @csrf
                                        <input type="hidden" id="wishlist_url_{{$dataNewPet->product_id}}" value="{{route('product.detailproduct', $dataNewPet->product_id )}}">
                                        <input type="hidden" id="wishlist_name_{{$dataNewPet->product_id}}" value="{{$dataNewPet->product_name}}">
                                        <input type="hidden" id="wishlist_price_{{$dataNewPet->product_id}}" value="{{number_format($dataNewPet->getArchive->price)}}">
                                        <input type="hidden" id="wishlist_description_{{$dataNewPet->product_id}}" value="{{ $dataNewPet->product_description }}">
                                        <input type="hidden" id="wishlist_image_{{$dataNewPet->product_id}}" value="{{asset($dataNewPet->getMainImage->link_image)}}">
                                        <input type="hidden" id="wishlist_quantity_{{$dataNewPet->product_id}}" value="{{$dataNewPet->getArchive->quantity}}">
                                    </form>
                                    <ul>
                                        <li><a id="{{$dataNewPet->product_id}}" data-tooltip="tooltip" data-placement="left" title="Thêm" class="checkLoginAuth addCartItem"><i class="icon-shopping-bag"></i></a></li>
                                        <li><a id="{{$dataNewPet->product_id}}" data-tooltip="tooltip" data-placement="left" title="So sánh" class="compareButton"><i class="icon-sliders "></i></a></li>
                                        <li><a id="{{$dataNewPet->product_id}}" data-tooltip="tooltip" data-placement="left" title="yêu thích" class="checkLoginAuth wishlistButton"><i class="icon-heart"></i></a></li>
                                        <li><a href="{{ route('infor.getInfPet',$dataNewPet->product_id) }}" data-tooltip="tooltip" data-placement="left" data-id="{{$dataNewPet->product_id}}" title="Xem nhanh" class="icon_show_inf_pet"><i class="icon-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content text-center">
                                <ul class="rating">
                                    @for($i = 0; $i < 5 ; $i++) 
                                    @php if($dataNewPet->avgRating->first() != ''){
                                        if($i < round($dataNewPet->avgRating->first()->aggregate))
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
                                <h4 class="product-name"><a href="{{route('product.detailproduct', $dataNewPet->product_id )}}" class="font-weight-bold" style="font-size:1.1rem">{{$dataNewPet->product_name}}</a></h4>
                                <p class="text-break m-0 lh-base">
                                    @php
                                    $truncated = Str::limit($dataNewPet->product_description,61, '...');
                                    @endphp
                                    {{$truncated}}
                                </p>
                                <div class="price-box">
                                    <span class="current-price" {{number_format($dataNewPet->getArchive->price)}}</span>
                                        <!-- <span class="old-price">$29.00</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endisset

                </div>

                <!-- Add Arrows -->
                <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
            </div>
        </div>
    </div>
</div>
<!--New Product End-->

<!--About Start-->
<div class="about-area section-padding-4">
    <div class="container">
        <div class="row" style="align-items: center">
            <div class="col-lg-6">
                <div class="about-image">
                    <img src="images_upload/img_about_us.jpg" style="width: 100%; height: 376px; object-fit: cover;" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="title">Đôi Điều về chúng tôi</h2>
                    <p>Với mong muốn được đồng hành, truyền cảm hứng và khuyến khích các bạn nam giới trẻ dám bước ra khỏi vùng an toàn để tự do, tự tin thể hiện chính mình theo phong cách phù hợp với bản thân. Thương hiệu điện thoại HERO đầu tư tâm huyết nghiên cứu thiết kế chi tiết từng sản phẩm để có thể mang lại những trải nghiệm mới cho khách hàng, cũng là thông điệp muốn nhắn nhủ đến các bạn trẻ hãy cho bản thân trải nghiệm, dám thay đổi, bứt phá để vươn lên.
                    </p>
                    <ul>
                        <li> Sản phẩm và chất lượng luôn được đặt lên hàng đầu. </li>
                        <li> Phương châm: "Khách hàng là thượng đế". </li>
                    </ul>
                    <div class="about-btn">
                        <a href="" class="btn btn-orange btn-round">Liên hệ với chùng tôi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--About End-->

<!--New list Product Start-->
<div class="features-product-area section-padding-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Nổi Bật</h2>
                    <p>Được nhiều người xem nhất trong thời gian gần đây.</p>
                </div>
            </div>
        </div>
        <div class="product-wrapper">
            <div class="product-tab-menu">
                <ul class="nav justify-content-center" role="tablist">
                    <li>
                        <a class="active" data-toggle="tab" href="#tab1" role="tab">Điện thoại</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab2" role="tab">Phụ kiện</a>
                    </li>
                    <!-- <li>
                        <a data-toggle="tab" href="#tab3" role="tab">Dịch vụ</a>
                    </li> -->
                </ul>
            </div>

            <div class="tab-content product-items-tab">
                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                    <div class="swiper-container product-active">
                        <div class="swiper-wrapper">
                            @isset($arrlists)
                            @foreach ($arrlists as $arrliststPet)
                            <div class="swiper-slide">
                                @foreach ($arrliststPet as $itemPet)
                                <div class="single-product">
                                    <div class="product-image">
                                        <a href="{{route('product.detailproduct',$itemPet->product_id)}}">
                                            <img style="height: 340px; width: 100%; object-fit: cover; " src="{{$itemPet->getMainImage->link_image}}" alt="">
                                        </a>

                                        <div class="action-links">
                                            <form>
                                                @csrf
                                                <input type="hidden" id="wishlist_url_{{$itemPet->product_id}}" value="{{route('product.detailproduct', $itemPet->product_id )}}">
                                                <input type="hidden" id="wishlist_name_{{$itemPet->product_id}}" value="{{$itemPet->product_name}}">
                                                <input type="hidden" id="wishlist_price_{{$itemPet->product_id}}" value="{{number_format($itemPet->getArchive->price)}}">
                                                <input type="hidden" id="wishlist_description_{{$itemPet->product_id}}" value="{{ $itemPet->product_description }}">
                                                <input type="hidden" id="wishlist_image_{{$itemPet->product_id}}" value="{{asset($itemPet->getMainImage->link_image)}}">
                                                <input type="hidden" id="wishlist_quantity_{{$itemPet->product_id}}" value="{{$itemPet->getArchive->quantity}}">
                                            </form>
                                            <ul>
                                                <li><a id="{{$itemPet->product_id}}" data-tooltip="tooltip" data-placement="left" title="Thêm" class="checkLoginAuth addCartItem"><i class="icon-shopping-bag"></i></a></li>
                                                <li><a id="{{$itemPet->product_id}}" data-tooltip="tooltip" data-placement="left" title="So sánh" class="compareButton"><i class="icon-sliders"></i></a></li>
                                                <li><a id="{{$itemPet->product_id}}" data-tooltip="tooltip" data-placement="left" title="Yêu thích" class="checkLoginAuth wishlistButton"><i class="icon-heart"></i></a></li>
                                                <li><a href="{{ route('infor.getInfPet',$itemPet->product_id) }}" data-tooltip="tooltip" data-placement="left" title="Xem nhanh" class="icon_show_inf_pet"><i class="icon-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content text-center">
                                        <ul class="rating">
                                            @for($i = 0; $i < 5 ; $i++) @php if($itemPet->avgRating->first() != ''){
                                                if($i < round($itemPet->avgRating->first()->aggregate))
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
                                        <h4 class="product-name"><a href="{{route('product.detailproduct',$itemPet->product_id)}}" class="font-weight-bold" style="font-size:1.1rem">{{$itemPet->product_name}}</a></h4>
                                        <p class="text-break m-0 lh-base">
                                            @php
                                            $truncated = Str::limit($itemPet->product_description,61, '...');
                                            @endphp
                                            {{$truncated}}
                                        </p>
                                        <div class="price-box">
                                            <span class="current-price" {{number_format($itemPet->getArchive->price)}}</span>
                                                <!-- <span class="old-price">$29.00</span> -->
                                        </div>
                                    </div>
                                </div>
                                @endforeach;
                            </div>
                            @endforeach
                            @endisset
                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab2" role="tabpanel">
                    <div class="swiper-container product-active">
                        <div class="swiper-wrapper">
                            @isset($arrlistsNotPets)
                            @foreach ($arrlistsNotPets as $arrlist)
                            <div class="swiper-slide">
                                @foreach ($arrlist as $item)
                                <div class="single-product">
                                    <div class="product-image">
                                        <a href="{{route('product.detailproduct',$item->product_id)}}">
                                            <img style="height: 340px; width: 100%; object-fit: cover; " src="{{$item->getMainImage->link_image}}" alt="">
                                        </a>

                                        <div class="action-links">
                                            <form>
                                                @csrf
                                                <input type="hidden" id="wishlist_url_{{$item->product_id}}" value="{{route('product.detailproduct', $item->product_id )}}">
                                                <input type="hidden" id="wishlist_name_{{$item->product_id}}" value="{{$item->product_name}}">
                                                <input type="hidden" id="wishlist_price_{{$item->product_id}}" value="{{number_format($item->getArchive->price)}}">
                                                <input type="hidden" id="wishlist_description_{{$item->product_id}}" value="{{ $item->product_description }}">
                                                <input type="hidden" id="wishlist_image_{{$item->product_id}}" value="{{asset($item->getMainImage->link_image)}}">
                                                <input type="hidden" id="wishlist_quantity_{{$item->product_id}}" value="{{$item->getArchive->quantity}}">
                                            </form>
                                            <ul>
                                                <li><a id="{{$item->product_id}}" data-tooltip="tooltip" data-placement="left" title="Thêm" class="checkLoginAuth addCartItem"><i class="icon-shopping-bag"></i></a></li>
                                                <li><a id="{{$item->product_id}}" data-tooltip="tooltip" data-placement="left" title="So sánh" class="compareButton"><i class="icon-sliders"></i></a></li>
                                                <li><a id="{{$item->product_id}}" data-tooltip="tooltip" data-placement="left" title="Yêu thích" class="checkLoginAuth wishlistButton"><i class="icon-heart"></i></a></li>
                                                <li><a href="{{ route('infor.getInfPet',$item->product_id) }}" data-tooltip="tooltip" data-placement="left" title="Xem nhanh" class="icon_show_inf_pet"><i class="icon-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content text-center">
                                        <ul class="rating">
                                            @for($i = 0; $i < 5 ; $i++) @php if($item->avgRating->first() != ''){
                                                if($i < round($item->avgRating->first()->aggregate))
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
                                        <h4 class="product-name"><a href="{{route('product.detailproduct',$item->product_id)}}" class="font-weight-bold" style="font-size:1.1rem">{{$item->product_name}}</a></h4>
                                        <p class="text-break m-0 lh-base">
                                            @php
                                            $truncated = Str::limit($item->product_description,61, '...');
                                            @endphp
                                            {{$truncated}}
                                        </p>
                                        <div class="price-box">
                                            <span class="current-price" {{number_format($item->getArchive->price)}}</span>
                                                <!-- <span class="old-price">$29.00</span> -->
                                        </div>
                                    </div>
                                </div>
                                @endforeach;
                            </div>
                            @endforeach
                            @endisset
                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--New list Product End-->

<!--Blog Start-->
<div class="blog-area blog-bg section-padding-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Bài viết của mọi người</h2>
                    <p>
                        Những vào viết của người dùng mới nhất được chúng thôi cập nhật ở đây
                    </p>
                </div>
            </div>
        </div>
        <div class="blog-wrapper">
            <div class="swiper-container blog-active">
                <div class="swiper-wrapper">
                    @foreach($posts as $item)
                    <div class="swiper-slide">
                        <div class="single-blog">
                            <div class="blog-image">
                                <a href="{{route('post.detail', $item->id)}}">
                                    <img src="{{asset($item->p_link_image)}}" alt="" style="width:372px; height:223px; object-fit: cover;">
                                </a>
                            </div>
                            <div class="blog-content">
                                <h4 class="title"><a href="{{route('post.detail', $item->id)}}">{{ Str::limit($item->p_title,35, '...') }}</a>
                                </h4>
                                <div class="articles-date">
                                    <p>Tác giả <span> {{$item->getUser->name}} / {{date_format($item->created_at, 'd-m-y H:i')}} </span></p>
                                </div>
                                <div class="blog-footer">
                                    <a class="more" href="{{route('post.detail', $item->id)}}">Tiếp tục đọc</a>
                                    <p class="comment-count"><i class="icon-message-circle"></i>{{$item->getComment->count()}}</p>
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
<!--Blog End-->

@endsection

@section('javascript_page')
<script>
    $(document).ready(function() {

        $("body").on('click', '.wishlistButton', function(e) {

            let id = $(this).attr('id');
            if ('{{Auth::check()}}') {
                add_wishList(id);
            }
        });

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
                        }
                    }
                })
            }
        });

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