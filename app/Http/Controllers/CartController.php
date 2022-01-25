<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Events\OrderEvent;
use App\Listeners\OrderListener;
use App\Models\Category;
use App\Models\Product;
use App\Notifications\OrderNotification;
use App\Models\User;
use App\Models\Role;
use App\Models\orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentPlatform;
use Illuminate\Support\Facades\DB;
use App\Resolvers\PaymentPlatformResolver;
use Carbon\Carbon;
use PDF;


class CartController extends Controller
{
    protected $paymentPlatformResolver;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     // FUNCION PARA MOSTRAR LOS PRODUCTOS EN LA PAGINA SHOP
    public function shop(){
        //SE CREA VARIABLE LA CUAL CONTIENE LOS PRODUCTOS PAGINADOS A 5 ITEMS
        $products = Product::all();
        $categories = Category::all();
        //SE RETORNA LA VISTA 'SHOP', CON LA VARIABLE CREADA ANTERIORMENTE
        return view('shop', compact(['products', 'categories']));
    }

    public function productByCategory($category){
        $categories = Category::all();
        $category=Category::where('name', '=', $category)->first();
        $products = Product::where('category_id', '=', $category->id)->get();
        return view('shop', compact(['products', 'categories']));

    }

    public function index()
    {
        //
        //SE CREA LA VARIABLE QUE CONTIENE LOS PRODUCTOS AGREGADOS AL CARRITO
        $cartCollection = \Cart::getContent();
        $paymentPlatforms = PaymentPlatform::all();

        // PARA LUEGO RETORNARLOS A LA VISTA PRINCIPAL DEL CARRITO
        return view('cart.cart')->with(['cartCollection'=>$cartCollection, 'paymentPlatforms'=>$paymentPlatforms]);
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
        //ARREGLO PARA GUARDAR LA INFORMACION DE LOS PRODUCTOS DEL CARRITO
        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->img,
                'slug' => $request->slug
            )
        ));

        //RETORNANDO LA VISTA PRINCIPAL DEL CARRITO CON MENSAJE DE SATISFACCION
        return redirect()->route('cart.index')->with('success_msg', 'Item is Added to Cart!');
    }
    public function clear(){
        //METODO PARA LIMPIAR EL CARRITO
        \Cart::clear();
        //RETORNANDO A LA VISTA SHOP CON MENSAKE DE SATISFACCION
        return redirect()->route('shop')->with('success_msg', 'Car is cleared!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
        \Cart::update($request->id,
        array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity
            ),
    ));
    return redirect()->route('cart.index')->with('success_msg', 'Cart is Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cart $cart)
    {
        //
        \Cart::remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', 'Item is removed!');
    }

    /*public function factura(Request $request){
        if(\Cart::getContent()->count()>0):
            //procedimiento
            $order = new Orders();
            $order->code = 'COD'.time();
            $order->order_date = date('Y-m-d H:i:s');
            $order->order_status = 'PENDIENTE';
            $order->payment_option = session();
            $order->total_price = \Cart::getSubTotal();
            $order->user_id = Auth::user()->id;

            $order->save();

            foreach(\Cart::getContent() as $r):

                $cart = new Cart();

                $cart->total_products = $r->quantity;
                $cart->product_id = $r->id;
                $cart->order_id = $order->id;
                $cart->save();

            endforeach;
            self::make_order_notification($order);
            \Cart::clear();
            return view('cart.confirmation')->with(['order'=>$order->code]);
        else:
            return redirect('/shop');
        endif;
    }*/

    static function make_order_notification($order){

        event(new OrderEvent($order));
        //User::role(['trabajador'])
        //Auth::user()->notify(new OrderNotification($order));

        //User::all()
        //->except($order->user_id)
        //->each(function(User $user) use ($order){
        //$user->notify(new OrderNotification($order));
       // });


    }

    public function markNotification(Request $request)
    {
        auth()->user()->unreadNotifications
                ->when($request->input('id'), function($query) use ($request){
                    return $query->where('id', $request->input('id'));
                })->markAsRead();
        return response()->noContent();
    }

    public function venta_producto(){
        $carts = DB::table('carts')
        ->selectRaw('COUNT(carts.product_id) as unidades, PRODUCTS.NAME as producto, PRODUCTS.PRICE AS precio_unitario, (PRODUCTS.price * COUNT(carts.product_id)) AS total_vendido')
        ->RightJoin('products', 'products.id', 'carts.product_id')-> groupBy('products.name', 'products.price')->get();

        return view('venta_producto', compact('carts'));
    }

    public function ventaP_pdf(){
        $carts = DB::table('carts')
        ->selectRaw('COUNT(*) as unidades, PRODUCTS.NAME as producto, PRODUCTS.PRICE AS precio_unitario, (PRODUCTS.price * COUNT(*)) AS total_vendido')
        ->join('products', 'products.id', 'carts.product_id')-> groupBy('products.name', 'products.price')->get();

        $data = compact('carts');
        $pdf=PDF::loadView('reports.venta_producto', $data);
        return $pdf->setPaper('a4','landscape')->download('ventasxproducto'.Carbon::today('America/Bogota')->format('d/m/Y').'.pdf');

    }



}
