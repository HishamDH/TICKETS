import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { BrainCircuit, TrendingUp, PieChart, Users, Lightbulb } from 'lucide-react';
import { Bar, BarChart, Line, LineChart, XAxis, YAxis, Tooltip, Legend, ResponsiveContainer, Pie, Cell } from 'recharts';
import { Button } from '@/components/ui/button';

const bookingData = [
    { month: 'يناير', online: 20, internal: 15 },
    { month: 'فبراير', online: 25, internal: 18 },
    { month: 'مارس', online: 35, internal: 22 },
    { month: 'أبريل', online: 30, internal: 25 },
    { month: 'مايو', online: 45, internal: 30 },
    { month: 'يونيو', online: 50, internal: 35 },
];

const revenueData = [
    { name: 'الباقة الذهبية', value: 450000 },
    { name: 'الباقة الفضية', value: 250000 },
    { name: 'تصوير', value: 150000 },
    { name: 'إضافات', value: 80000 },
];

const COLORS = ['#0088FE', '#00C49F', '#FFBB28', '#FF8042'];

const AdvancedAnalyticsContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">التحليلات المتقدمة والذكاء الاصطناعي</h2>
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <Card className="lg:col-span-3">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><BrainCircuit /> رؤى مدعومة بالذكاء الاصطناعي</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div className="text-lg text-slate-700 bg-blue-50 border-r-4 border-blue-500 p-4 rounded-md">
                            <p className="flex items-start gap-2">
                                <Lightbulb className="w-6 h-6 text-blue-500 mt-1 shrink-0"/>
                                <span>
                                    <strong>توصية تسعير ديناميكي:</strong> لاحظنا زيادة في الطلب على <strong>"الباقة الذهبية"</strong> بنسبة 30% في عطلات نهاية الأسبوع. نقترح رفع سعرها بنسبة 10% في هذه الأيام لزيادة الأرباح.
                                </span>
                            </p>
                            <Button size="sm" className="mt-3" onClick={() => handleFeatureClick("تطبيق توصية التسعير الديناميكي")}>تطبيق التوصية</Button>
                        </div>
                         <div className="text-lg text-slate-700 bg-green-50 border-r-4 border-green-500 p-4 rounded-md">
                            <p className="flex items-start gap-2">
                                <Lightbulb className="w-6 h-6 text-green-500 mt-1 shrink-0"/>
                                <span>
                                    <strong>فرصة تسويقية:</strong> معظم حجوزات "خدمات التصوير" تأتي من عملاء في جدة. نقترح إنشاء حملة إعلانية موجهة لسكان جدة للترويج لهذه الخدمة.
                                </span>
                            </p>
                             <Button size="sm" className="mt-3" onClick={() => handleFeatureClick("إنشاء حملة إعلانية موجهة")}>إنشاء حملة إعلانية</Button>
                        </div>
                    </CardContent>
                </Card>

                <Card className="lg:col-span-2">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><TrendingUp /> نمو الحجوزات (آخر 6 أشهر)</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <ResponsiveContainer width="100%" height={300}>
                            <LineChart data={bookingData}>
                                <XAxis dataKey="month" />
                                <YAxis />
                                <Tooltip />
                                <Legend />
                                <Line type="monotone" dataKey="online" name="أونلاين" stroke="#8884d8" />
                                <Line type="monotone" dataKey="internal" name="داخلي" stroke="#82ca9d" />
                            </LineChart>
                        </ResponsiveContainer>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><PieChart /> توزيع الإيرادات حسب الباقة</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <ResponsiveContainer width="100%" height={300}>
                            <PieChart>
                                <Pie data={revenueData} dataKey="value" nameKey="name" cx="50%" cy="50%" outerRadius={100} fill="#8884d8" label>
                                    {revenueData.map((entry, index) => (
                                        <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
                                    ))}
                                </Pie>
                                <Tooltip />
                                <Legend />
                            </PieChart>
                        </ResponsiveContainer>
                    </CardContent>
                </Card>
            </div>
        </div>
    );
};

export default AdvancedAnalyticsContent;