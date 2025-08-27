import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Switch } from '@/components/ui/switch';
import { HeartHandshake, Star, Gift, Users, Settings, Award } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const LoyaltyProgramContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [programSettings, setProgramSettings] = useState(JSON.parse(localStorage.getItem('lilium_night_loyalty_settings_v1')) || {
        enabled: true,
        pointsPerRiyal: 1,
        pointsForReview: 50,
        pointsForReferral: 100,
        minimumRedemption: 100
    });
    const [rewards, setRewards] = useState(JSON.parse(localStorage.getItem('lilium_night_loyalty_rewards_v1')) || [
        { id: 'REW-001', name: 'خصم 10%', description: 'خصم 10% على الحجز التالي', pointsCost: 100, type: 'discount', value: 10, active: true },
        { id: 'REW-002', name: 'تصوير مجاني لساعة', description: 'ساعة تصوير مجانية', pointsCost: 300, type: 'service', value: 0, active: true },
        { id: 'REW-003', name: 'خصم 50 ريال', description: 'خصم نقدي 50 ريال', pointsCost: 200, type: 'cash', value: 50, active: true },
    ]);
    const [customers, setCustomers] = useState(JSON.parse(localStorage.getItem('lilium_night_loyalty_customers_v1')) || [
        { id: 'CUST-001', name: 'أحمد محمد', email: 'ahmed@example.com', points: 250, totalSpent: 5000, bookings: 3, tier: 'ذهبي' },
        { id: 'CUST-002', name: 'فاطمة علي', email: 'fatima@example.com', points: 150, totalSpent: 3000, bookings: 2, tier: 'فضي' },
        { id: 'CUST-003', name: 'خالد سالم', email: 'khalid@example.com', points: 80, totalSpent: 1500, bookings: 1, tier: 'برونزي' },
    ]);

    useEffect(() => {
        localStorage.setItem('lilium_night_loyalty_settings_v1', JSON.stringify(programSettings));
    }, [programSettings]);

    useEffect(() => {
        localStorage.setItem('lilium_night_loyalty_rewards_v1', JSON.stringify(rewards));
    }, [rewards]);

    useEffect(() => {
        localStorage.setItem('lilium_night_loyalty_customers_v1', JSON.stringify(customers));
    }, [customers]);

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

    const handleSettingChange = (setting, value) => {
        setProgramSettings(prev => ({ ...prev, [setting]: value }));
        handleFeatureClick(`تغيير إعداد برنامج الولاء: ${setting}`);
    };

    const getTierColor = (tier) => {
        switch(tier) {
            case 'ذهبي': return 'bg-yellow-100 text-yellow-800';
            case 'فضي': return 'bg-slate-100 text-slate-800';
            case 'برونزي': return 'bg-orange-100 text-orange-800';
            default: return 'bg-slate-100 text-slate-600';
        }
    };

    const handleAwardPoints = (customerId, points) => {
        setCustomers(customers.map(c => c.id === customerId ? { ...c, points: c.points + points } : c));
        const customer = customers.find(c => c.id === customerId);
        toast({ title: "تم منح النقاط!", description: `تم منح ${points} نقطة للعميل ${customer?.name}.` });
        handleFeatureClick(`منح ${points} نقطة للعميل ${customer?.name}`);
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">برنامج ولاء العملاء</h2>
            </div>
            
            <div className="grid lg:grid-cols-3 gap-8">
                <Card className="lg:col-span-1">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Settings /> إعدادات البرنامج</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-6">
                        <div className="flex items-center justify-between">
                            <Label htmlFor="program-enabled">تفعيل برنامج الولاء</Label>
                            <Switch id="program-enabled" checked={programSettings.enabled} onCheckedChange={(checked) => handleSettingChange('enabled', checked)} />
                        </div>
                        
                        <div className="space-y-2">
                            <Label htmlFor="points-per-riyal">النقاط لكل ريال مُنفق</Label>
                            <Input id="points-per-riyal" type="number" value={programSettings.pointsPerRiyal} onChange={(e) => handleSettingChange('pointsPerRiyal', parseInt(e.target.value))} />
                        </div>
                        
                        <div className="space-y-2">
                            <Label htmlFor="points-review">نقاط كتابة تقييم</Label>
                            <Input id="points-review" type="number" value={programSettings.pointsForReview} onChange={(e) => handleSettingChange('pointsForReview', parseInt(e.target.value))} />
                        </div>
                        
                        <div className="space-y-2">
                            <Label htmlFor="points-referral">نقاط إحالة عميل جديد</Label>
                            <Input id="points-referral" type="number" value={programSettings.pointsForReferral} onChange={(e) => handleSettingChange('pointsForReferral', parseInt(e.target.value))} />
                        </div>
                        
                        <div className="space-y-2">
                            <Label htmlFor="min-redemption">الحد الأدنى لاستبدال النقاط</Label>
                            <Input id="min-redemption" type="number" value={programSettings.minimumRedemption} onChange={(e) => handleSettingChange('minimumRedemption', parseInt(e.target.value))} />
                        </div>
                    </CardContent>
                </Card>

                <div className="lg:col-span-2 space-y-6">
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2"><Gift /> المكافآت المتاحة</CardTitle>
                            <CardDescription>المكافآت التي يمكن للعملاء استبدالها بنقاطهم.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>المكافأة</TableHead>
                                        <TableHead>النقاط المطلوبة</TableHead>
                                        <TableHead>النوع</TableHead>
                                        <TableHead>الحالة</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {rewards.map((reward) => (
                                        <TableRow key={reward.id}>
                                            <TableCell>
                                                <div>
                                                    <p className="font-semibold">{reward.name}</p>
                                                    <p className="text-sm text-slate-500">{reward.description}</p>
                                                </div>
                                            </TableCell>
                                            <TableCell className="font-semibold">{reward.pointsCost} نقطة</TableCell>
                                            <TableCell>{reward.type === 'discount' ? 'خصم' : reward.type === 'service' ? 'خدمة' : 'نقدي'}</TableCell>
                                            <TableCell>
                                                <span className={`px-2 py-1 text-xs font-semibold rounded-full ${reward.active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`}>
                                                    {reward.active ? 'نشط' : 'معطل'}
                                                </span>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2"><Users /> عملاء برنامج الولاء</CardTitle>
                            <CardDescription>قائمة العملاء المشتركين في برنامج الولاء ونقاطهم.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>العميل</TableHead>
                                        <TableHead>النقاط الحالية</TableHead>
                                        <TableHead>إجمالي الإنفاق</TableHead>
                                        <TableHead>المستوى</TableHead>
                                        <TableHead>إجراءات</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {customers.map((customer) => (
                                        <TableRow key={customer.id}>
                                            <TableCell>
                                                <div>
                                                    <p className="font-semibold">{customer.name}</p>
                                                    <p className="text-sm text-slate-500">{customer.email}</p>
                                                </div>
                                            </TableCell>
                                            <TableCell className="font-semibold text-primary">{customer.points} نقطة</TableCell>
                                            <TableCell>{customer.totalSpent.toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'})}</TableCell>
                                            <TableCell>
                                                <span className={`px-2 py-1 text-xs font-semibold rounded-full flex items-center gap-1 w-fit ${getTierColor(customer.tier)}`}>
                                                    <Award className="w-3 h-3"/> {customer.tier}
                                                </span>
                                            </TableCell>
                                            <TableCell>
                                                <Button variant="outline" size="sm" onClick={() => handleAwardPoints(customer.id, 50)}>
                                                    <Star className="w-4 h-4 ml-1"/> منح 50 نقطة
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    );
});

export default LoyaltyProgramContent;