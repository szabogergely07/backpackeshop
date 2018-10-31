@extends('layouts.shop')

@section('content')



<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!--  Product Details -->
				<div class="product product-details clearfix">
					<div class="col-md-6">
						<div id="product-main-view">
							<div class="product-view">
								<img src="{{$product->photo}}" alt="">
							</div>
							<div class="product-view">
								<img src="{{asset('images/main-product02.jpg')}}" alt="">
							</div>
							<div class="product-view">
								<img src="{{asset('images/main-product03.jpg')}}" alt="">
							</div>
							<div class="product-view">
								<img src="{{asset('images/main-product04.jpg')}}" alt="">
							</div>
						</div>
						<div id="product-view">
							<div class="product-view">
								<img src="{{$product->photo}}" alt="">
							</div>
							<div class="product-view">
								<img src="{{asset('images/thumb-product02.jpg')}}" alt="">
							</div>
							<div class="product-view">
								<img src="{{asset('images/thumb-product03.jpg')}}" alt="">
							</div>
							<div class="product-view">
								<img src="{{asset('images/thumb-product04.jpg')}}" alt="">
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="product-body">
							<div class="product-label">
								<span>New</span>
								<span class="sale">-{{floor(100-($product->price/($product->price*1.5)*100))}}%</span>
							</div>
							<h2 class="product-name">{{$product->name}}</h2>
							<h3 class="product-price">€{{$product->price}} <del class="product-old-price">€{{$product->price*1.5}}</del></h3>
							<div>
								<div class="star-ratings-sprite"><span style="width:{{$average}}%" class="star-ratings-sprite-rating"></span></div>
								<a href="#tab2">{{$reviewCount}} Review{{$reviewCount > 1 ? 's' : ''}} / Add Review</a>
							</div>
							<p><strong>Availability:</strong> In Stock</p>
							<p><strong>Brand:</strong> E-SHOP</p>
							<p>{{$product->description}}</p>
							<div class="product-options">
								<ul class="size-option">
									<li><span class="text-uppercase">Size:</span></li>
									<li class="active"><a href="#">S</a></li>
									<li><a href="#">XL</a></li>
									<li><a href="#">SL</a></li>
								</ul>
								<ul class="color-option">
									<li><span class="text-uppercase">Color:</span></li>
									<li class="active"><a href="#" style="background-color:#475984;"></a></li>
									<li><a href="#" style="background-color:#8A2454;"></a></li>
									<li><a href="#" style="background-color:#BF6989;"></a></li>
									<li><a href="#" style="background-color:#9A54D8;"></a></li>
								</ul>
							</div>
							<form action="{{route('basket.store')}}" method="POST">
  											{!! csrf_field() !!}
	  										<input type="hidden" name="id" value="{{ $product->id }}">
	  										
							<div class="product-btns">
								<div class="qty-input">
									<span class="text-uppercase">QTY: </span>
									<input min="1" value="1" class="input" type="number" name="quantity">
								</div>
								<button type="submit" class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
							
								<div class="pull-right">
									<!-- <button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
									<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
									<button class="main-btn icon-btn"><i class="fa fa-share-alt"></i></button> -->
								</div>
							</div>
							</form>
						</div>
					</div>
					<div class="col-md-12">
						<div class="product-tab">
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
								<li><a data-toggle="tab" href="#tab1">Details</a></li>
								<li><a data-toggle="tab" href="#tab2">Reviews ({{$reviewCount}})</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab1" class="tab-pane fade in active">
									<p>{{$product->description}}</p>
								</div>
								<div id="tab2" class="tab-pane fade in">

									<div class="row">
										<!-- Review -->
										
										<div class="col-md-6">
											<div class="product-reviews">
												@foreach ($reviews as $review)
												<div class="single-review">
													<div class="review-heading">
														<div><a href="#"><i class="fa fa-user-o"></i> {{$review->user->name}}</a></div>
														<div><a href="#"><i class="fa fa-clock-o"></i> {{$review->created_at}}</a></div>
														<div class="review-rating pull-right">
															<?php for ($i=$review->rating;$i>0;$i--) { ?> 
																
															<i class="fa fa-star"></i>
															<?php } ?>

															<?php for($i=$review->rating;$i<5;$i++) { ?>
															<i class="fa fa-star-o empty"></i>
															<?php } ?>
														</div>
													</div>
													<div class="review-body">
														<p>{{$review->body}}</p>
													</div>
												</div>
												@endforeach	
												
											

												<ul class="reviews-pages">
													<!-- <li class="active">1</li>
													<li><a href="#">2</a></li>
													<li><a href="#">3</a></li>
													<li><a href="#"><i class="fa fa-caret-right"></i></a></li> -->
													{{ $reviews->links() }}
												</ul>
											</div>

										</div>
										


										@guest
										@else
										<div class="col-md-6">
											<h4 class="text-uppercase">Write Your Review</h4>
											<p>Your email address will not be published.</p>
											<form action="{{route('review.store')}}" method="POST" class="review-form">
												@csrf
												<input type="hidden" name="productId" value="{{$product->id}}">
												<div class="form-group">
													<textarea name="body" class="input" placeholder="Your review"></textarea>
												</div>
												<div class="form-group">
													<div class="input-rating">
														<strong class="text-uppercase">Your Rating: </strong>
														<div class="stars">
															<input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
															<input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
															<input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
															<input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
															<input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
														</div>
													</div>
												</div>
												<button type="submit" class="primary-btn">Submit</button>
											</form>
										</div>
										@endguest
									</div>



								</div>
							</div>
						</div>
					</div>

				</div>
				<!-- /Product Details -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->



@endsection