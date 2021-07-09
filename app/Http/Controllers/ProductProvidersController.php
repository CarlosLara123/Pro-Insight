<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\ProductProviders;

class ProductProvidersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
        setlocale(LC_TIME, config('app.locale'));

    }

    /**
     * Rediret to list of product providers.
     *
     * @return void
     */
    public function index(){
        $products = ProductProviders::with('product')
        ->with('provider')
        ->paginate(5);
        //dd($products);
        return view('productProviders.index')
        ->with('productProviders', $products);
    }

    /**
     * Store a new register.
     *
     * @return void
     */
    public function store(Request $request){
        $http_response = array("message" => "Error", "response" => false);

        if($request->has("providers") && $request->has("product")){
            $data = json_decode($request->providers);

            foreach ($data as $value) {
                $product = new ProductProviders();
                $product->idProduct = $request->product;
                $product->idProvider = $value->id;
                $product->price = 0;
                $product->creation_date = date("Y-m-d H:i:s");
                $product->update_date = date("Y-m-d H:i:s");
                $product->save();
            }

            $http_response["message"] = "Proveedores asociados con exito";
            $http_response["response"] = true;
        }else{
            $http_response["message"] = "Algo salio mal, ¿estas seguro de haber ingresado todos los datos?";
        }

        return response()->json($http_response);
    }

    /**
     * Get One Product.
     *
     * @return void
     */
    public function getProduct(Request $request){
        $product = ProductProviders::find($request->id);
        return response()->json($product);
    }

    /**
     * Update a product.
     *
     * @return void
     */
    public function updatePrice(Request $request){
        $http_response = array("message" => "Error, algo salio mal", "response" => false);
        $product = ProductProviders::find($request->id);
        $update = false;

        if($request->has("price") && $request->price !== $product->price){
            $new_product = ProductProviders::find($request->id)
            ->update(["price" => $request->price]);
            $update = true;

            $http_response["message"] = "Precio actualizado exitosamente";
            $http_response["response"] = true;
        }

        return response()->json($http_response);
    }
}
