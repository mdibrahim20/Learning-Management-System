<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Admin</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='ri-arrow-left-s-line'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='ri-dashboard-line'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        
      
        
        <li class="menu-label">UI Elements</li>
       
        @if (Auth::user()->can('category.menu')) 
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='ri-folder-2-line'></i>
                </div>
                <div class="menu-title">Manage Category</div>
            </a>
            <ul>
                @if (Auth::user()->can('category.all')) 
                <li> <a href="{{ route('all.category') }}"><i class='ri-arrow-right-s-line'></i>All Category </a>
                </li>
                @endif
                @if (Auth::user()->can('subcategory.all')) 
                <li> <a href="{{ route('all.subcategory') }}"><i class='ri-arrow-right-s-line'></i>All SubCategory  </a>
                </li>
                @endif
                
            </ul>
        </li>
        @endif


        @if (Auth::user()->can('instructor.menu')) 
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-user-star-line'></i>
                </div>
                <div class="menu-title">Manage Instructor</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.instructor') }}"><i class='ri-arrow-right-s-line'></i>All Instructor</a>
                </li>
               
               
            </ul>
        </li>
        @endif


        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-book-open-line'></i>
                </div>
                <div class="menu-title">Manage Courses</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.all.course') }}"><i class='ri-arrow-right-s-line'></i>All Courses</a>
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
                <li> <a href="{{ route('admin.all.coupon') }}"><i class='ri-arrow-right-s-line'></i>All Coupon</a>
                </li>
               
               
            </ul>
        </li>


        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-settings-4-line'></i>
                </div>
                <div class="menu-title">Manage Setting</div>
            </a>
            <ul>
                <li> <a href="{{ route('smtp.setting') }}"><i class='ri-arrow-right-s-line'></i>Manage SMPT</a>
                </li>
                <li> <a href="{{ route('integration.setting') }}"><i class='ri-arrow-right-s-line'></i>Integrations</a>
                </li>
                <li> <a href="{{ route('site.setting') }}"><i class='ri-arrow-right-s-line'></i>Site Setting </a>
                </li>
               
               
            </ul>
        </li>


        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-shopping-bag-3-line'></i>
                </div>
                <div class="menu-title">Manage Orders</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.pending.order') }}"><i class='ri-arrow-right-s-line'></i>Pending Orders </a>
                </li>
                <li> <a href="{{ route('admin.confirm.order') }}"><i class='ri-arrow-right-s-line'></i>Confirm Orders </a>
                </li>
               
               
            </ul>
        </li>


        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-file-chart-line'></i>
                </div>
                <div class="menu-title">Manage Report</div>
            </a>
            <ul>
                <li> <a href="{{ route('report.view') }}"><i class='ri-arrow-right-s-line'></i>Report View </a>
                </li>
               
               
               
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-star-smile-line'></i>
                </div>
                <div class="menu-title">Manage Review</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.pending.review') }}"><i class='ri-arrow-right-s-line'></i>Pending Review </a>
                </li>
                <li> <a href="{{ route('admin.active.review') }}"><i class='ri-arrow-right-s-line'></i>Active Review </a>
                </li>
               
               
               
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-team-line'></i>
                </div>
                <div class="menu-title">Manage All User </div>
            </a>
            <ul>
                <li> <a href="{{ route('all.user') }}"><i class='ri-arrow-right-s-line'></i>All User </a>
                </li>
                <li> <a href="{{ route('all.instructor') }}"><i class='ri-arrow-right-s-line'></i>All Instructor</a>
                </li>
               
               
               
            </ul>
        </li>


        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='ri-article-line'></i>
                </div>
                <div class="menu-title">Manage Blog </div>
            </a>
            <ul>
                <li> <a href="{{ route('blog.category') }}"><i class='ri-arrow-right-s-line'></i>Blog Category </a>
                </li>
                <li> <a href="{{ route('blog.post') }}"><i class='ri-arrow-right-s-line'></i>Blog Post</a>
                </li>
               
               
               
            </ul>
        </li>

         
      
     
        <li class="menu-label">Role & Permission</li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="ri-shield-keyhole-line"></i>
                </div>
                <div class="menu-title">Role & Permission</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.permission') }}"><i class='ri-arrow-right-s-line'></i>All Permission</a>
                </li>
                <li> <a href="{{ route('all.roles') }}"><i class='ri-arrow-right-s-line'></i>All Roles</a>
                </li>
                <li> <a href="{{ route('add.roles.permission') }}"><i class='ri-arrow-right-s-line'></i>Role In Permission</a>
                </li>
                <li> <a href="{{ route('all.roles.permission') }}"><i class='ri-arrow-right-s-line'></i>All Role In Permission</a>
                </li>
                
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="ri-admin-line"></i>
                </div>
                <div class="menu-title">Manage Admin</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.admin') }}"><i class='ri-arrow-right-s-line'></i>All Admin</a>
                </li> 
            </ul>
        </li>

    </ul>
    <!--end navigation-->
</div>
