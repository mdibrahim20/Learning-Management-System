<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('backend/assets/images/favicon-32x32.png') }}" type="image/png" />
    <link href="{{ asset('backend/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/assets/js/pace.min.js') }}"></script>
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <title>Instructor Login</title>
    <style>
        body { font-family: "Plus Jakarta Sans", sans-serif; background: linear-gradient(160deg,#edf6ff,#f8fbff); min-height: 100vh; }
        .auth-shell { min-height: 100vh; display: grid; grid-template-columns: 1.2fr 1fr; }
        .auth-brand { padding: 56px; background: linear-gradient(145deg,#0d4c4f,#17807f); color:#fff; display:flex; flex-direction:column; justify-content:center; }
        .auth-brand h1 { font-size: 42px; font-weight: 800; margin-bottom: 12px; color:#fff; }
        .auth-brand p { color: rgba(255,255,255,.92); max-width: 520px; }
        .auth-badge { display:inline-flex; padding: 7px 14px; border:1px solid rgba(255,255,255,.35); border-radius: 999px; font-size:12px; margin-bottom:18px; }
        .auth-panel { display:flex; align-items:center; justify-content:center; padding: 30px; }
        .auth-card { width:100%; max-width: 460px; background:#fff; border:1px solid #d7ecec; border-radius:20px; box-shadow: 0 20px 45px rgba(10,56,58,.12); padding: 28px; }
        .auth-title { font-size: 30px; font-weight: 800; margin-bottom: 2px; color:#174243; }
        .auth-sub { color:#5f7f80; margin-bottom: 18px; }
        .google-btn { display:flex; align-items:center; justify-content:center; gap:8px; width:100%; border:1px solid #d7ecec; background:#f3fbfb; color:#145f61; border-radius:12px; padding:11px 14px; font-weight:700; text-decoration:none; }
        .google-btn:hover { background:#e8f7f7; color:#145f61; }
        .divider { text-align:center; color:#7c9696; font-size:12px; margin:14px 0; position:relative; }
        .divider span { background:#fff; padding:0 10px; position:relative; z-index:2; }
        .divider:before { content:""; position:absolute; left:0; right:0; top:50%; border-top:1px solid #dceeee; z-index:1; }
        .form-control { border-color:#d2e7e7; border-radius:10px; height:44px; }
        .form-control:focus { border-color:#1c7a7d; box-shadow:0 0 0 .2rem rgba(28,122,125,.12); }
        .btn-primary { border-radius:12px; height:44px; background:#166a6d; border-color:#166a6d; font-weight:700; }
        .btn-primary:hover { background:#12585a; border-color:#12585a; }
        .auth-note { color:#658484; font-size:13px; margin-top:14px; text-align:center; }
        @media (max-width: 992px) { .auth-shell { grid-template-columns: 1fr; } .auth-brand { display:none; } }
    </style>
</head>
<body>
    <div class="auth-shell">
        <section class="auth-brand">
            <span class="auth-badge">Nuvetic Instructor Panel</span>
            <h1>Teach, track, and scale your courses.</h1>
            <p>Access your course manager, learner orders, questions, and review analytics from one focused workspace.</p>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                <div class="mb-3 text-center">
                    <img src="{{ asset('backend/assets/images/logo-icon.png') }}" width="54" alt="logo">
                </div>
                <h3 class="auth-title">Instructor Login</h3>
                <p class="auth-sub">Sign in to continue to your instructor dashboard.</p>

                <a href="{{ route('social.redirect', 'google') }}" class="google-btn">
                    <i class="bx bxl-google"></i> Continue with Google
                </a>
                <div class="divider"><span>or use email and password</span></div>

                <form class="row g-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="instructor@nuvetic.com" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" name="password" id="password" class="form-control border-end-0 @error('password') is-invalid @enderror" placeholder="Enter password">
                            <a href="javascript:void(0)" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                    </div>
                </form>

                <p class="auth-note">Want to become an instructor? <a href="{{ route('become.instructor') }}">Apply here</a></p>
            </div>
        </section>
    </div>

    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide").removeClass("bx-show");
                } else {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide").addClass("bx-show");
                }
            });
        });
    </script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
     @if(Session::has('message'))
     var type = "{{ Session::get('alert-type','info') }}"
     switch(type){
        case 'info': toastr.info(" {{ Session::get('message') }} "); break;
        case 'success': toastr.success(" {{ Session::get('message') }} "); break;
        case 'warning': toastr.warning(" {{ Session::get('message') }} "); break;
        case 'error': toastr.error(" {{ Session::get('message') }} "); break;
     }
     @endif
    </script>
</body>
</html>
