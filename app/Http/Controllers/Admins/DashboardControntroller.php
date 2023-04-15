<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\Dashboard\DashboardRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardControntroller extends Controller
{
    protected $dashboardRepository;
    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');

        $countUser = User::where('role_id', '=', 0)->count();
        $toltaOder = Transaction::where('transactions_status', '!=', 0)->count();
        $countComment = Comment::count();

        $arrNameProduct = [];
        $arrTotalQuantity = [];

        $bestSell = Order::whereHas('getTransaction', function ($query) {
            return $query->where('transactions_status', '!=', 0);
        })
            ->select(DB::raw('sum(od_quantity) as total_sales , od_product_id'))
            ->groupBy('od_product_id')
            ->orderBy('total_sales', 'desc')
            ->take(1)
            ->get();

        foreach ($bestSell as $item) {
            array_push($arrNameProduct , $item->getProduct->product_name);
            array_push($arrTotalQuantity , $item->total_sales);
        }

        // return $arrNameProduct;

        return view('admins.pages.dashboard.index', compact('countUser', 'toltaOder', 'countComment' ,'arrNameProduct' , 'arrTotalQuantity','bestSell'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
