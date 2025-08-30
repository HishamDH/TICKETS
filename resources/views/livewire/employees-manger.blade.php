<div>

@php
$access = false;
if (adminPermission("employees_edit")) {
    $access = true;
}
@endphp
<fieldset @if (!$access) disabled @endif >
<div class="p-6 space-y-6" >
    {{-- رسائل --}}
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- إضافة أدمن --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
            <i class="ri-user-add-line text-blue-600"></i>
            إضافة أدمن جديد
        </h2>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <input type="text" wire:model="f_name" placeholder="الاسم الأول" class="border p-2 rounded w-full">
            <input type="text" wire:model="l_name" placeholder="اسم العائلة" class="border p-2 rounded w-full">
            <input type="email" 
       wire:model="email" 
       placeholder="الإيميل" 
       class="border p-2 rounded w-full"
       pattern="^[^@]+@[^@]+\.[a-zA-Z]{2,}$"
       title="يجب إدخال إيميل صحيح يحتوي على @ وامتداد مثل .com">
            <input type="password" wire:model="password" placeholder="الباسورد" class="border p-2 rounded w-full">
        </div>

        <div class="mb-4">
            <h3 class="mb-2 font-semibold flex items-center gap-2">
                <i class="ri-shield-keyhole-line text-gray-600"></i>
                الصلاحيات
            </h3>
            <div class="grid grid-cols-2 gap-2">
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="permissions.employees_edit">
                    <span>تعديل الموظفين</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="permissions.merchants_access">
                    <span>الوصول للتجار</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="permissions.staff_approval">
                    <span>القبول / الستاف</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="permissions.tickets">
                    <span>التذاكر</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="permissions.withdraw_check">
                    <span>معالجة السحوبات</span>
                </label>
                {{-- <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="permissions.system_edit">
                    <span>إعدادات النظام</span>
                </label> --}}
            </div>
        </div>

        <button wire:click="addAdmin" class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 flex items-center gap-2">
            <i class="ri-add-circle-line"></i> إضافة
        </button>
    </div>

    {{-- عرض الأدمنز بالكروت --}}
    <div class="space-y-6">
        <h2 class="font-bold text-lg flex items-center gap-2">
            <i class="ri-team-line text-gray-700"></i>
            قائمة الأدمنز
        </h2>

        @foreach ($admins as $admin)
            @php
                $perms = $admin->additional_data['permissions'] ?? [];
            @endphp

            <div class="bg-white rounded-2xl shadow-md p-6" x-data="{ open: false }">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <i class="ri-user-3-line text-blue-500"></i>
                {{ $admin->f_name }} {{ $admin->l_name }}
            </h3>
            <p class="text-gray-500 text-sm flex items-center gap-1">
                <i class="ri-mail-line"></i>
                {{ $admin->email }}
            </p>
        </div>
        <button wire:click="deleteAdmin({{ $admin->id }})"
            class="bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600 flex items-center gap-1">
            <i class="ri-delete-bin-6-line"></i> حذف
        </button>
    </div>

    {{-- الصلاحيات --}}
    <div>
        <button @click="open = !open" 
            class="w-full flex justify-between items-center bg-gray-100 px-4 py-2 rounded-xl font-semibold hover:bg-gray-200">
            <span class="flex items-center gap-2">
                <i class="ri-key-2-line text-gray-600"></i> الصلاحيات
            </span>
            <i :class="open ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line'"></i>
        </button>

        <div x-show="open" x-transition class="mt-3">
            <ol class="list-decimal list-inside space-y-2 text-sm">
                <li>
                    <button wire:click="togglePermission({{ $admin->id }}, 'employees_edit')"
                        class="px-3 py-1 rounded-xl flex items-center gap-2 {{ ($perms['employees_edit'] ?? false) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <i class="ri-edit-2-line"></i> تعديل الموظفين
                    </button>
                </li>
                <li>
                    <button wire:click="togglePermission({{ $admin->id }}, 'merchants_access')"
                        class="px-3 py-1 rounded-xl flex items-center gap-2 {{ ($perms['merchants_access'] ?? false) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <i class="ri-store-2-line"></i> الوصول للتجار
                    </button>
                </li>
                <li>
                    <button wire:click="togglePermission({{ $admin->id }}, 'staff_approval')"
                        class="px-3 py-1 rounded-xl flex items-center gap-2 {{ ($perms['staff_approval'] ?? false) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <i class="ri-user-follow-line"></i> القبول / الستاف
                    </button>
                </li>
                <li>
                    <button wire:click="togglePermission({{ $admin->id }}, 'tickets')"
                        class="px-3 py-1 rounded-xl flex items-center gap-2 {{ ($perms['tickets'] ?? false) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <i class="ri-customer-service-2-line"></i> التذاكر
                    </button>
                </li>
                <li>
                    <button wire:click="togglePermission({{ $admin->id }}, 'withdraw_check')"
                        class="px-3 py-1 rounded-xl flex items-center gap-2 {{ ($perms['withdraw_check'] ?? false) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <i class="ri-bank-card-line"></i> معالجة السحوبات
                    </button>
                </li>
                {{-- <li>
                    <button wire:click="togglePermission({{ $admin->id }}, 'system_edit')"
                        class="px-3 py-1 rounded-xl flex items-center gap-2 {{ ($perms['system_edit'] ?? false) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <i class="ri-settings-3-line"></i> إعدادات النظام
                    </button>
                </li> --}}
            </ol>
        </div>
    </div>
</div>

        @endforeach
    </div>
</div>
</fieldset></div>