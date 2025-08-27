import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { Tag, PlusCircle, Calendar as CalendarIcon, Edit, Trash2, RefreshCw, CheckCircle, XCircle, Clock } from 'lucide-react';
import { format, parseISO, isPast, isValid } from "date-fns";
import { ar } from "date-fns/locale";
import { useToast } from "@/components/ui/use-toast";
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogDescription } from "@/components/ui/dialog";

const PromotionsContent = memo(({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [promoCodes, setPromoCodes] = useState(JSON.parse(localStorage.getItem('lilium_night_promo_codes_v1')) || [
        { id: 'CODE-001', name: 'خصم الصيف', code: 'LILIUM25', discountType: 'percentage', discountValue: '25', status: 'active', usageLimit: '100', currentUsage: 45, expiryDate: '2025-08-10', applicableServices: ['all'] },
        { id: 'CODE-002', name: 'عرض الزفاف', code: 'WEDDING500', discountType: 'fixed', discountValue: '500', status: 'active', usageLimit: '200', currentUsage: 88, expiryDate: '2025-09-15', applicableServices: ['venue1'] },
    ]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingPromo, setEditingPromo] = useState(null);
    const [newPromoData, setNewPromoData] = useState({
        name: '', code: '', discountType: 'percentage', discountValue: '', 
        usageLimit: '', expiryDate: null, applicableServices: ['all'], status: 'active', currentUsage: 0
    });

    useEffect(() => {
        localStorage.setItem('lilium_night_promo_codes_v1', JSON.stringify(promoCodes));
    }, [promoCodes]);

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

    const handleDateChange = (date) => {
        const setTargetData = editingPromo ? setEditingPromo : setNewPromoData;
        setTargetData(prev => ({ ...prev, expiryDate: date ? format(date, 'yyyy-MM-dd') : null }));
    };
    
    const handleSelectChange = (name, value) => {
        const setTargetData = editingPromo ? setEditingPromo : setNewPromoData;
        setTargetData(prev => ({ ...prev, [name]: value }));
    };

    const generateRandomCode = () => {
        const randomCode = Math.random().toString(36).substring(2, 10).toUpperCase();
        const setTargetData = editingPromo ? setEditingPromo : setNewPromoData;
        setTargetData(prev => ({ ...prev, code: randomCode }));
        handleFeatureClick("إنشاء كود خصم عشوائي");
    };

    const handleSubmit = () => {
        const dataToSave = editingPromo || newPromoData;
        if (!dataToSave.name || !dataToSave.code || !dataToSave.discountValue || !dataToSave.usageLimit || !dataToSave.expiryDate) {
            toast({ title: "خطأ", description: "يرجى ملء جميع الحقول المطلوبة.", variant: "destructive" });
            return;
        }
        if (parseFloat(dataToSave.discountValue) <= 0) {
             toast({ title: "خطأ", description: "قيمة الخصم يجب أن تكون أكبر من صفر.", variant: "destructive" });
            return;
        }
        if (parseInt(dataToSave.usageLimit) <= 0) {
             toast({ title: "خطأ", description: "الحد الأقصى للاستخدام يجب أن يكون أكبر من صفر.", variant: "destructive" });
            return;
        }

        if (editingPromo) {
            setPromoCodes(promoCodes.map(p => p.id === editingPromo.id ? { ...editingPromo, status: determineStatus(editingPromo) } : p));
            handleFeatureClick(`تحديث كود الخصم: ${editingPromo.code}`);
        } else {
            const newId = `CODE-${Date.now().toString().slice(-5)}`;
            const promoToAdd = { ...newPromoData, id: newId, currentUsage: 0, status: determineStatus(newPromoData) };
            setPromoCodes([...promoCodes, promoToAdd]);
            handleFeatureClick(`إنشاء كود خصم جديد: ${newPromoData.code}`);
        }
        closeModal();
    };
    
    const determineStatus = (promo) => {
        if (!promo.expiryDate || !isValid(parseISO(promo.expiryDate))) return 'error';
        if (isPast(parseISO(promo.expiryDate))) return 'expired';
        if (promo.currentUsage >= parseInt(promo.usageLimit)) return 'used_up';
        return 'active';
    };

    const getStatusDisplay = (status) => {
        switch(status) {
            case 'active': return { text: 'نشط', color: 'bg-green-100 text-green-700', icon: CheckCircle };
            case 'expired': return { text: 'منتهي', color: 'bg-red-100 text-red-700', icon: XCircle };
            case 'used_up': return { text: 'مستخدم بالكامل', color: 'bg-yellow-100 text-yellow-700', icon: Clock };
            default: return { text: 'غير معروف', color: 'bg-slate-100 text-slate-600', icon: Clock };
        }
    };

    const openModalForEdit = (promo) => {
        setEditingPromo({ ...promo });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة تعديل كود الخصم: ${promo.code}`);
    };
    
    const openModalForNew = () => {
        setEditingPromo(null);
        setNewPromoData({ 
            name: '', code: '', discountType: 'percentage', discountValue: '', 
            usageLimit: '', expiryDate: null, applicableServices: ['all'], status: 'active', currentUsage: 0
        });
        setIsModalOpen(true);
        handleFeatureClick("فتح نافذة إنشاء كود خصم جديد");
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setEditingPromo(null);
        handleFeatureClick("إغلاق نافذة إضافة/تعديل كود الخصم");
    };

    const handleDeletePromo = (promoId) => {
        const promoToDelete = promoCodes.find(p => p.id === promoId);
        setPromoCodes(promoCodes.filter(p => p.id !== promoId));
        handleFeatureClick(`حذف كود الخصم: ${promoToDelete?.code}`);
    };

    const renderPromoForm = () => {
        const currentData = editingPromo || newPromoData;
        const selectedDate = currentData.expiryDate ? parseISO(currentData.expiryDate) : null;
        return (
            <div className="space-y-4">
                <div className="grid md:grid-cols-2 gap-4">
                    <div>
                        <Label htmlFor="promoName">اسم العرض (داخلي، لك فقط)</Label>
                        <Input id="promoName" name="name" value={currentData.name} onChange={handleInputChange} placeholder="مثال: خصم الصيف" />
                    </div>
                    <div>
                        <Label htmlFor="promoCode">كود الخصم (سيستخدمه العميل)</Label>
                        <div className="flex gap-2">
                            <Input id="promoCode" name="code" value={currentData.code} onChange={handleInputChange} placeholder="SUMMER24" />
                            <Button variant="outline" size="icon" onClick={generateRandomCode}><RefreshCw className="h-4 w-4"/></Button>
                        </div>
                    </div>
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
                <div className="grid md:grid-cols-2 gap-4">
                    <div>
                        <Label htmlFor="usageLimit">الحد الأقصى للاستخدام</Label>
                        <Input id="usageLimit" name="usageLimit" type="number" value={currentData.usageLimit} onChange={handleInputChange} placeholder="100" />
                    </div>
                    <div>
                        <Label>تاريخ انتهاء الصلاحية</Label>
                        <Popover>
                            <PopoverTrigger asChild>
                                <Button variant="outline" className="w-full justify-start text-right font-normal">
                                    <CalendarIcon className="ml-2 h-4 w-4" />
                                    {selectedDate && isValid(selectedDate) ? format(selectedDate, "PPP", { locale: ar }) : <span>اختر تاريخاً</span>}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent className="w-auto p-0"><Calendar mode="single" selected={selectedDate} onSelect={handleDateChange} initialFocus locale={ar} /></PopoverContent>
                        </Popover>
                    </div>
                </div>
                <div>
                    <Label>تطبيق الخصم على</Label>
                    <Select dir="rtl" name="applicableServices" value={currentData.applicableServices[0]} onValueChange={(val) => handleSelectChange('applicableServices', [val])}>
                        <SelectTrigger><SelectValue /></SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">كل خدماتك</SelectItem>
                            <SelectItem value="venue1">قاعة الأفراح الملكية</SelectItem>
                            <SelectItem value="catering1">بوفيه الكرم للضيافة</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>
        );
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">العروض الترويجية وأكواد الخصم</h2>
                 <Button className="gradient-bg text-white" onClick={openModalForNew}>
                    <PlusCircle className="w-5 h-5 ml-2"/> إنشاء كود خصم جديد
                </Button>
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>قائمة أكواد الخصم ({promoCodes.length})</CardTitle>
                    <CardDescription>إدارة وتتبع جميع أكواد الخصم الخاصة بخدماتك.</CardDescription>
                </CardHeader>
                <CardContent>
                    {promoCodes.length > 0 ? (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>الكود</TableHead>
                                    <TableHead>الخصم</TableHead>
                                    <TableHead>يطبق على</TableHead>
                                    <TableHead>الحالة</TableHead>
                                    <TableHead>الاستخدام</TableHead>
                                    <TableHead>تاريخ الانتهاء</TableHead>
                                    <TableHead>إجراءات</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {promoCodes.map((promo) => {
                                    const statusInfo = getStatusDisplay(determineStatus(promo));
                                    const StatusIcon = statusInfo.icon;
                                    return (
                                    <TableRow key={promo.id}>
                                        <TableCell className="font-mono font-semibold">{promo.code}</TableCell>
                                        <TableCell>{promo.discountType === 'percentage' ? `${promo.discountValue}%` : `${promo.discountValue} ريال`}</TableCell>
                                        <TableCell>{promo.applicableServices.includes('all') ? 'كل الخدمات' : promo.applicableServices.join(', ')}</TableCell>
                                        <TableCell>
                                            <span className={`px-2 py-1 text-xs font-semibold rounded-full flex items-center gap-1 w-fit ${statusInfo.color}`}>
                                                <StatusIcon className="w-3 h-3"/> {statusInfo.text}
                                            </span>
                                        </TableCell>
                                        <TableCell>{promo.currentUsage}/{promo.usageLimit}</TableCell>
                                        <TableCell>{promo.expiryDate ? format(parseISO(promo.expiryDate), 'yyyy/MM/dd') : '-'}</TableCell>
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
                            <Tag className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                            <p className="text-xl font-semibold">لا توجد أكواد خصم مضافة بعد.</p>
                            <p>ابدأ بإنشاء كود خصم جديد لزيادة حجوزاتك.</p>
                        </div>
                    )}
                </CardContent>
            </Card>

            <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
                <DialogContent className="sm:max-w-[625px]" dir="rtl">
                    <DialogHeader>
                        <DialogTitle className="text-xl font-semibold mb-1">
                            {editingPromo ? 'تعديل كود الخصم' : 'إنشاء كود خصم جديد'}
                        </DialogTitle>
                        <DialogDescription>
                           {editingPromo ? 'قم بتحديث تفاصيل كود الخصم.' : 'أدخل تفاصيل كود الخصم الجديد لخدماتك.'}
                        </DialogDescription>
                    </DialogHeader>
                    <div className="py-4 max-h-[60vh] overflow-y-auto pr-2">
                        {renderPromoForm()}
                    </div>
                    <DialogFooter className="gap-2 pt-4 border-t">
                        <Button variant="ghost" onClick={closeModal}><XCircle className="w-4 h-4 ml-2" />إلغاء</Button>
                        <Button onClick={handleSubmit} className="gradient-bg text-white">
                            {editingPromo ? <Edit className="w-4 h-4 ml-2" /> : <PlusCircle className="w-4 h-4 ml-2" />}
                            {editingPromo ? 'حفظ التعديلات' : 'إنشاء الكود'}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
});

export default PromotionsContent;