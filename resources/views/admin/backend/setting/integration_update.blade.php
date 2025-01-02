@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Integration Setting</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">Google & Stripe Integration</h5>
            <form action="{{ route('update.integration') }}" method="post" class="row g-3">
                @csrf

                <div class="col-md-12">
                    <h6 class="fw-bold">Google Login</h6>
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">Google Client ID</label>
                    <input type="text" name="google_client_id" class="form-control" value="{{ old('google_client_id', $integration->google_client_id) }}">
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">Google Client Secret</label>
                    <input type="password" name="google_client_secret" class="form-control" placeholder="Leave blank to keep existing secret">
                </div>

                <div class="form-group col-md-12">
                    <label class="form-label">Google Redirect URI</label>
                    <input type="url" name="google_redirect_uri" class="form-control" value="{{ old('google_redirect_uri', $integration->google_redirect_uri) }}">
                </div>

                <div class="col-md-12 mt-4">
                    <h6 class="fw-bold">Stripe Payment</h6>
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">Stripe Publishable Key</label>
                    <input type="text" name="stripe_key" class="form-control" value="{{ old('stripe_key', $integration->stripe_key) }}">
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">Stripe Secret Key</label>
                    <input type="password" name="stripe_secret" class="form-control" placeholder="Leave blank to keep existing secret">
                </div>

                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
