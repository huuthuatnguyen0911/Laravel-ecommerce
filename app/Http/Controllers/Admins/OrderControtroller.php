<?php

namespace App\Http\Controllers\Admins;

use App\Events\OrderNoticeEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Transport;
use Faker\Core\Number;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Float_;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class OrderControtroller extends Controller
{

    // trang đơn hàng 2
    public function index_order(Request $request)
    {

        if ($request->ajax()) {
            $data = Transaction::where('transactions_status', '=', 0)->get();

            return DataTables::of($data)
                ->editColumn('transactions_price', function ($data) {
                    return number_format($data->transactions_price);
                })
                ->addColumn('transactions_total_order', function ($data) {
                    return $data->getOrder->count() . " sản phẩm";
                })
                ->addColumn('transactions_user_order', function ($data) {
                    return $data->getUser->name;
                })
                ->addColumn('action', function ($data) {
                    return ' 
                    <a href="' . route('order.detail.index', $data->id) . '" class="btn btn-sm btn-outline-success btn_seen_order"><i class="mdi mdi-eye"></i></a>    
                    <a href="' . route('order.confirm', $data->id) . '"  class="btn btn-sm btn-outline-primary btn_confirm_order" ><i class="fa fa-check"></i></a>
                        <a href="' . route('order.confirm', $data->id) . '" class="btn btn-sm btn-outline-danger btn_no_confirm_order"><i class="fa  fa-times"></i></a>
                    ';
                })
                ->rawColumns(['transactions_price', 'transactions_total_order', 'action', 'transactions_user_order'])
                ->make(true);
        }

        return view('admins.pages.order.index_order');
    }

    // xác nhận đơn hàng mới
    public function confirmOrderTransactions(request $request, $id)
    {
        $stutusCode = $request->input('statusCode');

        if ($stutusCode == '123') {
            $result = Transaction::find($id);
            $result->transactions_status = 1;
            $result->save();

            if ($result != '') {
                return true;
            }
        }
        if ($stutusCode == '345') {
            $result = Transaction::find($id);
            $result->transactions_status = 2;
            $result->save();

            if ($result != '') {
                return true;
            }
        }


        return false;
    }

    // view vận chuyển hàng
    public function indexTransport(Request $request)
    {
        $data = Transaction::where('transactions_status', '=', 1)->get();

        return DataTables::of($data)
            ->editColumn('transactions_price', function ($data) {
                return number_format($data->transactions_price);
            })
            ->addColumn('transactions_total_order', function ($data) {
                return $data->getOrder->count() . " sản phẩm";
            })
            ->addColumn('action', function ($data) {
                return ' 
                    <a href="' . route('order.detail.index', $data->id) . '" class="btn btn-sm btn-outline-success btn_seen_order"><i class="mdi mdi-eye"></i></a>    
                    <a href="' . route('order.transport.confirm', $data->id) . '"  class="btn btn-sm btn-outline-primary btn_transport" ><i class="fa fa-check"></i></a>
                        <a href="' . route('order.transport.confirm', $data->id) . '" class="btn btn-sm btn-outline-danger btn_no_transport" ><i class="fa  fa-times"></i></a>
                    ';
            })
            ->rawColumns(['transactions_price', 'transactions_total_order', 'action'])
            ->make(true);
    }

    // xác nhận vận chuyển
    public function confirmTransport(request $request, $id)
    {
        $statusCode = $request->input('statusCode');
        $stadd_id = $request->input('idStaff');

        $result = Transaction::find($id);
        $result->transactions_status = 3;
        $result->save();

        if ($statusCode == 'tp_123') {

            $table_transport = new Transport();
            $table_transport->ts_id_staff = $stadd_id;
            $table_transport->ts_transaction_id = $id;
            $table_transport->ts_status = 1;
            $table_transport->save();

            if ($table_transport != '') {
                return true;
            }
        }

        if ($statusCode == 'tp_345') {

            $table_transport = new Transport();
            $table_transport->ts_id_staff = $stadd_id;
            $table_transport->ts_transaction_id = $id;
            $table_transport->ts_status = 0;
            $table_transport->save();

            if ($table_transport != '') {
                return true;
            }
        }

        return false;
    }

    // Đã giao hàng
    public function deliveredTable()
    {
        $data = Transport::all();
        return DataTables::of($data)
            ->addColumn('ts_name_staff', function ($data) {
                return $data->getStaff->name;
            })
            ->addColumn('ts_name_order', function ($data) {
                return $data->getTransaction->transactions_name;
            })
            ->addColumn('ts_total_price', function ($data) {
                return number_format($data->getTransaction->transactions_price);
            })
            ->addColumn('ts_address', function ($data) {
                return $data->getTransaction->transactions_address;
            })
            ->addColumn('ts_phone', function ($data) {
                return $data->getTransaction->transactions_phone;
            })
            ->addColumn('ts_email', function ($data) {
                return $data->getTransaction->transactions_email;
            })
            ->editColumn('created_at', function ($data) {
                return date_format($data->created_at, "d/m/Y H:i:s");
            })
            ->editColumn('ts_status', function ($data) {
                if ($data->ts_status == 1) {
                    return '<span class="badge badge-success">Giao hàng thành công</span>';
                } else {
                    return '<span class="badge badge-danger">Giao hàng thất bại</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '
                    <a href="' . route('order.detail.index', $data->ts_transaction_id) . '" class="btn btn-outline-success btn_seen_order"><i class="mdi mdi-eye"></i></a>    
                ';
            })
            ->rawColumns(['ts_name_staff', 'ts_total_price', 'ts_name_order', 'ts_address', 'ts_phone', 'ts_email', 'created_at', 'action', 'ts_status'])
            ->make(true);
    }

    // lấy danh  sách cách order
    public function getListConfirmOrder()
    {
        $data = Order::where('od_status', '=', 2)->get();
        return DataTables::of($data)
            ->editColumn('od_price', function ($data) {
                return number_format($data->od_price);
            })
            ->addColumn('od_name_product', function ($data) {
                return '<p id="name_product-' . $data->id . '" >' . $data->getProduct->product_name . '</p>';
            })
            ->addColumn('od_link_product', function ($data) {
                return '<img src="' . asset($data->getMainImage->link_image) . '" data-id_link="link_image_order-' . $data->id . '" alt="" style="height: 50px; object-fit: cover;" class="rounded float-left">';
            })
            ->addColumn('od_Toltal_price', function ($data) {
                return number_format($data->od_price * $data->od_quantity);
            })
            ->addColumn('action', function ($data) {
                return '
                        <a href="" class="btn btn-outline-success btn_seen_order"><i class="mdi mdi-eye"></i></a>    
                    ';
            })
            ->rawColumns(['od_price', 'od_Toltal_price', 'action', 'od_link_product', 'od_name_product'])
            ->make(true);
    }

    // trang chi tiết đơn hàng
    public function index_detail_order(request $request, $id)
    {
        $data = Transaction::where('id', '=', $id)->with('getUser', 'getOrder')->first();

        // return $data;
        return view('admins.pages.order.detail_order', compact('data'));
    }

    // in hoắ đơn
    public function printBillOrder(Request $request, $id)
    {
        // $data = [
        //     'title' => 'Welcome to ItSolutionStuff.com',
        //     'date' => date('m/d/Y')
        // ];

        $data = Transaction::where('id', '=', $id)->with('getOrder')->first();

        $pdf = PDF::loadView('export.print_bill_order', compact('data'));

        // return array("data" => $data);
        // return view('export.print_bill_order', compact('data')); ;

        // return $pdf->download($data->id .' '. $data->created_at);
        return $pdf->stream();
    }
}
