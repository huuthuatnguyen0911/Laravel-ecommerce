@extends('admins/masterlayoutadmin')

@section('main_title')
Thể loại
@endsection

@section('status_avtive_nav_category')
active
@endsection

@section('main_content')
<div class="container-fluid box_main_category">
    <!-- <div class="page-head">
        <h4 class="mt-2 mb-2">Categories</h4>
    </div> -->
    <div class="edit-table mt-5">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3" style=" align-items: center; ">
                            <div class="col-md-4">
                                <h5 class="header-title font-weight-bold">Thể loại sản phẩm</h5>
                                <!--<p class="text-muted">Add toolbar column with edit and delete buttons.</p> -->
                            </div>
                            <div class="col-md-4">
                                <!-- search -->
                                <form action="{{ route('category.index') }}" method="GET" id="formSearchCategory">
                                    <input type="text" id="searchInputCategory" value="@isset( $keySearchCategory) {{$keySearchCategory}} @endisset" class="form-control" name="keySearchCategory" placeholder="Nhập tên thể loại">
                                </form>
                            </div>
                            <div class="col-md-4 text-right ">
                                <!-- Button to Open the Modal add -->
                                <button href="{{route('category.store')}}" type="button" class="btn btn-primary btn_add_category " data-toggle="modal" data-target="#model_form">
                                    <i class="fa fa-plus"></i>
                                    Thêm thể loại
                                </button>
                            </div>
                        </div>
                        <div class="">
                            <table class="table table-striped" id="my-table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>ID thể loại</th>
                                        <th>ảnh đại diện</th>
                                        <th>Tên thể loại</th>
                                        <th>Mô tả</th>
                                        <th>Tổng sản phẩm</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody ID="tableBodyCategory">
                                    @if( isset($categories) )
                                    @foreach($categories as $category)
                                    <tr class="category-{{$category->category_id}} box_category_main  ">
                                        <td>{{$loop->index +1}}</td>
                                        <td id="id_category_{{$category->category_id}}">{{$category->category_id}}</td>
                                        <td>
                                            <div class="text-left">
                                                <img id="avt_category_{{$category->category_id}}" src="{{asset($category->category_avatar)}}" style="height: 50px;" class="rounded" alt="img {{$category->category_name}}">
                                            </div>
                                        </td>
                                        <td id="name_category_{{$category->category_id}}">{{$category->category_name}}</td>
                                        <td id="ds_category_{{$category->category_id}}" class="d-inline-block text-truncate " style="max-width: 200px;">{{$category->category_description}}</td>
                                        <td id="tt_pr_category_{{$category->category_id}}">{{$category->childrenProducts ? $category->childrenProducts->count() : 0 }}</td>
                                        <td class="">
                                            <div class="text-right">
                                                <a href="" data-id="{{$category->category_id}}" name="editCategory" class="btn btn-outline-success btn_seen_category"><i class=" mdi mdi-eye"></i></a>
                                                <a href="{{route('category.updateUploadFile',$category->category_id)}}" data-id="{{$category->category_id}}" name="seenCategory" class="btn btn-outline-primary btn_edit_category"><i class="fa fa-edit"></i></a>
                                                <a href="{{route('category.destroy',$category->category_id)}}" data-id="{{$category->category_id}}" name="deleteCategory" class="btn btn-outline-danger btn_delete_category"> <i class="fa  fa-trash-o"></i> </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endisset
                                </tbody>
                            </table>

                        </div>
                        <!-- tao phần phân trang -->
                        <div class="box_pagination_main">
                            @isset($categories)
                            {{ $categories->appends(request()->all())->links() }}
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>

    <!-- Modal add edit -->
    <div class="modal fade" id="model_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="model_formLabel">
                        Xem thể loại
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="form_category">
                        {{ csrf_field() }}
                        <!-- ID thể loại -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="inputGroup-sizing-theLoai">ID thể loại</span>
                            </div>
                            <input type="text" id="idCategory" name="idCategory_n" class="form-control" aria-label="idTheLoai" readonly aria-describedby="inputGroup-sizing-theLoai">
                        </div>
                        <!-- ảnh đại diện -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="inputGroup-sizing-avatar">Ảnh đại diện</span>
                            </div>
                            <div class="text-left" id="avatarCategory">
                                <img id="" src="" class="rounded mx-auto d-block" style="width:100%; height:100%" alt="">
                            </div>
                            <input type="file" id="avatarCategoryform" name="avatarCategory_n" class="form-control" hidden aria-label="avatar" aria-describedby="inputGroup-sizing-avatar">
                        </div>
                        <!-- tên thể loại -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="inputGroup-sizing-tenTheLoai">Tên thể loại</span>
                            </div>
                            <input type="text" id="nameCategory" name="nameCategory_n" class="form-control" aria-label="tenTheLoai" readonly aria-describedby="inputGroup-sizing-tenTheLoai">
                        </div>
                        <!-- Mô tả -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="inputGroup-sizing-description">Mô tả</span>
                            </div>
                            <!-- <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default"> -->
                            <textarea id="dsCategory" name="dsCategory_n" class="form-control" cols="30" rows="5" readonly aria-label="description" aria-describedby="inputGroup-sizing-description"></textarea>
                        </div>
                        <!-- Tổng sản phẩm -->
                        <div class="input-group mb-3 box_total_Category_product">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="inputGroup-sizing-default">Tổng sản phẩm</span>
                            </div>
                            <input type="text" id="totalPrCategory" name="totalPrCategory_n" class="form-control" aria-label="Default" readonly aria-describedby="inputGroup-sizing-default">
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary btn_edit_form" hidden>Sửa</button>
                            <button type="submit" class="btn btn-primary btn_add_form" hidden>Thêm</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript_page')
<!-- <h1>Tui javascript đây</h1> -->
<script src="{{asset('assets/admins/my_js_admin/js_category.js')}}"></script>
<script src="{{asset('assets/admins/my_js_admin/ajax/ajax__category.js')}}"></script>
@endsection