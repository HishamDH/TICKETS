import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { Share2, Send } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const socialPlatforms = [
    { id: 'twitter', name: 'Twitter / X', icon: (props) => <svg {...props}><path d="M22.46 6c-.77.35-1.6.58-2.46.67.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98-3.56-.18-6.73-1.89-8.84-4.48-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.22-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.5 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"></path></svg> },
    { id: 'instagram', name: 'Instagram', icon: (props) => <svg {...props}><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg> },
    { id: 'facebook', name: 'Facebook', icon: (props) => <svg {...props}><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg> },
    { id: 'snapchat', name: 'Snapchat', icon: (props) => <svg {...props}><path d="M12 20.3a2.1 2.1 0 0 1-1.8-1.1l-2.5-4.2a2.3 2.3 0 0 1 0-2.3l2.5-4.2a2.1 2.1 0 0 1 3.6 0l2.5 4.2a2.3 2.3 0 0 1 0 2.3l-2.5 4.2a2.1 2.1 0 0 1-1.8 1.1z"></path><path d="M8.5 12.8a0.7.7 0 0 0-1 0 3.5 3.5 0 0 0 0 5.6.7.7 0 0 0 1 0"></path><path d="M15.5 12.8a0.7.7 0 0 1 1 0 3.5 3.5 0 0 1 0 5.6.7.7 0 0 1-1 0"></path></svg> },
];

const SocialMediaIntegrationContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [integrations, setIntegrations] = useState(JSON.parse(localStorage.getItem('lilium_night_social_integrations_v1')) || {});

    useEffect(() => {
        localStorage.setItem('lilium_night_social_integrations_v1', JSON.stringify(integrations));
    }, [integrations]);

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

    const handleToggleIntegration = (platformId, checked) => {
        setIntegrations(prev => ({
            ...prev,
            [platformId]: checked ? { connected: true, autoPost: false } : undefined
        }));
        handleFeatureClick(`${checked ? 'ربط' : 'إلغاء ربط'} حساب ${platformId}`);
    };

    const handleToggleAutoPost = (platformId, checked) => {
        setIntegrations(prev => ({
            ...prev,
            [platformId]: { ...prev[platformId], autoPost: checked }
        }));
        handleFeatureClick(`تغيير النشر التلقائي لـ ${platformId} إلى ${checked ? 'مفعل' : 'معطل'}`);
    };
    
    const handleShareNow = (platformName) => {
        handleFeatureClick(`مشاركة الآن على ${platformName}`);
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">ربط ومشاركة عبر السوشيال ميديا</h2>
            
            <div className="grid md:grid-cols-2 gap-8">
                {socialPlatforms.map(platform => (
                    <Card key={platform.id}>
                        <CardHeader>
                            <div className="flex justify-between items-center">
                                <CardTitle className="flex items-center gap-3">
                                    <platform.icon className="w-6 h-6" /> {platform.name}
                                </CardTitle>
                                <Switch 
                                    checked={!!integrations[platform.id]?.connected} 
                                    onCheckedChange={(checked) => handleToggleIntegration(platform.id, checked)}
                                />
                            </div>
                        </CardHeader>
                        <CardContent>
                            {integrations[platform.id]?.connected ? (
                                <div className="space-y-4">
                                    <p className="text-green-600 font-semibold">تم الربط بنجاح!</p>
                                    <div className="flex items-center space-x-2 space-x-reverse p-3 bg-slate-50 rounded-lg">
                                        <Switch 
                                            id={`auto-post-${platform.id}`} 
                                            checked={!!integrations[platform.id]?.autoPost}
                                            onCheckedChange={(checked) => handleToggleAutoPost(platform.id, checked)}
                                        />
                                        <Label htmlFor={`auto-post-${platform.id}`}>نشر العروض الجديدة تلقائياً</Label>
                                    </div>
                                    <Button variant="outline" className="w-full" onClick={() => handleShareNow(platform.name)}>
                                        <Send className="w-4 h-4 ml-2" /> مشاركة عرض مخصص الآن
                                    </Button>
                                </div>
                            ) : (
                                <p className="text-slate-500">اربط حسابك لنشر العروض والباقات مباشرة من لوحة التحكم.</p>
                            )}
                        </CardContent>
                    </Card>
                ))}
            </div>
        </div>
    );
});

export default SocialMediaIntegrationContent;