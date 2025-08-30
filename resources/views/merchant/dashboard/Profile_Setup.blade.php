@extends('merchant.layouts.app')
@section('content')

@php
$data = is_array(Auth::guard('merchant')->user()->additional_data??null) ? Auth::guard('merchant')->user()->additional_data : json_decode(Auth::guard('merchant')->user()->additional_data??'', true);
$user = Auth::guard('merchant')->user();
//dd($user);
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<div class="flex-1 p-8">

    <div class="rounded-2xl border mt-4 border-slate-200 bg-white text-slate-900 shadow-lg p-6 space-y-6">
        <h2 class="text-2xl font-bold">تعديل إعدادات الصفحة</h2>
      
        <form method="POST" action="{{route("merchant.dashboard.update_ProfileS",['id'=>Auth::id()])}}" class="space-y-4">
            @csrf
            
      
            <!-- الاسم الأول -->
            <div>
                <label class="block text-sm font-medium mb-1" for="f_name">الاسم الأول</label>
                <input type="text" name="f_name" id="f_name" value="{{ old('f_name', $user->f_name) }}"
                    class="w-full px-4 py-2 rounded-md border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
      
            <!-- الاسم الأخير -->
            <div>
                <label class="block text-sm font-medium mb-1" for="l_name">الاسم الأخير</label>
                <input type="text" name="l_name" id="l_name" value="{{ old('l_name', $user->l_name) }}"
                    class="w-full px-4 py-2 rounded-md border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
      

      
            <!-- زر الحفظ -->
            <div class="text-end">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md text-sm">حفظ التغييرات</button>
            </div>
        </form>
      </div>


  <div class="rounded-2xl border mt-4 border-slate-200 bg-white text-slate-900 shadow-lg p-6 space-y-6">
    <h2 class="text-2xl font-bold">تغيير كلمة المرور</h2>
  
    <form method="POST" action="{{ route('merchant.dashboard.update_password', ['id' => Auth::id()]) }}" class="space-y-4">
        @csrf
  
        <!-- كلمة المرور الجديدة -->
        <div>
          <label class="block text-sm font-medium mb-1" for="password">كلمة المرور القديمة</label>
          <input type="name" name="old_password" id="password"
              class="w-full px-4 py-2 rounded-md border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
              required
              
              placeholder="كلمة المرور القديمة"
              title="كلمة المرور يجب أن تحتوي على حرف كبير، رقم، وحرف خاص، وألا تقل عن 8 أحرف">
          @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
      </div>

        <div>
            <label class="block text-sm font-medium mb-1" for="password">كلمة المرور الجديدة</label>
            <input type="password" name="password" id="password"
                class="w-full px-4 py-2 rounded-md border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                required
                
                placeholder="كلمة المرور"
                pattern="(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}"
                title="كلمة المرور يجب أن تحتوي على حرف كبير، رقم، وحرف خاص، وألا تقل عن 8 أحرف">
            @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
  
        <!-- تأكيد كلمة المرور -->
        <div>
            <label class="block text-sm font-medium mb-1" for="password_confirmation">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="w-full px-4 py-2 rounded-md border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                required placeholder="الحقق من كلمة المرور">
        </div>
  
        <!-- زر الحفظ -->
        <div class="text-end">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md text-sm">
                حفظ كلمة المرور
            </button>
        </div>
    </form>
  </div>
  

</div>

</div>


@endsection
