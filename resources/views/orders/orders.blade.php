@extends('layouts.shop')

@section('content')

<div class="col-md-4">
	<div class="order-summary clearfix">
		<div class="section-title">
			<h3 class="title">{{ !$orders->count() ? 'You do not have any orders yet!' : 'Your orders' }}</h3>
		</div>
		@foreach($orders as $order)
		<div class="panel-group" id="accordion">
		  <div class="panel panel-default">
		    <div class="panel-heading">
		      <h4 class="panel-title">
		        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$order->id}}">
		        Order ID: {{$order->id}}<br>Total amount: €{{$order->total}}<br>Order Date: {{$order->created_at}}</a>
		      </h4>
		    </div>
		    <div id="collapse{{$order->id}}" class="panel-collapse collapse {{$recentOrderId == $order->id ? 'in' : ''}}">
		      <div class="panel-body">
		      	@foreach($orderdetails as $orderdetail)
					@if($orderdetail->order_id == $order->id)
					<table class="shopping-cart-table table">
					<tbody>
						<tr>
							<td class="thumb"><img src="{{asset('images/thumb-product01.jpg')}}" alt=""></td>
							<td class="details" id="orderDet">
								<a href="{{route('product.show', ['id'=>$orderdetail->product->id])}}"> {{$orderdetail->product->name}}</a>
								<ul>
									<li><span>Description: {{$orderdetail->product->description}}</span></li>
									<li><span>Price: {{$orderdetail->price}}</span></li>
									<li><span>Quantity: {{$orderdetail->quantity}}</span></li>
									<li><span>Subtotal: {{$orderdetail->subtotal}}</span></li>
									
								</ul>
							</td>
		
						</tr>
					</tbody>
					</table>

<!-- 
					<ul>
						<li>Product name: {{$orderdetail->product->name}}</li>
						<li>Quantity: {{$orderdetail->quantity}}</li>
						<li>Product price: €{{$orderdetail->price}}</li>
						<li>Subtotal: €{{$orderdetail->subtotal}}</li>
					</ul> -->

					@endif
				@endforeach
		      </div>
		    </div>
		  </div>
		</div>
		@endforeach

	</div>
</div>

@endsection


