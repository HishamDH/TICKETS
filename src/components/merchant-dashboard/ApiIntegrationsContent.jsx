import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Key, Copy, RefreshCw, PlusCircle, Trash2, Webhook } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const ApiIntegrationsContent = memo(({ handleFeatureClick }) => {
    const { toast } = useToast();
    const [apiKey, setApiKey] = useState(localStorage.getItem('lilium_night_api_key_v1') || 'sk_live_********************');
    const [webhooks, setWebhooks] = useState(JSON.parse(localStorage.getItem('lilium_night_webhooks_v1')) || [
        { id: 'wh1', url: 'https://api.example.com/webhook/lilium' },
    ]);
    const [newWebhookUrl, setNewWebhookUrl] = useState('');

    useEffect(() => {
        localStorage.setItem('lilium_night_api_key_v1', apiKey);
        localStorage.setItem('lilium_night_webhooks_v1', JSON.stringify(webhooks));
    }, [apiKey, webhooks]);

    const regenerateApiKey = () => {
        const newKey = `sk_live_${[...Array(20)].map(() => Math.random().toString(36)[2]).join('')}`;
        setApiKey(newKey);
        toast({ title: "تم إنشاء مفتاح جديد!", description: "تم إنشاء مفتاح API جديد. قم بتحديثه في تطبيقاتك." });
        handleFeatureClick("إنشاء مفتاح API جديد");
    };

    const copyToClipboard = (text, message) => {
        navigator.clipboard.writeText(text).then(() => toast({ title: "تم النسخ!", description: message }));
        handleFeatureClick(message);
    };

    const addWebhook = () => {
        if (!newWebhookUrl.startsWith('https://')) {
            toast({ title: "خطأ", description: "الرجاء إدخال رابط صحيح يبدأ بـ https://", variant: "destructive" });
            return;
        }
        setWebhooks([...webhooks, { id: `wh${Date.now()}`, url: newWebhookUrl }]);
        setNewWebhookUrl('');
        toast({ title: "تمت الإضافة", description: "تم إضافة Webhook جديد بنجاح." });
        handleFeatureClick(`إضافة Webhook: ${newWebhookUrl}`);
    };

    const deleteWebhook = (id) => {
        const webhookToDelete = webhooks.find(wh => wh.id === id);
        setWebhooks(webhooks.filter(wh => wh.id !== id));
        handleFeatureClick(`حذف Webhook: ${webhookToDelete.url}`);
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">الربط البرمجي (API)</h2>
            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><Key /> مفتاح API الخاص بك</CardTitle>
                    <CardDescription>استخدم هذا المفتاح لربط أنظمتك الخارجية مع منصة ليلة الليليوم. حافظ على سريته.</CardDescription>
                </CardHeader>
                <CardContent className="flex items-center gap-4">
                    <Input value={apiKey} readOnly className="font-mono" />
                    <Button variant="outline" onClick={() => copyToClipboard(apiKey, "تم نسخ مفتاح API.")}><Copy className="w-4 h-4" /></Button>
                    <Button variant="destructive" onClick={regenerateApiKey}><RefreshCw className="w-4 h-4 ml-2" /> إنشاء مفتاح جديد</Button>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><Webhook /> إدارة Webhooks</CardTitle>
                    <CardDescription>أضف روابط Webhook ليتم إعلام أنظمتك تلقائياً عند وقوع أحداث معينة (مثل حجز جديد).</CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="flex items-center gap-2 mb-4">
                        <Input 
                            placeholder="https://api.example.com/webhook" 
                            value={newWebhookUrl}
                            onChange={(e) => setNewWebhookUrl(e.target.value)}
                        />
                        <Button onClick={addWebhook}><PlusCircle className="w-4 h-4 ml-2" /> إضافة</Button>
                    </div>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>رابط الـ Webhook</TableHead>
                                <TableHead>إجراء</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {webhooks.map(wh => (
                                <TableRow key={wh.id}>
                                    <TableCell className="font-mono">{wh.url}</TableCell>
                                    <TableCell>
                                        <Button variant="ghost" size="icon" onClick={() => deleteWebhook(wh.id)}>
                                            <Trash2 className="w-4 h-4 text-red-500" />
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    );
});

export default ApiIntegrationsContent;