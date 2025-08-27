import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { ShieldCheck, ShieldAlert, UserCheck, UserX, Globe, Search, Download, SlidersHorizontal } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const initialSecurityLogs = [
    { id: 'sl1', timestamp: '2025-06-26 10:30:15', eventType: 'تسجيل دخول ناجح', user: 'admin@lilium.sa', ip: '192.168.1.10', severity: 'منخفض' },
    { id: 'sl2', timestamp: '2025-06-26 09:15:45', eventType: 'محاولة تسجيل دخول فاشلة', user: 'hacker@evil.com', ip: '10.0.0.5', severity: 'مرتفع' },
    { id: 'sl3', timestamp: '2025-06-25 15:20:00', eventType: 'تغيير كلمة المرور', user: 'merchant_support@lilium.sa', ip: '172.16.0.20', severity: 'متوسط' },
    { id: 'sl4', timestamp: '2025-06-25 12:05:30', eventType: 'تحديث إعدادات النظام', user: 'admin@lilium.sa', ip: '192.168.1.10', severity: 'متوسط' },
    { id: 'sl5', timestamp: '2025-06-24 18:55:10', eventType: 'تسجيل دخول ناجح (شريك)', user: 'partner1@example.com', ip: '203.0.113.45', severity: 'منخفض' },
];

const severityBadges = {
    'منخفض': 'bg-emerald-100 text-emerald-800',
    'متوسط': 'bg-amber-100 text-amber-800',
    'مرتفع': 'bg-red-100 text-red-800',
};

const SecurityMonitoring = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [logs, setLogs] = useState(initialSecurityLogs);
    const [searchTerm, setSearchTerm] = useState('');
    const [severityFilter, setSeverityFilter] = useState('all');
    const [eventTypeFilter, setEventTypeFilter] = useState('all');

    const uniqueEventTypes = ['all', ...new Set(logs.map(log => log.eventType))];

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

    const filteredLogs = logs.filter(log => 
        (log.user.toLowerCase().includes(searchTerm.toLowerCase()) || log.ip.includes(searchTerm)) &&
        (severityFilter === 'all' || log.severity === severityFilter) &&
        (eventTypeFilter === 'all' || log.eventType === eventTypeFilter)
    );
    
    const handleExportLogs = () => {
        handleFeatureClick("تصدير السجلات الأمنية");
    };

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                 <div>
                    <h1 className="text-3xl font-bold text-slate-800 flex items-center gap-2"><ShieldCheck className="w-8 h-8 text-primary"/>مراقبة الأمان وسجل التدقيق</h1>
                    <p className="text-slate-500 mt-1">تتبع الأحداث الأمنية وسجلات الوصول للأنظمة الهامة.</p>
                </div>
                <Button variant="outline" onClick={handleExportLogs}><Download className="w-4 h-4 ml-2"/>تصدير السجلات</Button>
            </div>
            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل حالة النظام")}>
                    <CardHeader className="flex flex-row items-center justify-between pb-2"><CardTitle className="text-sm font-medium">حالة النظام</CardTitle><ShieldCheck className="h-4 w-4 text-emerald-500"/></CardHeader>
                    <CardContent><div className="text-2xl font-bold text-emerald-600">آمن ومستقر</div><p className="text-xs text-slate-500">آخر فحص: قبل 5 دقائق</p></CardContent>
                </Card>
                 <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل محاولات الدخول الفاشلة")}>
                    <CardHeader className="flex flex-row items-center justify-between pb-2"><CardTitle className="text-sm font-medium">محاولات دخول فاشلة (24س)</CardTitle><UserX className="h-4 w-4 text-red-500"/></CardHeader>
                    <CardContent><div className="text-2xl font-bold text-red-600">3</div><p className="text-xs text-slate-500">آخر محاولة: قبل 45 دقيقة</p></CardContent>
                </Card>
                 <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل الأجهزة المتصلة")}>
                    <CardHeader className="flex flex-row items-center justify-between pb-2"><CardTitle className="text-sm font-medium">الأجهزة المتصلة النشطة</CardTitle><UserCheck className="h-4 w-4 text-sky-500"/></CardHeader>
                    <CardContent><div className="text-2xl font-bold text-sky-600">12</div><p className="text-xs text-slate-500">من 5 دول مختلفة</p></CardContent>
                </Card>
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل التنبيهات الأمنية")}>
                    <CardHeader className="flex flex-row items-center justify-between pb-2"><CardTitle className="text-sm font-medium">تنبيهات أمنية (24س)</CardTitle><ShieldAlert className="h-4 w-4 text-amber-500"/></CardHeader>
                    <CardContent><div className="text-2xl font-bold text-amber-600">1</div><p className="text-xs text-slate-500">تنبيه متوسط الخطورة</p></CardContent>
                </Card>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>سجل الأحداث الأمنية</CardTitle>
                     <div className="flex flex-wrap gap-2 pt-4">
                        <div className="relative flex-grow">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                            <Input placeholder="بحث بالمستخدم أو IP..." className="pl-10" value={searchTerm} onChange={e => {setSearchTerm(e.target.value); handleFeatureClick(`البحث في السجلات الأمنية عن: ${e.target.value}`);}} />
                        </div>
                        <Select value={severityFilter} onValueChange={(val) => {setSeverityFilter(val); handleFeatureClick(`فلترة السجلات بالخطورة: ${val}`)}} dir="rtl">
                            <SelectTrigger className="w-full sm:w-[180px]">
                                <SlidersHorizontal className="h-4 w-4 ml-2" />
                                <SelectValue placeholder="فلترة بالخطورة" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">كل الخطورة</SelectItem>
                                {Object.keys(severityBadges).map(s => <SelectItem key={s} value={s}>{s}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        <Select value={eventTypeFilter} onValueChange={(val) => {setEventTypeFilter(val); handleFeatureClick(`فلترة السجلات بنوع الحدث: ${val}`)}} dir="rtl">
                            <SelectTrigger className="w-full sm:w-[200px]">
                                <SlidersHorizontal className="h-4 w-4 ml-2" />
                                <SelectValue placeholder="فلترة بنوع الحدث" />
                            </SelectTrigger>
                            <SelectContent>
                                {uniqueEventTypes.map(type => <SelectItem key={type} value={type}>{type === 'all' ? 'كل أنواع الأحداث' : type}</SelectItem>)}
                            </SelectContent>
                        </Select>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>الوقت</TableHead>
                                <TableHead>نوع الحدث</TableHead>
                                <TableHead>المستخدم</TableHead>
                                <TableHead>عنوان IP</TableHead>
                                <TableHead>الخطورة</TableHead>
                                <TableHead className="text-left">تفاصيل</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredLogs.map((log) => (
                                <TableRow key={log.id}>
                                    <TableCell className="text-xs text-slate-500">{log.timestamp}</TableCell>
                                    <TableCell>{log.eventType}</TableCell>
                                    <TableCell className="font-medium">{log.user}</TableCell>
                                    <TableCell>{log.ip}</TableCell>
                                    <TableCell><Badge className={severityBadges[log.severity] || 'bg-slate-100 text-slate-800'}>{log.severity}</Badge></TableCell>
                                    <TableCell className="text-left">
                                        <Button variant="ghost" size="sm" onClick={() => handleFeatureClick(`عرض تفاصيل السجل الأمني ${log.id}`)}>عرض</Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                            {filteredLogs.length === 0 && <TableRow><TableCell colSpan={6} className="h-24 text-center">لا توجد سجلات تطابق الفلاتر.</TableCell></TableRow>}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    );
};

export default SecurityMonitoring;