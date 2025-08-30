<form wire:submit.prevent="save">
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">الوصف المختصر <span class="text-red-500" style="font-weight: bold;">*</span></label>
                <input type="text" wire:model.lazy="name" class="w-full border rounded-md p-2">
            </div>

            @if ($type != 'restaurant')

            <div>
                <label class="block text-sm font-medium mb-1">الموقع <span class="text-red-500" style="font-weight: bold;">*</span></label>
                <input type="text" wire:model.lazy="location" class="w-full border rounded-md p-2">
            </div>
            @endif


            {{-- <div>
                <label class="block text-sm font-medium mb-1">السعر</label>
                <input type="number" wire:model.lazy="price" step="0.01" class="w-full border rounded-md p-2">
            </div> --}}
@if ($type != 'restaurant')



            <div>
                <label class="block text-sm font-medium mb-1">النوع <span class="text-red-500" style="font-weight: bold;">*</span></label>
                <select wire:model.lazy="type" class="w-full border rounded-md p-2">
                    {{-- <option value="restaurant">مطعم</option> --}}
                    <option value="events">فعالية</option>
                    <option value="services">خدمة</option>
                    {{-- <option value="conference">مؤتمر</option> --}}
                    {{-- <option value="experiences">تجربة</option> --}}
                </select>
            </div>
@endif

@if ($type == 'restaurant')



            <div>
                <label class="block text-sm font-medium mb-1">النوع</label>
                <select wire:model.lazy="services_type" class="w-full border rounded-md p-2">
                    {{-- <option value="restaurant">مطعم</option> --}}
                    <option value="services">خدمة</option>
                    {{-- <option value="conference">مؤتمر</option> --}}
                    {{-- <option value="experiences">تجربة</option> --}}
                </select>
            </div>
@endif
@if ($type == 'events')

<div class="space-y-4">
    <!-- اختيار نوع الفعالية -->
    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
        <i class="ri-calendar-event-line text-indigo-500 text-lg"></i>
        نوع الفعالية
    </label>
    <div class="relative">
        <i class="ri-list-check text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
        <select wire:model.lazy="category" id="event_category"
            class="w-full border border-gray-300 rounded-xl p-3 pr-10 bg-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
            <option value="">-- اختر نوع الفعالية --</option>
            <option value="conference">مؤتمر</option>
            <option value="exhibition">معرض</option>
            <option value="children_event">فعالية أطفال</option>
            <option value="online">فعالية أونلاين</option>
            <option value="workshop">ورشة / دورة تدريبية</option>
            <option value="social_party">فعالية اجتماعية / حفلة</option>
            <option value="sports_fitness">رياضة / لياقة</option>
        </select>
    </div>

    <!-- اختيار الفعالية الفعلية -->
    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
        <i class="ri-settings-3-line text-indigo-500 text-lg"></i>
        الفعالية الفعلية
    </label>
    <div class="relative">
        <i class="ri-checkbox-circle-line text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
        <select wire:model.lazy="services_type" id="event_name"
            class="w-full border border-gray-300 rounded-xl p-3 pr-10 bg-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
            <option value="">اختر الفعالية الفعلية</option>
    
            {{-- المؤتمرات --}}
            @if($category == 'conference')
                <option value="tech_conference">مؤتمر تقني</option>
                <option value="business_conference">مؤتمر أعمال</option>
                <option value="medical_conference">مؤتمر طبي</option>
                <option value="educational_conference">مؤتمر تعليمي</option>
                <option value="cultural_conference">مؤتمر ثقافي</option>
                <option value="scientific_conference">مؤتمر علمي</option>
                <option value="press_conference">مؤتمر صحفي</option>
            @endif
    
            {{-- المعارض --}}
            @if($category == 'exhibition')
                <option value="art_exhibition">معرض فني</option>
                <option value="tech_exhibition">معرض تقني</option>
                <option value="trade_exhibition">معرض تجاري</option>
                <option value="fashion_exhibition">معرض أزياء</option>
                <option value="car_exhibition">معرض سيارات</option>
                <option value="book_fair">معرض كتاب</option>
                <option value="food_exhibition">معرض طعام</option>
            @endif
    
            {{-- فعاليات الأطفال --}}
            @if($category == 'children_event')
                <option value="kids_show">عرض للأطفال</option>
                <option value="kids_workshop">ورشة للأطفال</option>
                <option value="kids_party">حفلة أطفال</option>
                <option value="kids_festival">مهرجان أطفال</option>
                <option value="storytelling_event">حفل قصص للأطفال</option>
                <option value="kids_theater">مسرح أطفال</option>
            @endif
    
            {{-- الفعاليات الأونلاين --}}
            @if($category == 'online')
                <option value="webinar">ويبينار</option>
                <option value="online_training">تدريب أونلاين</option>
                <option value="virtual_meeting">اجتماع افتراضي</option>
                <option value="online_conference">مؤتمر أونلاين</option>
                <option value="online_workshop">ورشة عمل أونلاين</option>
                <option value="online_show">عرض مباشر</option>
            @endif
    
            {{-- الورشات والدورات --}}
            @if($category == 'workshop')
                <option value="technical_workshop">ورشة تقنية</option>
                <option value="art_workshop">ورشة فنية</option>
                <option value="business_training">تدريب أعمال</option>
                <option value="language_course">دورة لغة</option>
                <option value="photography_workshop">ورشة تصوير</option>
                <option value="culinary_workshop">ورشة طبخ</option>
            @endif
    
            {{-- الفعاليات الاجتماعية والحفلات --}}
            @if($category == 'social_party')
                <option value="wedding">حفل زفاف</option>
                <option value="birthday">عيد ميلاد</option>
                <option value="community_event">فعالية مجتمعية</option>
                <option value="graduation_party">حفل تخرج</option>
                <option value="charity_event">فعالية خيرية</option>
                <option value="family_gathering">لقاء عائلي</option>
            @endif
    
            {{-- الرياضة واللياقة --}}
            @if($category == 'sports_fitness')
                <option value="marathon">ماراثون</option>
                <option value="fitness_class">حصة لياقة</option>
                <option value="tournament">بطولة</option>
                <option value="football_match">مباراة كرة قدم</option>
                <option value="basketball_match">مباراة كرة سلة</option>
                <option value="yoga_session">جلسة يوغا</option>
                <option value="cycling_event">سباق دراجات</option>
            @endif
        </select>
    </div>
    
