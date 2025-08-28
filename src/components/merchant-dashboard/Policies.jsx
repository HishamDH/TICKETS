import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Checkbox } from '@/components/ui/checkbox';
import { Save, FileText, CreditCard } from 'lucide-react';

const PoliciesContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">السياسات والإعدادات</h2>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("حفظ الإعدادات")}><Save className="w-4 h-4 ml-2"/>حفظ الإعدادات</Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><FileText/>سياسة الإلغاء والاسترجاع</CardTitle>
                    <CardDescription>حدد الشروط التي يمكن للعملاء بموجبها إلغاء حجوزاتهم واسترداد أموالهم.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    <div>
                        <Label htmlFor="cancellation-policy">نص السياسة</Label>
                        <Textarea id="cancellation-policy" placeholder="مثال: لا يمكن استرجاع المبلغ قبل 24 ساعة من موعد الفعالية..." className="mt-2 min-h-[120px]"/>
                    </div>
                    <div className="flex items-center space-x-2 space-x-reverse">
                        <Checkbox id="allow-refund" />
                        <Label htmlFor="allow-refund">السماح بالاسترجاع التلقائي وفقًا للشروط</Label>
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><CreditCard/>إعدادات الدفع</CardTitle>
                    <CardDescription>اختر وسائل الدفع التي ترغب في توفيرها لعملائك.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="visa-mastercard">بطاقات فيزا وماستركارد</Label>
                        <Checkbox id="visa-mastercard" defaultChecked />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="mada">مدى</Label>
                        <Checkbox id="mada" defaultChecked />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="apple-pay">Apple Pay</Label>
                        <Checkbox id="apple-pay" defaultChecked />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="stc-pay">STC Pay</Label>
                        <Checkbox id="stc-pay" />
                    </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default PoliciesContent;