<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model 
{

    static public function getProducts() {
        $products = DB::table('product')->get();
        
        return $products;
    }

    static public function getProductById($id = 0) {
        $product = DB::table('product')->where('id', $id)->get();
        return $product;
    }

}
