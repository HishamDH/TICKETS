import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from "@/components/ui/switch";
import { Label } from '@/components/ui/label';
import { Bell, Mail, MessageSquare, Settings } from 'lucide-react';
import { Separator } from "@/components/ui/separator";
import { useToast } from "@/components/ui/use-toast";

const initialNotificationSettings = {
    'customer-confirm-email': true, 'customer-confirm-sms': false, 'customer-confirm-push': true,
    'customer-reminder-email': true, 'customer-reminder-sms': true, 'customer-reminder-push': true,
    'customer-cancel-email': true, 'customer-cancel-sms': false, 'customer-cancel-push': true,
    'merchant-new-booking-email': true, 'merchant-new-booking-sms': false, 'merchant-new-booking-push': true,
    'merchant-payout-email': true, 'merchant-payout-sms': false, 'merchant-payout-push': true,
    'merchant-review-email': true, 'merchant-review-sms': false, 'merchant-review-push': true,
    'staff-event-change-email': true, 'staff-event-change-sms': false, 'staff-event-change-push': true,
};

const NotificationItem = memo(({ title, description, id, settings, onSettingChange, onFeatureClick, onTestNotification }) => (
    <div className="grid grid-cols-1 md:grid-cols-2 gap-4 items-center p-4 border-b last:border-b-0">
        <div className="space-y-1">
            <p className="font-semibold text-slate-800">{title}</p>
            <p className="text-sm text-slate-500">{description}</p>
        </div>
        <div className="flex items-center justify-between gap-4">
            <div className="flex items-center gap-4">
                <div className="flex items-center space-x-2 space-x-reverse">
                    <Switch id={`email-${id}`} checked={settings[`${id}-email`]} onCheckedChange={(checked) => {onSettingChange(`${id}-email`, checked); onFeatureClick(`تغيير إشعار البريد لـ ${title}`);}} />
                    <Label htmlFor={`email-${id}`} className="flex flex-col items-center">
                        <Mail className="h--5 w-5 text-slate-600"/>
                        <span className="text-xs">بريد</span>
                    </Label>
                </div>
                 <div className="flex items-center space-x-2 space-x-reverse">
                    <Switch id={`sms-${id}`} checked={settings[`${id}-sms`]} onCheckedChange={(checked) => {onSettingChange(`${id}-sms`, checked); onFeatureClick(`تغيير إشعار SMS لـ ${title}`);}} />
                    <Label htmlFor={`sms-${id}`} className="flex flex-col items-center">
                        <MessageSquare className="h-5 w-5 text-slate-600"/>
                        <span className="text-xs">SMS</span>
                    </Label>
                </div>
                 <div className="flex items-center space-x-2 space-x-reverse">
                    <Switch id={`push-${id}`} checked={settings[`${id}-push`]} onCheckedChange={(checked) => {onSettingChange(`${id}-push`, checked); onFeatureClick(`تغيير إشعار التطبيق لـ ${title}`);}} />
                    <Label htmlFor={`push-${id}`} className="flex flex-col items-center">
                        <Bell className="h-5 w-5 text-slate-600"/>
                        <span className="text-xs">تنبيه</span>
                    </Label>
                </div>
            </div>
            <Button variant="outline" size="sm" onClick={() => onTestNotification(title)}>تجربة</Button>
        </div>
    </div>
));


