import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { CreditCard, BarChart, Mail, MessageCircle } from 'lucide-react';

const integrations = [
    { name: 'Stripe', category: 'بوابة دفع', icon: CreditCard, connected: true },
    { name: 'Google Analytics', category: 'تحليلات', icon: BarChart, connected: true },
    { name: 'SendGrid', category: 'بريد إلكتروني', icon: Mail, connected: false },
    { name: 'Twilio', category: 'رسائل SMS', icon: MessageCircle, connected: false },
];

const Integrations = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">التكاملات والأنظمة الخارجية</h1>
                <p className="text-slate-500 mt-1">ربط وإدارة الخدمات الخارجية مثل بوابات الدفع والتحليلات.</p>
            </div>

            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                {integrations.map((integration) => (
                    <Card key={integration.name}>
                        <CardHeader>
                            <div className="flex items-center gap-4">
                                <div className="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <integration.icon className="w-6 h-6 text-primary" />
                                </div>
                                <div>
                                    <CardTitle>{integration.name}</CardTitle>
                                    <CardDescription>{integration.category}</CardDescription>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div className="flex items-center justify-between">
                                <Label htmlFor={`switch-${integration.name}`} className={integration.connected ? 'text-emerald-600' : 'text-slate-500'}>
                                    {integration.connected ? 'متصل' : 'غير متصل'}
                                </Label>
                                <Switch id={`switch-${integration.name}`} checked={integration.connected} onCheckedChange={() => handleFeatureClick(`تغيير حالة ${integration.name}`)} />
                            </div>
                        </CardContent>
                    </Card>
                ))}
            </div>
        </div>
    );
};

export default Integrations;