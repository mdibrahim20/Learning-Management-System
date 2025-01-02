@php
    $adminId = Auth::id();
    $profileData = App\Models\User::find($adminId);
    $adminNotifications = Auth::user()->notifications->take(8);
    $adminUnreadCount = Auth::user()->unreadNotifications()->count();

    $adminPendingCount = App\Models\Payment::where('status', 'pending')->count();
    $adminUserCount = App\Models\User::where('role', 'user')->count();
    $adminCourseCount = App\Models\Course::count();
@endphp

<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='ri-menu-2-line'></i></div>

            <div class="position-relative search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                <input class="form-control px-5" disabled type="search" placeholder="Search">
                <span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 fs-5"><i class='ri-search-2-line'></i></span>
            </div>

            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a class="nav-link" href="javascript:void(0)"><i class='ri-search-2-line'></i></a>
                    </li>
                    <li class="nav-item dark-mode d-none d-sm-flex">
                        <a class="nav-link dark-mode-icon" href="javascript:void(0)"><i class='ri-contrast-2-line'></i></a>
                    </li>

                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown">
                            <span class="alert-count">{{ $adminUnreadCount }}</span>
                            <i class='ri-notification-3-line'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0)">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-badge">{{ $adminUnreadCount }} unread</p>
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                @forelse ($adminNotifications as $notification)
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-info text-info">N</div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">{{ \Illuminate\Support\Str::limit($notification->data['message'] ?? 'Notification', 38) }}
                                                    <span class="msg-time float-end">{{ $notification->created_at->diffForHumans() }}</span>
                                                </h6>
                                                <p class="msg-info">System update</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="dropdown-item text-muted">No notifications yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='ri-dashboard-horizontal-line'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0)">
                                <div class="msg-header">
                                    <p class="msg-header-title">Quick Overview</p>
                                    <p class="msg-header-badge">Live</p>
                                </div>
                            </a>
                            <div class="header-message-list">
                                <a class="dropdown-item" href="{{ route('admin.pending.order') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="notify bg-light-warning text-warning"><i class="ri-time-line"></i></div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name mb-0">Pending Orders</h6>
                                            <p class="msg-info mb-0">{{ number_format($adminPendingCount) }} awaiting action</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="{{ route('all.user') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="notify bg-light-primary text-primary"><i class="ri-team-line"></i></div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name mb-0">Registered Users</h6>
                                            <p class="msg-info mb-0">{{ number_format($adminUserCount) }} students</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.all.course') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="notify bg-light-success text-success"><i class="ri-book-open-line"></i></div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name mb-0">Courses</h6>
                                            <p class="msg-info mb-0">{{ number_format($adminCourseCount) }} total courses</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ (!empty($profileData->photo)) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg')}}" class="user-img" alt="user avatar">
                    <div class="user-info">
                        <p class="user-name mb-0">{{ $profileData->name }}</p>
                        <p class="designattion mb-0">{{ $profileData->email }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile') }}"><i class="ri-user-3-line fs-5"></i><span>Profile</span></a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.change.password') }}"><i class="ri-settings-3-line fs-5"></i><span>Change Password</span></a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.dashboard') }}"><i class="ri-layout-grid-line fs-5"></i><span>Dashboard</span></a></li>
                    <li><div class="dropdown-divider mb-0"></div></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}"><i class="ri-logout-circle-r-line"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
