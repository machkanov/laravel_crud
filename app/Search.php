<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Search extends Model
{
    static public function search($search, $period) {
        $newDate = '';
        
        if ($period == 1) {
            // all the time
            $newDate = date('1970-01-01');
        }else if ($period == 2) {
            // last 7 days
            $today = date('Y-m-d');
            $newDate = date('Y-m-d',strtotime($today . '-7 days'));
        }else if($period == 3){
            // today
            $newDate = date('Y-m-d');
        }
        
        $query = DB::select( 
                    DB::raw("SELECT * FROM `order` "
						. " LEFT JOIN user ON user.id = order.user_id"
						. " LEFT JOIN product ON product.id = order.product_id"
						. " WHERE (user.name LIKE '%" . $search . "%' OR product.product LIKE '%" . $search . "%') "
						. " AND order.created_at >= '". $newDate . "00:00:00'")
				);
        
        return $query;
        
    }
}
