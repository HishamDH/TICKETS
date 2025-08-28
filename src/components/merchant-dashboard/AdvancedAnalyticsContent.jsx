
import React from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { LineChart, Line, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid, Area, AreaChart } from 'recharts';
import { Lightbulb, TrendingUp, Users, DollarSign, ArrowRight, Activity } from 'lucide-react';

const forecastData = [
    { name: 'مايو', الفعلي: 6000, المتوقع: 6000 },
    { name: 'يونيو', الفعلي: 5500, المتوقع: 5500 },
    { name: 'يوليو', الفعلي: 7200, المتوقع: 7200 },
    { name: 'أغسطس', المتوقع: 7500 },
    { name: 'سبتمبر', المتوقع: 8200 },
    { name: 'أكتوبر', المتوقع: 7800 },
];

const insights = [
    {
        icon: Activity,
        title: "أفضل وقت للنشر",
        description: "أفضل وقت لنشر فعاليتك القادمة هو يوم الخميس الساعة 6 مساءً لزيادة الوصول بنسبة 30%.",
        color: "text-sky-500"
    },
    {
        icon: DollarSign,
        title: "فرصة لزيادة السعر",
        description: "خدمة \"تجربة الغوص\" عالية الطلب. يمكنك زيادة سعرها بنسبة 10% دون التأثير على الحجوزات.",
        color: "text-green-500"
    },
    {
        icon: Users,
        title: "العملاء الأكثر ولاءً",
        description: "أكثر من 40% من حجوزاتك تأتي من عملاء عائدين. فكّر في إطلاق برنامج مكافآت.",
        color: "text-indigo-500"
    }
];

const customerSegments = [
    { name: "العملاء الأوفياء", percentage: "42%", description: "عملاء قاموا بالحجز 3 مرات أو أكثر." },
    { name: "الباحثون عن العروض", percentage: "25%", description: "عملاء يستخدمون أكواد الخصم بشكل متكرر." },
    { name: "الحجوزات العائلية", percentage: "18%", description: "عملاء يقومون بحجز 3 تذاكر أو أكثر في المتوسط." },
    { name: "الزوار الجدد", percentage: "15%", description: "عملاء قاموا بأول حجز لهم هذا الشهر." },
];

const AdvancedAnalyticsContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <div className="flex justify-between items-start">
                <div>
                    <h2 className="text-3xl font-bold text-slate-800">الذكاء والتحليلات المتقدمة</h2>
                    <p className="text-slate-500 mt-2">استخدم قوة البيانات لاتخاذ قرارات أفضل وتنمية أعمالك.</p>
                </div>
            </div>
            
            <Card className="bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-50">
                <CardHeader>
                    <CardTitle className="flex items-center gap-2 text-indigo-800"><Lightbulb /> رؤى ذكية قابلة للتنفيذ</CardTitle>
                    <CardDescription className="text-indigo-700">اقتراحات مولّدة بالذكاء الاصطناعي بناءً على بياناتك.</CardDescription>
                </CardHeader>
                <CardContent className="grid md:grid-cols-3 gap-4">
                    {insights.map((insight, index) => (
                        <div key={index} className="bg-white/60 p-4 rounded-lg shadow-sm backdrop-blur-sm border border-white/50">
                            <div className="flex items-center gap-3">
                                <div className={`w-10 h-10 rounded-lg flex items-center justify-center bg-white ${insight.color}`}>
                                    <insight.icon className="w-5 h-5"/>
                                </div>
                                <h3 className="font-bold text-slate-800">{insight.title}</h3>
                            </div>
                            <p className="mt-3 text-sm text-slate-600">{insight.description}</p>
                        </div>
                    ))}
                </CardContent>
            </Card>

            <div className="grid lg:grid-cols-5 gap-8">
                <Card className="lg:col-span-3">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><TrendingUp /> توقعات الأداء</CardTitle>
                        <CardDescription>توقعات المبيعات للأشهر القادمة بناءً على أدائك السابق.</CardDescription>
                    </CardHeader>
                    <CardContent className="h-72">
                        <ResponsiveContainer width="100%" height="100%">
                            <AreaChart data={forecastData} margin={{ top: 5, right: 20, left: -10, bottom: 5 }}>
                                <defs>
                                    <linearGradient id="colorActual" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="5%" stopColor="#3b82f6" stopOpacity={0.8}/>
                                        <stop offset="95%" stopColor="#3b82f6" stopOpacity={0}/>
                                    </linearGradient>
                                     <linearGradient id="colorForecast" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="5%" stopColor="#8b5cf6" stopOpacity={0.4}/>
                                        <stop offset="95%" stopColor="#8b5cf6" stopOpacity={0}/>
                                    </linearGradient>
                                </defs>
                                <CartesianGrid strokeDasharray="3 3" vertical={false} />
                                <XAxis dataKey="name" fontSize={12} />
                                <YAxis fontSize={12} tickFormatter={(value) => `${value / 1000} ألف`} />
                                <Tooltip
                                    contentStyle={{
                                        borderRadius: '0.5rem',
                                        borderColor: 'rgba(200, 200, 200, 0.3)',
                                        backgroundColor: 'rgba(255, 255, 255, 0.8)',
                                        backdropFilter: 'blur(4px)',
                                    }}
                                />
                                <Area type="monotone" dataKey="الفعلي" stroke="#3b82f6" fill="url(#colorActual)" strokeWidth={2} name="المبيعات الفعلية" />
                                <Area type="monotone" dataKey="المتوقع" stroke="#8b5cf6" fill="url(#colorForecast)" strokeWidth={2} strokeDasharray="5 5" name="المبيعات المتوقعة" />
                            </AreaChart>
                        </ResponsiveContainer>
                    </CardContent>
                </Card>

                <Card className="lg:col-span-2">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Users /> شرائح العملاء الرئيسية</CardTitle>
                         <CardDescription>تعرّف على أهم مجموعات عملائك.</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-3">
                        {customerSegments.map((segment, index) => (
                            <div key={index} className="p-3 bg-slate-50 rounded-lg">
                                <div className="flex justify-between items-center mb-1">
                                    <p className="font-semibold text-slate-700">{segment.name}</p>
                                    <p className="font-bold text-primary text-lg">{segment.percentage}</p>
                                </div>
                                <p className="text-xs text-slate-500">{segment.description}</p>
                            </div>
                        ))}
                         <div className="pt-2 flex justify-end">
                            <Button variant="link" className="p-0 h-auto text-primary" onClick={() => handleFeatureClick("عرض كل الشرائح")}>
                                عرض تحليل مفصل
                               <ArrowRight className="w-4 h-4 mr-2" />
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    );
};

export default AdvancedAnalyticsContent;
