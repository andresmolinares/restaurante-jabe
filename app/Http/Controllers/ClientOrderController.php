<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Auth;

class ClientOrderController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $text = trim($request->get('text'));
        $order = DB::table('orders')
        ->join('users', 'orders.user_id', 'users.id')
        ->select('users.id', 'orders.id', 'code', 'order_date', 'order_status', 'total_price')
        ->where('users.id', '=', auth()->id())
        ->orderBy('order_date', 'desc')
        ->paginate(5)
        ;
        $request->user()->authorizeRoles(['cliente']);
        return view('clientorder.index', compact('order'));

    }


    public function cancel_order($id){

        $orders = Orders::findOrFail($id);
        if($orders->order_status == 'PENDIENTE'){
            $orders->update(['order_status'=>'CANCELADO']);
            return redirect()->back();

        }else{
            return redirect()->back()->with('mensaje', 'No puedes cancelar un pedido que ha sido entregado');

        }
    }
}
