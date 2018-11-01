@extends('layouts.shop')

@section('content')


<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- ASIDE -->
				
				<!-- MAIN -->
				<div id="main" class="col-md-12">
					<!-- store top filter -->
					<div class="store-filter clearfix">
						<div class="pull-left">
							<div class="row-filter">
								<a href="#"><i class="fa fa-th-large"></i></a>
								<a href="#" class="active"><i class="fa fa-bars"></i></a>
							</div>
							<div class="sort-filter">
								<span class="text-uppercase">Sort By:</span>
								<select class="input">
										<option value="0">Position</option>
										<option value="0">Price</option>
										<option value="0">Rating</option>
									</select>
								<a href="#" class="main-btn icon-btn"><i class="fa fa-arrow-down"></i></a>
							</div>
						</div>
						<div class="pull-right">
							<div class="page-filter">
								<span class="text-uppercase">Show:</span>
								<select name="numberofpages" id="dynamicSelect" class="input">
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option value="2">3</option>
								</select>
							
							<ul class="store-pages">
								<!-- <li><span class="text-uppercase">Page: </span></li> -->
								{{ $products->links() }}
								<!-- <li class="active">1</li> -->
								<!-- <li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#"><i class="fa fa-caret-right"></i></a></li> -->
							</ul>
							</div>
						</div>
					</div>
					<!-- /store top filter -->

					<!-- STORE -->
					<div id="store">
						<!-- row -->
						<div class="row">
							<!-- Product Single -->
							@foreach($products as $product)
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<div class="product-label">
											<span>New</span>
											<span class="sale">-{{floor(100-($product->price/($product->price*1.5)*100))}}%</span>
										</div>
										<a href="{{route('product.show', ['id'=>$product->id])}}" class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</a>
										<img src="{{$product->photo}}" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">€{{$product->price}} <del class="product-old-price">€{{$product->price*1.5}}</del></h3>
										<div class="product-rating">
											<div class="star-ratings-sprite"><span style="width:{{$product->product_rating}}%" class="star-ratings-sprite-rating"></span></div>

										</div>
										<h2 class="product-name"><a href="#">{{$product->name}}</a></h2>
	
	 
	
										<div class="product-btns">
										<form action="{{route('basket.store')}}" method="POST">
  											{!! csrf_field() !!}
	  										<input type="hidden" name="id" value="{{ $product->id }}">
	  										<select name="quantity">
											  	<option value="1">1</option>
											  	<option value="2">2</option>
											  	<option value="3">3</option>
											 </select>
	  
											
											<button class="primary-btn add-to-cart" type="submit"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</form>
										</div>
										
									</div>
								</div>
							</div>
							@endforeach
							<!-- /Product Single -->
						</div>
						<!-- /row -->
					</div>
					<!-- /STORE -->

					<!-- store bottom filter -->
					<div class="store-filter clearfix">
						<div class="pull-left">
							<div class="row-filter">
								<a href="#"><i class="fa fa-th-large"></i></a>
								<a href="#" class="active"><i class="fa fa-bars"></i></a>
							</div>
							<div class="sort-filter">
								<span class="text-uppercase">Sort By:</span>
								<select class="input">
										<option value="0">Position</option>
										<option value="0">Price</option>
										<option value="0">Rating</option>
									</select>
								<a href="#" class="main-btn icon-btn"><i class="fa fa-arrow-down"></i></a>
							</div>
						</div>
						<div class="pull-right">
							<div class="page-filter">
								<span class="text-uppercase">Show:</span>
								<select class="input">
										<option value="0">10</option>
										<option value="1">20</option>
										<option value="2">30</option>
									</select>
							</div>
							<ul class="store-pages">
								<!-- <li><span class="text-uppercase">Page: </span></li> -->
								{{ $products->links() }}
								<!-- <li class="active">1</li> -->
								<!-- <li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#"><i class="fa fa-caret-right"></i></a></li> -->
							</ul>
						</div>
					</div>
					<!-- /store bottom filter -->
				</div>
				<!-- /MAIN -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->


@endsection