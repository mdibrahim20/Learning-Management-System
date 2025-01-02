@extends('frontend.dashboard.user_dashboard')
@section('userdashboard')

@php
    $userId = Auth::id();
    $profileData = App\Models\User::find($userId);

    $paymentIds = App\Models\Order::where('user_id', $userId)->distinct()->pluck('payment_id');

    $enrolledCourses = App\Models\Order::where('user_id', $userId)->distinct('course_id')->count('course_id');
    $wishlistCount = App\Models\Wishlist::where('user_id', $userId)->count();
    $questionCount = App\Models\Question::where('user_id', $userId)->count();
    $reviewCount = App\Models\Review::where('user_id', $userId)->count();
    $confirmedOrders = App\Models\Payment::whereIn('id', $paymentIds)->where('status', 'confirm')->count();
    $totalSpent = (float) App\Models\Payment::whereIn('id', $paymentIds)->sum('total_amount');
    $unreadNotifications = Auth::user()->unreadNotifications()->count();
@endphp

<div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between mb-5">
    <div class="media media-card align-items-center">
        <div class="media-img media--img media-img-md rounded-full">
            <img class="rounded-full" src="{{ !empty($profileData->photo) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="User">
        </div>
        <div class="media-body">
            <h2 class="section__title fs-30">Welcome back, {{ $profileData->name }}</h2>
            <div class="d-flex align-items-center pt-2">
                <span class="badge badge-info mr-2">{{ ucfirst($profileData->role) }}</span>
                <span class="text-gray fs-15">{{ $unreadNotifications }} unread notifications</span>
            </div>
        </div>
    </div>
</div>

<div class="section-block mb-5"></div>
<div class="dashboard-heading mb-4">
    <h3 class="fs-22 font-weight-semi-bold">Dashboard Overview</h3>
</div>

<div class="row">
    <div class="col-lg-4 responsive-column-half">
        <div class="card card-item dashboard-info-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon-element flex-shrink-0 bg-1 text-white"><i class="la la-book fs-24"></i></div>
                <div class="pl-4">
                    <p class="card-text fs-18">Enrolled Courses</p>
                    <h5 class="card-title pt-2 fs-26">{{ $enrolledCourses }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 responsive-column-half">
        <div class="card card-item dashboard-info-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon-element flex-shrink-0 bg-2 text-white"><i class="la la-heart fs-24"></i></div>
                <div class="pl-4">
                    <p class="card-text fs-18">Wishlist Items</p>
                    <h5 class="card-title pt-2 fs-26">{{ $wishlistCount }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 responsive-column-half">
        <div class="card card-item dashboard-info-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon-element flex-shrink-0 bg-3 text-white"><i class="la la-check-circle fs-24"></i></div>
                <div class="pl-4">
                    <p class="card-text fs-18">Confirmed Orders</p>
                    <h5 class="card-title pt-2 fs-26">{{ $confirmedOrders }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 responsive-column-half">
        <div class="card card-item dashboard-info-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon-element flex-shrink-0 bg-4 text-white"><i class="la la-dollar fs-24"></i></div>
                <div class="pl-4">
                    <p class="card-text fs-18">Total Spend</p>
                    <h5 class="card-title pt-2 fs-26">${{ number_format($totalSpent, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 responsive-column-half">
        <div class="card card-item dashboard-info-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon-element flex-shrink-0 bg-5 text-white"><i class="la la-question-circle fs-24"></i></div>
                <div class="pl-4">
                    <p class="card-text fs-18">Questions Asked</p>
                    <h5 class="card-title pt-2 fs-26">{{ $questionCount }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 responsive-column-half">
        <div class="card card-item dashboard-info-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon-element flex-shrink-0 bg-6 text-white"><i class="la la-star fs-24"></i></div>
                <div class="pl-4">
                    <p class="card-text fs-18">Reviews Given</p>
                    <h5 class="card-title pt-2 fs-26">{{ $reviewCount }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
