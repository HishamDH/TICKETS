
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Download } from 'lucide-react';

const payments = [
    { bookingId: '#1234', amount: '200 ريال', method: 'Visa **** 1234', date: '2025-11-15', status: 'مكتمل' },
    { bookingId: '#1235', amount: '150 ريال', method: 'Apple Pay', date: '2025-11-10', status: 'مكتمل' },
    { bookingId: '#1236', amount: '450 ريال', method: 'Visa **** 1234', date: '2025-10-20', status: 'مسترد' },
];

const PaymentHistory = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">السجل المالي</h1>
                <p className="text-slate-500 mt-1">جميع عمليات الدفع والاسترداد الخاصة بك.</p>
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>سجل العمليات</CardTitle>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>رقم الحجز</TableHead>
                                <TableHead>المبلغ</TableHead>
                                <TableHead>وسيلة الدفع</TableHead>
                                <TableHead>التاريخ</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead className="text-left">الفاتورة</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {payments.map((payment) => (
                                <TableRow key={payment.bookingId}>
                                    <TableCell className="font-medium">{payment.bookingId}</TableCell>
                                    <TableCell>{payment.amount}</TableCell>
                                    <TableCell>{payment.method}</TableCell>
                                    <TableCell>{payment.date}</TableCell>
                                    <TableCell><Badge variant={payment.status === 'مسترد' ? 'destructive' : 'default'}>{payment.status}</Badge></TableCell>
                                    <TableCell className="text-left">
                                        <Button variant="outline" size="sm" onClick={() => handleFeatureClick("تحميل الفاتورة")}><Download className="w-4 h-4 ml-2"/> تحميل</Button>
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

export default PaymentHistory;
