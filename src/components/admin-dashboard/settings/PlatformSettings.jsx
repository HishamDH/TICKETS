
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Input } from '@/components/ui/input';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Save, FileText, CreditCard, ToggleRight, Mail } from 'lucide-react';

const PlatformSettings = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">إعدادات النظام العام</h1>
                    <p className="text-slate-500 mt-1">التحكم في السياسات، وسائل الدفع، والميزات العامة للمنصة.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("حفظ كل الإعدادات")}><Save className="w-4 h-4 ml-2"/>حفظ التغييرات</Button>
            </div>

            <Card>
                <Tabs defaultValue="policies">
                    <CardHeader>
                        <TabsList>
                            <TabsTrigger value="policies"><FileText className="w-4 h-4 ml-2"/>السياسات العامة</TabsTrigger>
                            <TabsTrigger value="payments"><CreditCard className="w-4 h-4 ml-2"/>وسائل الدفع</TabsTrigger>
                            <TabsTrigger value="features"><ToggleRight className="w-4 h-4 ml-2"/>تفعيل الميزات</TabsTrigger>
                            <TabsTrigger value="messages"><Mail className="w-4 h-4 ml-2"/>قوالب الرسائل</TabsTrigger>
                        </TabsList>
                    </CardHeader>
                    <CardContent>
                        <TabsContent value="policies" className="space-y-4">
                            <CardTitle>السياسات والشروط</CardTitle>
                            <div>
                                <Label htmlFor="cancellation-policy">سياسة الإلغاء والاسترجاع الافتراضية</Label>
                                <Textarea id="cancellation-policy" placeholder="اكتب نص السياسة هنا..." className="mt-2 min-h-[100px]"/>
                            </div>
                            <div>
                                <Label htmlFor="terms">شروط استخدام المنصة</Label>
                                <Textarea id="terms" placeholder="اكتب نص الشروط هنا..." className="mt-2 min-h-[100px]"/>
                            </div>
                        </TabsContent>
                        <TabsContent value="payments" className="space-y-4">
                            <CardTitle>إعداد وسائل الدفع المتاحة</CardTitle>
                            <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                <Label htmlFor="stripe">Stripe (بطاقات ائتمانية)</Label>
                                <Switch id="stripe" defaultChecked />
                            </div>
                            <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                <Label htmlFor="stc-pay">STC Pay</Label>
                                <Switch id="stc-pay" defaultChecked />
                            </div>
                            <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                <Label htmlFor="otoo">OTOO</Label>
                                <Switch id="otoo" />
                            </div>
                        </TabsContent>
                        <TabsContent value="features" className="space-y-4">
                            <CardTitle>التحكم في ميزات النظام</CardTitle>
                            <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                <Label htmlFor="guest-booking">السماح بالحجز كزائر</Label>
                                <Switch id="guest-booking" defaultChecked />
                            </div>
                            <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                <Label htmlFor="vip-tickets">تفعيل نظام تذاكر VIP</Label>
                                <Switch id="vip-tickets" defaultChecked />
                            </div>
                        </TabsContent>
                        <TabsContent value="messages" className="space-y-4">
                            <CardTitle>إعداد الرسائل النصية والبريدية</CardTitle>
                            <div>
                                <Label htmlFor="welcome-email">قالب البريد الترحيبي للتاجر</Label>
                                <Textarea id="welcome-email" placeholder="مرحباً بك {merchant_name} في شباك التذاكر..." className="mt-2 min-h-[100px]"/>
                            </div>
                            <div>
                                <Label htmlFor="booking-sms">قالب رسالة تأكيد الحجز (SMS)</Label>
                                <Textarea id="booking-sms" placeholder="تم تأكيد حجزك رقم {booking_id}..." className="mt-2 min-h-[100px]"/>
                            </div>
                        </TabsContent>
                    </CardContent>
                </Tabs>
            </Card>
        </div>
    );
};

export default PlatformSettings;
