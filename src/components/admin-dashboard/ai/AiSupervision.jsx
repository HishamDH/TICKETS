import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { AlertTriangle, CheckCircle, TrendingUp, UserX, Bot, Search } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const initialRecommendations = [
    { id: 'rec1', title: 'مراجعة مزوّد خدمة: "زهور الربيع"', reason: 'نمو غير طبيعي في الحجوزات بنسبة 300% خلال 24 ساعة.', icon: TrendingUp, color: 'text-amber-500', action: 'مراجعة النشاط', resolved: false },
    { id: 'rec2', title: 'تجميد خدمة: "رحلة السفاري الصحراوية"', reason: 'ارتفاع نسبة طلبات الاسترجاع إلى 40%.', icon: UserX, color: 'text-red-500', action: 'تجميد مؤقت', resolved: false },
];

const initialAlerts = [
    { id: 'alert1', text: 'تم بلوغ 90% من سعة قاعة "ليالي الفرح".', time: 'قبل 10 دقائق', icon: AlertTriangle, color: 'text-amber-500', read: false },
    { id: 'alert2', text: 'تمت معالجة 50 طلب سحب بنجاح لمزوّدي الخدمات.', time: 'قبل ساعة', icon: CheckCircle, color: 'text-emerald-500', read: true },
];

const AiSupervision = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [recommendations, setRecommendations] = useState(initialRecommendations);
    const [alerts, setAlerts] = useState(initialAlerts);
    const [searchTerm, setSearchTerm] = useState('');
    const [aiSettings, setAiSettings] = useState({
        autoSuspend: true,
        anomalyThreshold: 80,
        notificationFrequency: 'daily'
    });

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

    const handleRecommendationAction = (recId, actionName) => {
        setRecommendations(prev => prev.map(r => r.id === recId ? {...r, resolved: true} : r));
        handleFeatureClick(`اتخاذ إجراء "${actionName}" على التوصية "${recommendations.find(r=>r.id === recId)?.title}"`);
    };
    
    const handleAlertAction = (alertId) => {
        setAlerts(prev => prev.map(a => a.id === alertId ? {...a, read: true} : a));
        handleFeatureClick(`وضع علامة مقروء على التنبيه ${alertId}`);
    };

    const handleSettingsChange = (key, value) => {
        setAiSettings(prev => ({...prev, [key]: value}));
        handleFeatureClick(`تغيير إعداد الرقابة الذكية: ${key} إلى ${value}`);
    };

    const filteredRecommendations = recommendations.filter(rec => 
        rec.title.toLowerCase().includes(searchTerm.toLowerCase()) || 
        rec.reason.toLowerCase().includes(searchTerm.toLowerCase())
    );

    const filteredAlerts = alerts.filter(alert => 
        alert.text.toLowerCase().includes(searchTerm.toLowerCase())
    );


    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800 flex items-center gap-2"><Bot className="w-8 h-8 text-primary"/>الرقابة الذكية والتحكم الآلي</h1>
                    <p className="text-slate-500 mt-1">توصيات وتنبيهات ذكية لتحسين أداء وأمان منصة ليلة الليليوم.</p>
                </div>
                 <Input 
                    type="search" 
                    placeholder="بحث في التوصيات والتنبيهات..." 
                    className="w-full md:w-1/3"
                    value={searchTerm}
                    onChange={(e) => {setSearchTerm(e.target.value); handleFeatureClick(`البحث في الرقابة الذكية عن: ${e.target.value}`);}}
                />
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>إعدادات الرقابة الذكية</CardTitle>
                </CardHeader>
                <CardContent className="grid md:grid-cols-3 gap-6">
                    <div className="flex items-center space-x-2 space-x-reverse">
                        <Switch id="autoSuspend" checked={aiSettings.autoSuspend} onCheckedChange={(val) => handleSettingsChange('autoSuspend', val)} />
                        <Label htmlFor="autoSuspend">تفعيل التجميد التلقائي للحسابات المشبوهة</Label>
                    </div>
                    <div>
                        <Label htmlFor="anomalyThreshold">عتبة كشف الشذوذ (%)</Label>
                        <Input type="number" id="anomalyThreshold" value={aiSettings.anomalyThreshold} onChange={(e) => handleSettingsChange('anomalyThreshold', parseInt(e.target.value))} />
                    </div>
                     <div>
                        <Label htmlFor="notificationFrequency">تكرار إرسال ملخص التنبيهات</Label>
                        <Select value={aiSettings.notificationFrequency} onValueChange={(val) => handleSettingsChange('notificationFrequency', val)} dir="rtl">
                            <SelectTrigger id="notificationFrequency"><SelectValue /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="realtime">فوري</SelectItem>
                                <SelectItem value="hourly">كل ساعة</SelectItem>
                                <SelectItem value="daily">يومي</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>توصيات ذكية ({filteredRecommendations.filter(r => !r.resolved).length} غير محلولة)</CardTitle>
                    <CardDescription>إجراءات مقترحة بناءً على تحليل سلوك المستخدمين ومزوّدي الخدمات.</CardDescription>
                </CardHeader>
                <CardContent className="grid md:grid-cols-2 gap-6">
                    {filteredRecommendations.map((rec) => (
                        <Card key={rec.id} className={`bg-slate-50 ${rec.resolved ? 'opacity-60 border-dashed' : ''}`}>
                            <CardHeader className="flex flex-row items-start gap-4">
                                <rec.icon className={`w-8 h-8 mt-1 ${rec.color}`} />
                                <div>
                                    <CardTitle className="text-base">{rec.title}</CardTitle>
                                    <p className="text-sm text-slate-600 mt-1">{rec.reason}</p>
                                </div>
                            </CardHeader>
                            <CardContent>
                                {rec.resolved ? (
                                    <p className="text-sm text-green-600 flex items-center gap-1"><CheckCircle className="w-4 h-4"/> تم الحل</p>
                                ) : (
                                    <Button className="w-full" variant="outline" onClick={() => handleRecommendationAction(rec.id, rec.action)}>{rec.action}</Button>
                                )}
                            </CardContent>
                        </Card>
                    ))}
                    {filteredRecommendations.length === 0 && <p className="text-slate-500 col-span-2 text-center py-4">لا توجد توصيات تطابق بحثك.</p>}
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>آخر التنبيهات التلقائية ({filteredAlerts.filter(a => !a.read).length} غير مقروءة)</CardTitle>
                </CardHeader>
                <CardContent>
                    <div className="space-y-4">
                        {filteredAlerts.map((alert) => (
                            <div key={alert.id} className={`flex items-center gap-4 p-3 border-r-4 rounded-md bg-slate-50 ${alert.read ? 'opacity-70' : ''}`} style={{borderColor: alert.color.includes('amber') ? '#f59e0b' : '#10b981'}}>
                                <alert.icon className={`w-6 h-6 ${alert.color}`} />
                                <div className="flex-grow">
                                    <p className="text-slate-800">{alert.text}</p>
                                </div>
                                <p className="text-sm text-slate-400">{alert.time}</p>
                                {!alert.read && (
                                    <Button variant="ghost" size="sm" onClick={() => handleAlertAction(alert.id)}>وضع علامة مقروء</Button>
                                )}
                            </div>
                        ))}
                        {filteredAlerts.length === 0 && <p className="text-slate-500 text-center py-4">لا توجد تنبيهات تطابق بحثك.</p>}
                    </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default React.memo(AiSupervision);