@extends('layouts.basic')

@section('contents')
<div class="container">
    <div class="content">
        <form method="post">
            <div class="title">Edit order № {{ $orders[0]->order_id }} </div>

            @if(Session::has('msg'))
            <p class="alert alert-info">{{Session::get('msg')}}</p>
            @endif
            <div class="row">
                <div class="left_col">User</div>
                <div class="right_col">

                    <select name="user">
                        <?php foreach ($users as $user) : ?>

                            <option <?php echo $orders[0]->user_id == $user->id ? "selected" : "" ?> value="{{$user->id}}">{{$user->name}}</option>

                        <?php endforeach; ?>
                    </select>
                </div>
                <?php
                if (isset($errors->user)) {
                    echo '<div class="right_col">';
                    echo '<div class="alert alert-danger">Please choose User!</div>';
                    echo '</div>';
                }
                ?>

            </div>
            <div class="row">
                <div class="left_col">Product</div>
                <div class="right_col">

                    <select name="product">
                        <?php foreach ($products as $product) : ?>

                            <option <?php echo $orders[0]->product_id == $product->id ? "selected" : "" ?> value="{{$product->id}}">{{$product->product}}</option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <?php
                if (isset($errors->product)) {
                    echo '<div class="right_col">';
                    echo '<div class="alert alert-danger">Please choose User!</div>';
                    echo '</div>';
                }
                ?>

            </div>
            <div class="row">
                <div class="left_col">Quantity</div>
                <div class="right_col">

                    <input name="quantity" type="number" value="<?php echo $orders[0]->quantity ?>"/>
                </div>

                <?php
                if (isset($errors->quantity)) {
                    echo '<div class="right_col">';
                    echo '<div class="alert alert-danger">Please choose User!</div>';
                    echo '</div>';
                }
                ?>

            </div>
            <div class="row">
                <div class="left_col alignr">
                    <a href="{{ action("OrderController@index") }}" value="" class="btn btn-info">Cancel</a>
                </div>
                <div class="right_col">
                    {{ csrf_field() }}
                    <input type="submit" value="Edit" class="btn btn-success"/>
                </div>

            </div>

        </form>
    </div>





</div>
@endsection