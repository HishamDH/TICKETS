import React, { useState, useEffect, useMemo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Download, User, Package, TrendingUp, BarChart as BarIcon, Users as UsersIcon, PieChart as PieIcon, LineChart as LineIcon } from 'lucide-react';
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid, PieChart as RePieChart, Pie, Cell, Legend, LineChart as ReLineChart, Line } from 'recharts';
import { useToast } from "@/components/ui/use-toast";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { format, parseISO, startOfMonth, endOfMonth, eachMonthOfInterval, subMonths } from 'date-fns';
import { ar } from 'date-fns/locale';

const CANCELLATION_COLORS = ['#f59e0b', '#ef4444', '#64748b'];
const CATEGORY_COLORS = ['#8884d8', '#82ca9d', '#ffc658', '#ff8042', '#00C49F', '#0088FE', '#FFBB28'];

const CustomTooltip = ({ active, payload, label }) => {
  if (active && payload && payload.length) {
    return (
      <div className="bg-white p-3 border rounded-lg shadow-lg text-sm">
        <p className="font-bold text-slate-700">{label}</p>
        {payload.map(pld => (
            <p key={pld.dataKey} style={{color: pld.fill || pld.stroke}}>
                {pld.name}: {pld.value.toLocaleString('ar-SA')} {pld.dataKey === 'revenue' || pld.dataKey === 'sales' ? 'ريال' : ''}
            </p>
        ))}
      </div>
    );
  }
  return null;
};

