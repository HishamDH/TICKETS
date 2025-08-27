import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { ListOrdered, ArrowUp, ArrowDown, GripVertical } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const ServicesOrderContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [services, setServices] = useState(JSON.parse(localStorage.getItem('lilium_night_services_order_v1')) || [
        { id: 'srv1', name: 'قاعة الأفراح الملكية - الباقة الذهبية' },
        { id: 'srv2', name: 'قاعة الأفراح الملكية - الباقة الفضية' },
        { id: 'srv3', name: 'بوفيه الكرم للضيافة - قائمة العشاء' },
        { id: 'srv4', name: 'استوديو الإبداع - باقة تصوير العروسين' },
    ]);

    useEffect(() => {
        localStorage.setItem('lilium_night_services_order_v1', JSON.stringify(services));
    }, [services]);

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
    
    const moveService = (index, direction) => {
        const newServices = [...services];
        const targetIndex = index + direction;
        if (targetIndex < 0 || targetIndex >= newServices.length) return;
        
        [newServices[index], newServices[targetIndex]] = [newServices[targetIndex], newServices[index]];
        
        setServices(newServices);
        handleFeatureClick(`تغيير ترتيب خدمة: ${services[index].name}`);
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">ترتيب عرض الخدمات والباقات</h2>
            
            <Card>
                <CardHeader>
                    <CardTitle>إدارة ترتيب ظهور الخدمات</CardTitle>
                    <CardDescription>اسحب وأفلت أو استخدم الأسهم لترتيب كيفية ظهور خدماتك وباقاتك للعملاء في صفحتك العامة.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="space-y-2">
                        {services.map((service, index) => (
                            <div key={service.id} className="flex items-center gap-2 p-3 bg-slate-50 rounded-lg border">
                                <GripVertical className="w-5 h-5 text-slate-400 cursor-grab" />
                                <span className="flex-grow font-semibold">{service.name}</span>
                                <div className="flex gap-1">
                                    <Button variant="ghost" size="icon" disabled={index === 0} onClick={() => moveService(index, -1)}>
                                        <ArrowUp className="w-5 h-5" />
                                    </Button>
                                    <Button variant="ghost" size="icon" disabled={index === services.length - 1} onClick={() => moveService(index, 1)}>
                                        <ArrowDown className="w-5 h-5" />
                                    </Button>
                                </div>
                            </div>
                        ))}
                    </div>
                </CardContent>
            </Card>
        </div>
    );
});

export default ServicesOrderContent;