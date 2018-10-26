<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{ backpack_url('customer') }}"><i class="fa fa-user"></i> <span>Customers</span></a></li>
<li><a href="{{ backpack_url('product') }}"><i class="fa fa-product-hunt"></i> <span>Products</span></a></li>
<li><a href="{{ backpack_url('category') }}"><i class="fa fa-tags"></i> <span>Categories</span></a></li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<li><a href="{{ route('user.index') }}"><i class="fa fa-files-o"></i> <span>Users</span></a></li>