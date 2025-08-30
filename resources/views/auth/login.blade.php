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
                            <h1 class="text-3xl md:text-4xl font-bold text-orange-500 mb-2">تسجيل الدخول</h1>
                            <p class="text-gray-600">ابدأ رحلتك في إدارة أعمالك بكفاءة واحترافية.</p>
                        </div>
                        @error('email')
                        <div class="p-4 bg-red-500/10 text-red-500 border border-red-500 rounded-md text-sm mb-4">
                            {{ $message }}
                        </div>

                        @enderror
                        <form action="{{route('singin',['guard'=>'merchant'])}}" method="POST" class="space-y-6">
                            @csrf
                            <div bis_skin_checked="1"><label class="block text-sm font-medium text-gray-700 mb-2" for="email">البريد الإلكتروني</label><input name="email" type="email" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" required="" id="email" placeholder="example@ticket-window.sa"></div>
                            <div bis_skin_checked="1"><label class="block text-sm font-medium text-gray-700 mb-2" for="password">كلمة المرور</label><input name="password" type="password" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" required="" id="password" placeholder="كلمة المرور"></div>
                            <button class="inline-flex items-center justify-center ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-500/90 h-11 rounded-md px-8 w-full bg-orange-500 text-white py-6 text-lg font-semibold transform hover:scale-105 transition-transform" type="submit">تسجيل الدخول</button>
                        </form>
                        <div class="text-center mt-4">ليس لديك حساب؟ <a href="{{ route('register') }}" class="text-orange-500 font-bold">طلب الانضمام</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
