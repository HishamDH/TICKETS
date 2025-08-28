import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { CheckCircle2, XCircle, Wallet, Percent } from 'lucide-react';

const withdrawalRequests = [
    { merchant: 'مطعم الذواقة', amount: '2,500 ريال', date: '2023-10-25', status: 'معلق' },
    { merchant: 'فعالية الشتاء', amount: '10,000 ريال', date: '2023-10-24', status: 'معلق' },
    { merchant: 'تجربة الغوص', amount: '1,200 ريال', date: '2023-10-22', status: 'مكتمل' },
];

const FinanceSystem = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">النظام المالي</h1>
                <p className="text-slate-500 mt-1">إدارة طلبات السحب، العمولات، والسجلات المالية.</p>
            </div>

            <div className="grid md:grid-cols-2 gap-6">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between pb-2">
                        <CardTitle className="text-sm font-medium">الرصيد العام للمنصة</CardTitle>
                        <Wallet className="w-4 h-4 text-slate-500" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">1,250,430.50 ريال</div>
                        <p className="text-xs text-slate-500">+20.1% من الشهر الماضي</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between pb-2">
                        <CardTitle className="text-sm font-medium">إجمالي العمولات (الشهر)</CardTitle>
                        <Percent className="w-4 h-4 text-slate-500" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">45,231.80 ريال</div>
                        <p className="text-xs text-slate-500">+15.2% من الشهر الماضي</p>
                    </CardContent>
                </Card>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>طلبات السحب المعلقة</CardTitle>
                    <CardDescription>مراجعة والموافقة على طلبات سحب الأرصدة من التجار.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>التاجر</TableHead>
                                <TableHead>المبلغ</TableHead>
                                <TableHead>تاريخ الطلب</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead className="text-left">إجراء</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {withdrawalRequests.map((req) => (
                                <TableRow key={req.merchant}>
                                    <TableCell className="font-medium">{req.merchant}</TableCell>
                                    <TableCell>{req.amount}</TableCell>
                                    <TableCell>{req.date}</TableCell>
                                    <TableCell><Badge variant={req.status === 'معلق' ? 'destructive' : 'default'}>{req.status}</Badge></TableCell>
                                    <TableCell className="text-left">
                                        {req.status === 'معلق' && (
                                            <div className="flex gap-2 justify-end">
                                                <Button size="sm" variant="outline" className="text-emerald-600 border-emerald-600 hover:bg-emerald-50" onClick={() => handleFeatureClick(`الموافقة على سحب ${req.merchant}`)}><CheckCircle2 className="w-4 h-4 ml-2"/>موافقة</Button>
                                                <Button size="sm" variant="outline" className="text-red-600 border-red-600 hover:bg-red-50" onClick={() => handleFeatureClick(`رفض سحب ${req.merchant}`)}><XCircle className="w-4 h-4 ml-2"/>رفض</Button>
                                            </div>
                                        )}
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    );
};

export default FinanceSystem;