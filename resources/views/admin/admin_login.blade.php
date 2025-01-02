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
    <title>Admin Login</title>
    <style>
        body { font-family: "Plus Jakarta Sans", sans-serif; background: linear-gradient(160deg,#eaf2fb,#f4f8ff); min-height: 100vh; }
        .auth-shell { min-height: 100vh; display: grid; grid-template-columns: 1.2fr 1fr; }
        .auth-brand { padding: 56px; background: linear-gradient(145deg,#0e3865,#205c95); color:#fff; display:flex; flex-direction:column; justify-content:center; }
        .auth-brand h1 { font-size: 42px; font-weight: 800; margin-bottom: 12px; color:#fff; }
        .auth-brand p { color: rgba(255,255,255,.92); max-width: 520px; }
        .auth-badge { display:inline-flex; padding: 7px 14px; border:1px solid rgba(255,255,255,.35); border-radius: 999px; font-size:12px; margin-bottom:18px; }
        .auth-panel { display:flex; align-items:center; justify-content:center; padding: 30px; }
        .auth-card { width:100%; max-width: 460px; background:#fff; border:1px solid #dbe7f3; border-radius:20px; box-shadow: 0 20px 45px rgba(14,42,68,.12); padding: 28px; }
        .auth-title { font-size: 30px; font-weight: 800; margin-bottom: 2px; color:#17324d; }
        .auth-sub { color:#61788f; margin-bottom: 18px; }
        .google-btn { display:flex; align-items:center; justify-content:center; gap:8px; width:100%; border:1px solid #dbe7f3; background:#f5f9ff; color:#123e6a; border-radius:12px; padding:11px 14px; font-weight:700; text-decoration:none; }
        .google-btn:hover { background:#eaf3ff; color:#123e6a; }
        .divider { text-align:center; color:#7b8fa4; font-size:12px; margin:14px 0; position:relative; }
        .divider span { background:#fff; padding:0 10px; position:relative; z-index:2; }
        .divider:before { content:""; position:absolute; left:0; right:0; top:50%; border-top:1px solid #dce7f3; z-index:1; }
        .form-control { border-color:#d6e4f2; border-radius:10px; height:44px; }
        .form-control:focus { border-color:#2f6da8; box-shadow:0 0 0 .2rem rgba(47,109,168,.12); }
        .btn-primary { border-radius:12px; height:44px; background:#114a87; border-color:#114a87; font-weight:700; }
        .btn-primary:hover { background:#0f3d71; border-color:#0f3d71; }
        .auth-note { color:#698198; font-size:13px; margin-top:14px; text-align:center; }
        @media (max-width: 992px) { .auth-shell { grid-template-columns: 1fr; } .auth-brand { display:none; } }
    </style>
</head>
<body>
    <div class="auth-shell">
        <section class="auth-brand">
            <span class="auth-badge">Nuvetic Admin Panel</span>
            <h1>Command your platform with confidence.</h1>
            <p>Access order flow, content governance, user management, and reporting from one secure admin workspace.</p>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                <div class="mb-3 text-center">
                    <img src="{{ asset('backend/assets/images/logo-icon.png') }}" width="54" alt="logo">
                </div>
                <h3 class="auth-title">Admin Login</h3>
                <p class="auth-sub">Sign in to continue to the dashboard.</p>

                <a href="{{ route('social.redirect', 'google') }}" class="google-btn">
                    <i class="bx bxl-google"></i> Continue with Google
                </a>
                <div class="divider"><span>or use email and password</span></div>

                <form class="row g-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="admin@nuvetic.com" value="{{ old('email') }}">
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

                <p class="auth-note">Need student access? <a href="{{ route('login') }}">Go to user login</a></p>
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
