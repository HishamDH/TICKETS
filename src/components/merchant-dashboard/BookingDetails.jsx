
import React from 'react';
import { Button } from '@/components/ui/button';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Badge } from '@/components/ui/badge';
import { Separator } from '@/components/ui/separator';
import { Edit, Trash2, RefreshCw, History, FileText, PlusCircle, CheckCircle2, Mail } from 'lucide-react';

const bookingStatusDetails = {
    pending: { text: 'قيد الانتظار', color: 'bg-yellow-500' },
    paid: { text: 'مدفوع', color: 'bg-green-500' },
    approved: { text: 'مقبول يدويًا', color: 'bg-sky-500' },
    rejected: { text: 'مرفوض يدويًا', color: 'bg-red-500' },
    used: { text: 'مستخدم', color: 'bg-indigo-500' },
    expired: { text: 'منتهية الصلاحية', color: 'bg-slate-500' },
    cancelled_by_user: { text: 'ملغي من العميل', color: 'bg-orange-500' },
    cancelled_by_merchant: { text: 'ملغي من التاجر', color: 'bg-orange-600' },
    refunded_full: { text: 'مسترد بالكامل', color: 'bg-purple-500' },
    awaiting_confirmation: { text: 'بانتظار الموافقة', color: 'bg-cyan-500' },
    no_show: { text: 'لم يحضر', color: 'bg-gray-500' },
};

const activityLog = [
    { action: "إنشاء الحجز", user: "النظام", timestamp: "2025-06-12 10:30ص", icon: PlusCircle },
    { action: "تم الدفع بنجاح", user: "العميل", timestamp: "2025-06-12 10:32ص", icon: CheckCircle2 },
    { action: "تم إرسال التأكيد", user: "النظام", timestamp: "2025-06-12 10:33ص", icon: Mail },
];

const BookingDetails = ({ booking, handleFeatureClick }) => {
    if (!booking) return null;

    const status = bookingStatusDetails[booking.status] || { text: booking.status, color: 'bg-gray-400' };

    return (
        <div className="flex flex-col h-full">
            <div className="flex-grow space-y-6 p-2 overflow-y-auto">
                <div className="flex flex-col items-center text-center pt-6">
                    <Avatar className="w-24 h-24 mb-4 border-4 border-white shadow-lg">
                        <AvatarImage asChild>
                            <img  alt={booking.customer} src="https://images.unsplash.com/photo-1624775054619-bf29a387fecc" />
                        </AvatarImage>
                        <AvatarFallback className="text-3xl">{booking.customer.charAt(0)}</AvatarFallback>
                    </Avatar>
                    <h3 className="text-2xl font-bold">{booking.customer}</h3>
                    <p className="text-sm text-muted-foreground">{booking.email}</p>
                    <Badge variant="outline" className="mt-2 text-xs font-mono">{booking.id}</Badge>
                </div>

                <Separator />

                <div className="space-y-4 text-sm px-4">
                    <div className="flex justify-between items-center">
                        <span className="font-semibold text-muted-foreground">الحالة</span>
                        <div className="flex items-center gap-2">
                            <div className={`w-3 h-3 rounded-full ${status.color}`}></div>
                            <span className="font-bold">{status.text}</span>
                        </div>
                    </div>
                    <div className="flex justify-between items-center">
                        <span className="font-semibold text-muted-foreground">الخدمة</span>
                        <span className="font-bold">{booking.event}</span>
                    </div>
                    <div className="flex justify-between items-center">
                        <span className="font-semibold text-muted-foreground">تاريخ الحجز</span>
                        <span className="font-bold font-mono">{booking.date}</span>
                    </div>
                    <div className="flex justify-between items-center">
                        <span className="font-semibold text-muted-foreground">المبلغ المدفوع</span>
                        <span className="font-bold font-mono text-green-600">{booking.amount} ريال</span>
                    </div>
                </div>

                <Separator />

                <div className="px-4">
                    <h4 className="font-bold text-md mb-4 flex items-center gap-2"><History className="w-5 h-5" /> سجل النشاط</h4>
                    <div className="relative">
                        <div className="absolute left-2.5 top-0 h-full w-0.5 bg-slate-200"></div>
                        <div className="space-y-6">
                            {activityLog.map((log, index) => (
                                <div key={index} className="flex items-start gap-4 relative">
                                    <div className="w-6 h-6 bg-primary rounded-full flex items-center justify-center z-10">
                                        <log.icon className="w-4 h-4 text-white" />
                                    </div>
                                    <div className="flex-1 -mt-1">
                                        <p className="font-semibold text-sm">{log.action} <span className="font-normal text-muted-foreground">بواسطة {log.user}</span></p>
                                        <p className="text-xs text-muted-foreground">{log.timestamp}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
            
            <div className="grid grid-cols-2 gap-2 p-4 mt-auto border-t bg-gray-50">
                <Button variant="outline" onClick={() => handleFeatureClick("تعديل الحجز")}><Edit className="w-4 h-4 ml-2" /> تعديل</Button>
                <Button variant="outline" className="text-red-500 hover:text-red-600" onClick={() => handleFeatureClick("إلغاء الحجز")}><Trash2 className="w-4 h-4 ml-2" /> إلغاء</Button>
                <Button variant="outline" className="col-span-2" onClick={() => handleFeatureClick("تغيير حالة الحجز")}><RefreshCw className="w-4 h-4 ml-2" /> تغيير الحالة</Button>
                <Button variant="primary" className="col-span-2 gradient-bg text-white" onClick={() => handleFeatureClick("عرض الفاتورة")}><FileText className="w-4 h-4 ml-2" /> عرض الفاتورة</Button>
            </div>
        </div>
    );
};

export default BookingDetails;
