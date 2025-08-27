import React, { useState, useEffect, useMemo, memo } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { TrendingUp, Ticket, Wallet, Package as PackageIcon, Clock, BarChart2 } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { isAfter, startOfToday, parseISO } from 'date-fns';

const OverviewContent = memo(({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [stats, setStats] = useState({
        totalRevenue: 0,
        upcomingBookings: 0,
        availableBalance: 0,
        totalPackages: 0,
    });

    useEffect(() => {
        const bookings = JSON.parse(localStorage.getItem('lilium_night_all_bookings_v1')) || [];
        const wallet = JSON.parse(localStorage.getItem('lilium_night_wallet_v1')) || { currentBalance: 0 };
        const packages = JSON.parse(localStorage.getItem('lilium_night_packages_by_date_v3')) || {};

        const totalRevenue = bookings
            .filter(b => b.status === 'paid' || b.status === 'used' || b.status === 'completed' || b.status === 'awaiting_confirmation')
            .reduce((sum, b) => sum + (b.amount || 0), 0);

        const upcomingBookings = bookings
            .filter(b => b.date && isAfter(parseISO(b.date), startOfToday())).length;
        
        const totalPackages = Object.values(packages).reduce((sum, dayPkgs) => sum + dayPkgs.length, 0);

        setStats({
            totalRevenue: totalRevenue,
            upcomingBookings: upcomingBookings,
            availableBalance: wallet.currentBalance || 0,
            totalPackages: totalPackages,
        });

    }, []);
    
    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick && typeof propHandleFeatureClick === 'function') {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
                variant: "default",
            });
        }
    };

    const statCards = useMemo(() => [
        { title: "إجمالي الإيرادات", value: stats.totalRevenue.toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'}), icon: TrendingUp, color: "from-green-400 to-emerald-500", action: () => handleFeatureClick("view_sales_report") },
        { title: "الحجوزات القادمة", value: stats.upcomingBookings, icon: Clock, color: "from-blue-400 to-sky-500", action: () => handleFeatureClick("view_active_bookings") },
        { title: "الرصيد المتاح للسحب", value: stats.availableBalance.toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'}), icon: Wallet, color: "gradient-bg", action: () => handleFeatureClick("view_wallet") },
        { title: "إجمالي الباقات المنشأة", value: stats.totalPackages, icon: PackageIcon, color: "from-amber-400 to-orange-500", action: () => handleFeatureClick("view_all_packages") }
    ], [stats, handleFeatureClick]);

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">نظرة عامة على حساب مزوّد الخدمة</h2>
            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                {statCards.map((stat, index) => (
                    <Card key={index} className="card-hover cursor-pointer" onClick={stat.action}>
                        <CardHeader className="flex flex-row items-center justify-between pb-2">
                            <CardTitle className="text-sm font-medium text-slate-500">{stat.title}</CardTitle>
                            <div className={`w-8 h-8 flex items-center justify-center rounded-lg text-white bg-gradient-to-br ${stat.color}`}>
                                <stat.icon className="h-5 w-5" />
                            </div>
                        </CardHeader>
                        <CardContent>
                            <p className="text-3xl font-bold text-slate-900">{stat.value}</p>
                        </CardContent>
                    </Card>
                ))}
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>الإشعارات والتنبيهات الجديدة</CardTitle>
                </CardHeader>
                <CardContent>
                     <p className="text-slate-500">لا توجد إشعارات جديدة حالياً. كل الأمور تسير على ما يرام!</p>
                </CardContent>
            </Card>
        </div>
    );
});

export default OverviewContent;