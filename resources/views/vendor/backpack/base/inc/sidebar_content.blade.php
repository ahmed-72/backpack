{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> Users</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon la la-question"></i> Categories</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('article') }}"><i class="nav-icon la la-blog"></i> Articles</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('tag') }}"><i class="nav-icon la la-question"></i> Tags</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('article-tag') }}"><i class="nav-icon la la-question"></i> Article tags</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('order') }}"><i class="nav-icon la la-question"></i> Orders</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('vendor') }}"><i class="nav-icon la la-question"></i> Vendors</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('vendor-classification') }}"><i class="nav-icon la la-question"></i> Vendor classifications</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('classification') }}"><i class="nav-icon la la-question"></i> Classifications</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="nav-icon la la-question"></i> Products</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product-option') }}"><i class="nav-icon la la-question"></i> Product options</a></li>