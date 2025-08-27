import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Textarea } from '@/components/ui/textarea';
import { Popover, PopoverTrigger, PopoverContent } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { PlusCircle, User, Phone, Mail, Calendar as CalendarIcon, Clock, CreditCard } from 'lucide-react';
import { format } from "date-fns";
import { ar } from "date-fns/locale";
import { useToast } from "@/components/ui/use-toast";

const ManualBookingContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [bookingData, setBookingData] = useState({
        customerName: '', customerPhone: '', customerEmail: '', 
        serviceType: '', eventDate: null, eventTime: '', 
        notes: '', paymentMethod: 'cash', amount: '', status: 'confirmed'
    });

    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick && typeof propHandleFeatureClick === 'function') {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setBookingData(prev => ({ ...prev, [name]: value }));
    };

    const handleSelectChange = (name, value) => {
        setBookingData(prev => ({ ...prev, [name]: value }));
    };

    const handleDateChange = (date) => {
        setBookingData(prev => ({ ...prev, eventDate: date }));
    };

    const handleCreateBooking = () => {
        if (!bookingData.customerName || !bookingData.customerPhone || !bookingData.serviceType || !bookingData.eventDate) {
            toast({ title: "خطأ", description: "الرجاء ملء جميع الحقول المطلوبة.", variant: "destructive" });
            return;
        }

        const newBooking = {
            id: `MAN-${Date.now().toString().slice(-5)}`,
            ...bookingData,
            createdAt: new Date().toISOString(),
            source: 'manual'
        };

        const existingBookings = JSON.parse(localStorage.getItem('lilium_night_manual_bookings_v1')) || [];
        localStorage.setItem('lilium_night_manual_bookings_v1', JSON.stringify([newBooking, ...existingBookings]));

        toast({ title: "تم بنجاح!", description: `تم إنشاء الحجز ${newBooking.id} للعميل ${bookingData.customerName}.` });
        handleFeatureClick(`إنشاء حجز يدوي للعميل: ${bookingData.customerName}`);
        
        setBookingData({
            customerName: '', customerPhone: '', customerEmail: '', 
            serviceType: '', eventDate: null, eventTime: '', 
            notes: '', paymentMethod: 'cash', amount: '', status: 'confirmed'
        });
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">إضافة حجز يدوي</h2>
            
            <Card>
                <CardHeader>
                    <CardTitle>إنشاء حجز جديد خارج المنصة</CardTitle>
                    <CardDescription>أدخل تفاصيل الحجز الذي تم عبر الهاتف أو شخصياً لتسجيله في النظام.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div className="grid md:grid-cols-2 gap-6">
                        <div className="space-y-2">
                            <Label htmlFor="customerName">اسم العميل *</Label>
                            <div className="relative">
                                <User className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input id="customerName" name="customerName" value={bookingData.customerName} onChange={handleInputChange} placeholder="مثال: أحمد محمد" className="pr-10" />
                            </div>
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="customerPhone">رقم الجوال *</Label>
                            <div className="relative">
                                <Phone className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input id="customerPhone" name="customerPhone" value={bookingData.customerPhone} onChange={handleInputChange} placeholder="05xxxxxxxx" className="pr-10" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <Label htmlFor="customerEmail">البريد الإلكتروني (اختياري)</Label>
                        <div className="relative">
                            <Mail className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                            <Input id="customerEmail" name="customerEmail" type="email" value={bookingData.customerEmail} onChange={handleInputChange} placeholder="email@example.com" className="pr-10" />
                        </div>
                    </div>

                    <div className="grid md:grid-cols-2 gap-6">
                        <div className="space-y-2">
                            <Label>نوع الخدمة المحجوزة *</Label>
                            <Select dir="rtl" value={bookingData.serviceType} onValueChange={(val) => handleSelectChange('serviceType', val)}>
                                <SelectTrigger><SelectValue placeholder="اختر الخدمة..." /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="wedding_hall">قاعة الأفراح الملكية</SelectItem>
                                    <SelectItem value="photography">تصوير احترافي</SelectItem>
                                    <SelectItem value="catering">بوفيه الضيافة</SelectItem>
                                    <SelectItem value="beauty">خدمات التجميل</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="amount">المبلغ المتفق عليه (ريال)</Label>
                            <div className="relative">
                                <CreditCard className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input id="amount" name="amount" type="number" value={bookingData.amount} onChange={handleInputChange} placeholder="5000" className="pr-10" />
                            </div>
                        </div>
                    </div>

                    <div className="grid md:grid-cols-2 gap-6">
                        <div className="space-y-2">
                            <Label>تاريخ المناسبة *</Label>
                            <Popover>
                                <PopoverTrigger asChild>
                                    <Button variant="outline" className="w-full justify-start text-right font-normal">
                                        <CalendarIcon className="ml-2 h-4 w-4" />
                                        {bookingData.eventDate ? format(bookingData.eventDate, "PPP", { locale: ar }) : <span>اختر التاريخ</span>}
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent className="w-auto p-0"><Calendar mode="single" selected={bookingData.eventDate} onSelect={handleDateChange} initialFocus locale={ar} /></PopoverContent>
                            </Popover>
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="eventTime">وقت المناسبة</Label>
                            <div className="relative">
                                <Clock className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input id="eventTime" name="eventTime" value={bookingData.eventTime} onChange={handleInputChange} placeholder="مثال: 7:00 مساءً" className="pr-10" />
                            </div>
                        </div>
                    </div>

                    <div className="grid md:grid-cols-2 gap-6">
                        <div className="space-y-2">
                            <Label>وسيلة الدفع</Label>
                            <Select dir="rtl" value={bookingData.paymentMethod} onValueChange={(val) => handleSelectChange('paymentMethod', val)}>
                                <SelectTrigger><SelectValue /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="cash">نقداً</SelectItem>
                                    <SelectItem value="bank_transfer">تحويل بنكي</SelectItem>
                                    <SelectItem value="card">بطاقة ائتمانية</SelectItem>
                                    <SelectItem value="installments">أقساط</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <div className="space-y-2">
                            <Label>حالة الحجز</Label>
                            <Select dir="rtl" value={bookingData.status} onValueChange={(val) => handleSelectChange('status', val)}>
                                <SelectTrigger><SelectValue /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="confirmed">مؤكد</SelectItem>
                                    <SelectItem value="pending">بانتظار التأكيد</SelectItem>
                                    <SelectItem value="paid">مدفوع</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>

                    <div>
                        <Label htmlFor="notes">ملاحظات إضافية</Label>
                        <Textarea id="notes" name="notes" value={bookingData.notes} onChange={handleInputChange} placeholder="أي تفاصيل أو طلبات خاصة..." />
                    </div>

                    <Button className="w-full gradient-bg text-white" size="lg" onClick={handleCreateBooking}>
                        <PlusCircle className="w-5 h-5 ml-2"/>
                        إنشاء الحجز وإرسال تأكيد للعميل
                    </Button>
                </CardContent>
            </Card>
        </div>
    );
});

export default ManualBookingContent;