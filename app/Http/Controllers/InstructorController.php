<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class InstructorController extends Controller
{
    public function InstructorDashboard(){
        $instructorId = Auth::id();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $instructorCourseIds = Course::where('instructor_id', $instructorId)->pluck('id');
        $instructorPaymentIds = Order::where('instructor_id', $instructorId)->distinct()->pluck('payment_id');

        $totalOrders = Order::where('instructor_id', $instructorId)->count();
        $totalRevenue = (float) Order::where('orders.instructor_id', $instructorId)
            ->join('payments', 'orders.payment_id', '=', 'payments.id')
            ->where('payments.status', 'confirm')
            ->sum('orders.price');
        $totalCourses = $instructorCourseIds->count();
        $activeCourses = Course::where('instructor_id', $instructorId)->where('status', 1)->count();
        $pendingPayments = Payment::whereIn('id', $instructorPaymentIds)->where('status', 'pending')->count();

        $thisMonthOrders = Order::where('instructor_id', $instructorId)
            ->whereBetween('created_at', [$startOfMonth, $now])
            ->count();
        $lastMonthOrders = Order::where('instructor_id', $instructorId)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();
        $ordersTrend = $this->trendPercentage($thisMonthOrders, $lastMonthOrders);

        $thisMonthRevenue = (float) Order::where('orders.instructor_id', $instructorId)
            ->join('payments', 'orders.payment_id', '=', 'payments.id')
            ->where('payments.status', 'confirm')
            ->whereBetween('orders.created_at', [$startOfMonth, $now])
            ->sum('orders.price');
        $lastMonthRevenue = (float) Order::where('orders.instructor_id', $instructorId)
            ->join('payments', 'orders.payment_id', '=', 'payments.id')
            ->where('payments.status', 'confirm')
            ->whereBetween('orders.created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('orders.price');
        $revenueTrend = $this->trendPercentage($thisMonthRevenue, $lastMonthRevenue);

        $pendingRatio = $totalOrders > 0 ? round((Order::where('instructor_id', $instructorId)->join('payments', 'orders.payment_id', '=', 'payments.id')->where('payments.status', 'pending')->count() / $totalOrders) * 100, 1) : 0;
        $activeCourseRatio = $totalCourses > 0 ? round(($activeCourses / $totalCourses) * 100, 1) : 0;

        $latestOrderIds = Order::where('instructor_id', $instructorId)
            ->selectRaw('MAX(id) as id')
            ->groupBy('payment_id')
            ->orderByDesc('id')
            ->limit(8)
            ->pluck('id');

        $recentOrders = Order::with(['course:id,course_name,course_image', 'payment:id,invoice_no,status,total_amount,order_date'])
            ->whereIn('id', $latestOrderIds)
            ->orderByDesc('id')
            ->get();

        $months = collect(range(5, 0))->map(function ($index) use ($now) {
            return $now->copy()->subMonths($index)->format('M');
        })->values();

        $monthlyOrders = collect(range(5, 0))->map(function ($index) use ($now, $instructorId) {
            $month = $now->copy()->subMonths($index);
            return Order::where('instructor_id', $instructorId)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        })->values();

        $monthlyRevenue = collect(range(5, 0))->map(function ($index) use ($now, $instructorId) {
            $month = $now->copy()->subMonths($index);
            return (float) Order::where('orders.instructor_id', $instructorId)
                ->join('payments', 'orders.payment_id', '=', 'payments.id')
                ->where('payments.status', 'confirm')
                ->whereYear('orders.created_at', $month->year)
                ->whereMonth('orders.created_at', $month->month)
                ->sum('orders.price');
        })->values();

        return view('instructor.index', compact(
            'totalOrders',
            'totalRevenue',
            'totalCourses',
            'activeCourses',
            'pendingPayments',
            'ordersTrend',
            'revenueTrend',
            'pendingRatio',
            'activeCourseRatio',
            'recentOrders',
            'months',
            'monthlyOrders',
            'monthlyRevenue'
        ));
    } // End Mehtod 

    private function trendPercentage(float|int $current, float|int $previous): float
    {
        if ((float) $previous === 0.0) {
            return (float) $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    public function InstructorLogout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'info'
        );

        return redirect('/instructor/login')->with($notification);
    } // End Method 


    public function InstructorLogin(){
        return view('instructor.instructor_login');
    } // End Method 

    public function InstructorProfile(){

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('instructor.instructor_profile_view',compact('profileData'));
    }// End Method


    public function InstructorProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
           $file = $request->file('photo');
           @unlink(public_path('upload/instructor_images/'.$data->photo));
           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/instructor_images'),$filename);
           $data['photo'] = $filename; 
        }

        $data->save();

        $notification = array(
            'message' => 'Instructor Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        
    }// End Method
    

    public function InstructorChangePassword(){

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('instructor.instructor_change_password',compact('profileData'));

    }// End Method


    public function InstructorPasswordUpdate(Request $request){

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




}
 
