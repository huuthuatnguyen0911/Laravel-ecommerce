<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // Thanh toán
    public function paymentOnline(Request $request)
    {
        $vnp_TxnRef = $request->input('order_id'); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $request->input('order_desc');
        $vnp_OrderType = $request->input('order_type');
        $vnp_Amount = $request->input('amount') * 100;
        $vnp_Locale = $request->input('language');
        $vnp_BankCode = $request->input('bank_code');
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version

        $inputData = array(
            "vnp_Version" => "2.1.0",
            // "vnp_TmnCode" => env('VNP_TMNCODE'),
            "vnp_TmnCode" => 'S3GTPO10',
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => route('payment.return'),
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // $vnp_Url = env('VNP_URL') . "?" . $query;
        $vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html' . "?" . $query;
        // if (env('VNP_HASHSECRET')) {
            // $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('VNP_HASHSECRET')); //  
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, 'QAOBIXSVBKPXTVKHJXNSDLMSYEADSQMA'); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        // }

        // return $vnp_Url;
        return redirect($vnp_Url);
    }

    // tạo thanh toán
    public function createPayment(Request $request)
    {

        $data = $request->except('_token', 'payment');

        $data['user_id'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();


        if ($request->input('payment') == '2') {
            session(['infor_custormer' => $data]);
            $totalPrice = $request->input('pricePayment');
            return view('frontend.pages.vnpay.index', compact('totalPrice'));
        } else {
            // return $data['nameReceiverOrder'];
            $transactionID = Transaction::insertGetId([
                'transactions_user_id' => $data['user_id'],
                'transactions_name' => $data['nameReceiverOrder'],
                'transactions_phone' => $data['phonenumbeOrder'],
                'transactions_address' => $data['addressOrder'],
                'transactions_email' => $data['emailOrder'],
                'transactions_note' => $data['noteOrder'],
                'transactions_price' => $data['pricePayment'],
                'transactions_date' => $data['created_at'],
                'transactions_method' => 'offline',
                'transactions_status' => 0,
                'created_at' => Carbon::now(),
            ]);

            $dataCarts = Cart::where('id_user', $request->input('user_id_payment'))->where('check', '=', '1')->with('getProduct')->get();

            // $arrtesst = array();

            foreach ($dataCarts as $dataCart) {
                Order::insert([
                    'od_transaction_id' => $transactionID,
                    'od_product_id' => $dataCart->id_product,
                    'od_quantity' => $dataCart->quantity,
                    'od_price' => $dataCart->getProduct->getArchivePrice->price,
                    'od_status' => 0,
                    'created_at' => Carbon::now(),
                ]);
                $quantityArchive = Archive::select('quantity', 'id_archive')->where('product_id', '=', $dataCart->id_product)->first();
                // array_push($arrtesst, $quantityArchive);
                // return $quantityArchive;
                Archive::where('product_id', '=', $dataCart->id_product)->update([
                    'quantity' => (int)$quantityArchive->quantity - (int)$dataCart->quantity
                ]);
                Cart::find($dataCart->id)->delete();
            }
            // return $arrtesst;

            // Gui email
            $to_name =  $data['nameReceiverOrder'];
            $to_email =  $data['emailOrder'];

            $data = [
                'name' => "Xác nhận thanh toán thành công ",
                'body' => 'Cảm ơn bạn đã mua hàng.',
            ];

            Mail::send('export.send_mail_payment', $data, function ($message) use ($to_name, $to_email) {
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to($to_email)->subject('Mail cảm ơn');
            });


            return redirect()->to('/');
        }
    }

    // payment tra ve
    public function paymentReturn(Request $request)
    {
        // return $request->all();
        if (session()->has('infor_custormer') && $request->input('vnp_TransactionStatus') == '00') {

            $data = session()->get('infor_custormer');
            $vnpData = $request->all();

            $transactionID = Transaction::insertGetId([
                'transactions_user_id' => $data['user_id'],
                'transactions_name' => $data['nameReceiverOrder'],
                'transactions_phone' => $data['phonenumbeOrder'],
                'transactions_address' => $data['addressOrder'],
                'transactions_email' => $data['emailOrder'],
                'transactions_note' => $data['noteOrder'],
                'transactions_price' => $data['pricePayment'],
                'transactions_date' => $data['created_at'],
                'transactions_method' => 'online',
                'transactions_status' => 1,
                'created_at' => Carbon::now(),
            ]);

            $dataCarts = Cart::where('id_user', $data['user_id'])->where('check', '=', '1')->with('getProduct')->get();

            foreach ($dataCarts as $dataCart) {

                Order::insert([
                    'od_transaction_id' => $transactionID,
                    'od_product_id' => $dataCart->id_product,
                    'od_quantity' => $dataCart->quantity,
                    'od_price' => $dataCart->getProduct->getArchivePrice->price,
                    'od_status' => 1,
                ]);

                Cart::find($dataCart->id)->delete();
            }

            Payment::insert([
                'transaction_id' => $transactionID,
                'user_id' => $data['user_id'],
                'money' => $data['pricePayment'],
                'transaction_code' => $vnpData['vnp_TxnRef'],
                'note' => $vnpData['vnp_OrderInfo'],
                'vnp_response_code' => $vnpData['vnp_ResponseCode'],
                'code_vppay' => $vnpData['vnp_TransactionNo'],
                'code_bank' => $vnpData['vnp_CardType'],
                'time' => date(' Y-m-d H:i:s', strtotime($vnpData['vnp_PayDate'])),
            ]);

            // Gui email
            // $to_name =  $data['nameReceiverOrder'];
            // $to_email =  $data['emailOrder'];

            // $data = [
            //     'name' => "Xác nhận thanh toán thành công ",
            //     'body' => 'Bạn đã thanh toán công đơn hàng ' . $vnpData['vnp_TxnRef']
            // ];

            // Mail::send('export.send_mail_payment', $data, function ($message) use ($to_name, $to_email) {
            //     $message->to($to_email)->subject('Thanh Toán Thành Công VNPAY');
            //     $message->from($to_email, $to_name);
            // });

            // Gui email
            $to_name =  $data['nameReceiverOrder'];
            $to_email =  $data['emailOrder'];

            $data = [
                'name' => "Xác nhận thanh toán thành công ",
                'body' => 'Cảm ơn bạn đã mua hàng.',
            ];

            Mail::send('export.send_mail_payment', $data, function ($message) use ($to_name, $to_email) {
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to($to_email)->subject('Thanh Toán Thành Công VNPAY');
            });

            return redirect()->to('/');
        }
    }
}
