import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { AlertCircle, ArrowLeft, Calendar, Star, Ticket, Gift } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Progress } from "@/components/ui/progress";

const CustomerOverview = ({ handleNavigation, setActiveSection, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    
    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick) {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };
    
    const navigateToSection = (sectionId, featureName) => {
        if (setActiveSection) {
            setActiveSection(sectionId);
        }
        handleFeatureClick(featureName || `الانتقال إلى قسم ${sectionId}`);
    };

    const upcomingEvent = {
        title: "حفل زفاف في قاعة الأفراح الملكية",
        date: "السبت، 16 ديسمبر 2025 - 8:00 مساءً",
        bookingId: "BK-8462"
    };

    const stats = [
        { id: 'bookings_section', title: 'حجوزاتك النشطة', value: '3', description: 'لديك 3 حجوزات قادمة هذا الشهر.', icon: Ticket, featureName: "عرض الحجوزات النشطة" },
        { id: 'offers_section', title: 'نقاط المكافآت', value: '1,250 نقطة', description: 'يمكنك استبدالها بخصومات رائعة!', icon: Star, featureName: "عرض نقاط المكافآت" },
        { id: 'reviews_section', title: 'تقييماتك المعلقة', value: '1', description: 'لديك تجربة واحدة بانتظار تقييمك.', icon: Gift, featureName: "عرض التقييمات المعلقة" },
    ];
    
    const loyaltyProgress = 75;

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">مرحباً بكِ، نورة!</h1>
                <p className="text-slate-500 mt-1">نظرة سريعة على حسابك ونشاطك في منصة ليلة الليليوم.</p>
            </div>
            
            <Card className="bg-gradient-to-tr from-primary to-indigo-600 text-white shadow-lg">
                <CardHeader>
                    <CardTitle className="flex justify-between items-center">
                        <span>مناسبتك القادمة</span>
                        <Calendar/>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p className="text-2xl font-bold">{upcomingEvent.title}</p>
                    <p className="text-indigo-200">{upcomingEvent.date}</p>
                    <Button variant="secondary" className="mt-4 bg-white/20 hover:bg-white/30 text-white" onClick={() => navigateToSection('bookings_section', `عرض تفاصيل الحجز لـ ${upcomingEvent.title}`)}>
                        عرض تفاصيل الحجز <ArrowLeft className="w-4 h-4 mr-2"/>
                    </Button>
                </CardContent>
            </Card>

            <div className="grid md:grid-cols-3 gap-6">
                {stats.map(stat => (
                    <Card key={stat.id} className="cursor-pointer hover:shadow-lg transition-shadow" onClick={() => navigateToSection(stat.id, stat.featureName)}>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2 text-slate-700"><stat.icon className="w-5 h-5 text-primary"/> {stat.title}</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <p className="text-3xl font-bold text-slate-800">{stat.value}</p>
                            <p className="text-sm text-slate-500 mt-1">{stat.description}</p>
                        </CardContent>
                    </Card>
                ))}
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>مستوى الولاء لديك</CardTitle>
                    <CardDescription>أنت على وشك الوصول للمستوى الذهبي! أكمل حجوزاتك لفتح مكافآت حصرية.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Progress value={loyaltyProgress} className="w-full h-3" />
                    <div className="flex justify-between text-sm text-slate-500 mt-2">
                        <span>المستوى الفضي</span>
                        <span>{loyaltyProgress}% نحو الذهبي</span>
                    </div>
                    <Button variant="link" className="p-0 h-auto mt-2" onClick={() => navigateToSection('offers_section', "عرض تفاصيل مستوى الولاء")}>عرض تفاصيل مستويات الولاء والمكافآت</Button>
                </CardContent>
            </Card>

            <Card className="border-amber-500 bg-amber-50">
                 <CardHeader>
                    <CardTitle className="flex items-center gap-2 text-amber-800"><AlertCircle/> تنبيهات هامة</CardTitle>
                </CardHeader>
                <CardContent className="text-amber-700">
                    <p>تم تحديث توقيت حجز "بوفيه الكرم للضيافة" ليبدأ في الساعة 9:30 مساءً بدلاً من 9:00 مساءً بناءً على طلبك. <Button variant="link" size="sm" className="p-0 h-auto text-amber-800" onClick={() => navigateToSection('bookings_section', "عرض تفاصيل التنبيه الهام")}>عرض التفاصيل</Button></p>
                </CardContent>
            </Card>
        </div>
    );
};

export default CustomerOverview;