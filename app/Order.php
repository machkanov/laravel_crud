<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model 
{

    static public function getOrders() {
        $orders = DB::table('order')
                ->leftJoin('user', 'user.id', '=', 'order.user_id')
                ->leftJoin('product', 'product.id', '=', 'order.product_id')
                ->orderBy('order.created_at', 'DESC')
                ->get();

        return $orders;
    }

    public function newOrder($data) {
        $order = DB::table('order')->insert($data);
        
        return $order;
    }

    public function getOrderById($id) {
        $order = DB::table('order')->where('order_id', $id)->get();

        return $order;
    }

    public function updateOrder($data, $id) {
        
        $orderEdit = DB::table('order')->where('order_id', $id)->update($data);
        
        return $orderEdit;
    }
    
    public function deleteOrder($id) {
        
        $deleteOrder = DB::table('order')->where('order_id', $id)->delete();
        
        return $deleteOrder;
    }

}
