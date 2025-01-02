<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseLecture;
use App\Models\CourseSection;
use App\Models\Course_goal;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Question;
use App\Models\Review;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Wishlist;
use App\Notifications\OrderComplete;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class BulkLmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake();
        $now = Carbon::now();

        $this->seedUsers($faker);

        $instructorIds = User::where('role', 'instructor')->pluck('id');
        $userIds = User::where('role', 'user')->pluck('id');

        if ($instructorIds->isEmpty() || $userIds->isEmpty()) {
            return;
        }

        $this->seedCoursesAndCurriculum($faker, $instructorIds);
        $this->seedCoupons($faker, $instructorIds);
        $this->seedBlogPosts($faker);
        $this->seedWishlists($userIds);
        $this->seedReviews($faker, $userIds);
        $this->seedQuestions($faker, $userIds);
        $this->seedPaymentsAndOrders($faker, $userIds, $now);
        $this->seedChats($faker, $userIds, $instructorIds, $now);
    }

    private function seedUsers(\Faker\Generator $faker): void
    {
        $instructorRole = Role::where('name', 'Instructor')->first();
        $userRole = Role::where('name', 'User')->first();

        $password = Hash::make('111');

        $targetInstructors = 20;
        $existingInstructors = User::where('role', 'instructor')->count();
        for ($i = $existingInstructors + 1; $i <= $targetInstructors; $i++) {
            $user = User::create([
                'name' => "Instructor {$i}",
                'username' => "instructor_{$i}",
                'email' => "instructor{$i}@seed.lms",
                'password' => $password,
                'role' => 'instructor',
                'status' => '1',
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'email_verified_at' => now(),
            ]);

            if ($instructorRole) {
                $user->assignRole($instructorRole);
            }
        }

        $targetUsers = 200;
        $existingUsers = User::where('role', 'user')->count();
        for ($i = $existingUsers + 1; $i <= $targetUsers; $i++) {
            $user = User::create([
                'name' => $faker->name(),
                'username' => "student_{$i}",
                'email' => "student{$i}@seed.lms",
                'password' => $password,
                'role' => 'user',
                'status' => '1',
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'email_verified_at' => now(),
            ]);

            if ($userRole) {
                $user->assignRole($userRole);
            }
        }
    }

    private function seedCoursesAndCurriculum(\Faker\Generator $faker, $instructorIds): void
    {
        $categories = Category::pluck('id');
        $subCategories = SubCategory::select('id', 'category_id')->get()->groupBy('category_id');

        if ($categories->isEmpty()) {
            return;
        }

        $targetCourses = 120;
        $existingCourses = Course::count();

        for ($index = $existingCourses + 1; $index <= $targetCourses; $index++) {
            $categoryId = $categories->random();

            if (!isset($subCategories[$categoryId]) || $subCategories[$categoryId]->isEmpty()) {
                continue;
            }

            $subcategoryId = $subCategories[$categoryId]->random()->id;
            $courseName = ucfirst($faker->words(3, true)) . " {$index}";
            $sellingPrice = $faker->numberBetween(30, 250);
            $hasDiscount = $faker->boolean(60);

            $course = Course::create([
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'instructor_id' => $instructorIds->random(),
                'course_image' => 'upload/no_image.jpg',
                'course_title' => $courseName . ' Masterclass',
                'course_name' => $courseName,
                'course_name_slug' => Str::slug($courseName . '-' . $index),
                'description' => $faker->paragraphs(4, true),
                'video' => 'upload/course/video/1693682154.mp4',
                'label' => $faker->randomElement(['Beginner', 'Intermediate', 'Advanced']),
                'duration' => $faker->numberBetween(4, 60) . ' Hours',
                'resources' => $faker->numberBetween(5, 35) . ' resources',
                'certificate' => $faker->randomElement(['Yes', 'No']),
                'selling_price' => $sellingPrice,
                'discount_price' => $hasDiscount ? $faker->numberBetween(10, $sellingPrice - 1) : null,
                'prerequisites' => $faker->sentence(10),
                'bestseller' => $faker->boolean(20) ? 1 : 0,
                'featured' => $faker->boolean(25) ? 1 : 0,
                'highestrated' => $faker->boolean(15) ? 1 : 0,
                'status' => 1,
            ]);

            for ($goal = 1; $goal <= 4; $goal++) {
                Course_goal::create([
                    'course_id' => $course->id,
                    'goal_name' => $faker->sentence(8),
                ]);
            }

            $sectionCount = $faker->numberBetween(3, 6);
            for ($sectionIndex = 1; $sectionIndex <= $sectionCount; $sectionIndex++) {
                $section = CourseSection::create([
                    'course_id' => $course->id,
                    'section_title' => "Section {$sectionIndex}: " . ucfirst($faker->words(3, true)),
                ]);

                $lectureCount = $faker->numberBetween(2, 5);
                for ($lectureIndex = 1; $lectureIndex <= $lectureCount; $lectureIndex++) {
                    CourseLecture::create([
                        'course_id' => $course->id,
                        'section_id' => $section->id,
                        'lecture_title' => "Lecture {$lectureIndex}: " . ucfirst($faker->words(4, true)),
                        'video' => 'upload/course/video/1693682154.mp4',
                        'url' => $faker->url(),
                        'content' => $faker->paragraph(3),
                    ]);
                }
            }
        }
    }

    private function seedCoupons(\Faker\Generator $faker, $instructorIds): void
    {
        for ($i = 1; $i <= 25; $i++) {
            Coupon::firstOrCreate(
                ['coupon_name' => "ADMIN{$i}OFF"],
                [
                    'coupon_discount' => $faker->numberBetween(5, 40),
                    'coupon_validity' => now()->addDays($faker->numberBetween(30, 365))->format('Y-m-d'),
                    'status' => 1,
                ]
            );
        }

        foreach ($instructorIds as $instructorId) {
            $courseIds = Course::where('instructor_id', $instructorId)->pluck('id');
            if ($courseIds->isEmpty()) {
                continue;
            }

            for ($i = 1; $i <= 2; $i++) {
                Coupon::firstOrCreate(
                    ['coupon_name' => "INS{$instructorId}_{$i}"],
                    [
                        'coupon_discount' => $faker->numberBetween(10, 50),
                        'coupon_validity' => now()->addDays($faker->numberBetween(15, 240))->format('Y-m-d'),
                        'status' => 1,
                        'instructor_id' => $instructorId,
                        'course_id' => $courseIds->random(),
                    ]
                );
            }
        }
    }

    private function seedBlogPosts(\Faker\Generator $faker): void
    {
        $blogCategoryIds = BlogCategory::pluck('id');
        if ($blogCategoryIds->isEmpty()) {
            return;
        }

        $targetPosts = 80;
        $existingPosts = BlogPost::count();
        for ($i = $existingPosts + 1; $i <= $targetPosts; $i++) {
            $title = ucfirst($faker->words(6, true)) . " {$i}";
            BlogPost::create([
                'blogcat_id' => $blogCategoryIds->random(),
                'post_title' => $title,
                'post_slug' => Str::slug($title),
                'post_image' => 'upload/post/1778854741002902.png',
                'long_descp' => $faker->paragraphs(6, true),
                'post_tags' => implode(',', $faker->words(5)),
            ]);
        }
    }

    private function seedWishlists($userIds): void
    {
        $courseIds = Course::pluck('id');
        if ($courseIds->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 500; $i++) {
            Wishlist::firstOrCreate([
                'user_id' => $userIds->random(),
                'course_id' => $courseIds->random(),
            ]);
        }
    }

    private function seedReviews(\Faker\Generator $faker, $userIds): void
    {
        $courses = Course::select('id', 'instructor_id')->get();
        if ($courses->isEmpty()) {
            return;
        }

        $targetReviews = 700;
        $existingReviews = Review::count();
        for ($i = $existingReviews + 1; $i <= $targetReviews; $i++) {
            $course = $courses->random();
            Review::create([
                'course_id' => $course->id,
                'user_id' => $userIds->random(),
                'comment' => $faker->sentence(20),
                'rating' => (string) $faker->numberBetween(1, 5),
                'instructor_id' => $course->instructor_id,
                'status' => (string) $faker->numberBetween(0, 1),
            ]);
        }
    }

    private function seedQuestions(\Faker\Generator $faker, $userIds): void
    {
        $courses = Course::select('id', 'instructor_id')->get();
        if ($courses->isEmpty()) {
            return;
        }

        $questionIds = [];
        for ($i = 1; $i <= 250; $i++) {
            $course = $courses->random();
            $question = Question::create([
                'course_id' => $course->id,
                'user_id' => $userIds->random(),
                'instructor_id' => $course->instructor_id,
                'subject' => $faker->sentence(6),
                'question' => $faker->paragraph(2),
            ]);
            $questionIds[] = $question->id;
        }

        foreach (array_slice($questionIds, 0, 120) as $parentId) {
            $parentQuestion = Question::find($parentId);
            if (!$parentQuestion) {
                continue;
            }

            Question::create([
                'course_id' => $parentQuestion->course_id,
                'user_id' => $parentQuestion->instructor_id,
                'instructor_id' => $parentQuestion->instructor_id,
                'parent_id' => $parentQuestion->id,
                'subject' => 'Instructor Reply',
                'question' => $faker->sentence(16),
            ]);
        }
    }

    private function seedPaymentsAndOrders(\Faker\Generator $faker, $userIds, Carbon $now): void
    {
        $courseData = Course::select('id', 'course_title', 'instructor_id', 'selling_price', 'discount_price')->get();
        if ($courseData->isEmpty()) {
            return;
        }

        $targetPayments = 180;
        $existingPayments = Payment::count();
        for ($i = $existingPayments + 1; $i <= $targetPayments; $i++) {
            $buyerId = $userIds->random();
            $buyer = User::find($buyerId);
            if (!$buyer) {
                continue;
            }

            $purchaseCount = min($faker->numberBetween(1, 4), $courseData->count());
            $purchasedCourses = $courseData->shuffle()->take($purchaseCount)->values();

            $totalAmount = $purchasedCourses->sum(function ($course) {
                return (int) ($course->discount_price ?? $course->selling_price ?? 0);
            });

            $payment = Payment::create([
                'name' => $buyer->name,
                'email' => $buyer->email,
                'phone' => $buyer->phone,
                'address' => $buyer->address,
                'cash_delivery' => $faker->randomElement(['handcash', 'stripe']),
                'total_amount' => (string) $totalAmount,
                'payment_type' => $faker->randomElement(['Direct Payment', 'Stripe']),
                'invoice_no' => 'EOS' . str_pad((string) $i, 8, '0', STR_PAD_LEFT),
                'order_date' => $now->format('d F Y'),
                'order_month' => $now->format('F'),
                'order_year' => $now->format('Y'),
                'status' => $faker->randomElement(['pending', 'confirm']),
            ]);

            foreach ($purchasedCourses as $course) {
                $price = (int) ($course->discount_price ?? $course->selling_price ?? 0);

                Order::create([
                    'payment_id' => $payment->id,
                    'user_id' => $buyer->id,
                    'course_id' => $course->id,
                    'instructor_id' => $course->instructor_id,
                    'course_title' => $course->course_title,
                    'price' => $price,
                ]);

                $instructor = User::find($course->instructor_id);
                if ($instructor) {
                    $instructor->notify(new OrderComplete($buyer->name));
                }
            }
        }
    }

    private function seedChats(\Faker\Generator $faker, $userIds, $instructorIds, Carbon $now): void
    {
        $targetChats = 600;
        $existingChats = ChatMessage::count();
        for ($i = $existingChats + 1; $i <= $targetChats; $i++) {
            $createdAt = $now->copy()->subMinutes($faker->numberBetween(1, 50000));
            ChatMessage::create([
                'sender_id' => $userIds->random(),
                'receiver_id' => $instructorIds->random(),
                'msg' => $faker->sentence(14),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
