<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'order_date',
        'order_status',
        'payment_option',
        'total_price',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cart(){
        return $this->hasOne(Cart::class);
    }

    public function payment_platforms(){
        return $this->belongsTo(PaymentPlatform::class);
    }


    public function ventas_dia(){
        $venta = Orders::whereDate('order_date', Carbon::today('America/Bogota'))->get();
        $total = $venta->sum('total_price');

         $noventa = DB::table('orders')
        ->selectRaw('count(*) as total, order_date')
        ->whereDate('order_date', Carbon::today('America/Bogota'))->groupBy('order_date')->get();

        return view('ventas_dia', compact('venta', 'total', 'noventa'));
    }









    /*public function ventas_mes(Request $request){
        $text = trim($request->get('text'));
        $month = trim($request->get('month'));
        $ventas = DB::table('orders')
        ->join('users', 'orders.user_id', 'users.id')
        ->selectRaw('orders.id, code, users.name,order_date, order_status, total_price')
        ->whereMonth('order_date', $month)
        ->where('code', 'LIKE', '%'.$text.'%')
        ->orderBy('order_status', 'desc')
        ->get()
        ;
        $request->user()->authorizeRoles(['trabajador']);

        return view('ventas_mes', compact('ventas', 'text', 'month'));
    }
    */

}
