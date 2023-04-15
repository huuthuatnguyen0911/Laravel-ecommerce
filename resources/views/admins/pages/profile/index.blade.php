@extends('admins/masterlayoutadmin')

@section('main_title')
{{Auth::user()->name}}
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
                    <img src="{{asset(Auth::user()->avatar)}}" alt="" class="rounded-circle mx-auto d-block">
                </div>
                <div class="text-center">
                    <h5>{{Auth::user()->name}}</h5>
                    <p class="text-muted mb-0 mt-0">
                        @if(Auth::user()->role_id == 1)
                        Quản lý
                        @else
                        Nhân viên
                        @endif
                    </p>
                </div>
                <div class="row text-center profile-block" style="justify-content: center;">
                    <div class="col-6 align-self-center py-3">
                        <p class="profile-count mb-0 mt-0">{{Auth::user()->getTransport->count()}}</p>
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
                                <li class=""><i class="fa fa-phone mr-2"></i> <b> phone </b> : {{Auth::user()->getInfor->phone}}</li>
                                <li class="mt-2"><i class="fa fa-envelope-o mt-2 mr-2"></i> <b> Email </b> : {{Auth::user()->email}}</li>
                                <li class="mt-2"><i class="fa fa-map-marker mt-2 mr-2"></i> <b>Địa chỉ</b> : {{Auth::user()->getInfor->getDistrict->_name}} , {{Auth::user()->getInfor->getProvince->_name}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-sm-12">
            <div class="card-title tab-2">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" href="#about" data-toggle="tab" aria-expanded="false"><i class="ti-user mr-2"></i>Thông tin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#settings" data-toggle="tab" aria-expanded="false"><i class="ti-settings mr-2"></i>Cài đặt</a>
                    </li>
                </ul>
                <div class="tab-content p-4 bg-white">
                    <div class="tab-pane active p-4" id="about">
                        <div class="row justify-content-center">
                            <div class="col-md-12  profile-detail">
                                <div class="text-center">
                                    <i class="fa fa-graduation-cap"></i>
                                    <h5>Thông tin cá nhân</h5>
                                    <div class="profile-border my-3"></div>
                                    <p class="detail-text">
                                        {{Auth::user()->getInfor->content}}
                                    </p>

                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <div class="presonal-inform">
                                            <ul class="list-unstyled">
                                                <li><b>Tên:</b>{{Auth::user()->name}}</li>
                                                <li><b>SĐT:</b>{{Auth::user()->getInfor->phone}}</li>
                                                <li><b>Email:</b>{{Auth::user()->email}}</li>
                                                <li><b>Địa chỉ:</b>
                                                    @if(Auth::user()->getInfor->street != '')
                                                    {{Auth::user()->getInfor->street}} -
                                                    @endif
                                                    @if(Auth::user()->getInfor->getWard->_name != '')
                                                    {{Auth::user()->getInfor->getWard->_name}} -
                                                    @endif
                                                    @if(Auth::user()->getInfor->getDistrict->_name != '')
                                                    {{Auth::user()->getInfor->getDistrict->_name}} -
                                                    @endif
                                                    {{Auth::user()->getInfor->getProvince->_name}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="settings">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card-body">
                                    <form action="{{route('admin.profile.edit',Auth::user()->id)}}" method="POST" class="form-horizontal form-material">
                                        @csrf
                                        <div class="form-group">
                                            <textarea rows="5" placeholder="Mô tả cá nhân" name="inputContent" class="form-control form-control-line" >{{Auth::user()->getInfor->content}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" placeholder="Họ và tên" name="inputName" value="{{Auth::user()->name}}" class="form-control form-control-line">
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <input type="email" placeholder="Email" class="form-control form-control-line" value="{{Auth::user()->email}}" disabled id="inputEmail">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="inputPhone" value="{{Auth::user()->getInfor->phone}}" placeholder="Số điện thoại" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <select class="custom-select" name="selectProvince" id="selectProvince">
                                                    @foreach($provice as $item)
                                                    @if($item->id == Auth::user()->getInfor->id_province)
                                                    <option value="{{$item->id}}" selected>{{$item->_name}}</option>
                                                    @else
                                                    <option value="{{$item->id}}">{{$item->_name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <select class="custom-select" name="selectDistrict" id="selectDistrict">
                                                    @foreach($district as $item)
                                                    @if($item->id == Auth::user()->getInfor->id_district)
                                                    <option value="{{$item->id}}" selected>{{$item->_name}}</option>
                                                    @else
                                                    <option value="{{$item->id}}">{{$item->_name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="custom-select" name="selectWard" id="selectWard">
                                                    @foreach($ward as $item)
                                                    @if($item->id == Auth::user()->getInfor->id_ward)
                                                    <option value="{{$item->id}}" selected>{{$item->_name}}</option>
                                                    @else
                                                    <option value="{{$item->id}}">{{$item->_name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" placeholder="tổ, thôn, đường...." value="{{Auth::user()->getInfor->street}}" class="form-control form-control-line" name="inputStreet" id="inputStreet">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info">Cập nhật</button>
                                        </div>

                                    </form>
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
    $(document).ready(function() {
        $('#settings').on('change', '#selectProvince', function(e) {
            e.preventDefault();
            let idProvince = $(this).val();
            $.ajax({
                url: '{{route("admin.profile.index")}}',
                type: 'GET',
                data: {
                    code: 'searchProvince',
                    idProvince: idProvince,
                },
                success: (data) => {
                    $('#selectDistrict').html(data[0]);
                    $('#selectWard').html(data[1]);
                }
            })
        })

        $('#settings').on('change', '#selectDistrict', function(e) {
            e.preventDefault();
            let idDistrict = $(this).val();
            let idProvince = $('#selectProvince').val();

            $.ajax({
                url: '{{route("admin.profile.index")}}',
                type: 'GET',
                data: {
                    code: 'searchDistrict',
                    idProvince: idProvince,
                    idDistrict: idDistrict,
                },
                success: (data) => {
                    $('#selectWard').html(data);
                }
            })
        })
    })
</script>

@endsection