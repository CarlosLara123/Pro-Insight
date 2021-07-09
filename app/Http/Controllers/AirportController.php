<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\Airport;

class AirportController extends Controller
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
        $airports = Airport::paginate(5);
        return view("airport.index")
        ->with("airports", $airports);
    }

    public function store(Request $request){
        $http_response = array("message" => "Error", "response" => false);

        if($request->has("name") && $request->has("ubication") && $request->has("maritime")){
            $airport = new Airport();
            $airport->name = $request->name;
            $airport->ubication = $request->ubication;
            $airport->maritime = $request->maritime;
            $airport->creation_date = date("Y-m-d H:i:s");
            $airport->update_date = date("Y-m-d H:i:s");
            $airport->save();

            $http_response["message"] = "El aeropuerto se creo exitosamente";
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
        $product = Airport::find($request->id);
        return response()->json($product);
    }
}