const ReportsAnalytics = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [bookings, setBookings] = useState([]);
    const [merchants, setMerchants] = useState([]);

    useEffect(() => {
        const storedBookings = JSON.parse(localStorage.getItem('lilium_night_all_bookings_v1')) || [];
        const storedMerchants = JSON.parse(localStorage.getItem('lilium_night_merchants_v1')) || [
            { id: 'merch1', name: 'قصر الأفراح الملكية', type: 'قاعة مناسبات' },
            { id: 'merch2', name: 'استوديو الإبداع للتصوير', type: 'تصوير فوتوغرافي وفيديو' },
            { id: 'merch3', name: 'بوفيه الكرم للضيافة', type: 'إعاشة وبوفيه' },
        ];
        setBookings(storedBookings);
        setMerchants(storedMerchants);
    }, []);

    const analyticsData = useMemo(() => {
        const now = new Date();
        const last30DaysStart = subMonths(now, 1);

        const recentBookings = bookings.filter(b => parseISO(b.date) >= last30DaysStart);
        const totalRevenue = recentBookings.reduce((sum, b) => sum + b.amount, 0);
        const totalBookingsCount = recentBookings.length;
        const avgBookingValue = totalBookingsCount > 0 ? totalRevenue / totalBookingsCount : 0;

        const merchantSalesData = merchants.map(merchant => {
            const merchantBookings = bookings.filter(b => b.serviceType === merchant.name);
            const sales = merchantBookings.reduce((sum, b) => sum + b.amount, 0);
            return { name: merchant.name, sales, bookings: merchantBookings.length };
        }).sort((a, b) => b.sales - a.sales).slice(0, 5);

        const cancellationData = [
            { name: 'إلغاء من العميل', value: bookings.filter(b => b.status === 'cancelled_by_user').length },
            { name: 'إلغاء من مزوّد الخدمة', value: bookings.filter(b => b.status === 'cancelled_by_merchant').length },
            { name: 'أخرى', value: bookings.filter(b => b.status === 'cancelled' || b.status === 'refunded_full').length },
        ].filter(d => d.value > 0);

        const monthlyInterval = { start: startOfMonth(subMonths(now, 5)), end: endOfMonth(now) };
        const monthlyTrendData = eachMonthOfInterval(monthlyInterval).map(monthStart => {
            const monthEnd = endOfMonth(monthStart);
            const monthBookings = bookings.filter(b => {
                const bookingDate = parseISO(b.date);
                return bookingDate >= monthStart && bookingDate <= monthEnd;
            });
            const revenue = monthBookings.reduce((sum, b) => sum + b.amount, 0);
            return {
                month: format(monthStart, 'MMM', { locale: ar }),
                bookings: monthBookings.length,
                revenue,
            };
        });

        const serviceCategoryPerformance = merchants.reduce((acc, merchant) => {
            const category = merchant.type;
            if (!acc[category]) {
                acc[category] = { category, bookings: 0, revenue: 0 };
            }
            const merchantBookings = bookings.filter(b => b.serviceType === merchant.name);
            acc[category].bookings += merchantBookings.length;
            acc[category].revenue += merchantBookings.reduce((sum, b) => sum + b.amount, 0);
            return acc;
        }, {});

        return {
            totalRevenue,
            totalBookingsCount,
            avgBookingValue,
            activeMerchantsCount: merchants.length,
            merchantSalesData,
            cancellationData,
            monthlyTrendData,
            serviceCategoryPerformance: Object.values(serviceCategoryPerformance),
        };
    }, [bookings, merchants]);

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

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">التقارير والتحليلات الذكية</h1>
                    <p className="text-slate-500 mt-1">بيانات تفصيلية حول أداء منصة ليلة الليليوم ومزوّدي الخدمات.</p>
                </div>
                <div className="flex gap-2">
                    <Select onValueChange={(value) => handleFeatureClick(`تصدير تقرير ${value}`)} dir="rtl">
                        <SelectTrigger className="w-[180px]">
                            <SelectValue placeholder="تصدير تقرير محدد" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all_merchants">أداء كل التجار</SelectItem>
                            <SelectItem value="cancellations">أسباب الإلغاء</SelectItem>
                            <SelectItem value="monthly_trends">الاتجاهات الشهرية</SelectItem>
                            <SelectItem value="category_performance">أداء فئات الخدمات</SelectItem>
                        </SelectContent>
                    </Select>
                    <Button variant="outline" onClick={() => handleFeatureClick("تصدير كل التقارير")}><Download className="w-4 h-4 ml-2"/>تصدير الكل</Button>
                </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل إجمالي الإيرادات")}>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">إجمالي الإيرادات (آخر 30 يوم)</CardTitle>
                        <TrendingUp className="h-4 w-4 text-muted-foreground text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{analyticsData.totalRevenue.toLocaleString('ar-SA', { style: 'currency', currency: 'SAR' })}</div>
                    </CardContent>
                </Card>
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل إجمالي الحجوزات")}>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">إجمالي الحجوزات (آخر 30 يوم)</CardTitle>
                        <Package className="h-4 w-4 text-muted-foreground text-blue-500" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{analyticsData.totalBookingsCount.toLocaleString('ar-SA')} حجز</div>
                    </CardContent>
                </Card>
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل متوسط قيمة الحجز")}>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">متوسط قيمة الحجز</CardTitle>
                        <BarIcon className="h-4 w-4 text-muted-foreground text-purple-500" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{analyticsData.avgBookingValue.toLocaleString('ar-SA', { style: 'currency', currency: 'SAR' })}</div>
                    </CardContent>
                </Card>
                 <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل عدد مزودي الخدمات")}>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">عدد مزوّدي الخدمات النشطين</CardTitle>
                        <UsersIcon className="h-4 w-4 text-muted-foreground text-orange-500" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{analyticsData.activeMerchantsCount.toLocaleString('ar-SA')} مزوّد</div>
                    </CardContent>
                </Card>
            </div>
            
            <div className="grid lg:grid-cols-3 gap-6">
                <Card className="lg:col-span-2">
                    <CardHeader>
                        <CardTitle>الاتجاهات الشهرية للحجوزات والإيرادات</CardTitle>
                    </CardHeader>
                    <CardContent className="h-96">
                        <ResponsiveContainer width="100%" height="100%">
                            <ReLineChart data={analyticsData.monthlyTrendData} margin={{ top: 5, right: 20, left: -10, bottom: 5 }}>
                                <CartesianGrid strokeDasharray="3 3" vertical={false} />
                                <XAxis dataKey="month" stroke="#888888" fontSize={12} />
                                <YAxis yAxisId="left" stroke="#888888" fontSize={12} tickFormatter={(value) => `${(value / 1000).toLocaleString('ar-SA')} ألف`} />
                                <YAxis yAxisId="right" orientation="right" stroke="#888888" fontSize={12} />
                                <Tooltip content={<CustomTooltip />} />
                                <Legend />
                                <Line yAxisId="left" type="monotone" dataKey="revenue" name="الإيرادات (ريال)" stroke="var(--color-primary)" strokeWidth={2} dot={{ r: 4 }} activeDot={{ r: 6 }} />
                                <Line yAxisId="right" type="monotone" dataKey="bookings" name="الحجوزات" stroke="#82ca9d" strokeWidth={2} dot={{ r: 4 }} activeDot={{ r: 6 }} />
                            </ReLineChart>
                        </ResponsiveContainer>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>تحليل أسباب إلغاء الحجوزات</CardTitle>
                    </CardHeader>
                    <CardContent className="h-96">
                        <ResponsiveContainer width="100%" height="100%">
                            <RePieChart>
                                <Pie data={analyticsData.cancellationData} dataKey="value" nameKey="name" cx="50%" cy="50%" outerRadius={100} labelLine={false} label={({ name, percent }) => `${name}: ${(percent * 100).toFixed(0)}%`}>
                                    {analyticsData.cancellationData.map((entry, index) => (
                                        <Cell key={`cell-${index}`} fill={CANCELLATION_COLORS[index % CANCELLATION_COLORS.length]} />
                                    ))}
                                </Pie>
                                <Tooltip content={<CustomTooltip />} />
                                <Legend />
                            </RePieChart>
                        </ResponsiveContainer>
                    </CardContent>
                </Card>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>مقارنة أداء مزوّدي الخدمات (الأعلى دخلاً)</CardTitle>
                </CardHeader>
                <CardContent className="h-96">
                    <ResponsiveContainer width="100%" height="100%">
                        <BarChart data={analyticsData.merchantSalesData} layout="vertical" margin={{ right: 20, left: 80 }}>
                            <CartesianGrid strokeDasharray="3 3" horizontal={false} />
                            <XAxis type="number" fontSize={12} tickFormatter={(value) => `${(value / 1000).toLocaleString('ar-SA')} ألف`} />
                            <YAxis type="category" dataKey="name" width={120} fontSize={12} />
                            <Tooltip content={<CustomTooltip />} cursor={{ fill: 'rgba(99, 102, 241, 0.1)' }} />
                            <Legend />
                            <Bar dataKey="sales" fill="var(--color-primary)" radius={[0, 4, 4, 0]} name="المبيعات (ريال)" />
                            <Bar dataKey="bookings" fill="#82ca9d" radius={[0, 4, 4, 0]} name="الحجوزات" />
                        </BarChart>
                    </ResponsiveContainer>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>أداء فئات الخدمات (حسب الإيرادات)</CardTitle>
                </CardHeader>
                <CardContent className="h-96">
                     <ResponsiveContainer width="100%" height="100%">
                        <RePieChart>
                            <Pie dataKey="revenue" data={analyticsData.serviceCategoryPerformance} nameKey="category" cx="50%" cy="50%" outerRadius={120} label={({ category, percent }) => `${category} (${(percent * 100).toFixed(0)}%)`}>
                                {analyticsData.serviceCategoryPerformance.map((entry, index) => (
                                    <Cell key={`cell-${index}`} fill={CATEGORY_COLORS[index % CATEGORY_COLORS.length]} />
                                ))}
                            </Pie>
                            <Tooltip content={<CustomTooltip />} />
                            <Legend />
                        </RePieChart>
                    </ResponsiveContainer>
                </CardContent>
            </Card>
        </div>
    );
};

export default ReportsAnalytics;