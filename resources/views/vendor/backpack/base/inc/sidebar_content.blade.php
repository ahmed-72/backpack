{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> Users</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon la la-code-branch "></i> Categories</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('vendor') }}"><i class="nav-icon la la-store-alt"></i> Vendors</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="nav-icon la la-hamburger"></i> Products</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product-option') }}"><i class="nav-icon la la-stream"></i> Product options</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('order') }}"><i class="nav-icon la la-clipboard"></i> Orders</a></li>