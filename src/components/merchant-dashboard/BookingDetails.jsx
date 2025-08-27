import React, { memo } from 'react';
import { Button } from '@/components/ui/button';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Badge } from '@/components/ui/badge';
import { Separator } from '@/components/ui/separator';
import { Edit, Trash2, RefreshCw, History, FileText, PlusCircle, CheckCircle2, Mail } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

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

const BookingDetails = memo(({ booking, handleFeatureClick }) => {
    const { toast } = useToast();
    
    const internalHandleFeatureClick = (featureName) => {
        if (handleFeatureClick && typeof handleFeatureClick === 'function') {
            handleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };
    
    if (!booking) return (
        <div className="flex items-center justify-center h-full text-slate-500 p-6">
            <p>اختر حجزًا لعرض التفاصيل.</p>
        </div>
    );

    const status = bookingStatusDetails[booking.status] || { text: booking.status, color: 'bg-gray-400' };
    const isPackage = booking.id.startsWith('PKG-');

    return (
        <div className="flex flex-col h-full">
            <div className="flex-grow space-y-6 p-6 overflow-y-auto">
                <div className="flex flex-col items-center text-center">
                    <Avatar className="w-24 h-24 mb-4 border-4 border-white shadow-lg">
                        <AvatarImage src={isPackage ? "https://images.unsplash.com/photo-1581094481740-54c5d95c4c6f?q=80&w=200" : booking.avatar === '-' ? `https://source.unsplash.com/random/200x200?sig=${booking.id}` : booking.avatar} alt={isPackage ? "باقة" : booking.customer} />
                        <AvatarFallback className="text-3xl">{isPackage ? 'B' : booking.customer.charAt(0)}</AvatarFallback>
                    </Avatar>
                    <h3 className="text-2xl font-bold">{isPackage ? "تفاصيل الباقة" : booking.customer}</h3>
                    {!isPackage && <p className="text-sm text-muted-foreground">{booking.email}</p>}
                    <Badge variant="outline" className="mt-2 text-xs font-mono">{booking.id}</Badge>
                </div>

                <Separator />

                <div className="space-y-4 text-sm">
                    <div className="flex justify-between items-center">
                        <span className="font-semibold text-muted-foreground">{isPackage ? "حالة الباقة" : "حالة الحجز"}</span>
                        <div className="flex items-center gap-2">
                            <div className={`w-3 h-3 rounded-full ${status.color}`}></div>
                            <span className="font-bold">{booking.packageStatus || status.text}</span>
                        </div>
                    </div>
                    <div className="flex justify-between items-center">
                        <span className="font-semibold text-muted-foreground">{isPackage ? "اسم الباقة" : "الخدمة"}</span>
                        <span className="font-bold">{booking.event}</span>
                    </div>
                    <div className="flex justify-between items-center">
                        <span className="font-semibold text-muted-foreground">تاريخ المناسبة</span>
                        <span className="font-bold font-mono">{booking.date}</span>
                    </div>
                     <div className="flex justify-between items-center">
                        <span className="font-semibold text-muted-foreground">{isPackage ? "سعر الباقة" : "المبلغ المدفوع"}</span>
                        <span className="font-bold font-mono text-green-600">{booking.amount.toFixed(2)} ريال</span>
                    </div>
                     <div className="flex justify-between items-center">
                        <span className="font-semibold text-muted-foreground">متاح أونلاين؟</span>
                        <span className={`font-bold ${booking.online ? 'text-green-600' : 'text-red-600'}`}>{booking.online ? 'نعم' : 'لا'}</span>
                    </div>
                    {isPackage && booking.serviceType && (
                        <div className="flex justify-between items-center">
                            <span className="font-semibold text-muted-foreground">نوع الخدمة الأساسي</span>
                            <span className="font-bold">{booking.serviceType}</span>
                        </div>
                    )}
                </div>

                {!isPackage && (
                <>
                    <Separator />
                    <div className="px-0">
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
                </>
                )}
            </div>
            
            <div className="grid grid-cols-2 gap-2 p-4 mt-auto border-t bg-gray-50">
                <Button variant="outline" onClick={() => internalHandleFeatureClick(`تعديل ${isPackage ? 'الباقة' : 'الحجز'}: ${booking.id}`)}><Edit className="w-4 h-4 ml-2" /> تعديل</Button>
                <Button variant="outline" className="text-red-500 hover:text-red-600" onClick={() => internalHandleFeatureClick(`إلغاء ${isPackage ? 'الباقة' : 'الحجز'}: ${booking.id}`)}><Trash2 className="w-4 h-4 ml-2" /> {isPackage ? 'حذف' : 'إلغاء'}</Button>
                {!isPackage && <Button variant="outline" className="col-span-2" onClick={() => internalHandleFeatureClick(`تغيير حالة الحجز: ${booking.id}`)}><RefreshCw className="w-4 h-4 ml-2" /> تغيير الحالة</Button>}
                <Button variant="primary" className="col-span-2 gradient-bg text-white" onClick={() => internalHandleFeatureClick(`عرض ${isPackage ? 'تفاصيل إضافية للباقة' : 'الفاتورة'}: ${booking.id}`)}><FileText className="w-4 h-4 ml-2" /> {isPackage ? 'عرض تفاصيل إضافية' : 'عرض الفاتورة'}</Button>
            </div>
        </div>
    );
});

export default BookingDetails;