
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Eye, XCircle, Edit, Star } from 'lucide-react';

const bookings = [
    { type: 'تذكرة فعالية', event: 'فعالية الشتاء', date: '2025-12-16', status: 'مدفوع', category: 'active' },
    { type: 'حجز طاولة', event: 'مطعم الذواقة', date: '2025-12-20', status: 'مؤكد', category: 'active' },
    { type: 'تجربة', event: 'تجربة الغوص', date: '2025-11-05', status: 'مستخدم', category: 'past' },
    { type: 'Badge مؤتمر', event: 'مؤتمر TechCon', date: '2025-10-15', status: 'ملغي', category: 'cancelled' },
];

const statusBadges = { 'مدفوع': 'bg-emerald-100 text-emerald-800', 'مؤكد': 'bg-sky-100 text-sky-800', 'مستخدم': 'bg-slate-100 text-slate-800', 'ملغي': 'bg-red-100 text-red-800' };

const CustomerBookings = ({ handleFeatureClick }) => {
    const renderTable = (category) => (
        <Table>
            <TableHeader><TableRow><TableHead>النوع</TableHead><TableHead>الفعالية/التاجر</TableHead><TableHead>التاريخ</TableHead><TableHead>الحالة</TableHead><TableHead className="text-left">إجراءات</TableHead></TableRow></TableHeader>
            <TableBody>
                {bookings.filter(b => b.category === category).map((booking) => (
                    <TableRow key={booking.event}>
                        <TableCell className="font-medium">{booking.type}</TableCell>
                        <TableCell>{booking.event}</TableCell>
                        <TableCell>{booking.date}</TableCell>
                        <TableCell><Badge className={statusBadges[booking.status]}>{booking.status}</Badge></TableCell>
                        <TableCell className="text-left flex gap-1 justify-end">
                            <Button variant="ghost" size="icon" onClick={() => handleFeatureClick("عرض")}><Eye className="w-4 h-4"/></Button>
                            {booking.category === 'active' && <Button variant="ghost" size="icon" onClick={() => handleFeatureClick("تعديل")}><Edit className="w-4 h-4"/></Button>}
                            {booking.category === 'active' && <Button variant="ghost" size="icon" className="text-red-500" onClick={() => handleFeatureClick("إلغاء")}><XCircle className="w-4 h-4"/></Button>}
                             {booking.category === 'past' && <Button variant="ghost" size="icon" className="text-amber-500" onClick={() => handleFeatureClick("تقييم")}><Star className="w-4 h-4"/></Button>}
                        </TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">حجوزاتي</h1>
                <p className="text-slate-500 mt-1">جميع حجوزاتك السابقة والقادمة.</p>
            </div>
            <Card>
                <Tabs defaultValue="active">
                    <CardHeader>
                        <TabsList className="grid w-full grid-cols-4">
                            <TabsTrigger value="active">✅ النشطة</TabsTrigger>
                            <TabsTrigger value="past">🔴 منتهية</TabsTrigger>
                            <TabsTrigger value="cancelled">❌ ملغاة</TabsTrigger>
                            <TabsTrigger value="today">🟡 قيد الاستخدام</TabsTrigger>
                        </TabsList>
                    </CardHeader>
                    <CardContent>
                        <TabsContent value="active">{renderTable('active')}</TabsContent>
                        <TabsContent value="past">{renderTable('past')}</TabsContent>
                        <TabsContent value="cancelled">{renderTable('cancelled')}</TabsContent>
                         <TabsContent value="today"><div className="text-center p-8 text-slate-500">لا توجد حجوزات مستخدمة حالياً.</div></TabsContent>
                    </CardContent>
                </Tabs>
            </Card>
        </div>
    );
};

export default CustomerBookings;
