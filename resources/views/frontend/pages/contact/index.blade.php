@extends('frontend/masterLayout')

@section('main_title')
Liên hệ
@endsection

@section('main_active_site_contact')
active-site
@endsection

@section('main_style_page')
<style>
</style>
@endsection

@section('main_content')

<!-- bản đổ -->
<div class="box_main_map mt-4">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3835.747040669732!2d108.24970407514141!3d15.9745811419647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31421088e365cc75%3A0x6648fdda14970b2c!2zNDcwIMSQxrDhu51uZyBUcuG6p24gxJDhuqFpIE5naMSpYSwgSG_DoCBI4bqjaSwgTmfFqSBIw6BuaCBTxqFuLCDEkMOgIE7hurVuZyA1NTAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2sus!4v1681548921550!5m2!1svi!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>


<!--Contact Start-->
<div class="contact-page section-padding-5">
    <div class="container">
        <div class="contact-info">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center">
                        <h2 class="title">Thư ngỏ</h2>
                        <p>
                            Cảm ơn bạn đã tin tưởng và ghé thăng web của chúng tôi. Chúng tôi sẵn sàng lắm nghe những góp ý từ các bạn.
                            Bạn có thể liên hệ với chúng tôi thông qua địa chỉ ở bên dưới.
                        </p>
                    </div>
                </div>
            </div>

            <div class="contact-info-content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="single-contact-info text-center">
                            <i class="fa fa-fax"></i>
                            <h4 class="title"> Địa chỉ </h4>
                            <p>470 Trần Đại Nghĩa, Ngũ Hành Sơn, Đà Nẵng</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="single-contact-info text-center">
                            <i class="fa fa-phone"></i>
                            <h4 class="title"> Số điện thoại </h4>
                            <p><a href="tel:7162981822"> 0818-184-841 </a></p>
                            <p><a href="tel:7162981822"> 0216-298-822 </a></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="single-contact-info text-center">
                            <i class="fa fa-envelope"></i>
                            <h4 class="title"> Địa chỉ email </h4>
                            <p><a href="mailto:info@example.com"> heroshop@gmail.com </a></p>
                            <p><a href="mailto:info@kngu.com"> infohero@gmail.com </a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="contact-form">
            <form id="contact-form" action="assets/php/contact.php" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-form">
                            <input type="text" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-form">
                            <input type="email" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="single-form">
                            <input type="text" name="subject" placeholder="Subject">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="single-form">
                            <textarea name="message" placeholder="Message"></textarea>
                        </div>
                    </div>
                    <p class="form-message"></p>
                    <div class="col-md-12">
                        <div class="single-form text-center">
                            <button class="btn btn-dark">Message Send</button>
                        </div>
                    </div>
                </div>
            </form>
        </div> -->
    </div>
</div>
<!--Contact End-->

@endsection

@section('javascript_page')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    });
</script>
@endsection