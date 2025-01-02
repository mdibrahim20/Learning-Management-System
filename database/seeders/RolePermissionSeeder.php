<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            ['name' => 'category.all', 'group_name' => 'Category'],
            ['name' => 'category.add', 'group_name' => 'Category'],
            ['name' => 'category.edit', 'group_name' => 'Category'],
            ['name' => 'category.delete', 'group_name' => 'Category'],
            ['name' => 'subcategory.all', 'group_name' => 'Category'],
            ['name' => 'subcategory.add', 'group_name' => 'Category'],
            ['name' => 'subcategory.edit', 'group_name' => 'Category'],
            ['name' => 'subcategory.delete', 'group_name' => 'Category'],
            ['name' => 'course.menu', 'group_name' => 'Course'],
            ['name' => 'course.list', 'group_name' => 'Course'],
            ['name' => 'course.add', 'group_name' => 'Course'],
            ['name' => 'course.edit', 'group_name' => 'Course'],
            ['name' => 'course.delete', 'group_name' => 'Course'],
            ['name' => 'course.approve', 'group_name' => 'Course'],
            ['name' => 'order.menu', 'group_name' => 'Orders'],
            ['name' => 'order.list', 'group_name' => 'Orders'],
            ['name' => 'order.details', 'group_name' => 'Orders'],
            ['name' => 'coupon.menu', 'group_name' => 'Coupon'],
            ['name' => 'coupon.list', 'group_name' => 'Coupon'],
            ['name' => 'coupon.add', 'group_name' => 'Coupon'],
            ['name' => 'coupon.edit', 'group_name' => 'Coupon'],
            ['name' => 'coupon.delete', 'group_name' => 'Coupon'],
            ['name' => 'blog.menu', 'group_name' => 'Blog'],
            ['name' => 'blog.list', 'group_name' => 'Blog'],
            ['name' => 'blog.add', 'group_name' => 'Blog'],
            ['name' => 'blog.edit', 'group_name' => 'Blog'],
            ['name' => 'blog.delete', 'group_name' => 'Blog'],
            ['name' => 'report.menu', 'group_name' => 'Report'],
            ['name' => 'report.view', 'group_name' => 'Report'],
            ['name' => 'review.menu', 'group_name' => 'Review'],
            ['name' => 'review.list', 'group_name' => 'Review'],
            ['name' => 'review.approve', 'group_name' => 'Review'],
            ['name' => 'review.delete', 'group_name' => 'Review'],
            ['name' => 'user.menu', 'group_name' => 'All User'],
            ['name' => 'user.list', 'group_name' => 'All User'],
            ['name' => 'user.add', 'group_name' => 'All User'],
            ['name' => 'user.edit', 'group_name' => 'All User'],
            ['name' => 'user.delete', 'group_name' => 'All User'],
            ['name' => 'role.menu', 'group_name' => 'Role and Permission'],
            ['name' => 'role.list', 'group_name' => 'Role and Permission'],
            ['name' => 'role.add', 'group_name' => 'Role and Permission'],
            ['name' => 'role.edit', 'group_name' => 'Role and Permission'],
            ['name' => 'role.delete', 'group_name' => 'Role and Permission'],
            ['name' => 'setting.menu', 'group_name' => 'Setting'],
            ['name' => 'site.setting', 'group_name' => 'Setting'],
            ['name' => 'smtp.setting', 'group_name' => 'Setting'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name'], 'guard_name' => 'web'],
                ['group_name' => $permission['group_name']]
            );
        }

        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $instructorRole = Role::firstOrCreate(['name' => 'Instructor', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);

        $adminRole->givePermissionTo(Permission::all());
        $instructorRole->givePermissionTo([
            'category.all',
            'subcategory.all',
            'course.menu',
            'course.list',
            'course.add',
            'course.edit',
            'coupon.menu',
            'coupon.list',
            'coupon.add',
            'coupon.edit',
            'coupon.delete',
            'order.menu',
            'order.list',
            'review.menu',
            'review.list',
        ]);
    }
}
