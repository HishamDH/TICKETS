
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Search, Download, FileWarning } from 'lucide-react';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const bookings = [
    { id: '#1234', merchant: 'مطعم الذواقة', customer: 'خالد العلي', amount: '150 ريال', status: 'مدفوع' },
    { id: '#1235', merchant: 'فعالية الشتاء', customer: 'سارة محمد', amount: '200 ريال', status: 'مستخدم' },
    { id: '#1236', merchant: 'تجربة الغوص', customer: 'أحمد ياسر', amount: '450 ريال', status: 'ملغي من العميل' },
    { id: '#1237', merchant: 'مؤتمر TechCon', customer: 'نورة عبدالله', amount: '100 ريال', status: 'قيد النزاع' },
];

const statusBadges = {
    'مدفوع': 'bg-emerald-100 text-emerald-800',
    'مستخدم': 'bg-slate-100 text-slate-800',
    'ملغي من العميل': 'bg-orange-100 text-orange-800',
    'قيد النزاع': 'bg-red-100 text-red-800',
};

const AdminBookingsManagement = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">إدارة الحجوزات العامة</h1>
                    <p className="text-slate-500 mt-1">عرض شامل لجميع الحجوزات في النظام والتدخل عند الحاجة.</p>
                </div>
                <Button variant="outline" onClick={() => handleFeatureClick("تصدير تقرير الحجوزات")}><Download className="w-4 h-4 ml-2"/>تصدير تقرير</Button>
            </div>

            <Card>
                <CardHeader>
                    <div className="flex justify-between items-center">
                        <CardTitle>سجل الحجوزات</CardTitle>
                        <div className="flex items-center gap-2">
                            <div className="relative w-64">
                                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input placeholder="بحث برقم الحجز أو العميل..." className="pl-10" />
                            </div>
                            <Select>
                                <SelectTrigger className="w-[180px]">
                                    <SelectValue placeholder="فلترة حسب الحالة" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">الكل</SelectItem>
                                    <SelectItem value="paid">مدفوع</SelectItem>
                                    <SelectItem value="disputed">قيد النزاع</SelectItem>
                                    <SelectItem value="cancelled">ملغي</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>رقم الحجز</TableHead>
                                <TableHead>التاجر</TableHead>
                                <TableHead>العميل</TableHead>
                                <TableHead>المبلغ</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead className="text-left">إجراء</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {bookings.map((booking) => (
                                <TableRow key={booking.id}>
                                    <TableCell className="font-medium">{booking.id}</TableCell>
                                    <TableCell>{booking.merchant}</TableCell>
                                    <TableCell>{booking.customer}</TableCell>
                                    <TableCell>{booking.amount}</TableCell>
                                    <TableCell><Badge className={statusBadges[booking.status]}>{booking.status}</Badge></TableCell>
                                    <TableCell className="text-left">
                                        <Button variant="ghost" size="sm" onClick={() => handleFeatureClick(`مراجعة حجز ${booking.id}`)}>
                                            <FileWarning className="w-4 h-4 ml-2"/> مراجعة
                                        </Button>
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

export default AdminBookingsManagement;
