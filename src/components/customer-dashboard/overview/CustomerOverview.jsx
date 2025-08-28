
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { AlertCircle, ArrowLeft, Calendar, Star, Ticket } from 'lucide-react';

const CustomerOverview = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">مرحباً بكِ، نورة!</h1>
                <p className="text-slate-500 mt-1">نظرة سريعة على حسابك ونشاطك.</p>
            </div>
            
            <Card className="bg-gradient-to-tr from-primary to-indigo-600 text-white">
                <CardHeader>
                    <CardTitle className="flex justify-between items-center">
                        <span>حجزك القادم</span>
                        <Calendar/>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p className="text-2xl font-bold">فعالية الشتاء</p>
                    <p className="text-indigo-200">السبت، 16 ديسمبر 2025 - 8:00 مساءً</p>
                    <Button variant="secondary" className="mt-4" onClick={() => handleFeatureClick("عرض التذكرة")}>
                        عرض التذكرة <ArrowLeft className="w-4 h-4 mr-2"/>
                    </Button>
                </CardContent>
            </Card>

            <div className="grid md:grid-cols-2 gap-6">
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Ticket /> حجوزاتك النشطة</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p className="text-3xl font-bold">3</p>
                        <p className="text-slate-500">لديك 3 حجوزات قادمة هذا الشهر.</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Star /> نقاط المكافآت</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p className="text-3xl font-bold">1,250 نقطة</p>
                        <p className="text-slate-500">يمكنك استبدالها بخصومات رائعة!</p>
                    </CardContent>
                </Card>
            </div>

            <Card className="border-amber-500 bg-amber-50">
                 <CardHeader>
                    <CardTitle className="flex items-center gap-2 text-amber-800"><AlertCircle/> تنبيهات هامة</CardTitle>
                </CardHeader>
                <CardContent className="text-amber-700">
                    <p>تم تحديث توقيت حجز "مطعم الذواقة" ليبدأ في الساعة 9:30 مساءً بدلاً من 9:00 مساءً بناءً على طلبك.</p>
                </CardContent>
            </Card>
        </div>
    );
};

export default CustomerOverview;
