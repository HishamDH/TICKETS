import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Star, Gift, Ticket, ShoppingBag, Percent } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Progress } from "@/components/ui/progress";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

const initialRewardsData = [
    { id: 'rw1', title: 'خصم 10% على خدمة التصوير', points: 500, icon: Percent, type: 'discount', details: 'خصم 10% على أي باقة تصوير من استوديو الإبداع.' },
    { id: 'rw2', title: 'باقة ورد مجانية مع حجز القاعة', points: 2000, icon: Gift, type: 'gift', details: 'احصل على باقة ورد فاخرة عند حجز قاعة الأفراح الملكية.' },
    { id: 'rw3', title: 'ترقية مجانية لخدمة الضيافة VIP', points: 1500, icon: Star, type: 'upgrade', details: 'تمتع بخدمة ضيافة VIP مجاناً مع بوفيه الكرم.' },
    { id: 'rw4', title: 'قسيمة شرائية بقيمة 50 ريال', points: 250, icon: ShoppingBag, type: 'voucher', details: 'استخدمها لشراء أي من خدمات الإضافات المتوفرة.' },
];

const initialPointsHistoryData = [
    { id: 'ph1', reason: 'إتمام حجز #حجز1234', points: '+150 نقطة', date: '2025-06-15' },
    { id: 'ph2', reason: 'تقييم خدمة "بوفيه الكرم"', points: '+50 نقطة', date: '2025-05-06' },
    { id: 'ph3', reason: 'استبدال مكافأة "خصم 10%"', points: '-500 نقطة', date: '2025-04-20' },
];

