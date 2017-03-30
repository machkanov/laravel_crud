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

    static public function getProductPriceById( $id = 0 ) {
        $productPrice = DB::table('product')->where('id', $id)->value('price');
        return $productPrice;
    }

}
