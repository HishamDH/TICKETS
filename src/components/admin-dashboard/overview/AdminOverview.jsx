import React, { useState } from 'react';
import StatCard from '@/components/admin-dashboard/overview/StatCard';
import RevenueChart from '@/components/admin-dashboard/overview/RevenueChart';
import RecentActivity from '@/components/admin-dashboard/overview/RecentActivity';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { SlidersHorizontal } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const AdminOverview = ({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [filters, setFilters] = useState({
        category: 'all',
        branch: 'all',
        provider: 'all',
    });

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

    const handleFilterChange = (filterName, value) => {
        setFilters(prev => ({ ...prev, [filterName]: value }));
        handleFeatureClick(`فلترة نظرة عامة حسب ${filterName}: ${value}`);
    };

    const categories = [{value: 'all', label: 'كل الفئات'}, {value: 'venues', label: 'قاعات'}, {value: 'catering', label: 'إعاشة'}, {value: 'photography', label: 'تصوير'}];
    const branches = [{value: 'all', label: 'كل الفروع'}, {value: 'riyadh', label: 'فرع الرياض'}, {value: 'jeddah', label: 'فرع جدة'}];
    const providers = [{value: 'all', label: 'كل المزودين'}, {value: 'provider1', label: 'قاعة الأفراح الملكية'}, {value: 'provider2', label: 'استوديو الإبداع'}];

    return (
        <div className="space-y-6">
            <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h2 className="text-3xl font-bold">نظرة عامة على المنصة</h2>
                <div className="flex items-center gap-2 w-full md:w-auto">
                    <SlidersHorizontal className="w-5 h-5 text-slate-500" />
                    <Select dir="rtl" value={filters.category} onValueChange={(value) => handleFilterChange('category', value)}>
                        <SelectTrigger className="w-full md:w-[150px]"><SelectValue /></SelectTrigger>
                        <SelectContent>{categories.map(c => <SelectItem key={c.value} value={c.value}>{c.label}</SelectItem>)}</SelectContent>
                    </Select>
                    <Select dir="rtl" value={filters.branch} onValueChange={(value) => handleFilterChange('branch', value)}>
                        <SelectTrigger className="w-full md:w-[150px]"><SelectValue /></SelectTrigger>
                        <SelectContent>{branches.map(b => <SelectItem key={b.value} value={b.value}>{b.label}</SelectItem>)}</SelectContent>
                    </Select>
                    <Select dir="rtl" value={filters.provider} onValueChange={(value) => handleFilterChange('provider', value)}>
                        <SelectTrigger className="w-full md:w-[180px]"><SelectValue /></SelectTrigger>
                        <SelectContent>{providers.map(p => <SelectItem key={p.value} value={p.value}>{p.label}</SelectItem>)}</SelectContent>
                    </Select>
                </div>
            </div>
            <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <StatCard title="إجمالي الإيرادات" iconType="revenue" filters={filters} />
                <StatCard title="الحجوزات الجديدة" iconType="bookings" filters={filters} />
                <StatCard title="المستخدمون النشطون" iconType="users" filters={filters} />
                <StatCard title="متوسط قيمة الحجز" iconType="avg_booking" filters={filters} />
            </div>
            <div className="grid gap-6 lg:grid-cols-3">
                <div className="lg:col-span-2">
                    <RevenueChart filters={filters} />
                </div>
                <div>
                    <RecentActivity filters={filters} />
                </div>
            </div>
        </div>
    );
};

export default React.memo(AdminOverview);