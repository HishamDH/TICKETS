import React, { useState, useMemo, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Download, Filter, Search, CalendarDays, ArrowUpCircle, ArrowDownCircle, DollarSign, TrendingUp, Percent } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Popover, PopoverTrigger, PopoverContent } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { format, parseISO, isAfter, isBefore } from 'date-fns';
import { ar } from 'date-fns/locale';
import { cn } from '@/lib/utils';

const initialTransactions = [
    { id: 'TXN-001', date: '2025-06-15T11:30:00Z', type: 'sale', service: 'باقة الزفاف الملكية', amount: 12000, commission: 360, net: 11640 },
    { id: 'TXN-002', date: '2025-06-14T15:00:00Z', type: 'sale', service: 'تصوير حفل تخرج', amount: 3500, commission: 105, net: 3395 },
    { id: 'TXN-003', date: '2025-06-13T18:00:00Z', type: 'refund', service: 'باقة الزفاف الملكية', amount: -12000, commission: -360, net: -11640 },
    { id: 'TXN-004', date: '2025-06-12T09:45:00Z', type: 'sale', service: 'تجهيز جناح معرض', amount: 8500, commission: 255, net: 8245 },
    { id: 'TXN-005', date: '2025-06-11T12:00:00Z', type: 'sale', service: 'استئجار ملعب كرة القدم', amount: 1500, commission: 45, net: 1455 },
];

const ITEMS_PER_PAGE = 10;

const PaymentHistoryContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [transactions, setTransactions] = useState(JSON.parse(localStorage.getItem('lilium_night_transactions_v1')) || initialTransactions);
    const [searchTerm, setSearchTerm] = useState('');
    const [typeFilter, setTypeFilter] = useState('all');
    const [dateRange, setDateRange] = useState({ from: undefined, to: undefined });
    const [currentPage, setCurrentPage] = useState(1);

    useEffect(() => {
        localStorage.setItem('lilium_night_transactions_v1', JSON.stringify(transactions));
    }, [transactions]);
    
    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick) {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    const filteredTransactions = useMemo(() => {
        return transactions
            .filter(t => typeFilter === 'all' || t.type === typeFilter)
            .filter(t => 
                t.service.toLowerCase().includes(searchTerm.toLowerCase()) ||
                t.id.toLowerCase().includes(searchTerm.toLowerCase())
            )
            .filter(t => {
                if (!dateRange.from && !dateRange.to) return true;
                const transactionDate = parseISO(t.date);
                if (dateRange.from && isBefore(transactionDate, dateRange.from)) return false;
                if (dateRange.to && isAfter(transactionDate, dateRange.to)) return false;
                return true;
            })
            .sort((a, b) => new Date(b.date) - new Date(a.date));
    }, [transactions, searchTerm, typeFilter, dateRange]);

    const totalPages = Math.ceil(filteredTransactions.length / ITEMS_PER_PAGE);
    const paginatedTransactions = filteredTransactions.slice((currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE);
    
    const summary = useMemo(() => {
        const totalSales = filteredTransactions.filter(t => t.type === 'sale').reduce((acc, t) => acc + t.amount, 0);
        const totalRefunds = filteredTransactions.filter(t => t.type === 'refund').reduce((acc, t) => acc + t.amount, 0);
        const totalCommission = filteredTransactions.reduce((acc, t) => acc + t.commission, 0);
        const netIncome = totalSales + totalRefunds - totalCommission;
        return { totalSales, totalRefunds, totalCommission, netIncome };
    }, [filteredTransactions]);
    

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">سجل المدفوعات والعمولات</h2>
            
            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <Card>
                    <CardHeader><CardTitle className="flex items-center gap-2 text-sm font-medium"><TrendingUp className="w-5 h-5 text-green-500"/>إجمالي المبيعات</CardTitle></CardHeader>
                    <CardContent className="text-3xl font-bold">{summary.totalSales.toLocaleString('ar-SA', {style:'currency', currency:'SAR'})}</CardContent>
                </Card>
                <Card>
                    <CardHeader><CardTitle className="flex items-center gap-2 text-sm font-medium"><ArrowDownCircle className="w-5 h-5 text-red-500"/>إجمالي المرتجعات</CardTitle></CardHeader>
                    <CardContent className="text-3xl font-bold">{Math.abs(summary.totalRefunds).toLocaleString('ar-SA', {style:'currency', currency:'SAR'})}</CardContent>
                </Card>
                <Card>
                    <CardHeader><CardTitle className="flex items-center gap-2 text-sm font-medium"><Percent className="w-5 h-5 text-orange-500"/>إجمالي العمولات</CardTitle></CardHeader>
                    <CardContent className="text-2xl font-bold">{summary.totalCommission.toLocaleString('ar-SA', {style:'currency', currency:'SAR'})}</CardContent>
                </Card>
                <Card>
                    <CardHeader><CardTitle className="flex items-center gap-2 text-sm font-medium"><DollarSign className="w-5 h-5 text-primary"/>صافي الدخل</CardTitle></CardHeader>
                    <CardContent className="text-2xl font-bold">{summary.netIncome.toLocaleString('ar-SA', {style:'currency', currency:'SAR'})}</CardContent>
                </Card>
            </div>

            <Card>
                <CardHeader>
                    <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <CardTitle>سجل العمليات المالية</CardTitle>
                        <div className="flex items-center gap-2 w-full md:w-auto">
                            <div className="relative flex-grow">
                                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input placeholder="بحث بالخدمة أو رقم العملية..." className="pl-10" value={searchTerm} onChange={e => { setSearchTerm(e.target.value); setCurrentPage(1); handleFeatureClick(`البحث في سجل المدفوعات عن: ${e.target.value}`)}}/>
                            </div>
                            <Popover>
                                <PopoverTrigger asChild>
                                  <Button id="date" variant={"outline"} className={cn("w-full md:w-[250px] justify-start text-left font-normal", !dateRange.from && "text-muted-foreground")} onClick={() => handleFeatureClick("فتح محدد نطاق التاريخ لسجل المدفوعات")}>
                                    <CalendarDays className="ml-2 h-4 w-4" />
                                    {dateRange.from ? (dateRange.to ? (<>{format(dateRange.from, "LLL dd, y", { locale: ar })} - {format(dateRange.to, "LLL dd, y", { locale: ar })}</>) : format(dateRange.from, "LLL dd, y", { locale: ar })) : (<span>فلترة بالتاريخ</span>)}
                                  </Button>
                                </PopoverTrigger>
                                <PopoverContent className="w-auto p-0" align="end"><Calendar initialFocus mode="range" defaultMonth={dateRange?.from} selected={dateRange} onSelect={range => { setDateRange(range); handleFeatureClick("تغيير نطاق التاريخ لسجل المدفوعات"); }} numberOfMonths={2} locale={ar}/></PopoverContent>
                            </Popover>
                            <Select value={typeFilter} onValueChange={value => { setTypeFilter(value); setCurrentPage(1); handleFeatureClick(`فلترة سجل المدفوعات بالنوع: ${value}`); }} dir="rtl">
                                <SelectTrigger className="w-[150px]"><SelectValue /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">كل الأنواع</SelectItem>
                                    <SelectItem value="sale">مبيعات</SelectItem>
                                    <SelectItem value="refund">مرتجعات</SelectItem>
                                </SelectContent>
                            </Select>
                            <Button variant="outline" onClick={() => handleFeatureClick("تصدير سجل المدفوعات")}><Download className="w-4 h-4 ml-2"/>تصدير</Button>
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>النوع</TableHead>
                                <TableHead>رقم العملية</TableHead>
                                <TableHead>التاريخ</TableHead>
                                <TableHead>الخدمة</TableHead>
                                <TableHead className="text-right">المبلغ</TableHead>
                                <TableHead className="text-right">العمولة</TableHead>
                                <TableHead className="text-right">صافي المبلغ</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {paginatedTransactions.map((t) => (
                                <TableRow key={t.id}>
                                    <TableCell>
                                        <div className={`flex items-center gap-2 ${t.type === 'sale' ? 'text-green-600' : 'text-red-600'}`}>
                                            {t.type === 'sale' ? <ArrowUpCircle className="w-4 h-4"/> : <ArrowDownCircle className="w-4 h-4"/>}
                                            {t.type === 'sale' ? 'بيع' : 'إرجاع'}
                                        </div>
                                    </TableCell>
                                    <TableCell className="font-mono text-xs">{t.id}</TableCell>
                                    <TableCell>{format(parseISO(t.date), 'PPP p', { locale: ar })}</TableCell>
                                    <TableCell>{t.service}</TableCell>
                                    <TableCell className="text-right font-semibold">{t.amount.toLocaleString('ar-SA', {style:'currency', currency:'SAR'})}</TableCell>
                                    <TableCell className="text-right text-orange-600">({t.commission.toLocaleString('ar-SA', {style:'currency', currency:'SAR'})})</TableCell>
                                    <TableCell className="text-right font-bold text-primary">{t.net.toLocaleString('ar-SA', {style:'currency', currency:'SAR'})}</TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
                {totalPages > 1 && (
                    <CardFooter className="flex items-center justify-center pt-6 gap-2">
                        <Button variant="outline" size="sm" onClick={() => { setCurrentPage(p => Math.max(1, p - 1)); handleFeatureClick("الانتقال للصفحة السابقة في سجل المدفوعات"); }} disabled={currentPage === 1}>السابق</Button>
                        <span className="text-sm text-slate-600">صفحة {currentPage} من {totalPages}</span>
                        <Button variant="outline" size="sm" onClick={() => { setCurrentPage(p => Math.min(totalPages, p + 1)); handleFeatureClick("الانتقال للصفحة التالية في سجل المدفوعات"); }} disabled={currentPage === totalPages}>التالي</Button>
                    </CardFooter>
                )}
            </Card>
        </div>
    );
});

export default PaymentHistoryContent;