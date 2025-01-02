@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <section class="panel-hero">
        <h3>Admin Command Center</h3>
        <p>Track orders, monitor platform health, and move quickly across Nuvetic operations.</p>
        <div class="panel-quick-links">
            <a class="panel-pill" href="{{ route('admin.pending.order') }}">Pending Orders</a>
            <a class="panel-pill" href="{{ route('admin.confirm.order') }}">Confirmed Orders</a>
            <a class="panel-pill" href="{{ route('admin.all.course') }}">All Courses</a>
            <a class="panel-pill" href="{{ route('all.user') }}">Users</a>
        </div>
    </section>

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
                <p class="panel-stat-title">Pending Orders Ratio</p>
                <h4 class="panel-stat-value">{{ $pendingRatio }}%</h4>
                <p class="panel-stat-foot">{{ number_format($pendingOrders) }} pending / {{ number_format($confirmOrders) }} confirmed</p>
                </div>
            </div>
            <div class="col">
                <div class="panel-stat-card">
                <p class="panel-stat-title">User Activation</p>
                <h4 class="panel-stat-value">{{ $activationRatio }}%</h4>
                <p class="panel-stat-foot">{{ number_format($totalStudents) }} students, {{ number_format($totalInstructors) }} instructors</p>
                </div>
            </div>
        </div>

    <div class="row mt-3">
        <div class="col-12 d-flex">
            <div class="card w-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="mb-1">Sales Overview</h5>
                    <p class="text-muted mb-0">Monthly orders and confirmed revenue.</p>
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
                            <h5 class="mb-0">{{ number_format($pendingOrders) }}</h5>
                            <small class="mb-0 text-muted">Pending Payments</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3">
                            <h5 class="mb-0">{{ number_format($confirmOrders) }}</h5>
                            <small class="mb-0 text-muted">Confirmed Payments</small>
                        </div>
                    </div>
                    <div class="col panel-surface-soft">
                        <div class="p-3">
                            <h5 class="mb-0">{{ number_format($totalCourses ?? 0) }}</h5>
                            <small class="mb-0 text-muted">Courses in Catalog</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-transparent border-0 pb-0">
            <h5 class="mb-1">Recent Orders</h5>
            <p class="text-muted mb-0">Latest order statuses and shipping progress.</p>
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
                                <td>{{ \Illuminate\Support\Str::limit($order['course_title'], 34) }}</td>
                                <td><img src="{{ asset($order['course_image']) }}" class="product-img-2" alt="course img"></td>
                                <td>{{ $order['invoice_no'] }}</td>
                                <td>
                                    <span class="badge {{ $order['status'] === 'confirm' ? 'bg-gradient-quepal' : 'bg-gradient-blooker' }} text-white shadow-sm w-100">
                                        {{ ucfirst($order['status']) }}
                                    </span>
                                </td>
                                <td>${{ number_format($order['total_amount'], 2) }}</td>
                                <td>{{ $order['order_date'] }}</td>
                                <td>{{ $order['items_count'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No recent orders found.</td>
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
