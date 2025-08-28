
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { CheckCircle2, XCircle, Clock, Banknote, Timer } from 'lucide-react';

const payoutRequests = [
    { merchant: 'مطعم الذواقة', amount: '2,500 ريال', date: '2023-10-25', status: 'بانتظار المراجعة', bank: 'البنك الأهلي - **** 1234' },
    { merchant: 'فعالية الشتاء', amount: '10,000 ريال', date: '2023-10-24', status: 'بانتظار المراجعة', bank: 'بنك الراجحي - **** 5678' },
    { merchant: 'تجربة الغوص', amount: '1,200 ريال', date: '2023-10-22', status: 'مكتملة', bank: 'بنك الرياض - **** 9012' },
    { merchant: 'مؤتمر TechCon', amount: '5,000 ريال', date: '2023-10-21', status: 'مرفوضة', bank: 'البنك السعودي الفرنسي - **** 3456' },
];

const PayoutsManagement = ({ handleFeatureClick }) => {
    const renderTable = (status) => (
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>التاجر</TableHead>
                    <TableHead>المبلغ</TableHead>
                    <TableHead>تاريخ الطلب</TableHead>
                    <TableHead>الحساب البنكي</TableHead>
                    {status === 'بانتظار المراجعة' && <TableHead className="text-left">إجراء</TableHead>}
                </TableRow>
            </TableHeader>
            <TableBody>
                {payoutRequests.filter(r => r.status === status).map((req) => (
                    <TableRow key={req.merchant}>
                        <TableCell className="font-medium">{req.merchant}</TableCell>
                        <TableCell>{req.amount}</TableCell>
                        <TableCell>{req.date}</TableCell>
                        <TableCell className="text-slate-500">{req.bank}</TableCell>
                        {status === 'بانتظار المراجعة' && (
                            <TableCell className="text-left">
                                <div className="flex gap-2 justify-end">
                                    <Button size="sm" variant="outline" className="text-emerald-600 border-emerald-600 hover:bg-emerald-50" onClick={() => handleFeatureClick(`الموافقة على سحب ${req.merchant}`)}><CheckCircle2 className="w-4 h-4 ml-2"/>موافقة</Button>
                                    <Button size="sm" variant="outline" className="text-red-600 border-red-600 hover:bg-red-50" onClick={() => handleFeatureClick(`رفض سحب ${req.merchant}`)}><XCircle className="w-4 h-4 ml-2"/>رفض</Button>
                                </div>
                            </TableCell>
                        )}
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">إدارة طلبات السحب</h1>
                <p className="text-slate-500 mt-1">مراجعة واعتماد طلبات سحب الأرصدة من التجار.</p>
            </div>

            <div className="grid md:grid-cols-3 gap-6">
                <Card><CardHeader><CardTitle className="flex items-center gap-2"><Banknote/>إجمالي المسحوب (الشهر)</CardTitle></CardHeader><CardContent className="text-3xl font-bold">120,750 ريال</CardContent></Card>
                <Card><CardHeader><CardTitle className="flex items-center gap-2"><Clock/>طلبات معلقة</CardTitle></CardHeader><CardContent className="text-3xl font-bold">2</CardContent></Card>
                <Card><CardHeader><CardTitle className="flex items-center gap-2"><Timer/>متوسط وقت التحويل</CardTitle></CardHeader><CardContent className="text-3xl font-bold">24 ساعة</CardContent></Card>
            </div>

            <Card>
                <Tabs defaultValue="pending">
                    <CardHeader>
                        <TabsList className="grid w-full grid-cols-3">
                            <TabsTrigger value="pending">بانتظار المراجعة</TabsTrigger>
                            <TabsTrigger value="completed">مكتملة</TabsTrigger>
                            <TabsTrigger value="rejected">مرفوضة</TabsTrigger>
                        </TabsList>
                    </CardHeader>
                    <CardContent>
                        <TabsContent value="pending">{renderTable('بانتظار المراجعة')}</TabsContent>
                        <TabsContent value="completed">{renderTable('مكتملة')}</TabsContent>
                        <TabsContent value="rejected">{renderTable('مرفوضة')}</TabsContent>
                    </CardContent>
                </Tabs>
            </Card>
        </div>
    );
};

export default PayoutsManagement;
