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
    public function __construct(){
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

            //Upload Image
            $name_file = cloudinary()->upload($request->file('photo')->getRealPath())->getPublicId();

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
     * Get All Products.
     *
     * @return void
     */
    public function getProducts(Request $request){
        $product = Product::paginate(5);
        return response()->json($product);
    }

    /**
     * Get One Product.
     *
     * @return void
     */
    public function getProduct(Request $request){
        $product = Product::find($request->id);
        return response()->json($product);
    }

    /**
     * Update a product.
     *
     * @return void
     */
    public function update(Request $request){
        $http_response = array("message" => "Error", "response" => false);
        $product = Product::find($request->id);
        $update = false;

        if($request->has("name") && $request->name !== $product->name){
            $new_product = Product::find($request->id)
            ->update(["name" => $request->name, "update_date" => date("Y-m-d H:i:s")]);
            $update = true;
        }
        if($request->has("sku") && $request->sku !== $product->sku){
            $new_product = Product::find($request->id)
            ->update(["sku" => $request->sku, "update_date" => date("Y-m-d H:i:s")]);
            $update = true;
        }
        if($request->has("presentation") && $request->presentation !== $product->presentation){
            $new_product = Product::find($request->id)
            ->update(["presentation" => $request->presentation, "update_date" => date("Y-m-d H:i:s")]);
            $update = true;
        }
        if($request->has("volume") && $request->volume !== $product->volume){
            $new_product = Product::find($request->id)
            ->update(["volume" => $request->volume, "update_date" => date("Y-m-d H:i:s")]);
            $update = true;
        }
        if($request->has("unit") && $request->unit !== $product->unit){
            $new_product = Product::find($request->id)
            ->update(["unit" => $request->unit, "update_date" => date("Y-m-d H:i:s")]);
            $update = true;
        }
        if($request->hasFile("photo") && $request->photo !== $product->photo){
            $name_file = cloudinary()->upload($request->file('photo')->getRealPath())->getPublicId();
            $new_product = Product::find($request->id)
            ->update(["photo" => $name_file, "update_date" => date("Y-m-d H:i:s")]);
            $update = true;
        }

        if($update){
            $http_response["message"] = "Producto actualizado exitosamente";
            $http_response["response"] = true;
        }

        return response()->json($http_response);
    }
}
