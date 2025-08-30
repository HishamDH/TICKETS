<form wire:submit.prevent="save" class="max-w-5xl mx-auto mt-12 bg-white p-8 rounded-xl shadow space-y-6" enctype="multipart/form-data">
    <div class="flex items-center gap-6">
        <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200">
            @if (isset(Auth::user()->additional_data['profile_picture']))
                <img src="{{ asset('storage/' . Auth::user()->additional_data['profile_picture']) }}" class="w-full h-full object-cover" />
            @else
                <img src="https://via.placeholder.com/150" class="w-full h-full object-cover" />
            @endif
        </div>
        
        <label class="inline-block cursor-pointer bg-gray-100 px-4 py-2 rounded-md border text-sm">
            تغيير الصورة
            <input type="file" wire:model="image" hidden accept="image/*">
        </label>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">الاسم الأول</label>
            <input type="text" wire:model.lazy="f_name" class="w-full border rounded-md p-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">الاسم الأخير</label>
            <input type="text" wire:model.lazy="l_name" class="w-full border rounded-md p-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">البريد الإلكتروني</label>
            <input type="email" wire:model.lazy="email" disabled class="w-full border bg-gray-100 rounded-md p-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">رقم الجوال</label>
            <input type="text" wire:model.lazy="phone" class="w-full border rounded-md p-2" />
        </div>


    </div>

    <div class="bg-gray-50 p-6 rounded-xl shadow-inner space-y-4">
        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">تغيير كلمة المرور</h2>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور الجديدة</label>
            <input type="password" wire:model.lazy="password"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">تأكيد كلمة المرور</label>
            <input type="password" wire:model.lazy="password_confirmation"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
            @error('password_confirmation')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="text-left">
            <button wire:click="updatePass"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition shadow">
                تحديث كلمة المرور
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 pt-4">
        <div class="flex items-center justify-between bg-slate-50 p-3 rounded-lg">
            <span class="text-sm font-medium">إشعارات البريد الإلكتروني</span>
            <input type="checkbox" wire:model.lazy="notify_email" class="form-checkbox rounded text-blue-600">
        </div>

        <div class="flex items-center justify-between bg-slate-50 p-3 rounded-lg">
            <span class="text-sm font-medium">إشعارات SMS</span>
            <input type="checkbox" wire:model.lazy="notify_sms" class="form-checkbox rounded text-blue-600">
        </div>
    </div>
</form>
