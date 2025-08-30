<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-8">Merchant Admin Panel</h1>

    {{-- Tabs Navigation --}}
    @php
    if($Amerchantid){
    $hasRoleCreatePermission = has_Permetion(Auth::id(),"role_create",$Amerchantid);
    $hasRoleDeletePermission = has_Permetion(Auth::id(),"role_delete",$Amerchantid);
    $hasRoleEditPermission = has_Permetion(Auth::id(),"role_edit",$Amerchantid);
    $hasRoleTeamCreatePermission = has_Permetion(Auth::id(),"team_manager_create",$Amerchantid);
    $hasRoleTeamkickPermission = has_Permetion(Auth::id(),"team_manager_kick",$Amerchantid);
    $hasRoleTeamEditPermission = has_Permetion(Auth::id(),"team_manager_edit",$Amerchantid);

    }else{
    $hasRoleCreatePermission = true;
    $hasRoleDeletePermission = true;
    $hasRoleEditPermission = true;
    $hasRoleTeamCreatePermission = true;
    $hasRoleTeamkickPermission = true;
    $hasRoleTeamEditPermission = true;
    }
    @endphp
    <div class="flex border-b mb-6">
        <button
            wire:click="setActiveTab('roles')"
            class="px-4 py-2 text-sm font-medium border-b-2 transition-colors duration-200 flex items-center gap-2"
            @class([ 'border-blue-500 text-blue-500'=> $activeTab === 'roles',
            'border-transparent text-gray-500 hover:text-blue-500' => $activeTab !== 'roles',
            ])
            >
            <i class="ri-shield-line"></i>
            إدارة الرولات والصلاحيات
        </button>

        <button
            wire:click="setActiveTab('workers')"
            class="px-4 py-2 text-sm font-medium border-b-2 transition-colors duration-200 ml-4 flex items-center gap-2"
            @class([ 'border-blue-500 text-blue-500'=> $activeTab === 'workers',
            'border-transparent text-gray-500 hover:text-blue-500' => $activeTab !== 'workers',
            ])
            >
            <i class="ri-team-line"></i>
            إدارة العمال
        </button>
    </div>

    {{-- Section 1: Roles --}}
    @if ($activeTab === 'roles')
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="ri-shield-line"></i> إضافة رول جديد مع صلاحياته
        </h2>

        @if (session()->has('success'))
        <div class="mb-4 text-green-600 font-medium flex items-center gap-2">
            <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
        </div>
        @endif

        {{-- Add New Role Form --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">اسم الرول</label>
            <input type="text" wire:model="newRoleName" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">الصلاحيات</label>
            <select wire:model="newRolePermissionIds" multiple class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                @foreach($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->key }}</option>
                @endforeach
            </select>
            <small class="text-gray-500">امسك Ctrl/Cmd لاختيار أكثر من صلاحية</small>
        </div>

        @if ($hasRoleCreatePermission)
        <button wire:click="createRole" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition flex items-center gap-2">
            <i class="ri-add-line"></i> إضافة الرول
        </button>
        @else
        <button class="bg-gray-300 text-gray-500 px-4 py-2 rounded cursor-not-allowed flex items-center gap-2" disabled>
            <i class="ri-lock-line"></i> ليس لديك صلاحية لإنشاء رول
        </button>
        @endif


        <hr class="my-6">

        <h3 class="text-lg font-semibold mb-3">قائمة الرولات الحالية وصلاحياتها</h3>

        <div class="space-y-4">
            @foreach($roles as $role)
            <div class="border rounded overflow-hidden shadow">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition cursor-pointer"
                    wire:click="toggleRoleAccordion({{ $role->id }})">
                    <div class="flex items-center gap-2">
                        <i class="ri-shield-line"></i>
                        <span class="font-medium">{{ $role->name }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        @if ($hasRoleEditPermission)
                        <button
                            type="button"
                            wire:click.stop="startEditingRole({{ $role->id }})"
                            class="hover:text-blue-600"
                            title="تعديل">


                            <i class="ri-pencil-line"></i>
                        </button>
                        @else
                        <button
                            type="button"
                            class="text-gray-400 cursor-not-allowed"
                            title="ليس لديك صلاحية لتعديل الرول">
                            <i class="ri-pencil-line"></i>
                        </button>
                        @endif
                        @if ($hasRoleDeletePermission)
                        <button
                            type="button"
                            wire:click.stop="deleteRole({{ $role->id }})"
                            class="hover:text-red-600"
                            title="حذف">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                        @else
                        <button
                            type="button"
                            class="text-gray-400 cursor-not-allowed"
                            title="ليس لديك صلاحية لحذف الرول">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                        @endif


                        <span
                            class="transform transition-transform duration-300"
                            @class(['rotate-180'=> $roleAccordionOpen === $role->id])
                            >
                            <i class="ri-arrow-down-s-line"></i>
                        </span>
                    </div>
                </div>

                @if ($roleAccordionOpen === $role->id)
                <div class="px-4 py-3 bg-white border-t">
                    @if ($editingRoleId === $role->id)
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">اسم الرول</label>
                        <input type="text" wire:model="editRoleName" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">الصلاحيات</label>
                        <select wire:model="editRolePermissionIds" multiple class="w-full border rounded px-3 py-2">
                            @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button
                        wire:click="updateRole"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center gap-2">
                        <i class="ri-save-line"></i> حفظ التعديلات
                    </button>
                    @else
                    @php
                    $add = json_decode($role->additional_data, true);
                    $permIds = $add['permissions'] ?? [];
                    @endphp

                    @if(count($permIds))
                    <ul class="list-disc list-inside text-sm text-gray-700 mt-2">
                        @foreach($permIds as $permId)
                        @php
                        $perm = $permissions->firstWhere('id', $permId);
                        @endphp
                        <li>{{ $perm ? $perm->key : 'Unknown Permission' }}</li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-gray-500 text-sm mt-2">لا يوجد صلاحيات مرتبطة بهذا الرول</p>
                    @endif
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Section 2: Workers --}}
    @if ($activeTab === 'workers')
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="ri-team-line"></i> إضافة عامل وربطه برول
        </h2>

        <div class="mb-4">
        <label class="block text-sm font-medium mb-1">اضافة عامل</label>
        @if (session()->has('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">
        {{ session('success') }}
    </div>
@endif
<input wire:model="UserEmail" type="email"
    pattern="^[^@]+@[^@]+\.[a-zA-Z]{2,}$"
    title="يجب إدخال إيميل صحيح يحتوي على @ وامتداد مثل .com"
    required
    placeholder="ايميل العامل"
    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
@error('UserEmail')
    <span class="text-red-500 text-sm">{{ $message }}</span>
@enderror

<div class="flex gap-3 mt-3">


    <div class="flex-1">
        <input wire:model="UserFname" required type="text"
            placeholder="الاسم الاول"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        @error('UserFname')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex-1">
        <input wire:model="UserLname" required type="text"
            placeholder="الاسم الثاني"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        @error('UserLname')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
</div>

<input wire:model="UserPassword" required type="password"
    placeholder="كلمة السر"
    class="w-full mt-3 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
@error('UserPassword')
    <span class="text-red-500 text-sm">{{ $message }}</span>
@enderror
            @if (!$UserId)
            @if ($hasRoleTeamCreatePermission)
            <button wire:click="adduser" class="bg-blue-500 text-white px-4 py-2 mt-3 rounded hover:bg-blue-600 transition flex items-center gap-2">
                <i class="ri-add-line"></i> إضافة العامل
            </button>
            @else
            <button class="bg-gray-300 text-gray-500 px-4 py-2 mt-3 rounded cursor-not-allowed flex items-center gap-2" disabled>
                <i class="ri-lock-line"></i> ليس لديك صلاحية لإضافة عامل
            </button>
            @endif

            @endif
            @if ($UserId)
            <div class="flex flex-wrap gap-3 mt-3">
                @if ($hasRoleTeamEditPermission)

                <button wire:click="adduser" class="bg-lime-500 text-white px-4 py-2 mt-3 rounded hover:bg-lime-600 transition flex items-center gap-2">
                    <i class="ri-pencil-line"></i> تعديل العامل
                </button>
                <button wire:click="canceledit" class="bg-red-200 text-white px-4 py-2 mt-3 rounded hover:bg-red-400 transition flex items-center gap-2">
                    <i class="ri-pencil-line"></i> الغاء التعديل
                </button>
                @else
                <button class="bg-gray-300 text-gray-500 px-4 py-2 mt-3 rounded cursor-not-allowed flex items-center gap-2" disabled>
                    <i class="ri-lock-line"></i> ليس لديك صلاحية لتعديل العامل
                </button>

                @endif

                @if ($hasRoleTeamkickPermission)
                <button wire:click="deleteUser" class="bg-red-500 text-white px-4 py-2 mt-3 rounded hover:bg-red-600 transition flex items-center gap-2">
                    <i class="ri-pencil-line"></i> طرد العامل
                </button>
                @else
                <button class="bg-gray-300 text-gray-500 px-4 py-2 mt-3 rounded cursor-not-allowed flex items-center gap-2" disabled>
                    <i class="ri-lock-line"></i> ليس لديك صلاحية لطرد العامل
                </button>
                @endif

            </div>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">اختر العامل</label>
            <select wire:model="selectedUserId" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <option value="">-- اختر العامل --</option>
                @foreach($users as $user)
                @if($user->id !== Auth::id())
                <option value="{{ $user->id }}">{{ $user->f_name }}</option>
                @endif
                @endforeach

            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">اختر الرول</label>
            <select wire:model="selectedRoleId" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <option value="">-- اختر الرول --</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        @if ($hasRoleTeamEditPermission)

        <button wire:click="assignWorkerToMerchant" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center gap-2">
            <i class="ri-add-line"></i> إضافة العامل
        </button>
        @else
        <button class="bg-gray-300 text-gray-500 px-4 py-2 rounded cursor-not-allowed flex items-center gap-2" disabled>
            <i class="ri-lock-line"></i> ليس لديك صلاحية لإضافة عامل
        </button>
        @endif

        <hr class="my-6">

        <h3 class="text-lg font-semibold mb-3">قائمة العمال المرتبطين بأدوار</h3>

        <div class="space-y-4">
            @foreach($usersWithRoles as $user)
            <div class="border rounded p-4">
                <h4 class="font-bold flex items-center gap-2">
                    <i class="ri-user-line"></i> {{ $user['employee']->f_name }}
                    @if ($hasRoleTeamEditPermission && $user["employee"]->id != Auth::id())

                    <button wire:click="editUser({{ $user['employee']->id }})" class="text-blue-500 text-sm hover:underline ml-2">
                        <i class="ri-pencil-line"></i> تعديل
                    </button>
                    @else
                    <button class="text-gray-400 cursor-not-allowed text-sm hover:underline ml-2" disabled>
                        <i class="ri-pencil-line"></i> ليس لديك صلاحية لتعديل
                    </button>
                    @endif
                </h4>
                @if($user['roles']->count())
                <ul class="list-disc list-inside text-sm text-gray-700 mt-2">
                    @foreach($user['roles'] as $role)
                    <li class="flex items-center justify-between">
                        <span>{{ $role->name }}</span>
                        @if ($hasRoleTeamEditPermission && $user['employee']->id != Auth::id())

                        <button wire:click="removeRoleFromEmployee({{ $user['employee']->id }}, {{ $role->id }})" class="text-red-500 text-sm hover:underline flex items-center gap-1">
                            <i class="ri-delete-bin-line"></i> حذف
                        </button>
                        @else
                        <button class="text-gray-400 cursor-not-allowed text-sm hover:underline flex items-center gap-1" disabled>
                            <i class="ri-delete-bin-line"></i> ليس لديك صلاحية لحذف
                        </button>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-500 text-sm mt-2">❗ لا يوجد أدوار مرتبطة بهذا العامل</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>