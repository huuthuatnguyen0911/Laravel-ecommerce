@extends('admins/masterlayoutadmin')

@section('main_title')
{{$user->name}}
@endsection

@section('style_page_main')
<style>

</style>
@endsection

@section('main_content')
<div class="container-fluid mt-5">
    <div class="page-head"></div>
    <div class="row">
        <div class="col-lg-3 col-sm-12">
            <div class="card m-b-30 border-0">
                <!-- <div class="row text-center text-white profile-block" style="height: 100px;">
                    <div class="col-4 align-self-center">
                        <a href="#">
                            <i class="fa fa-phone"></i>
                        </a>
                    </div>
                    <div class="col-4 ml-auto align-self-center">
                        <a href="#">
                            <i class="fa fa-cog"></i>
                        </a>
                    </div>
                </div> -->
                <div class="card-body pro-img mx-auto text-center">
                    <img src="{{asset($user->avatar)}}" alt="" class="rounded-circle mx-auto d-block">
                </div>
                <div class="text-center">
                    <h5>{{$user->name}}</h5>
                    <p class="text-muted mb-0 mt-0">
                        @if($user->role_id == 1)
                        Quản lý
                        @else
                        Nhân viên
                        @endif
                    </p>
                </div>
                <div class="row text-center profile-block" style="justify-content: center;">
                    <div class="col-6 align-self-center py-3">
                        <p class="profile-count mb-0 mt-0">{{$user->getTransport->count()}}</p>
                        <p class="mb-0">Đơn hàng</p>
                    </div>
                </div>
            </div>
            <!-- liên hệ trái -->
            <div class="row mt-3">
                <div class="col-lg-12 col-sm-12">
                    <div class="card m-b-30 contact">
                        <div class="card-body">
                            <h6 class="header-title pb-3">Contact</h6>
                            <ul class="list-unstyled">
                                <li class=""><i class="fa fa-phone mr-2"></i> <b> phone </b> : {{$user->getInfor->phone}}</li>
                                <li class="mt-2"><i class="fa fa-envelope-o mt-2 mr-2"></i> <b> Email </b> : {{$user->email}}</li>
                                <li class="mt-2"><i class="fa fa-map-marker mt-2 mr-2"></i> <b>Địa chỉ</b> :
                                    @isset($user->getInfor->getDistrict->_name)
                                    {{$user->getInfor->getDistrict->_name}} -
                                    @endisset
                                    @isset($user->getInfor->getProvince->_name)
                                    {{$user->getInfor->getProvince->_name}}
                                    @endisset
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-sm-12">
            <div class="card-title tab-2">
                <!-- <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" href="#about" data-toggle="tab" aria-expanded="false"><i class="ti-user mr-2"></i>Thông tin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#settings" data-toggle="tab" aria-expanded="false"><i class="ti-settings mr-2"></i>Cài đặt</a>
                    </li>
                </ul> -->
                <div class="tab-content p-4 bg-white">
                    <div class="tab-pane active p-4" id="about">
                        <div class="row justify-content-center">
                            <div class="col-md-12  profile-detail">
                                <div class="text-center">
                                    <i class="fa fa-graduation-cap"></i>
                                    <h5>Thông tin cá nhân</h5>
                                    <div class="profile-border my-3"></div>
                                    <p class="detail-text">
                                        {{$user->getInfor->content}}
                                    </p>

                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <div class="presonal-inform">
                                            <ul class="list-unstyled">
                                                <li><b>Tên:</b>{{$user->name}}</li>
                                                <li><b>SĐT:</b>{{$user->getInfor->phone}}</li>
                                                <li><b>Email:</b>{{$user->email}}</li>
                                                <li><b>Địa chỉ:</b>
                                                    @isset($user->getInfor->street)
                                                    {{$user->getInfor->street}} -
                                                    @endisset
                                                    @isset($user->getInfor->getWard->_name )
                                                    {{$user->getInfor->getWard->_name}} -
                                                    @endisset
                                                    @isset($user->getInfor->getDistrict->_name )
                                                    {{$user->getInfor->getDistrict->_name}} -
                                                    @endisset
                                                    @isset($user->getInfor->getProvince->_name)
                                                    {{$user->getInfor->getProvince->_name}}
                                                    @endisset
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('javascript_page')
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

<script src="{{asset('plugins/tinymce/tinymce.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {})
</script>

@endsection