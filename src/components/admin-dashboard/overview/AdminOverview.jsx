
import React from 'react';
import StatCard from './StatCard';
import RevenueChart from './RevenueChart';
import RecentActivity from './RecentActivity';
import { BookCopy, TrendingUp, Users, Wallet } from 'lucide-react';

const AdminOverview = ({ handleFeatureClick }) => {
    const stats = [
        { title: 'إجمالي الحجوزات (الشهر)', value: '1,280', icon: BookCopy, color: 'text-sky-500', bgColor: 'bg-sky-50' },
        { title: 'إجمالي الإيرادات (الشهر)', value: '95,430 ريال', icon: Wallet, color: 'text-emerald-500', bgColor: 'bg-emerald-50' },
        { title: 'تجار جدد (الشهر)', value: '12', icon: Users, color: 'text-amber-500', bgColor: 'bg-amber-50' },
        { title: 'طلبات سحب معلقة', value: '8', icon: TrendingUp, color: 'text-red-500', bgColor: 'bg-red-50' },
    ];
    return (
        <div className="space-y-8">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">نظرة عامة</h1>
                <p className="text-slate-500 mt-1">مرحباً بعودتك! إليك آخر المستجدات في المنصة.</p>
            </div>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {stats.map((stat, index) => (
                    <StatCard key={index} {...stat} handleFeatureClick={handleFeatureClick}/>
                ))}
            </div>
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div className="lg:col-span-2">
                    <RevenueChart handleFeatureClick={handleFeatureClick}/>
                </div>
                <div>
                    <RecentActivity handleFeatureClick={handleFeatureClick}/>
                </div>
            </div>
        </div>
    );
};

export default AdminOverview;
