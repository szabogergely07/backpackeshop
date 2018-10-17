@extends('layouts.shop')

@section('content')

<div style="width:50%; margin:auto;" class="container">

@foreach($orders as $order)
<h1>Order</h1>
<ul>
	<li>Order Id: {{$order->id}}</li>
	<li>Total Amount: {{$order->total}}</li>
	<li>Order Date: {{$order->created_at}}</li>
</ul>
<br>

<h1>Order details</h1>
@foreach($orderdetails as $orderdetail)
	@if($orderdetail->order_id == $order->id)
<ul>
	<li>Product name: {{$orderdetail->product->name}}</li>
	<li>Quantity: {{$orderdetail->quantity}}</li>
	<li>Product price: {{$orderdetail->price}}</li>
	<li>Subtotal: {{$orderdetail->subtotal}}</li>
</ul>
	@endif
@endforeach

<hr>

@endforeach

</div>

@endsection