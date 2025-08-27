import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Checkbox } from '@/components/ui/checkbox';
import { Save, FileText, CreditCard } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const PoliciesContent = memo(({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [cancellationPolicy, setCancellationPolicy] = useState('');
    const [allowAutoRefund, setAllowAutoRefund] = useState(false);
    const [enableFinancing, setEnableFinancing] = useState(false);

    useEffect(() => {
        setCancellationPolicy(localStorage.getItem('lilium_night_cancellation_policy_v1') || 'يمكن إلغاء الحجز واسترداد المبلغ كاملاً قبل 15 يومًا من تاريخ المناسبة. يتم خصم 50% من المبلغ في حال الإلغاء قبل 7 أيام. لا يمكن استرداد المبلغ في حال الإلغاء قبل أقل من 7 أيام.');
        setAllowAutoRefund(localStorage.getItem('lilium_night_auto_refund_v1') === 'true');
        setEnableFinancing(localStorage.getItem('lilium_night_financing_v1') === 'true');
    }, []);

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

    const handleSavePolicies = () => {
        localStorage.setItem('lilium_night_cancellation_policy_v1', cancellationPolicy);
        localStorage.setItem('lilium_night_auto_refund_v1', allowAutoRefund.toString());
        localStorage.setItem('lilium_night_financing_v1', enableFinancing.toString());
        handleFeatureClick("حفظ إعدادات السياسات والدفع");
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">السياسات والإعدادات الخاصة بك</h2>
                <Button className="gradient-bg text-white" onClick={handleSavePolicies}><Save className="w-4 h-4 ml-2"/>حفظ الإعدادات</Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><FileText/>سياسة الإلغاء والاسترجاع الخاصة بخدماتك</CardTitle>
                    <CardDescription>حدد الشروط التي يمكن للعملاء بموجبها إلغاء حجوزاتهم واسترداد أموالهم لخدماتك المقدمة عبر ليلة الليليوم.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    <div>
                        <Label htmlFor="cancellation-policy">نص السياسة (سيظهر للعميل عند الحجز)</Label>
                        <Textarea 
                            id="cancellation-policy" 
                            placeholder="مثال: لا يمكن استرجاع المبلغ قبل 24 ساعة من موعد المناسبة..." 
                            className="mt-2 min-h-[120px]"
                            value={cancellationPolicy}
                            onChange={(e) => setCancellationPolicy(e.target.value)}
                        />
                    </div>
                    <div className="flex items-center space-x-2 space-x-reverse">
                        <Checkbox 
                            id="allow-refund" 
                            checked={allowAutoRefund}
                            onCheckedChange={(checked) => {setAllowAutoRefund(!!checked); handleFeatureClick(`تغيير السماح بالاسترجاع التلقائي إلى ${!!checked}`);}}
                        />
                        <Label htmlFor="allow-refund">السماح بالاسترجاع التلقائي وفقًا للشروط المذكورة أعلاه (إذا لم يتم تحديدها، ستتم مراجعة كل طلب إلغاء يدويًا)</Label>
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><CreditCard/>إعدادات الدفع والتمويل</CardTitle>
                    <CardDescription>اختر وسائل الدفع التي ترغب في توفيرها لعملائك، وفعل خيارات التمويل إذا كنت ترغب بذلك.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="visa-mastercard">بطاقات فيزا وماستركارد (عبر بوابة الدفع الرئيسية للمنصة)</Label>
                        <Checkbox id="visa-mastercard" defaultChecked disabled />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="mada">مدى (عبر بوابة الدفع الرئيسية للمنصة)</Label>
                        <Checkbox id="mada" defaultChecked disabled />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="apple-pay">Apple Pay (عبر بوابة الدفع الرئيسية للمنصة)</Label>
                        <Checkbox id="apple-pay" defaultChecked disabled />
                    </div>
                     <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="tamara-tabby">تفعيل خيارات التمويل (تمارا، تابي) لعملائك (تطبق شروط وأحكام شركاء التمويل)</Label>
                        <Checkbox 
                            id="tamara-tabby" 
                            checked={enableFinancing}
                            onCheckedChange={(checked) => {setEnableFinancing(!!checked); handleFeatureClick(`تغيير تفعيل خيارات التمويل إلى ${!!checked}`);}}
                        />
                    </div>
                </CardContent>
            </Card>
        </div>
    );
});

export default PoliciesContent;