
import React from 'react';
import { motion } from 'framer-motion';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { DollarSign, CheckCircle, XCircle, Clock } from 'lucide-react';

const payouts = [
  { id: 'PAY-1034', date: '2023-06-05', amount: '3,500.00 ر.س', status: 'مكتمل' },
  { id: 'PAY-1033', date: '2023-05-05', amount: '5,120.50 ر.س', status: 'مكتمل' },
  { id: 'PAY-1032', date: '2023-04-04', amount: '2,800.00 ر.س', status: 'مرفوض' },
  { id: 'PAY-1031', date: '2023-03-06', amount: '4,200.00 ر.س', status: 'مكتمل' },
];

const getStatusBadge = (status) => {
    switch (status) {
        case 'مكتمل': return <Badge className="bg-green-100 text-green-700"><CheckCircle className="w-4 h-4 ml-1"/>مكتمل</Badge>;
        case 'بانتظار': return <Badge className="bg-yellow-100 text-yellow-700"><Clock className="w-4 h-4 ml-1"/>بانتظار</Badge>;
        case 'مرفوض': return <Badge className="bg-red-100 text-red-700"><XCircle className="w-4 h-4 ml-1"/>مرفوض</Badge>;
        default: return <Badge variant="outline">{status}</Badge>;
    }
};

const Payouts = ({handleFeatureClick}) => {
    return (
        <motion.div 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
            className="space-y-6"
        >
            <div className="grid gap-6 md:grid-cols-2">
                <Card className="shadow-lg bg-gradient-to-br from-green-50 to-green-100 border-green-200">
                    <CardHeader>
                        <CardTitle className="text-green-800">الرصيد القابل للسحب</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p className="text-4xl font-bold text-green-700">4,850.75 ر.س</p>
                        <p className="text-sm text-green-600 mt-2">سيتم إضافة الأرباح الجديدة بعد 24 ساعة من كل عملية.</p>
                    </CardContent>
                </Card>
                 <Card className="shadow-lg bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
                    <CardHeader>
                        <CardTitle className="text-blue-800">الرصيد المعلّق</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p className="text-4xl font-bold text-blue-700">1,230.00 ر.س</p>
                        <p className="text-sm text-blue-600 mt-2">هذا الرصيد قيد المراجعة وسيتاح قريباً.</p>
                    </CardContent>
                </Card>
            </div>
            
            <Button size="lg" className="w-full md:w-auto" onClick={handleFeatureClick}>
                <DollarSign className="w-5 h-5 ml-2" />
                طلب سحب الرصيد المتاح
            </Button>

            <Card className="shadow-lg">
                <CardHeader>
                    <CardTitle>سجل السحوبات</CardTitle>
                    <CardDescription>
                        قائمة بجميع طلبات السحب التي قمت بها.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>معرف الطلب</TableHead>
                                <TableHead>التاريخ</TableHead>
                                <TableHead>المبلغ</TableHead>
                                <TableHead>الحالة</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {payouts.map((payout, index) => (
                                <TableRow key={index}>
                                    <TableCell className="font-mono">{payout.id}</TableCell>
                                    <TableCell>{payout.date}</TableCell>
                                    <TableCell className="font-semibold">{payout.amount}</TableCell>
                                    <TableCell>{getStatusBadge(payout.status)}</TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </motion.div>
    );
};

export default Payouts;
