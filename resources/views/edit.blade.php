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
                @if(isset($errors->user))
                    <div class="right_col long">
						<div class="alert alert-danger">Please choose User!</div>
                    </div>
                @endif
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
                @if(isset($errors->product))
                    <div class="right_col long">
						<div class="alert alert-danger">Please choose Product!</div>
                    </div>
                @endif			
            </div>
            <div class="row">
                <div class="left_col">Quantity</div>
                <div class="right_col">
                    <input name="quantity" type="number" value="<?php echo $orders[0]->quantity ?>"/>
                </div>
                @if(isset($errors->quantity))
                    <div class="right_col long">
						<div class="alert alert-danger">Please choose Quantity!</div>
                    </div>
                @endif

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