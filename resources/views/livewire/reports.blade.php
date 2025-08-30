<div>
    <div class="max-w-7xl mx-auto px-6 py-12 space-y-12 bg-gray-100">

        <h2 class="text-4xl font-bold text-center text-blue-700 mb-12">لوحة إحصاءات الإدارة المتقدمة</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- المحفظة -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-wallet-3-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">رصيد المحفظة</h3>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($totalBalance, 0) }}</p>
                <p class="text-sm text-gray-400">الأرصدة الحالية للتجار</p>
            </div>

            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-lock-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">أرصدة مجمدة</h3>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($totalLocked, 0) }}</p>
                <p class="text-sm text-gray-400">المبالغ المحجوزة</p>
            </div>

            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-refund-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">السحوبات</h3>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($totalWithdrawn, 0) }}</p>
                <p class="text-sm text-gray-400">المبالغ المسحوبة</p>
            </div>

            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-stack-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">إجمالي المحفظة</h3>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($walletTotal, 0) }}</p>
                <p class="text-sm text-gray-400">إجمالي أموال المحفظة</p>
            </div>

            <!-- المستخدمين -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-user-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">المستخدمين</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalUsers }}</p>
                <p class="text-sm text-gray-400">عدد المستخدمين العاديين</p>
            </div>

            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-admin-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">المدراء</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalAdmins }}</p>
                <p class="text-sm text-gray-400">عدد المدراء</p>
            </div>

            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-briefcase-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">العروض</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalOffers }}</p>
                <p class="text-sm text-gray-400">عدد العروض في النظام</p>
            </div>

            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-building-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">الفروع</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalBranches }}</p>
                <p class="text-sm text-gray-400">عدد الفروع</p>
            </div>

            <!-- الحضور / الPresence -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-checkbox-circle-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">الحضور الكامل</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalPresence }}</p>
                <p class="text-sm text-gray-400">عدد الحاضرين / الحضروات المدفوعة</p>
            </div>
            <!-- رسائل الدعم -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-message-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">رسائل الدعم</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalSupportMessages }}</p>
                <p class="text-sm text-gray-400">إجمالي الرسائل المرسلة عبر الدعم</p>
            </div>

            <!-- التذاكر -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-ticket-2-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">تذاكر الدعم</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalSupportTickets }}</p>
                <p class="text-sm text-gray-400">عدد التذاكر المفتوحة</p>
            </div>

            <!-- الرولات -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-shield-user-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">الرولات</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalRoles }}</p>
                <p class="text-sm text-gray-400">عدد أدوار النظام</p>
            </div>

            <!-- الفيوز / مشاهدات الصفحات -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-eye-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">مشاهدات الصفحات</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalPageViews }}</p>
                <p class="text-sm text-gray-400">إجمالي المشاهدات على الموقع</p>
            </div>

            <!-- محادثات التجار -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-chat-3-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">محادثات التجار</h3>
                <p class="text-2xl font-bold text-blue-500">{{ $totalMerchantChats }}</p>
                <p class="text-sm text-gray-400">عدد المحادثات بين التجار والعملاء</p>
            </div>

            <!-- رسائل التجار -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 text-center">
                <i class="ri-mail-line text-4xl text-blue-500 mb-2"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">رسائل التجار</h3>
                <p class="text-2xl font-bold text-blue-500">{{ $totalMerchantMessages }}</p>
                <p class="text-sm text-gray-400">إجمالي الرسائل المرسلة من التجار للعملاء</p>
            </div>



        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- نسبة التجار والمستخدمين -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-3 text-gray-700">نسبة التجار والمستخدمين</h3>
                <div id="merchantUserChart" style="height:350px;"></div>
            </div>

            <!-- المعاملات والمدفوعات والسحوبات -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-3 text-gray-700">المعاملات والمدفوعات</h3>
                <div id="transactionChart" style="height:350px;"></div>
            </div>

            <!-- أعلى 4 عروض -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-3 text-gray-700">أعلى 4 عروض</h3>
                <div id="topOffersChart" style="height:350px;"></div>
            </div>
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 p-6 mt-6">
    <h3 class="text-lg font-semibold mb-3 text-gray-700">المدفوعات اليومية منذ بداية الموقع</h3>
    <div id="dailyPaymentsChart" style="height:400px;"></div>
