@extends('frontend.master')
@section('home')

@section('title')
Checkout | Nuvetic
@endsection

<div class="front-shell">
    <section class="page-hero">
        <span class="kicker">Checkout</span>
        <h1>Complete Your Enrollment</h1>
        <p style="color:var(--muted);margin:0">Secure payment and immediate course access after confirmation.</p>
    </section>

    <form method="post" action="{{ route('payment') }}" enctype="multipart/form-data">
        @csrf

        <section class="checkout-layout">
            <div class="elegant-surface">
                <h3>Billing Details</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input class="form-control" type="text" name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label>Address</label>
                        <input class="form-control" type="text" name="address" value="{{ Auth::user()->address }}" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label>Phone</label>
                        <input class="form-control" type="tel" name="phone" value="{{ Auth::user()->phone }}" required>
                    </div>
                </div>

                <h3 style="margin-top:8px;">Payment Method</h3>
                <div class="meta-list" style="grid-template-columns:1fr 1fr;">
                    <label class="meta-pill" style="cursor:pointer;display:flex;align-items:center;gap:8px;">
                        <input type="radio" name="cash_delivery" value="handcash" checked>
                        Direct Payment
                    </label>
                    <label class="meta-pill" style="cursor:pointer;display:flex;align-items:center;gap:8px;">
                        <input type="radio" name="cash_delivery" value="stripe">
                        Stripe Payment
                    </label>
                </div>
            </div>

            <div>
                <div class="elegant-surface">
                    <h3>Order Details</h3>
                    @foreach ($carts as $item)
                        <input type="hidden" name="sulg[]" value="{{ $item->options->slug }}">
                        <input type="hidden" name="course_id[]" value="{{ $item->id }}">
                        <input type="hidden" name="course_title[]" value="{{ $item->name }}">
                        <input type="hidden" name="price[]" value="{{ $item->price }}">
                        <input type="hidden" name="instructor_id[]" value="{{ $item->options->instructor }}">

                        <div class="order-item">
                            <img class="thumb-sm" src="{{ asset($item->options->image) }}" alt="{{ $item->name }}">
                            <div>
                                <a href="{{ url('course/details/'.$item->id.'/'.$item->options->slug) }}" style="font-weight:700;">{{ $item->name }}</a>
                            </div>
                            <div style="font-weight:800;color:var(--brand)">${{ $item->price }}</div>
                        </div>
                    @endforeach

                    <a href="{{ route('mycart') }}" class="front-btn" style="margin-top:8px;display:inline-block;">Edit Cart</a>
                </div>

                <div class="elegant-surface" style="margin-top:10px;">
                    <h3>Order Summary</h3>
                    @if (Session::has('coupon'))
                        <p style="margin-bottom:6px;">Subtotal: <strong>${{ $cartTotal }}</strong></p>
                        <p style="margin-bottom:6px;">Coupon: <strong>{{ session()->get('coupon')['coupon_name'] }}</strong> ({{ session()->get('coupon')['coupon_discount'] }}%)</p>
                        <p style="margin-bottom:6px;">Discount: <strong>${{ session()->get('coupon')['discount_amount'] }}</strong></p>
                        <p style="font-size:18px;font-weight:800;color:var(--brand)">Total: ${{ session()->get('coupon')['total_amount'] }}</p>
                        <input type="hidden" name="total" value="{{ $cartTotal }}">
                    @else
                        <p style="font-size:18px;font-weight:800;color:var(--brand)">Total: ${{ $cartTotal }}</p>
                        <input type="hidden" name="total" value="{{ $cartTotal }}">
                    @endif

                    <button type="submit" class="front-btn primary" style="display:block;width:100%;margin-top:10px;padding:12px 14px;">Place Order</button>
                </div>
            </div>
        </section>
    </form>
</div>

@endsection

