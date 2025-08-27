import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { PlusCircle, Edit, Trash2, Plus, Search } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import AddServiceDialog from '@/components/merchant-dashboard/AddServiceDialog';

const ServiceAddonsContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [addons, setAddons] = useState(JSON.parse(localStorage.getItem('lilium_night_service_addons_v2')) || [
        { id: 'ADD-001', name: 'تصوير إضافي لساعة', description: 'ساعة تصوير إضافية للمناسبة', price: 300, category: 'photography', available: true },
        { id: 'ADD-002', name: 'ديكور إضافي للطاولات', description: 'تنسيق زهور إضافي للطاولات', price: 150, category: 'decoration', available: true },
    ]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [searchTerm, setSearchTerm] = useState('');
    const [modalContext, setModalContext] = useState({ category: 'general', name: ''});

    useEffect(() => {
        localStorage.setItem('lilium_night_service_addons_v2', JSON.stringify(addons));
    }, [addons]);

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

    const openModalForNew = (category = 'general', name = 'إضافة جديدة') => {
        setModalContext({ category, name });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة إضافة جديدة (فئة: ${category})`);
    };

    const handleDeleteAddon = (addonId) => {
        const addonToDelete = addons.find(a => a.id === addonId);
        setAddons(addons.filter(a => a.id !== addonId));
        toast({ title: "تم الحذف", description: `تم حذف الإضافة: ${addonToDelete?.name}`, variant: "destructive" });
        handleFeatureClick(`حذف الإضافة: ${addonToDelete?.name}`);
    };

    const handleAddonAdded = (newAddon) => {
        setAddons(prev => [...prev, newAddon]);
    };

    const filteredAddons = addons.filter(addon => 
        addon.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
        addon.description.toLowerCase().includes(searchTerm.toLowerCase())
    );

    return (
        <div className="space-y-8">
             <div className="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 className="text-3xl font-bold text-slate-800">إدارة الإضافات (Add-ons)</h2>
                    <p className="text-slate-500 mt-1">خدمات إضافية يمكن للعميل اختيارها لتعزيز باقته الأساسية.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={() => openModalForNew('general')}>
                    <PlusCircle className="w-5 h-5 ml-2"/> إضافة Add-on جديد
                </Button>
            </div>
            
            <Card>
                <CardHeader>
                   <div className="flex justify-between items-center">
                        <div>
                            <CardTitle>قائمة الإضافات المتاحة ({filteredAddons.length})</CardTitle>
                            <CardDescription>إدارة الخدمات الإضافية التي يمكن للعملاء اختيارها.</CardDescription>
                        </div>
                         <div className="relative w-64">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-500" />
                            <Input
                                placeholder="ابحث عن إضافة..."
                                className="pl-10"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                            />
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    {filteredAddons.length > 0 ? (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>اسم الإضافة</TableHead>
                                    <TableHead>الفئة</TableHead>
                                    <TableHead>السعر الإضافي</TableHead>
                                    <TableHead>الحالة</TableHead>
                                    <TableHead>إجراءات</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {filteredAddons.map((addon) => (
                                    <TableRow key={addon.id}>
                                        <TableCell>
                                            <div>
                                                <p className="font-semibold">{addon.name}</p>
                                                <p className="text-sm text-slate-500">{addon.description}</p>
                                            </div>
                                        </TableCell>
                                        <TableCell>{addon.category}</TableCell>
                                        <TableCell className="font-semibold text-green-600">+{Number(addon.price).toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'})}</TableCell>
                                        <TableCell>
                                            <span className={`px-2 py-1 text-xs font-semibold rounded-full ${addon.available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`}>
                                                {addon.available ? 'متاح' : 'غير متاح'}
                                            </span>
                                        </TableCell>
                                        <TableCell className="space-x-1 space-x-reverse">
                                            <Button variant="ghost" size="icon" onClick={() => handleFeatureClick(`تعديل الإضافة: ${addon.name}`)}>
                                                <Edit className="w-4 h-4 text-slate-600"/>
                                            </Button>
                                            <Button variant="ghost" size="icon" onClick={() => handleDeleteAddon(addon.id)}>
                                                <Trash2 className="w-4 h-4 text-red-600"/>
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    ) : (
                        <div className="text-center py-12 text-slate-500">
                            <Plus className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                            <p className="text-xl font-semibold">لا توجد إضافات تطابق بحثك.</p>
                            <p>ابدأ بإضافة خدمات إضافية لزيادة قيمة باقاتك.</p>
                        </div>
                    )}
                </CardContent>
            </Card>

            <AddServiceDialog 
                isOpen={isModalOpen}
                onOpenChange={setIsModalOpen}
                serviceCategory={modalContext.category}
                suggestedServiceName={modalContext.name}
                onAddonAdded={handleAddonAdded}
            />
        </div>
    );
});

export default ServiceAddonsContent;