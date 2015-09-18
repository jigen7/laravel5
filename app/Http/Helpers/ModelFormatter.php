<?php namespace App\Http\Helpers;


use Illuminate\Support\Facades\Input;

class ModelFormatter
{


   /**
     * Returns an array of user data with more fields than userFormat()
     *
     * @param $data
     * @return array
     */

    /**
     * Returns an array of restaurant data for use in restaurantView API
     *
     * @param Restaurants $data
     * @param $is_bookmarked
     * @return array
     */
    public static function restaurantViewFormat(Restaurants $data, $is_bookmarked = 0)
    {
        $short_restaurant_url = route('short_restaurant_view', ['encoded_id' => recordEncode($data->id)]);
        $arr = array(
            KeyParser::id => $data->id,
            KeyParser::short_url => $short_restaurant_url,
            KeyParser::name => $data->name,
            KeyParser::slug_name => $data->slug_name,
            KeyParser::address => $data->address,
            KeyParser::telephone => $data->telephone,
            KeyParser::budget => $data->budget,
            KeyParser::can_deliver => $data->can_deliver,
            KeyParser::can_dinein => $data->can_dinein,
            KeyParser::operating_time => $data->operating_time,
            KeyParser::longitude => $data->longitude,
            KeyParser::latitude => $data->latitude,
            KeyParser::rating => $data->rating,
            KeyParser::review_count => Reviews::getByRestaurantId($data->id)->count(),
            KeyParser::checkin_count => CheckIns::getByRestaurantId($data->id)->count(),
            KeyParser::view_count => $data->view_count,
            KeyParser::status_close => $data->status_close,
            KeyParser::status_verify => $data->status_verify,
            KeyParser::user_id => $data->user_id,
            KeyParser::thumbnail => $data->thumbnail,
            KeyParser::is_bookmarked => $is_bookmarked
        );

        return $arr;
    }
 
} //end of Class Model