const NotificationsManagementContent = memo(({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [notificationSettings, setNotificationSettings] = useState(
        JSON.parse(localStorage.getItem('lilium_night_notifications_v1')) || initialNotificationSettings
    );

    useEffect(() => {
        localStorage.setItem('lilium_night_notifications_v1', JSON.stringify(notificationSettings));
    }, [notificationSettings]);

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

    const handleSettingChange = (key, value) => {
        setNotificationSettings(prev => ({ ...prev, [key]: value }));
    };
    
    const handleTestNotification = (notificationTitle) => {
        toast({
            title: `🔔 إشعار تجريبي: ${notificationTitle}`,
            description: "هذا هو شكل الإشعار الذي سيصل للمستخدم.",
        });
        handleFeatureClick(`تجربة إشعار "${notificationTitle}"`);
    };

    const handleSaveChanges = () => {
        toast({ title: "تم الحفظ", description: "تم حفظ إعدادات الإشعارات بنجاح." });
        handleFeatureClick("حفظ إعدادات الإشعارات");
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">إدارة الإشعارات والتنبيهات</h2>
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>إعدادات الإشعارات</CardTitle>
                    <CardDescription>تحكم في الإشعارات التي تصلك أنت وعملاؤك وموظفوك عبر منصة ليلة الليليوم.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div>
                        <h3 className="text-lg font-bold text-slate-900 mb-4">إشعارات العملاء</h3>
                        <div className="border rounded-lg overflow-hidden">
                           <NotificationItem 
                                id="customer-confirm"
                                title="تأكيد الحجز"
                                description="إشعار يرسل للعميل عند تأكيد حجزه لخدمة من خدماتك بنجاح."
                                settings={notificationSettings}
                                onSettingChange={handleSettingChange}
                                onFeatureClick={handleFeatureClick}
                                onTestNotification={handleTestNotification}
                           />
                           <NotificationItem 
                                id="customer-reminder"
                                title="تذكير بالموعد"
                                description="تذكير يرسل للعميل قبل موعد المناسبة بـ 24 ساعة."
                                settings={notificationSettings}
                                onSettingChange={handleSettingChange}
                                onFeatureClick={handleFeatureClick}
                                onTestNotification={handleTestNotification}
                           />
                           <NotificationItem 
                                id="customer-cancel"
                                title="إلغاء الحجز"
                                description="إشعار يرسل للعميل عند إلغاء حجزه (سواء منك أو منه)."
                                settings={notificationSettings}
                                onSettingChange={handleSettingChange}
                                onFeatureClick={handleFeatureClick}
                                onTestNotification={handleTestNotification}
                           />
                        </div>
                    </div>
                    
                    <Separator className="my-8" />

                    <div>
                        <h3 className="text-lg font-bold text-slate-900 mb-4">إشعارات مزوّد الخدمة (أنت)</h3>
                         <div className="border rounded-lg overflow-hidden">
                           <NotificationItem 
                                id="merchant-new-booking"
                                title="حجز جديد"
                                description="تنبيه فوري عند استلام حجز جديد لخدماتك."
                                settings={notificationSettings}
                                onSettingChange={handleSettingChange}
                                onFeatureClick={handleFeatureClick}
                                onTestNotification={handleTestNotification}
                           />
                           <NotificationItem 
                                id="merchant-payout"
                                title="طلب سحب"
                                description="تنبيه عند إنشاء طلب سحب جديد من محفظتك المالية."
                                settings={notificationSettings}
                                onSettingChange={handleSettingChange}
                                onFeatureClick={handleFeatureClick}
                                onTestNotification={handleTestNotification}
                           />
                           <NotificationItem 
                                id="merchant-review"
                                title="تقييم جديد من عميل"
                                description="إشعار عند إضافة تقييم جديد من عميل على إحدى خدماتك."
                                settings={notificationSettings}
                                onSettingChange={handleSettingChange}
                                onFeatureClick={handleFeatureClick}
                                onTestNotification={handleTestNotification}
                           />
                        </div>
                    </div>

                    <Separator className="my-8" />
                    
                    <div>
                        <h3 className="text-lg font-bold text-slate-900 mb-4">إشعارات الموظفين (مساعدي المزوّد)</h3>
                         <div className="border rounded-lg overflow-hidden">
                           <NotificationItem 
                                id="staff-event-change"
                                title="تغيير في تفاصيل خدمة/حجز"
                                description="إشعار لموظفي التحقق أو المنسقين عند تغيير تفاصيل خدمة أو حجز معين."
                                settings={notificationSettings}
                                onSettingChange={handleSettingChange}
                                onFeatureClick={handleFeatureClick}
                                onTestNotification={handleTestNotification}
                           />
                        </div>
                    </div>
                    
                    <div className="mt-8 flex justify-end">
                        <Button className="gradient-bg text-white" onClick={handleSaveChanges}>
                            <Settings className="w-4 h-4 ml-2" />
                            حفظ التغييرات
                        </Button>
                    </div>

                </CardContent>
            </Card>
        </div>
    );
});

export default NotificationsManagementContent;