<div class="w-full max-w-6xl mx-auto mb-12" x-data="{ showForm: false, showTform: false }">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- البانر --}}
    <div class="relative w-full h-52 md:h-64 bg-cover bg-center rounded-b-3xl shadow-2xl ring-1 ring-orange-200"
        style="background-image: url('{{ isset($merchant['additional_data']['banner']) ? asset('storage/' . $merchant['additional_data']['banner']) : asset('default-banner.jpg') }}')">


        <div class="absolute top-2 left-4 flex gap-4 z-20">

            <a href="{{ route('customer.dashboard.tickets.index') }}" wire:navigate>
                <button class="bg-white p-3 rounded-md shadow-lg hover:bg-gray-300 transition text-2xl text-gray-800">
                    <i class="ri-shopping-cart-2-line"></i>
                </button>
            </a>
            <a href="{{ route('customer.dashboard.overview') }}" wire:navigate>
                <button class="bg-white p-3 rounded-md shadow-lg hover:bg-gray-300 transition text-2xl text-gray-800">
                    <i class="ri-user-settings-line"></i>
                </button>
            </a>
        </div>



    </div>


    {{-- الصورة الشخصية --}}
    <div class="relative w-full flex justify-center -mt-16 md:-mt-20 z-10">
        <img src="{{ isset($merchant['additional_data']['profile_picture']) ? asset('storage/' . $merchant['additional_data']['profile_picture']) : asset('default-avatar.png') }}"
            class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-2xl object-cover ring-2 ring-orange-400" />
    </div>

    {{-- معلومات التاجر --}}
    <div class="text-center mt-4 px-4">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800">{{ $merchant['business_name'] ?? '' }}</h1>
        <p class="text-slate-600 mt-1 text-lg font-medium">
            {{ $merchant->additional_data ? $merchant->additional_data['discription'] ?? '' : '' }}
        </p>
        <div class="mt-4 flex flex-col gap-2 justify-center items-center text-sm text-gray-500">
            @if (isset($merchant->phone))
            <div class="flex items-center gap-1">
                <a href="tel:{{ $merchant->phone }}" dir="ltr">{{ $merchant->phone }}</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 2H8a2 2 0 00-2 2v16a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2zM12 18h.01" />
                </svg>

            </div>
            @endif
            @if (isset($merchant->additional_data['page_email']))
            <div class="flex items-center gap-1">
                <a href="mailto:{{ $merchant->additional_data['page_email'] ?? '' }}" dir="ltr">
                    {{ $merchant->additional_data['page_email'] }}
                </a>
                <!-- أيقونة الظرف البريدي -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            @endif


        </div>

        {{-- روابط تواصل اجتماعي --}}
        @if (isset($merchant['additional_data']['social_links']))
        <div class="flex justify-center gap-4 mt-4 text-2xl text-slate-700" x-data="{
                getIcon(url) {
                    url = url.toLowerCase();
                    if (url.includes('facebook.com')) return 'ri-facebook-fill';
                    if (url.includes('twitter.com')) return 'ri-twitter-x-fill';
                    if (url.includes('instagram.com')) return 'ri-instagram-line';
                    if (url.includes('tiktok.com')) return 'ri-tiktok-fill';
                    if (url.includes('youtube.com')) return 'ri-youtube-fill';
                    if (url.includes('pinterest.com')) return 'ri-pinterest-fill';
                    if (url.includes('linkedin.com')) return 'ri-linkedin-fill';
                    if (url.includes('snapchat.com')) return 'ri-snapchat-fill';
                    if (url.includes('whatsapp.com')) return 'ri-whatsapp-fill';
                    if (url.includes('telegram.me') || url.includes('t.me')) return 'ri-telegram-fill';
                    if (url.includes('github.com')) return 'ri-github-fill';
                    if (url.includes('reddit.com')) return 'ri-reddit-fill';
                    if (url.includes('medium.com')) return 'ri-medium-fill';
                    if (url.includes('dribbble.com')) return 'ri-dribbble-fill';
                    if (url.includes('behance.net')) return 'ri-behance-fill';
                    if (url.includes('flickr.com')) return 'ri-flickr-fill';
                    if (url.includes('tumblr.com')) return 'ri-tumblr-fill';
                    if (url.includes('vimeo.com')) return 'ri-vimeo-fill';
                    if (url.includes('itch.io')) return 'fa-brands fa-itch-io'; // FontAwesome
                    if (url.includes('discord.gg') || url.includes('discord.com')) return 'ri-discord-fill';
                    return 'ri-global-line';
                }
            }">

            @foreach ($merchant['additional_data']['social_links'] as $link)
            <a href="{{ $link }}" target="_blank"
                class="hover:text-orange-500 transition duration-300">
                <i :class="getIcon('{{ $link }}')"></i>
            </a>
            @endforeach
        </div>
        @endif


    </div>

    {{-- تبويبات العروض --}}
    @php
    $latestPublishedOffer = $merchant->offers()->where('status', 'active')->latest()->first();
    @endphp
    <div x-data="{ tab: '{{ $latestPublishedOffer->type ?? null }}' }" class="mt-10 px-4">
        <div class="flex justify-center gap-6 mb-6">
            <button @click="tab = 'services'"
                :class="tab === 'services' ? 'text-orange-600 border-b-2 border-orange-600' : 'text-slate-600'"
                class="pb-1 text-lg font-semibold transition">
                الخدمات
            </button>
            <button @click="tab = 'events'"
                :class="tab === 'events' ? 'text-orange-600 border-b-2 border-orange-600' : 'text-slate-600'"
                class="pb-1 text-lg font-semibold transition">
                الفعاليات
            </button>
            <button @click="tab = 'ratings'" wire:click="load_chats"
                :class="tab === 'ratings' ? 'text-orange-600 border-b-2 border-orange-600' : 'text-slate-600'"
                class="pb-1 text-lg font-semibold transition">
                التقيمات
            </button>
            <button @click="tab = 'policies'"
                :class="tab === 'policies' ? 'text-orange-600 border-b-2 border-orange-600' : 'text-slate-600'"
                class="pb-1 text-lg font-semibold transition">
                السياسات
            </button>
            <button @click="tab = 'support'" wire:click="load_chats"
                :class="tab === 'support' ? 'text-orange-600 border-b-2 border-orange-600' : 'text-slate-600'"
                class="pb-1 text-lg font-semibold transition">
                الدعم
            </button>

        </div>



        <div x-show="tab === 'ratings'" x-transition class="flex flex-col items-center justify-start min-h-screen space-y-4 p-4">

            @forelse($reviews as $review)
            @php
            $additional = $review->additional_data;
            $user = $review->user ?? null;
            $rating = floatval($review->rating);
            $f_name = $user->f_name ?? 'مجهول';
            $l_name = $user->l_name ?? '';
            $profile = $user->additional_data['profile_picture'] ?? null;
            @endphp

            <div class="w-full md:w-2/3 bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-shadow p-4 flex flex-col space-y-2">

                {{-- رأس البطاقة: صورة المستخدم و الاسم --}}
                <div class="flex items-center gap-3">

                    @if($profile)
                    <img src="{{ Storage::url($profile) }}" alt="صورة المستخدم" class="w-12 h-12 rounded-full object-cover border border-gray-300">
                    @else
                    <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($f_name,0,1)) }}
                    </div>
                    @endif

                    <div>
                        <p class="font-semibold text-gray-800">{{ $f_name }} {{ $l_name }}</p>
                        <div class="flex space-x-1 mt-1">
                            {{-- نجوم التقييم --}}
                            @for ($i = 1; $i <= 5; $i++)
                                @if($i <=floor($rating))
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 .587l3.668 7.568L24 9.423l-6 5.843L19.335 24 12 19.771 4.665 24 6 15.266 0 9.423l8.332-1.268z" /></svg>
                                @elseif($i - $rating < 1)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" viewBox="0 0 24 24">
                                    <defs>
                                        <linearGradient id="half">
                                            <stop offset="50%" stop-color="currentColor" />
                                            <stop offset="50%" stop-color="transparent" />
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#half)" d="M12 .587l3.668 7.568L24 9.423l-6 5.843L19.335 24 12 19.771 4.665 24 6 15.266 0 9.423l8.332-1.268z" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 .587l3.668 7.568L24 9.423l-6 5.843L19.335 24 12 19.771 4.665 24 6 15.266 0 9.423l8.332-1.268z" />
                                    </svg>
                                    @endif
                                    @endfor
                        </div>
                    </div>
                </div>

                {{-- نص المراجعة --}}
                <p class="text-gray-800">{{ $review->review }}</p>

                {{-- بيانات إضافية --}}
                @if(!empty($additional))
                <div class="text-sm text-gray-500 mt-2 border-t pt-2 space-y-1">
                    @foreach($additional as $key => $value)
                    @if(!in_array($key, ['ip', 'profile_picture']))
                    <p><span class="font-semibold">{{ ucfirst(str_replace('_',' ',$key)) }}:</span> {{ is_bool($value) ? ($value ? 'نعم' : 'لا') : $value }}</p>
                    @endif
                    @endforeach
                </div>
                @endif

                <div class="text-xs text-gray-400 mt-2">
                    {{ \Carbon\Carbon::parse($review->created_at)->format('Y-m-d H:i') }}
                </div>
            </div>

            @empty
            <p class="text-gray-500">لا توجد تقييمات بعد.</p>
            @endforelse

        </div>


        <div x-show="tab === 'policies'" x-transition class="flex items-center justify-center min-h-screen">
            <div class="bg-white shadow-lg rounded-2xl p-6 space-y-6 w-full max-w-2xl ">

                <!-- العنوان -->
                <h3 class="text-xl font-bold text-slate-800 flex gap-2">
                    <i class="ri-file-text-line text-orange-500 text-2xl"></i>
                    السياسات والأحكام
                </h3>

                <!-- نص السياسة -->
                <div class="bg-slate-50 rounded-xl p-4 shadow-sm">
                    <h4 class="text-lg font-semibold text-slate-700 mb-2 flex items-center gap-2">
                        <i class="ri-article-line text-orange-500"></i> نص السياسة
                    </h4>
                    <p class="text-slate-600">
                        {!! $merchant->additional_data['policies'] ?? 'لا توجد سياسة محددة حالياً.' !!}
                    </p>
                </div>

                <!-- السماح بالاسترجاع -->
                <div class="bg-slate-50 rounded-xl p-4 shadow-sm">
                    <h4 class="text-lg font-semibold text-slate-700 mb-2 flex items-center gap-2">
                        <i class="ri-refresh-line text-orange-500"></i> الاسترجاع التلقائي
                    </h4>
                    <p class="flex items-center gap-2 text-slate-700">
                        @if (!empty($merchant->additional_data['allow_refund']) && $merchant->additional_data['allow_refund'])
                        <i class="ri-checkbox-circle-line text-green-500"></i> مسموح بالاسترجاع التلقائي وفق الشروط.
                        @else
                        <i class="ri-close-circle-line text-red-500"></i> غير مسموح بالاسترجاع التلقائي.
                        @endif
                    </p>
                </div>

                <!-- وسائل الدفع -->
                <div class="bg-slate-50 rounded-xl p-4 shadow-sm">
                    <h4 class="text-lg font-semibold text-slate-700 mb-2 flex items-center gap-2">
                        <i class="ri-bank-card-line text-orange-500"></i> وسائل الدفع المتاحة
                    </h4>
                    @if (!empty($merchant->additional_data['payments']))
                    <ul class="space-y-2 text-slate-600">
                        @foreach ($merchant->additional_data['payments'] as $payment)
                        <li class="flex items-center gap-2">
                            <i class="ri-check-line text-orange-500"></i>
                            @switch($payment)
                            @case('visa-mastercard')
                            بطاقات فيزا وماستركارد
                            @break

                            @case('mada')
                            مدى
                            @break

                            @case('apple-pay')
                            Apple Pay
                            @break

                            @case('stc-pay')
                            STC Pay
                            @break

                            @default
                            {{ $payment }}
                            @endswitch
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-slate-500 flex items-center gap-2">
                        <i class="ri-information-line text-orange-500"></i> لا توجد وسائل دفع محددة.
                    </p>
                    @endif
                </div>

            </div>
        </div>

        <div x-show="tab === 'support'" x-transition class="flex justify-center pt-10">
            <div class="bg-white shadow-lg rounded-2xl p-6 space-y-6 w-full max-w-2xl">

                <!-- زر إضافة تذكرة جديدة -->
                <div class="flex justify-end">
                    <button @click="showTform = true" wire:click="add_ticket"
                        class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                        + إضافة تذكرة جديدة
                    </button>

                </div>

                <!-- عرض التذاكر -->
                @if (!empty($tickets) && count($tickets) > 0)
                <div class="space-y-4">
                    @foreach ($tickets as $ticket)
                    <div class="border rounded-lg p-4 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start gap-4">
                            <!-- الصورة -->
                            <img src="{{ asset('storage/' . ($ticket['attachment'] ?? 'default-image.jpg')) }}"
                                alt="معاينة الصورة" class="w-16 h-16 object-cover rounded-lg shadow">

                            <!-- النص مع زر الحذف -->
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-semibold text-slate-700">
                                        #{{ $ticket['id'] }} - {{ $ticket['subject'] ?? 'بدون عنوان' }}
                                    </h3>

                                    @if ($ticket->additional_data['status'] ?? null == 'pending')
                                    <a href="{{ route('customer.dashboard.chatC') }}">
                                        <button class="text-blue-500 hover:text-blue-700 text-lg">
                                            <i class="ri-chat-3-line"></i>
                                        </button>
                                    </a>
                                    @else
                                    <button wire:click="deleteTicket({{ $ticket['id'] }})"
                                        class="text-red-500 hover:text-red-700 text-lg">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                    @endif

                                </div>
                                <p class="text-slate-600">
                                    {{ $ticket['description'] ?? 'لا يوجد وصف للتذكرة.' }}
                                </p>
                                <p class="text-sm text-slate-500 mt-2">
                                    <i class="ri-time-line"></i>
                                    {{ $ticket['created_at'] ?? 'تاريخ غير متوفر' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>
                @else
                <p class="text-center text-slate-500">لا توجد تذاكر حالياً.</p>
                @endif

            </div>
        </div>



        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


            @foreach ($offers_collection as $offer)
            @php
            $type = $offer['type'] ?? 'services';
            $features = $offer['features'];
            if (is_string($features)) {
            $features = json_decode($features, true);
            }
            $calendar = $features['calendar'][0] ?? null;

            $now = \Carbon\Carbon::now();
            $start = \Carbon\Carbon::parse($features['discount_start'] ?? null);
            $end = \Carbon\Carbon::parse($features['discount_end'] ?? null);
            $discountActive = ($features['enable_discounts'] ?? false)
            && $start && $end
            && $now->between($start, $end);

            $price = (float) $offer['price'];
            $discountPercent = (float) ($features['discount_percent'] ?? 0);
            $discountedPrice = $price - ($price * $discountPercent / 100);
            @endphp


            <div x-show="tab === '{{ $type }}'" x-transition
                class="bg-white shadow-lg hover:shadow-xl ring-1 ring-orange-100 rounded-2xl overflow-hidden transition duration-300">
                <div class="relative">
                    <img src="{{ asset('storage/' . $offer['image']) }}"
                        class="w-full h-40 object-cover rounded-lg shadow" />

                    <a href="{{ route('offer_view', ['template' => 1, 'id' => $offer['id']]) }}" wire:navigate.replace
                        class="absolute top-2 right-2 bg-black bg-opacity-60 text-white p-2 rounded-full hover:bg-opacity-80 transition"
                        title="عرض التفاصيل">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                </div>

                <div class="p-4 space-y-2">
                    <h3 class="text-lg font-bold text-slate-800">{{ $offer['name'] }}</h3>
                    <p class="text-sm text-slate-600">{{ Str::limit($offer['description'], 100) }}</p>

                    <div class="text-sm text-slate-700 mt-2 space-y-1">
                        <p class="flex items-center gap-1">
                            <i class="ri-map-pin-line text-orange-500"></i> {{ $offer['location'] }}
                        </p>
                        <p class="flex items-center gap-1">
                            <i class="ri-cash-line text-orange-500"></i> @if($discountActive)
                            <span class="line-through text-gray-400">{{ $price }} ريال</span>
                            <span class="text-green-600 font-bold">{{ $discountedPrice }} ريال</span>
                            @else
                            <span>{{ $price }} ريال</span>
                            @endif
                    </div>

                    @if ($calendar)
                    <div class="text-sm text-slate-600 mt-2 space-y-1">
                        <p class="flex items-center gap-1">
                            <i class="ri-time-line text-orange-500"></i> {{ $calendar['start_time'] }} -
                            {{ $calendar['end_time'] }}
                        </p>
                        <p class="flex items-center gap-1">
                            <i class="ri-calendar-line text-orange-500"></i> {{ $calendar['start_date'] }} إلى
                            {{ $calendar['end_date'] }}
                        </p>
                    </div>
                    @endif

                    <div class="pt-4">
                        <button
                            @click="showForm = true"
                            wire:click="selectOffer('{{ $offer['id'] }}')"
                            class="inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow transition-all duration-300"
                            :class="{
                                'bg-orange-500 hover:bg-orange-600': {{ can_booking_now($offer['id']) ? 'true' : 'false' }},
                                'bg-gray-400 cursor-not-allowed': {{ !can_booking_now($offer['id']) ? 'true' : 'false' }}
                            }"
                            {{ can_booking_now($offer['id']) ? '' : 'disabled' }}>
                            <i class="ri-calendar-check-line text-lg"></i>
                            حجز الآن
                        </button>



                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if ($newTicket)
    <div x-show="showTform" x-transition
        class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
        @click.self="showTform = false">
        @if (Auth::guard('customer')->user())
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg relative">

            <button wire:click="reset_ticket" @click="showTform = false"
                class="absolute top-3 right-3 text-slate-400 hover:text-orange-500 text-xl">
                <i class="ri-close-line"></i>
            </button>

            @if (!$savedTicket)
            <h2 class="text-xl font-bold mb-4 text-slate-800">طلب تذكرة دعم</h2>

            <div class="space-y-4">
                <input type="text" wire:model.lazy="ticketTitle" placeholder="عنوان التذكرة"
                    class="w-full p-2 border rounded" />
                <input type="file" wire:model="ticketImage" class="w-full p-2 border rounded" />

                <textarea wire:model.lazy="ticketDescription" placeholder="وصف التذكرة" class="w-full p-2 border rounded"
                    rows="4"></textarea>
                <button wire:click="save_ticket"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded">
                    إرسال
                </button>
            </div>
            @else
            <h2 class="text-xl font-bold mb-4 text-slate-800">نجاح</h2>
            <div class="flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="text-center text-slate-700">تمت العملية بنجاح!</p>
            <div class="mt-4 text-center">
                <button @click="showTform = false"
                    class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                    إغلاق
                </button>
            </div>
            @endif

        </div>
        @else
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg text-center">
            <h2 class="text-xl font-bold mb-4 text-slate-800">يرجى تسجيل الدخول</h2>
            <p class="mb-4 text-slate-600">يجب أن تكون مسجلاً للدخول لطلب تذكرة الدعم.</p>
            <a
                x-data
                x-bind:href="'{{ route('customer.login') }}?back=' + encodeURIComponent(window.location.href)"
                class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded transition-all duration-300">
                تسجيل الدخول
            </a>
        </div>
        @endif

    </div>


    @endif

    @if ($selectedOffer)
    <div x-show="showForm" x-transition
        class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
        @click.self="showForm = false">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg relative">
            <button wire:click="resetForm" @click="showForm = false"
                class="absolute top-3 right-3 text-slate-400 hover:text-orange-500 text-xl">
                <i class="ri-close-line"></i>
            </button>
            @if (Auth::guard('customer')->check())

            <h2 class="text-xl font-bold mb-4 text-slate-800">حجز الموعد</h2>

            @if ($step == 0)
            <div class="space-y-4 text-slate-700">
                {{-- صورة العرض --}}
                <div class="w-full h-40 rounded-xl overflow-hidden shadow">
                    <img src="{{ asset('storage/' . $selectedOffer->image) }}"
                        alt="{{ $selectedOffer->title }}" class="w-full h-full object-cover" />
                </div>

                {{-- العنوان والسعر --}}
                <div class="flex justify-between items-center">
                    <a href="{{ route('offer_view', ['template' => 1, 'id' => $selectedOffer->id]) }}"
                        wire:navigate>
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="ri-building-4-line text-orange-500 text-xl"></i>
                            {{ $selectedOffer->name }}
                        </h2>
                    </a>
                    <span
                        class="text-sm bg-orange-100 text-orange-600 font-semibold px-3 py-1 rounded-full shadow-sm">
                        <i class="ri-money-dollar-circle-line"></i>
                        {{ number_format($PiceforView, 2) }} ريال
                    </span>
                </div>

                {{-- الموقع --}}
                <div class="text-sm text-slate-500 flex items-center gap-2">
                    <i class="ri-map-pin-line text-orange-400 text-lg"></i>
                    {{ $selectedOffer->location }}
                </div>

                {{-- الوصف --}}
                <div class="text-sm text-slate-600 leading-relaxed border-t pt-3 max-h-36 overflow-y-auto">
                    {!! nl2br(e($selectedOffer->description)) !!}
                </div>
            </div>
            @endif

            @if ($step == 1)
            <div class="mb-6">
                <label for="branch" class="block text-sm font-medium text-gray-700 mb-2">اختر
                    الفرع</label>

                @if ($selectedOffer->type === 'services' && $branch->isNotEmpty())
                <select wire:model.lazy="selectedBranch" id="branch"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
                    <option value="">-- اختر فرعاً --</option>
                    @foreach ($branch as $branche)
                    <option value="{{ $branche->id }}">{{ $branche->name }}</option>
                    @endforeach
                </select>
                @else
                @php
                $this->dispatch('stepNext');
                @endphp
                <div class="text-red-500 font-semibold">لا يوجد فروع متاحة حالياً.</div>
                @endif
            </div>

            @if ($branchDetails)
            <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold mb-2">بيانات الفرع</h3>
                <p><strong>الاسم:</strong> {{ $branchDetails->name }}</p>
                <p><strong>الموقع:</strong> {{ $branchDetails->location }}</p>
            </div>
            @endif
            @endif



            @if ($step == 2)
            @if ($selectedOffer->type == 'events')
            @php
            $selected = $selectedDate ?? null;
            $selectedT = $selectedTime ?? null;

            $uniqueDates = collect($times['data'] ?? [])
            ->flatMap(function ($item) {
            return [
            [
            \Carbon\Carbon::parse($item['start_date'])->format('Y-m-d'),
            \Carbon\Carbon::parse($item['start_time'])->format('H:i'),
            ],
            //\Carbon\Carbon::parse($item['end_date'])->format('Y-m-d'),
            ];
            })
            ->unique()
            ->sort()
            ->values();
            //dd($uniqueDates,$times['data'] );
            @endphp

            <div class="space-y-3">
                @foreach ($uniqueDates as $date)
                @php
                $isSelected = $date[0] === $selected && $date[1] === $selectedT;
                $dateW = $date[0];
                $time = $date[1];
                @endphp
                <button wire:click="selectDateE('{{ $dateW }}', '{{ $time }}')"
                    class="w-full flex flex-col items-start justify-center px-4 py-3 rounded-lg border transition gap-1
                            {{ $isSelected ? 'bg-orange-500 text-white border-orange-600' : 'bg-white text-slate-700 hover:bg-orange-100 border-slate-200' }}">

                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col text-right">
                            <span class="font-semibold">
                                {{ \Carbon\Carbon::parse($dateW)->translatedFormat('j F Y') }}
                            </span>
                            <span
                                class="text-sm {{ $isSelected ? 'text-orange-100' : 'text-slate-500' }}">
                                {{ \Carbon\Carbon::parse($time)->translatedFormat('H:i') }}
                            </span>
                        </div>
                        <i
                            class="ri-arrow-left-s-line text-xl {{ $isSelected ? 'text-white' : 'text-slate-400' }}"></i>
                    </div>
                </button>
                @endforeach
            </div>
            @elseif ($selectedOffer->type == 'services')
            @php
            $currentDate = isset($calendarDate) ? \Carbon\Carbon::parse($calendarDate) : now();
            $startOfMonth = $currentDate->copy()->startOfMonth();
            $endOfMonth = $currentDate->copy()->endOfMonth();
            $firstDayOfWeek = $startOfMonth->dayOfWeek;
            $daysInMonth = $currentDate->daysInMonth;
            $today = now()->toDateString();
            $maxDate = isset($times['max_reservation_date'])
            ? \Carbon\Carbon::parse($times['max_reservation_date'])
            : null;

            $availableDays = array_filter($times['data'] ?? [], function ($day) {
            return !empty($day['enabled']) && !empty($day['from']) && !empty($day['to']);
            });
            //dd($availableDays);

            $dayToCarbon = [
            'sunday' => 0,
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
            ];
            @endphp

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <button wire:click="previousMonth"
                        class="text-slate-500 hover:text-orange-500 text-xl">
                        <i class="ri-arrow-left-s-line"></i>
                    </button>
                    <h3 class="text-lg font-semibold text-slate-800">
                        <i class="ri-calendar-line text-orange-500 text-xl"></i>
                        {{ $currentDate->format('F Y') }}
                    </h3>
                    <button wire:click="nextMonth"
                        class="text-slate-500 hover:text-orange-500 text-xl">
                        <i class="ri-arrow-right-s-line"></i>
                    </button>
                </div>

                {{-- أسماء الأيام --}}
                <div class="grid grid-cols-7 gap-2 text-center text-slate-500 font-medium text-sm">
                    <div>أحد</div>
                    <div>اثنين</div>
                    <div>ثلاثاء</div>
                    <div>أربعاء</div>
                    <div>خميس</div>
                    <div>جمعة</div>
                    <div>سبت</div>
                </div>

                {{-- تقويم الشهر --}}
                <div class="grid grid-cols-7 gap-2 text-center text-sm">
                    @for ($i = 0; $i < $firstDayOfWeek; $i++)
                        <div>
                </div> {{-- فراغات قبل أول يوم --}}
                @endfor

                @for ($day = 1; $day <= $daysInMonth; $day++)
                    @php
                    $date=$currentDate->copy()->day($day);
                    $dateString = $date->toDateString();
                    $isToday = $dateString === $today;
                    $isSelected = isset($selectedDate) && $dateString === $selectedDate;
                    $dayOfWeek = $date->dayOfWeek; // 0 (الأحد) إلى 6 (السبت)

                    $dayName = array_search($dayOfWeek, $dayToCarbon);
                    $isDayAvailable = isset($availableDays[$dayName]);

                    $withinMaxDate = !$maxDate || $date->lte($maxDate);
                    $inFuture = $date->isSameDay(now()) || $date->isAfter(now());
                    $canReserve = $isDayAvailable && $inFuture && $withinMaxDate;
                    @endphp

                    @if ($canReserve)
                    <button wire:click="selectDate('{{ $dateString }}')"
                        class="py-2 rounded-xl border font-medium transition
                                                {{ $isSelected ? 'bg-orange-500 text-white border-orange-600' : ($isToday ? 'bg-orange-100 border-orange-300 text-slate-700' : 'bg-slate-100 hover:bg-orange-100 border-slate-200 text-slate-700') }}">
                        {{ $day }}
                    </button>
                    @else
                    <div
                        class="py-2 rounded-xl border border-slate-100 text-slate-300 line-through bg-gray-100 cursor-not-allowed">
                        {{ $day }}
                    </div>
                    @endif
                    @endfor
            </div>
        </div>
        @endif

        @endif

        @if ($step == 3)
        @if ($selectedOffer->type == 'events')

        {{-- @php
                            $this->dispatch('stepNext');
                    @endphp --}}
        @elseif ($selectedOffer->type == 'services')
        @php

        $dayName = Carbon\Carbon::parse($selectedDate)->locale('en')->dayName; // e.g. "Saturday"
        $dayName = strtolower($dayName); // Ensure match with array keys
        $minTime = '00:00';
        $maxTime = '23:59';

        if ($selectedOffer->type == 'events') {
        $minTime = $times['data'][0]['start_time'] ?? '00:00';
        $maxTime = $times['data'][0]['end_time'] ?? '23:59';
        } elseif ($selectedOffer->type == 'services' && isset($times['data'][$dayName])) {
        $minTime = $times['data'][$dayName]['from'] ?? '00:00';
        $maxTime = $times['data'][$dayName]['to'] ?? '23:59';
        }
        //dd($minTime,$maxTime);
        @endphp
        @php

        $start = Carbon\Carbon::createFromFormat('H:i', $minTime);
        $end = Carbon\Carbon::createFromFormat('H:i', $maxTime);

        if ($end->lessThan($start)) {
        $end->addDay();
        }

        $intervalMinutes = 1;
        $times = [];
        while ($start->lessThanOrEqualTo($end)) {
        $times[] = $start->format('H:i');
        $start->addMinutes($intervalMinutes);
        }

        // استخراج الساعات والدقائق للسكرول
        $hours = collect($times)->map(fn($t) => (int) explode(':', $t)[0])->unique()->values();
        $minutes = collect($times)
        ->map(fn($t) => (int) explode(':', $t)[1])
        ->unique()
        ->sort()
        ->values();
        @endphp

        <div class="p-6 rounded-2xl  w-full max-w-md mx-auto">
            <h2 class="text-xl font-bold mb-6 text-center text-gray-700">اختيار الوقت</h2>

            <div class="flex gap-4 justify-center">
                <!-- الساعات -->
                <div class="w-1/2 max-h-64 overflow-y-auto border rounded-xl">
                    <h3 class="text-center font-semibold text-gray-600 my-2">الساعة</h3>
                    @foreach ($hours as $h)
                    <div wire:click="$set('selectedHour', {{ $h }})"
                        class="cursor-pointer text-center py-2 mx-2 my-1 rounded-lg transition
                                    {{ isset($selectedHour) && $selectedHour === $h ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-blue-100' }}">
                        {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}:00
                    </div>
                    @endforeach
                </div>

                <!-- الدقائق -->
                <div class="w-1/2 max-h-64 overflow-y-auto border rounded-xl">
                    <h3 class="text-center font-semibold text-gray-600 my-2">الدقيقة</h3>
                    @foreach ($minutes as $m)
                    <div wire:click="$set('selectedMinute', {{ $m }})"
                        class="cursor-pointer text-center py-2 mx-2 my-1 rounded-lg transition
                                    {{ isset($selectedMinute) && $selectedMinute === $m ? 'bg-green-500 text-white' : 'bg-gray-100 hover:bg-green-100' }}">
                        {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- عرض الوقت المختار --}}
            @if (isset($selectedHour, $selectedMinute))
            @php
            $selectedTime =
            str_pad($selectedHour, 2, '0', STR_PAD_LEFT) .
            ':' .
            str_pad($selectedMinute, 2, '0', STR_PAD_LEFT);
            @endphp

            <div class="mt-6 text-center text-lg text-green-700 font-semibold">
                الوقت المختار: {{ $selectedTime }}
            </div>

            {{-- تخزينه في selectedTime --}}
            <input type="hidden" wire:model.lazy="selectedTime">
            @endif
        </div>

        @endif

        @endif


        @if ($step == 4)
        <div class="space-y-6">

            <div class="flex justify-between items-center">
                <div class="text-lg font-semibold">
                    السعر: {{ $PiceforView }} ريال
                </div>
                <div class="text-sm text-gray-600">
                    الكمية المتوفرة: {{ $stock }}
                </div>
            </div>

            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <button wire:click="decreaseQuantity"
                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                    -
                </button>
                {{-- <input type="number" wire:model.lazy="quantity"
                            class="w-16 text-center border rounded p-1" min="0" max="{{ $stock }}"> --}}
                <span class="w-16 text-center border rounded p-1"> {{ $quantity }} </span>
                <button wire:click="increaseQuantity"
                    class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                    +
                </button>
            </div>

            {{-- الكوبون --}}
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <input type="text" wire:model.lazy="couponCode" placeholder="أدخل كود الخصم"
                    class="flex-1 p-2 border rounded">
                <button wire:click="applyCoupon"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    تحقق
                </button>
            </div>

            {{-- السعر النهائي --}}
            <div class="text-xl font-bold text-right">
                السعر النهائي: {{ $finalPrice }} ريال
            </div>

        </div>
        @endif

        @if ($step == 5)
        @foreach ($Qa as $index => $Q)
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">
                {{ $Q['question'] }}
            </label>
            <input type="text" wire:model.defer="Qa.{{ $index }}.answer"
                class="w-full border px-3 py-2 rounded shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                placeholder="اكتب إجابتك هنا">
        </div>
        @endforeach
        @endif

        @if ($step == 6)
        @if ($this->is_ready())
        <div class="space-y-6 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">مراجعة الحجز</h2>

            {{-- بيانات الفرع --}}
            <div>
                <h3 class="font-semibold text-gray-700">الفرع:</h3>
                <p>{{ $branchDetails->name ?? 'غير محدد' }}</p>
                <p class="text-sm text-gray-500">{{ $branchDetails->location ?? '' }}</p>
            </div>

            {{-- التاريخ والوقت --}}
            <div>
                <h3 class="font-semibold text-gray-700">التاريخ والوقت:</h3>
                <p>{{ $selectedDate }}</p>
                <p>{{ $selectedTime }}</p>
            </div>

            {{-- السعر والكمية --}}
            <div>
                <h3 class="font-semibold text-gray-700">السعر:</h3>
                <p>{{ $PiceforView }} ريال x {{ $quantity }} =
                    <strong>{{ $PiceforView * $quantity }} ريال</strong>
                </p>
            </div>

            {{-- الكوبون --}}
            @if ($coupon)
            <div>
                <h3 class="font-semibold text-gray-700">الكوبون:</h3>
                <p>تم تطبيق الكوبون <strong>{{ $couponCode }}</strong>، الخصم:
                    {{ $discount }} ريال
                </p>
            </div>
            @endif

            {{-- السعر النهائي --}}
            <div class="text-lg font-bold text-green-600">
                السعر النهائي: {{ $finalPrice }} ريال
            </div>

            {{-- زر التأكيد --}}


        </div>
        @else
        <div class="text-center text-red-600 font-semibold py-10">
            لا يمكن عرض المعاينة حالياً، يرجى التأكد من إدخال جميع البيانات بشكل صحيح.
        </div>
        @endif
        @endif


        @if ($step == 7)
        <div
            class="flex flex-col items-center justify-center bg-white shadow-md rounded-lg p-10 space-y-6 text-center">
            {{-- الأيقونة --}}
            <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-green-600"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>

            {{-- الرسالة --}}
            <h2 class="text-2xl font-bold text-green-700">تمت الإضافة بنجاح</h2>
            <p class="text-gray-600">تمت إضافة العرض إلى السلة بنجاح. يمكنك متابعة التسوق أو الانتقال
                إلى السلة لإتمام الحجز.</p>

            {{-- زر الانتقال --}}
            <div class="space-x-4">
                <a href=""
                    class="inline-block bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                    عروض أخرى
                </a>
                <a href="{{ route('customer.dashboard.tickets.index') }}" wire:navigate
                    class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    الذهاب إلى السلة
                </a>
            </div>
        </div>
        @endif
        @if ($step < 7)
            <div class="mt-6">
            <div class="flex justify-between gap-4">
                @if ($step > 0)
                <button wire:click="stepBack"
                    class="w-full bg-gray-200 hover:bg-gray-300 text-slate-700 font-semibold py-2 rounded-xl transition">
                    رجوع <i class="ri-arrow-right-line"></i>
                </button>
                @endif

                @if ($step != 6)
                <button wire:click="stepNext" @if (!$enableNext && $step !=0) disabled @endif
                    class="w-full @if (!$enableNext && $step != 0) bg-gray-400 @else bg-orange-500 hover:bg-orange-600 @endif text-white font-semibold py-2 rounded-xl transition">
                    <i class="ri-arrow-left-line"></i> التالي
                </button>
                @else
                <button wire:click="stepNext"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-xl transition">
                    الحجز <i class="ri-check-double-line"></i>
                </button>
                @endif
            </div>



    </div>



    @endif
</div>
@else
@if ($LoginStep == 0)
<div class="w-full mt-4 space-y-3">
    <!-- تسجيل الدخول -->

    <a
        x-data
        x-bind:href="'{{ route('customer.login') }}?back=' + encodeURIComponent(window.location.href)"> <button
            class="w-full flex items-center px-4 py-3 rounded-lg border transition bg-white text-slate-700 hover:bg-orange-100 border-slate-200 gap-3">
            <i class="fas fa-sign-in-alt text-orange-500 text-lg"></i>
            <span class="font-semibold">تسجيل الدخول</span>
        </button>
    </a>

    <!-- تسجيل جديد -->
    <a href="{{ route('customer.register') }}" wire:navigate>
        <button
            class="w-full flex items-center px-4 py-3 rounded-lg border transition bg-white text-slate-700 hover:bg-orange-100 border-slate-200 gap-3">
            <i class="fas fa-user-plus text-green-500 text-lg"></i>
            <span class="font-semibold">تسجيل جديد</span>
        </button>
    </a>

    <button wire:click="NextStepLogin"
        class="w-full flex items-center px-4 py-3 rounded-lg border transition bg-white text-slate-700 hover:bg-orange-100 border-slate-200 gap-3">
        <i class="fas fa-user-secret text-gray-500 text-lg"></i>
        <span class="font-semibold">إكمال كزائر</span>
    </button>
</div>
@endif
@if ($LoginStep == 1)
<div class="space-y-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">ادخال اسم المستخدم</h2>

    {{-- الاسم --}}
    <div>
        <label for="name" class="block text-sm font-medium mb-1">الاسم الاول</label>
        <input type="text" id="name" wire:model.lazy="f_name"
            class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:ring-orange-500 focus:border-orange-500 placeholder:text-gray-400">
    </div>
    @if (isset($errors['f_name']))
    <span class="text-red-500">{{ $errors['f_name'][0] }}</span>
    @endif

    <div>
        <label for="name" class="block text-sm font-medium mb-1">الاسم الثاني</label>
        <input type="text" id="name" wire:model.lazy="l_name"
            class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:ring-orange-500 focus:border-orange-500 placeholder:text-gray-400">
    </div>
    @if (isset($errors['l_name']))
    <span class="text-red-500">{{ $errors['l_name'][0] }}</span>
    @endif

</div>
@endif
@if ($LoginStep == 2)
<div class="space-y-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">البريد الاكتروني والرقم</h2>

    {{-- البريد الإلكتروني --}}
    <div>
        <label for="email" class="block text-sm font-medium mb-1">البريد الإلكتروني</label>
        <input type="email" id="email" wire:model.lazy="email"
            class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:ring-orange-500 focus:border-orange-500 placeholder:text-gray-400">
    </div>
    @if (isset($errors['email']))
    <span class="text-red-500">{{ $errors['email'][0] }}</span>
    @endif

    {{-- رقم الجوال --}}
    <div>
        <label for="phone" class="block text-sm font-medium mb-1">رقم الجوال</label>
        <input type="text" id="phone" wire:model.lazy="phone"
            class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:ring-orange-500 focus:border-orange-500 placeholder:text-gray-400">
    </div>
    @if (isset($errors['phone']))
    <span class="text-red-500">{{ $errors['phone'][0] }}</span>
    @endif



</div>
@endif

@if ($LoginStep == 3)
<div class="space-y-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">كلمة المرور</h2>

    <div>
        <label for="password" class="block text-sm font-medium mb-1">كلمة المرور</label>
        <input type="password" id="password" wire:model.lazy="password"
            class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:ring-orange-500 focus:border-orange-500 placeholder:text-gray-400">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium mb-1">التحقق من كلمة المرور</label>
        <input type="password" id="password" wire:model.lazy="password_confirmation"
            class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:ring-orange-500 focus:border-orange-500 placeholder:text-gray-400">
    </div>
    @if (isset($errors['password']))
    <span class="text-red-500">{{ $errors['password'][0] }}</span>
    @endif
</div>
@endif

@if ($LoginStep < 4)
    <div class="mt-6">
    <div class="flex justify-between gap-4">
        @if ($LoginStep > 0)
        <button wire:click="BackStepLogin"
            class="w-full bg-gray-200 hover:bg-gray-300 text-slate-700 font-semibold py-2 rounded-xl transition">
            رجوع <i class="ri-arrow-right-line"></i>
        </button>
        @endif

        @if ($LoginStep > 0)
        <button wire:click="NextStepLogin" @if (!$EnableLogin && $LoginStep !=0) disabled @endif
            class="w-full @if (!$EnableLogin && $LoginStep != 0) bg-gray-400 @else bg-orange-500 hover:bg-orange-600 @endif text-white font-semibold py-2 rounded-xl transition">
            <i class="ri-arrow-left-line"></i> التالي
        </button>
        @endif
    </div>
    </div>
    @endif





    @endif
    </div>
    @endif



    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts()
    <script>
        // Livewire.on('login-error', (data) => {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'خطأ',
        //         text: data.message,
        //         confirmButtonText: 'تسجيل دخول',
        //         customClass: {
        //             confirmButton: 'bg-orange-500 hover:bg-orange-600 text-white font-semibold shadow-md transition duration-300',
        //         }
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             window.location.href = "{{ route('customer.login', ['redirect' => request()->fullUrl()]) }}";
        //         }
        //     });
        // });
    </script>

    <script>
        // document.addEventListener('DOMContentLoaded', () => {
        //     document.querySelectorAll('#merchant-social-links a').forEach(anchor => {
        //         const url = anchor.dataset.url?.toLowerCase() || '';
        //         let iconClass = 'ri-global-line';

        //         if (url.includes('facebook.com'))        iconClass = 'ri-facebook-fill';
        //         else if (url.includes('twitter.com'))    iconClass = 'ri-twitter-x-fill';
        //         else if (url.includes('instagram.com'))  iconClass = 'ri-instagram-line';
        //         else if (url.includes('tiktok.com'))     iconClass = 'ri-tiktok-fill';
        //         else if (url.includes('youtube.com'))    iconClass = 'ri-youtube-fill';
        //         else if (url.includes('pinterest.com'))  iconClass = 'ri-pinterest-fill';
        //         else if (url.includes('linkedin.com'))   iconClass = 'ri-linkedin-fill';
        //         else if (url.includes('snapchat.com'))   iconClass = 'ri-snapchat-fill';
        //         else if (url.includes('whatsapp.com'))   iconClass = 'ri-whatsapp-fill';
        //         else if (url.includes('telegram.me') || url.includes('t.me')) iconClass = 'ri-telegram-fill';
        //         else if (url.includes('github.com'))     iconClass = 'ri-github-fill';
        //         else if (url.includes('reddit.com'))     iconClass = 'ri-reddit-fill';
        //         else if (url.includes('medium.com'))     iconClass = 'ri-medium-fill';
        //         else if (url.includes('dribbble.com'))   iconClass = 'ri-dribbble-fill';
        //         else if (url.includes('behance.net'))    iconClass = 'ri-behance-fill';
        //         else if (url.includes('flickr.com'))     iconClass = 'ri-flickr-fill';
        //         else if (url.includes('tumblr.com'))     iconClass = 'ri-tumblr-fill';
        //         else if (url.includes('vimeo.com'))      iconClass = 'ri-vimeo-fill';
        //         else if (url.includes('itch.io'))        iconClass = 'fa-brands fa-itch-io'; // FontAwesome
        //         else if (url.includes('discord.gg') || url.includes('discord.com')) iconClass = 'ri-discord-fill';

        //         const icon = anchor.querySelector('i');
        //         icon.className = iconClass;
        //     });
        // });
    </script>