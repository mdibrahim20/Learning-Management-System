@extends('frontend.master')
@section('home')
@section('title')
Register Page | Nuvetic
@endsection

<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area section-padding img-bg-2">
    <div class="overlay"></div>
    <div class="container">
        <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
            <div class="section-heading">
                <h2 class="section__title text-white">Create your account</h2>
            </div>
            <ul class="generic-list-item generic-list-item-white generic-list-item-arrow d-flex flex-wrap align-items-center">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Account</li>
                <li>Register</li>
            </ul>
        </div>
    </div>
</section>
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<!-- ================================
       START CONTACT AREA
================================= -->
<section class="contact-area section--padding auth-shell">
    <div class="container">
        <div class="auth-wrap">
            <div class="auth-copy">
                <span class="auth-chip">Nuvetic Access</span>
                <h3>Join Nuvetic and start learning.</h3>
                <p>Create a student account in seconds and access your personalized learning dashboard.</p>
                <ul class="auth-points">
                    <li><i class="la la-check-circle"></i> One-click Google registration</li>
                    <li><i class="la la-check-circle"></i> Personalized dashboard access</li>
                    <li><i class="la la-check-circle"></i> Secure account protection</li>
                </ul>
            </div>
            <div class="auth-card">
                <h4>Create your account</h4>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" class="pt-3" action="{{ route('register') }}">
                    @csrf
                    <a href="{{ route('social.redirect', 'google') }}" class="auth-google-btn">
                        <i class="la la-google"></i> Continue with Google
                    </a>
                    <div class="auth-divider"><span>or register with email</span></div>
                    <div class="input-box">
                        <label class="label-text">Full Name</label>
                        <div class="form-group">
                            <input class="form-control form--control" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" required>
                            <span class="la la-user input-icon"></span>
                        </div>
                    </div>
                    <div class="input-box">
                        <label class="label-text">Email</label>
                        <div class="form-group">
                            <input class="form-control form--control" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                            <span class="la la-envelope input-icon"></span>
                        </div>
                    </div>
                    <div class="input-box">
                        <label class="label-text">Password</label>
                        <div class="form-group">
                            <input class="form-control form--control" id="password" type="password" name="password" placeholder="Create password" required>
                            <span class="la la-lock input-icon"></span>
                        </div>
                    </div>
                    <div class="input-box">
                        <label class="label-text">Confirm Password</label>
                        <div class="form-group">
                            <input class="form-control form--control" id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm password" required>
                            <span class="la la-lock input-icon"></span>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox mb-2 fs-15">
                        <input type="checkbox" class="custom-control-input" id="receiveCheckbox" required>
                        <label class="custom-control-label custom--control-label lh-20" for="receiveCheckbox">Send me product updates, learning tips, and special offers.</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-4 fs-15">
                        <input type="checkbox" class="custom-control-input" id="agreeCheckbox" required>
                        <label class="custom-control-label custom--control-label" for="agreeCheckbox">I agree to the terms and privacy policy.</label>
                    </div>
                    <button class="btn theme-btn w-100" type="submit">Register Account <i class="la la-arrow-right icon ml-1"></i></button>
                    <p class="fs-14 pt-3 mb-0 text-center">Already have an account? <a href="{{ route('login') }}" class="text-color hover-underline">Log in</a></p>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- ================================
       END CONTACT AREA
================================= -->

@endsection
