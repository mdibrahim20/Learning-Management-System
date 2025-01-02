@php
    $user = Auth::user();
    $wishlistCount = App\Models\Wishlist::where('user_id', $user->id)->count();
    $unreadCount = $user->unreadNotifications()->count();
@endphp

<div class="off-canvas-menu-close dashboard-menu-close icon-element icon-element-sm shadow-sm" data-toggle="tooltip" data-placement="left" title="Close menu">
    <i class="la la-times"></i>
</div>

<div class="logo-box px-4">
    <a href="{{ route('index') }}" class="logo"><img src="{{ asset('frontend/images/logo.png') }}" alt="Nuvetic"></a>
</div>

<ul class="generic-list-item off-canvas-menu-list off--canvas-menu-list pt-35px">
    <li class="{{ request()->routeIs('dashboard') ? 'page-active' : '' }}">
        <a href="{{ route('dashboard') }}"><i class="la la-dashboard mr-2"></i>Dashboard</a>
    </li>

    <li class="{{ request()->routeIs('user.profile') ? 'page-active' : '' }}">
        <a href="{{ route('user.profile') }}"><i class="la la-user mr-2"></i>My Profile</a>
    </li>

    <li class="{{ request()->routeIs('my.course') ? 'page-active' : '' }}">
        <a href="{{ route('my.course') }}"><i class="la la-book mr-2"></i>My Courses</a>
    </li>

    <li class="{{ request()->routeIs('user.wishlist') ? 'page-active' : '' }}">
        <a href="{{ route('user.wishlist') }}"><i class="la la-heart-o mr-2"></i>Wishlist <span class="badge badge-info p-1 ml-2" id="wishQty">{{ $wishlistCount }}</span></a>
    </li>

    <li class="{{ request()->routeIs('live.chat') ? 'page-active' : '' }}">
        <a href="{{ route('live.chat') }}"><i class="la la-comments mr-2"></i>Live Chat</a>
    </li>

    <li>
        <a href="{{ route('mycart') }}"><i class="la la-shopping-cart mr-2"></i>My Cart <span class="badge badge-info p-1 ml-2" id="cartQty">0</span></a>
    </li>

    <li>
        <a href="{{ route('dashboard') }}"><i class="la la-bell-o mr-2"></i>Notifications @if($unreadCount > 0)<span class="badge badge-danger p-1 ml-2">{{ $unreadCount }}</span>@endif</a>
    </li>

    <li class="{{ request()->routeIs('user.change.password') ? 'page-active' : '' }}">
        <a href="{{ route('user.change.password') }}"><i class="la la-lock mr-2"></i>Change Password</a>
    </li>

    <li>
        <a href="{{ route('user.logout') }}"><i class="la la-power-off mr-2"></i>Logout</a>
    </li>
</ul>
