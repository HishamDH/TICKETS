import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { CheckCircle2, XCircle, Clock, Banknote, Timer, Download, Filter, Search } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const initialPayoutRequests = [
    { id: 'pr1', merchant: 'قصر الأفراح الملكية', amount: '12,500 ريال', date: '2025-06-15', status: 'بانتظار المراجعة', bank: 'البنك الأهلي - **** 1234', transactionId: null },
    { id: 'pr2', merchant: 'استوديو الإبداع للتصوير', amount: '8,000 ريال', date: '2025-06-14', status: 'بانتظار المراجعة', bank: 'بنك الراجحي - **** 5678', transactionId: null },
    { id: 'pr3', merchant: 'بوفيه الكرم للضيافة', amount: '5,200 ريال', date: '2025-06-12', status: 'مكتملة', bank: 'بنك الرياض - **** 9012', transactionId: 'TRX12345' },
    { id: 'pr4', merchant: 'زهور الربيع للتنسيق', amount: '3,000 ريال', date: '2025-06-11', status: 'مرفوضة', bank: 'البنك السعودي الفرنسي - **** 3456', transactionId: null, reason: 'معلومات بنكية غير صحيحة' },
];

const PayoutsManagement = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [payoutRequests, setPayoutRequests] = useState(initialPayoutRequests);
    const [searchTerm, setSearchTerm] = useState('');
    const [activeTab, setActiveTab] = useState('pending');

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

    const handlePayoutAction = (requestId, newStatus, reason = '') => {
        const request = payoutRequests.find(r => r.id === requestId);
        setPayoutRequests(prev => prev.map(req => 
            req.id === requestId ? { ...req, status: newStatus, reason: newStatus === 'مرفوضة' ? reason : req.reason, transactionId: newStatus === 'مكتملة' ? `TRX${Math.random().toString().slice(2,8)}` : null } : req
        ));
        handleFeatureClick(`تحديث حالة طلب السحب ${requestId} لـ ${request?.merchant} إلى "${newStatus}"`);
    };

    const filteredRequests = (status) => payoutRequests.filter(r => 
        r.status === status && 
        (r.merchant.toLowerCase().includes(searchTerm.toLowerCase()) || r.bank.toLowerCase().includes(searchTerm.toLowerCase()))
    );
    
    const renderTableContent = (status) => (
         <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>مزوّد الخدمة</TableHead>
                    <TableHead>المبلغ</TableHead>
                    <TableHead>تاريخ الطلب</TableHead>
                    <TableHead>الحساب البنكي</TableHead>
                    {status === 'مكتملة' && <TableHead>رقم العملية</TableHead>}
                    {status === 'مرفوضة' && <TableHead>سبب الرفض</TableHead>}
                    {status === 'بانتظار المراجعة' && <TableHead className="text-left">إجراء</TableHead>}
                </TableRow>
            </TableHeader>
            <TableBody>
                {filteredRequests(status).map((req) => (
                    <TableRow key={req.id}>
                        <TableCell className="font-medium">{req.merchant}</TableCell>
                        <TableCell>{req.amount}</TableCell>
                        <TableCell>{req.date}</TableCell>
                        <TableCell className="text-slate-500 text-xs">{req.bank}</TableCell>
                        {status === 'مكتملة' && <TableCell className="text-xs text-green-600">{req.transactionId}</TableCell>}
                        {status === 'مرفوضة' && <TableCell className="text-xs text-red-600">{req.reason}</TableCell>}
                        {status === 'بانتظار المراجعة' && (
                            <TableCell className="text-left">
                                <div className="flex gap-2 justify-end">
                                    <Button size="sm" variant="outline" className="text-emerald-600 border-emerald-600 hover:bg-emerald-50" onClick={() => handlePayoutAction(req.id, 'مكتملة')}><CheckCircle2 className="w-4 h-4 ml-2"/>موافقة</Button>
                                    <Button size="sm" variant="outline" className="text-red-600 border-red-600 hover:bg-red-50" onClick={() => handlePayoutAction(req.id, 'مرفوضة', 'بيانات غير كافية')}><XCircle className="w-4 h-4 ml-2"/>رفض</Button>
                                </div>
                            </TableCell>
                        )}
                    </TableRow>
                ))}
                {filteredRequests(status).length === 0 && (
                    <TableRow><TableCell colSpan={status === 'بانتظار المراجعة' ? 6 : (status === 'مكتملة' || status === 'مرفوضة' ? 5 : 4)} className="h-24 text-center">لا توجد طلبات تطابق البحث في هذه الفئة.</TableCell></TableRow>
                )}
            </TableBody>
        </Table>
    );

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">إدارة طلبات السحب</h1>
                <p className="text-slate-500 mt-1">مراجعة واعتماد طلبات سحب الأرصدة من مزوّدي الخدمات.</p>
            </div>

            <div className="grid md:grid-cols-3 gap-6">
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل إجمالي المسحوب")}>
                    <CardHeader><CardTitle className="flex items-center gap-2"><Banknote/>إجمالي المسحوب (الشهر)</CardTitle></CardHeader>
                    <CardContent className="text-3xl font-bold">120,750 ريال</CardContent>
                </Card>
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل الطلبات المعلقة")}>
                    <CardHeader><CardTitle className="flex items-center gap-2"><Clock/>طلبات معلقة</CardTitle></CardHeader>
                    <CardContent className="text-3xl font-bold">{payoutRequests.filter(r=>r.status === 'بانتظار المراجعة').length}</CardContent>
                </Card>
                <Card className="cursor-pointer hover:shadow-lg" onClick={() => handleFeatureClick("عرض تفاصيل متوسط وقت التحويل")}>
                    <CardHeader><CardTitle className="flex items-center gap-2"><Timer/>متوسط وقت التحويل</CardTitle></CardHeader>
                    <CardContent className="text-3xl font-bold">24 ساعة</CardContent>
                </Card>
            </div>

            <Card>
                <Tabs value={activeTab} onValueChange={setActiveTab}>
                    <CardHeader className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <TabsList className="grid w-full md:w-auto grid-cols-3">
                            <TabsTrigger value="pending" onClick={() => handleFeatureClick("عرض طلبات السحب المعلقة")}>بانتظار المراجعة</TabsTrigger>
                            <TabsTrigger value="completed" onClick={() => handleFeatureClick("عرض طلبات السحب المكتملة")}>مكتملة</TabsTrigger>
                            <TabsTrigger value="rejected" onClick={() => handleFeatureClick("عرض طلبات السحب المرفوضة")}>مرفوضة</TabsTrigger>
                        </TabsList>
                        <div className="flex gap-2 w-full md:w-auto">
                            <div className="relative flex-grow">
                                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input 
                                    placeholder="بحث بالتاجر أو البنك..." 
                                    className="pl-10 w-full"
                                    value={searchTerm}
                                    onChange={(e) => {setSearchTerm(e.target.value); handleFeatureClick(`البحث في طلبات السحب عن: ${e.target.value}`);}}
                                />
                            </div>
                            <Button variant="outline" onClick={() => handleFeatureClick("تصدير تقرير طلبات السحب")}><Download className="w-4 h-4 ml-2"/>تصدير</Button>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <TabsContent value="pending">{renderTableContent('بانتظار المراجعة')}</TabsContent>
                        <TabsContent value="completed">{renderTableContent('مكتملة')}</TabsContent>
                        <TabsContent value="rejected">{renderTableContent('مرفوضة')}</TabsContent>
                    </CardContent>
                </Tabs>
            </Card>
        </div>
    );
};

export default React.memo(PayoutsManagement);