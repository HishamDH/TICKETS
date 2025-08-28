
import React from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Copy, RefreshCw, Book, ArrowRight, Plug } from 'lucide-react';

const webhooks = [
    { event: 'booking.created', description: 'يتم تفعيله عند إنشاء حجز جديد.' },
    { event: 'booking.confirmed', description: 'يتم تفعيله عند تأكيد حجز.' },
    { event: 'booking.cancelled', description: 'يتم تفعيله عند إلغاء حجز.' },
    { event: 'checkin.success', description: 'يتم تفعيله عند تسجيل وصول ناجح.' },
];

const ApiIntegrationsContent = ({ handleFeatureClick }) => {
    const apiKey = "shb_live_sk_XXXXXXXXXXXXXXXXXXXX";

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-start">
                <div>
                    <h2 className="text-3xl font-bold text-slate-800">API والتكاملات</h2>
                    <p className="text-slate-500 mt-2">قم بربط أنظمتك الخارجية وقم بأتمتة مهامك عبر واجهة برمجة التطبيقات (API).</p>
                </div>
                <Button variant="outline" onClick={() => handleFeatureClick("قراءة الوثائق")}>
                    <Book className="w-4 h-4 ml-2" />
                    وثائق الـ API
                </Button>
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>مفاتيح الـ API</CardTitle>
                    <CardDescription>استخدم هذه المفاتيح لمصادقة طلباتك. حافظ على سريتها!</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    <div className="space-y-2">
                        <Label htmlFor="api-key">مفتاح API السري</Label>
                        <div className="flex gap-2">
                            <Input id="api-key" type="password" readOnly value={apiKey} className="font-mono"/>
                            <Button variant="outline" size="icon" onClick={() => handleFeatureClick("نسخ المفتاح")}>
                                <Copy className="w-4 h-4" />
                            </Button>
                            <Button variant="outline" size="icon" onClick={() => handleFeatureClick("إنشاء مفتاح جديد")}>
                                <RefreshCw className="w-4 h-4" />
                            </Button>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>Webhooks</CardTitle>
                    <CardDescription>احصل على إشعارات بالأحداث الهامة في أنظمتك عبر Webhooks.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div className="space-y-2">
                        <Label htmlFor="webhook-url">عنوان URL لنقطة النهاية (Endpoint)</Label>
                        <div className="flex gap-2">
                            <Input id="webhook-url" placeholder="https://your-app.com/webhook" />
                            <Button onClick={() => handleFeatureClick("إضافة Webhook")}>
                                <Plug className="w-4 h-4 ml-2" />
                                إضافة
                            </Button>
                        </div>
                    </div>
                    <div className="border rounded-lg">
                        <div className="p-4">
                            <h4 className="font-semibold text-slate-800">الأحداث المتاحة</h4>
                            <p className="text-sm text-slate-500">اختر الأحداث التي تريد الاشتراك بها.</p>
                        </div>
                        <div className="divide-y">
                            {webhooks.map((hook) => (
                                <div key={hook.event} className="flex items-center justify-between p-4">
                                    <div>
                                        <p className="font-mono text-sm font-medium bg-slate-100 px-2 py-1 rounded inline-block">{hook.event}</p>
                                        <p className="text-sm text-slate-500 mt-1">{hook.description}</p>
                                    </div>
                                    <Switch 
                                        onCheckedChange={() => handleFeatureClick(`تفعيل ${hook.event}`)}
                                    />
                                </div>
                            ))}
                        </div>
                    </div>
                     <div className="mt-4 flex justify-end">
                        <Button variant="link" className="p-0 h-auto" onClick={() => handleFeatureClick("عرض سجلات Webhook")}>
                           عرض سجلات Webhook
                           <ArrowRight className="w-4 h-4 mr-2" />
                        </Button>
                    </div>
                </CardContent>
            </Card>

        </div>
    );
};

export default ApiIntegrationsContent;
