<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class OrdersController extends Controller
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
        ->select('orders.id', 'code', 'users.name','order_date', 'order_status', 'total_price')
        ->where('code', 'LIKE', '%'.$text.'%')
        ->orWhere('users.cedula', 'LIKE', '%'.$text.'%')
        ->orderBy('order_status', 'desc')
        ->paginate(5)
        ;
        $request->user()->authorizeRoles(['trabajador']);
        return view('order.index', compact('order', 'text'));

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
     * @param  \App\Models\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = DB::table('orders')

        ->join('users', 'orders.user_id', 'users.id')

        ->selectRaw('code, users.name AS nom_cliente, users.last_name as last_cliente, users.address, users.phone_number, order_date, order_status, orders.payment_option,total_price')
        ->where('orders.id', '=', $id)
        ->get()
        ;

        //d($order);

        $products = DB::table('carts')
        ->join('orders', 'orders.id', 'carts.order_id')
        ->join('products', 'carts.product_id', 'products.id')
        ->selectRaw('products.name, total_products, products.price')
        ->where('carts.order_id', '=', $id)
        ->get();

        return view('order.show', compact('order', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(orders $orders)
    {
        //
    }

    public function change_status($id){

        $orders = Orders::findOrFail($id);
        if($orders->order_status == 'PENDIENTE'){
            $orders->update(['order_status'=>'ENTREGADO']);
            return redirect()->back();

        }else{
            $orders->update(['order_status'=>'PENDIENTE']);
            return redirect()->back();
        }
    }

    public function ventas_mes(){
        $fi = Carbon::parse(Carbon::today('America/Bogota'))->format('Y-m-d') . ' 00:00:00';
        $ff = Carbon::parse(Carbon::today('America/Bogota'))->format('Y-m-d') . ' 23:59:59';
        $venta = Orders::whereDate('order_date', Carbon::today('America/Bogota'))->get();
        $total = $venta->sum('total_price');


        $noventa = DB::table('orders')
        ->selectRaw('count(*) as total, order_date')
        ->whereBetween('order_date', [$fi, $ff] )->groupBy('order_date')->get();





        return view('ventas_mes', compact('venta', 'total', 'fi', 'ff', 'noventa'));
    }


    public function report_results(Request $request){
        $fi = $request->fecha_ini.' 00:00:00';
        $ff = $request->fecha_fin.' 23:59:59';
        $venta = Orders::whereBetween('order_date', [$fi, $ff])->get();
        $total = $venta->sum('total_price');


        $noventa = DB::table('orders')
        ->selectRaw('count(*) as total, order_date')
        ->whereBetween('order_date', [$fi, $ff])->groupBy('order_date')->get();

        //dd($noventa);

        return view('ventas_mes', compact('venta', 'total', 'fi', 'ff', 'noventa'));
    }



    //PDF

    public $dateFrom, $dateTo;
    public function ventaD_pdf(){
        $venta = Orders::whereDate('order_date', Carbon::today('America/Bogota'))->get();
        $total = $venta->sum('total_price');
        $data=compact('venta', 'total');
        $pdf=PDF::loadView('reports.venta_dia', $data);

        return $pdf->setPaper('a4','landscape')->download('ventasxdia'.Carbon::today('America/Bogota')->format('d/m/Y').'.pdf');

    }

    public function ventaM_pdf($fi, $ff){

        $venta = Orders::whereBetween('order_date', [$fi, $ff])->get();
        $total = $venta->sum('total_price');




        $data=compact('venta', 'total','fi', 'ff');
        $pdf=PDF::loadView('reports.venta_fecha', $data);
        return $pdf->setPaper('a4','landscape')->download('ventas-x-mes-'.$fi.'-'.$ff.'.pdf');

    }
}
