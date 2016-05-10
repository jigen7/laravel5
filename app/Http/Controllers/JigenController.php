<?php namespace App\Http\Controllers;

use App\Http\Helpers\Constants;
use App\Http\Helpers\KeyParser;
use App\Http\Helpers\ModelFormatter;
use Illuminate\Support\Facades\Input;



class JigenController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {

    }

    /**
     * Sample API 
     * route: /sample/jigen
     *
     * @return Response
     */
    public function jigenAction()
    {
        $arr = array("Vina","Consunto", "Sugata");
        
        return response()->json($arr);
    }

}
