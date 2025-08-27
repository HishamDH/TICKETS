import React, { useState, useEffect, useMemo, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from "@/components/ui/dialog";
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Textarea } from '@/components/ui/textarea';
import { Popover, PopoverTrigger, PopoverContent } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { Clock, PlusCircle, Calendar as CalendarIcon, Edit, Trash2, CheckCircle, XCircle, Percent } from 'lucide-react';
import { format, parseISO, isPast, isValid, startOfDay } from "date-fns";
import { ar } from "date-fns/locale";
import { useToast } from "@/components/ui/use-toast";
import { cn } from "@/lib/utils";

const TimedPromotionsContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [promotions, setPromotions] = useState(JSON.parse(localStorage.getItem('lilium_night_timed_promos_v1')) || [
        { id: 'PROMO-001', name: 'عرض نهاية الأسبوع', description: 'خصم خاص على حجوزات نهاية الأسبوع.', discountType: 'percentage', discountValue: '15', dateRange: { from: '2025-07-01', to: '2025-07-31' } },
        { id: 'PROMO-002', name: 'خصم الحجز المبكر', description: 'خصم 200 ريال للحجوزات التي تتم قبل شهر من الموعد.', discountType: 'fixed', discountValue: '200', dateRange: { from: '2025-06-01', to: '2025-12-31' } },
    ]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingPromo, setEditingPromo] = useState(null);
    const [newPromoData, setNewPromoData] = useState({
        name: '', description: '', discountType: 'percentage', discountValue: '', dateRange: { from: null, to: null }
    });

    useEffect(() => {
        localStorage.setItem('lilium_night_timed_promos_v1', JSON.stringify(promotions));
    }, [promotions]);

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

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        const setTargetData = editingPromo ? setEditingPromo : setNewPromoData;
        setTargetData(prev => ({ ...prev, [name]: value }));
    };

    const handleDateRangeChange = (range) => {
        const setTargetData = editingPromo ? setEditingPromo : setNewPromoData;
        setTargetData(prev => ({ ...prev, dateRange: { from: range?.from ? format(range.from, 'yyyy-MM-dd') : null, to: range?.to ? format(range.to, 'yyyy-MM-dd') : null } }));
    };
    
    const handleSelectChange = (name, value) => {
        const setTargetData = editingPromo ? setEditingPromo : setNewPromoData;
        setTargetData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = () => {
        const dataToSave = editingPromo || newPromoData;
        if (!dataToSave.name || !dataToSave.discountValue || !dataToSave.dateRange.from || !dataToSave.dateRange.to) {
            toast({ title: "خطأ", description: "يرجى ملء جميع الحقول المطلوبة (الاسم، قيمة الخصم، ونطاق التاريخ).", variant: "destructive" });
            return;
        }

        if (editingPromo) {
            setPromotions(promotions.map(p => p.id === editingPromo.id ? editingPromo : p));
            handleFeatureClick(`تحديث العرض المؤقت: ${editingPromo.name}`);
        } else {
            const newId = `PROMO-${Date.now().toString().slice(-5)}`;
            setPromotions([...promotions, { ...newPromoData, id: newId }]);
            handleFeatureClick(`إنشاء عرض مؤقت جديد: ${newPromoData.name}`);
        }
        closeModal();
    };

    const determineStatus = (promo) => {
        if (!promo.dateRange?.to || !isValid(parseISO(promo.dateRange.to))) return 'error';
        if (isPast(parseISO(promo.dateRange.to))) return 'expired';
        return 'active';
    };

    const getStatusDisplay = (status) => {
        switch(status) {
            case 'active': return { text: 'نشط', color: 'bg-green-100 text-green-700', icon: CheckCircle };
            case 'expired': return { text: 'منتهي', color: 'bg-red-100 text-red-700', icon: XCircle };
            default: return { text: 'غير معروف', color: 'bg-slate-100 text-slate-600', icon: Clock };
        }
    };

    const openModalForEdit = (promo) => {
        setEditingPromo({ ...promo });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة تعديل العرض المؤقت: ${promo.name}`);
    };
    
    const openModalForNew = () => {
        setEditingPromo(null);
        setNewPromoData({ name: '', description: '', discountType: 'percentage', discountValue: '', dateRange: { from: null, to: null } });
        setIsModalOpen(true);
        handleFeatureClick("فتح نافذة إنشاء عرض مؤقت جديد");
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setEditingPromo(null);
    };

    const handleDeletePromo = (promoId) => {
        const promoToDelete = promotions.find(p => p.id === promoId);
        setPromotions(promotions.filter(p => p.id !== promoId));
        handleFeatureClick(`حذف العرض المؤقت: ${promoToDelete?.name}`);
    };

    const renderPromoForm = () => {
        const currentData = editingPromo || newPromoData;
        const selectedDateRange = {
            from: currentData.dateRange.from ? parseISO(currentData.dateRange.from) : undefined,
            to: currentData.dateRange.to ? parseISO(currentData.dateRange.to) : undefined,
        };
        return (
            <div className="space-y-4">
                <div>
                    <Label htmlFor="promoName">اسم العرض</Label>
                    <Input id="promoName" name="name" value={currentData.name} onChange={handleInputChange} placeholder="مثال: عرض الصيف" />
                </div>
                <div>
                    <Label htmlFor="promoDescription">وصف قصير للعرض</Label>
                    <Textarea id="promoDescription" name="description" value={currentData.description} onChange={handleInputChange} placeholder="وصف يوضح تفاصيل العرض للعملاء." />
                </div>
                <div className="grid md:grid-cols-2 gap-4">
                    <div>
                        <Label>نوع الخصم</Label>
                        <Select dir="rtl" name="discountType" value={currentData.discountType} onValueChange={(val) => handleSelectChange('discountType', val)}>
                            <SelectTrigger><SelectValue /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="percentage">نسبة مئوية (%)</SelectItem>
                                <SelectItem value="fixed">مبلغ ثابت (ريال)</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <div>
                        <Label htmlFor="discountValue">قيمة الخصم</Label>
                        <Input id="discountValue" name="discountValue" type="number" value={currentData.discountValue} onChange={handleInputChange} placeholder="15 أو 50" />
                    </div>
                </div>
                <div>
                    <Label>فترة صلاحية العرض</Label>
                    <Popover>
                        <PopoverTrigger asChild>
                            <Button variant="outline" className="w-full justify-start text-right font-normal">
                                <CalendarIcon className="ml-2 h-4 w-4" />
                                {selectedDateRange.from ? (selectedDateRange.to ? (<>{format(selectedDateRange.from, "LLL dd, y", {locale:ar})} - {format(selectedDateRange.to, "LLL dd, y", {locale:ar})}</>) : format(selectedDateRange.from, "LLL dd, y", {locale:ar})) : (<span>اختر نطاق التاريخ</span>)}
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent className="w-auto p-0"><Calendar mode="range" selected={selectedDateRange} onSelect={handleDateRangeChange} initialFocus locale={ar} /></PopoverContent>
                    </Popover>
                </div>
            </div>
        );
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">العروض المؤقتة</h2>
                 <Button className="gradient-bg text-white" onClick={openModalForNew}>
                    <PlusCircle className="w-5 h-5 ml-2"/> إنشاء عرض جديد
                </Button>
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>قائمة العروض المؤقتة ({promotions.length})</CardTitle>
                    <CardDescription>إدارة العروض الخاصة التي تظهر للعملاء في فترات زمنية محددة.</CardDescription>
                </CardHeader>
                <CardContent>
                    {promotions.length > 0 ? (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>اسم العرض</TableHead>
                                    <TableHead>الخصم</TableHead>
                                    <TableHead>الفترة</TableHead>
                                    <TableHead>الحالة</TableHead>
                                    <TableHead>إجراءات</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {promotions.map((promo) => {
                                    const statusInfo = getStatusDisplay(determineStatus(promo));
                                    const StatusIcon = statusInfo.icon;
                                    return (
                                    <TableRow key={promo.id}>
                                        <TableCell className="font-semibold">{promo.name}</TableCell>
                                        <TableCell>{promo.discountType === 'percentage' ? `${promo.discountValue}%` : `${promo.discountValue} ريال`}</TableCell>
                                        <TableCell>{promo.dateRange.from ? `${format(parseISO(promo.dateRange.from), 'yyyy/MM/dd')} - ${format(parseISO(promo.dateRange.to), 'yyyy/MM/dd')}` : '-'}</TableCell>
                                        <TableCell>
                                            <span className={`px-2 py-1 text-xs font-semibold rounded-full flex items-center gap-1 w-fit ${statusInfo.color}`}>
                                                <StatusIcon className="w-3 h-3"/> {statusInfo.text}
                                            </span>
                                        </TableCell>
                                        <TableCell className="space-x-1 space-x-reverse">
                                            <Button variant="ghost" size="icon" onClick={() => openModalForEdit(promo)}><Edit className="w-4 h-4 text-blue-600"/></Button>
                                            <Button variant="ghost" size="icon" onClick={() => handleDeletePromo(promo.id)}><Trash2 className="w-4 h-4 text-red-600"/></Button>
                                        </TableCell>
                                    </TableRow>
                                )})}
                            </TableBody>
                        </Table>
                    ) : (
                        <div className="text-center py-12 text-slate-500">
                            <Clock className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                            <p className="text-xl font-semibold">لا توجد عروض مؤقتة مضافة بعد.</p>
                            <p>ابدأ بإنشاء عرض جديد لزيادة حجوزاتك في المواسم الهادئة.</p>
                        </div>
                    )}
                </CardContent>
            </Card>

            <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
                <DialogContent className="sm:max-w-[625px]" dir="rtl">
                    <DialogHeader>
                        <DialogTitle className="text-xl font-semibold mb-1">
                            {editingPromo ? 'تعديل العرض المؤقت' : 'إنشاء عرض مؤقت جديد'}
                        </DialogTitle>
                        <DialogDescription>
                           {editingPromo ? 'قم بتحديث تفاصيل العرض.' : 'أدخل تفاصيل العرض الجديد والفترة الزمنية لتفعيله.'}
                        </DialogDescription>
                    </DialogHeader>
                    <div className="py-4 max-h-[60vh] overflow-y-auto pr-2">
                        {renderPromoForm()}
                    </div>
                    <DialogFooter className="gap-2 pt-4 border-t">
                        <Button variant="ghost" onClick={closeModal}>إلغاء</Button>
                        <Button onClick={handleSubmit} className="gradient-bg text-white">
                            {editingPromo ? <Edit className="w-4 h-4 ml-2" /> : <PlusCircle className="w-4 h-4 ml-2" />}
                            {editingPromo ? 'حفظ التعديلات' : 'إنشاء العرض'}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
});

export default TimedPromotionsContent;