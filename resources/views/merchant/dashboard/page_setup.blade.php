@extends('merchant.layouts.app', ["merchant"=> $merchantid ?? false])
@section('content')

@php
$user = App\Models\User::find($finalID);
$data = is_array($user->additional_data??null) ? $user->additional_data : json_decode($user->additional_data??'', true);
$socialLinks = $data['social_links'] ?? [];
//$user = Auth::guard('merchant')->user();
//dd($user);
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<div class="flex-1 p-8">
  @php
  if(isset($merchantid)){
      $hasEditPPermission = has_Permetion(Auth::id(),'settings_edit', $merchantid);

  }else {
      $hasEditPPermission = true;
  }
  @endphp

  <fieldset  @if (!$hasEditPPermission) disabled @endif>
    <form method="POST" action="{{ isset($merchantid) ?  route('merchant.dashboard.m.update', ['id'=>$finalID , "merchant" => $merchantid]) :  route('merchant.dashboard.update', ['id'=>$finalID]) }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- الشعار والبنر -->
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold">الشعار والبانر</h2>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- الشعار -->
                <div class="space-y-2">
                    <label class="block font-medium mb-1">الشعار</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-slate-100 rounded-full overflow-hidden flex items-center justify-center">
                            <img id="preview_logo" src="{{ isset($data['profile_picture']) ? asset('storage/' . $data['profile_picture']) : '#' }}"
                                class="w-full h-full object-cover {{ isset($data['profile_picture']) ? '' : 'hidden' }}">
                            <i id="default_logo_icon" class="ri-image-add-line text-2xl text-slate-400 {{ isset($data['profile_picture']) ? 'hidden' : '' }}"></i>
                        </div>
                        <label class="cursor-pointer bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">
                            رفع صورة
                            <input type="file" name="profile_picture" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_logo', 'default_logo_icon')">
                        </label>
                    </div>
                </div>

                <!-- البنر -->
                <div class="space-y-2">
                    <label class="block font-medium mb-1">البانر</label>
                    <div class="flex items-center gap-4">
                        <div class="w-full h-20 bg-slate-100 rounded-lg overflow-hidden flex items-center justify-center">
                            <img id="preview_banner" src="{{ isset($data['banner']) ? asset('storage/' . $data['banner']) : '#' }}"
                                class="w-full h-full object-cover {{ isset($data['banner']) ? '' : 'hidden' }}">
                            <i id="default_banner_icon" class="ri-image-add-line text-2xl text-slate-400 {{ isset($data['banner']) ? 'hidden' : '' }}"></i>
                        </div>
                        <label class="cursor-pointer bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">
                            رفع صورة
                            <input type="file" name="banner" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_banner', 'default_banner_icon')">
                        </label>
                    </div>
                </div>
            </div>
            <h2 class="text-2xl font-bold">روابط التواصل الاجتماعي</h2>
            <div id="social-links-container" class="space-y-3">
                @foreach ($socialLinks as $link)
                <div class="flex items-center gap-2 social-input-group">
                    <span class="icon w-6 h-6 text-slate-400 flex items-center justify-center">
                        <i class="ri-global-line"></i>
                    </span>
                    <input name="social_links[]" type="url" value="{{ $link }}" oninput="updateSocialIcon(this)"
                        class="flex-1 border border-slate-300 px-4 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                        placeholder="https://...">
                    <button type="button" onclick="removeSocialLink(this)" class="text-red-500 hover:text-red-700 text-sm">✕</button>
                </div>
                @endforeach
            </div>

            <div>
                <button type="button" onclick="addSocialLink()" class="text-orange-600 hover:text-orange-800 text-sm flex items-center gap-1">
                    <i class="ri-add-line"></i>
                    إضافة رابط جديد
                </button>
            </div>
            <div class="text-end">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md">حفظ التغييرات</button>
            </div>
        </div>
    </form>

    <!-- القوالب والألوان -->
    <!-- <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg p-6 space-y-6">
  <h2 class="text-2xl font-bold">الألوان والقوالب</h2>

  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">اختر اللون الرئيسي</label>
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-orange-500 ring-2 ring-orange-500"></div>
      <div class="w-10 h-10 rounded-lg bg-blue-500"></div>
      <div class="w-10 h-10 rounded-lg bg-rose-500"></div>
      <div class="w-10 h-10 rounded-lg bg-slate-800"></div>
      <input type="color" value="#ff7842" disabled class="rounded-lg border border-slate-300 w-12 h-10 p-1 opacity-50 cursor-not-allowed">
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">نماذج القوالب</label>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="cursor-pointer group">
        <div class="h-24 rounded-lg bg-white border flex items-center justify-center group-hover:ring-2 ring-orange-500 transition-all">
          <i class="ri-layout-4-fill text-slate-500 text-2xl"></i>
        </div>
        <p class="text-center mt-2 font-semibold text-sm">القالب الأبيض</p>
      </div>
      <div class="cursor-pointer group">
        <div class="h-24 rounded-lg bg-slate-900 flex items-center justify-center group-hover:ring-2 ring-orange-500 transition-all">
          <i class="ri-layout-4-fill text-white text-2xl"></i>
        </div>
        <p class="text-center mt-2 font-semibold text-sm">القالب الداكن</p>
      </div>
      <div class="cursor-pointer group">
        <div class="h-24 rounded-lg bg-pink-200 flex items-center justify-center group-hover:ring-2 ring-orange-500 transition-all">
          <i class="ri-layout-4-fill text-pink-800 text-2xl"></i>
        </div>
        <p class="text-center mt-2 font-semibold text-sm">الوردي</p>
      </div>
      <div class="cursor-pointer group">
        <div class="h-24 rounded-lg bg-sky-200 flex items-center justify-center group-hover:ring-2 ring-orange-500 transition-all">
          <i class="ri-layout-4-fill text-sky-800 text-2xl"></i>
        </div>
        <p class="text-center mt-2 font-semibold text-sm">السماوي</p>
      </div>
    </div>
  </div>
