import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Search, BarChart, Eye, UserCheck } from 'lucide-react';
import { Input } from '@/components/ui/input';

const ReviewTools = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">أدوات المراجعة والتحكم الذكي</h1>
                <p className="text-slate-500 mt-1">أدوات يدوية للمراجعة والتحليل السريع.</p>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><UserCheck /> مراجعة نشاط تاجر</CardTitle>
                    <CardDescription>ابحث عن تاجر لعرض سجل نشاطه الكامل وتحليل أدائه.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="flex gap-2">
                        <Input placeholder="ابحث بالاسم أو البريد الإلكتروني للتاجر..." />
                        <Button onClick={() => handleFeatureClick("بحث عن تاجر")}><Search className="w-4 h-4 ml-2"/>بحث</Button>
                    </div>
                </CardContent>
            </Card>

            <div className="grid md:grid-cols-2 gap-6">
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><BarChart /> تحليل النمو</CardTitle>
                        <CardDescription>أداة لتحليل نمو التجار ومقارنتهم بناءً على معايير محددة.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Button className="w-full" variant="outline" onClick={() => handleFeatureClick("فتح أداة تحليل النمو")}>فتح الأداة</Button>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Eye /> مراقبة التجارب الجديدة</CardTitle>
                        <CardDescription>مراجعة خدمات "التجارب" الجديدة قبل نشرها بشكل رسمي للعموم.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Button className="w-full" variant="outline" onClick={() => handleFeatureClick("عرض التجارب قيد المراجعة")}>عرض التجارب</Button>
                    </CardContent>
                </Card>
            </div>
        </div>
    );
};

export default ReviewTools;