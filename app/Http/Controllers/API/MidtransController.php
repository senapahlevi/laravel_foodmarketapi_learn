<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request){

        //set configure midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    
        //buat instance midtrans notification
        $notification = new Notification();
        //assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
    
        //cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($order_id);
        //handle notifikasi status midtrans
        if($status == 'capture'){
            if($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transaction->status = 'PENDING';
                }
                else
                {
                    $transaction->status = 'SUCCESS';
                }
            }
        }
        else if($status == 'settlement')
        {
            $transaction->status = 'SUCCESS';
        }
        else if($status == 'pending')
        {
            $transaction->status = 'PENDING';

        }
        else if($status == 'deny')
        {
            $transaction->status = 'CANCELLED';

        }
        else if($status == 'expire')
        {
            $transaction->status = 'CANCELLED';
        }
        else if($status == 'cancel')
        {
            $transaction->status = 'CANCELLED';
        }
        // simpan transaksi
        $transaction->save();
    }

    public function success(Request $request){
        return view('midtrans.success');
    }
    public function unfinish(Request $request){
        return view('midtrans.unfinish');
    }
    public function error(Request $request){
        return view('midtrans.error');
    }
}
