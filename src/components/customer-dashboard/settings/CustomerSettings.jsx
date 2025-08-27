import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Save, Palette, Bell, Shield, Globe2 as LanguageIcon } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';

const CustomerSettings = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [settings, setSettings] = useState(() => {
        const savedSettings = localStorage.getItem('lilium_customer_settings_v1');
        return savedSettings ? JSON.parse(savedSettings) : {
            language: 'ar',
            defaultPaymentMethod: 'visa_1234',
            availabilityAlerts: true,
            appointmentReminders: true,
            newsletterSubscription: false,
            theme: 'light', 
            twoFactorAuthEnabled: false,
        };
    });

    useEffect(() => {
        localStorage.setItem('lilium_customer_settings_v1', JSON.stringify(settings));
    }, [settings]);

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


    const handleSettingChange = (key, value) => {
        setSettings(prev => ({ ...prev, [key]: value }));
        handleFeatureClick(`تغيير إعداد ${key} إلى ${value}`);
    };

    const handleSaveSettings = () => {
        toast({
            title: "تم حفظ الإعدادات",
            description: "تم تحديث إعداداتك وتفضيلاتك بنجاح.",
        });
        handleFeatureClick("حفظ جميع الإعدادات");
    };

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">الإعدادات والتفضيلات</h1>
                    <p className="text-slate-500 mt-1">تخصيص تجربتك في منصة ليلة الليليوم.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={handleSaveSettings}><Save className="w-4 h-4 ml-2"/>حفظ التغييرات</Button>
            </div>
            <Card>
                <CardHeader><CardTitle className="flex items-center gap-2"><LanguageIcon/> تفضيلات عامة</CardTitle></CardHeader>
                <CardContent className="space-y-4">
                    <div className="grid md:grid-cols-2 gap-4">
                        <div>
                            <Label htmlFor="language">اللغة المفضلة</Label>
                            <Select value={settings.language} onValueChange={val => handleSettingChange('language', val)}>
                                <SelectTrigger><SelectValue/></SelectTrigger>
                                <SelectContent><SelectItem value="ar">العربية</SelectItem><SelectItem value="en">English</SelectItem></SelectContent>
                            </Select>
                        </div>
                        <div>
                             <Label htmlFor="payment">وسيلة الدفع الافتراضية</Label>
                            <Select value={settings.defaultPaymentMethod} onValueChange={val => handleSettingChange('defaultPaymentMethod', val)}>
                                <SelectTrigger><SelectValue/></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="visa_1234">Visa **** 1234</SelectItem>
                                    <SelectItem value="apple_pay">Apple Pay</SelectItem>
                                    <SelectItem value="stc_pay">STC Pay</SelectItem>
                                    <SelectItem value="new_card" onClick={() => handleFeatureClick("إضافة بطاقة دفع جديدة من الإعدادات")}>إضافة بطاقة جديدة...</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                         <div>
                            <Label htmlFor="theme">مظهر المنصة</Label>
                            <Select value={settings.theme} onValueChange={val => handleSettingChange('theme', val)}>
                                <SelectTrigger><SelectValue/></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="light">فاتح</SelectItem>
                                    <SelectItem value="dark">داكن</SelectItem>
                                    <SelectItem value="system">إعدادات النظام</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                </CardContent>
            </Card>
            <Card>
                <CardHeader><CardTitle className="flex items-center gap-2"><Bell/> التنبيهات الذكية</CardTitle></CardHeader>
                <CardContent className="space-y-4">
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="availability-alert">تنبيه عند توفر مواعيد جديدة لخدمة مفضلة (مثلاً: قاعة معينة)</Label>
                        <Switch id="availability-alert" checked={settings.availabilityAlerts} onCheckedChange={val => handleSettingChange('availabilityAlerts', val)} />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="reminder-alert">تذكير قبل موعد المناسبة بـ 24 ساعة</Label>
                        <Switch id="reminder-alert" checked={settings.appointmentReminders} onCheckedChange={val => handleSettingChange('appointmentReminders', val)} />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="newsletterSubscription">الاشتراك في النشرة البريدية للعروض والتحديثات</Label>
                        <Switch id="newsletterSubscription" checked={settings.newsletterSubscription} onCheckedChange={val => handleSettingChange('newsletterSubscription', val)} />
                    </div>
                </CardContent>
            </Card>
            <Card>
                <CardHeader><CardTitle className="flex items-center gap-2"><Shield/> الأمان والخصوصية</CardTitle></CardHeader>
                <CardContent className="space-y-4">
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="twoFactorAuthEnabled">تفعيل المصادقة الثنائية (2FA)</Label>
                        <Switch id="twoFactorAuthEnabled" checked={settings.twoFactorAuthEnabled} onCheckedChange={val => handleSettingChange('twoFactorAuthEnabled', val)} />
                    </div>
                    {settings.twoFactorAuthEnabled && (
                        <div className="p-3 border rounded-md bg-blue-50 border-blue-200">
                            <p className="text-sm text-blue-700">سيتم إرسال رمز تحقق إلى بريدك الإلكتروني أو رقم جوالك عند كل تسجيل دخول.</p>
                            <Button variant="link" size="sm" className="p-0 h-auto text-blue-600" onClick={() => handleFeatureClick("إدارة طرق المصادقة الثنائية")}>إدارة طرق المصادقة</Button>
                        </div>
                    )}
                    <Button variant="outline" onClick={() => handleFeatureClick("عرض سجل نشاط الحساب")}>عرض سجل نشاط الحساب</Button>
                </CardContent>
            </Card>
        </div>
    );
};

export default CustomerSettings;