const CustomerRewards = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [rewards, setRewards] = useState(initialRewardsData); // No localStorage for rewards as they are likely static
    const [currentPoints, setCurrentPoints] = useState(() => {
        const saved = localStorage.getItem('lilium_customer_points_v1');
        return saved ? parseInt(saved, 10) : 1250;
    });
    const [pointsHistory, setPointsHistory] = useState(() => {
        const saved = localStorage.getItem('lilium_customer_points_history_v1');
        return saved ? JSON.parse(saved) : initialPointsHistoryData;
    });

    const [loyaltyLevel, setLoyaltyLevel] = useState({ name: "فضي", progress: 60, nextLevel: "ذهبي", pointsToNext: 750 });

    useEffect(() => {
        localStorage.setItem('lilium_customer_points_v1', currentPoints.toString());
    }, [currentPoints]);

    useEffect(() => {
        localStorage.setItem('lilium_customer_points_history_v1', JSON.stringify(pointsHistory));
    }, [pointsHistory]);

    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick) {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };


    const handleRedeemReward = (reward) => {
        if (currentPoints >= reward.points) {
            const newPoints = currentPoints - reward.points;
            setCurrentPoints(newPoints);
            
            const newHistoryEntry = { 
                id: `ph${Date.now()}`, 
                reason: `استبدال مكافأة "${reward.title}"`, 
                points: `-${reward.points} نقطة`, 
                date: new Date().toISOString().split('T')[0] 
            };
            setPointsHistory(prev => [newHistoryEntry, ...prev]);

            toast({
                title: "تم استبدال المكافأة بنجاح!",
                description: `لقد استبدلت "${reward.title}". سيتم تطبيقها على حجزك القادم أو تواصل معنا للتفاصيل. رصيدك الجديد: ${newPoints} نقطة.`,
            });
            handleFeatureClick(`استبدال مكافأة ${reward.title}`);
        } else {
            toast({
                title: "نقاط غير كافية",
                description: `ليس لديك نقاط كافية لاستبدال "${reward.title}".`,
                variant: "destructive",
            });
        }
    };

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">المكافآت والنقاط</h1>
                <p className="text-slate-500 mt-1">استبدل نقاطك بمكافآت وجوائز قيمة لمناسباتك القادمة مع ليلة الليليوم.</p>
            </div>
            <Card className="text-center bg-gradient-to-br from-primary/80 to-indigo-600/80 text-white shadow-lg">
                <CardHeader>
                    <CardTitle className="text-lg">رصيدك الحالي من النقاط</CardTitle>
                </CardHeader>
                <CardContent>
                    <p className="text-5xl font-bold flex items-center justify-center gap-2">{currentPoints.toLocaleString()} <Star className="w-10 h-10 text-amber-300 fill-amber-300"/></p>
                </CardContent>
            </Card>
            
            <Card>
                <CardHeader>
                    <CardTitle>مستوى الولاء: {loyaltyLevel.name}</CardTitle>
                    <CardDescription>أنت على بعد {loyaltyLevel.pointsToNext} نقطة من المستوى {loyaltyLevel.nextLevel}!</CardDescription>
                </CardHeader>
                <CardContent>
                    <Progress value={loyaltyLevel.progress} className="w-full h-3 mb-1" />
                    <p className="text-xs text-slate-500 text-center">{loyaltyLevel.progress}% نحو المستوى التالي</p>
                    <Button variant="link" className="p-0 h-auto mt-1 block mx-auto text-sm" onClick={() => handleFeatureClick("عرض تفاصيل مستويات الولاء")}>
                        تعرف على مميزات المستويات
                    </Button>
                </CardContent>
            </Card>

            <Tabs defaultValue="rewardsList">
                <TabsList className="grid w-full grid-cols-2">
                    <TabsTrigger value="rewardsList">قائمة المكافآت</TabsTrigger>
                    <TabsTrigger value="pointsHistory">سجل النقاط</TabsTrigger>
                </TabsList>
                <TabsContent value="rewardsList">
                    <Card>
                        <CardHeader>
                            <CardTitle>مكافآت يمكن استبدالها</CardTitle>
                        </CardHeader>
                        <CardContent className="grid md:grid-cols-2 gap-4">
                            {rewards.map(reward => (
                                <div key={reward.id} className="p-4 border rounded-lg flex flex-col justify-between bg-slate-50 hover:shadow-md transition-shadow">
                                    <div className="flex items-start gap-3 mb-3">
                                        <div className="p-2 bg-primary/10 rounded-md"><reward.icon className="w-6 h-6 text-primary"/></div>
                                        <div>
                                            <p className="font-semibold text-slate-800">{reward.title}</p>
                                            <p className="text-xs text-slate-500">{reward.details}</p>
                                        </div>
                                    </div>
                                    <div className="flex justify-between items-center mt-auto pt-2 border-t">
                                        <p className="text-sm font-bold text-primary">{reward.points} نقطة</p>
                                        <Button variant="outline" size="sm" onClick={() => handleRedeemReward(reward)} disabled={currentPoints < reward.points}>
                                            {currentPoints < reward.points ? 'نقاط غير كافية' : 'استبدال'}
                                        </Button>
                                    </div>
                                </div>
                            ))}
                            {rewards.length === 0 && <p className="text-center col-span-full py-4 text-slate-500">لا توجد مكافآت متاحة حالياً.</p>}
                        </CardContent>
                    </Card>
                </TabsContent>
                <TabsContent value="pointsHistory">
                    <Card>
                        <CardHeader><CardTitle>سجل حركة النقاط</CardTitle></CardHeader>
                        <CardContent>
                            <ul className="space-y-3">
                                {pointsHistory.map(item => (
                                    <li key={item.id} className="flex justify-between items-center p-3 border-b last:border-b-0">
                                        <div>
                                            <p className="font-medium text-slate-700">{item.reason}</p>
                                            <p className="text-xs text-slate-400">{item.date}</p>
                                        </div>
                                        <span className={`font-semibold text-sm ${item.points.startsWith('+') ? 'text-green-600' : 'text-red-600'}`}>{item.points}</span>
                                    </li>
                                ))}
                                {pointsHistory.length === 0 && <p className="text-center py-4 text-slate-500">لا يوجد سجل لنقاطك بعد.</p>}
                            </ul>
                        </CardContent>
                    </Card>
                </TabsContent>
            </Tabs>
        </div>
    );
};

export default CustomerRewards;