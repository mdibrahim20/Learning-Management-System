@php
  $id = Auth::user()->id;
  $instructorId = App\Models\User::find($id);
  $status = $instructorId->status;
@endphp

<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Instructor</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='ri-arrow-left-s-line'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        
        <li>
            <a href="{{ route('instructor.dashboard') }}">
                <div class="parent-icon"><i class='ri-dashboard-line'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        
        @if ($status === '1') 

        <li class="menu-label">Course Manage </li>
       
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='ri-book-open-line'></i>
                </div>
                <div class="menu-title">Course Manage</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.course') }}"><i class='ri-arrow-right-s-line'></i>All Course </a>
                </li>
                
                
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-shopping-bag-3-line'></i>
                </div>
                <div class="menu-title">All Orders</div>
            </a>
            <ul>
                <li> <a href="{{ route('instructor.all.order') }}"><i class='ri-arrow-right-s-line'></i>All Orders</a>
                </li>
                
               
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-question-answer-line'></i>
                </div>
                <div class="menu-title">All Question</div>
            </a>
            <ul>
                <li> <a href="{{ route('instructor.all.question') }}"><i class='ri-arrow-right-s-line'></i>All Question</a>
                </li>
                
               
            </ul>
        </li>


        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-coupon-3-line'></i>
                </div>
                <div class="menu-title">Manage Coupon</div>
            </a>
            <ul>
                <li> <a href="{{ route('instructor.all.coupon') }}"><i class='ri-arrow-right-s-line'></i>All Coupon</a>
                </li>
                
               
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-star-smile-line'></i>
                </div>
                <div class="menu-title">Manage Reivew</div>
            </a>
            <ul>
                <li> <a href="{{ route('instructor.all.review') }}"><i class='ri-arrow-right-s-line'></i>All Review</a>
                </li>
                
               
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-chat-voice-line'></i>
                </div>
                <div class="menu-title">Live Chat</div>
            </a>
            <ul>
                <li> <a href="{{ route('instructor.live.chat') }}"><i class='ri-arrow-right-s-line'></i>Live Chat</a>
                </li>
                
               
            </ul>
        </li>
      
     
        @else

        @endif
    </ul>
    <!--end navigation-->
</div>
