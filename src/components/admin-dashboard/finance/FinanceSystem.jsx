import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { CheckCircle2, XCircle, Wallet, Percent, Download, SlidersHorizontal, CalendarDays } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Popover, PopoverTrigger, PopoverContent } from '@/components/ui/popover';
import { Calendar } from '@/components/ui/calendar';
import { format, parseISO } from 'date-fns';
import { ar } from 'date-fns/locale';
import { cn } from '@/lib/utils';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const initialWithdrawalRequests = [
    { id: 'wr1', merchant: 'مطعم الذواقة', amount: '2,500 ريال', date: '2025-06-25', status: 'معلق', bankDetails: 'بنك الرياض **** 1122' },
    { id: 'wr2', merchant: 'فعالية الشتاء', amount: '10,000 ريال', date: '2025-06-24', status: 'معلق', bankDetails: 'البنك الأهلي **** 3344' },
    { id: 'wr3', merchant: 'تجربة الغوص', amount: '1,200 ريال', date: '2025-06-22', status: 'مكتمل', bankDetails: 'بنك الراجحي **** 5566' },
    { id: 'wr4', merchant: 'قاعة الأفراح الملكية', amount: '15,000 ريال', date: '2025-06-20', status: 'مرفوض', bankDetails: 'بنك البلاد **** 7788', reason: 'معلومات بنكية غير صحيحة' },
];

