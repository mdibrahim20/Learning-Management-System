@extends('frontend.master')
@section('home')

@section('title')
Cart | Nuvetic
@endsection

<div class="front-shell">
    <section class="page-hero">
        <span class="kicker">Cart</span>
        <h1>Your Learning Cart</h1>
        <p style="color:var(--muted);margin:0">Review selected courses and continue to secure checkout.</p>
    </section>

    <section class="front-section" style="margin-top:14px;">
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Preview</th>
                        <th>Course</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cartPage"></tbody>
            </table>
        </div>

        <div class="page-grid" style="margin-top:14px;grid-template-columns:1fr 340px;">
            <div class="elegant-surface">
                @if(!Session::has('coupon'))
                <div id="couponField">
                    <label style="font-weight:700;font-size:14px">Have a coupon?</label>
                    <div class="input-group" style="margin-top:8px;max-width:460px;">
                        <input class="form-control form--control" type="text" id="coupon_name" placeholder="Enter coupon code">
                        <div class="input-group-append">
                            <a type="button" onclick="applyCoupon()" class="btn theme-btn">Apply</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div>
                <div class="elegant-surface" id="couponCalField"></div>
                <a href="{{ route('checkout') }}" class="front-btn primary" style="display:block;text-align:center;margin-top:10px;padding:12px 14px;">Proceed to Checkout</a>
            </div>
        </div>
    </section>
</div>

@endsection

