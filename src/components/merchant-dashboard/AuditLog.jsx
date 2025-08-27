import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { FilePlus, LogIn, UserCog, Wallet, Edit3, Trash2, Package, CalendarDays, Tag as TagIcon, GitBranch as BranchIcon } from 'lucide-react';
import { formatDistanceToNow } from 'date-fns';
import { ar } from 'date-fns/locale';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Search } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const ITEMS_PER_PAGE_LOGS = 10;

const AuditLogContent = ({ handleNavigation, handleFeatureClick }) => {
    const { toast } = useToast();
    const [logs, setLogs] = useState(JSON.parse(localStorage.getItem('lilium_night_audit_logs_v1')) || [
        { id: 'log-1', icon: FilePlus, action: 'إضافة خدمة جديدة', details: 'باقة تصوير زفاف فاخرة', user: 'علياء حسن (مشرف)', time: new Date(Date.now() - 10 * 60 * 1000).toISOString(), avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200', type: 'service_management' },
        { id: 'log-2', icon: Wallet, action: 'طلب سحب جديد', details: 'مبلغ 12,500 ريال', user: 'أنت (المالك)', time: new Date(Date.now() - 2 * 60 * 60 * 1000).toISOString(), avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200', type: 'finance' },
        { id: 'log-3', icon: UserCog, action: 'تعديل صلاحيات موظف', details: 'يوسف خالد -> دعم فني', user: 'علياء حسن (مشرف)', time: new Date(Date.now() - 24 * 60 * 60 * 1000).toISOString(), avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200', type: 'team_management' },
        { id: 'log-4', icon: LogIn, action: 'تسجيل دخول ناجح', details: 'من جهاز مكتبي (Chrome)', user: 'أنت (المالك)', time: new Date(Date.now() - 25 * 60 * 60 * 1000).toISOString(), avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200', type: 'security' },
        { id: 'log-5', icon: CalendarDays, action: 'تحديث إعدادات يوم', details: '2025-07-15 -> متاح', user: 'أنت (المالك)', time: new Date(Date.now() - 30 * 60 * 1000).toISOString(), avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200', type: 'booking_settings' },
        { id: 'log-6', icon: Package, action: 'إضافة باقة جديدة', details: 'باقة العيد لليوم 2025-07-15', user: 'أنت (المالك)', time: new Date(Date.now() - 28 * 60 * 1000).toISOString(), avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200', type: 'package_management' },
        { id: 'log-7', icon: TagIcon, action: 'إنشاء كود خصم', details: 'SUMMER25', user: 'علياء حسن (مشرف)', time: new Date(Date.now() - 5 * 60 * 60 * 1000).toISOString(), avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200', type: 'promotions' },
        { id: 'log-8', icon: BranchIcon, action: 'إضافة فرع جديد', details: 'فرع الدمام', user: 'أنت (المالك)', time: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000).toISOString(), avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200', type: 'branch_management' },
    ]);

    const [searchTerm, setSearchTerm] = useState('');
    const [userFilter, setUserFilter] = useState('all');
    const [actionTypeFilter, setActionTypeFilter] = useState('all');
    const [currentPage, setCurrentPage] = useState(1);

    useEffect(() => {
        localStorage.setItem('lilium_night_audit_logs_v1', JSON.stringify(logs));
    }, [logs]);

    const logActionTypes = {
        all: "كل الأنواع",
        service_management: "إدارة الخدمات",
        finance: "المالية والسحوبات",
        team_management: "إدارة الفريق",
        security: "الأمان وتسجيل الدخول",
        booking_settings: "إعدادات الحجوزات والتقويم",
        package_management: "إدارة الباقات",
        promotions: "العروض والخصومات",
        branch_management: "إدارة الفروع",
    };

    const uniqueUsers = ['all', ...new Set(logs.map(log => log.user))];

    const filteredLogs = logs
        .filter(log => 
            log.action.toLowerCase().includes(searchTerm.toLowerCase()) || 
            log.details.toLowerCase().includes(searchTerm.toLowerCase())
        )
        .filter(log => userFilter === 'all' || log.user === userFilter)
        .filter(log => actionTypeFilter === 'all' || log.type === actionTypeFilter)
        .sort((a, b) => new Date(b.time) - new Date(a.time));

    const totalPages = Math.ceil(filteredLogs.length / ITEMS_PER_PAGE_LOGS);
    const paginatedLogs = filteredLogs.slice((currentPage - 1) * ITEMS_PER_PAGE_LOGS, currentPage * ITEMS_PER_PAGE_LOGS);

    const getIconForType = (type) => {
        switch(type) {
            case 'service_management': return FilePlus;
            case 'finance': return Wallet;
            case 'team_management': return UserCog;
            case 'security': return LogIn;
            case 'booking_settings': return CalendarDays;
            case 'package_management': return Package;
            case 'promotions': return TagIcon;
            case 'branch_management': return BranchIcon;
            default: return FilePlus;
        }
    };
     const internalHandleFeatureClick = (featureName) => {
        if (handleFeatureClick && typeof handleFeatureClick === 'function') {
            handleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">سجل الأنشطة والتدقيق</h2>
            <Card>
                <CardHeader>
                    <CardTitle>سجل العمليات</CardTitle>
                    <CardDescription>تتبع كل التغييرات والعمليات التي تمت في حساب مزوّد الخدمة الخاص بك في منصة ليلة الليليوم.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="flex flex-wrap items-center gap-4 p-4 mb-6 bg-slate-50 rounded-lg">
                        <div className="relative flex-grow min-w-[200px]">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-500" />
                            <Input
                                placeholder="ابحث في تفاصيل الحدث..."
                                className="pl-10"
                                value={searchTerm}
                                onChange={(e) => { setSearchTerm(e.target.value); setCurrentPage(1); internalHandleFeatureClick(`البحث في السجل عن: ${e.target.value}`); }}
                            />
                        </div>
                        <Select value={userFilter} onValueChange={(value) => { setUserFilter(value); setCurrentPage(1); internalHandleFeatureClick(`فلترة السجل بالمستخدم: ${value}`); }} dir="rtl">
                            <SelectTrigger className="w-full md:w-[180px]">
                                <SelectValue placeholder="فلترة بالمستخدم" />
                            </SelectTrigger>
                            <SelectContent>
                                {uniqueUsers.map(user => (
                                    <SelectItem key={user} value={user}>{user === 'all' ? 'كل المستخدمين' : user}</SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        <Select value={actionTypeFilter} onValueChange={(value) => { setActionTypeFilter(value); setCurrentPage(1); internalHandleFeatureClick(`فلترة السجل بنوع الحدث: ${value}`); }} dir="rtl">
                            <SelectTrigger className="w-full md:w-[180px]">
                                <SelectValue placeholder="فلترة بنوع الحدث" />
                            </SelectTrigger>
                            <SelectContent>
                                {Object.entries(logActionTypes).map(([key, value]) => (
                                    <SelectItem key={key} value={key}>{value}</SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>

                    {paginatedLogs.length > 0 ? (
                        <div className="relative">
                            <div className="absolute left-5 top-0 h-full w-0.5 bg-slate-200 hidden md:block"></div>
                            <div className="space-y-8">
                                {paginatedLogs.map((log) => {
                                    const LogIcon = getIconForType(log.type);
                                    return (
                                    <div key={log.id} className="flex items-start gap-4 relative">
                                        <div className="w-11 h-11 bg-primary/10 rounded-full flex items-center justify-center z-10 ring-4 ring-background md:ring-slate-100 shrink-0">
                                            <LogIcon className="w-5 h-5 text-primary" />
                                        </div>
                                        <div className="flex-1 pt-1.5">
                                            <div className="flex flex-col md:flex-row justify-between md:items-center">
                                                <div>
                                                    <p className="font-semibold text-slate-800">{log.action}: <span className="font-normal text-slate-600">{log.details}</span></p>
                                                    <div className="flex items-center gap-2 text-sm text-slate-500 mt-1">
                                                        <Avatar className="w-6 h-6">
                                                            <AvatarImage src={log.avatar} />
                                                            <AvatarFallback>{log.user.charAt(0)}</AvatarFallback>
                                                        </Avatar>
                                                        <span>{log.user}</span>
                                                    </div>
                                                </div>
                                                <p className="text-sm text-slate-400 mt-1 md:mt-0">
                                                    {formatDistanceToNow(new Date(log.time), { addSuffix: true, locale: ar })}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                )})}
                            </div>
                        </div>
                    ) : (
                         <div className="text-center py-12 text-slate-500">
                            <Search className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                            <p className="text-xl font-semibold">لا توجد سجلات تطابق بحثك.</p>
                            <p>حاول تغيير فلاتر البحث أو انتظر حدوث أنشطة جديدة.</p>
                        </div>
                    )}

                    {totalPages > 1 && (
                        <div className="flex items-center justify-center pt-8 gap-2">
                            <Button variant="outline" size="sm" onClick={() => {setCurrentPage(p => Math.max(1, p - 1)); internalHandleFeatureClick("الانتقال للصفحة السابقة في السجل");}} disabled={currentPage === 1}>السابق</Button>
                            <span className="text-sm text-slate-600">صفحة {currentPage} من {totalPages}</span>
                            <Button variant="outline" size="sm" onClick={() => {setCurrentPage(p => Math.min(totalPages, p + 1)); internalHandleFeatureClick("الانتقال للصفحة التالية في السجل");}} disabled={currentPage === totalPages}>التالي</Button>
                        </div>
                    )}
                </CardContent>
            </Card>
        </div>
    );
};

export default AuditLogContent;