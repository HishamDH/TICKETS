
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Star, Gift, Ticket } from 'lucide-react';

const rewards = [
    { title: 'خصم 10%', points: '500 نقطة', icon: Gift },
    { title: 'تذكرة فعالية مجانية', points: '2000 نقطة', icon: Ticket },
    { title: 'ترقية VIP', points: '1500 نقطة', icon: Star },
];

const CustomerRewards = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">المكافآت والنقاط</h1>
                <p className="text-slate-500 mt-1">استبدل نقاطك بمكافآت وجوائز قيمة.</p>
            </div>
            <Card className="text-center">
                <CardHeader>
                    <CardTitle className="text-lg text-slate-600">رصيدك الحالي من النقاط</CardTitle>
                </CardHeader>
                <CardContent>
                    <p className="text-5xl font-bold text-primary flex items-center justify-center gap-2">1,250 <Star className="w-10 h-10 text-amber-400"/></p>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle>مكافآت يمكن استبدالها</CardTitle>
                </CardHeader>
                <CardContent className="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {rewards.map(reward => (
                        <div key={reward.title} className="p-4 border rounded-lg flex items-center justify-between">
                            <div className="flex items-center gap-3">
                                <reward.icon className="w-6 h-6 text-primary"/>
                                <div>
                                    <p className="font-semibold">{reward.title}</p>
                                    <p className="text-sm text-slate-500">{reward.points}</p>
                                </div>
                            </div>
                            <Button variant="outline" onClick={() => handleFeatureClick("استبدال")}>استبدال</Button>
                        </div>
                    ))}
                </CardContent>
            </Card>
        </div>
    );
};

export default CustomerRewards;
