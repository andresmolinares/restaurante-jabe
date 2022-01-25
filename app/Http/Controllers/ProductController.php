<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $product = DB::table('products')
        ->join('categories', 'categories.id', 'products.category_id')
        ->selectRaw('products.id as num_pro, products.name as nom_pro, products.description as desc_pro,
        products.photo, products.price, categories.name as category')
        ->paginate(5);

        $request->user()->authorizeRoles(['admin']);
        return view('product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = Category::all();
        return view('product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $campos=[
            'name'=>'required|string|max:100',
            'description'=>'required|string|max:191',
            'price'=>'required|string|max:191',

            'category_id'=>'required|int|max:20',


        ];

        $mensaje=[
            'required'=>'El :attribute es requerido',

        ];


        $this->validate($request, $campos, $mensaje);




        $dataProduct = request()->except('_token');
        if($image = $request->file('photo')){
            $rutaGuardarImg = 'imagen/';
            $imagenProducto = date('YmdHis').".".$image->getClientOriginalExtension();
            $image->move($rutaGuardarImg, $imagenProducto);
            $dataProduct['photo'] = "$imagenProducto";
            $campos=['photo'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $mensaje=['photo.required'=>'La foto es requerida'];
        }
        Product::insert($dataProduct);


        return redirect()->route('product.index')->with('mensaje', 'Producto agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product=Product::findOrFail($id);
        $category=Category::all();

        return view('product.edit', compact('product', 'category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $campos=[
            'name'=>'required|string|max:100',
            'description'=>'required|string|max:191',
            'photo'=>'required|max:10000|mimes:jpeg,png,jpg',
            'price'=>'required|string|max:191',

            'category_id'=>'required|int|max:20'


        ];

        $mensaje=[
            'required'=>'El :attribute es requerido',
            'photo.required'=>'La foto es requerida'
        ];

        $this->validate($request, $campos, $mensaje);

        $dataProduct = request()->except('_token');
        if($image = $request->file('photo')){
            $rutaGuardarImg = 'imagen/';
            $imagenProducto = date('YmdHis').".".$image->getClientOriginalExtension();
            $image->move($rutaGuardarImg, $imagenProducto);
            $dataProduct['photo'] = "$imagenProducto";
        }else{
            unset($dataProduct['photo']);
        }
/*        if($request->hasFile('photo')){
            $product=Product::findOrFail($id);
            Storage::delete('public/'.$product->photo);
            $dataProduct['photo']=$request->file('photo')->store('uploads', 'public');

        }
*/
        $product->update($dataProduct);
        //Product::UpdateOrCreate(["id"=>$product->id], $request->all());
        return redirect()->route('product.index', ["id"=>$product->id])->with('mensaje', 'Producto editado con éxito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return redirect()->route('product.index')->with('mensaje', 'Producto eliminado con éxito');
    }
}
