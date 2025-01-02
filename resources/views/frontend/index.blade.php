@extends('frontend.master')
@section('home')

@section('title')
Nuvetic | Modern LMS
@endsection

@php
    $categories = App\Models\Category::orderBy('category_name', 'asc')->take(10)->get();
    $courseCountByCategory = App\Models\Course::selectRaw('category_id, COUNT(*) as total')
        ->groupBy('category_id')
        ->pluck('total', 'category_id');
    $featuredCourses = App\Models\Course::with('user')->where('status', 1)->latest()->take(9)->get();
    $latestPosts = App\Models\BlogPost::with('blog')->latest()->take(3)->get();
    $statsCourses = App\Models\Course::where('status', 1)->count();
    $statsStudents = App\Models\User::where('role', 'user')->count();
    $statsInstructors = App\Models\User::where('role', 'instructor')->count();
@endphp

<div class="front-shell">
    <section class="hero-wrap">
        <div>
            <span class="hero-kicker">New Learning Experience</span>
            <h1 class="hero-title">Elegant learning platform for students, instructors, and admins.</h1>
            <p class="hero-copy">
                Track progress, manage courses, and build real skills through a cleaner learning journey aligned with your dashboard workflows.
            </p>
            <div class="hero-stat-grid">
                <div class="stat-box">
                    <strong>{{ number_format($statsCourses) }}</strong>
                    <span>Active courses</span>
                </div>
                <div class="stat-box">
                    <strong>{{ number_format($statsStudents) }}</strong>
                    <span>Students enrolled</span>
                </div>
                <div class="stat-box">
                    <strong>{{ number_format($statsInstructors) }}</strong>
                    <span>Expert instructors</span>
                </div>
            </div>
        </div>

        <aside class="hero-panel">
            <h3 style="margin-bottom: 10px;">Dashboard Quick Access</h3>
            <p class="hero-copy" style="font-size:14px;margin-bottom:12px;">Jump directly to role-based panels.</p>
            <div style="display:grid;gap:10px;">
                <a class="front-btn" href="{{ route('dashboard') }}">Student Dashboard</a>
                <a class="front-btn" href="{{ route('instructor.login') }}">Instructor Login</a>
                <a class="front-btn" href="{{ route('admin.login') }}">Admin Login</a>
                <a class="front-btn primary" href="{{ route('become.instructor') }}">Become an Instructor</a>
            </div>
        </aside>
    </section>

    <section class="front-section">
        <div class="section-head">
            <div>
                <h2>Explore Categories</h2>
                <p>Discover domains that match your dashboard goals and learning path.</p>
            </div>
        </div>

        <div class="category-grid">
            @forelse ($categories as $cat)
                <a class="category-card" href="{{ url('category/'.$cat->id.'/'.$cat->category_slug) }}">
                    <h3 style="font-size:18px;margin-bottom:6px;">{{ $cat->category_name }}</h3>
                    <span class="count">{{ $courseCountByCategory[$cat->id] ?? 0 }} courses</span>
                </a>
            @empty
                <div class="category-card">No categories available yet.</div>
            @endforelse
        </div>
    </section>

    <section class="front-section">
        <div class="section-head">
            <div>
                <h2>Featured Courses</h2>
                <p>Fresh, high-impact courses selected for practical outcomes.</p>
            </div>
            <a class="front-btn" href="{{ route('mycart') }}">View Cart</a>
        </div>

        <div class="course-grid">
            @forelse ($featuredCourses as $course)
                <article class="course-card">
                    <a href="{{ url('course/details/'.$course->id.'/'.$course->course_name_slug) }}">
                        <img class="course-thumb" src="{{ asset($course->course_image ?? 'upload/no_image.jpg') }}" alt="{{ $course->course_name }}">
                    </a>
                    <div class="course-body">
                        <div class="course-meta">By {{ $course->user->name ?? 'Instructor' }} | {{ $course->label ?? 'General' }}</div>
                        <h3 class="course-title">
                            <a href="{{ url('course/details/'.$course->id.'/'.$course->course_name_slug) }}">{{ $course->course_name }}</a>
                        </h3>
                        <div class="price-row">
                            <div class="price">
                                ${{ $course->discount_price ?? $course->selling_price }}
                                @if($course->discount_price)
                                    <del>${{ $course->selling_price }}</del>
                                @endif
                            </div>
                            <button type="button" class="front-btn" onclick="addToCart({{ $course->id }}, '{{ addslashes($course->course_name) }}', {{ $course->instructor_id }}, '{{ $course->course_name_slug }}')">Add to Cart</button>
                        </div>
                    </div>
                </article>
            @empty
                <p>No courses available.</p>
            @endforelse
        </div>
    </section>

    <section class="dashboard-strip">
        <div>
            <h3 style="margin-bottom:6px;color:#fff;">Designed Around Your Dashboards</h3>
            <p>The frontend now guides users naturally into student, instructor, and admin flows.</p>
        </div>
        @auth
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="front-btn">Go to Admin</a>
            @elseif (auth()->user()->role === 'instructor')
                <a href="{{ route('instructor.dashboard') }}" class="front-btn">Go to Instructor</a>
            @else
                <a href="{{ route('dashboard') }}" class="front-btn">Go to Student</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="front-btn">Sign In to Continue</a>
        @endauth
    </section>

    <section class="front-section">
        <div class="section-head">
            <div>
                <h2>Latest Insights</h2>
                <p>Practical updates, trends, and learning strategy articles.</p>
            </div>
            <a class="front-btn" href="{{ route('blog') }}">View all posts</a>
        </div>

        <div class="blog-grid">
            @forelse ($latestPosts as $post)
                <article class="blog-card">
                    <a href="{{ url('blog/details/'.$post->post_slug) }}">
                        <img class="blog-thumb" src="{{ asset($post->post_image ?? 'upload/no_image.jpg') }}" alt="{{ $post->post_title }}">
                    </a>
                    <div class="blog-body">
                        <div class="blog-meta">{{ $post->blog->category_name ?? 'General' }} | {{ $post->created_at->format('M d, Y') }}</div>
                        <h3 class="blog-title"><a href="{{ url('blog/details/'.$post->post_slug) }}">{{ $post->post_title }}</a></h3>
                    </div>
                </article>
            @empty
                <p>No blog posts available.</p>
            @endforelse
        </div>
    </section>
</div>

@endsection

