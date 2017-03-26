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
        $validation = Validator::make(
                        array(
                            'user' => $request->user,
                            'product' => $request->product,
                            'quantity' => $request->quantity,
                        ), array(
                            'user' => array('required', 'integer', 'min:1'),
                            'product' => array('required', 'integer', 'min:1'),
                            'quantity' => array('required', 'integer', 'min:1'),
                        )
        );
        
        $errors = [];
        if ($validation->fails()) {
            $errors = $validation->messages();
        }

        $user = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $product = filter_var($request->product, FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_var($request->quantity, FILTER_SANITIZE_NUMBER_INT);

        if ($validation->fails()) {
            return redirect('orders')->with('errors', json_decode($validation->messages()));
        }

        $productPrice = Product::getProductById($product);

        $bought_for = $productPrice[0]->price;
        
        $total = $quantity * $productPrice[0]->price;

        if ($product == 2 && $quantity >= 3) {
            $total *= 0.8;
        }

        $data = [
            'user_id' => $user,
            'product_id' => $product,
            'user_id' => $user,
            'quantity' => $quantity,
            'total' => $total,
            'bought_for' => $bought_for
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

        $validation = Validator::make(
                        array(
                    'user' => $request->user,
                    'product' => $request->product,
                    'quantity' => $request->quantity,
                        ), array(
                    'user' => array('required', 'integer', 'min:1'),
                    'product' => array('required', 'integer', 'min:1'),
                    'quantity' => array('required', 'integer', 'min:1'),
                        )
        );

        $errors = [];
        if ($validation->fails()) {
            $errors = $validation->messages();
        }

        $user = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $product = filter_var($request->product, FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_var($request->quantity, FILTER_SANITIZE_NUMBER_INT);

        $productPrice = Product::getProductById($product);

        $bought_for = $productPrice[0]->price;

        $total = $quantity * $productPrice[0]->price;

        if ($product == 2 && $quantity >= 3) {
            $total *= 0.8;
        }

        $data = [
            'user_id' => $user,
            'product_id' => $product,
            'user_id' => $user,
            'quantity' => $quantity,
            'total' => $total,
            'bought_for' => $bought_for
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
    public function delete($id) {
        $order = new Order();
        $orderDelete = $order->getOrderById($id);

        if (empty($orderDelete)) {
            return redirect('orders');
        }

        $order->deleteOrder($id);
        session()->flash('msg_deleted', 'Order № '.$id.' deleted successfully!');
        return redirect('orders');
    }

}
