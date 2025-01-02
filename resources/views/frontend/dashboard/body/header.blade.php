<header class="header-menu-area">
    @php
        $authUser = Auth::user();
        $profileData = App\Models\User::find($authUser->id);
        $wishlistCount = App\Models\Wishlist::where('user_id', $authUser->id)->count();
        $unreadCount = $authUser->unreadNotifications()->count();
        $recentNotifications = $authUser->notifications()->latest()->take(6)->get();
    @endphp

    <div class="header-menu-content dashboard-menu-content pr-30px pl-30px bg-white shadow-sm">
        <div class="container-fluid">
            <div class="main-menu-content">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="logo-box logo--box">
                            <a href="{{ route('index') }}" class="logo"><img src="{{ asset('frontend/images/logo.png') }}" alt="Nuvetic"></a>
                            <div class="user-btn-action">
                                <div class="search-menu-toggle icon-element icon-element-sm shadow-sm mr-2" data-toggle="tooltip" data-placement="top" title="Search">
                                    <i class="la la-search"></i>
                                </div>
                                <div class="off-canvas-menu-toggle cat-menu-toggle icon-element icon-element-sm shadow-sm mr-2" data-toggle="tooltip" data-placement="top" title="Dashboard menu">
                                    <i class="la la-th-large"></i>
                                </div>
                                <div class="off-canvas-menu-toggle main-menu-toggle icon-element icon-element-sm shadow-sm" data-toggle="tooltip" data-placement="top" title="Main menu">
                                    <i class="la la-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="menu-wrapper">
                            <form method="get" action="{{ url('/') }}" class="mr-auto ml-0">
                                <div class="form-group mb-0">
                                    <input class="form-control form--control form--control-gray pl-3" type="text" name="search" placeholder="Search courses">
                                    <span class="la la-search search-icon"></span>
                                </div>
                            </form>

                            <div class="nav-right-button d-flex align-items-center">
                                <div class="user-action-wrap d-flex align-items-center">
                                    <div class="shop-cart wishlist-cart pr-3 mr-3 border-right border-right-gray">
                                        <ul>
                                            <li>
                                                <a class="shop-cart-btn" href="{{ route('user.wishlist') }}">
                                                    <i class="la la-heart-o"></i>
                                                    <span class="dot-status bg-1" id="wishQtyTop">{{ $wishlistCount }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="shop-cart notification-cart pr-3 mr-3 border-right border-right-gray">
                                        <ul>
                                            <li>
                                                <p class="shop-cart-btn">
                                                    <i class="la la-bell"></i>
                                                    @if($unreadCount > 0)
                                                        <span class="dot-status bg-1">{{ $unreadCount }}</span>
                                                    @endif
                                                </p>
                                                <ul class="cart-dropdown-menu after-none p-0 notification-dropdown-menu">
                                                    <li class="menu-heading-block d-flex align-items-center justify-content-between">
                                                        <h4>Notifications</h4>
                                                        <span class="ribbon fs-14">{{ $recentNotifications->count() }}</span>
                                                    </li>
                                                    <li>
                                                        <div class="notification-body">
                                                            @forelse($recentNotifications as $notification)
                                                                <a href="javascript:void(0)" onclick="markUserNotificationRead('{{ $notification->id }}')" class="media media-card align-items-center">
                                                                    <div class="icon-element icon-element-sm flex-shrink-0 {{ $notification->read_at ? 'bg-5' : 'bg-1' }} mr-3 text-white">
                                                                        <i class="la {{ $notification->read_at ? 'la-check' : 'la-bell' }}"></i>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <h5>{{ \Illuminate\Support\Str::limit($notification->data['message'] ?? 'New notification', 58) }}</h5>
                                                                        <span class="d-block lh-18 pt-1 text-gray fs-13">{{ $notification->created_at->diffForHumans() }}</span>
                                                                    </div>
                                                                </a>
                                                            @empty
                                                                <div class="p-3 text-muted fs-14">No notifications yet.</div>
                                                            @endforelse
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="shop-cart user-profile-cart">
                                        <ul>
                                            <li>
                                                <div class="shop-cart-btn">
                                                    <div class="avatar-xs">
                                                        <img class="rounded-full img-fluid" src="{{ !empty($profileData->photo) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="Avatar">
                                                    </div>
                                                    <span class="dot-status bg-1"></span>
                                                </div>
                                                <ul class="cart-dropdown-menu after-none p-0 notification-dropdown-menu">
                                                    <li class="menu-heading-block d-flex align-items-center">
                                                        <a href="{{ route('user.profile') }}" class="avatar-sm flex-shrink-0 d-block">
                                                            <img class="rounded-full img-fluid" src="{{ !empty($profileData->photo) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="Avatar">
                                                        </a>
                                                        <div class="ml-2">
                                                            <h4><a href="{{ route('user.profile') }}" class="text-black">{{ $profileData->name }}</a></h4>
                                                            <span class="d-block fs-14 lh-20">{{ $profileData->email }}</span>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <ul class="generic-list-item">
                                                            <li><a href="{{ route('dashboard') }}"><i class="la la-dashboard mr-1"></i> Dashboard</a></li>
                                                            <li><a href="{{ route('my.course') }}"><i class="la la-book mr-1"></i> My Courses</a></li>
                                                            <li><a href="{{ route('user.wishlist') }}"><i class="la la-heart mr-1"></i> Wishlist</a></li>
                                                            <li><a href="{{ route('user.profile') }}"><i class="la la-user mr-1"></i> Edit Profile</a></li>
                                                            <li><a href="{{ route('user.change.password') }}"><i class="la la-lock mr-1"></i> Change Password</a></li>
                                                            <li><div class="section-block"></div></li>
                                                            <li><a href="{{ route('user.logout') }}"><i class="la la-power-off mr-1"></i> Logout</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="off-canvas-menu custom-scrollbar-styled main-off-canvas-menu">
        <div class="off-canvas-menu-close main-menu-close icon-element icon-element-sm shadow-sm" data-toggle="tooltip" data-placement="left" title="Close menu">
            <i class="la la-times"></i>
        </div>

        <h4 class="off-canvas-menu-heading pt-90px">Alerts</h4>
        <ul class="generic-list-item off-canvas-menu-list pt-1 pb-2 border-bottom border-bottom-gray">
            <li><a href="{{ route('dashboard') }}">Notifications</a></li>
            <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
            <li><a href="{{ route('mycart') }}">My Cart</a></li>
        </ul>

        <h4 class="off-canvas-menu-heading pt-20px">Account</h4>
        <ul class="generic-list-item off-canvas-menu-list pt-1 pb-2 border-bottom border-bottom-gray">
            <li><a href="{{ route('user.profile') }}">Account Settings</a></li>
            <li><a href="{{ route('user.change.password') }}">Change Password</a></li>
        </ul>

        <h4 class="off-canvas-menu-heading pt-20px">Learning</h4>
        <ul class="generic-list-item off-canvas-menu-list pt-1">
            <li><a href="{{ route('my.course') }}">My Courses</a></li>
            <li><a href="{{ url('/') }}">Browse Courses</a></li>
            <li><a href="{{ route('user.logout') }}">Log out</a></li>
        </ul>
    </div>
</header>

<script>
    function markUserNotificationRead(notificationId) {
        fetch('/mark-notification-as-read/' + notificationId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(function () {
            location.reload();
        });
    }
</script>
