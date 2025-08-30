@extends('merchant.layouts.app',['merchant' => $merchantid ?? false])

@section('content')

<script defer src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

<div class="flex-1 p-6 space-y-8 bg-slate-50">

  <!-- العنوان الرئيسي وزر التصدير -->
  <div class="flex justify-between items-center">
    <h2 class="text-3xl font-bold text-slate-800">التقارير والتحليلات</h2>
    <button id="export-all" class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-orange-100 hover:text-orange-700 transition">
      <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
        <polyline points="7 10 12 15 17 10"></polyline>
        <line x1="12" x2="12" y1="15" y2="3"></line>
      </svg>
      تصدير الكل
    </button>
  </div>

  <!-- البطاقات الإحصائية -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @php
        $cards = [
            ['title' => 'إجمالي المبيعات', 'value' => number_format($wallet->balance, 0, '.', ',') . ' ريال', 'icon' => 'bar-chart-2'],
            ['title' => 'نسبة الإلغاء', 'value' => $refundPercent . '%', 'icon' => 'pie-chart'],
            ['title' => 'الزوار الفعليون', 'value' => number_format($views, 0, '.', ','), 'icon' => 'users'],
            ['title' => 'أوقات الذروة', 'value' => $maxHour !== null ? \Carbon\Carbon::createFromTime($maxHour)->format('h A') . ' - ' . $maxDay : 'لا يوجد بيانات', 'icon' => 'calendar'],
        ];
    @endphp

    @foreach($cards as $card)
    <div class="rounded-2xl border border-slate-200 bg-white shadow-md p-6 space-y-4">
      <div class="flex items-center space-x-2 rtl:space-x-reverse">
        <svg class="lucide w-5 h-5" data-lucide="{{ $card['icon'] }}"></svg>
        <h3 class="text-lg font-semibold text-slate-700">{{ $card['title'] }}</h3>
      </div>
      <div class="text-2xl font-bold text-slate-900">{{ $card['value'] }}</div>
    </div>
    @endforeach
  </div>

  <!-- الرسوم البيانية -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- رسم الأعمدة -->
    <div class="bg-white rounded-2xl shadow-md p-6">
      <h3 class="text-lg font-semibold text-slate-700 mb-1">تقرير المبيعات الأسبوعي</h3>
      <p class="text-sm text-slate-500 mb-4">نظرة على أداء المبيعات خلال الأيام الماضية.</p>
      <div id="weekly-sales-chart" class="h-72 w-full"></div>
    </div>

    <!-- رسم دائري الخدمات -->
    <div class="bg-white rounded-2xl shadow-md p-6">
      <h3 class="text-lg font-semibold text-slate-700 mb-1">توزيع الحجوزات حسب الخدمات</h3>
      <p class="text-sm text-slate-500 mb-4">نسبة الحجوزات بين العروض.</p>
      <div id="servicePieChart" class="h-72 w-full"></div>
    </div>

    <!-- رسم دونت الإحصائيات -->
    <div class="bg-white rounded-2xl shadow-md p-6">
      <h3 class="text-lg font-semibold text-slate-700 mb-1">الإحصائيات</h3>
      <p class="text-sm text-slate-500 mb-4">مدفوعات وإلغاءات.</p>
      <div id="donutChart" class="h-72 w-full"></div>
    </div>

    <!-- رسم الذروة -->
    <div class="bg-white rounded-2xl shadow-md p-6 lg:col-span-2">
      <h3 class="text-lg font-semibold text-slate-700 mb-1">ساعات الذروة خلال الأسبوع</h3>
      <p class="text-sm text-slate-500 mb-4">أوقات النشاط الأعلى في المبيعات.</p>
      <div id="sales_chart" class="h-72 w-full"></div>
    </div>
  </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