</div> -->

<div class="rounded-2xl border mt-4 border-slate-200 bg-white text-slate-900 shadow-lg p-6 space-y-6">
  <h2 class="text-2xl font-bold">تعديل إعدادات الصفحة</h2>

  <form method="POST" action="{{ isset($merchantid) ? route("merchant.dashboard.m.update_settings",['id'=>$finalID,"merchant" => $merchantid]) : route("merchant.dashboard.update_settings",['id'=>$finalID])}}" class="space-y-4">
      @csrf
      

      {{-- <!-- الاسم الأول -->
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
      </div> --}}

      <!-- البريد الإلكتروني -->
      <div>
          <label class="block text-sm font-medium mb-1" for="email">البريد الإلكتروني الخاص بصفحة</label>
          <input type="email" name="email" id="email" value="{{ old('email', $user->additional_data['page_email'] ?? null) }}"
              class="w-full px-4 py-2 rounded-md border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
      </div>

      <!-- رقم الهاتف -->
      <div>
          <label class="block text-sm font-medium mb-1" for="phone">رقم الهاتف</label>
          <input type="tel"  name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
              class="w-full px-4 py-2 rounded-md border border-slate-300 text-sm rtl:text-right focus:outline-none focus:ring-2 focus:ring-orange-500">
      </div>

      <!-- زر الحفظ -->
      <div class="text-end">
          <button type="submit"
              class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md text-sm">حفظ التغييرات</button>
      </div>
  </form>
</div>


<div class="rounded-2xl border mt-4 border-slate-200 bg-white text-slate-900 shadow-lg p-6 space-y-6">
  <h2 class="text-2xl font-bold">تعديل إعدادات النشاط</h2>

  <form method="POST" action="{{ isset($merchantid) ? route("merchant.dashboard.m.update_work",['id'=>$finalID, "merchant" => $merchantid]) : route("merchant.dashboard.update_work",['id'=>$finalID])}}" class="space-y-4">
      @csrf
      

      {{-- <!-- الاسم الأول -->
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
      </div> --}}

      <div bis_skin_checked="1">
        <label class="block text-sm font-medium text-gray-700 mb-2" for="activityType">نوع
            النشاط</label>
            <select name="business_type" required id="activityType"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all bg-white @error('business_type') border-red-500 @else border-slate-300 @enderror">
            <option @selected(old('business_type', $user->business_type) == null || old('business_type', $user->business_type) == '') disabled>اختر نوع النشاط</option>
            <option @selected(old('business_type', $user->business_type) == 'events') value="events">تنظيم الفعاليات</option>
            <option @selected(old('business_type', $user->business_type) == 'restaurant') value="restaurant">مطعم</option>
            <option @selected(old('business_type', $user->business_type) == 'show') value="show">معارض</option>
            <option @selected(old('business_type', $user->business_type) == 'other') value="other">أخرى</option>
        </select>
        
        @error('business_type')
            <label for="" class="text-red-500">{{ $message }}</label>
        @enderror
    </div>

    <div id="otherInputContainer"
        @if (old('business_type', $user->business_type) == 'other') style="display: block;" @else style="display: none;" @endif
        class="mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-2" for="otherInput">يرجى
            تحديد نوع النشاط</label>
        <input type="text" id="otherInput" name="other_business_type"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all bg-white @error('other_business_type') border-red-500 @else border-slate-300 @enderror"
            value="{{ old('other_business_type',$user->additional_data['other_business_type'] ?? '') }}" placeholder="اكتب نوع النشاط">
        @error('other_business_type')
            <label for="otherInput" class="text-red-500">{{ $message }}</label>
        @enderror
    </div>

    <div bis_skin_checked="1">
        <label class="block text-sm font-medium text-gray-700 mb-2" for="businessName">اسم
            النشاط التجاري</label>
        <input name="business_name"
            class="flex h-10 w-full rounded-lg border bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('business_name') border-red-500 @else border-slate-300 @enderror"
            value="{{ old('business_name',$user->business_name) }}" required="" id="businessName"
            placeholder="أدخل اسم نشاطك التجاري">
        @error('businessName')
            <label for="businessName" class="text-red-500">{{ $message }}</label>
        @enderror
    </div>

      <!-- زر الحفظ -->
      <div class="text-end">
          <button type="submit"
              class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md text-sm">حفظ التغييرات</button>
      </div>
  </form>
