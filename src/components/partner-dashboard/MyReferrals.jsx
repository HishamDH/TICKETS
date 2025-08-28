
import React from 'react';
import { motion } from 'framer-motion';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { Users } from 'lucide-react';

const referrals = [
  { name: 'مقهى القمة', status: 'مفعل', joinDate: '2023-06-01', totalSales: '45,000 ر.س', commission: '2,250 ر.س' },
  { name: 'فعاليات الرياض', status: 'مفعل', joinDate: '2023-05-20', totalSales: '120,000 ر.س', commission: '6,000 ر.س' },
  { name: 'تجربة الصحراء', status: 'معلّق', joinDate: '2023-06-10', totalSales: '0 ر.س', commission: '0 ر.س' },
  { name: 'معرض الفن الحديث', status: 'مفعل', joinDate: '2023-04-15', totalSales: '78,500 ر.س', commission: '3,925 ر.س' },
  { name: 'مطعم الأفق', status: 'موقوف', joinDate: '2023-03-01', totalSales: '12,300 ر.س', commission: '615 ر.س' },
  { name: 'مهرجان الربيع', status: 'مفعل', joinDate: '2023-05-05', totalSales: '250,000 ر.س', commission: '12,500 ر.س' },
];

const getStatusBadge = (status) => {
    switch (status) {
        case 'مفعل': return <Badge variant="default" className="bg-green-500">مفعل</Badge>;
        case 'معلّق': return <Badge variant="secondary" className="bg-yellow-500 text-white">معلّق</Badge>;
        case 'موقوف': return <Badge variant="destructive">موقوف</Badge>;
        default: return <Badge variant="outline">{status}</Badge>;
    }
};

const MyReferrals = () => {
    return (
        <motion.div 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
        >
            <Card className="shadow-lg">
                <CardHeader>
                    <CardTitle className="flex items-center gap-2">
                        <Users className="w-6 h-6 text-primary"/>
                        <span>التجار المسجلون عبرك</span>
                    </CardTitle>
                    <CardDescription>
                        قائمة بجميع التجار الذين انضموا للمنصة باستخدام رابط الإحالة الخاص بك.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>اسم التاجر</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead>تاريخ الانضمام</TableHead>
                                <TableHead>إجمالي المبيعات</TableHead>
                                <TableHead>عمولتك</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {referrals.map((referral, index) => (
                                <TableRow key={index}>
                                    <TableCell className="font-medium">{referral.name}</TableCell>
                                    <TableCell>{getStatusBadge(referral.status)}</TableCell>
                                    <TableCell>{referral.joinDate}</TableCell>
                                    <TableCell>{referral.totalSales}</TableCell>
                                    <TableCell className="text-green-600 font-semibold">{referral.commission}</TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </motion.div>
    );
};

export default MyReferrals;
