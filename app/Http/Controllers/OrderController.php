<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Order;
use App\User;
use App\Product;
use App\Search;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller 
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $search = filter_var(Input::get('search'), FILTER_SANITIZE_STRING);
        $period = filter_var(Input::get('period'), FILTER_SANITIZE_NUMBER_INT);

        $orders = [];
        if ($search != "" || $period > 1) {
            $orders = Search::search($search, $period);
        } else {
            $orders = Order::getOrders();
        }
        $users = User::getUsers();
        $products = Product::getProducts();

        $data = array('orders' => $orders, 'users' => $users, 'products' => $products);

        return view("welcome")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
		
        $validation = Validator::make($request->all(), [
			'user' => 'required|integer|min:1',
			'product' => 'required|integer|min:1',
			'quantity' => 'required|integer|min:1'
        ]);
        
        $errors = [];
        if ($validation->fails()) {
            $errors = $validation->messages();
            return redirect('orders')->with('errors', json_decode($validation->messages()));
        }
		
        $user = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $product = filter_var($request->product, FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_var($request->quantity, FILTER_SANITIZE_NUMBER_INT);

        $productPrice = Product::getProductPriceById($product);
        
        $total = $quantity * $productPrice;

        if ($product == 2 && $quantity >= 3) {
            $total *= 0.8;
        }

        $data = [
            'user_id' => $user,
            'product_id' => $product,
            'quantity' => $quantity,
            'total' => $total,
            'bought_for' => $productPrice
        ];

        $order = new Order();		
		$order->newOrder($data);		
		session()->flash('msg',  'Order successfully added!');
		
		return redirect('orders');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $order = new Order();
        $orderEdit = $order->getOrderById($id);
        $users = User::getUsers();
        $products = Product::getProducts();
		
        if (empty($orderEdit)) {
            return redirect('orders');
        }
		
        $data = array('orders' => $orderEdit, 'users' => $users, 'products' => $products);

        return view("edit")->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $validation = Validator::make($request->all(), [
			'user' => 'required|integer|min:1',
			'product' => 'required|integer|min:1',
			'quantity' => 'required|integer|min:1'
        ]);

        $errors = [];
        if ($validation->fails()) {
            $errors = $validation->messages();
			return redirect('orders/edit/'. $id)->with('errors', json_decode($validation->messages()));
        }

        $user = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $product = filter_var($request->product, FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_var($request->quantity, FILTER_SANITIZE_NUMBER_INT);

        $productPrice = Product::getProductPriceById($product);
        $total = $quantity * $productPrice;

        if ( $product == 2 && $quantity >= 3 ) {
            $total *= 0.8;
        }

        $data = [
            'user_id' => $user,
            'product_id' => $product,
            'quantity' => $quantity,
            'total' => $total,
            'bought_for' => $productPrice
        ];

        $order = new Order();
        $order->updateOrder($data, $id);
        session()->flash('msg_updated', 'Order № '.$id.' updated successfully!');
		
        return redirect('orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete( $id ) {
		
        $order = new Order();
        $orderDelete = $order->getOrderById($id);

        if ( empty( $orderDelete ) ) {
            return redirect('orders');
        }

        $order->deleteOrder($id);
        session()->flash('msg_deleted', 'Order № '.$id.' deleted successfully!');
        return redirect('orders');
    }

}
