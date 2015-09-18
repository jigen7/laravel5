<?php namespace App\Http\Controllers\Api;

use App\Http\Helpers\Constants;
use App\Http\Helpers\KeyParser;
use App\Http\Helpers\ModelFormatter;
use Illuminate\Support\Facades\Input;



class RestaurantController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {

    }

    /**
     * Restaurant Search function
     * route: /restaurants/search
     * Optional URL params: all (search_key to be used), name, rating, cuisine, orderby
     *
     * @return Response
     */
    public function searchAction()
    {
        $params = Input::get();

        $search_results = SearchUtilities::restaurantSearch($params);

        return response()->json($search_results);
    }

}
