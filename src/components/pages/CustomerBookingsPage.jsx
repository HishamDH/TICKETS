import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { ArrowRight, CalendarDays, MapPin, Users, Clock, CheckCircle, XCircle, AlertTriangle } from 'lucide-react';
import { Badge } from '@/components/ui/badge';
import { format, parseISO } from 'date-fns';
import { ar } from 'date-fns/locale';
import { useToast } from "@/components/ui/use-toast";

const customerBookingsData = [
    { 
        id: 'CBK-001', 
        serviceName: 'قاعة الأفراح الملكية', 
        providerName: 'مجموعة ليالينا الفاخرة',
        date: '2025-12-16', 
        time: '08:00 PM - 02:00 AM',
        location: 'الرياض، حي العليا، شارع الأمير محمد بن عبدالعزيز',
        guests: 200,
        status: 'confirmed',
        notes: 'تم طلب كوشة خاصة باللون الأبيض والذهبي.',
        image: 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?q=80&w=600'
    },
    { 
        id: 'CBK-002', 
        serviceName: 'تصوير فوتوغرافي وفيديو', 
        providerName: 'استوديو الإبداع للتصوير',
        date: '2025-12-20', 
        time: 'كامل اليوم',
        location: 'حسب موقع العميل (سيتم التواصل لتحديد التفاصيل)',
        guests: null,
        status: 'paid',
        notes: 'يشمل ألبوم صور فاخر وفيديو مونتاج احترافي.',
        image: 'https://images.unsplash.com/photo-1519680484038-19220ac003ba?q=80&w=600'
    },
    { 
        id: 'CBK-003', 
        serviceName: 'بوفيه الكرم للضيافة', 
        providerName: 'مطبخ الكرم المركزي',
        date: '2025-11-05', 
        time: '07:00 PM',
        location: 'قاعة المناسبات بفندق هيلتون جدة',
        guests: 150,
        status: 'completed',
        notes: 'تم تقديم الخدمة بنجاح.',
        image: 'https://images.unsplash.com/photo-1555243896-c709b02b2791?q=80&w=600'
    },
     { 
        id: 'CBK-004', 
        serviceName: 'تنسيق زهور الربيع', 
        providerName: 'محل زهور الربيع',
        date: '2025-10-15', 
        time: 'يتم التنسيق قبل المناسبة بيوم',
        location: 'يتم التوصيل لموقع العميل',
        guests: null,
        status: 'cancelled_by_user',
        notes: 'تم الإلغاء بسبب تغيير موعد المناسبة.',
        image: 'https://images.unsplash.com/photo-1587888637140-849b89d73894?q=80&w=600'
    },
];

const statusDetails = {
    confirmed: { text: 'مؤكد', icon: CheckCircle, color: 'text-sky-600 bg-sky-100' },
    paid: { text: 'مدفوع بالكامل', icon: CheckCircle, color: 'text-emerald-600 bg-emerald-100' },
    pending_payment: { text: 'بانتظار الدفع', icon: Clock, color: 'text-amber-600 bg-amber-100' },
    completed: { text: 'مكتمل', icon: CheckCircle, color: 'text-slate-600 bg-slate-100' },
    cancelled_by_user: { text: 'ملغي من طرفك', icon: XCircle, color: 'text-red-600 bg-red-100' },
    cancelled_by_provider: { text: 'ملغي من مزود الخدمة', icon: AlertTriangle, color: 'text-orange-600 bg-orange-100' },
};


