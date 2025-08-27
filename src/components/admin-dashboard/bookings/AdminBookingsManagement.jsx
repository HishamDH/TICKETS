import React, { useState, useMemo, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Input } from "@/components/ui/input";
import { Globe, Pencil } from 'lucide-react';
import { format, parseISO } from 'date-fns';
import { ar } from 'date-fns/locale';

const statusMap = {
    paid: { label: 'مدفوع', color: 'bg-green-100 text-green-800' },
    awaiting_confirmation: { label: 'بانتظار التأكيد', color: 'bg-yellow-100 text-yellow-800' },
    used: { label: 'مستخدم', color: 'bg-blue-100 text-blue-800' },
    pending: { label: 'داخلي', color: 'bg-gray-100 text-gray-800' },
    cancelled_by_user: { label: 'ملغي (عميل)', color: 'bg-red-100 text-red-800' },
    cancelled_by_merchant: { label: 'ملغي (تاجر)', color: 'bg-red-100 text-red-800' },
    refunded_full: { label: 'مسترجع', color: 'bg-purple-100 text-purple-800' },
    expired: { label: 'منتهي', color: 'bg-gray-100 text-gray-800' },
    no_show: { label: 'لم يحضر', color: 'bg-orange-100 text-orange-800' },
    completed: { label: 'مكتمل', color: 'bg-blue-100 text-blue-800' },
    cancelled: { label: 'ملغي', color: 'bg-red-100 text-red-800' },
};

const sourceMap = {
    online: { label: 'أونلاين', icon: <Globe className="w-4 h-4 text-blue-500" /> },
    manual: { label: 'يدوي', icon: <Pencil className="w-4 h-4 text-orange-500" /> },
};

const AdminBookingsManagement = ({ handleFeatureClick }) => {
    const [bookings, setBookings] = useState([]);
    const [searchTerm, setSearchTerm] = useState('');
    const [sourceFilter, setSourceFilter] = useState('all');

    useEffect(() => {
        const storedBookings = JSON.parse(localStorage.getItem('lilium_night_all_bookings_v1')) || [];
        setBookings(storedBookings);
    }, []);

    const filteredBookings = useMemo(() => {
        return bookings.filter(booking => {
            const matchesSearch = (booking.customer?.toLowerCase() || '').includes(searchTerm.toLowerCase()) ||
                                  (booking.event?.toLowerCase() || '').includes(searchTerm.toLowerCase()) ||
                                  (booking.id?.toLowerCase() || '').includes(searchTerm.toLowerCase());
            const matchesSource = sourceFilter === 'all' || (booking.online && sourceFilter === 'online') || (!booking.online && sourceFilter === 'manual');
            return matchesSearch && matchesSource;
        });
    }, [bookings, searchTerm, sourceFilter]);

    return (
        <div className="space-y-6">
            <h2 className="text-3xl font-bold">إدارة حجوزات المنصة</h2>
            <Card>
                <CardHeader>
                    <CardTitle>قائمة الحجوزات ({filteredBookings.length})</CardTitle>
                    <CardDescription>عرض وتصفية جميع الحجوزات على المنصة.</CardDescription>
                    <div className="flex flex-col md:flex-row gap-4 pt-4">
                        <Input 
                            placeholder="ابحث بالعميل، الباقة، أو رقم الحجز..."
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            className="max-w-sm"
                        />
                        <Select value={sourceFilter} onValueChange={setSourceFilter} dir="rtl">
                            <SelectTrigger className="w-full md:w-[180px]">
                                <SelectValue placeholder="فلترة حسب المصدر" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">كل المصادر</SelectItem>
                                <SelectItem value="online">أونلاين</SelectItem>
                                <SelectItem value="manual">يدوي</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>رقم الحجز</TableHead>
                                <TableHead>العميل</TableHead>
                                <TableHead>الباقة/الخدمة</TableHead>
                                <TableHead>التاريخ</TableHead>
                                <TableHead>المبلغ</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead>المصدر</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredBookings.map((booking) => (
                                <TableRow key={booking.id}>
                                    <TableCell className="font-mono">{booking.id}</TableCell>
                                    <TableCell>{booking.customer}</TableCell>
                                    <TableCell>{booking.event}</TableCell>
                                    <TableCell>{format(parseISO(booking.date), 'PPP', { locale: ar })}</TableCell>
                                    <TableCell>{booking.amount.toLocaleString('ar-SA', { style: 'currency', currency: 'SAR' })}</TableCell>
                                    <TableCell>
                                        <Badge className={`${statusMap[booking.status]?.color || 'bg-gray-100 text-gray-800'} hover:${statusMap[booking.status]?.color}`}>
                                            {statusMap[booking.status]?.label || booking.status}
                                        </Badge>
                                    </TableCell>
                                    <TableCell>
                                        <div className="flex items-center gap-2">
                                            {booking.online ? sourceMap.online.icon : sourceMap.manual.icon}
                                            <span>{booking.online ? sourceMap.online.label : sourceMap.manual.label}</span>
                                        </div>
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

export default React.memo(AdminBookingsManagement);