import React from 'react';
import { motion } from 'framer-motion';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { Users } from 'lucide-react';

const referrals = [
  { name: 'قصر الأفراح الملكي', status: 'مفعل', joinDate: '2025-06-01', totalSales: '125,000 ر.س', commission: '6,250 ر.س' },
  { name: 'استوديو العدسة الذهبية (تصوير)', status: 'مفعل', joinDate: '2025-05-20', totalSales: '30,000 ر.س', commission: '1,500 ر.س' },
  { name: 'مطابخ النخبة (إعاشة)', status:'معلّق', joinDate: '2025-06-10', totalSales: '0 ر.س', commission: '0 ر.س' },
  { name: 'صالون الجمال الأنيق', status: 'مفعل', joinDate: '2025-04-15', totalSales: '15,500 ر.س', commission: '775 ر.س' },
  { name: 'شركة تنظيم الحفلات الماسية', status: 'موقوف', joinDate: '2025-03-01', totalSales: '8,000 ر.س', commission: '400 ر.س' },
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
                        <span>مزوّدو الخدمات المسجلون عبرك</span>
                    </CardTitle>
                    <CardDescription>
                        قائمة بجميع مزوّدي الخدمات الذين انضموا للمنصة باستخدام رابط الإحالة الخاص بك.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>اسم مزوّد الخدمة</TableHead>
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