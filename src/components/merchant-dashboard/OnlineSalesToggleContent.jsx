import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { Globe, Search } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const initialServices = [
    { id: 'srv1', name: 'قاعة الأفراح الملكية - الباقة الذهبية', online: true },
    { id: 'srv2', name: 'قاعة الأفراح الملكية - الباقة الفضية', online: true },
    { id: 'srv3', name: 'بوفيه الكرم للضيافة - قائمة العشاء', online: false },
    { id: 'srv4', name: 'استوديو الإبداع - باقة تصوير العروسين', online: true },
    { id: 'srv5', name: 'خدمة تنسيق الزهور', online: false },
];

const OnlineSalesToggleContent = memo(({ handleFeatureClick }) => {
    const { toast } = useToast();
    const [services, setServices] = useState(JSON.parse(localStorage.getItem('lilium_night_online_sales_v1')) || initialServices);
    const [searchTerm, setSearchTerm] = useState('');

    useEffect(() => {
        localStorage.setItem('lilium_night_online_sales_v1', JSON.stringify(services));
    }, [services]);

    const handleToggle = (serviceId, checked) => {
        setServices(services.map(s => s.id === serviceId ? { ...s, online: checked } : s));
        const serviceName = services.find(s => s.id === serviceId)?.name;
        toast({
            title: "تم تحديث الحالة",
            description: `تم ${checked ? 'تفعيل' : 'إيقاف'} البيع أونلاين لـ "${serviceName}".`,
        });
        handleFeatureClick(`تغيير حالة البيع لـ ${serviceName}`);
    };

    const filteredServices = services.filter(s => s.name.toLowerCase().includes(searchTerm.toLowerCase()));

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">تفعيل البيع أونلاين</h2>
            <Card>
                <CardHeader>
                    <CardTitle>إدارة ظهور الخدمات أونلاين</CardTitle>
                    <CardDescription>تحكم في أي من خدماتك وباقاتك تظهر للعملاء في صفحة الحجز الأونلاين.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="mb-6">
                        <div className="relative">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" />
                            <Input 
                                placeholder="ابحث عن خدمة أو باقة..." 
                                className="pl-10"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                            />
                        </div>
                    </div>
                    <div className="space-y-4">
                        {filteredServices.map(service => (
                            <div key={service.id} className="flex items-center justify-between p-4 border rounded-lg bg-slate-50">
                                <Label htmlFor={`switch-${service.id}`} className="font-semibold text-slate-700">{service.name}</Label>
                                <div className="flex items-center gap-3">
                                    <span className={`text-sm font-bold ${service.online ? 'text-green-600' : 'text-red-600'}`}>
                                        {service.online ? 'معروض أونلاين' : 'غير معروض'}
                                    </span>
                                    <Switch
                                        id={`switch-${service.id}`}
                                        checked={service.online}
                                        onCheckedChange={(checked) => handleToggle(service.id, checked)}
                                    />
                                </div>
                            </div>
                        ))}
                    </div>
                </CardContent>
            </Card>
        </div>
    );
});

export default OnlineSalesToggleContent;