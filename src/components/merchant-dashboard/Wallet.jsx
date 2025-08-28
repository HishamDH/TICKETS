
import React from 'react';
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Banknote } from 'lucide-react';

const WalletContent = ({ handleFeatureClick }) => (
    <div className="space-y-8">
        <h2 className="text-3xl font-bold text-slate-800">المحفظة المالية والسحب</h2>
        <div className="grid md:grid-cols-3 gap-6">
            <Card><CardHeader><CardTitle>الرصيد الحالي</CardTitle></CardHeader><CardContent className="text-3xl font-bold">15,300 ريال</CardContent></Card>
            <Card><CardHeader><CardTitle>الرصيد المحجوز</CardTitle></CardHeader><CardContent className="text-3xl font-bold">3,150 ريال</CardContent></Card>
            <Card><CardHeader><CardTitle>عمولة المنصة</CardTitle></CardHeader><CardContent className="text-3xl font-bold">5%</CardContent></Card>
        </div>
        <Card>
            <CardHeader className="flex-row justify-between items-center">
                <CardTitle>سجل السحوبات</CardTitle>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("طلب سحب جديد")}><Banknote className="w-4 h-4 ml-2"/>طلب سحب</Button>
            </CardHeader>
            <CardContent>
                <p className="text-slate-500">لا توجد عمليات سحب سابقة.</p>
            </CardContent>
        </Card>
    </div>
);

export default WalletContent;
