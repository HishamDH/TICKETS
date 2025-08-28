
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Building, PlusCircle, List, FileText, Trash2, User, Phone, Ticket } from 'lucide-react';

const groupBookings = [
    { id: 'GRP-001', company: 'شركة ألفا', event: 'معرض التقنية 2025', tickets: 25, status: 'مدفوع' },
    { id: 'GRP-002', company: 'مؤسسة بيتا', event: 'تجربة الغوص', tickets: 10, status: 'مدفوع' },
    { id: 'GRP-003', company: 'مجموعة جاما', event: 'معرض التقنية 2025', tickets: 50, status: 'بانتظار الدفع' },
];

const GroupBookingContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">نظام الحجز الجماعي</h2>
            </div>
            
            <Tabs defaultValue="create" dir="rtl">
                <TabsList className="grid w-full grid-cols-2">
                    <TabsTrigger value="create" className="flex items-center gap-2"><PlusCircle className="h-4 w-4"/> إنشاء حجز جماعي</TabsTrigger>
                    <TabsTrigger value="list" className="flex items-center gap-2"><List className="h-4 w-4"/> سجل الحجوزات الجماعية</TabsTrigger>
                </TabsList>

                <TabsContent value="create" className="pt-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>إنشاء حجز لشركة أو جهة</CardTitle>
                            <CardDescription>أدخل تفاصيل الحجز لإصدار فاتورة موحدة.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-6">
                            <div className="grid md:grid-cols-2 gap-6">
                                <div className="space-y-2">
                                    <Label htmlFor="companyName">اسم الشركة / الجهة</Label>
                                    <div className="relative">
                                        <Building className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                        <Input id="companyName" placeholder="مثال: شركة الحلول المبتكرة" className="pr-10" />
                                    </div>
                                </div>
                                <div className="space-y-2">
                                    <Label>الفعالية / الخدمة</Label>
                                    <Select dir="rtl">
                                        <SelectTrigger>
                                            <SelectValue placeholder="اختر الخدمة..." />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="event1">معرض التقنية 2025</SelectItem>
                                            <SelectItem value="event2">تجربة الغوص</SelectItem>
                                            <SelectItem value="event3">حفل العشاء السنوي</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                            </div>
                            
                            <div className="space-y-2">
                                <Label htmlFor="ticketCount">عدد التذاكر</Label>
                                <div className="relative">
                                    <Ticket className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                    <Input id="ticketCount" type="number" placeholder="مثال: 50" className="pr-10" />
                                </div>
                            </div>

                            <div className="grid md:grid-cols-2 gap-6">
                                <div className="space-y-2">
                                    <Label htmlFor="contactName">اسم مسؤول التواصل</Label>
                                    <div className="relative">
                                        <User className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                        <Input id="contactName" placeholder="مثال: سارة عبدالله" className="pr-10" />
                                    </div>
                                </div>
                                <div className="space-y-2">
                                    <Label htmlFor="contactPhone">رقم جوال التواصل</Label>
                                    <div className="relative">
                                        <Phone className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                        <Input id="contactPhone" placeholder="05xxxxxxxx" className="pr-10" />
                                    </div>
                                </div>
                            </div>
                            
                            <Button className="w-full gradient-bg text-white" size="lg" onClick={() => handleFeatureClick("إنشاء فاتورة جماعية")}>
                                <FileText className="w-5 h-5 ml-2"/>
                                إنشاء الحجز وإصدار فاتورة موحدة
                            </Button>
                        </CardContent>
                    </Card>
                </TabsContent>

                <TabsContent value="list" className="pt-6">
                     <Card>
                        <CardHeader>
                            <CardTitle>سجل الحجوزات الجماعية</CardTitle>
                            <CardDescription>عرض جميع الحجوزات التي تمت للشركات والمؤسسات.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>رقم الحجز</TableHead>
                                        <TableHead>الشركة / الجهة</TableHead>
                                        <TableHead>الفعالية</TableHead>
                                        <TableHead>عدد التذاكر</TableHead>
                                        <TableHead>الحالة</TableHead>
                                        <TableHead>إجراءات</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {groupBookings.map((booking) => (
                                        <TableRow key={booking.id}>
                                            <TableCell className="font-mono">{booking.id}</TableCell>
                                            <TableCell>{booking.company}</TableCell>
                                            <TableCell>{booking.event}</TableCell>
                                            <TableCell>{booking.tickets}</TableCell>
                                            <TableCell>
                                                <span className={`px-2 py-1 text-xs font-semibold rounded-full ${booking.status === 'مدفوع' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}`}>
                                                    {booking.status}
                                                </span>
                                            </TableCell>
                                            <TableCell className="space-x-2 space-x-reverse">
                                                <Button variant="outline" size="sm" onClick={() => handleFeatureClick("عرض الفاتورة")}>
                                                    <FileText className="w-4 h-4 ml-1"/> عرض الفاتورة
                                                </Button>
                                                <Button variant="ghost" size="sm" className="text-red-500 hover:text-red-600" onClick={() => handleFeatureClick("إلغاء الحجز الجماعي")}>
                                                    <Trash2 className="w-4 h-4 ml-1"/> إلغاء
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </TabsContent>
            </Tabs>
        </div>
    );
};

export default GroupBookingContent;
