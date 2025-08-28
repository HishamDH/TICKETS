
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Save } from 'lucide-react';

const CustomerSettings = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">الإعدادات والتفضيلات</h1>
                    <p className="text-slate-500 mt-1">تخصيص تجربتك في المنصة.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("Save")}><Save className="w-4 h-4 ml-2"/>حفظ التغييرات</Button>
            </div>
            <Card>
                <CardHeader><CardTitle>تفضيلات عامة</CardTitle></CardHeader>
                <CardContent className="space-y-4">
                    <div className="grid md:grid-cols-2 gap-4">
                        <div>
                            <Label htmlFor="language">اللغة المفضلة</Label>
                            <Select defaultValue="ar">
                                <SelectTrigger><SelectValue/></SelectTrigger>
                                <SelectContent><SelectItem value="ar">العربية</SelectItem><SelectItem value="en">English</SelectItem></SelectContent>
                            </Select>
                        </div>
                        <div>
                             <Label htmlFor="payment">وسيلة الدفع الافتراضية</Label>
                            <Select defaultValue="visa">
                                <SelectTrigger><SelectValue/></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="visa">Visa **** 1234</SelectItem>
                                    <SelectItem value="apple-pay">Apple Pay</SelectItem>
                                    <SelectItem value="stc-pay">STC Pay</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                </CardContent>
            </Card>
            <Card>
                <CardHeader><CardTitle>التنبيهات الذكية</CardTitle></CardHeader>
                <CardContent className="space-y-4">
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="availability-alert">تنبيه عند توفر أماكن جديدة لفعالية مفضلة</Label>
                        <Switch id="availability-alert" defaultChecked />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="reminder-alert">تذكير قبل موعد الحجز بـ 24 ساعة</Label>
                        <Switch id="reminder-alert" defaultChecked />
                    </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default CustomerSettings;
