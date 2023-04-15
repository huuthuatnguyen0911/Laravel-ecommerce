@extends('frontend/masterLayout')

@section('main_title')
Cửa hàng
@endsection

@section('main_active_site_store')
active-site
@endsection

@section('main_style_page')
<style>
    .box_main_banner {
        /* position: relative; */
    }

    .box_item_banner {
        position: relative;
    }

    .box_main_banner .box-overlay {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: 2;
    }

    .box_main_content_banner {
        position: absolute;
        top: 50%;
        left: 40%;
        transform: translate(-50%, -50%);
        text-align: left;
        z-index: 22;
    }

    .box_main_content_banner h1 {
        font-weight: 700;
        font-size: 2.5rem;
        color: #fff;
        margin: 0;
    }

    .box_main_content_banner p {
        color: #f3f3f3;
        /* margin: 0; */
    }

    .box_main_content_banner a {
        font-size: 1rem;
        color: white;
        border: 2px solid #f34f3f;
        text-decoration: none;
        transition: 0.5s;
    }

    .box_main_content_banner a:hover {
        background-color: #f34f3f;
        color: black;
    }

    .box_image_banner img {
        width: 100%;
        height: 500px;
        object-fit: cover;
    }

    .slick-dots {
        position: absolute;
        bottom: 50px;
        left: 0;
        right: 0;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }

    .slick-dots li {
        margin-right: 20px;
    }

    .slick-dots li:last-child {
        margin-right: 0;
    }

    .slick-dots li.slick-active button {
        border: 2px solid #f34f3f;
        background-color: #f34f3f;
    }

    .slick-dots li button {
        height: 14px;
        width: 14px;
        background: #e1e1e1;
        text-indent: -9999px;
        display: block;
        border: 2px solid #e1e1e1;
        border-radius: 50%;
        padding: 0;
        outline: none
    }

    .page-pagination {
        border: none;
        border-top: 1px solid #e5e5e5;
    }

    .page-pagination nav .pagination {
        justify-content: center;
    }
</style>
@endsection

