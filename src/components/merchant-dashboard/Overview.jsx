
import React from 'react';
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { TrendingUp, Ticket, Wallet, Sparkles } from 'lucide-react';

const OverviewContent = ({ handleFeatureClick }) => {
    const stats = [
        { title: "إجمالي المبيعات (اليوم)", value: "2,560 ريال", icon: TrendingUp, color: "from-green-400 to-emerald-500" },
        { title: "الحجوزات النشطة", value: "78", icon: Ticket, color: "from-blue-400 to-sky-500" },
        { title: "الرصيد المتاح", value: "15,300 ريال", icon: Wallet, color: "gradient-bg" },
        { title: "أكثر الفعاليات حجزاً", value: "معرض التقنية", icon: Sparkles, color: "from-amber-400 to-orange-500" }
    ];
    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">نظرة عامة</h2>
            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                {stats.map((stat, index) => (
                    <Card key={index} className="card-hover" onClick={() => handleFeatureClick(stat.title)}>
                        <CardHeader className="flex flex-row items-center justify-between pb-2">
                            <CardTitle className="text-sm font-medium text-slate-500">{stat.title}</CardTitle>
                            <div className={`w-8 h-8 flex items-center justify-center rounded-lg text-white ${stat.color}`}>
                                <stat.icon className="h-5 w-5" />
                            </div>
                        </CardHeader>
                        <CardContent>
                            <p className="text-3xl font-bold text-slate-900">{stat.value}</p>
                        </CardContent>
                    </Card>
                ))}
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>الإشعارات الجديدة</CardTitle>
                </CardHeader>
                <CardContent>
                     <p className="text-slate-500">لا توجد إشعارات جديدة حالياً.</p>
                </CardContent>
            </Card>
        </div>
    );
};

export default OverviewContent;
