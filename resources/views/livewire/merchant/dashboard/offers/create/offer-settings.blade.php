<div>
    <p class="text-red-600">لايتم اضهار الصور حتى يتم الحفض</p>




@if ($type == "events")
<div>

    
    @if ($category === 'conference')
    <div class="mb-6" dir="rtl">
        <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
    
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">المتحدث</th>
                    <th class="border px-3 py-2">التاريخ</th>
                    <th class="border px-3 py-2">الوقت</th>
                    <th class="border px-3 py-2">المكان</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sessions as $index => $session)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                        <td class="border px-2 py-1">{{ $session['date'] }}</td>
                        <td class="border px-2 py-1">{{ $session['time'] }}</td>
                        <td class="border px-2 py-1">{{ $session['location'] }}</td>
                        <td class="border px-2 py-1">{{ $session['description'] }}</td>
                        <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                            <button wire:click="$set('editingIndex', {{ $index }})" class="text-blue-600 hover:text-blue-800" title="تعديل">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف جلسة
            </button>
    
            <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الجلسات
            </button>
        </div>
    
        {{-- مودال التعديل --}}
        @if($editingIndex !== null)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 mx-4 relative">
                    <h3 class="text-lg font-semibold mb-4">تعديل الجلسة</h3>
    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">المتحدث</label>
                            <input type="text" wire:model.lazy="sessions.{{ $editingIndex }}.speaker" class="w-full p-2 border rounded" />
                        </div>
    
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 font-medium">التاريخ</label>
                                <input type="date" wire:model.lazy="sessions.{{ $editingIndex }}.date" class="w-full p-2 border rounded" />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">الوقت</label>
                                <input type="time" wire:model.lazy="sessions.{{ $editingIndex }}.time" class="w-full p-2 border rounded" />
                            </div>
                        </div>
    
                        <div>
                            <label class="block mb-1 font-medium">المكان</label>
                            <input type="text" wire:model.lazy="sessions.{{ $editingIndex }}.location" class="w-full p-2 border rounded" />
                        </div>
    
                        <div>
                            <label class="block mb-1 font-medium">الوصف</label>
                            <textarea wire:model.lazy="sessions.{{ $editingIndex }}.description" rows="3" class="w-full p-2 border rounded resize-none"></textarea>
                        </div>
                    </div>
    
                    <div class="mt-6 flex justify-end gap-3">
                        <button wire:click="$set('editingIndex', null)" class="px-4 py-2 border rounded hover:bg-gray-100">إلغاء</button>
                        <button wire:click="saveRow({{ $editingIndex }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ التعديل</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>
    
    @endif
    
    @if ($category === 'exhibition')
        <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">المنتجات</label>
    
        {{-- الشريط الأفقي --}}
        <div class="flex overflow-x-auto gap-4 pb-2">
            @foreach ($products as $index => $product)
                <div class="flex-shrink-0 w-64 border rounded-lg shadow-sm bg-white">
                    @if ($productsEditingIndex === $index)
                        {{-- حالة التعديل --}}
                        <div class="p-3 flex flex-col gap-2">
                            <input type="text" wire:model.lazy="products.{{ $index }}.name" placeholder="اسم المنتج" class="p-2 border rounded text-sm">
                            <input type="file" wire:model.lazy="products.{{ $index }}.image" class="p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="products.{{ $index }}.price" placeholder="السعر" class="p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="products.{{ $index }}.category" placeholder="التصنيف" class="p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="products.{{ $index }}.booth" placeholder="رقم الجناح" class="p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="products.{{ $index }}.link" placeholder="رابط المنتج" class="p-2 border rounded text-sm">
                            <textarea wire:model.lazy="products.{{ $index }}.description" placeholder="الوصف" class="p-2 border rounded text-sm"></textarea>
                            
                            <div class="flex justify-between mt-2">
                                <button wire:click="saveProduct({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeProduct({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- حالة العرض --}}
                        <img src="{{ is_string($product['image']) ? asset('storage/'.$product['image']) : 'https://via.placeholder.com/300x200' }}" class="w-full h-40 object-cover rounded-t-lg">
                        <div class="p-3">
                            <h3 class="font-bold text-sm">{{ $product['name'] }}</h3>
                            <p class="text-xs text-gray-600 mb-1">{{ $product['category'] }} - جناح {{ $product['booth'] }}</p>
                            <p class="text-green-600 font-semibold">{{ $product['price'] }} ر.س</p>
                            <p class="text-xs text-gray-700 line-clamp-3">{{ $product['description'] }}</p>
                            
                            <div class="flex justify-between mt-2">
                                <button wire:click="editProduct({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeProduct({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        {{-- أزرار إضافة وحفظ --}}
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addProduct" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف منتج
            </button>
    
            <button type="button" wire:click="saveProducts" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل المنتجات
            </button>
        </div>
        </div>
    
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>
    
    @endif
    @if ($category === 'children_event')
        <div class="mb-6 font-sans">
            <label class="block text-2xl font-extrabold mb-6 text-pink-600">🎲 الألعاب</label>
        
            <div class="flex space-x-6 overflow-x-auto pb-4">
                @foreach ($games as $index => $game)
                    <div class="flex-shrink-0 w-72 bg-gradient-to-br from-pink-100 via-pink-200 to-pink-300 rounded-xl shadow-lg p-5 relative text-gray-800">
                        @if ($gamesEditingIndex === $index)
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.name" 
                                placeholder="اسم اللعبة" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 font-semibold text-lg text-pink-700"
                            />
                            <textarea 
                                wire:model.lazy="games.{{ $index }}.description" 
                                placeholder="وصف اللعبة" 
                                rows="3"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm resize-none"
                            ></textarea>
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.age_range" 
                                placeholder="الفئة العمرية" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm"
                            />
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.location" 
                                placeholder="المكان" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm"
                            />
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.supervisor" 
                                placeholder="المشرف" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm"
                            />
                            <textarea 
                                wire:model.lazy="games.{{ $index }}.rules" 
                                placeholder="قوانين اللعبة" 
                                rows="2"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm resize-none"
                            ></textarea>
        
                            <label class="block mb-2 font-semibold text-pink-600">صورة اللعبة</label>
                            <input 
                                type="file" 
                                wire:model="games.{{ $index }}.image" 
                                accept="image/*"
                                class="mb-3 w-full text-sm text-pink-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 cursor-pointer"
                            />
        
                            <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                                <button 
                                    wire:click="saveGame({{ $index }})" 
                                    class="text-pink-600 hover:text-pink-800 transition text-xl" 
                                    title="حفظ"
                                >
                                    <i class="ri-save-line"></i>
                                </button>
                                <button 
                                    wire:click="removeGame({{ $index }})" 
                                    class="text-red-600 hover:text-red-800 transition text-xl" 
                                    title="حذف"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
        
                        @else
                            <div class="h-40 rounded-lg overflow-hidden mb-4 bg-pink-50 flex items-center justify-center">
                                @if (!empty($game['image']) && !is_object($game['image']))
                                    <img src="{{ asset('storage/' . $game['image']) }}" alt="صورة اللعبة" class="object-cover w-full h-full" />
                                @elseif(is_object($game['image']))
                                    <img src="{{ $game['image']->temporaryUrl() }}" alt="صورة مؤقتة" class="object-cover w-full h-full" />
                                @else
                                    <i class="ri-gamepad-line text-6xl text-pink-400"></i>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-pink-700 mb-1 truncate">{{ $game['name'] ?: 'بدون اسم' }}</h3>
                            <p class="text-sm text-pink-600 mb-1">الفئة العمرية: <span class="font-semibold">{{ $game['age_range'] ?: 'غير محددة' }}</span></p>
                            <p class="text-sm text-gray-700 mb-2 h-12 overflow-hidden">{{ $game['description'] ?: 'لا يوجد وصف' }}</p>
                            <p class="text-xs text-gray-500 mb-1">المكان: {{ $game['location'] ?: 'غير محدد' }}</p>
                            <p class="text-xs text-gray-500 mb-3">المشرف: {{ $game['supervisor'] ?: 'غير محدد' }}</p>
        
                            <div class="flex justify-between items-center">
                                <button 
                                    wire:click="editGame({{ $index }})" 
                                    class="text-pink-600 hover:text-pink-800 transition text-xl" 
                                    title="تعديل"
                                >
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button 
                                    wire:click="removeGame({{ $index }})" 
                                    class="text-red-600 hover:text-red-800 transition text-xl" 
                                    title="حذف"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex justify-between items-center mt-6">
                <button 
                    type="button" 
                    wire:click="addGame" 
                    class="px-5 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-lg font-semibold transition"
                >
                    + أضف لعبة جديدة
                </button>
        
                <button 
                    type="button" 
                    wire:click="saveGames" 
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition"
                >
                    حفظ كل الألعاب
                </button>
            </div>
        </div>
    
    
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>

        <div class="mb-6 font-sans">
            <label class="block text-2xl font-extrabold mb-6 text-indigo-600">🦸‍♂️ الشخصيات الكرتونية</label>
        
            <div class="flex space-x-6 overflow-x-auto pb-4">
                @foreach ($cartoons as $index => $cartoon)
                    <div class="flex-shrink-0 w-72 bg-gradient-to-br from-indigo-100 via-indigo-200 to-indigo-300 rounded-xl shadow-lg p-5 relative text-gray-800">
                        @if ($cartoonEditingIndex === $index)
                            <input 
                                type="text" 
                                wire:model.lazy="cartoons.{{ $index }}.name" 
                                placeholder="اسم الشخصية" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 font-semibold text-lg text-indigo-700"
                            />
                            <textarea 
                                wire:model.lazy="cartoons.{{ $index }}.description" 
                                placeholder="وصف الشخصية" 
                                rows="3"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm resize-none"
                            ></textarea>
        
                            <label class="block mb-2 font-semibold text-indigo-600">صورة الشخصية</label>
                            <input 
                                type="file" 
                                wire:model="cartoons.{{ $index }}.image" 
                                accept="image/*"
                                class="mb-3 w-full text-sm text-indigo-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer"
                            />
        
                            <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                                <button wire:click="saveCartoon({{ $index }})" class="text-indigo-600 hover:text-indigo-800 transition text-xl" title="حفظ">
                                    <i class="ri-save-line"></i>
                                </button>
                                <button wire:click="removeCartoon({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @else
                            <div class="h-40 rounded-lg overflow-hidden mb-4 bg-indigo-50 flex items-center justify-center">
                                @if (!empty($cartoon['image']) && !is_object($cartoon['image']))
                                    <img src="{{ asset('storage/' . $cartoon['image']) }}" alt="صورة الشخصية" class="object-cover w-full h-full" />
                                @elseif(is_object($cartoon['image']))
                                    <img src="{{ $cartoon['image']->temporaryUrl() }}" alt="صورة مؤقتة" class="object-cover w-full h-full" />
                                @else
                                    <i class="ri-user-3-line text-6xl text-indigo-400"></i>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-indigo-700 mb-1 truncate">{{ $cartoon['name'] ?: 'بدون اسم' }}</h3>
                            <p class="text-sm text-indigo-600 mb-2 h-16 overflow-hidden">{{ $cartoon['description'] ?: 'لا يوجد وصف' }}</p>
        
                            <div class="flex justify-between items-center">
                                <button wire:click="editCartoon({{ $index }})" class="text-indigo-600 hover:text-indigo-800 transition text-xl" title="تعديل">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button wire:click="removeCartoon({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex justify-between items-center mt-6">
                <button type="button" wire:click="addCartoon" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                    + أضف شخصية كرتونية جديدة
                </button>
        
                <button type="button" wire:click="saveCartoons" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                    حفظ كل الشخصيات
                </button>
            </div>
        </div>
        <div class="mb-6 font-sans">
            <label class="block text-2xl font-extrabold mb-6 text-teal-600">🛠️ ورش العمل</label>
        
            <div class="flex space-x-6 overflow-x-auto pb-4">
                @foreach ($workshops as $index => $workshop)
                    <div class="flex-shrink-0 w-72 bg-gradient-to-br from-teal-100 via-teal-200 to-teal-300 rounded-xl shadow-lg p-5 relative text-gray-800">
                        @if ($workshopEditingIndex === $index)
                            <input 
                                type="text" 
                                wire:model.lazy="workshops.{{ $index }}.title" 
                                placeholder="عنوان الورشة" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-400 font-semibold text-lg text-teal-700"
                            />
                            <textarea 
                                wire:model.lazy="workshops.{{ $index }}.description" 
                                placeholder="وصف الورشة" 
                                rows="3"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-400 text-sm resize-none"
                            ></textarea>
        
                            <label class="block mb-2 font-semibold text-teal-600">صورة الورشة</label>
                            <input 
                                type="file" 
                                wire:model="workshops.{{ $index }}.image" 
                                accept="image/*"
                                class="mb-3 w-full text-sm text-teal-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-100 file:text-teal-700 hover:file:bg-teal-200 cursor-pointer"
                            />
        
                            <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                                <button wire:click="saveWorkshop({{ $index }})" class="text-teal-600 hover:text-teal-800 transition text-xl" title="حفظ">
                                    <i class="ri-save-line"></i>
                                </button>
                                <button wire:click="removeWorkshop({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @else
                            <div class="h-40 rounded-lg overflow-hidden mb-4 bg-teal-50 flex items-center justify-center">
                                @if (!empty($workshop['image']) && !is_object($workshop['image']))
                                    <img src="{{ asset('storage/' . $workshop['image']) }}" alt="صورة الورشة" class="object-cover w-full h-full" />
                                @elseif(is_object($workshop['image']))
                                    <img src="{{ $workshop['image']->temporaryUrl() }}" alt="صورة مؤقتة" class="object-cover w-full h-full" />
                                @else
                                    <i class="ri-tools-line text-6xl text-teal-400"></i>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-teal-700 mb-1 truncate">{{ $workshop['title'] ?: 'بدون عنوان' }}</h3>
                            <p class="text-sm text-teal-600 mb-2 h-16 overflow-hidden">{{ $workshop['description'] ?: 'لا يوجد وصف' }}</p>
        
                            <div class="flex justify-between items-center">
                                <button wire:click="editWorkshop({{ $index }})" class="text-teal-600 hover:text-teal-800 transition text-xl" title="تعديل">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button wire:click="removeWorkshop({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex justify-between items-center mt-6">
                <button type="button" wire:click="addWorkshop" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-semibold transition">
                    + أضف ورشة جديدة
                </button>
        
                <button type="button" wire:click="saveWorkshops" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                    حفظ كل الورش
                </button>
            </div>
        </div>
                
    
    @endif
    @if ($category == "online")
        <p class="text-yellow-500">في حالة وجود مواقع دخول المرور يكون بكود الحجز الذي عند اليوزر</p>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">المتحدث</th>
                        <th class="border px-3 py-2">التاريخ</th>
                        <th class="border px-3 py-2">الوقت</th>
                        <th class="border px-3 py-2">المكان</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sessions as $index => $session)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($editingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                                <td class="border px-2 py-1">{{ $session['date'] }}</td>
                                <td class="border px-2 py-1">{{ $session['time'] }}</td>
                                <td class="border px-2 py-1">{{ $session['location'] }}</td>
                                <td class="border px-2 py-1">{{ $session['description'] }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف جلسة
                </button>
        
                <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الجلسات
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">روابط الفعالية</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">المنصة</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($links as $index => $link)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($linksEditingIndex === $index)
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="links.{{ $index }}.platform" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="links.{{ $index }}.url" class="w-full p-1 border rounded text-sm" />
                                </td>

                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="links.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveLink({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeLink({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                <td class="border px-2 py-1">{{ $link['platform'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $link['url'] }}" target="_blank" class="text-blue-500 underline">{{ $link['url'] }}</a>
                                </td>
                                <td class="border px-2 py-1">{{ $link['description'] }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editLink({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeLink({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addLink" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف رابط
                </button>
        
                <button type="button" wire:click="saveLinks" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الروابط
                </button>
            </div>
        </div>
        
    @endif
    @if ($category == "workshop")
        <div class="mb-6">
            <label class="block text-lg font-semibold mb-3 text-gray-700">الدورات & الورش التدريبية</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">العنوان</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">المدة</th>
                        <th class="border px-3 py-2">المكان</th>
                        <th class="border px-3 py-2">المدرب</th>
                        <th class="border px-3 py-2">الشهادة</th>
                        <th class="border px-3 py-2">الصورة</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
        
                <tbody class="text-center text-gray-800">
                    @foreach ($trainingWorkshops as $index => $w)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($trainingWorkshopsEditingIndex === $index)
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.title" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.duration" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.instructor" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <label class="inline-flex items-center gap-2">
                                        <input type="checkbox" wire:model.lazy="trainingWorkshops.{{ $index }}.certificate" class="form-checkbox h-4 w-4" />
                                        <span class="text-sm">نعم</span>
                                    </label>
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="trainingWorkshops.{{ $index }}.image" accept="image/*" class="w-full text-sm" />
                                    @if (isset($trainingWorkshops[$index]['image']) && is_object($trainingWorkshops[$index]['image']))
                                        <img src="{{ $trainingWorkshops[$index]['image']->temporaryUrl() }}" class="mt-2 h-20 object-cover mx-auto" />
                                    @elseif(!empty($trainingWorkshops[$index]['image']))
                                        <img src="{{ asset('storage/' . $trainingWorkshops[$index]['image']) }}" class="mt-2 h-20 object-cover mx-auto" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveTrainingWorkshop({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeTrainingWorkshop({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                <td class="border px-2 py-1">{{ $w['title'] }}</td>
                                <td class="border px-2 py-1">{{ $w['description'] }}</td>
                                <td class="border px-2 py-1">{{ $w['duration'] }}</td>
                                <td class="border px-2 py-1">{{ $w['location'] }}</td>
                                <td class="border px-2 py-1">{{ $w['instructor'] }}</td>
                                <td class="border px-2 py-1">{{ $w['certificate'] ? 'نعم' : 'لا' }}</td>
                                <td class="border px-2 py-1">
                                    @if (!empty($w['image']) && !is_object($w['image']))
                                        <img src="{{ asset('storage/' . $w['image']) }}" class="h-16 object-cover mx-auto" />
                                    @else
                                        <span class="text-gray-400 text-xs">لا صورة</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editTrainingWorkshop({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeTrainingWorkshop({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addTrainingWorkshop" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف ورشة / دورة
                </button>
        
                <button type="button" wire:click="saveTrainingWorkshops" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الورش والدورات
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>
    @endif

    @if ($category =="social_party")
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
    
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">المؤدي</th>
                    <th class="border px-3 py-2">التاريخ</th>
                    <th class="border px-3 py-2">الوقت</th>
                    <th class="border px-3 py-2">المكان</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sessions as $index => $session)
                    <tr class="hover:bg-gray-50 transition">
                        @if ($editingIndex === $index)
                            {{-- حالة التعديل --}}
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            {{-- حالة العرض --}}
                            <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                            <td class="border px-2 py-1">{{ $session['date'] }}</td>
                            <td class="border px-2 py-1">{{ $session['time'] }}</td>
                            <td class="border px-2 py-1">{{ $session['location'] }}</td>
                            <td class="border px-2 py-1">{{ $session['description'] }}</td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف جلسة
            </button>
    
            <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الجلسات
            </button>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
    
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">الاسم</th>
                    <th class="border px-3 py-2">المستوى</th>
                    <th class="border px-3 py-2">الرابط</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">الشعار</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sponsors as $index => $sponsor)
                    <tr class="hover:bg-gray-50 transition">
                        @if ($sponsorEditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                    <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                @endif
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            {{-- حالة العرض --}}
                            <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                            <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                            </td>
                            <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                            <td class="border px-2 py-1">
                                @if ($sponsor['logo'])
                                <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                @else
                                <span class="text-gray-400 text-xs">لا يوجد</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف راعٍ
            </button>
    
            <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الرعاة
            </button>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">المؤدين</label>

        <div class="flex gap-4 overflow-x-auto py-2 px-1">
            @foreach ($speakers as $index => $speaker)
                <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                    
                    {{-- صورة المتحدث --}}
                    <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                        @if(is_string($speaker['image']) && $speaker['image'] !== '')
                            <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                        @else
                            <span class="text-gray-400">لا صورة</span>
                        @endif
                    </div>

                    {{-- بيانات المتحدث --}}
                    @if ($SpeakereditingIndex === $index)
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                            <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                            <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                        </div>

                        <div class="flex justify-between mt-2 text-sm">
                            <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                            <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                        </div>
                    @else
                        <div class="space-y-1 text-sm text-gray-800">
                            <p><strong>{{ $speaker['name'] }}</strong></p>
                            <p>{{ $speaker['title'] }}</p>
                            <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                        </div>

                        <div class="flex justify-between mt-2 text-sm">
                            <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                            <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- زر الإضافة والحفظ --}}
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف متحدث
            </button>

            <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل المتحدثين
            </button>
        </div>
    </div>
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
            @foreach ($activities as $index => $activity)
                <div class="border rounded-md p-4 shadow-sm bg-white relative">
                    @if ($activityeditingIndex === $index)
                        {{-- حالة التعديل --}}
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                            <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                            <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                            
                            <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                            
                            <div class="flex justify-end gap-2 mt-2">
                                <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- حالة العرض --}}
                        <div class="space-y-1">
                            <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
    
                            @if (!empty($activity['image']))
                                <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                            @endif
                        </div>
    
                        <div class="absolute top-2 left-2 flex gap-2">
                            <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف فعالية
            </button>
    
            <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ الفعاليات
            </button>
        </div>
    </div>
    @endif

    @if ($category == "sports_fitness")
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات & المباريات</label>
    
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">المؤدي</th>
                    <th class="border px-3 py-2">التاريخ</th>
                    <th class="border px-3 py-2">الوقت</th>
                    <th class="border px-3 py-2">المكان</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sessions as $index => $session)
                    <tr class="hover:bg-gray-50 transition">
                        @if ($editingIndex === $index)
                            {{-- حالة التعديل --}}
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            {{-- حالة العرض --}}
                            <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                            <td class="border px-2 py-1">{{ $session['date'] }}</td>
                            <td class="border px-2 py-1">{{ $session['time'] }}</td>
                            <td class="border px-2 py-1">{{ $session['location'] }}</td>
                            <td class="border px-2 py-1">{{ $session['description'] }}</td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف جلسة
            </button>
    
            <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الجلسات
            </button>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
    
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">الاسم</th>
                    <th class="border px-3 py-2">المستوى</th>
                    <th class="border px-3 py-2">الرابط</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">الشعار</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sponsors as $index => $sponsor)
                    <tr class="hover:bg-gray-50 transition">
                        @if ($sponsorEditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                    <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                @endif
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            {{-- حالة العرض --}}
                            <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                            <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                            </td>
                            <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                            <td class="border px-2 py-1">
                                @if ($sponsor['logo'])
                                <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                @else
                                <span class="text-gray-400 text-xs">لا يوجد</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف راعٍ
            </button>
    
            <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الرعاة
            </button>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الشخصيات & الرياضيون</label>

        <div class="flex gap-4 overflow-x-auto py-2 px-1">
            @foreach ($speakers as $index => $speaker)
                <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                    
                    {{-- صورة المتحدث --}}
                    <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                        @if(is_string($speaker['image']) && $speaker['image'] !== '')
                            <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                        @else
                            <span class="text-gray-400">لا صورة</span>
                        @endif
                    </div>

                    {{-- بيانات المتحدث --}}
                    @if ($SpeakereditingIndex === $index)
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                            <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                            <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                        </div>

                        <div class="flex justify-between mt-2 text-sm">
                            <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                            <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                        </div>
                    @else
                        <div class="space-y-1 text-sm text-gray-800">
                            <p><strong>{{ $speaker['name'] }}</strong></p>
                            <p>{{ $speaker['title'] }}</p>
                            <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                        </div>

                        <div class="flex justify-between mt-2 text-sm">
                            <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                            <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- زر الإضافة والحفظ --}}
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف شخصية
            </button>

            <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الشخصيات
            </button>
        </div>
    </div>
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
            @foreach ($activities as $index => $activity)
                <div class="border rounded-md p-4 shadow-sm bg-white relative">
                    @if ($activityeditingIndex === $index)
                        {{-- حالة التعديل --}}
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                            <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                            <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                            
                            <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                            
                            <div class="flex justify-end gap-2 mt-2">
                                <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- حالة العرض --}}
                        <div class="space-y-1">
                            <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
    
                            @if (!empty($activity['image']))
                                <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                            @endif
                        </div>
    
                        <div class="absolute top-2 left-2 flex gap-2">
                            <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف فعالية
            </button>
    
            <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ الفعاليات
            </button>
        </div>
    </div>
    @endif

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الخدمات المتوفرة</label>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
            @foreach ($services as $index => $activity)
                <div class="border rounded-md p-4 shadow-sm bg-white relative">
                    @if ($servicesEditingIndex === $index)
                        {{-- حالة التعديل --}}
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="services.{{ $index }}.title" placeholder="عنوان الخدمة" class="w-full p-2 border rounded text-sm">
                            <input type="time" wire:model.lazy="services.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="services.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                            <textarea wire:model.lazy="services.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                            
                            <input type="file" wire:model="services.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                            
                            <div class="flex justify-end gap-2 mt-2">
                                <button wire:click="saveServiceRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeService({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- حالة العرض --}}
                        <div class="space-y-1">
                            <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
    
                            @if (!empty($activity['image']))
                                <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                            @endif
                        </div>
    
                        <div class="absolute top-2 left-2 flex gap-2">
                            <button wire:click="editServiceRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeService({{ $index }})" class="text-red-600 hover:text-red-800">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addService" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف خدمة
            </button>
    
            <button type="button" wire:click="saveServices" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ الخدمات
            </button>
        </div>
    </div>
</div>

@endif

@if ($type == "services")
    @if ($category == "digital")

    
    @endif
    @if ($category == "maintenance")
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الأجهزة المدعومة التي تقوم بتصليحها</label>
    
        <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-3 py-2 text-right">اسم الجهاز</th>
                        <th class="border border-gray-300 px-3 py-2 text-right">موديل الجهاز</th>
                        <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                        <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                        <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supportedDevices as $index => $device)
                        <tr>
                            @if($supportedDevicesEditingIndex === $index)
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" wire:model.lazy="supportedDevices.{{ $index }}.device_name" placeholder="اسم الجهاز" class="w-full p-1 border rounded" />
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" wire:model.lazy="supportedDevices.{{ $index }}.model" placeholder="موديل الجهاز" class="w-full p-1 border rounded" />
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <textarea wire:model.lazy="supportedDevices.{{ $index }}.description" placeholder="وصف الجهاز (اختياري)" class="w-full p-1 border rounded" rows="2"></textarea>
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-center">
                                    @if(isset($device['image']) && $device['image'])
                                        <img src="{{ is_string($device['image']) ? asset('storage/'.$device['image']) : $device['image']->temporaryUrl() }}" class="mx-auto w-24 h-16 object-cover rounded" alt="صورة الجهاز">
                                    @endif
                                    <input type="file" wire:model="supportedDevices.{{ $index }}.image" class="mt-1" />
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                    <button wire:click="saveSupportedDevice({{ $index }})" class="text-green-600 hover:text-green-800 mr-2" title="حفظ">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSupportedDevice({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                <td class="border border-gray-300 px-2 py-1">{{ $device['device_name'] }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $device['model'] }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ Str::limit($device['description'], 50) }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-center">
                                    @if(!empty($device['image']))
                                        <img src="{{ asset('storage/' . $device['image']) }}" alt="صورة الجهاز" class="mx-auto w-24 h-16 object-cover rounded" />
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                    <button wire:click="editSupportedDevice({{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSupportedDevice({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <div class="mt-4 flex gap-3">
            <button wire:click="addSupportedDevice" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                + إضافة جهاز مدعوم
            </button>
            <button wire:click="saveSupportedDevices" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                حفظ الأجهزة
            </button>
        </div>
    </div>
    
      
    @endif
    @if ($category == "central")
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الشخص</th>
                        <th class="border px-3 py-2">التاريخ</th>
                        <th class="border px-3 py-2">الوقت</th>
                        <th class="border px-3 py-2">المكان</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sessions as $index => $session)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($editingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                                <td class="border px-2 py-1">{{ $session['date'] }}</td>
                                <td class="border px-2 py-1">{{ $session['time'] }}</td>
                                <td class="border px-2 py-1">{{ $session['location'] }}</td>
                                <td class="border px-2 py-1">{{ $session['description'] }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف جلسة
                </button>
        
                <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الجلسات
                </button>
            </div>
        </div>
    @endif

    @if ($category == "tourism")
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الوجهات السياحية</label>
    
        <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-3 py-2 text-right">الاسم</th>
                        <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                        <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                        <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Destenations as $index => $destination)
                        <tr>
                            @if($DestenationsEditingIndex === $index)
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" wire:model.lazy="Destenations.{{ $index }}.name" placeholder="اسم الوجهة" class="w-full p-1 border rounded" />
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <textarea wire:model.lazy="Destenations.{{ $index }}.description" placeholder="وصف الوجهة" class="w-full p-1 border rounded" rows="2"></textarea>
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-center">
                                    @if(isset($destination['image']) && $destination['image'])
                                        <img src="{{ is_string($destination['image']) ? asset('storage/'.$destination['image']) : $destination['image']->temporaryUrl() }}" class="mx-auto w-24 h-16 object-cover rounded" alt="صورة الوجهة">
                                    @endif
                                    <input type="file" wire:model="Destenations.{{ $index }}.image" class="mt-1" />
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                    <button wire:click="saveDestination({{ $index }})" class="text-green-600 hover:text-green-800 mr-2" title="حفظ">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeDestination({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                <td class="border border-gray-300 px-2 py-1">{{ $destination['name'] }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ Str::limit($destination['description'], 50) }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-center">
                                    @if(!empty($destination['image']))
                                        <img src="{{ asset('storage/' . $destination['image']) }}" alt="صورة الوجهة" class="mx-auto w-24 h-16 object-cover rounded" />
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                    <button wire:click="editDestination({{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeDestination({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <div class="mt-4 flex gap-3">
            <button wire:click="addDestination" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                + إضافة وجهة جديدة
            </button>
            <button wire:click="saveDestenations" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                حفظ الوجهات
            </button>
        </div>
    </div>
    
    @endif

    @if ($category == "personal")
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الشخص</th>
                        <th class="border px-3 py-2">التاريخ</th>
                        <th class="border px-3 py-2">الوقت</th>
                        <th class="border px-3 py-2">المكان</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sessions as $index => $session)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($editingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                                <td class="border px-2 py-1">{{ $session['date'] }}</td>
                                <td class="border px-2 py-1">{{ $session['time'] }}</td>
                                <td class="border px-2 py-1">{{ $session['location'] }}</td>
                                <td class="border px-2 py-1">{{ $session['description'] }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف جلسة
                </button>
        
                <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الجلسات
                </button>
            </div>
        </div>

    @endif

    @if ($category == "medical")
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الشخص</th>
                        <th class="border px-3 py-2">التاريخ</th>
                        <th class="border px-3 py-2">الوقت</th>
                        <th class="border px-3 py-2">المكان</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sessions as $index => $session)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($editingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                                <td class="border px-2 py-1">{{ $session['date'] }}</td>
                                <td class="border px-2 py-1">{{ $session['time'] }}</td>
                                <td class="border px-2 py-1">{{ $session['location'] }}</td>
                                <td class="border px-2 py-1">{{ $session['description'] }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف جلسة
                </button>
        
                <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الجلسات
                </button>
            </div>
        </div>


        

    @endif

    @if ($category == "consulting")
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">المؤدي</th>
                        <th class="border px-3 py-2">التاريخ</th>
                        <th class="border px-3 py-2">الوقت</th>
                        <th class="border px-3 py-2">المكان</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sessions as $index => $session)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($editingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                                <td class="border px-2 py-1">{{ $session['date'] }}</td>
                                <td class="border px-2 py-1">{{ $session['time'] }}</td>
                                <td class="border px-2 py-1">{{ $session['location'] }}</td>
                                <td class="border px-2 py-1">{{ $session['description'] }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف جلسة
                </button>
        
                <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الجلسات
                </button>
            </div>
        </div>
        

    @endif
    @if ($category =="restaurant")
    <div class="mb-6" dir="rtl"> {{-- وضع اتجاه عربي --}}
        <label class="block text-base font-semibold mb-3 text-gray-700">الأطباق في المطاعم</label>
    
        <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
            <table class="w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-3 py-2 text-right">اسم الطبق</th>
                        <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                        <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                        <th class="border border-gray-300 px-3 py-2 text-center">السعر</th>
                        <th class="border border-gray-300 px-3 py-2 text-center">السعرات الحرارية</th>
                        <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plats as $index => $plat)
                        <tr>
                            <td class="border border-gray-300 px-2 py-1">{{ $plat['name'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ Str::limit($plat['description'], 50) }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center">
                                @if(!empty($plat['image']))
                                    <img src="{{ is_string($plat['image']) ? asset('storage/' . $plat['image']) : $plat['image']->temporaryUrl() }}" alt="صورة الطبق" class="mx-auto w-24 h-16 object-cover rounded" />
                                @endif
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center">{{ $plat['price'] }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center">{{ $plat['calories'] ?? '-' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                <button wire:click="editPlat({{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removePlat({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        {{-- مربع التعديل الكبير --}}
        @if($platsEditingIndex !== null)
            @php
                $plat = $plats[$platsEditingIndex];
            @endphp
            <div class="mt-6 p-6 border border-gray-300 rounded bg-gray-50 max-w-xl mx-auto shadow-md" dir="rtl">
                <h3 class="text-lg font-semibold mb-4 text-right">تعديل الطبق</h3>
                
                <div class="mb-4 text-right">
                    <label class="block mb-1 font-semibold">اسم الطبق</label>
                    <input type="text" wire:model.lazy="plats.{{ $platsEditingIndex }}.name" class="w-full p-2 border rounded" placeholder="اسم الطبق" />
                </div>
    
                <div class="mb-4 text-right">
                    <label class="block mb-1 font-semibold">وصف الطبق</label>
                    <textarea wire:model.lazy="plats.{{ $platsEditingIndex }}.description" class="w-full p-2 border rounded" rows="4" placeholder="وصف الطبق"></textarea>
                </div>
    
                <div class="mb-4 text-center">
                    @if(isset($plat['image']) && $plat['image'])
                        <img src="{{ is_string($plat['image']) ? asset('storage/'.$plat['image']) : $plat['image']->temporaryUrl() }}" class="mx-auto w-48 h-32 object-cover rounded mb-2" alt="صورة الطبق">
                    @endif
                    <input type="file" wire:model="plats.{{ $platsEditingIndex }}.image" class="mx-auto" />
                </div>
    
                <div class="mb-4 text-right flex gap-4">
                    <div class="flex-1">
                        <label class="block mb-1 font-semibold">السعر</label>
                        <input type="number" wire:model.lazy="plats.{{ $platsEditingIndex }}.price" class="w-full p-2 border rounded text-center" placeholder="السعر" />
                    </div>
    
                    <div class="flex-1">
                        <label class="block mb-1 font-semibold">السعرات الحرارية</label>
                        <input type="number" wire:model.lazy="plats.{{ $platsEditingIndex }}.calories" class="w-full p-2 border rounded text-center" placeholder="السعرات الحرارية" />
                    </div>
                </div>
    
                <div class="text-center mt-6 flex justify-center gap-6">
                    <button wire:click="savePlat({{ $platsEditingIndex }})" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">حفظ</button>
                    <button wire:click="cancelEdit" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">إلغاء</button>
                </div>
            </div>
        @endif
    
        <div class="mt-4 flex gap-3 justify-center">
            <button wire:click="addPlat" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                + إضافة طبق جديد
            </button>
            <button wire:click="savePlats" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                حفظ الأطباق
            </button>
        </div>
    </div>
    
    @endif
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الأدوات المتاحة</label>
    
        <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-3 py-2 text-right">الاسم</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">التصنيف</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">الموديل</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">التوفر</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">المميزات</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($availableTools as $index => $tool)
                    <tr>
                        @if ($availableToolsEditingIndex === $index)
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" wire:model.lazy="availableTools.{{ $index }}.name" class="w-full p-1 border rounded" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" wire:model.lazy="availableTools.{{ $index }}.category" class="w-full p-1 border rounded" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" wire:model.lazy="availableTools.{{ $index }}.model" class="w-full p-1 border rounded" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" wire:model.lazy="availableTools.{{ $index }}.availability" class="w-full p-1 border rounded" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <textarea wire:model.lazy="availableTools.{{ $index }}.features" class="w-full p-1 border rounded" rows="2"></textarea>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <textarea wire:model.lazy="availableTools.{{ $index }}.description" class="w-full p-1 border rounded" rows="2"></textarea>
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center">
                                @if (isset($tool['image']) && $tool['image'])
                                    <img src="{{ is_string($tool['image']) ? asset('storage/'.$tool['image']) : $tool['image']->temporaryUrl() }}" class="mx-auto w-16 h-16 object-cover rounded" alt="صورة الأداة">
                                @endif
                                <input type="file" wire:model="availableTools.{{ $index }}.image" class="mt-1" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                <button wire:click="saveAvailableTool({{ $index }})" class="text-green-600 hover:text-green-800 mr-2" title="حفظ">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeAvailableTool({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            <td class="border border-gray-300 px-2 py-1">{{ $tool['name'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $tool['category'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $tool['model'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $tool['availability'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ Str::limit($tool['features'], 50) }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ Str::limit($tool['description'], 50) }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center">
                                @if (!empty($tool['image']))
                                    <img src="{{ asset('storage/' . $tool['image']) }}" class="mx-auto w-16 h-16 object-cover rounded" alt="صورة الأداة">
                                @endif
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                <button wire:click="editAvailableTool({{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeAvailableTool({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    
        <div class="mt-4 flex gap-3">
            <button wire:click="addAvailableTool" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                + أضف أداة جديدة
            </button>
            <button wire:click="saveAvailableTools" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                حفظ الأدوات
            </button>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">البورتفوليو</label>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
            @foreach ($Portfolio as $index => $item)
                <div class="border rounded-md p-4 shadow-sm bg-white relative">
                    @if ($portfolioEditingIndex === $index)
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="Portfolio.{{ $index }}.title" placeholder="العنوان" class="w-full p-2 border rounded text-sm" />
                            <textarea wire:model.lazy="Portfolio.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                            <input type="url" wire:model.lazy="Portfolio.{{ $index }}.link" placeholder="الرابط" class="w-full p-2 border rounded text-sm" />
                            <input type="date" wire:model.lazy="Portfolio.{{ $index }}.date" class="w-full p-2 border rounded text-sm" />
                            <input type="text" wire:model.lazy="Portfolio.{{ $index }}.tools" placeholder="الأدوات مفصولة بفواصل" class="w-full p-2 border rounded text-sm" />
                            <input type="file" wire:model="Portfolio.{{ $index }}.image" class="w-full p-2 border rounded text-sm" />
                            
                            <div class="flex justify-end gap-2 mt-2">
                                <button wire:click="savePortfolioRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    حفظ
                                </button>
                                <button wire:click="removePortfolio({{ $index }})" class="text-red-600 hover:text-red-800">
                                    حذف
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="space-y-1">
                            <h3 class="font-semibold text-sm text-gray-800">{{ $item['title'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $item['date'] }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $item['description'] }}</p>
                            <p class="text-xs text-gray-500">الأدوات: {{ $item['tools'] }}</p>
                            <a href="{{ $item['link'] }}" target="_blank" class="text-blue-600 underline text-sm">رابط المشروع</a>
    
                            @if (!empty($item['image']))
                                <img src="{{ asset('storage/' . $item['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="صورة المشروع">
                            @endif
                        </div>
    
                        <div class="absolute top-2 left-2 flex gap-2">
                            <button wire:click="editPortfolioRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                تعديل
                            </button>
                            <button wire:click="removePortfolio({{ $index }})" class="text-red-600 hover:text-red-800">
                                حذف
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        <div class="flex items-center mt-4 gap-3">
            <button wire:click="addPortfolio" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + أضف مشروع جديد
            </button>
    
            <button wire:click="savePortfolio" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                حفظ البورتفوليو
            </button>
        </div>
    </div>
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الخدمات الاضافية</label>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
            @foreach ($services as $index => $activity)
                <div class="border rounded-md p-4 shadow-sm bg-white relative">
                    @if ($servicesEditingIndex === $index)
                        {{-- حالة التعديل --}}
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="services.{{ $index }}.title" placeholder="عنوان الخدمة" class="w-full p-2 border rounded text-sm">
                            <input type="time" wire:model.lazy="services.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="services.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                            <textarea wire:model.lazy="services.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                            
                            <input type="file" wire:model="services.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                            
                            <div class="flex justify-end gap-2 mt-2">
                                <button wire:click="saveServiceRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeService({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- حالة العرض --}}
                        <div class="space-y-1">
                            <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
    
                            @if (!empty($activity['image']))
                                <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                            @endif
                        </div>
    
                        <div class="absolute top-2 left-2 flex gap-2">
                            <button wire:click="editServiceRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeService({{ $index }})" class="text-red-600 hover:text-red-800">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addService" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف خدمة
            </button>
    
            <button type="button" wire:click="saveServices" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ الخدمات
            </button>
        </div>
    </div>
@endif
<div class="mb-6">
    <label class="block text-base font-semibold mb-3 text-gray-700">مزايا العرض (Offer Features)</label>

    <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-3 py-2 text-right">الاسم</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Offerfeatures as $index => $feature)
                    <tr>
                        @if($OfferfeaturesEditingIndex === $index)
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" wire:model.lazy="Offerfeatures.{{ $index }}.name" placeholder="اسم الميزة" class="w-full p-1 border rounded" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <textarea wire:model.lazy="Offerfeatures.{{ $index }}.description" placeholder="وصف الميزة" class="w-full p-1 border rounded" rows="2"></textarea>
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center">
                                @if(isset($feature['image']) && $feature['image'])
                                    <img src="{{ is_string($feature['image']) ? asset('storage/'.$feature['image']) : $feature['image']->temporaryUrl() }}" class="mx-auto w-24 h-16 object-cover rounded" alt="صورة الميزة">
                                @endif
                                <input type="file" wire:model="Offerfeatures.{{ $index }}.image" class="mt-1" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                <button wire:click="saveOfferFeature({{ $index }})" class="text-green-600 hover:text-green-800 mr-2" title="حفظ">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeOfferFeature({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            <td class="border border-gray-300 px-2 py-1">{{ $feature['name'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ Str::limit($feature['description'], 50) }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center">
                                @if(!empty($feature['image']))
                                    <img src="{{ asset('storage/' . $feature['image']) }}" alt="صورة الميزة" class="mx-auto w-24 h-16 object-cover rounded" />
                                @endif
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                <button wire:click="editOfferFeature({{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeOfferFeature({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex gap-3">
        <button wire:click="addOfferFeature" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + إضافة ميزة جديدة
        </button>
        <button wire:click="saveOfferFeatures" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            حفظ المزايا
        </button>
    </div>
</div>

<script>
    document.querySelectorAll('input[type=file]').forEach(input => {
    input.setAttribute('accept', 'image/*');
});

</script>
</div>