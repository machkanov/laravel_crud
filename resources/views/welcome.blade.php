@extends('layouts.basic')

@section('contents')
<div class="container">
    <div class="content">
        <form method="post">

            <div class="title">Add new order</div>

            <div class="row">
                <div class="left_col">User</div>
                <div class="right_col">

                    <select name="user">
                        <?php foreach ($users as $user) : ?>

                            <option value="{{$user->id}}">{{$user->name}}</option>

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

                            <option value="{{$product->id}}">{{$product->product}}</option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <?php
                if (isset($errors->product)) {
                    echo '<div class="right_col">';
                    echo '<div class="alert alert-danger">Please choose Product!</div>';
                    echo '</div>';
                }
                ?>

            </div>
            <div class="row">
                <div class="left_col">Quantity</div>
                <div class="right_col">

                    <input name="quantity" type="number" value="1"/>
                </div>

                <?php
                if (isset($errors->quantity)) {
                    echo '<div class="right_col">';
                    echo '<div class="alert alert-danger">Please choose Quantity!</div>';
                    echo '</div>';
                }
                ?>

            </div>
            <div class="row">
                <div class="left_col"></div>
                <div class="right_col alignr">
                    {{ csrf_field() }}
                    <input type="submit" value="Add" class="btn btn-success"/>
                </div>

            </div>
            @if(Session::has('msg'))
            <div class="row alert alert-success m20">{{Session::get('msg')}}</div>
            @endif

        </form>
    </div>
    <div class="content">
        <form method="GET">
            <div class="title">Search</div>
            <div class="row">
                <div class="right_col">

                    <select name="period">
                        <option <?php echo isset($_GET['period']) ? $_GET['period'] == 1 ? "selected" : "" : "" ?> value="1">All time</option>
                        <option <?php echo isset($_GET['period']) ? $_GET['period'] == 2 ? "selected" : "" : "" ?> value="2">Last 7 days</option>
                        <option <?php echo isset($_GET['period']) ? $_GET['period'] == 3 ? "selected" : "" : "" ?> value="3">Today</option>
                    </select>
                </div>

                <div class="right_col alignr">

                    <input name="search" type="text" placeholder="enter search term..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>"/>
                </div>

                <div class="right_col alignr">

                    <input type="submit" value="Search" class="btn btn-info"/>
                </div>

            </div>

            <div class="row">
                <div class="left_col"></div>

            </div>
        </form>
    </div>

    <div class="content padding-20">


        @if(Session::has('msg_deleted'))
        <div class="row alert alert-danger m20">{{Session::get('msg_deleted')}}</div>
        @endif

        @if(Session::has('msg_updated'))
        <div class="row alert alert-success m20">{{Session::get('msg_updated')}}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped">
                <thead> 
                    <tr> 
                        <th>User</th> 
                        <th>Product</th> 
                        <th>Price</th> 
                        <th>Quantity</th> 
                        <th>Total</th> 
                        <th>Date</th> 
                        <th>Actions</th> 
                    </tr>
                </thead>
                <tbody> 
                    <?php foreach ($orders as $key => $order) : ?>
                        <tr>
                            <td>{{$order->name}}</td>
                            <td>{{$order->product}}</td>
                            <td>{{number_format($order->bought_for, 2)}} EUR</td>
                            <td>{{$order->quantity}}</td>
                            <td>{{number_format($order->total, 2)}}</td>
                            <td>{{ date('d M Y, h:i A', strtotime($order->created_at)) }}</td>
                            <td>
                                <a href="{{ URL::route('edit', $order->order_id) }}" class="btn btn-warning">Edit</a>

                                <a href="{{ URL::route('delete', $order->order_id) }}" class="btn btn-danger" onclick="confirm('Are you sure you want to delete order № {{$order->order_id}}?')">Delete</a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection