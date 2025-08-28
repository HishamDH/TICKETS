
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { AlertTriangle, CheckCircle, TrendingUp, UserX } from 'lucide-react';

const recommendations = [
    { title: 'مراجعة تاجر: فعالية الشتاء', reason: 'نمو غير طبيعي في المبيعات بنسبة 300% خلال 24 ساعة.', icon: TrendingUp, color: 'text-amber-500', action: 'مراجعة النشاط' },
    { title: 'تجميد فعالية: تجربة الغوص', reason: 'ارتفاع نسبة طلبات الاسترجاع إلى 40%.', icon: UserX, color: 'text-red-500', action: 'تجميد مؤقت' },
];

const alerts = [
    { text: 'تم بلوغ 90% من سعة فعالية "معرض التقنية".', time: 'قبل 10 دقائق', icon: AlertTriangle, color: 'text-amber-500' },
    { text: 'تمت معالجة 50 طلب سحب بنجاح.', time: 'قبل ساعة', icon: CheckCircle, color: 'text-emerald-500' },
];

const AiSupervision = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">الرقابة الذكية والتحكم الآلي</h1>
                <p className="text-slate-500 mt-1">توصيات وتنبيهات ذكية لتحسين أداء وأمان المنصة.</p>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>توصيات ذكية</CardTitle>
                    <CardDescription>إجراءات مقترحة بناءً على تحليل سلوك المستخدمين والتجار.</CardDescription>
                </CardHeader>
                <CardContent className="grid md:grid-cols-2 gap-6">
                    {recommendations.map((rec, index) => (
                        <Card key={index} className="bg-slate-50">
                            <CardHeader className="flex flex-row items-start gap-4">
                                <rec.icon className={`w-8 h-8 mt-1 ${rec.color}`} />
                                <div>
                                    <CardTitle className="text-base">{rec.title}</CardTitle>
                                    <p className="text-sm text-slate-600 mt-1">{rec.reason}</p>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <Button className="w-full" variant="outline" onClick={() => handleFeatureClick(rec.action)}>{rec.action}</Button>
                            </CardContent>
                        </Card>
                    ))}
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>آخر التنبيهات التلقائية</CardTitle>
                </CardHeader>
                <CardContent>
                    <div className="space-y-4">
                        {alerts.map((alert, index) => (
                            <div key={index} className="flex items-center gap-4 p-3 border-r-4 rounded-md bg-slate-50" style={{borderColor: alert.color.includes('amber') ? '#f59e0b' : '#10b981'}}>
                                <alert.icon className={`w-6 h-6 ${alert.color}`} />
                                <div className="flex-grow">
                                    <p className="text-slate-800">{alert.text}</p>
                                </div>
                                <p className="text-sm text-slate-400">{alert.time}</p>
                            </div>
                        ))}
                    </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default AiSupervision;
