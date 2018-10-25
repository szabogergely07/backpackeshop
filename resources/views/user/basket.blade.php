<?php $__env->startSection('content'); ?>


<div class="col-md-12">
	<div class="order-summary clearfix">
		<div class="section-title">
			<h3 class="title">Order Review</h3>
		</div>
		<table class="shopping-cart-table table">
			<thead>
				<tr>
					<th>Product</th>
					<th></th>
					<th class="text-center">Price</th>
					<th class="text-center">Quantity</th>
					<th class="text-center">Total</th>
					<th class="text-right"></th>
				</tr>
			</thead>
			<tbody>

				<?php $__currentLoopData = $myproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td class="thumb"><img src="./img/thumb-product01.jpg" alt=""></td>
					<td class="details">
						<a href="#"><?php echo e($product->name); ?></a>
						<ul>
							<li><span>Description: <?php echo e($product->description); ?></span></li>
							
						</ul>
					</td>
					<td class="price text-center"><strong><?php echo e("€$product->price"); ?></strong></td>
					<td class="qty text-center">
						<div style="width: 105px; margin: auto;" class="input-group">
					<span class="input-group-btn">
						<form action="<?php echo e(route('basket.update', ['id'=>$product->id])); ?>" method="POST">
								<?php echo csrf_field(); ?>

								<?php echo e(method_field('PUT')); ?>

									<input type="hidden" name="quantity" value="<?php echo e($product->pivot->quantity); ?>">
									<input type="hidden" name="way" value="2">
						<button type="submit" class="btn btn-danger btn-number" data-type="" data-field="">
						<span class="glyphicon glyphicon-minus"></span>
						</button>
					</form>
					</span>
							<input class="form-control" type="text" value="<?php echo e($product->pivot->quantity); ?>" readonly>
						 	<span class="input-group-btn">
						 		<form action="<?php echo e(route('basket.update', ['id'=>$product->id])); ?>" method="POST">
								<?php echo csrf_field(); ?>

								<?php echo e(method_field('PUT')); ?>

									<input type="hidden" name="quantity" value="<?php echo e($product->pivot->quantity); ?>">
									<input type="hidden" name="way" value="1">
						<button type="submit" class="btn btn-success btn-number" data-type="" data-field="">
						<span class="glyphicon glyphicon-plus"></span>
						</button>
					</form>
					</span>
					</div>
					</td>
					<td class="total text-center"><strong class="primary-color">€{{$product->pivot->subtotal}}</strong></td>
					<td class="text-right">
						<form action="<?php echo e(route('basket.destroy', ['id'=>$product->id])); ?>" method="POST">
							<?php echo csrf_field(); ?>

							<?php echo e(method_field('DELETE')); ?>

							<button type="submit" class="main-btn icon-btn"><i class="fa fa-close"></i></button>
						</form>
					</td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="empty" colspan="3"></th>
					<th>SUBTOTAL</th>
					<th colspan="2" class="sub-total">€{{$total}}</th>
				</tr>
				<tr>
					<th class="empty" colspan="3"></th>
					<th>SHIPPING</th>
					<td colspan="2">Free Shipping</td>
				</tr>
				<tr>
					<th class="empty" colspan="3"></th>
					<th>TOTAL</th>
					<th colspan="2" class="total">€{{$total}}</th>
				</tr>
			</tfoot>
		</table>
		<div class="pull-right">
			<form action="<?php echo e(route('order.store')); ?>" method="POST">
				<?php echo csrf_field(); ?>

				<button type="submit" class="primary-btn">Place Order</button>
			</form>
		</div>
	</div>

</div>







<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.shop', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>