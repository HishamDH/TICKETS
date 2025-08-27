import React, { useMemo, memo } from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { ResponsiveContainer, BarChart, CartesianGrid, XAxis, YAxis, Tooltip, Legend, Bar, PieChart, Pie, Cell } from 'recharts';
import { format, getMonth, getYear } from 'date-fns';
import { ar } from "date-fns/locale";
import { useToast } from "@/components/ui/use-toast";

const COLORS = ['#0088FE', '#00C49F', '#FFBB28', '#FF8042', '#8884D8', '#82Ca9D'];

const SalesReport = memo(({ bookings, handleFeatureClick: propHandleFeatureClick }) => {
  const { toast } = useToast();
  const handleFeatureClick = (featureName) => {
    if (propHandleFeatureClick && typeof propHandleFeatureClick === 'function') {
        propHandleFeatureClick(featureName);
    } else {
        toast({
            title: "🚧 ميزة قيد التطوير",
            description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
        });
    }
  };

  const salesBySource = useMemo(() => {
    const onlineSales = bookings.filter(b => b.online).reduce((sum, b) => sum + b.amount, 0);
    const internalSales = bookings.filter(b => !b.online).reduce((sum, b) => sum + b.amount, 0);
    return [
      { name: 'مبيعات أونلاين', value: onlineSales },
      { name: 'مبيعات داخلية', value: internalSales },
    ];
  }, [bookings]);

  const monthlySalesComparison = useMemo(() => {
    const monthlyData = {};
    const currentYear = getYear(new Date());

    bookings.forEach(booking => {
      const bookingDate = new Date(booking.date);
      if (getYear(bookingDate) !== currentYear) return; 

      const month = format(bookingDate, 'MMMM', { locale: ar });
      if (!monthlyData[month]) {
        monthlyData[month] = { name: month, online: 0, internal: 0 };
      }
      if (booking.online) {
        monthlyData[month].online += booking.amount;
      } else {
        monthlyData[month].internal += booking.amount;
      }
    });
    
    return Object.values(monthlyData).sort((a,b) => 
        getMonth(new Date(currentYear, Object.keys(monthlyData).find(key => monthlyData[key] === a))) - 
        getMonth(new Date(currentYear, Object.keys(monthlyData).find(key => monthlyData[key] === b)))
    );
  }, [bookings]);

  const totalOnlineBookings = bookings.filter(b => b.online).length;
  const totalInternalBookings = bookings.filter(b => !b.online).length;

  return (
    <div className="space-y-6">
      <Card className="shadow-lg border-t-4 border-accent">
        <CardHeader>
          <CardTitle className="text-2xl font-bold">تقرير المبيعات المقارن</CardTitle>
          <CardDescription>
            نظرة عامة على أداء مبيعاتك عبر الإنترنت والمبيعات الداخلية.
          </CardDescription>
        </CardHeader>
      </Card>

      <div className="grid md:grid-cols-2 gap-6">
        <Card>
          <CardHeader>
            <CardTitle>إجمالي المبيعات حسب المصدر</CardTitle>
          </CardHeader>
          <CardContent className="h-80">
            <ResponsiveContainer width="100%" height="100%">
              <PieChart>
                <Pie
                  data={salesBySource}
                  cx="50%"
                  cy="50%"
                  labelLine={false}
                  label={({ name, percent, value }) => `${name}: ${(percent * 100).toFixed(0)}% (${value.toLocaleString('ar-SA')} ريال)`}
                  outerRadius={100}
                  fill="#8884d8"
                  dataKey="value"
                >
                  {salesBySource.map((entry, index) => (
                    <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
                  ))}
                </Pie>
                <Tooltip formatter={(value) => `${value.toLocaleString('ar-SA')} ريال`} />
                <Legend />
              </PieChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>
        <Card>
            <CardHeader><CardTitle>إحصائيات سريعة</CardTitle></CardHeader>
            <CardContent className="space-y-4">
                <div className="flex justify-between items-center p-3 bg-sky-50 rounded-lg">
                    <span className="font-semibold">إجمالي مبيعات الأونلاين:</span>
                    <span className="text-lg font-bold text-sky-600">{salesBySource.find(s=>s.name === 'مبيعات أونلاين')?.value.toLocaleString('ar-SA') || 0} ريال</span>
                </div>
                <div className="flex justify-between items-center p-3 bg-emerald-50 rounded-lg">
                    <span className="font-semibold">إجمالي المبيعات الداخلية:</span>
                    <span className="text-lg font-bold text-emerald-600">{salesBySource.find(s=>s.name === 'مبيعات داخلية')?.value.toLocaleString('ar-SA') || 0} ريال</span>
                </div>
                 <div className="flex justify-between items-center p-3 bg-indigo-50 rounded-lg">
                    <span className="font-semibold">عدد حجوزات الأونلاين:</span>
                    <span className="text-lg font-bold text-indigo-600">{totalOnlineBookings} حجز</span>
                </div>
                <div className="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                    <span className="font-semibold">عدد الحجوزات الداخلية:</span>
                    <span className="text-lg font-bold text-purple-600">{totalInternalBookings} حجز</span>
                </div>
            </CardContent>
        </Card>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>مقارنة المبيعات الشهرية (أونلاين مقابل داخلي) - السنة الحالية</CardTitle>
        </CardHeader>
        <CardContent className="h-96">
          <ResponsiveContainer width="100%" height="100%">
            <BarChart data={monthlySalesComparison}>
              <CartesianGrid strokeDasharray="3 3" vertical={false} />
              <XAxis dataKey="name" fontSize={12} />
              <YAxis fontSize={12} tickFormatter={(value) => `${value / 1000} ألف`} />
              <Tooltip formatter={(value) => `${value.toLocaleString('ar-SA')} ريال`} />
              <Legend />
              <Bar dataKey="online" name="أونلاين" fill={COLORS[0]} radius={[4, 4, 0, 0]} />
              <Bar dataKey="internal" name="داخلي" fill={COLORS[1]} radius={[4, 4, 0, 0]} />
            </BarChart>
          </ResponsiveContainer>
        </CardContent>
      </Card>
    </div>
  );
});

export default SalesReport;