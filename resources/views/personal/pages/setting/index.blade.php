@extends('personal/masterLayout')

@section('main_title')
Thiết lập
@endsection

@section('active_page_main_setting')
active
@endsection

@section('main_content_page')
<div class="container ">

    <div class="box_setting_infor ml-auto mr-auto mt-4" id="settings" style="width: 70% ;">
        <div class="mb-3 border-bottom">
            <h2 class="change_light">Thiết lập</h2>
        </div>
        <form action="{{route('admin.profile.edit',Auth::user()->id)}}" method="POST" class="form-horizontal form-material">
            @csrf
            <div class="form-group">
                <textarea rows="5" placeholder="Mô tả cá nhân" name="inputContent" class="form-control form-control-line">{{Auth::user()->getInfor->content}}</textarea>
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

    <div class="box_setting_infor ml-auto mr-auto mt-4" id="settings" style="width: 70% ;">
        <div class="mb-3 border-bottom">
            <h2 class="change_light">Đổi mật khẩu</h2>
        </div>
        <form action="{{route('personal.setting.password')}}" method="POST" class="form-horizontal form-material" id="formPassword">
            @csrf
            <input type="hidden" name="idUser" value="{{Auth::user()->id}}">
            <div class="form-group row">
                <div class="col-md-6">
                    <input type="password" placeholder="Nhập mật khẩu" class="form-control form-control-line" name="inputPassword" id="inputPassword">
                </div>

                <div class="col-md-6">
                    <input type="password" placeholder="Nhập lại mật khẩu" class="form-control form-control-line" name="" id="inputRePassword">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-info">Đổi</button>
            </div>

        </form>
    </div>

</div>
@endsection

@section('main_js_page')

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $('#settings').on('change', '#selectProvince', function(e) {
            e.preventDefault();
            let idProvince = $(this).val();
            $.ajax({
                url: '{{route("personal.setting.index")}}',
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
                url: '{{route("personal.setting.index")}}',
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

        $('body').on('submit', '#formPassword', function(e) {
            let valPass = $('#inputPassword').val();
            let rePass = $('#inputRePassword').val();

            if(valPass != rePass)
            {
                e.preventDefault();
                alert('Mật khẩu không đúng');
                $('#inputPassword').val('');
                $('#inputRePassword').val('');
            }

            if(valPass == '' && rePass == '')
            {
                e.preventDefault();
                $('#inputPassword').focus();
                $('#inputRePassword').focus();
                alert('Hãy nhập đầy đủ thông tin thông tin');
                
            } 

        })
    })
</script>
@endsection