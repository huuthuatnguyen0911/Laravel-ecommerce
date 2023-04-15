@extends('admins/masterlayoutadmin')

@section('main_title')
Thống kê
@endsection

@section('status_avtive_nav_dashboard')
active
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-head">
        <h4 class="mt-2 mb-2">Thống kê</h4>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="row">
                <div class="col-lg-3 col-sm-3">
                    <div class="widget-box bg-white m-b-30">
                        <div class="row d-flex align-items-center">
                            <div class="col-6">
                                <div class="text-center"><i class="ti ti-eye"></i></div>
                            </div>
                            <div class="col-6 text-center">
                                <h2 class="m-0 counter" id="idCountUserOnline">0</h2>
                                <p class="mb-0">Đang truy cập</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <div class="widget-box bg-white m-b-30">
                        <div class="row d-flex align-items-center text-center">
                            <div class="col-6">
                                <div class="text-center"><i class="ti ti-user"></i></div>
                            </div>
                            <div class="col-6 text-center">
                                <h2 class="m-0 counter">{{$countUser}}</h2>
                                <p class="mb-0">Người dùng</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <div class="widget-box bg-white m-b-30">
                        <div class="row d-flex align-items-center">
                            <div class="col-6">
                                <div class="text-center"><i class="fa fa-shopping-cart text-light "></i></div>
                            </div>
                            <div class="col-6 text-center">
                                <h2 class="m-0 counter">{{$toltaOder}}</h2>
                                <p class="mb-0">Tổng Đơn hàng</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <div class="widget-box bg-white m-b-30">
                        <div class="row d-flex align-items-center">
                            <div class="col-6">
                                <div class="text-center"><i class="fa fa-comment-o"></i></div>
                            </div>
                            <div class="col-6 text-center">
                                <h2 class="m-0 counter">{{$countComment}}</h2>
                                <p class="mb-0">Phản hồi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    <div>
        <h4 class="mt-4 mb-2 text-center">Top 10 sản phẩm bán chạy</h4>
        <canvas id="myChart" style="width:100%"></canvas>
    </div>
</div>
@endsection

@section('javascript_page')

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>

<script>
    // readltime xem người dùng
    let countUserOnline = 0;

    // hiển thị số người online
    function showUserOnline(countUserOnline) {
        $('#idCountUserOnline').text(countUserOnline);
    }

    // lọc ra những người dùng
    // function getUser()

    function visitsTody() {
        Echo.join('joining')
            .here((user) => {
                let arrNewUser = user.filter((e) => {
                    return e.role_id == 0;
                });
                countUserOnline = arrNewUser.length;

                showUserOnline(countUserOnline);
            })
            .joining((user) => {
                if (user.role_id == 0) {
                    countUserOnline++;
                    showUserOnline(countUserOnline);
                }
            })
            .leaving((user) => {
                if (user.role_id == 0) {
                    countUserOnline--;
                    showUserOnline(countUserOnline);
                }

            })
    }
    visitsTody()

    // biểu đồ sản phẩm
    function showChartBestProduct() {
        let xValues = [];
        let yValues = [];

        let test = 'hello';

        @foreach($arrNameProduct as $name)
        xValues.push('{{$name}}');
        @endforeach

        @foreach($arrTotalQuantity as $quantity)
        yValues.push('{{$quantity}}');
        @endforeach

        let chan = '';

        const dataChart = {
            labels: xValues,
            datasets: [{
                label: 'Dữ liệu bán hàng',
                data: yValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.4)',
                    'rgba(255, 159, 64, 0.4)',
                    'rgba(255, 205, 86, 0.4)',
                    'rgba(75, 192, 192, 0.4)',
                    'rgba(54, 162, 235, 0.4)',
                    'rgba(153, 102, 255, 0.4)',
                    'rgba(201, 203, 207, 0.4)',
                    'rgba(65, 184, 131, 0.4)',
                    'rgba(243, 79, 63, 0.4)',
                    'rgba(237, 109, 175, 0.4)',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    'rgb(65, 184, 131)',
                    'rgb(243, 79, 63)',
                    'rgb(237, 109, 175)',
                ],
                borderWidth: 1
            }]
        };

        new Chart("myChart", {
            type: "bar",
            data: dataChart,
            options: {
                indexAxis: 'y',
                legend: {
                    display: false
                },
            }
        });
    }

    showChartBestProduct()
</script>
@endsection