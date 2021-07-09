<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Container;
use App\Models\Airport;

class OrderController extends Controller
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
     * Rediret to list of orders.
     *
     * @return void
     */
    public function index(){
        $orders = Order::with('container')
        ->with('airport')
        ->paginate(5);
        $containers = Container::all();
        $airports = Airport::all();

        return view('orders.index')
        ->with('containers', $containers)
        ->with('airports', $airports)
        ->with('orders', $orders);
    }

    /**
     * Store a new order.
     *
     * @return void
     */
    public function store(Request $request){
        $http_response = array("message" => "Error", "response" => false);

        if($request->has("container") && $request->has("airport")){
            $order = new Order();
            $order->idContainer = $request->container;
            $order->idAirport = $request->airport;
            $order->creation_date = date("Y-m-d H:i:s");
            $order->update_date = date("Y-m-d H:i:s");
            $order->save();

            $http_response["message"] = "Pedido generado con exito";
            $http_response["response"] = true;
        }else{
            $http_response["message"] = "Algo salio mal, ¿estas seguro de haber ingresado todos los datos?";
        }

        return response()->json($http_response);
    }
}
