import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { CreditCard, BarChart, Mail, MessageCircle, FileSignature, Settings, Zap } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Input } from '@/components/ui/input';

const initialIntegrations = [
    { id: 'stripe', name: 'Stripe', category: 'بوابة دفع', icon: CreditCard, connected: true, apiKey: 'sk_test_xxxxxxxxxxxx', webhookSecret: 'whsec_yyyyyyyyyyyy' },
    { id: 'tamara', name: 'Tamara', category: 'تمويل (اشتر الآن وادفع لاحقاً)', icon: CreditCard, connected: true, apiKey: 'tamara_pk_xxxxxxxxxx', notificationToken: 'tamara_nt_yyyyyyyyyy' },
    { id: 'tabby', name: 'Tabby', category: 'تمويل (اشتر الآن وادفع لاحقاً)', icon: CreditCard, connected: false, apiKey: '', notificationToken: '' },
    { id: 'docusign', name: 'DocuSign', category: 'توقيع إلكتروني للعقود', icon: FileSignature, connected: true, accountId: 'ds_acc_xxxxxxxx', integrationKey: 'ds_ik_yyyyyyyy' },
    { id: 'googleAnalytics', name: 'Google Analytics', category: 'تحليلات الموقع', icon: BarChart, connected: true, trackingId: 'UA-XXXXXXXXX-X', viewId: 'ga:xxxxxxxx' },
    { id: 'sendgrid', name: 'SendGrid', category: 'خدمة إرسال البريد الإلكتروني', icon: Mail, connected: false, apiKey: '', senderEmail: '' },
    { id: 'twilio', name: 'Twilio', category: 'خدمة إرسال رسائل SMS', icon: MessageCircle, connected: false, accountSid: '', authToken: '', fromNumber: '' },
    { id: 'zapier', name: 'Zapier', category: 'أتمتة المهام', icon: Zap, connected: false, apiKey: '', webhookUrl: '' },
];

const Integrations = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [integrations, setIntegrations] = useState(initialIntegrations);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [currentIntegration, setCurrentIntegration] = useState(null);

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

    const handleToggleConnection = (integrationId) => {
        const toggledInt = integrations.find(i => i.id === integrationId);
        setIntegrations(prev => prev.map(int => 
            int.id === integrationId ? { ...int, connected: !int.connected } : int
        ));
        handleFeatureClick(`${toggledInt.connected ? 'قطع اتصال' : 'توصيل'} ${toggledInt.name}`);
    };

    const openSettingsModal = (integration) => {
        setCurrentIntegration(integration);
        setIsModalOpen(true);
        handleFeatureClick(`فتح إعدادات تكامل ${integration.name}`);
    };

    const handleSettingsChange = (field, value) => {
        setCurrentIntegration(prev => ({ ...prev, [field]: value }));
        handleFeatureClick(`تغيير حقل ${field} في إعدادات ${currentIntegration?.name}`);
    };

    const saveIntegrationSettings = () => {
        if (!currentIntegration) return;
        setIntegrations(prev => prev.map(int => 
            int.id === currentIntegration.id ? currentIntegration : int
        ));
        handleFeatureClick(`حفظ إعدادات ${currentIntegration.name}`);
        setIsModalOpen(false);
        setCurrentIntegration(null);
    };
    
    const getIntegrationFields = (integration) => {
        switch(integration.id) {
            case 'stripe': return [{label: 'API Key', field: 'apiKey', type: 'password'}, {label: 'Webhook Secret', field: 'webhookSecret', type: 'password'}];
            case 'tamara': return [{label: 'API Key', field: 'apiKey'}, {label: 'Notification Token', field: 'notificationToken'}];
            case 'tabby': return [{label: 'API Key', field: 'apiKey'}, {label: 'Notification Token', field: 'notificationToken'}];
            case 'docusign': return [{label: 'Account ID', field: 'accountId'}, {label: 'Integration Key', field: 'integrationKey'}];
            case 'googleAnalytics': return [{label: 'Tracking ID', field: 'trackingId'}, {label: 'View ID', field: 'viewId'}];
            case 'sendgrid': return [{label: 'API Key', field: 'apiKey', type: 'password'}, {label: 'Sender Email', field: 'senderEmail', type: 'email'}];
            case 'twilio': return [{label: 'Account SID', field: 'accountSid'}, {label: 'Auth Token', field: 'authToken', type: 'password'}, {label: 'From Number', field: 'fromNumber'}];
            case 'zapier': return [{label: 'API Key', field: 'apiKey', type: 'password'}, {label: 'Webhook URL', field: 'webhookUrl'}];
            default: return [];
        }
    };

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">التكاملات والأنظمة الخارجية</h1>
                <p className="text-slate-500 mt-1">ربط وإدارة الخدمات الخارجية مثل بوابات الدفع، التمويل، توقيع العقود، والتحليلات.</p>
            </div>

            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                {integrations.map((integration) => (
                    <Card key={integration.id}>
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
                        <CardContent className="flex flex-col gap-3">
                            <div className="flex items-center justify-between">
                                <Label htmlFor={`switch-${integration.id}`} className={integration.connected ? 'text-emerald-600' : 'text-slate-500'}>
                                    {integration.connected ? 'متصل' : 'غير متصل'}
                                </Label>
                                <Switch id={`switch-${integration.id}`} checked={integration.connected} onCheckedChange={() => handleToggleConnection(integration.id)} />
                            </div>
                            <Button variant="outline" size="sm" onClick={() => openSettingsModal(integration)} className="w-full">
                                <Settings className="w-4 h-4 ml-2"/> إعدادات التكامل
                            </Button>
                        </CardContent>
                    </Card>
                ))}
            </div>
            {currentIntegration && (
                <Dialog open={isModalOpen} onOpenChange={(isOpen) => { if(!isOpen) setCurrentIntegration(null); setIsModalOpen(isOpen);}}>
                    <DialogContent dir="rtl">
                        <DialogHeader>
                            <DialogTitle>إعدادات تكامل {currentIntegration.name}</DialogTitle>
                            <DialogDescription>أدخل معلومات الربط الخاصة بـ {currentIntegration.name}.</DialogDescription>
                        </DialogHeader>
                        <div className="py-4 space-y-4">
                            {getIntegrationFields(currentIntegration).map(fieldInfo => (
                                <div key={fieldInfo.field}>
                                    <Label htmlFor={fieldInfo.field}>{fieldInfo.label}</Label>
                                    <Input 
                                        id={fieldInfo.field} 
                                        name={fieldInfo.field} 
                                        type={fieldInfo.type || 'text'}
                                        value={currentIntegration[fieldInfo.field] || ''} 
                                        onChange={(e) => handleSettingsChange(fieldInfo.field, e.target.value)} 
                                    />
                                </div>
                            ))}
                        </div>
                        <DialogFooter className="gap-2">
                            <Button variant="ghost" onClick={() => {setIsModalOpen(false); setCurrentIntegration(null); handleFeatureClick(`إلغاء إعدادات ${currentIntegration.name}`);}}>إلغاء</Button>
                            <Button onClick={saveIntegrationSettings}>حفظ الإعدادات</Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>
            )}
        </div>
    );
};

export default React.memo(Integrations);