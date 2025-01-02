<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
 
class AdminController extends Controller
{
    public function AdminDashboard(){
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $totalOrders = Payment::count();
        $totalRevenue = (float) Payment::where('status', 'confirm')->sum('total_amount');
        $totalStudents = User::where('role', 'user')->count();
        $totalInstructors = User::where('role', 'instructor')->count();
        $totalCourses = Course::count();
        $pendingOrders = Payment::where('status', 'pending')->count();
        $confirmOrders = Payment::where('status', 'confirm')->count();

        $thisMonthOrders = Payment::whereBetween('created_at', [$startOfMonth, $now])->count();
        $lastMonthOrders = Payment::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $ordersTrend = $this->trendPercentage($thisMonthOrders, $lastMonthOrders);

        $thisMonthRevenue = (float) Payment::where('status', 'confirm')
            ->whereBetween('created_at', [$startOfMonth, $now])
            ->sum('total_amount');
        $lastMonthRevenue = (float) Payment::where('status', 'confirm')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total_amount');
        $revenueTrend = $this->trendPercentage($thisMonthRevenue, $lastMonthRevenue);

        $pendingRatio = $totalOrders > 0 ? round(($pendingOrders / $totalOrders) * 100, 1) : 0;
        $activationRatio = ($totalStudents + $totalInstructors) > 0
            ? round((User::whereIn('role', ['user', 'instructor'])->where('status', '1')->count() / ($totalStudents + $totalInstructors)) * 100, 1)
            : 0;

        $recentPayments = Payment::latest()->take(8)->get();
        $paymentIds = $recentPayments->pluck('id');
        $ordersByPayment = Order::with(['course:id,course_name,course_image'])
            ->whereIn('payment_id', $paymentIds)
            ->orderByDesc('id')
            ->get()
            ->groupBy('payment_id');

        $recentOrders = $recentPayments->map(function ($payment) use ($ordersByPayment) {
            $items = $ordersByPayment->get($payment->id, collect());
            $firstItem = $items->first();
            return [
                'invoice_no' => $payment->invoice_no,
                'status' => $payment->status,
                'total_amount' => (float) $payment->total_amount,
                'order_date' => $payment->order_date,
                'items_count' => $items->count(),
                'course_title' => $firstItem?->course_title ?? 'N/A',
                'course_image' => $firstItem?->course?->course_image ?? 'upload/no_image.jpg',
            ];
        });

        $months = collect(range(5, 0))->map(function ($index) use ($now) {
            return $now->copy()->subMonths($index)->format('M');
        })->values();

        $monthlyOrders = collect(range(5, 0))->map(function ($index) use ($now) {
            $month = $now->copy()->subMonths($index);
            return Payment::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        })->values();

        $monthlyRevenue = collect(range(5, 0))->map(function ($index) use ($now) {
            $month = $now->copy()->subMonths($index);
            return (float) Payment::where('status', 'confirm')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount');
        })->values();

        return view('admin.index', compact(
            'totalOrders',
            'totalRevenue',
            'totalStudents',
            'totalInstructors',
            'totalCourses',
            'pendingOrders',
            'confirmOrders',
            'ordersTrend',
            'revenueTrend',
            'pendingRatio',
            'activationRatio',
            'recentOrders',
            'months',
            'monthlyOrders',
            'monthlyRevenue'
        ));

    } // End Method 

    private function trendPercentage(float|int $current, float|int $previous): float
    {
        if ((float) $previous === 0.0) {
            return (float) $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    public function AdminLogout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'info'
        );
 
        return redirect('/admin/login')->with($notification);
    } // End Method 

    public function AdminLogin(){
        return view('admin.admin_login');
    } // End Method 


    public function AdminProfile(){

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view',compact('profileData'));
    }// End Method


    public function AdminProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
           $file = $request->file('photo');
           @unlink(public_path('upload/admin_images/'.$data->photo));
           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/admin_images'),$filename);
           $data['photo'] = $filename; 
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        
    }// End Method

    public function AdminChangePassword(){

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password',compact('profileData'));

    }// End Method

 
    public function AdminPasswordUpdate(Request $request){

        /// Validation 
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, auth::user()->password)) {
            
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        } 

        /// Update The new Password 
        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification); 

    }// End Method


    public function BecomeInstructor(){

        return view('frontend.instructor.reg_instructor');

    }// End Method

    public function InstructorRegister(Request $request){

        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required', 'string','unique:users'],
        ]);

        User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' =>  Hash::make($request->password),
            'role' => 'instructor',
            'status' => '0',
        ]);

        $notification = array(
            'message' => 'Instructor Registed Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('instructor.login')->with($notification); 

    }// End Method


    public function AllInstructor(){

        $allinstructor = User::where('role','instructor')->latest()->get();
        return view('admin.backend.instructor.all_instructor',compact('allinstructor'));
    }// End Method
 
    public function UpdateUserStatus(Request $request){

        $userId = $request->input('user_id');
        $isChecked = $request->input('is_checked',0);

        $user = User::find($userId);
        if ($user) {
            $user->status = $isChecked;
            $user->save();
        }

        return response()->json(['message' => 'User Status Updated Successfully']);

    }// End Method


    public function AdminAllCourse(){

        $course = Course::latest()->get();
        return view('admin.backend.courses.all_course',compact('course'));

    }// End Method


    public function UpdateCourseStatus(Request $request){

        $courseId = $request->input('course_id');
        $isChecked = $request->input('is_checked',0);

        $course = Course::find($courseId);
        if ($course) {
            $course->status = $isChecked;
            $course->save();
        }

        return response()->json(['message' => 'Course Status Updated Successfully']);

    }// End Method

    public function AdminCourseDetails($id){

        $course = Course::find($id);
        return view('admin.backend.courses.course_details',compact('course'));

    }// End Method

    /// Admin User All Method ////////////

    public function AllAdmin(){

        $alladmin = User::where('role','admin')->get();
        return view('admin.backend.pages.admin.all_admin',compact('alladmin'));

    }// End Method

    public function AddAdmin(){

        $roles = Role::all();
        return view('admin.backend.pages.admin.add_admin',compact('roles'));

    }// End Method

    public function StoreAdmin(Request $request){

        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->status = '1';
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'New Admin Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification); 

    }// End Method


    public function EditAdmin($id){

        $user = User::find($id);
        $roles = Role::all();
        return view('admin.backend.pages.admin.edit_admin',compact('user','roles'));

    }// End Method

    public function UpdateAdmin(Request $request,$id){

        $user = User::find($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address; 
        $user->role = 'admin';
        $user->status = '1';
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'Admin Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification); 

    }// End Method

    public function DeleteAdmin($id){

        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }

        $notification = array(
            'message' => 'Admin Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 

    }// End Method
    


}
 
