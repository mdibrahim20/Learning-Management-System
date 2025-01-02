<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { margin: 0; padding: 22px; }
        .invoice-wrap { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #1f2a37; }
        .invoice-header { border: 1px solid #d9e1ea; background: #f7faff; border-radius: 10px; padding: 14px; }
        .invoice-title { color: #0d3b66; font-size: 22px; margin: 0; }
        .muted { color: #5b6675; }
        .row { width: 100%; margin-top: 12px; }
        .col { width: 48%; display: inline-block; vertical-align: top; }
        .right { text-align: right; }
        .invoice-table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        .invoice-table th, .invoice-table td { border: 1px solid #d9e1ea; padding: 8px; }
        .invoice-table th { background: #e8f0fb; color: #0d3b66; }
        .summary { margin-top: 14px; text-align: right; }
        .summary p { margin: 4px 0; }
        .total { font-size: 18px; color: #0d3b66; font-weight: 700; }
    </style>
</head>
<body>
<div class="invoice-wrap">
    <div class="invoice-header">
        <table width="100%" style="border:none;">
            <tr>
                <td style="border:none;">
                    <h1 class="invoice-title">Nuvetic Invoice</h1>
                    <p class="muted" style="margin:4px 0 0;">Premium LMS billing statement</p>
                </td>
                <td style="border:none;" class="right">
                    <p style="margin:0;"><strong>Invoice #</strong> {{ $payment->invoice_no }}</p>
                    <p style="margin:2px 0 0;" class="muted">Order Date: {{ $payment->order_date }}</p>
                    <p style="margin:2px 0 0;" class="muted">Payment: {{ $payment->payment_type }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col">
            <p style="margin:0 0 6px;"><strong>Billed To</strong></p>
            <p style="margin:0;">{{ $payment->name }}</p>
            <p style="margin:2px 0 0;" class="muted">{{ $payment->email }}</p>
            <p style="margin:2px 0 0;" class="muted">{{ $payment->phone }}</p>
            <p style="margin:2px 0 0;" class="muted">{{ $payment->address }}</p>
        </div>
        <div class="col right">
            <p style="margin:0 0 6px;"><strong>Issued By</strong></p>
            <p style="margin:0;">Nuvetic</p>
            <p style="margin:2px 0 0;" class="muted">support@lms.com</p>
            <p style="margin:2px 0 0;" class="muted">Dhaka, Bangladesh</p>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th style="text-align:left;">Course</th>
                <th width="120">Instructor</th>
                <th width="90">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItem as $item)
                <tr>
                    <td>{{ $item->course->course_name }}</td>
                    <td>{{ $item->instructor->name ?? 'Instructor' }}</td>
                    <td>{{ $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p>Subtotal: {{ $payment->total_amount }}</p>
        <p class="total">Total: {{ $payment->total_amount }}</p>
    </div>

    <p class="muted" style="margin-top:20px;">Thank you for learning with Nuvetic.</p>
</div>
</body>
</html>

