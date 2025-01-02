@extends('frontend.master')
@section('home')

@section('title')
{{ $course->course_name }} | Nuvetic
@endsection

@php
    $reviewCount = App\Models\Review::where('course_id', $course->id)->where('status', 1)->count();
    $averageRating = App\Models\Review::where('course_id', $course->id)->where('status', 1)->avg('rating') ?? 0;
    $enrollmentCount = App\Models\Order::where('course_id', $course->id)->count();
    $sections = App\Models\CourseSection::where('course_id', $course->id)->orderBy('id', 'asc')->get();
@endphp

<div class="front-shell">
    <section class="page-hero">
        <span class="kicker">Course Details</span>
        <h1>{{ $course->course_name }}</h1>
        <p style="color:var(--muted);margin:0">{{ $course->course_title }}</p>
        <div class="meta-list" style="margin-top:12px;">
            <div class="meta-pill">Instructor: <strong>{{ $course['user']['name'] ?? 'Instructor' }}</strong></div>
            <div class="meta-pill">Rating: <strong>{{ number_format($averageRating, 1) }}</strong> ({{ $reviewCount }} reviews)</div>
            <div class="meta-pill">Students: <strong>{{ number_format($enrollmentCount) }}</strong></div>
        </div>
    </section>

    <section class="page-grid">
        <div>
            <div class="elegant-surface">
                <h3>What You Will Learn</h3>
                <ul style="margin:0;padding-left:18px;">
                    @forelse ($goals as $goal)
                        <li style="margin-bottom:6px;">{{ $goal->goal_name }}</li>
                    @empty
                        <li>Practical skills and project-based understanding.</li>
                    @endforelse
                </ul>
            </div>

            <div class="elegant-surface" style="margin-top:10px;">
                <h3>Course Description</h3>
                <p>{!! $course->description !!}</p>
                <p style="color:var(--muted)"><strong>Prerequisites:</strong> {{ $course->prerequisites }}</p>
            </div>

            <div class="elegant-surface" style="margin-top:10px;">
                <h3>Curriculum</h3>
                <div id="courseAccordion" class="accordion">
                    @forelse ($sections as $section)
                        @php $lectures = App\Models\CourseLecture::where('section_id', $section->id)->get(); @endphp
                        <div class="card" style="border:1px solid var(--line);border-radius:12px;margin-bottom:8px;">
                            <div class="card-header" style="background:#f9fbff;border:none;padding:10px 14px;" id="heading{{ $section->id }}">
                                <button class="btn btn-link" style="font-weight:700;color:var(--brand);text-decoration:none;" data-toggle="collapse" data-target="#collapse{{ $section->id }}" aria-expanded="false" aria-controls="collapse{{ $section->id }}">
                                    {{ $section->section_title }} ({{ count($lectures) }} lectures)
                                </button>
                            </div>
                            <div id="collapse{{ $section->id }}" class="collapse" aria-labelledby="heading{{ $section->id }}" data-parent="#courseAccordion">
                                <div class="card-body" style="padding:10px 14px;">
                                    <ul style="margin:0;padding-left:18px;">
                                        @foreach ($lectures as $lecture)
                                            <li style="margin-bottom:6px;">{{ $lecture->lecture_title }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No curriculum added yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="elegant-surface" style="margin-top:10px;">
                <h3>About Instructor</h3>
                <div style="display:flex;gap:12px;align-items:flex-start;">
                    <img src="{{ (!empty($course->user->photo)) ? url('upload/instructor_images/'.$course->user->photo) : url('upload/no_image.jpg') }}" alt="Instructor" style="width:76px;height:76px;border-radius:12px;object-fit:cover;border:1px solid var(--line);">
                    <div>
                        <p style="margin:0 0 4px 0;font-weight:800">{{ $course['user']['name'] ?? 'Instructor' }}</p>
                        <p style="margin:0;color:var(--muted)">{{ $course['user']['email'] ?? '' }}</p>
                        <p style="margin:8px 0 0 0;color:var(--muted)">Published courses: {{ count($instructorCourses) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <aside>
            <div class="elegant-surface" style="position:sticky;top:92px;">
                <img src="{{ asset($course->course_image ?? 'upload/no_image.jpg') }}" alt="{{ $course->course_name }}" style="width:100%;border-radius:12px;border:1px solid var(--line);margin-bottom:10px;">
                <h3 style="margin-bottom:8px;">
                    ${{ $course->discount_price ?? $course->selling_price }}
                    @if($course->discount_price)
                        <del style="font-size:14px;color:var(--muted)">${{ $course->selling_price }}</del>
                    @endif
                </h3>
                <button type="button" class="front-btn primary" style="width:100%;margin-bottom:8px;" onclick="buyCourse({{ $course->id }}, '{{ addslashes($course->course_name) }}', {{ $course->instructor_id }}, '{{ $course->course_name_slug }}')">Buy Now</button>
                <button type="button" class="front-btn" style="width:100%;margin-bottom:8px;" onclick="addToCart({{ $course->id }}, '{{ addslashes($course->course_name) }}', {{ $course->instructor_id }}, '{{ $course->course_name_slug }}')">Add to Cart</button>
                <button type="button" class="front-btn" style="width:100%;" onclick="addToWishList({{ $course->id }})">Add to Wishlist</button>

                <hr>
                <p style="margin:0 0 6px 0;"><strong>Duration:</strong> {{ $course->duration }}</p>
                <p style="margin:0 0 6px 0;"><strong>Resources:</strong> {{ $course->resources }}</p>
                <p style="margin:0 0 6px 0;"><strong>Level:</strong> {{ $course->label }}</p>
                <p style="margin:0;"><strong>Certificate:</strong> {{ $course->certificate }}</p>
            </div>

            <div class="elegant-surface" style="margin-top:10px;">
                <h3>Related Courses</h3>
                @forelse ($relatedCourses as $related)
                    <div class="order-item">
                        <img class="thumb-sm" src="{{ asset($related->course_image ?? 'upload/no_image.jpg') }}" alt="{{ $related->course_name }}">
                        <a href="{{ url('course/details/'.$related->id.'/'.$related->course_name_slug) }}" style="font-weight:700;line-height:1.35;">{{ $related->course_name }}</a>
                        <div style="font-weight:800;color:var(--brand)">${{ $related->discount_price ?? $related->selling_price }}</div>
                    </div>
                @empty
                    <p>No related courses.</p>
                @endforelse
            </div>
        </aside>
    </section>
</div>

@endsection

