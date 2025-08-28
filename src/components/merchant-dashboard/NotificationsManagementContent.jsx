
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Switch } from "@/components/ui/switch";
import { Label } from "@/components/ui/label";
import { Bell, Mail, MessageSquare, Settings } from 'lucide-react';
import { Separator } from "@/components/ui/separator";

const NotificationItem = ({ title, description, id }) => (
    <div className="flex items-center justify-between p-4 border-b last:border-b-0">
        <div className="space-y-1">
            <p className="font-semibold text-slate-800">{title}</p>
            <p className="text-sm text-slate-500">{description}</p>
        </div>
        <div className="flex items-center gap-4">
            <div className="flex items-center space-x-2 space-x-reverse">
                <Switch id={`email-${id}`} defaultChecked />
                <Label htmlFor={`email-${id}`} className="flex flex-col items-center">
                    <Mail className="h-5 w-5 text-slate-600"/>
                    <span className="text-xs">بريد</span>
                </Label>
            </div>
             <div className="flex items-center space-x-2 space-x-reverse">
                <Switch id={`sms-${id}`} />
                <Label htmlFor={`sms-${id}`} className="flex flex-col items-center">
                    <MessageSquare className="h-5 w-5 text-slate-600"/>
                    <span className="text-xs">SMS</span>
                </Label>
            </div>
             <div className="flex items-center space-x-2 space-x-reverse">
                <Switch id={`push-${id}`} defaultChecked />
                <Label htmlFor={`push-${id}`} className="flex flex-col items-center">
                    <Bell className="h-5 w-5 text-slate-600"/>
                    <span className="text-xs">تنبيه</span>
                </Label>
            </div>
        </div>
    </div>
);


const NotificationsManagementContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">إدارة الإشعارات</h2>
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>إعدادات الإشعارات</CardTitle>
                    <CardDescription>تحكم في الإشعارات التي تصلك أنت وعملاؤك وموظفوك.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div>
                        <h3 className="text-lg font-bold text-slate-900 mb-4">إشعارات العملاء</h3>
                        <div className="border rounded-lg overflow-hidden">
                           <NotificationItem 
                                id="customer-confirm"
                                title="تأكيد الحجز"
                                description="إشعار يرسل للعميل عند تأكيد حجزه بنجاح."
                           />
                           <NotificationItem 
                                id="customer-reminder"
                                title="تذكير بالموعد"
                                description="تذكير يرسل للعميل قبل موعد الحجز بـ 24 ساعة."
                           />
                           <NotificationItem 
                                id="customer-cancel"
                                title="إلغاء الحجز"
                                description="إشعار يرسل للعميل عند إلغاء الحجز."
                           />
                        </div>
                    </div>
                    
                    <Separator className="my-8" />

                    <div>
                        <h3 className="text-lg font-bold text-slate-900 mb-4">إشعارات التاجر</h3>
                         <div className="border rounded-lg overflow-hidden">
                           <NotificationItem 
                                id="merchant-new-booking"
                                title="حجز جديد"
                                description="تنبيه فوري عند استلام حجز جديد."
                           />
                           <NotificationItem 
                                id="merchant-payout"
                                title="طلب سحب"
                                description="تنبيه عند إنشاء طلب سحب جديد من المحفظة."
                           />
                           <NotificationItem 
                                id="merchant-review"
                                title="تقييم جديد"
                                description="إشعار عند إضافة تقييم جديد من عميل."
                           />
                        </div>
                    </div>

                    <Separator className="my-8" />
                    
                    <div>
                        <h3 className="text-lg font-bold text-slate-900 mb-4">إشعارات الموظفين</h3>
                         <div className="border rounded-lg overflow-hidden">
                           <NotificationItem 
                                id="staff-event-change"
                                title="تغيير في الفعالية"
                                description="إشعار لموظفي التحقق عند تغيير تفاصيل الفعالية."
                           />
                        </div>
                    </div>
                    
                    <div className="mt-8 flex justify-end">
                        <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("حفظ إعدادات الإشعارات")}>
                            <Settings className="w-4 h-4 ml-2" />
                            حفظ التغييرات
                        </Button>
                    </div>

                </CardContent>
            </Card>
        </div>
    );
};

export default NotificationsManagementContent;
