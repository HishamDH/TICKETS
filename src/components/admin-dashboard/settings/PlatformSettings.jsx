import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Settings, Users, Percent, Mail, MessageSquare, Globe, Server, Zap } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const PlatformSettings = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [settings, setSettings] = useState({
        platformName: 'ليلة الليليوم',
        defaultLanguage: 'ar',
        maintenanceMode: false,
        maintenanceMessage: 'المنصة قيد الصيانة حالياً. نعتذر عن الإزعاج وسنعود قريباً.',
        registrationOpen: true,
        defaultCommissionRate: 10, 
        maxFileSizeUpload: 5, 
        emailNotifications: true,
        smsNotifications: false,
        smtpHost: 'smtp.example.com',
        smtpPort: '587',
        smtpUser: '',
        smsGatewayApiKey: '',
    });

    useEffect(() => {
        const savedSettings = localStorage.getItem('lilium_platform_settings_admin');
        if (savedSettings) {
            setSettings(JSON.parse(savedSettings));
        }
    }, []);

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

    const handleInputChange = (e) => {
        const { name, value, type, checked } = e.target;
        setSettings(prev => ({ ...prev, [name]: type === 'checkbox' || type === 'switch' ? checked : value }));
    };
    
    const handleSelectChange = (name, value) => {
        setSettings(prev => ({ ...prev, [name]: value }));
    };

    const handleSaveSettings = () => {
        localStorage.setItem('lilium_platform_settings_admin', JSON.stringify(settings));
        toast({
            title: "تم الحفظ بنجاح",
            description: "تم حفظ إعدادات المنصة العامة.",
        });
    };

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">إعدادات المنصة العامة</h1>
                    <p className="text-slate-500 mt-1">التحكم في الإعدادات الأساسية لمنصة ليلة الليليوم.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={handleSaveSettings}><Settings className="w-4 h-4 ml-2"/>حفظ الإعدادات</Button>
            </div>
            
            <div className="grid lg:grid-cols-3 gap-6">
                <Card className="lg:col-span-2">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Globe/> الإعدادات الأساسية</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div className="grid md:grid-cols-2 gap-4">
                            <div><Label htmlFor="platformName">اسم المنصة</Label><Input id="platformName" name="platformName" value={settings.platformName} onChange={handleInputChange} /></div>
                            <div>
                                <Label htmlFor="defaultLanguage">اللغة الافتراضية</Label>
                                <Select dir="rtl" name="defaultLanguage" value={settings.defaultLanguage} onValueChange={(val) => handleSelectChange('defaultLanguage', val)}>
                                    <SelectTrigger><SelectValue /></SelectTrigger>
                                    <SelectContent><SelectItem value="ar">العربية</SelectItem><SelectItem value="en">English</SelectItem></SelectContent>
                                </Select>
                            </div>
                        </div>
                        <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <Label htmlFor="maintenanceMode">وضع الصيانة</Label>
                            <Switch id="maintenanceMode" name="maintenanceMode" checked={settings.maintenanceMode} onCheckedChange={(val) => handleInputChange({target: {name: 'maintenanceMode', type:'switch', checked:val}})} />
                        </div>
                        {settings.maintenanceMode && (
                            <div><Label htmlFor="maintenanceMessage">رسالة الصيانة</Label><Textarea id="maintenanceMessage" name="maintenanceMessage" value={settings.maintenanceMessage} onChange={handleInputChange} /></div>
                        )}
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Users/> إعدادات العضوية والتسجيل</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <Label htmlFor="registrationOpen">السماح بالتسجيل الجديد للمستخدمين/التجار</Label>
                            <Switch id="registrationOpen" name="registrationOpen" checked={settings.registrationOpen} onCheckedChange={(val) => handleInputChange({target: {name: 'registrationOpen', type:'switch', checked:val}})} />
                        </div>
                        <div>
                            <Label htmlFor="defaultCommissionRate">نسبة العمولة الافتراضية (%)</Label>
                            <Input id="defaultCommissionRate" name="defaultCommissionRate" type="number" value={settings.defaultCommissionRate} onChange={handleInputChange} />
                        </div>
                    </CardContent>
                </Card>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><Server/> إعدادات الخادم والحدود</CardTitle>
                </CardHeader>
                <CardContent className="space-y-4">
                    <div>
                        <Label htmlFor="maxFileSizeUpload">الحد الأقصى لحجم رفع الملفات (MB)</Label>
                        <Input id="maxFileSizeUpload" name="maxFileSizeUpload" type="number" value={settings.maxFileSizeUpload} onChange={handleInputChange} />
                    </div>
                    <Button variant="outline" onClick={() => handleFeatureClick("إدارة حدود معدل الطلبات (Rate Limiting)")}>إدارة حدود معدل الطلبات (Rate Limiting)</Button>
                    <Button variant="outline" onClick={() => handleFeatureClick("مسح ذاكرة التخزين المؤقت (Cache)")}>مسح ذاكرة التخزين المؤقت (Cache)</Button>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><Zap/> إعدادات الإشعارات والرسائل</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                     <div className="grid md:grid-cols-2 gap-6">
                        <div className="space-y-4 p-4 border rounded-lg">
                             <h3 className="font-semibold flex items-center gap-2"><Mail/> إعدادات البريد الإلكتروني (SMTP)</h3>
                             <div className="flex items-center justify-between"><Label htmlFor="emailNotifications">تفعيل إشعارات البريد</Label><Switch id="emailNotifications" name="emailNotifications" checked={settings.emailNotifications} onCheckedChange={(val) => handleInputChange({target: {name: 'emailNotifications', type:'switch', checked:val}})}/></div>
                             <div><Label htmlFor="smtpHost">مضيف SMTP</Label><Input id="smtpHost" name="smtpHost" value={settings.smtpHost} onChange={handleInputChange}/></div>
                             <div><Label htmlFor="smtpPort">منفذ SMTP</Label><Input id="smtpPort" name="smtpPort" value={settings.smtpPort} onChange={handleInputChange}/></div>
                             <div><Label htmlFor="smtpUser">اسم مستخدم SMTP</Label><Input id="smtpUser" name="smtpUser" value={settings.smtpUser} onChange={handleInputChange}/></div>
                             <div><Label htmlFor="smtpPass">كلمة مرور SMTP</Label><Input id="smtpPass" name="smtpPass" type="password" onChange={(e) => handleInputChange(e)} placeholder="********"/></div>
                             <Button variant="outline" size="sm" onClick={()=> handleFeatureClick("إرسال بريد تجريبي")}>إرسال بريد تجريبي</Button>
                        </div>
                        <div className="space-y-4 p-4 border rounded-lg">
                            <h3 className="font-semibold flex items-center gap-2"><MessageSquare/> إعدادات رسائل SMS</h3>
                            <div className="flex items-center justify-between"><Label htmlFor="smsNotifications">تفعيل إشعارات SMS</Label><Switch id="smsNotifications" name="smsNotifications" checked={settings.smsNotifications} onCheckedChange={(val) => handleInputChange({target: {name: 'smsNotifications', type:'switch', checked:val}})}/></div>
                            <div><Label htmlFor="smsGatewayApiKey">مفتاح API لبوابة SMS</Label><Input id="smsGatewayApiKey" name="smsGatewayApiKey" value={settings.smsGatewayApiKey} onChange={handleInputChange}/></div>
                            <Button variant="outline" size="sm" onClick={()=> handleFeatureClick("إرسال رسالة SMS تجريبية")}>إرسال رسالة SMS تجريبية</Button>
                        </div>
                     </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default PlatformSettings;