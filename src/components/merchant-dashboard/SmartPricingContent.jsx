import React, { useState, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from "@/components/ui/switch";
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Slider } from "@/components/ui/slider";
import { BrainCircuit, TrendingUp, TrendingDown, DollarSign } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { ResponsiveContainer, LineChart, Line, XAxis, YAxis, Tooltip } from 'recharts';

const mockPriceData = [
  { name: 'قبل 30 يوم', price: 100 },
  { name: 'قبل 20 يوم', price: 110 },
  { name: 'قبل 10 أيام', price: 150 },
  { name: 'اليوم', price: 120 },
  { name: 'بعد 10 أيام', price: 90 },
  { name: 'بعد 20 يوم', price: 80 },
  { name: 'بعد 30 يوم', price: 75 },
];


const SmartPricingContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [isEnabled, setIsEnabled] = useState(false);
    const [aggressiveness, setAggressiveness] = useState([50]);
    const [minPrice, setMinPrice] = useState('');
    const [maxPrice, setMaxPrice] = useState('');

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

    const handleSave = () => {
        toast({
            title: "تم الحفظ!",
            description: "تم حفظ إعدادات التسعير الديناميكي بنجاح.",
        });
        handleFeatureClick("حفظ إعدادات التسعير الديناميكي");
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800 flex items-center gap-3"><BrainCircuit className="w-8 h-8 text-primary"/>التسعير الديناميكي (تجريبي)</h2>
            </div>
            
            <Card>
                <CardHeader>
                    <div className="flex justify-between items-start">
                        <div>
                            <CardTitle>تفعيل التسعير الذكي</CardTitle>
                            <CardDescription>اسمح للنظام بتعديل أسعارك تلقائياً بناءً على الطلب والمواسم لزيادة أرباحك.</CardDescription>
                        </div>
                        <div className="flex items-center space-x-2 space-x-reverse pt-1">
                            <Switch id="smart-pricing-toggle" checked={isEnabled} onCheckedChange={(val) => { setIsEnabled(val); handleFeatureClick(`تغيير حالة التسعير الذكي إلى ${val}`);}}/>
                            <Label htmlFor="smart-pricing-toggle" className="text-lg font-semibold">{isEnabled ? "مفعّل" : "متوقف"}</Label>
                        </div>
                    </div>
                </CardHeader>
                <CardContent className={`space-y-6 transition-opacity ${isEnabled ? 'opacity-100' : 'opacity-50 pointer-events-none'}`}>
                    <div className="grid md:grid-cols-2 gap-6">
                        <div>
                            <Label htmlFor="minPrice">الحد الأدنى للسعر (ريال)</Label>
                            <Input id="minPrice" type="number" placeholder="مثال: 5000" value={minPrice} onChange={(e) => setMinPrice(e.target.value)} />
                            <p className="text-xs text-slate-500 mt-1">لن يتم عرض سعر أقل من هذا المبلغ.</p>
                        </div>
                        <div>
                            <Label htmlFor="maxPrice">الحد الأقصى للسعر (ريال)</Label>
                            <Input id="maxPrice" type="number" placeholder="مثال: 20000" value={maxPrice} onChange={(e) => setMaxPrice(e.target.value)} />
                             <p className="text-xs text-slate-500 mt-1">لن يتم عرض سعر أعلى من هذا المبلغ.</p>
                        </div>
                    </div>
                     <div>
                        <Label>مدى قوة تغيير الأسعار</Label>
                         <div className="flex items-center gap-4 mt-2">
                             <TrendingDown className="text-green-500"/>
                             <Slider defaultValue={aggressiveness} max={100} step={1} onValueChange={setAggressiveness}/>
                             <TrendingUp className="text-red-500"/>
                         </div>
                         <p className="text-center text-sm text-slate-600 mt-1">
                            {aggressiveness < 33 ? 'تغييرات طفيفة ومحافظة' : aggressiveness < 66 ? 'تغييرات متوازنة' : 'تغييرات قوية وجريئة'}
                         </p>
                    </div>
                </CardContent>
                <CardFooter className="flex justify-end border-t pt-4">
                    <Button onClick={handleSave} disabled={!isEnabled}>
                        <DollarSign className="w-4 h-4 ml-2"/> حفظ إعدادات التسعير
                    </Button>
                </CardFooter>
            </Card>

             <Card>
                <CardHeader>
                    <CardTitle>محاكاة توقعات الأسعار</CardTitle>
                    <CardDescription>رسم بياني يوضح كيف قد تتغير أسعارك بناءً على الإعدادات الحالية.</CardDescription>
                </CardHeader>
                <CardContent className="h-72">
                    <ResponsiveContainer width="100%" height="100%">
                        <LineChart data={mockPriceData}>
                            <XAxis dataKey="name" fontSize={12} />
                            <YAxis domain={['dataMin - 20', 'dataMax + 20']} fontSize={12} />
                            <Tooltip formatter={(value) => [`${value} ريال`, 'السعر المتوقع']} />
                            <Line type="monotone" dataKey="price" stroke="var(--color-primary)" strokeWidth={2} />
                        </LineChart>
                    </ResponsiveContainer>
                </CardContent>
            </Card>
        </div>
    );
});

export default SmartPricingContent;