<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

//Models
use App\Models\Product;
use App\Models\Provider;


class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        setlocale(LC_TIME, config('app.locale'));

    }

    /**
     * Rediret to list of products.
     *
     * @return void
     */
    public function index(){
        $products = Product::all();
        $providers = Provider::all();
        return view('products.list_products')
        ->with('products', $products)
        ->with('providers', $providers);
    }

    /**
     * Create a new product
     *
     * @return void
     */
    public function store(Request $request){
        $http_response = array("message" => "Error", "response" => false);

        if($request->hasFile("photo") && $request->has("name") && $request->has("sku") &&
            $request->has("presentation") && $request->has("volume") && $request->has("unit")){

            //https://res.cloudinary.com/dftejnbqx/image/upload/v1625683897/
            $name_file = cloudinary()->upload($request->file('photo')->getRealPath())->getPublicId();
            //dd($name_file);
            $product = new Product();
            $product->name = $request->name;
            $product->sku = $request->sku;
            $product->presentation = $request->presentation;
            $product->volume = $request->volume;
            $product->unit = $request->unit;
            $product->photo = $name_file;
            $product->creation_date = date("Y-m-d H:i:s");
            $product->update_date = date("Y-m-d H:i:s");
            $product->save();

            $http_response["message"] = "El proveedor fue agragado";
            $http_response["response"] = true;
        }else{
            $http_response["message"] = "Algo salio mal, ¿estas seguro de haber ingresado todos los datos?";
        }

        return response()->json($http_response);
    }

    /**
     * Get all providers.
     *
     * @return void
     */
    public function edit(Request $request){
        $providers = Provider::all();
        return response()->json($providers);
    }

    public function update(Request $request){
        $http_response = array("message" => "Error", "response" => false);

        $product = Product::find($request->id);

        if($request->name !== $product->name){
            $product = Product::find($request->id)
            ->update(["name" => $request->name]);
        }
        if($request->sku !== $product->sku){
            $product = Product::find($request->id)
            ->update(["sku" => $request->sku]);
        }
        if($request->presentation !== $product->presentation){
            $product = Product::find($request->id)
            ->update(["presentation" => $request->presentation]);
        }
        if($request->volume !== $product->volume){
            $product = Product::find($request->id)
            ->update(["volume" => $request->volume]);
        }
        if($request->unit !== $product->unit){
            $product = Product::find($request->id)
            ->update(["unit" => $request->unit]);
        }
        if($request->photo !== $product->photo){
            $product = Product::find($request->id)
            ->update(["photo" => $request->photo]);
        }

        $http_response["message"] = "Producto actualizado exitosamente";
        $http_response["response"] = true;

        return response()->json($http_response);
    }
}
