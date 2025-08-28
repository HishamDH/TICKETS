
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Download } from 'lucide-react';
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid, PieChart, Pie, Cell, Legend } from 'recharts';

const merchantSalesData = [
    { name: 'مطعم الذواقة', sales: 12000 }, { name: 'فعالية الشتاء', sales: 25000 },
    { name: 'مؤتمر TechCon', sales: 8000 }, { name: 'تجربة الغوص', sales: 5000 },
];

const cancellationData = [
    { name: 'إلغاء من العميل', value: 65 }, { name: 'إلغاء من التاجر', value: 20 },
    { name: 'فشل الدفع', value: 15 },
];
const COLORS = ['#f59e0b', '#ef4444', '#64748b'];

const ReportsAnalytics = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">التقارير والتحليلات الذكية</h1>
                    <p className="text-slate-500 mt-1">بيانات تفصيلية حول أداء المنصة والتجار.</p>
                </div>
                <Button variant="outline" onClick={() => handleFeatureClick("تصدير كل التقارير")}><Download className="w-4 h-4 ml-2"/>تصدير الكل</Button>
            </div>

            <div className="grid lg:grid-cols-2 gap-6">
                <Card>
                    <CardHeader>
                        <CardTitle>مقارنة أداء التجار (آخر 30 يوم)</CardTitle>
                    </CardHeader>
                    <CardContent className="h-80">
                        <ResponsiveContainer width="100%" height="100%">
                            <BarChart data={merchantSalesData} layout="vertical">
                                <CartesianGrid strokeDasharray="3 3" horizontal={false} />
                                <XAxis type="number" fontSize={12} tickFormatter={(value) => `${value / 1000}k`} />
                                <YAxis type="category" dataKey="name" width={100} fontSize={12} />
                                <Tooltip cursor={{ fill: 'rgba(99, 102, 241, 0.1)' }} />
                                <Bar dataKey="sales" fill="var(--color-primary)" radius={[0, 4, 4, 0]} />
                            </BarChart>
                        </ResponsiveContainer>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>تحليل أسباب إلغاء الحجوزات</CardTitle>
                    </CardHeader>
                    <CardContent className="h-80">
                        <ResponsiveContainer width="100%" height="100%">
                            <PieChart>
                                <Pie data={cancellationData} cx="50%" cy="50%" innerRadius={60} outerRadius={80} fill="#8884d8" dataKey="value" nameKey="name" paddingAngle={5}>
                                    {cancellationData.map((entry, index) => (
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

export default ReportsAnalytics;
