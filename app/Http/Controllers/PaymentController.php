<?php

namespace App\Http\Controllers;

use App\Services\PayPalService;
use App\Models\Cart;
use App\Models\orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderEvent;
use App\Listeners\OrderListener;
use Carbon\Carbon;


use App\Resolvers\PaymentPlatformResolver;

class PaymentController extends Controller
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->middleware('auth');

        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }


    public function pay(Request $request){
        $rules =[
            'value' => ['required', 'numeric', 'min:1'],
            'currency' => ['required', 'exists:currencies,iso'],
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
        ];

        $request->validate($rules);

        if(request()->get('payment_platform') == 3){
            $request->paymentPlatform = 3;
            session()->put('paymentPlatformId', $request->payment_platform);
            return self::factura($request);
        }

        $paymentPlatform = $this->paymentPlatformResolver
        ->resolveService($request->payment_platform);
        session()->put('paymentPlatformId', $request->payment_platform);

        //$paymentPlatform = resolve(PayPalService::class);

        return $paymentPlatform->handlePayment($request);
    }

    public function factura(Request $request){
        if(\Cart::getContent()->count()>0):
            //procedimiento
            $order = new Orders();
            $order->code = 'COD'.time();
            $order->order_date = Carbon::today('America/Bogota');
            $order->order_status = 'PENDIENTE';


            $order->payment_option = session()->get('paymentPlatformId');
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
            CartController::make_order_notification($order);
            \Cart::clear();
            return view('cart.confirmation')->with(['order'=>$order->code]);
        else:
            return redirect('/shop');
        endif;
    }

    public function approval(){
        if (session()->has('paymentPlatformId')) {

            $paymentPlatform = $this->paymentPlatformResolver->resolveService(session()->get('paymentPlatformId'));

            return $paymentPlatform->handleApproval();
        }

        return redirect()
        ->route('cart.index')
        ->withErrors('No podemos recuperar su plataforma de pago. Por favor, inténtalo de nuevo.');

    }

    public function cancelled(){

        return redirect()
            ->route('cart.index')
            ->withErrors('Has cancelado el proceso de pago.');
    }
}
