import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Search, Eye, TrendingUp, CheckCircle, Percent, Star, FileSearch, AlertCircle } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid, PieChart as RePieChart, Pie, Cell, Legend } from 'recharts';

const initialMerchantGrowthData = [
    { name: 'قصر الأفراح', growth: 30, rating: 4.8, bookings: 150 },
    { name: 'استوديو الإبداع', growth: 15, rating: 4.5, bookings: 120 },
    { name: 'بوفيه الكرم', growth: 25, rating: 4.2, bookings: 100 },
    { name: 'زهور الربيع', growth: -5, rating: 3.9, bookings: 80 },
];
const COLORS_RATING = ['#10b981', '#f59e0b', '#ef4444', '#6366f1'];


const initialNewServices = [
    { id: 'ns1', name: 'تجربة القفز المظلي (جديد)', merchant: 'مغامرات السماء', category: 'تجارب', status: 'بانتظار المراجعة', submissionDate: '2025-06-25' },
    { id: 'ns2', name: 'باقة الزفاف الماسية (محدث)', merchant: 'قصر الأفراح الملكية', category: 'قاعات', status: 'تمت المراجعة', submissionDate: '2025-06-20' },
];

const ReviewTools = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [searchTerm, setSearchTerm] = useState('');
    const [merchantData, setMerchantData] = useState(null);
    const [newServices, setNewServices] = useState(initialNewServices);

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

    const handleSearchMerchant = () => {
        if (!searchTerm) {
            toast({ title: "خطأ", description: "الرجاء إدخال اسم مزود خدمة للبحث.", variant: "destructive"});
            setMerchantData(null);
            return;
        }
        const found = initialMerchantGrowthData.find(m => m.name.toLowerCase().includes(searchTerm.toLowerCase()));
        setMerchantData(found || {name: searchTerm, notFound: true});
        handleFeatureClick(`البحث عن مزود الخدمة: ${searchTerm}`);
    };

    const handleReviewService = (serviceId) => {
        setNewServices(prev => prev.map(s => s.id === serviceId ? {...s, status: 'تمت المراجعة'} : s));
        const serviceName = newServices.find(s => s.id === serviceId)?.name;
        handleFeatureClick(`مراجعة الخدمة الجديدة: ${serviceName}`);
    };
    
    const CustomTooltip = ({ active, payload, label }) => {
        if (active && payload && payload.length) {
            return (
            <div className="bg-white p-3 border rounded-lg shadow-lg text-sm">
                <p className="font-bold text-slate-700">{label}</p>
                {payload.map(pld => (
                    <p key={pld.dataKey} style={{color: pld.fill || pld.stroke}}>
                        {pld.name}: {pld.value.toLocaleString()} {pld.dataKey === 'growth' ? '%' : pld.dataKey === 'rating' ? '' : ''}
                    </p>
                ))}
            </div>
            );
        }
        return null;
    };

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <h1 className="text-3xl font-bold text-slate-800">أدوات مراجعة وتقييم الأداء</h1>
                <p className="text-slate-500 mt-1">تحليل أداء مزوّدي الخدمات، ومراجعة الخدمات الجديدة والمحدّثة.</p>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><Search/> البحث عن مزوّد خدمة وتحليل أدائه</CardTitle>
                </CardHeader>
                <CardContent className="space-y-4">
                    <div className="flex gap-2">
                        <Input placeholder="ادخل اسم مزوّد الخدمة..." value={searchTerm} onChange={(e) => setSearchTerm(e.target.value)} />
                        <Button onClick={handleSearchMerchant}>بحث</Button>
                    </div>
                    {merchantData && (
                        merchantData.notFound ? (
                             <div className="p-4 bg-amber-50 border border-amber-200 rounded-md text-amber-700 flex items-center gap-2">
                                <AlertCircle className="w-5 h-5"/> لم يتم العثور على مزود خدمة بهذا الاسم.
                            </div>
                        ) : (
                        <Card className="bg-slate-50">
                            <CardHeader><CardTitle>{merchantData.name}</CardTitle></CardHeader>
                            <CardContent className="grid md:grid-cols-3 gap-4 text-center">
                                <div><p className="text-sm text-slate-500">نسبة النمو (30 يوم)</p><p className="text-2xl font-bold text-primary flex items-center justify-center gap-1">{merchantData.growth}% <TrendingUp className="w-5 h-5"/></p></div>
                                <div><p className="text-sm text-slate-500">متوسط التقييم</p><p className="text-2xl font-bold text-amber-500 flex items-center justify-center gap-1">{merchantData.rating} <Star className="w-5 h-5"/></p></div>
                                <div><p className="text-sm text-slate-500">إجمالي الحجوزات</p><p className="text-2xl font-bold text-sky-500">{merchantData.bookings}</p></div>
                            </CardContent>
                        </Card>
                        )
                    )}
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><TrendingUp/> تحليل نمو مزوّدي الخدمات (أفضل 4)</CardTitle>
                </CardHeader>
                <CardContent className="h-96">
                     <ResponsiveContainer width="100%" height="100%">
                        <BarChart data={initialMerchantGrowthData} margin={{ top: 5, right: 20, left: -10, bottom: 5 }}>
                            <CartesianGrid strokeDasharray="3 3" vertical={false} />
                            <XAxis dataKey="name" stroke="#888888" fontSize={12} />
                            <YAxis yAxisId="left" stroke="#888888" fontSize={12} unit="%" />
                            <YAxis yAxisId="right" orientation="right" stroke="#888888" fontSize={12} />
                            <Tooltip content={<CustomTooltip />} cursor={{fill: 'rgba(16, 185, 129, 0.05)'}}/>
                            <Legend />
                            <Bar yAxisId="left" dataKey="growth" name="نسبة النمو" fill="var(--color-primary)" radius={[4, 4, 0, 0]} />
                            <Bar yAxisId="right" dataKey="rating" name="التقييم" fill="#f59e0b" radius={[4, 4, 0, 0]} />
                            <Bar yAxisId="right" dataKey="bookings" name="الحجوزات" fill="#38bdf8" radius={[4, 4, 0, 0]} />
                        </BarChart>
                    </ResponsiveContainer>
                </CardContent>
            </Card>
            
            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><FileSearch/> مراجعة الخدمات الجديدة/المحدثة</CardTitle>
                </CardHeader>
                <CardContent className="space-y-3">
                    {newServices.map(service => (
                        <div key={service.id} className="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3 border rounded-md bg-slate-50">
                            <div>
                                <p className="font-semibold">{service.name}</p>
                                <p className="text-sm text-slate-500">التاجر: {service.merchant} | الفئة: {service.category} | تاريخ الإرسال: {service.submissionDate}</p>
                            </div>
                            {service.status === 'بانتظار المراجعة' ? (
                                <Button size="sm" variant="outline" className="mt-2 sm:mt-0 text-amber-600 border-amber-500 hover:bg-amber-50" onClick={() => handleReviewService(service.id)}><Eye className="w-4 h-4 ml-2"/>مراجعة الآن</Button>
                            ) : (
                                <p className="text-sm text-emerald-600 flex items-center gap-1 mt-2 sm:mt-0"><CheckCircle className="w-4 h-4"/> {service.status}</p>
                            )}
                        </div>
                    ))}
                    {newServices.length === 0 && <p className="text-slate-500 text-center py-4">لا توجد خدمات جديدة للمراجعة حالياً.</p>}
                </CardContent>
            </Card>
        </div>
    );
};

export default ReviewTools;