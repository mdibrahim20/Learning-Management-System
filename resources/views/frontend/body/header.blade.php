@php
    $setting = $siteSetting ?? App\Models\SiteSetting::query()->first();
    $settingPhone = $setting->phone ?? '+1 234 567 8900';
    $settingEmail = $setting->email ?? 'support@lms.com';
    $settingLogo = $setting->logo ?? 'upload/no_image.jpg';
    $categories = App\Models\Category::orderBy('category_name', 'asc')->take(10)->get();
@endphp

<div class="front-shell">
    <div class="front-topbar">
        <div>Reach us: <a href="tel:{{ $settingPhone }}">{{ $settingPhone }}</a> | <a href="mailto:{{ $settingEmail }}">{{ $settingEmail }}</a></div>
        <div>Elegant LMS experience for students, instructors, and admins</div>
    </div>

    <header class="front-nav">
        <a href="{{ url('/') }}" class="brand-logo">
            <img src="{{ asset($settingLogo) }}" alt="Logo">
            <span>Nuvetic</span>
        </a>

        <nav class="front-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('blog') }}">Blog</a>
            <a href="{{ route('mycart') }}">Cart</a>
            <a href="{{ route('become.instructor') }}">Become Instructor</a>
            <div class="front-dropdown">
                <button type="button" class="front-dropdown-toggle">Categories <i class="la la-angle-down"></i></button>
                <div class="front-dropdown-menu">
                    @foreach ($categories as $cat)
                        <a href="{{ url('category/'.$cat->id.'/'.$cat->category_slug) }}">{{ $cat->category_name }}</a>
                    @endforeach
                </div>
            </div>
        </nav>

        <div class="front-actions">
            <div class="shop-cart">
                <ul>
                    <li>
                        <p class="shop-cart-btn d-flex align-items-center front-btn" style="margin:0">
                            <i class="la la-shopping-cart"></i>
                            <span class="product-count" id="cartQty" style="margin-left:6px">0</span>
                        </p>
                        <ul class="cart-dropdown-menu">
                            <div id="miniCart"></div>
                            <br><br>
                            <li class="media media-card">
                                <div class="media-body fs-16">
                                    <p class="text-black font-weight-semi-bold lh-18">Total: $<span class="cart-total" id="cartSubTotal"></span></p>
                                </div>
                            </li>
                            <li><a href="{{ route('mycart') }}" class="btn theme-btn w-100">Go to cart</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="front-btn">Dashboard</a>
                @elseif (auth()->user()->role === 'instructor')
                    <a href="{{ route('instructor.dashboard') }}" class="front-btn">Dashboard</a>
                @else
                    <a href="{{ route('dashboard') }}" class="front-btn">Dashboard</a>
                @endif
                <a href="{{ route('user.logout') }}" class="front-btn primary">Logout</a>
            @else
                <a href="{{ route('login') }}" class="front-btn">Login</a>
                <a href="{{ route('register') }}" class="front-btn primary">Register</a>
            @endauth
        </div>
    </header>
</div>

