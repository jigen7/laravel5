<?php namespace App\Http\Models;

use App\Http\Helpers\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurants extends Model
{

    use SoftDeletes;

    protected $table = 'restaurants';

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    /*********************************** START ACCESSOR METHODS ************************************/
    public static function getRestaurantNameById($id)
    {
        $restaurant = self::find($id, array('name'));

        if(!$restaurant) {
            return false;
        }
        return $restaurant->name;
    }

    public static function getRestaurantsByCatId ($cat_id)
    {
        return self::select('restaurants.*')
            ->leftJoin('restaurants_category', 'restaurants.id', '=', 'restaurants_category.restaurant_id')
            ->where('restaurants_category.category_id', $cat_id)
            ->get();
    }

        /**
     * Returns single-dimensional array of restaurant names based on search key
     * @param $search_key
     *
     * @return Response
     */
    public static function getRestaurantNames($search_key)
    {
        $restaurant_names = self::where('name', 'LIKE', "%$search_key%")
            ->select('name')
            ->distinct('name')
            ->get()
            ->toArray();

        return array_fetch($restaurant_names, 'name');
    }


    /**
     * Returns list of nearby restaurants based on provided coordinates and distance
     *
     * @param $longitude
     * @param $latitude
     * @param float $distance
     * @param int $max_results
     * @param int $current_page
     * @param null $name_search
     * @param null $cuisine_search
     * @param null $sort_key
     * @return LengthAwarePaginator
     */
    public static function getNearbyRestaurants($longitude, $latitude, $distance = CONSTANTS::RESTAURANT_ONE_KILOMETER , $max_results = CONSTANTS::RESTAURANTS_GET_NEARBY_PAGINATION_LIMIT, $current_page = 1, $name_search = null, $cuisine_search = null, $sort_key = null)
    {

        $long1 = $longitude - $distance / abs(cos(deg2rad($latitude)) * 69);
        $long2 = $longitude + $distance / abs(cos(deg2rad($latitude)) * 69);
        $lat1 = $latitude - ($distance / 69);
        $lat2 = $latitude + ($distance / 69);

        //Compute the distance using coordinates
        $distance_computation = "3956 * 2 * ASIN(SQRT(POWER(SIN((? - restaurants.latitude) * pi() / 180 / 2), 2) + COS(? * pi() / 180) * COS(restaurants.latitude * pi() / 180) * POWER(SIN((? - restaurants.longitude) * pi() / 180 / 2), 2)))";

        $restaurants = DB::table(DB::raw('`restaurants`'))
            ->select('restaurants.id', 'restaurants.name', 'restaurants.address', 'restaurants.thumbnail', 'restaurants.rating', 'restaurants.budget', 'restaurants.longitude', 'restaurants.latitude', DB::raw($distance_computation . " as distance"))
            ->addBinding([$latitude, $latitude, $longitude], 'select')
            ->whereBetween('restaurants.longitude', array($long1, $long2))
            ->whereBetween('restaurants.latitude', array($lat1, $lat2))
            ->having('distance', '<', $distance);

        if ($name_search) {
            $restaurants->where('restaurants.name', 'like', "%$name_search%");
        }

        if ($cuisine_search) {
            $restaurants->rightJoin('restaurants_category', 'restaurants.id', '=', 'restaurants_category.restaurant_id')
                ->where('restaurants_category.category_id', '=', $cuisine_search);
        }

        if ($sort_key == 'budget') {
            $restaurants->orderBy('budget', CONSTANTS::ORDER_ASC);
        } elseif ($sort_key == 'rating') {
            $restaurants->orderBy('rating', CONSTANTS::ORDER_DESC);
        }

        $restaurants = $restaurants->whereNull('restaurants.deleted_at')
            ->orderBy('distance', CONSTANTS::ORDER_ASC)
            ->get();

        $total_restaurants = count($restaurants);

        if ($current_page > $total_restaurants || $current_page < CONSTANTS::FIRST_PAGE) {
            $current_page = CONSTANTS::FIRST_PAGE;
        }

        $offset = ($current_page * $max_results) - $max_results;
        $restaurants = array_slice($restaurants, $offset, $max_results);
        $paginated_restaurants = new LengthAwarePaginator($restaurants, $total_restaurants, $max_results);

        return $paginated_restaurants;
    } // end getNearbyRestaurants

    /**
     * Returns list of cuisines based on nearby restaurants
     *
     * @param $longitude
     * @param $latitude
     * @param $distance = show restaurants within specified distance (default is 1KM or 0.621371 miles)
     * @param $cuisine = specific cuisine to be searched
     *
     * @return mixed
     */
    public static function getNearbyCuisines($longitude, $latitude, $distance = CONSTANTS::RESTAURANT_ONE_KILOMETER, $cuisine = null)
    {
        $long1 = $longitude - $distance / abs(cos(deg2rad($latitude)) * 69);
        $long2 = $longitude + $distance / abs(cos(deg2rad($latitude)) * 69);
        $lat1 = $latitude - ($distance / 69);
        $lat2 = $latitude + ($distance / 69);

        //Compute the distance using coordinates
        $distance_computation = "3956 * 2 * ASIN(SQRT(POWER(SIN((? - restaurants.latitude) * pi() / 180 / 2), 2) + COS(? * pi() / 180) * COS(restaurants.latitude * pi() / 180) * POWER(SIN((? - restaurants.longitude) * pi() / 180 / 2), 2)))";

        $restaurant_cuisines = self::rightJoin('restaurants_category', 'restaurants.id', '=', 'restaurants_category.restaurant_id')
            ->rightJoin('categories', 'categories.id', '=', 'restaurants_category.category_id')
            ->whereBetween('restaurants.longitude', array($long1, $long2))
            ->whereBetween('restaurants.latitude', array($lat1, $lat2))
            ->where('categories.type', CONSTANTS::CATEGORY_CUISINE)
            ->having('distance', '<', $distance);

        if ($cuisine) {
            return $restaurant_cuisines->select('restaurants.id', 'restaurants.name', 'restaurants.address', 'restaurants.thumbnail', 'restaurants.rating', 'restaurants.budget', 'restaurants.longitude', 'restaurants.latitude', DB::raw($distance_computation . " as distance"))
                ->addBinding([$latitude, $latitude, $longitude], 'select')
                ->where('categories.name', $cuisine)
                ->get();
        }

        return $restaurant_cuisines->select('restaurants_category.category_id', 'categories.name', 'categories.type', DB::raw($distance_computation . " as distance"))
            ->addBinding([$latitude, $latitude, $longitude], 'select')
            ->orderBy('category_id', CONSTANTS::ORDER_ASC)
            ->groupBy('category_id')
            ->get();
    }

/*********************************** END ACCESSOR METHODS ************************************/


/*************************** START MUTATORS SETTER METHODS ***********************************


/*************************** END MUTATORS SETTER METHODS ************************************/



}



