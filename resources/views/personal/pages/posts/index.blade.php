@extends('personal/masterLayout')

@section('main_title')
Bài biết
@endsection

@section('active_page_main_posts')
active
@endsection

@section('main_content_page')
<section id="main_content_posts">
    <div class="container">
        <div class="box_header">
            <h3 class="title_text change_light">Bài viết của bạn</h3>
            <a href="{{route('personal.post.create.index')}}" class="btn_add_posts change_light">
                <span>Tạo bài viết</span>
                <i class="fas fa-pencil-alt"></i>
            </a>
        </div>

        <div class="boX_content mt-5 mb-5">
            <div class="box_table_list_post">
                <table class="table table-striped" id="post_table">
                    <thead>
                        <tr>
                            <!-- <th>NO</th> -->
                            <th class="change_light" style="color: #fff">Đăng</th>
                            <th class="change_light" style="color: #fff">Tiêu đề</th>
                            <th class="change_light" style="color: #fff">Thể loại</th>
                            <th class="change_light" style="color: #fff">Thời gian tạo</th>
                            <th class="change_light" style="color: #fff">Xử lý</th>
                        </tr>
                    </thead>
                    <tbody ID="tableBodyPost">

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection

@section('main_js_page')


<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $(function() {
            var table1 = $('#post_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('personal.post.index')}}",
                columns: [{
                        data: 'p_status',
                        name: 'p_status'
                    },
                    {
                        data: 'p_title',
                        name: 'p_title'
                    },
                    {
                        data: 'p_category',
                        name: 'p_category'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'p_action',
                        name: 'p_action'
                    },
                ],

            });

        });

        // Xóa bài viết
        $('#post_table').on('click', '.btnDeletePost' ,function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    if(data == 1)
                    {
                        $('#post_table').DataTable().ajax.reload();
                    }
                }
            })
        })

        // chuyển dổi hiển thị
        $('#post_table').on('click', '.btnChangePostPrivate' ,function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                data :{
                    changeStatus: 1,
                },
                success: function(data) {
                    if(data == 1)
                    {
                        $('#post_table').DataTable().ajax.reload();
                    }
                }
            })
        })
        $('#post_table').on('click', '.btnChangePostPublic' ,function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                data :{
                    changeStatus: 0,
                },
                success: function(data) {
                    if(data == 1)
                    {
                        $('#post_table').DataTable().ajax.reload();
                    }
                }
            })
        })
    })
</script>
@endsection