const CustomerBookingsPage = ({ handleNavigation }) => {
    const { toast } = useToast();
    const handleFeatureClick = (featureName) => {
        toast({
            title: "🚧 ميزة قيد التطوير",
            description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            variant: "default",
        });
    };

    return (
        <div className="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8 font-cairo" dir="rtl">
            <header className="mb-12 text-center">
                <div className="inline-flex items-center gap-3 mb-4">
                    <div className="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center">
                        <img
                            alt="شعار ليلة الليليوم"
                            className="w-7 h-7 invert"
                            src="https://images.unsplash.com/photo-1557845767-9cc6526890f7" />
                    </div>
                    <h1 className="text-4xl font-extrabold text-slate-800 tracking-tight">حجوزاتي في ليلة الليليوم</h1>
                </div>
                <p className="text-lg text-slate-600 max-w-2xl mx-auto">
                    مرحباً بك! هنا يمكنك استعراض جميع حجوزاتك لمناسباتك القادمة والسابقة عبر منصتنا.
                </p>
                 <Button onClick={() => handleNavigation('customer-dashboard')} variant="outline" className="mt-6">
                    <ArrowRight className="w-4 h-4 ml-2" /> العودة إلى لوحة التحكم الرئيسية
                </Button>
            </header>

            {customerBookingsData.length > 0 ? (
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {customerBookingsData.map((booking) => {
                        const statusInfo = statusDetails[booking.status] || { text: booking.status, icon: AlertTriangle, color: 'text-slate-600 bg-slate-100' };
                        const StatusIcon = statusInfo.icon;
                        return (
                            <Card key={booking.id} className="overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 rounded-xl">
                                <div className="relative">
                                    <img-replace src={booking.image} alt={`صورة لـ ${booking.serviceName}`} className="w-full h-56 object-cover" />
                                    <div className={`absolute top-4 left-4 px-3 py-1.5 text-sm font-semibold rounded-full flex items-center gap-2 ${statusInfo.color}`}>
                                        <StatusIcon className="w-4 h-4" />
                                        {statusInfo.text}
                                    </div>
                                </div>
                                <CardContent className="p-6 space-y-4">
                                    <CardTitle className="text-2xl font-bold text-primary">{booking.serviceName}</CardTitle>
                                    <CardDescription className="text-sm text-slate-500">مقدمة من: {booking.providerName}</CardDescription>
                                    
                                    <div className="space-y-2 text-slate-700">
                                        <div className="flex items-center gap-2">
                                            <CalendarDays className="w-5 h-5 text-slate-400" />
                                            <span>{format(parseISO(booking.date), 'EEEE، d MMMM yyyy', { locale: ar })}</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <Clock className="w-5 h-5 text-slate-400" />
                                            <span>{booking.time}</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <MapPin className="w-5 h-5 text-slate-400" />
                                            <span>{booking.location}</span>
                                        </div>
                                        {booking.guests && (
                                            <div className="flex items-center gap-2">
                                                <Users className="w-5 h-5 text-slate-400" />
                                                <span>{booking.guests} ضيف</span>
                                            </div>
                                        )}
                                    </div>
                                    {booking.notes && (
                                        <p className="text-xs bg-slate-100 p-3 rounded-md border border-slate-200 text-slate-600">
                                            <strong>ملاحظات:</strong> {booking.notes}
                                        </p>
                                    )}
                                    <Button 
                                        className="w-full mt-4 gradient-bg-hover" 
                                        onClick={() => { handleFeatureClick(`عرض تفاصيل حجز ${booking.id}`); handleNavigation('customer-dashboard', { section: 'bookings_section', bookingId: booking.id });}}
                                    >
                                        عرض تفاصيل الحجز وإدارته
                                    </Button>
                                </CardContent>
                            </Card>
                        );
                    })}
                </div>
            ) : (
                <div className="text-center py-16">
                    <CalendarDays className="w-24 h-24 mx-auto text-slate-300 mb-6" />
                    <h2 className="text-2xl font-semibold text-slate-700 mb-2">لا توجد حجوزات لعرضها حاليًا.</h2>
                    <p className="text-slate-500 mb-6">ابدأ بتصفح خدماتنا وحجز مناسبتك القادمة!</p>
                    <Button onClick={() => {handleFeatureClick('تصفح الخدمات الآن'); handleNavigation('services-showcase');}} className="gradient-bg text-white">
                        تصفح الخدمات الآن
                    </Button>
                </div>
            )}
        </div>
    );
};

export default CustomerBookingsPage;