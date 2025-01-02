@php
    $setting = $siteSetting ?? App\Models\SiteSetting::query()->first();
    $settingLogo = $setting->logo ?? 'upload/no_image.jpg';
    $settingPhone = $setting->phone ?? '+1 234 567 8900';
    $settingEmail = $setting->email ?? 'support@lms.com';
    $settingAddress = $setting->address ?? '123 Learning Street';
    $settingCopyright = $setting->copyright ?? 'Copyright (c) 2026 LMS Project. All Rights Reserved.';
@endphp

<footer class="front-shell front-footer">
    <div class="footer-grid">
        <div>
            <a href="{{ url('/') }}" class="brand-logo" style="margin-bottom:8px;display:inline-flex">
                <img src="{{ asset($settingLogo) }}" alt="Footer Logo">
                <span>Nuvetic</span>
            </a>
            <p>{{ $settingAddress }}</p>
            <a href="tel:{{ $settingPhone }}">{{ $settingPhone }}</a>
            <a href="mailto:{{ $settingEmail }}">{{ $settingEmail }}</a>
        </div>

        <div>
            <h4>Learning</h4>
            <a href="{{ route('mycart') }}">My Cart</a>
            <a href="{{ route('blog') }}">Blog</a>
            <a href="{{ route('checkout') }}">Checkout</a>
            <a href="{{ route('become.instructor') }}">Become Instructor</a>
        </div>

        <div>
            <h4>Dashboards</h4>
            <a href="{{ route('dashboard') }}">Student Dashboard</a>
            <a href="{{ route('instructor.login') }}">Instructor Portal</a>
            <a href="{{ route('admin.login') }}">Admin Portal</a>
            <a href="{{ route('login') }}">Account Login</a>
        </div>

        <div>
            <h4>Connect</h4>
            <a href="{{ route('blog') }}">Blog Updates</a>
            <a href="mailto:{{ $settingEmail }}">Email Support</a>
            <p>Support hours: 24/7 for active learners.</p>
        </div>
    </div>

    <div class="footer-bottom">{{ $settingCopyright }}</div>
</footer>

