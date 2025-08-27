import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Download, BarChart2, PieChart, Users, Calendar } from 'lucide-react';
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid, Pie, Cell } from 'recharts';
import { useToast } from "@/components/ui/use-toast";

const salesData = [
    { name: 'يناير', sales: 40000 }, { name: 'فبراير', sales: 30000 }, { name: 'مارس', sales: 50000 },
    { name: 'أبريل', sales: 45000 }, { name: 'مايو', sales: 60000 }, { name: 'يونيو', sales: 55000 },
];

const serviceData = [
    { name: 'قاعات الأفراح', value: 400 }, { name: 'خدمات التصوير', value: 300 },
    { name: 'بوفيهات الضيافة', value: 300 }, { name: 'تنسيق الزهور', value: 200 },
];
const COLORS = ['#6366f1', '#38bdf8', '#f59e0b', '#10b981'];

const ReportsContent = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick && typeof propHandleFeatureClick === 'function') {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
                variant: "default",
            });
        }
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">التقارير والتحليلات</h2>
                <Button variant="outline" onClick={() => handleFeatureClick("تصدير كل التقارير")}><Download className="w-4 h-4 ml-2"/>تصدير الكل</Button>
            </div>

            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <Card><CardHeader><CardTitle className="flex items-center gap-2"><BarChart2/>إجمالي الإيرادات</CardTitle></CardHeader><CardContent className="text-3xl font-bold">452,310 ريال</CardContent></Card>
                <Card><CardHeader><CardTitle className="flex items-center gap-2"><PieChart/>نسبة الإلغاء</CardTitle></CardHeader><CardContent className="text-3xl font-bold">5.4%</CardContent></Card>
                <Card><CardHeader><CardTitle className="flex items-center gap-2"><Users/>إجمالي الحجوزات</CardTitle></CardHeader><CardContent className="text-3xl font-bold">1,890</CardContent></Card>
                <Card><CardHeader><CardTitle className="flex items-center gap-2"><Calendar/>أوقات الذروة للحجوزات</CardTitle></CardHeader><CardContent className="text-xl font-bold">الخميس - 8 مساءً</CardContent></Card>
            </div>

            <div className="grid lg:grid-cols-2 gap-6">
                <Card>
                    <CardHeader>
                        <CardTitle>تقرير الإيرادات الشهري</CardTitle>
                        <CardDescription>نظرة على أداء إيرادات خدماتك خلال الأشهر الماضية.</CardDescription>
                    </CardHeader>
                    <CardContent className="h-72">
                        <ResponsiveContainer width="100%" height="100%">
                            <BarChart data={salesData}>
                                <CartesianGrid strokeDasharray="3 3" vertical={false} />
                                <XAxis dataKey="name" fontSize={12} />
                                <YAxis fontSize={12} tickFormatter={(value) => `${value / 1000} ألف`} />
                                <Tooltip cursor={{ fill: 'rgba(99, 102, 241, 0.1)' }} formatter={(value) => `${value.toLocaleString('ar-SA')} ريال`} />
                                <Bar dataKey="sales" fill="var(--color-primary)" radius={[4, 4, 0, 0]} name="المبيعات"/>
                            </BarChart>
                        </ResponsiveContainer>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>أداء أنواع الخدمات</CardTitle>
                        <CardDescription>توزيع الحجوزات على أنواع الخدمات المختلفة التي تقدمها.</CardDescription>
                    </CardHeader>
                    <CardContent className="h-72">
                        <ResponsiveContainer width="100%" height="100%">
                            <PieChart>
                                <Pie data={serviceData} cx="50%" cy="50%" labelLine={false} outerRadius={80} fill="#8884d8" dataKey="value" nameKey="name" label={({ name, percent }) => `${name} ${(percent * 100).toFixed(0)}%`}>
                                    {serviceData.map((entry, index) => (
                                        <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
                                    ))}
                                </Pie>
                                <Tooltip formatter={(value, name) => [`${value} حجز`, name]}/>
                            </PieChart>
                        </ResponsiveContainer>
                    </CardContent>
                </Card>
            </div>
        </div>
    );
};

export default ReportsContent;