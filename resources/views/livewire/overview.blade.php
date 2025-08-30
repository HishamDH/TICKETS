<div class="max-w-7xl mx-auto p-8 bg-gray-50 min-h-screen">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-10 flex items-center justify-center gap-2">
      <i class="ri-dashboard-line text-blue-500 text-5xl"></i>
      لوحة التحكم
    </h1>
  
    <!-- Counters -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow hover:shadow-md transition">
        <div class="text-gray-500 mb-2 flex items-center gap-2">
          <i class="ri-store-2-line text-2xl text-blue-500"></i> التجار
        </div>
        <div class="text-3xl font-bold">{{ $merchantCount }}</div>
      </div>
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow hover:shadow-md transition">
        <div class="text-gray-500 mb-2 flex items-center gap-2">
          <i class="ri-user-line text-2xl text-green-500"></i> المستخدمون
        </div>
        <div class="text-3xl font-bold">{{ $userCount }}</div>
      </div>
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow hover:shadow-md transition">
        <div class="text-gray-500 mb-2 flex items-center gap-2">
          <i class="ri-shield-user-line text-2xl text-purple-500"></i> الموظفون
        </div>
        <div class="text-3xl font-bold">{{ $staffCount }}</div>
      </div>
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow hover:shadow-md transition">
        <div class="text-gray-500 mb-2 flex items-center gap-2">
          <i class="ri-shopping-bag-line text-2xl text-orange-500"></i> إجمالي المبيعات
        </div>
        <div class="text-3xl font-bold">{{ number_format($salesAmount, 0, '.', ',') }} ريال</div>
      </div>
    </div>
  
    <!-- New Merchants -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 mb-12 shadow">
      <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="ri-user-add-line text-blue-500"></i> التجار الجدد آخر شهر
      </h2>
      @if ($newMerchants->isEmpty())
        <p class="text-gray-500">لا يوجد تجار جدد</p>
      @else
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2 text-left">الاسم</th>
                <th class="px-4 py-2 text-left">البريد</th>
                <th class="px-4 py-2 text-left">تاريخ التسجيل</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($newMerchants as $merchant)
                <tr class="border-t">
                  <td class="px-4 py-2">{{ $merchant->f_name .' '.  $merchant->l_name}}</td>
                  <td class="px-4 py-2">{{ $merchant->email }}</td>
                  <td class="px-4 py-2">{{ $merchant->created_at->format('Y-m-d') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  
    <!-- System Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow">
        <div class="text-gray-500 mb-2 flex items-center gap-2">
          <i class="ri-currency-line text-2xl text-green-500"></i> عدد المبيعات
        </div>
        <div class="text-3xl font-bold">{{ $salesAmount }}</div>
      </div>
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow">
        <div class="text-gray-500 mb-2 flex items-center gap-2">
          <i class="ri-ticket-line text-2xl text-yellow-500"></i> التذاكر
        </div>
        <div class="text-3xl font-bold">{{ $ticketsCount }}</div>
      </div>
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow">
        <div class="text-gray-500 mb-2 flex items-center gap-2">
          <i class="ri-message-2-line text-2xl text-purple-500"></i> الرسائل
        </div>
        <div class="text-3xl font-bold">{{ $messagesCount }}</div>
      </div>
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow">
        <div class="text-gray-500 mb-2 flex items-center gap-2">
          <i class="ri-notification-3-line text-2xl text-red-500"></i> الإشعارات
        </div>
        <div class="text-3xl font-bold">{{ $notificationsCount }}</div>
      </div>
    </div>
  
    <!-- Recent Notifications -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 mb-12 shadow">
      <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="ri-notification-line text-blue-500"></i> آخر الأخبار
      </h2>
      <ul class="space-y-3">
        @forelse ($notifications as $note)
          <li class="border-b last:border-b-0 py-2 flex items-center gap-3">
            <i class="ri-notification-fill text-blue-400"></i>
            <div>
              <div class="text-gray-800">{{ $note->message }}</div>
              <div class="text-sm text-gray-500">{{ $note->created_at->diffForHumans() }}</div>
            </div>
          </li>
        @empty
          <p class="text-gray-500">لا توجد إشعارات.</p>
        @endforelse
      </ul>
    </div>
  
    <!-- Recent Tickets & Messages -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
          <i class="ri-ticket-2-line text-yellow-500"></i> آخر التذاكر
        </h2>
        <ul class="space-y-2">
          @forelse ($recentTickets as $ticket)
            <li class="border-b last:border-b-0 py-2">
              <div class="text-gray-800">{{ $ticket->subject }}</div>
              <div class="text-sm text-gray-500">{{ $ticket->created_at->format('Y-m-d H:i') }}</div>
            </li>
          @empty
            <p class="text-gray-500">لا توجد تذاكر.</p>
          @endforelse
        </ul>
      </div>
  
      <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
          <i class="ri-message-line text-purple-500"></i> آخر الرسائل
        </h2>
        <ul class="space-y-2">
          @forelse ($recentMessages as $message)
            <li class="border-b last:border-b-0 py-2">
              <div class="text-gray-800">{{ $message->message }}</div>
              <div class="text-sm text-gray-500">{{ $message->created_at->format('Y-m-d H:i') }}</div>
            </li>
          @empty
            <p class="text-gray-500">لا توجد رسائل.</p>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
  