</div>

@endif

@if ($type == 'services')

    <div >
        <label class="block text-sm font-medium mb-1">المركزية</label>
        <select wire:model.lazy="center" class="w-full border rounded-md p-2">
            <option value="">هل الخدمة مركزية</option>
            <option value="place">مركزية</option>
            <option value="mobile">متنقلة</option>

        </select>
        
    </div>

<div class="space-y-4">
    <!-- اختيار الفئة -->
    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
        <i class="ri-folder-2-line text-indigo-500 text-lg"></i>
        الفئة
    </label>
    <div class="relative">
        <i class="ri-list-check text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
        <select wire:model.lazy="category" id="category"
            class="w-full border border-gray-300 rounded-xl p-3 pr-10 bg-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
            <option value="">اختر نوع الخدمة (القروب)</option>
            <option value="digital">خدمات رقمية</option>
            <option value="consulting">خدمات استشارية</option>
            <option value="restaurant">مطاعم</option>
            <option value="educational">خدمات تعليمية وتدريبية</option>
            <option value="technical">خدمات تقنية ودعم فني</option>
            <option value="personal">خدمات شخصية</option>
            <option value="central">خدمات مركزية وترفيهية</option>
            <option value="business">خدمات تجارية ولوجستية</option>
            <option value="medical">خدمات طبية وصحية</option>
            <option value="real_estate">خدمات عقارية</option>
            <option value="tourism">خدمات سياحية وسفر</option>
            <option value="financial">خدمات مالية</option>
            <option value="maintenance">خدمات صيانة وإصلاح</option>
            <option value="other">أخرى</option>
        </select>
    </div>

    <!-- اختيار الخدمة -->
    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
        <i class="ri-tools-line text-indigo-500 text-lg"></i>
        الخدمة الفعلية
    </label>
    <div class="relative">
        <i class="ri-settings-3-line text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
        <select wire:model.lazy="services_type" id="service_name"
            class="w-full border border-gray-300 rounded-xl p-3 pr-10 bg-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
            <option value="">اختر الخدمة الفعلية</option>

            @if($category == 'digital')
                <option value="graphic_design">تصميم جرافيك</option>
                <option value="web_development">تطوير وبرمجة المواقع</option>
                <option value="app_development">برمجة التطبيقات</option>
                <option value="video_editing">مونتاج وتحرير فيديو</option>
                <option value="content_writing">كتابة المحتوى</option>
                <option value="translation">ترجمة</option>
                <option value="seo">تحسين محركات البحث</option>
                <option value="digital_marketing">التسويق الإلكتروني</option>
            @endif

            @if($category == 'consulting')
                <option value="financial_consulting">استشارات مالية</option>
                <option value="legal_consulting">استشارات قانونية</option>
                <option value="marketing_consulting">استشارات تسويق</option>
                <option value="tech_consulting">استشارات تقنية</option>
                <option value="engineering_consulting">استشارات هندسية</option>
            @endif

            @if($category == 'educational')
                <option value="online_courses">دورات أونلاين</option>
                <option value="workshops">ورش عمل</option>
                <option value="coaching">تدريب فردي</option>
                <option value="educational_content">محتوى تعليمي</option>
            @endif

            @if($category == 'technical')
                <option value="tech_support">دعم فني</option>
                <option value="device_maintenance">صيانة الأجهزة</option>
                <option value="hosting">استضافة وإدارة المواقع</option>
                <option value="server_management">إدارة السيرفرات</option>
            @endif

            @if($category == 'personal')
                <option value="photography">تصوير فوتوغرافي</option>
                <option value="videography">تصوير فيديو</option>
                <option value="interior_design">تصميم داخلي</option>
                <option value="event_planning">تنظيم فعاليات</option>
                <option value="fitness_training">تدريب رياضي</option>
            @endif

            @if($category == 'central')
                <option value="restaurants">مطاعم</option>
                <option value="cafes">مقاهي</option>
                <option value="theaters">مسارح</option>
                <option value="cinemas">صالات سينما</option>
                <option value="party_halls">قاعات حفلات</option>
                <option value="conference_halls">صالات مؤتمرات</option>
                <option value="arcades">صالات ألعاب</option>
                <option value="equipment_rental">تأجير معدات</option>
                <option value="car_rental">تأجير سيارات</option>
                <option value="bike_rental">تأجير دراجات</option>
                <option value="clothing_rental">تأجير ملابس</option>
            @endif

            @if($category == 'business')
                <option value="shipping">شحن وتوصيل</option>
                <option value="inventory_management">إدارة المخزون</option>
                <option value="packaging">التعبئة والتغليف</option>
                <option value="warehousing">التخزين</option>
            @endif

            @if($category == 'medical')
                <option value="online_medical_consulting">استشارات طبية أونلاين</option>
                <option value="lab_tests">تحليل الفحوصات</option>
                <option value="physiotherapy">علاج طبيعي</option>
            @endif

            @if($category == 'real_estate')
                <option value="property_sales">بيع عقارات</option>
                <option value="property_rental">تأجير عقارات</option>
                <option value="property_management">إدارة أملاك</option>
                <option value="property_valuation">تقييم العقارات</option>
            @endif

            @if($category == 'tourism')
                <option value="ticket_booking">حجز تذاكر</option>
                <option value="trip_planning">تنظيم رحلات</option>
                <option value="hotel_booking">حجز فنادق</option>
            @endif

            @if($category == 'financial')
                <option value="money_transfer">تحويل الأموال</option>
                <option value="loans">القروض</option>
                <option value="investment">الاستثمار</option>
                <option value="portfolio_management">إدارة المحافظ المالية</option>
            @endif

            @if($category == 'maintenance')
                <option value="car_repair">صيانة سيارات</option>
                <option value="bike_repair">إصلاح الدراجات</option>
                <option value="ac_maintenance">صيانة المكيفات</option>
                <option value="computer_repair">صيانة الحواسيب</option>
                <option value="phone_repair">صيانة الهواتف</option>
                <option value="plumbing">إصلاح السباكة</option>
                <option value="electrical">أعمال كهرباء</option>
                <option value="furniture_repair">إصلاح الأثاث</option>
                <option value="home_appliance_repair">صيانة الأجهزة المنزلية</option>
                <option value="elevator_maintenance">صيانة المصاعد</option>
                <option value="door_window_repair">صيانة الأبواب والنوافذ</option>
                <option value="agriculture_tools_repair">إصلاح الأدوات الزراعية</option>
            @endif

            @if($category == 'other')
                <option value="other">أخرى</option>
            @endif
        </select>
    </div>
</div>

@endif

            <div>
                <label class="block text-sm font-medium mb-1">الوصف <span class="text-red-500" style="font-weight: bold;">*</span></label>
                <textarea wire:model.lazy="description" rows="3" class="w-full border rounded-md p-2"></textarea>
            </div>

{{--
            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model.lazy="has_chairs" class="form-checkbox">
                    <span>تحتوي على مقاعد</span>
                </label>
            </div>

            @if ($offering->has_chairs)
                <div>
                    <label class="block text-sm font-medium mb-1">عدد المقاعد</label>
                    <input type="number" wire:model.lazy="chairs_count" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div> --}}
    </div>
</form>