</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== أعلى 4 عروض مباشرة =====
    const topOffersChart = echarts.init(document.getElementById('topOffersChart'));

    topOffersChart.setOption({
        tooltip: {
            trigger: 'item',
            formatter: function(params) {
                return params.name + '<br/>إجمالي المبيعات: ' + params.value + 
                       ' ريال<br/>عدد المشترين: ' + params.data.buyers;
            }
        },
        legend: { top: 'bottom' },
        series: [{
            name: 'Top Offers',
            type: 'pie',
            radius: '50%',
            data: [
                @foreach($topOffers as $offer)
                { name: "{{ $offer->name }}", value: {{ $offer->totalSales }}, buyers: {{ $offer->totalBuyers }} },
                @endforeach
            ],
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0,0,0,0.5)'
                }
            }
        }],
        color: ['#2563EB', '#1D4ED8', '#3B82F6', '#60A5FA']
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== نسبة التجار والمستخدمين =====
    const merchantUserChart = echarts.init(document.getElementById('merchantUserChart'));
    merchantUserChart.setOption({
        tooltip: { trigger: 'item' },
        legend: { top: 'bottom' },
        series: [{
            name: 'Users & Merchants',
            type: 'pie',
            radius: '50%',
            data: [
                { value: {{ $totalMerchants }}, name: 'التجار' },
                { value: {{ $totalUsers }}, name: 'المستخدمين' }
            ],
            emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0,0,0,0.5)' } }
        }],
        color: ['#1E3A8A', '#3B82F6']
    });

    // ===== المعاملات والمدفوعات والسحوبات =====
    const transactionChart = echarts.init(document.getElementById('transactionChart'));
    transactionChart.setOption({
        tooltip: { trigger: 'axis' },
        xAxis: { type: 'category', data: ['المعاملات', 'المدفوعات', 'السحوبات'] },
        yAxis: { type: 'value' },
        series: [{
            type: 'bar',
            data: [{{ $totalTransactions }}, {{ $totalPay }}, {{ $totalWithdraws }}],
            itemStyle: { color: '#2563EB' }
        }]
    });

    // ===== أعلى 4 عروض =====
    const topOffersChart = echarts.init(document.getElementById('topOffersChart'));
    topOffersChart.setOption({
        tooltip: {
            trigger: 'item',
            formatter: function(params) {
                return `${params.name}<br/>إجمالي المبيعات: ${params.value} ريال<br/>عدد المشترين: ${params.data.buyers}`;
            }
        },
        legend: { top: 'bottom' },
        series: [{
            name: 'Top Offers',
            type: 'pie',
            radius: '50%',
            data: [
                @foreach($topOffers as $offer)
                { name: "{{ $offer->name }}", value: {{ $offer->totalSales }}, buyers: {{ $offer->totalBuyers }} },
                @endforeach
            ],
            emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0,0,0,0.5)' } }
        }],
        color: ['#2563EB', '#1D4ED8', '#3B82F6', '#60A5FA']
    });

});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    
        const dailyPaymentsChart = echarts.init(document.getElementById('dailyPaymentsChart'));
    
        dailyPaymentsChart.setOption({
            tooltip: {
                trigger: 'axis'
            },
            xAxis: {
                type: 'category',
                data: {!! json_encode($dates) !!},
                boundaryGap: false
            },
            yAxis: {
                type: 'value',
                name: 'المدفوعات (ريال)'
            },
            dataZoom: [
                {
                    type: 'slider',      // شريط التمرير
                    start: 0,
                    end: 100
                },
                {
                    type: 'inside'       // يسمح بالسحب والتكبير بالماوس
                }
            ],
            series: [{
                name: 'المدفوعات اليومية',
                type: 'line',
                data: {!! json_encode($totals) !!},
                smooth: true,
                areaStyle: { color: 'rgba(59, 130, 246, 0.2)' },
                lineStyle: { color: '#3B82F6', width: 2 },
                symbol: 'circle',
                symbolSize: 6
            }]
        });
    });
    </script>