<script>
if (!window.__dashboard_charts_initialized__) {
  window.__dashboard_charts_initialized__ = true;

  let chart, myChart, donutChart, myChart4;

  const offersPercent = @json($offersPercent);
  const salesData = @json(array_values($sells_day));
  const dayLabels = @json(array_keys($sells_day));
  const Pay = @json($PayPercent);
  const refund = @json($refundPercent);
  const allPayments = @json($all_payments);
  const allRefunds = @json($all_refunds);
  const peak_time = {!! json_encode($Peak_Time) !!};

  function renderCharts() {
      const chartDom = document.getElementById('servicePieChart');
      if (!chartDom) return;
      chart = echarts.init(chartDom);

      const offersData = Array.isArray(offersPercent) ? offersPercent.map(item => ({
          name: item.offer?.name ?? 'بدون اسم',
          value: item.percentage
      })) : [];

      chart.setOption({
          title: { text: 'توزيع الحجوزات', left: 'center' },
          tooltip: { trigger: 'item' },
          legend: { bottom: 10, left: 'center' },
          series: [{
              name: 'الخدمة',
              type: 'pie',
              radius: '60%',
              data: offersData,
              emphasis: {
                  itemStyle: {
                      shadowBlur: 10,
                      shadowOffsetX: 0,
                      shadowColor: 'rgba(0, 0, 0, 0.5)'
                  }
              },
              label: {
                  formatter: '{b}: {d}%'
              }
          }]
      });
  }

  function renderWeeklySalesChart() {
      const chartDom = document.getElementById('weekly-sales-chart');
      if (!chartDom) return;
      myChart = echarts.init(chartDom);

      myChart.setOption({
          tooltip: { trigger: 'axis' },
          xAxis: { type: 'category', data: dayLabels },
          yAxis: { type: 'value' },
          series: [{
              data: salesData,
              type: 'bar',
              itemStyle: {
                  color: '#3b82f6',
                  borderRadius: [4, 4, 0, 0]
              }
          }]
      });
  }

  function renderDonutChart() {
      const chartDom = document.getElementById('donutChart');
      if (!chartDom) return;
      donutChart = echarts.init(chartDom);

      donutChart.setOption({
          title: { text: 'الإحصائيات', left: 'center' },
          tooltip: { trigger: 'item' },
          legend: { orient: 'vertical', left: 'left' },
          series: [{
              name: 'البيانات',
              type: 'pie',
              radius: ['40%', '70%'],
              avoidLabelOverlap: false,
              label: {
                  show: true,
                  formatter: '{b}: {d}%',
                  fontSize: 10
              },
              labelLine: { show: true },
              data: [
                  { value: refund, name: `الإلغاءات ${allRefunds}` },
                  { value: Pay, name: `المدفوعات التامة ${allPayments}` }
              ]
          }]
      });
  }

  function renderPeakTimeChart() {
      const chartDom = document.getElementById('sales_chart');
      if (!chartDom) return;
      myChart4 = echarts.init(chartDom);

      const data = [];
      for (const day in peak_time) {
          for (let hour = 0; hour < 24; hour++) {
              const sales = peak_time[day][hour];
              if (sales > 0) {
                  data.push({
                      name: `${day} - ${hour}`,
                      value: [`${day} ${hour}:00`, sales]
                  });
              }
          }
      }

      myChart4.setOption({
          title: { text: 'مبيعات حسب الساعة خلال الأسبوع' },
          tooltip: { trigger: 'axis' },
          toolbox: {
              feature: {
                  dataZoom: { yAxisIndex: 'none' },
                  restore: {},
                  saveAsImage: {}
              }
          },
          dataZoom: [
              { type: 'slider', start: 0, end: 100 },
              { type: 'inside' }
          ],
          xAxis: {
              type: 'category',
              data: data.map(d => d.value[0]),
              name: 'اليوم - الساعة',
              axisLabel: { rotate: 45 }
          },
          yAxis: {
              type: 'value',
              name: 'عدد المبيعات'
          },
          series: [{
              data: data.map(d => d.value[1]),
              type: 'line',
              smooth: true,
              symbolSize: 8,
              lineStyle: { width: 3 }
          }]
      });
  }

  function renderAllCharts() {
      renderCharts();
      renderWeeklySalesChart();
      renderDonutChart();
      renderPeakTimeChart();
  }

  document.addEventListener("DOMContentLoaded", renderAllCharts);
  document.addEventListener("livewire:navigated", renderAllCharts);
  document.addEventListener("livewire:load", renderAllCharts);
  document.addEventListener("livewire:navigate", renderAllCharts);

  document.getElementById("export-all")?.addEventListener("click", function () {
      try {
          let csv = "الرسم,العنصر,القيمة\n";

          const donutData = donutChart?.getOption()?.series?.[0]?.data ?? [];
          donutData.forEach(item => {
              csv += `الإحصائيات,${item.name},${item.value}\n`;
          });

          const serviceData = chart?.getOption()?.series?.[0]?.data ?? [];
          serviceData.forEach(item => {
              csv += `الخدمات,${item.name},${item.value}\n`;
          });

          const salesOption = myChart?.getOption();
          const days = salesOption?.xAxis?.[0]?.data ?? [];
          const sales = salesOption?.series?.[0]?.data ?? [];
          days.forEach((day, i) => {
              csv += `المبيعات الأسبوعية,${day},${sales[i]}\n`;
          });

          const peakOption = myChart4?.getOption();
          const peakLabels = peakOption?.xAxis?.data ?? [];
          const peakSales = peakOption?.series?.[0]?.data ?? [];
          peakLabels.forEach((label, i) => {
              csv += `الذروة,${label},${peakSales[i]}\n`;
          });

          const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
          const url = URL.createObjectURL(blob);
          const a = document.createElement("a");
          a.href = url;
          a.download = "analytics-export.csv";
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
      } catch (err) {
          alert("حدث خطأ أثناء التصدير: " + err.message);
          console.error(err);
      }
  });
}
</script>




@endsection



