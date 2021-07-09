<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\Container;
use App\Models\Product;
use App\Models\ContainerProducts;
use App\Models\Airport;

class ContainerController extends Controller
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
     * Rediret to list of containers.
     */
    public function index(){
        $containers = Container::paginate(5);
        $products = Product::all();
        return view("containers.index")
        ->with("products", $products)
        ->with("containers", $containers);
    }


    public function indexContainerProdutcs(){
        $containers = ContainerProducts::with('product')
        ->with('container')
        ->paginate(5);

        return view('containers.containerProducts')
        ->with("containerProducts", $containers);
    }

    public function store(Request $request){
        $http_response = array("message" => "Error", "response" => false);

        if($request->has("arrival_date") && $request->has("quantity_products")){
            $container = new Container();
            $container->arrival_date = $request->arrival_date;
            $container->quantityProducts = $request->quantity_products;
            $container->creation_date = date("Y-m-d H:i:s");
            $container->update_date = date("Y-m-d H:i:s");
            $container->save();

            $http_response["message"] = "El contenedor se creo exitosamente";
            $http_response["response"] = true;
        }else{
            $http_response["message"] = "Algo salio mal, ¿estas seguro de haber ingresado todos los datos?";
        }

        return response()->json($http_response);
    }

    public function storeProducts(Request $request){
        $http_response = array("message" => "Error", "response" => false);

        if($request->has("products") && $request->has("container")){
            $data = json_decode($request->products);

            foreach ($data as $value) {
                $container = new ContainerProducts();
                $container->idContainer = $request->container;
                $container->idProduct = $value->id;
                $container->creation_date = date("Y-m-d H:i:s");
                $container->update_date = date("Y-m-d H:i:s");
                $container->save();
            }

            $http_response["message"] = "Proveedores asociados con exito";
            $http_response["response"] = true;
        }else{
            $http_response["message"] = "Algo salio mal, ¿estas seguro de haber ingresado todos los datos?";
        }

        return response()->json($http_response);
    }
}