</div>
  </fieldset>
<!-- سكريبت المعاينة والتبديل -->
<script>
    function previewImage(input, previewId, iconId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(previewId);
                const icon = document.getElementById(iconId);
                img.src = e.target.result;
                img.classList.remove('hidden');
                icon.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function addSocialLink() {
        const container = document.getElementById('social-links-container');
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 social-input-group';
        div.innerHTML = `
      <span class="icon w-6 h-6 text-slate-400 flex items-center justify-center">
        <i class="ri-add-line"></i>
      </span>
      <input name="social_links[]" type="url" placeholder="https://..." oninput="updateSocialIcon(this)"
             class="flex-1 border border-slate-300 px-4 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
      <button type="button" onclick="removeSocialLink(this)" class="text-red-500 hover:text-red-700 text-sm">✕</button>
    `;
        container.appendChild(div);
    }

    function removeSocialLink(btn) {
        btn.parentElement.remove();
    }

    function updateSocialIcon(input) {
        const url = input.value.toLowerCase();
        const iconSpan = input.parentElement.querySelector('.icon');
        let iconClass = 'ri-global-line';

        //let iconClass = '';

if (url.includes('facebook.com'))        iconClass = 'ri-facebook-fill';
else if (url.includes('twitter.com'))    iconClass = 'ri-twitter-x-fill';
else if (url.includes('instagram.com'))  iconClass = 'ri-instagram-line';
else if (url.includes('tiktok.com'))     iconClass = 'ri-tiktok-fill';
else if (url.includes('youtube.com'))    iconClass = 'ri-youtube-fill';
else if (url.includes('pinterest.com'))  iconClass = 'ri-pinterest-fill';
else if (url.includes('linkedin.com'))   iconClass = 'ri-linkedin-fill';
else if (url.includes('snapchat.com'))   iconClass = 'ri-snapchat-fill';
else if (url.includes('whatsapp.com'))   iconClass = 'ri-whatsapp-fill';
else if (url.includes('telegram.me') || url.includes('t.me')) iconClass = 'ri-telegram-fill';
else if (url.includes('github.com'))     iconClass = 'ri-github-fill';
else if (url.includes('reddit.com'))     iconClass = 'ri-reddit-fill';
else if (url.includes('medium.com'))     iconClass = 'ri-medium-fill';
else if (url.includes('dribbble.com'))   iconClass = 'ri-dribbble-fill';
else if (url.includes('behance.net'))    iconClass = 'ri-behance-fill';
else if (url.includes('flickr.com'))     iconClass = 'ri-flickr-fill';
else if (url.includes('tumblr.com'))     iconClass = 'ri-tumblr-fill';
else if (url.includes('vimeo.com'))      iconClass = 'ri-vimeo-fill';
else if (url.includes('itch.io'))        iconClass = 'fa-brands fa-itch-io'; // FontAwesome
else if (url.includes('discord.gg') || url.includes('discord.com')) iconClass = 'ri-discord-fill';


        iconSpan.innerHTML = `<i class="${iconClass}"></i>`;
    }

    window.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('#social-links-container input[type="url"]').forEach(input => {
        updateSocialIcon(input);
      });
    });

  window.addEventListener('livewire:navigated', () => {
    document.querySelectorAll('#social-links-container input[type="url"]').forEach(input => {
        updateSocialIcon(input);
    });
  });


</script>

<!-- Remix Icon CDN -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
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
