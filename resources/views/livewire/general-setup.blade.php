<div class="max-w-6xl mx-auto p-10 bg-white rounded-3xl shadow-lg border border-gray-200">

    <h2 class="text-4xl font-bold mb-10 text-center text-gray-800 flex items-center justify-center gap-3">
      <i class="ri-settings-3-line text-blue-500 text-5xl"></i>
      إعدادات الموقع
    </h2>
  
    @if (session()->has('success'))
      <div class="mb-8 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3 text-center shadow-sm">
        {{ session('success') }}
      </div>
    @endif
  
    <!-- Tabs -->

    <div class="flex flex-wrap justify-center mb-12 gap-3">
      @php
        
      @endphp
      @foreach($tabs as $key => $label)
        <button
          wire:click="$set('tab', '{{ $key }}')"
          class="px-5 py-2 rounded-full text-sm font-semibold shadow-sm transition duration-300
            {{ $tab == $key ? 'bg-gradient-to-r from-blue-500 to-blue-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
          {{ $label }}
        </button>
      @endforeach
    </div>
  
    <form wire:submit.prevent="save" class="space-y-10">
    @if ($tab == 'account')
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    {{-- First Name --}}
    <div>
        <label for="first_name" class="block text-sm font-medium mb-1">First Name</label>
        <input type="text" wire:model="first_name" id="first_name"
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
        @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Last Name --}}
    <div>
        <label for="last_name" class="block text-sm font-medium mb-1">Last Name</label>
        <input type="text" wire:model="last_name" id="last_name"
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
        @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="block text-sm font-medium mb-1">Email</label>
        <input type="email" wire:model="admin_email" id="admin_email"
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
        @error('admin_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Password --}}
    <div>
        <label for="password" class="block text-sm font-medium mb-1">Password</label>
        <input type="password" wire:model="password" id="password"
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Confirm Password --}}
    <div>
        <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirm Password</label>
        <input type="password" wire:model="password_confirmation" id="password_confirmation"
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
        @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

</div>
@endif






      <!-- GENERAL -->
      @if ($tab == 'general')
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
            <i class="ri-image-line text-blue-500"></i> شعار الموقع
          </label>
          @if ($setup->logo)
            <div class="my-3">
              <img src="{{ asset('storage/' . $setup->logo) }}" class="h-24 rounded-xl shadow border">
            </div>
          @endif
          <input wire:model="logo" type="file"
            class="block w-full border-gray-300 rounded-xl shadow-sm text-sm file:rounded-full file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 transition">
        </div>
  
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
            <i class="ri-pencil-line text-blue-500"></i> اسم الموقع
          </label>
          <input wire:model.defer="name" type="text"
            class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-300 transition text-sm px-4 py-2">
        </div>
      </div>
      @endif
  
      <!-- CONTACT -->
      @if ($tab == 'contact')
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
            <i class="ri-mail-line text-blue-500"></i> البريد الإلكتروني
          </label>
          <input wire:model.defer="email" type="email"
            class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-300 transition text-sm px-4 py-2">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
            <i class="ri-phone-line text-blue-500"></i> رقم الهاتف
          </label>
          <input wire:model.defer="phone" type="text"
            class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-300 transition text-sm px-4 py-2">
        </div>
      </div>
      @endif
  
      <!-- SOCIAL -->
      @if ($tab == 'social')
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">🌐 Facebook</label>
          <input wire:model.defer="social_links.facebook" type="text"
            class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 transition text-sm px-4 py-2">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">🐦 Twitter</label>
          <input wire:model.defer="social_links.twitter" type="text"
            class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 transition text-sm px-4 py-2">
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-2">📸 Instagram</label>
          <input wire:model.defer="social_links.instagram" type="text"
            class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 transition text-sm px-4 py-2">
        </div>
      </div>
      @endif
  
      <!-- PAYMENT -->
      @if ($tab == 'payment')
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">💰 العملة الافتراضية</label>
          <input wire:model.defer="additional_data.currency" type="text"
            class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 transition text-sm px-4 py-2">
        </div> -->
        <!-- <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">💱 العملات المسموحة (بفواصل)</label>
          <input wire:model.defer="additional_data.allowed_currencies" type="text"
            class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 transition text-sm px-4 py-2">
        </div> -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">🪙 عمولة المنصة (%)</label>
          <input wire:model.defer="additional_data.percent" type="text"
            class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 transition text-sm px-4 py-2">
        </div>
        <div class="md:col-span-2 flex items-center gap-3 mt-3">
          <input wire:model.defer="additional_data.auto_accept" type="checkbox"
            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-400 transition">
          <span class="text-sm text-gray-700">✅ قبول تلقائي لطلبات التجار</span>
        </div>
      </div>
      @endif
  
      <!-- POLICY -->
      @if ($tab == 'policy')
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
          <i class="ri-shield-keyhole-line text-blue-500"></i> سياسة الخصوصية
        </label>
        <textarea wire:model.defer="additional_data.policy" rows="8"
          class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 transition text-sm px-4 py-2"></textarea>
      </div>
      @endif
  
      <!-- TERMS -->
      @if ($tab == 'terms')
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
          <i class="ri-file-list-3-line text-blue-500"></i> الشروط والأحكام
        </label>
        <textarea wire:model.defer="additional_data.terms" rows="8"
          class="w-full border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 transition text-sm px-4 py-2"></textarea>
      </div>
      @endif
  
      <div class="text-center pt-6">
        @if ($can_save)
          
        <button type="submit"
          class="inline-flex items-center gap-2 px-8 py-3 rounded-full bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 focus:ring-2 focus:ring-green-400 shadow-lg transition">
          <i class="ri-save-line text-xl"></i> حفظ الإعدادات
        </button>
        @else
        <button type="button"
          class="inline-flex items-center gap-2 px-8 py-3 rounded-full bg-gray-300 text-gray-700 cursor-not-allowed shadow-lg transition">
          <i class="ri-lock-line text-xl"></i> لا يمكن الحفظ الآن
        </button>
        @endif

      </div>
    </form>
  </div>
  