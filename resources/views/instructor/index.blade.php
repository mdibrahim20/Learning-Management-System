@extends('instructor.instructor_dashboard')
@section('instructor')

@php
  $id = Auth::user()->id;
  $instructorId = App\Models\User::find($id);
  $status = $instructorId->status;
@endphp

<div class="page-content">
  <section class="panel-hero">
      <h3>Instructor Workspace</h3>
      <p>Manage course delivery, monitor learner activity, and handle enrolled student orders.</p>
      <div class="panel-quick-links">
          <a class="panel-pill" href="{{ route('all.course') }}">My Courses</a>
          <a class="panel-pill" href="{{ route('instructor.all.order') }}">Orders</a>
          <a class="panel-pill" href="{{ route('instructor.all.review') }}">Reviews</a>
          <a class="panel-pill" href="{{ route('instructor.all.question') }}">Questions</a>
      </div>
  </section>

  @if ($status === '1')
      <p class="panel-note" style="border-color:#bae6d3;background:#ecfdf5;color:#05543a;">
          Instructor account status: <strong>Active</strong>
      </p>
  @else
      <p class="panel-note">
          Instructor account status: <strong>Inactive</strong>. Please wait for admin approval.
      </p>
  @endif

  <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3">
      <div class="col">
          <div class="panel-stat-card">
              <p class="panel-stat-title">Total Orders</p>
              <h4 class="panel-stat-value">{{ number_format($totalOrders) }}</h4>
              <p class="panel-stat-foot"><span class="panel-status {{ $ordersTrend >= 0 ? 'success' : 'warn' }}">{{ $ordersTrend >= 0 ? '+' : '' }}{{ $ordersTrend }}%</span> vs last month</p>
          </div>
      </div>
      <div class="col">
          <div class="panel-stat-card">
              <p class="panel-stat-title">Total Revenue</p>
              <h4 class="panel-stat-value">${{ number_format($totalRevenue, 2) }}</h4>
              <p class="panel-stat-foot"><span class="panel-status {{ $revenueTrend >= 0 ? 'success' : 'warn' }}">{{ $revenueTrend >= 0 ? '+' : '' }}{{ $revenueTrend }}%</span> vs last month</p>
          </div>
      </div>
      <div class="col">
          <div class="panel-stat-card">
              <p class="panel-stat-title">Pending Payment Ratio</p>
              <h4 class="panel-stat-value">{{ $pendingRatio }}%</h4>
              <p class="panel-stat-foot">{{ number_format($pendingPayments) }} pending payout records</p>
          </div>
      </div>
      <div class="col">
          <div class="panel-stat-card">
              <p class="panel-stat-title">Active Course Ratio</p>
              <h4 class="panel-stat-value">{{ $activeCourseRatio }}%</h4>
              <p class="panel-stat-foot">{{ number_format($activeCourses) }} active / {{ number_format($totalCourses) }} total courses</p>
          </div>
      </div>
  </div>

  <div class="row mt-3">
      <div class="col-12 d-flex">
          <div class="card w-100">
              <div class="card-header bg-transparent border-0 pb-0">
                  <h5 class="mb-1">Performance Overview</h5>
                  <p class="text-muted mb-0">Monthly orders and confirmed revenue for your courses.</p>
              </div>
              <div class="card-body">
                  <div class="d-flex align-items-center ms-auto font-13 gap-2 mb-3">
                      <span class="border px-2 py-1 rounded"><i class="ri-checkbox-blank-circle-fill me-1" style="color: #14abef"></i>Orders</span>
                      <span class="border px-2 py-1 rounded"><i class="ri-checkbox-blank-circle-fill me-1" style="color: #ffc107"></i>Revenue</span>
                  </div>
                  <div class="chart-container-1">
                      <canvas id="chart1"></canvas>
                  </div>
              </div>
              <div class="row row-cols-1 row-cols-md-3 g-0 text-center border-top">
                  <div class="col panel-surface-soft">
                      <div class="p-3">
                          <h5 class="mb-0">{{ number_format($pendingPayments) }}</h5>
                          <small class="mb-0 text-muted">Pending Payments</small>
                      </div>
                  </div>
                  <div class="col">
                      <div class="p-3">
                          <h5 class="mb-0">{{ number_format($totalCourses) }}</h5>
                          <small class="mb-0 text-muted">Courses Created</small>
                      </div>
                  </div>
                  <div class="col panel-surface-soft">
                      <div class="p-3">
                          <h5 class="mb-0">{{ number_format($activeCourses) }}</h5>
                          <small class="mb-0 text-muted">Active Courses</small>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="card mt-3">
      <div class="card-header bg-transparent border-0 pb-0">
          <h5 class="mb-1">Recent Orders</h5>
          <p class="text-muted mb-0">Latest payment and shipment status for your course sales.</p>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table align-middle mb-0">
                  <thead>
                      <tr>
                          <th>Course</th>
                          <th>Photo</th>
                          <th>Invoice</th>
                          <th>Status</th>
                          <th>Amount</th>
                          <th>Date</th>
                          <th>Items</th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($recentOrders as $order)
                          <tr>
                              <td>{{ \Illuminate\Support\Str::limit($order->course?->course_name ?? $order->course_title, 34) }}</td>
                              <td><img src="{{ asset($order->course?->course_image ?? 'upload/no_image.jpg') }}" class="product-img-2" alt="course img"></td>
                              <td>{{ $order->payment?->invoice_no ?? 'N/A' }}</td>
                              <td>
                                  <span class="badge {{ ($order->payment?->status === 'confirm') ? 'bg-gradient-quepal' : 'bg-gradient-blooker' }} text-white shadow-sm w-100">
                                      {{ ucfirst($order->payment?->status ?? 'pending') }}
                                  </span>
                              </td>
                              <td>${{ number_format((float) ($order->price ?? 0), 2) }}</td>
                              <td>{{ $order->payment?->order_date ?? '-' }}</td>
                              <td>1</td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="7" class="text-center text-muted">No recent instructor orders found.</td>
                          </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<script>
    window.panelChartConfig = {
        labels: @json($months),
        seriesOneName: 'Orders',
        seriesOne: @json($monthlyOrders),
        seriesTwoName: 'Revenue',
        seriesTwo: @json($monthlyRevenue)
    };
</script>

@endsection