@section('main_content')
<!--Shop Start-->
<div class="shop-page section-padding-6">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="shop-banner box_main_banner">

                    @foreach($dataSlides as $dataSlide)
                    <div class="box_item_banner">
                        <div class="box-overlay"></div>
                        <div class="box_image_banner">
                            <img src="{{$dataSlide->image}}" alt="">
                        </div>
                        <div class="box_main_content_banner">
                            <h1>{{$dataSlide->main_title}}</h1>
                            <p>{{$dataSlide->main_title_text}}</p>
                            <a href="{{$dataSlide->link_button}}" class="btn">xem ngay</a>
                        </div>
                    </div>
                    @endforeach
                </div>


                <!--Shop Top Bar Start-->
                <div class="shop-top-bar d-sm-flex align-items-center justify-content-between">
                    <div class="top-bar-btn">
                        <ul class="nav" role="tablist">
                            <li class="nav-item"><a class="nav-link grid active" data-toggle="tab" href="#grid" role="tab"></a></li>
                            <li class="nav-item"><a class="nav-link list" data-toggle="tab" href="#list" role="tab"></a></li>
                        </ul>
                    </div>
                    <div class="top-bar-sorter">
                        <div class="sorter-wrapper d-flex align-items-center">
                            <label>Sắp xếp theo:</label>
                            <select class="sorter wide" name="SortBy" id="SortByProducts">
                                <option value="{{Request::url()}}" default selected>--Sắp xếp sản phẩm--</option>
                                <option value="{{Request::url()}}?sort_by=newest">Mới nhất</option>
                                <option value="{{Request::url()}}?sort_by=oldest">Cũ nhất</option>
                                <option value="{{Request::url()}}?sort_by=kytu_az">A đến Z</option>
                                <option value="{{Request::url()}}?sort_by=kytu_za">Z đến A</option>
                            </select>
                            </select>
                        </div>
                    </div>
                </div>
                <!--Shop Top Bar End-->


                <div class="tab-content" id="tableViewList">
                    <!-- theo grid -->
                    <div class="tab-pane fade show active" id="grid" role="tabpanel">
                        <div class="row">
                            @foreach($dataPets as $dataPet)
                            <div class="col-lg-4 col-sm-6">
                                <div class="single-product">
                                    <div class="product-image">
                                        <a href="{{route('product.detailproduct', $dataPet->product_id )}}" class="linkShowDetailsProduct">
                                            <img style="height: 340px; width: 100%; object-fit: cover; " src="{{asset($dataPet->getMainImage->link_image)}}" alt="{{$dataPet->getMainImage->alt_image}}">
                                        </a>

                                        <!-- <span class="sticker-new soldout-title">Soldout</span> -->

                                        <div class="action-links">

                                            <form>
                                                @csrf
                                                <input type="hidden" id="wishlist_url_{{$dataPet->product_id}}" value="{{route('product.detailproduct', $dataPet->product_id )}}">
                                                <input type="hidden" id="wishlist_name_{{$dataPet->product_id}}" value="{{$dataPet->product_name}}">
                                                <input type="hidden" id="wishlist_price_{{$dataPet->product_id}}" value=">{{number_format($dataPet->getArchive->price)}}">
                                                <input type="hidden" id="wishlist_description_{{$dataPet->product_id}}" value="{{ $dataPet->product_description }}">
                                                <input type="hidden" id="wishlist_image_{{$dataPet->product_id}}" value="{{asset($dataPet->getMainImage->link_image)}}">
                                                <input type="hidden" id="wishlist_quantity_{{$dataPet->product_id}}" value="{{$dataPet->getArchive->quantity}}">
                                            </form>

                                            <ul>
                                                <li><a id="{{$dataPet->product_id}}" data-tooltip="tooltip" data-placement="left" title="Thêm" class="checkLoginAuth addCartItem"><i class="icon-shopping-bag"></i></a></li>
                                                <li><a id="{{$dataPet->product_id}}" data-tooltip="tooltip" data-placement="left" title="So sánh" class="compareButton"><i class="icon-sliders"></i></a></li>
                                                <li><a id="{{$dataPet->product_id}}" data-tooltip="tooltip" data-placement="left" title="Yêu thích" class="checkLoginAuth wishlistButton"><i class="icon-heart"></i></a></li>
                                                <li><a href="{{ route('infor.getInfPet',$dataPet->product_id) }}" data-tooltip="tooltip" data-placement="left" data-id="{{$dataPet->product_id}}" title="Xem nhanh" class="icon_show_inf_pet"><i class="icon-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content text-center">
                                        <ul class="rating">
                                            @for($i = 0; $i < 5 ; $i++) @php if($dataPet->avgRating->first() != ''){
                                                if($i < round($dataPet->avgRating->first()->aggregate))
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
                                        <h4 class="product-name"><a href="{{route('product.detailproduct', $dataPet->product_id )}}" class="font-weight-bold" style="font-size:1.1rem">{{$dataPet->product_name}}</a></h4>
                                        <p class="text-break m-0 lh-base">
                                            @php
                                            $truncated = Str::limit($dataPet->product_description,61, '...');
                                            @endphp
                                            {{$truncated}}
                                        </p>
                                        <div class="price-box">
                                            <span class="current-price">{{number_format($dataPet->getArchive->price)}}</span>
                                            <!-- <span class="old-price">$29.00</span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- theo list -->
                    <div class="tab-pane fade" id="list" role="tabpanel">
                        @foreach($dataPets as $dataPet)
                        <div class="single-product product-list">
                            <div class="product-image">
                                <a href="{{route('product.detailproduct', $dataPet->product_id )}}">
                                    <img style="height: 300px; width: 100%; object-fit: cover;" src="{{asset($dataPet->getMainImage->link_image)}}" alt="{{$dataPet->getMainImage->alt_image}}">
                                </a>

                                <div class="action-links">
                                    <ul>
                                        <li><a href="{{ route('infor.getInfPet',$dataPet->product_id) }}" data-tooltip="tooltip" data-placement="left" data-id="{{$dataPet->product_id}}" title="Xem nhanh" class="icon_show_inf_pet"><i class="icon-eye"></i></a></li>
                                        <!-- <li><a href="javascript:void(0);" data-tooltip="tooltip" data-placement="left" title="Quick View" data-toggle="modal" data-target="#exampleModal"><i class="icon-eye"></i></a></li> -->
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <ul class="rating">
                                    @for($i = 0; $i < 5 ; $i++) @php if($dataPet->avgRating->first() != ''){
                                        if($i < round($dataPet->avgRating->first()->aggregate))
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
                                <h4 class="product-name"><a href="{{route('product.detailproduct', $dataPet->product_id )}}" class="font-weight-bold" style="font-size:1.1rem">{{$dataPet->product_name}}</a></h4>
                                <div class="price-box">
                                    <span class="current-price">{{number_format($dataPet->getArchive->price)}}</span>
                                    <!-- <span class="current-price">$79.00</span> -->
                                </div>
                                <p class="text-break m-0 lh-base">
                                    @php
                                    $truncated = Str::limit($dataPet->product_description,200, '...');
                                    @endphp
                                    {{$truncated}}
                                </p>
                                <!-- <p>we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of...</p> -->

                                <ul class="action-links">
                                    <li><a id="{{$dataPet->product_id}}" class="add-cart checkLoginAuth addCartItem" title="Thêm" data-tooltip="tooltip" data-placement="top"> Thêm sản phẩm </a></li>
                                    <li><a id="{{$dataPet->product_id}}" data-tooltip="tooltip" data-placement="top" title="Yêu thích" class="wishlist checkLoginAuth wishlistButton"><i class="icon-heart"></i></a></li>
                                    <li><a id="{{$dataPet->product_id}}" data-tooltip="tooltip" data-placement="top" title="So sánh" class="compare compareButton"><i class="icon-sliders"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!--Pagination Start-->
                <div class="page-pagination">
                    {{ $dataPets->appends(request()->all())->links() }}
                </div>

            </div>
            <div class="col-lg-3">
                <div class="shop-sidebar">
                    <!--Sidebar Categories Start-->
                    <div class="sidebar-categories">
                        <h3 class="widget-title">Danh mục</h3>

                        <ul class="categories-list">
                            @foreach($tableCategorys as $tableCategory)
                            <li><a href="{{route('store.category', $tableCategory->category_id)}}">{{$tableCategory->category_name}} <span>({{$tableCategory->childrenProducts()->count()}})</span> </a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!--Sidebar Categories End-->

                    <!--Sidebar price Start-->
                    <div class="sidebar-color">
                        <h3 class="widget-title mb-2">Giá</h3>
                        <form>
                            <div class="mb-2">
                                <label for="amount" style="margin: 0;">Giá từ:</label>
                                <input type="text" id="amount" readonly style="border:0; color:#f6931f; width: 100%;">
                                <input type=hidden id="start_price" name="start_price">
                                <input type=hidden id="end_price" name="end_price">
                            </div>
                            <div id="slider-range"></div>

                            <p class="mt-3 text-center"><input type="submit" name="fillter_price" value="Áp dụng" class="btn btn-orange"></input></p>
                        </form>
                    </div>
                    <!--Sidebar price End-->

                    <!-- slider wishlist start -->
                    <div class="sidebar-post">
                        <h3 class="widget-title">Yêu thích của bạn</h3>

                        <ul class="post-items" id="roW_wishlist" style=" overflow-y: scroll ; overflow-x: hidden; height: 500px;">
                        </ul>
                    </div>
                    <!-- slider wishlist end -->

                </div>
            </div>
        </div>
    </div>
</div>
<!--Shop End-->
@endsection

@section('javascript_page')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $('.box_main_banner').slick({
            dots: true,
            infinite: true,
            speed: 1000,
            slidesToShow: 1,
            adaptiveHeight: true,
            arrows: false,
            autoplay: true,
        });

        $('body').on('change', '#SortByProducts', function(e) {
            let url = $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        })

        let valuePriceStart = Number(formatPrice('{{$minPrice}}'));
        let valuePriceEnd = Number(formatPrice('{{$maxPrice}}'));

        @if(isset($_GET['start_price']) && isset($_GET['end_price']) && $_GET['start_price'] != '' && $_GET['end_price'] != '')
        valuePriceStart = Number(formatPrice("{{$_GET['start_price']}}"));
        valuePriceEnd = Number(formatPrice("{{$_GET['end_price']}}"));
        @endif

        $("#slider-range").slider({
            range: true,
            min: Number(formatPrice('{{$minPrice}}')),
            max: Number(formatPrice('{{$maxPrice}}')),
            values: [valuePriceStart, valuePriceEnd],
            slide: function(event, ui) {
                $("#amount").val(number_format(String(ui.values[0])) + " VNĐ" + " - " + number_format(String(ui.values[1])) + " VNĐ");
                $("#start_price").val(ui.values[0]);
                $("#end_price").val(ui.values[1]);
            }
        });

        $("#amount").val(number_format(String($("#slider-range").slider("values", 0))) +
            " VNĐ - " + number_format(String($("#slider-range").slider("values", 1))) + " VNĐ");

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

        function formatPrice(number) {
            let result = number.split(/[.,,]/);
            return result[0];
        }

        $("body").on('click', '.wishlistButton', function(e) {

            let id = $(this).attr('id');
            if ('{{Auth::check()}}') {
                add_wishList(id);
            }

        });

        function view() {
            if (localStorage.getItem('data') != null) {
                let data = JSON.parse(localStorage.getItem('data'));
                data.reverse();

                for (let i = 0; i < data.length; i++) {
                    let name = data[i]['name'];
                    let price = data[i]['price'];
                    let description = data[i]['description'];
                    let image = data[i]['image'];
                    let url = data[i]['url'];

                    let getPrice = price.split('>')[1];

                    $("#roW_wishlist").append(`
                    <li>
                        <a href="${url}" style="display: block">
                            <div class="single-post">
                                <div class="post-thumb" style="flex: 1; width: 25%;">
                                    <img src="${image}" alt="" style="width:100%; height:100%; object-fit: cover;">
                                </div>
                                <div class="post-content" style="flex: 2; width: 75%;">
                                    <h5 class="post-title overfow_text">${name}</h5>
                                    <span class="date overfow_text " style="font-size:0.9rem; margin: 0;">${description}</span>
                                    <p class="overfow_text">${getPrice}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    `)
                }
            }
        }
        view();

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
                $(".alert-warning .text_msg").text("Sản phẩm đã có trong danh mục yêu thích");
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
            } else {
                let getPrice = newItem.price.split('>')[1];

                old_data.push(newItem);
                $("#roW_wishlist").append(`
                    <li>
                        <a href="${newItem.url}" style="display: block">
                            <div class="single-post">
                                <div class="post-thumb" style="flex: 1; width: 25%;">
                                    <img src="${newItem.image}" alt="" style="width:100%; height:100%; object-fit: cover;">
                                </div>
                                <div class="post-content" style="flex: 2; width: 75%;">
                                    <h5 class="post-title overfow_text">${newItem.name}</h5>
                                    <span class="date overfow_text " style="font-size:0.9rem; margin: 0;">${newItem.description}</span>
                                    <p class="overfow_text">${getPrice}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    `)
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

            $.ajax({
                url: "{{route('cart.add')}}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id_User': ' {{Auth::check() ? Auth::user()->id : ""}} ',
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
            $.ajax({
                url: '{{ route("cart.sub") }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id_user: '{{Auth::check() ? Auth::user()->id : ""}}',
                },
                success: (data) => {
                    $('#showCartList').html(data.dataHtml);
                    $('#ShowTotalPrice').text(data.total);
                    $('#showQuantityCart').text(data.count);
                    // console.log(data);
                }
            })
        }
        cartSubCurrent()

        // so sánh
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

    });
</script>
@endsection