const FinanceSystem = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [withdrawalRequests, setWithdrawalRequests] = useState(initialWithdrawalRequests);
    const [platformBalance, setPlatformBalance] = useState(1250430.50);
    const [monthlyCommissions, setMonthlyCommissions] = useState(45231.80);
    const [dateFilter, setDateFilter] = useState(null);
    const [statusFilter, setStatusFilter] = useState('all');

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

    const handleWithdrawalAction = (requestId, newStatus) => {
        setWithdrawalRequests(prev => prev.map(req => 
            req.id === requestId ? { ...req, status: newStatus } : req
        ));
        handleFeatureClick(`تحديث حالة طلب السحب ${requestId} إلى ${newStatus}`);
    };

    const filteredRequests = withdrawalRequests.filter(req => {
        const matchesDate = !dateFilter || (req.date && format(parseISO(req.date), 'yyyy-MM-dd') === format(dateFilter, 'yyyy-MM-dd'));
        const matchesStatus = statusFilter === 'all' || req.status === statusFilter;
        return matchesDate && matchesStatus;
    });

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">النظام المالي</h1>
                <p className="text-slate-500 mt-1">إدارة طلبات السحب، العمولات، والسجلات المالية.</p>
            </div>

            <div className="grid md:grid-cols-2 gap-6">
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل الرصيد العام")}>
                    <CardHeader className="flex flex-row items-center justify-between pb-2">
                        <CardTitle className="text-sm font-medium">الرصيد العام للمنصة</CardTitle>
                        <Wallet className="w-4 h-4 text-slate-500" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{platformBalance.toLocaleString('ar-SA', { style: 'currency', currency: 'SAR' })}</div>
                        <p className="text-xs text-slate-500">+20.1% من الشهر الماضي</p>
                    </CardContent>
                </Card>
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل العمولات")}>
                    <CardHeader className="flex flex-row items-center justify-between pb-2">
                        <CardTitle className="text-sm font-medium">إجمالي العمولات (الشهر)</CardTitle>
                        <Percent className="w-4 h-4 text-slate-500" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{monthlyCommissions.toLocaleString('ar-SA', { style: 'currency', currency: 'SAR' })}</div>
                        <p className="text-xs text-slate-500">+15.2% من الشهر الماضي</p>
                    </CardContent>
                </Card>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>طلبات السحب</CardTitle>
                    <CardDescription>مراجعة والموافقة على طلبات سحب الأرصدة من التجار.</CardDescription>
                    <div className="flex flex-wrap gap-2 pt-4">
                        <Popover>
                            <PopoverTrigger asChild>
                                <Button variant="outline" className={cn("w-full sm:w-[200px] justify-start text-left font-normal", !dateFilter && "text-muted-foreground")} onClick={()=>handleFeatureClick("فتح فلتر التاريخ لطلبات السحب")}>
                                    <CalendarDays className="ml-2 h-4 w-4" />
                                    {dateFilter ? format(dateFilter, "PPP", { locale: ar }) : <span>فلترة بالتاريخ</span>}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent className="w-auto p-0">
                                <Calendar mode="single" selected={dateFilter} onSelect={(date) => {setDateFilter(date); handleFeatureClick(`فلترة طلبات السحب بالتاريخ: ${date ? format(date, "PPP", { locale: ar }) : 'إلغاء'}`)}} initialFocus locale={ar} />
                                {dateFilter && <Button variant="ghost" className="w-full" onClick={() => {setDateFilter(null); handleFeatureClick("مسح فلتر تاريخ طلبات السحب")}}>مسح الفلتر</Button>}
                            </PopoverContent>
                        </Popover>
                        <Select value={statusFilter} onValueChange={(val) => {setStatusFilter(val); handleFeatureClick(`فلترة طلبات السحب بالحالة: ${val}`)}} dir="rtl">
                           <SelectTrigger className="w-full sm:w-auto"> <SelectValue placeholder="فلترة بالحالة" /></SelectTrigger>
                           <SelectContent>
                                <SelectItem value="all">كل الحالات</SelectItem>
                                <SelectItem value="معلق">معلق</SelectItem>
                                <SelectItem value="مكتمل">مكتمل</SelectItem>
                                <SelectItem value="مرفوض">مرفوض</SelectItem>
                           </SelectContent>
                        </Select>
                        <Button variant="outline" onClick={() => handleFeatureClick("تصدير تقرير طلبات السحب")}><Download className="w-4 h-4 ml-2"/>تصدير</Button>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>التاجر</TableHead>
                                <TableHead>المبلغ</TableHead>
                                <TableHead>تاريخ الطلب</TableHead>
                                <TableHead>الحساب البنكي</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead className="text-left">إجراء</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredRequests.map((req) => (
                                <TableRow key={req.id}>
                                    <TableCell className="font-medium">{req.merchant}</TableCell>
                                    <TableCell>{req.amount}</TableCell>
                                    <TableCell>{format(parseISO(req.date), 'yyyy/MM/dd', { locale: ar })}</TableCell>
                                    <TableCell className="text-xs text-slate-500">{req.bankDetails}</TableCell>
                                    <TableCell><Badge variant={req.status === 'معلق' ? 'destructive' : (req.status === 'مكتمل' ? 'default' : 'outline')}>{req.status}</Badge></TableCell>
                                    <TableCell className="text-left">
                                        {req.status === 'معلق' && (
                                            <div className="flex gap-2 justify-end">
                                                <Button size="sm" variant="outline" className="text-emerald-600 border-emerald-600 hover:bg-emerald-50" onClick={() => handleWithdrawalAction(req.id, 'مكتمل')}><CheckCircle2 className="w-4 h-4 ml-2"/>موافقة</Button>
                                                <Button size="sm" variant="outline" className="text-red-600 border-red-600 hover:bg-red-50" onClick={() => handleWithdrawalAction(req.id, 'مرفوض')}><XCircle className="w-4 h-4 ml-2"/>رفض</Button>
                                            </div>
                                        )}
                                        {req.status === 'مرفوض' && <span className="text-xs text-red-500">{req.reason}</span>}
                                    </TableCell>
                                </TableRow>
                            ))}
                            {filteredRequests.length === 0 && (
                                <TableRow>
                                    <TableCell colSpan={6} className="h-24 text-center">
                                        لا توجد طلبات سحب تطابق الفلاتر.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    );
};

export default React.memo(FinanceSystem);