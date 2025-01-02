@extends('frontend.master')
@section('home')

@section('title')
{{ $category->category_name }} | Nuvetic
@endsection

<div class="front-shell">
    <section class="page-hero">
        <span class="kicker">Category</span>
        <h1>{{ $category->category_name }}</h1>
        <p style="color:var(--muted);margin:0">{{ count($courses) }} courses available in this track.</p>
    </section>

    <section class="front-section" style="margin-top:14px;">
        <div class="section-head">
            <div>
                <h2>Courses in {{ $category->category_name }}</h2>
                <p>Curated courses with dashboard-ready learning outcomes.</p>
            </div>
        </div>

        <div class="course-grid">
            @forelse ($courses as $course)
                <article class="course-card">
                    <a href="{{ url('course/details/'.$course->id.'/'.$course->course_name_slug) }}">
                        <img class="course-thumb" src="{{ asset($course->course_image ?? 'upload/no_image.jpg') }}" alt="{{ $course->course_name }}">
                    </a>
                    <div class="course-body">
                        <div class="course-meta">{{ $course->label ?? 'General' }} | {{ $course['user']['name'] ?? 'Instructor' }}</div>
                        <h3 class="course-title"><a href="{{ url('course/details/'.$course->id.'/'.$course->course_name_slug) }}">{{ $course->course_name }}</a></h3>
                        <div class="price-row">
                            <div class="price">
                                ${{ $course->discount_price ?? $course->selling_price }}
                                @if($course->discount_price)
                                    <del>${{ $course->selling_price }}</del>
                                @endif
                            </div>
                            <button type="button" class="front-btn" onclick="addToCart({{ $course->id }}, '{{ addslashes($course->course_name) }}', {{ $course->instructor_id }}, '{{ $course->course_name_slug }}')">Add</button>
                        </div>
                    </div>
                </article>
            @empty
                <p>No courses found in this category yet.</p>
            @endforelse
        </div>
    </section>

    <section class="front-section" style="margin-top:14px;">
        <div class="section-head">
            <div>
                <h2>Browse Other Categories</h2>
            </div>
        </div>
        <div class="category-grid">
            @foreach ($categories as $cat)
                <a class="category-card" href="{{ url('category/'.$cat->id.'/'.$cat->category_slug) }}">
                    <h3 style="font-size:18px;margin:0">{{ $cat->category_name }}</h3>
                </a>
            @endforeach
        </div>
    </section>
</div>

@endsection

