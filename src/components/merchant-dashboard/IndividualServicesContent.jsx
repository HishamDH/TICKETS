import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { PlusCircle, Edit, Trash2, Package, Search } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import AddServiceDialog from '@/components/merchant-dashboard/AddServiceDialog';

const IndividualServicesContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [services, setServices] = useState(JSON.parse(localStorage.getItem('lilium_night_individual_services_v2')) || [
        { id: 'SRV-001', name: 'تصوير فوتوغرافي لساعة واحدة', description: 'جلسة تصوير احترافية لمدة ساعة واحدة', price: 500, duration: '1 ساعة', available: true, category: 'photography' },
        { id: 'SRV-002', name: 'مكياج عروس', description: 'مكياج احترافي للعروس يوم الزفاف', price: 800, duration: '3 ساعات', available: true, category: 'beauty' },
    ]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [searchTerm, setSearchTerm] = useState('');
    const [modalContext, setModalContext] = useState({ category: 'general', name: ''});

    useEffect(() => {
        localStorage.setItem('lilium_night_individual_services_v2', JSON.stringify(services));
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
    
    const openModalForNew = (category = 'general', name = 'خدمة فردية جديدة') => {
        setModalContext({ category, name });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة إضافة خدمة فردية جديدة (فئة: ${category})`);
    };
    
    const handleDeleteService = (serviceId) => {
        const serviceToDelete = services.find(s => s.id === serviceId);
        setServices(services.filter(s => s.id !== serviceId));
        toast({ title: "تم الحذف", description: `تم حذف الخدمة الفردية: ${serviceToDelete?.name}`, variant: "destructive" });
        handleFeatureClick(`حذف الخدمة الفردية: ${serviceToDelete?.name}`);
    };

    const handleAddService = (newService) => {
        setServices(prev => [...prev, newService]);
    };

    const filteredServices = services.filter(service => 
        service.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
        service.category.toLowerCase().includes(searchTerm.toLowerCase())
    );

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 className="text-3xl font-bold text-slate-800">إدارة الخدمات الفردية</h2>
                    <p className="text-slate-500 mt-1">الخدمات التي يمكن حجزها بشكل مستقل عن الباقات الرئيسية.</p>
                </div>
                <div className="flex gap-2">
                    <Button className="gradient-bg text-white" onClick={() => openModalForNew('photography')}>
                        <PlusCircle className="w-5 h-5 ml-2"/> إضافة خدمة تصوير
                    </Button>
                    <Button className="gradient-bg text-white" onClick={() => openModalForNew('venue')}>
                        <PlusCircle className="w-5 h-5 ml-2"/> إضافة قاعة
                    </Button>
                     <Button className="gradient-bg text-white" onClick={() => openModalForNew('beauty')}>
                        <PlusCircle className="w-5 h-5 ml-2"/> إضافة خدمة تجميل
                    </Button>
                </div>
            </div>
            
            <Card>
                <CardHeader>
                    <div className="flex justify-between items-center">
                        <div>
                            <CardTitle>قائمة الخدمات ({filteredServices.length})</CardTitle>
                            <CardDescription>إدارة الخدمات التي يمكن حجزها بشكل منفصل.</CardDescription>
                        </div>
                         <div className="relative w-64">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-500" />
                            <Input
                                placeholder="ابحث عن خدمة..."
                                className="pl-10"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                            />
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    {filteredServices.length > 0 ? (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>اسم الخدمة</TableHead>
                                    <TableHead>الفئة</TableHead>
                                    <TableHead>السعر</TableHead>
                                    <TableHead>المدة</TableHead>
                                    <TableHead>الحالة</TableHead>
                                    <TableHead>إجراءات</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {filteredServices.map((service) => (
                                    <TableRow key={service.id}>
                                        <TableCell className="font-semibold">{service.name}</TableCell>
                                        <TableCell>{service.category}</TableCell>
                                        <TableCell>{Number(service.price).toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'})}</TableCell>
                                        <TableCell>{service.duration || 'غير محدد'}</TableCell>
                                        <TableCell>
                                            <span className={`px-2 py-1 text-xs font-semibold rounded-full ${service.available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`}>
                                                {service.available ? 'متاح' : 'غير متاح'}
                                            </span>
                                        </TableCell>
                                        <TableCell className="space-x-1 space-x-reverse">
                                            <Button variant="ghost" size="icon" onClick={() => handleFeatureClick(`تعديل الخدمة: ${service.name}`)}>
                                                <Edit className="w-4 h-4 text-slate-600"/>
                                            </Button>
                                            <Button variant="ghost" size="icon" onClick={() => handleDeleteService(service.id)}>
                                                <Trash2 className="w-4 h-4 text-red-600"/>
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    ) : (
                        <div className="text-center py-12 text-slate-500">
                            <Package className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                            <p className="text-xl font-semibold">لا توجد خدمات فردية تطابق بحثك.</p>
                            <p>ابدأ بإضافة خدماتك الفردية لتوسيع خيارات عملائك.</p>
                        </div>
                    )}
                </CardContent>
            </Card>

            <AddServiceDialog 
                isOpen={isModalOpen}
                onOpenChange={setIsModalOpen}
                serviceCategory={modalContext.category}
                suggestedServiceName={modalContext.name}
                onServiceAdded={handleAddService}
            />
        </div>
    );
});

export default IndividualServicesContent;