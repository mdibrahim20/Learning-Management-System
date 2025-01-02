@php
    $instructorId = Auth::id();
    $profileData = App\Models\User::find($instructorId);
    $ncount = Auth::user()->unreadNotifications()->count();
    $notifications = Auth::user()->notifications->take(8);

    $instructorCourseCount = App\Models\Course::where('instructor_id', $instructorId)->count();
    $instructorActiveCourseCount = App\Models\Course::where('instructor_id', $instructorId)->where('status', 1)->count();
    $instructorOrderCount = App\Models\Order::where('instructor_id', $instructorId)->count();
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
                            <span class="alert-count" id="notification-count">{{ $ncount }}</span>
                            <i class='ri-notification-3-line'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0)">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-badge">{{ $ncount }} unread</p>
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                @forelse ($notifications as $notification)
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="markNotificationRead('{{ $notification->id }}')">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-danger text-danger">N</div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">{{ \Illuminate\Support\Str::limit($notification->data['message'] ?? 'Notification', 38) }}
                                                    <span class="msg-time float-end">{{ $notification->created_at->diffForHumans() }}</span>
                                                </h6>
                                                <p class="msg-info">Order/learner update</p>
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
                                <a class="dropdown-item" href="{{ route('all.course') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="notify bg-light-primary text-primary"><i class="ri-book-open-line"></i></div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name mb-0">My Courses</h6>
                                            <p class="msg-info mb-0">{{ number_format($instructorCourseCount) }} total / {{ number_format($instructorActiveCourseCount) }} active</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="{{ route('instructor.all.order') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="notify bg-light-success text-success"><i class="ri-shopping-bag-3-line"></i></div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name mb-0">My Orders</h6>
                                            <p class="msg-info mb-0">{{ number_format($instructorOrderCount) }} order items</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="{{ route('instructor.all.review') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="notify bg-light-warning text-warning"><i class="ri-star-smile-line"></i></div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name mb-0">Reviews</h6>
                                            <p class="msg-info mb-0">Manage student feedback</p>
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
                    <img src="{{ (!empty($profileData->photo)) ? url('upload/instructor_images/'.$profileData->photo) : url('upload/no_image.jpg')}}" class="user-img" alt="user avatar">
                    <div class="user-info">
                        <p class="user-name mb-0">{{ $profileData->name }}</p>
                        <p class="designattion mb-0">{{ $profileData->email }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('instructor.profile') }}"><i class="ri-user-3-line fs-5"></i><span>Profile</span></a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('instructor.change.password') }}"><i class="ri-settings-3-line fs-5"></i><span>Change Password</span></a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('instructor.dashboard') }}"><i class="ri-layout-grid-line fs-5"></i><span>Dashboard</span></a></li>
                    <li><div class="dropdown-divider mb-0"></div></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('instructor.logout') }}"><i class="ri-logout-circle-r-line"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<script>
    function markNotificationRead(notificationId) {
        fetch('/mark-notification-as-read/' + notificationId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('notification-count').textContent = data.count;
        })
        .catch(error => {
            console.log('Error', error);
        });
    }
</script>
