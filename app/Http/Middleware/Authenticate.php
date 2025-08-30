<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // التحقق من الـ guard المستخدم
            if ($request->is('merchant/*')) {
                return route('login');  // إذا كان المستخدم مشرف
            } elseif ($request->is('user/*')||$request->is('cart-1')||$request->is('*/checkout/*')) {
                return route('customer.login');  // إذا كان المستخدم عميل
            } elseif ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');  // إذا كان المستخدم عميل
            }

            // توجيه افتراضي في حال عدم تحديد guard
            return route('login');
        }
    }
}
