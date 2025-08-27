import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from "@/components/ui/dialog";
import { PlusCircle, Building, Clock, CheckCircle, XCircle } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { format } from "date-fns";
import { ar } from "date-fns/locale";

const initialGroupBookings = [
    { id: 'grp1', company: 'شركة ألفا المحدودة', contact: 'خالد العامر', attendees: 50, date: new Date(Date.now() + 10 * 24 * 60 * 60 * 1000).toISOString(), status: 'pending' },
    { id: 'grp2', company: 'مؤسسة بيتا التجارية', contact: 'نورة السالم', attendees: 25, date: new Date(Date.now() + 20 * 24 * 60 * 60 * 1000).toISOString(), status: 'confirmed' },
    { id: 'grp3', company: 'مجموعة جاما القابضة', contact: 'سلطان الفهد', attendees: 120, date: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toISOString(), status: 'completed' },
];

const statusMap = {
    pending: { label: 'قيد المراجعة', icon: <Clock className="w-4 h-4 text-yellow-500" />, color: 'bg-yellow-100 text-yellow-800' },
    confirmed: { label: 'مؤكد', icon: <CheckCircle className="w-4 h-4 text-green-500" />, color: 'bg-green-100 text-green-800' },
    completed: { label: 'مكتمل', icon: <CheckCircle className="w-4 h-4 text-blue-500" />, color: 'bg-blue-100 text-blue-800' },
    cancelled: { label: 'ملغي', icon: <XCircle className="w-4 h-4 text-red-500" />, color: 'bg-red-100 text-red-800' },
};

const GroupBookingContent = memo(({ handleFeatureClick }) => {
    const { toast } = useToast();
    const [bookings, setBookings] = useState(JSON.parse(localStorage.getItem('lilium_night_group_bookings_v1')) || initialGroupBookings);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [newBooking, setNewBooking] = useState({ company: '', contact: '', attendees: '', date: '', notes: '' });

    useEffect(() => {
        localStorage.setItem('lilium_night_group_bookings_v1', JSON.stringify(bookings));
    }, [bookings]);

    const handleCreateBooking = () => {
        if (!newBooking.company || !newBooking.contact || !newBooking.attendees || !newBooking.date) {
            toast({ title: "خطأ", description: "الرجاء ملء جميع الحقول المطلوبة.", variant: "destructive" });
            return;
        }
        const newBookingData = { ...newBooking, id: `grp${Date.now()}`, status: 'pending' };
        setBookings([...bookings, newBookingData]);
        setIsModalOpen(false);
        setNewBooking({ company: '', contact: '', attendees: '', date: '', notes: '' });
        toast({ title: "تم إنشاء الحجز", description: "تمت إضافة حجز المجموعة الجديد بنجاح." });
        handleFeatureClick(`إنشاء حجز مجموعة لـ ${newBooking.company}`);
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">نظام حجز الشركات والمجموعات</h2>
                <Button className="gradient-bg text-white" onClick={() => setIsModalOpen(true)}>
                    <PlusCircle className="w-5 h-5 ml-2"/> إنشاء حجز جديد
                </Button>
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>إدارة حجوزات المجموعات</CardTitle>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>الشركة/المجموعة</TableHead>
                                <TableHead>عدد الحضور</TableHead>
                                <TableHead>التاريخ</TableHead>
                                <TableHead>الحالة</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {bookings.map(booking => (
                                <TableRow key={booking.id}>
                                    <TableCell className="font-semibold">{booking.company}</TableCell>
                                    <TableCell>{booking.attendees}</TableCell>
                                    <TableCell>{format(new Date(booking.date), 'PPP', { locale: ar })}</TableCell>
                                    <TableCell>
                                        <span className={`flex items-center gap-2 text-sm font-semibold px-2 py-1 rounded-full ${statusMap[booking.status].color}`}>
                                            {statusMap[booking.status].icon}
                                            {statusMap[booking.status].label}
                                        </span>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>

            <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
                <DialogContent className="sm:max-w-[525px]" dir="rtl">
                    <DialogHeader>
                        <DialogTitle>إنشاء حجز مجموعة جديد</DialogTitle>
                    </DialogHeader>
                    <div className="py-4 space-y-4">
                        <div>
                            <Label htmlFor="company">اسم الشركة/المجموعة</Label>
                            <Input id="company" value={newBooking.company} onChange={(e) => setNewBooking({...newBooking, company: e.target.value})} />
                        </div>
                        <div>
                            <Label htmlFor="contact">اسم مسؤول التواصل</Label>
                            <Input id="contact" value={newBooking.contact} onChange={(e) => setNewBooking({...newBooking, contact: e.target.value})} />
                        </div>
                        <div>
                            <Label htmlFor="attendees">عدد الحضور المتوقع</Label>
                            <Input id="attendees" type="number" value={newBooking.attendees} onChange={(e) => setNewBooking({...newBooking, attendees: e.target.value})} />
                        </div>
                        <div>
                            <Label htmlFor="date">التاريخ المطلوب</Label>
                            <Input id="date" type="date" value={newBooking.date} onChange={(e) => setNewBooking({...newBooking, date: e.target.value})} />
                        </div>
                        <div>
                            <Label htmlFor="notes">ملاحظات إضافية</Label>
                            <Textarea id="notes" value={newBooking.notes} onChange={(e) => setNewBooking({...newBooking, notes: e.target.value})} />
                        </div>
                    </div>
                    <DialogFooter>
                        <Button variant="ghost" onClick={() => setIsModalOpen(false)}>إلغاء</Button>
                        <Button className="gradient-bg text-white" onClick={handleCreateBooking}>إنشاء الحجز</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
});

export default GroupBookingContent;