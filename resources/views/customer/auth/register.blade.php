@extends('layouts.app')
@section('content')

<main class="pt-16">
    <div bis_skin_checked="1" style="opacity: 1; transform: none;">
        <div class="min-h-screen bg-orange-500/5 py-12" bis_skin_checked="1">
            <div class="container mx-auto px-4" bis_skin_checked="1">
                <div class="max-w-2xl mx-auto" bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-xl p-8 md:p-10 border" bis_skin_checked="1">
                        <div class="text-center mb-8" bis_skin_checked="1">
                            <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10 text-white">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg></div>
                            <h1 class="text-3xl md:text-4xl font-bold text-orange-500 mb-2">انشاء حساب</h1>
                            <p class="text-gray-600">ابدأ رحلتك في إدارة حجوزاتك بكفاءة واحترافية.</p>
                        </div>


                        @if ($errors->any())
    <div class="mb-4 text-red-600 space-y-1 bg-red-100 rounded-lg p-4">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form action="{{route('customer.signup',request()->all())}}" method="POST" class="space-y-6">
    @csrf
    @if(request()->has('redirect'))
        <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
    @endif

    <div class="grid md:grid-cols-2 gap-6" bis_skin_checked="1">
        <div bis_skin_checked="1">
            <label class="block text-sm font-medium text-gray-700 mb-2" for="firstName">الاسم الأول</label>
            <input name="f_name" value="{{ old('f_name') }}" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" required="" id="firstName" placeholder="أدخل اسمك الأول">
            @error('f_name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div bis_skin_checked="1">
            <label class="block text-sm font-medium text-gray-700 mb-2" for="lastName">اسم العائلة</label>
            <input name="l_name" value="{{ old('l_name') }}" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" required="" id="lastName" placeholder="أدخل اسم العائلة">
            @error('l_name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
    </div>

    <div bis_skin_checked="1">
        <label class="block text-sm font-medium text-gray-700 mb-2" for="email">البريد الإلكتروني</label>
        <input name="email" type="email" value="{{ old('email') }}" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" required="" id="email" placeholder="example@domain.com">
        @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2" for="country_code">رمز الدولة</label>
        <select name="country_code" id="country_code" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500">
            <option value="+1">🇺🇸 أمريكا (+1)</option>
            <option value="+966">🇸🇦 السعودية (+966)</option>
            <option value="+971">🇦🇪 الإمارات (+971)</option>
            <option value="+20">🇪🇬 مصر (+20)</option>
        </select>
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2" for="phone">رقم الهاتف</label>
        <input name="phone" type="tel" value="{{ old('phone') }}" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500" required id="phone" placeholder="5X XXX XXXX">
        @error('phone') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>
    

    <div class="grid md:grid-cols-2 gap-6" bis_skin_checked="1">
        <div bis_skin_checked="1">
            <label class="block text-sm font-medium text-gray-700 mb-2" for="password">كلمة المورور</label>
            <input name="password" type="password"
                class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                required="" id="firstName" placeholder="كلمة المرور"
                pattern="(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}"
                title="كلمة المرور يجب أن تحتوي على حرف كبير، رقم، وحرف خاص، وألا تقل عن 8 أحرف">
            @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div bis_skin_checked="1">
            <label class="block text-sm font-medium text-gray-700 mb-2" for="password_confirmation">التحقق من كلمة المرور</label>
            <input name="password_confirmation" type="password" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" required="" id="lastName" placeholder="الحقق من كلمة المرور">
        </div>
    </div>

    <button class="inline-flex items-center justify-center ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-500/90 h-11 rounded-md px-8 w-full bg-orange-500 text-white py-6 text-lg font-semibold transform hover:scale-105 transition-transform" type="submit">إرسال طلب التسجيل</button>
</form>



                        <div class="text-center mt-4">هل لديك حساب؟ <a href="{{ route('customer.login',request()->all()) }}" class="text-orange-500 font-bold">تسجيل الدخول</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    const activitySelect = document.getElementById("activityType");
    const otherInputContainer = document.getElementById("otherInputContainer");

    activitySelect.addEventListener("change", function () {
      if (this.value === "other") {
        otherInputContainer.style.display = "block";
      } else {
        otherInputContainer.style.display = "none";
      }
    });
  </script>
@endsection
