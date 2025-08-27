import React, { useState, useEffect, memo } from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Checkbox } from "@/components/ui/checkbox";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { format, parseISO } from 'date-fns';
import { ar } from "date-fns/locale";
import { useToast } from "@/components/ui/use-toast";
import { AlertTriangle, PackagePlus, Edit3, Save, Trash2, XCircle, Globe, Eye, EyeOff } from 'lucide-react';
import TermsAndConditionsModal from '@/components/merchant-dashboard/TermsAndConditionsModal'; 
import { Dialog, DialogContent, DialogFooter, DialogClose, DialogHeader, DialogTitle, DialogDescription } from "@/components/ui/dialog";


const DailyPackageManagement = memo(({ 
    availableDatesAndConfigs, 
    packagesByDate,
    onPackageUpdate, 
    onPackageAdd,
    onPackageDelete,
    showModalForDate,
    onCloseModal,
    onTogglePackageOnlineSale,
    handleFeatureClick: propHandleFeatureClick
}) => {
  const { toast } = useToast();
  const [selectedDateForPackages, setSelectedDateForPackages] = useState('');
  const [currentPackagesForSelectedDate, setCurrentPackagesForSelectedDate] = useState([]);
  const [editingPackage, setEditingPackage] = useState(null); 
  
  const [isAddOrEditPackageModalOpen, setIsAddOrEditPackageModalOpen] = useState(false);

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


  useEffect(() => {
    if (showModalForDate) {
        let initialDate = '';
        let packageToEditDetails = null;

        if (typeof showModalForDate === 'string') { 
            initialDate = showModalForDate;
        } else if (typeof showModalForDate === 'object' && showModalForDate.date && showModalForDate.id) { 
            initialDate = showModalForDate.date;
            packageToEditDetails = showModalForDate;
        }
        
        if (initialDate) {
            setSelectedDateForPackages(initialDate);
            if (packageToEditDetails) {
                const pkgToEdit = packagesByDate[initialDate]?.find(p => p.id === packageToEditDetails.id);
                setEditingPackage({ ...pkgToEdit, date: initialDate });
            } else {
                handleNewPackage(initialDate); 
            }
            setIsAddOrEditPackageModalOpen(true);
        }
    } else {
        setIsAddOrEditPackageModalOpen(false);
        setEditingPackage(null); 
    }
  }, [showModalForDate, packagesByDate, availableDatesAndConfigs]);


  useEffect(() => {
    if (selectedDateForPackages && packagesByDate[selectedDateForPackages]) {
      setCurrentPackagesForSelectedDate(packagesByDate[selectedDateForPackages]);
    } else {
      setCurrentPackagesForSelectedDate([]);
    }
  }, [selectedDateForPackages, packagesByDate]);

  const handleSavePackage = () => {
    const targetDate = editingPackage?.date; 
    if (!targetDate) {
      toast({ title: "خطأ", description: "التاريخ المستهدف للباقة غير محدد.", variant: "destructive" });
      return;
    }
    if (!editingPackage || !editingPackage.name || !editingPackage.price || !editingPackage.availableSlots) {
      toast({ title: "بيانات ناقصة", description: "يرجى ملء جميع حقول الباقة المطلوبة (الاسم، السعر، العدد المتاح).", variant: "destructive" });
      return;
    }
    if (availableDatesAndConfigs[targetDate]?.status !== 'available') {
      toast({ title: "خطأ في الحفظ", description: "لا يمكن حفظ باقة ليوم غير متاح. يرجى تعديل حالة اليوم في التقويم.", variant: "destructive" });
      return;
    }


    const effectiveOnlineStatus = editingPackage.onlineBookingEnabled && availableDatesAndConfigs[targetDate]?.onlineSaleActive;

    const packageToSave = { 
        ...editingPackage, 
        status: effectiveOnlineStatus ? 'منشور' : 'داخلي فقط' 
    };

    if (editingPackage.id) { 
      onPackageUpdate(targetDate, editingPackage.id, packageToSave);
      handleFeatureClick(`حفظ تعديلات الباقة: ${packageToSave.name}`);
    } else {
      onPackageAdd(targetDate, { ...packageToSave, id: Date.now().toString() });
      handleFeatureClick(`إضافة باقة جديدة: ${packageToSave.name}`);
    }
    
    onCloseModal(); 
    setEditingPackage(null);
    setIsAddOrEditPackageModalOpen(false);
  };

  const startEditPackage = (pkg, date) => {
    onCloseModal({ ...pkg, date: date });
    handleFeatureClick(`فتح نافذة تعديل الباقة: ${pkg.name}`);
  };

  const cancelEditPackage = () => {
    onCloseModal(); 
    setEditingPackage(null);
    setIsAddOrEditPackageModalOpen(false);
    handleFeatureClick("إلغاء تعديل/إضافة الباقة");
  };
  
  const handleNewPackage = (dateForModal) => {
    const targetDate = dateForModal;
    if (!targetDate) {
      toast({ title: "تنبيه", description: "الرجاء اختيار يوم من القائمة أولاً لإضافة باقة له.", variant: "destructive" });
      return;
    }
     if (availableDatesAndConfigs[targetDate]?.status !== 'available') {
      toast({ title: "تنبيه", description: "لا يمكن إضافة باقات ليوم غير متاح. يرجى تعديل حالة اليوم في التقويم.", variant: "warning" });
    }
    setEditingPackage({ 
        id: null, 
        date: targetDate, 
        name: '', 
        price: '', 
        availableSlots: '', 
        features: '', 
        onlineBookingEnabled: false, 
        status: 'داخلي فقط', 
        timeSlot: getAvailableTimeSlotsForDate(targetDate)[0]?.id || '' 
    });
    handleFeatureClick(`فتح نافذة إضافة باقة جديدة ليوم ${targetDate}`);
  };

  const handleDeletePackage = (dateString, packageId) => {
    onPackageDelete(dateString, packageId);
    const pkg = packagesByDate[dateString]?.find(p => p.id === packageId);
    handleFeatureClick(`حذف الباقة: ${pkg?.name}`);
  };
  
  const handleTogglePackageOnlineBookingInForm = (checked) => {
    if (!editingPackage) return;
    const targetDate = editingPackage.date;
    const isChecked = !!checked;

    if (isChecked && !availableDatesAndConfigs[targetDate]?.onlineSaleActive) {
        toast({ title: "تنبيه", description: "يجب تفعيل البيع أونلاين لليوم بأكمله أولاً من إعدادات التقويم.", variant: "warning"});
        handleFeatureClick(`محاولة تفعيل باقة أونلاين ليوم غير مفعل أونلاين: ${editingPackage.name}`);
        return;
    }
    setEditingPackage(prev => ({...prev, onlineBookingEnabled: isChecked}));
    handleFeatureClick(`تغيير حالة التفعيل أونلاين للباقة ${editingPackage.name} إلى ${isChecked}`);
  };
  
  const getAvailableTimeSlotsForDate = (dateString) => {
    const config = availableDatesAndConfigs[dateString];
    if (!config || config.status !== 'available') return [];
    
    const slots = [];
    if (config.morningAvailable) slots.push({ id: 'morning', name: 'الفترة الصباحية (9ص - 3م)'});
    if (config.eveningAvailable) slots.push({ id: 'evening', name: 'الفترة المسائية (5م - 11م)'});
    (config.customTimes || []).forEach((ct, index) => {
        if (ct.name && ct.startTime && ct.endTime) {
            slots.push({id: `custom-${index}`, name: `${ct.name} (${ct.startTime} - ${ct.endTime})` });
        }
    });
    return slots;
  };

  const renderPackageForm = () => {
    if(!editingPackage || !editingPackage.date) return null; 
    const targetDate = editingPackage.date;
    const dayIsOnlineActive = availableDatesAndConfigs[targetDate]?.onlineSaleActive;
    const dayIsAvailable = availableDatesAndConfigs[targetDate]?.status === 'available';

    return (
        <div className="space-y-4">
        <Input placeholder="اسم الباقة (مثلاً: الباقة الذهبية)" value={editingPackage.name || ''} onChange={e => setEditingPackage({...editingPackage, name: e.target.value})} />
        <Input type="number" placeholder="السعر (ريال)" value={editingPackage.price || ''} onChange={e => setEditingPackage({...editingPackage, price: e.target.value})} />
        <Input type="number" placeholder="عدد الحجوزات المتاحة لهذه الباقة" value={editingPackage.availableSlots || ''} onChange={e => setEditingPackage({...editingPackage, availableSlots: e.target.value})} />
        <Textarea placeholder="مميزات الباقة (مثلاً: تشمل عدد 100 ضيف، تقديم المشروبات...)" value={editingPackage.features || ''} onChange={e => setEditingPackage({...editingPackage, features: e.target.value})} />
        
        <Select value={editingPackage.timeSlot || ''} onValueChange={value => {setEditingPackage({...editingPackage, timeSlot: value}); handleFeatureClick(`تغيير فترة الباقة إلى ${value}`);}} dir="rtl" disabled={!dayIsAvailable}>
            <SelectTrigger><SelectValue placeholder="اختر الفترة الزمنية للباقة..." /></SelectTrigger>
            <SelectContent>
            {getAvailableTimeSlotsForDate(targetDate).map(slot => (
                <SelectItem key={slot.id} value={slot.id}>{slot.name}</SelectItem>
            ))}
            {getAvailableTimeSlotsForDate(targetDate).length === 0 && <SelectItem value="" disabled>
                {dayIsAvailable ? "لا توجد فترات محددة لهذا اليوم المتاح" : "اليوم غير متاح"}
            </SelectItem>}
            </SelectContent>
        </Select>

        <div className="flex items-center space-x-2 space-x-reverse pt-2">
            <Checkbox 
                id={`onlineBookingEnabledEdit-${editingPackage.id || 'new'}`} 
                checked={!!editingPackage.onlineBookingEnabled} 
                onCheckedChange={handleTogglePackageOnlineBookingInForm}
                disabled={!dayIsOnlineActive || !dayIsAvailable}
            />
            <Label htmlFor={`onlineBookingEnabledEdit-${editingPackage.id || 'new'}`} className={`flex items-center gap-1 ${(!dayIsOnlineActive || !dayIsAvailable) ? 'text-muted-foreground' : ''}`}>
                <Globe className={`w-4 h-4 ${(!dayIsOnlineActive || !dayIsAvailable) ? 'text-muted-foreground' : 'text-blue-500'}`}/> تفعيل الحجز الإلكتروني لهذه الباقة؟
            </Label>
        </div>
        {(!dayIsOnlineActive && dayIsAvailable) && (
             <p className="text-xs text-orange-600">يجب تفعيل البيع أونلاين لليوم بأكمله أولاً من إعدادات التقويم لتتمكن من تفعيل هذه الباقة أونلاين.</p>
        )}
         {!dayIsAvailable && (
             <p className="text-xs text-red-600">لا يمكن تفعيل الحجز الإلكتروني لأن اليوم غير متاح. يرجى تعديل حالة اليوم في التقويم.</p>
        )}
        </div>
    );
  }

  return (
    <>
    <Dialog open={isAddOrEditPackageModalOpen} onOpenChange={(isOpen) => { if (!isOpen) cancelEditPackage(); }}>
        <DialogContent className="sm:max-w-[525px]" dir="rtl">
            <DialogHeader>
                <DialogTitle className="text-xl font-semibold mb-1">
                 {editingPackage?.id ? 'تعديل باقة لـ' : 'إضافة باقة جديدة لـ'}: <span className="text-primary">{editingPackage?.date ? format(parseISO(editingPackage.date), 'PPP', { locale: ar }) : ''}</span>
                </DialogTitle>
                <DialogDescription>املأ تفاصيل الباقة.</DialogDescription>
            </DialogHeader>
            <div className="py-4">
                {renderPackageForm()}
            </div>
            <DialogFooter className="gap-2 pt-4 border-t">
                <Button variant="ghost" onClick={cancelEditPackage}><XCircle className="w-4 h-4 ml-2" />إلغاء</Button>
                <Button onClick={handleSavePackage} className="gradient-bg text-white" disabled={editingPackage && availableDatesAndConfigs[editingPackage.date]?.status !== 'available'}><Save className="w-4 h-4 ml-2" />حفظ الباقة</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>

    <Card className="shadow-xl border-t-4 border-secondary mt-6">
        <CardHeader>
            <CardTitle className="text-2xl font-bold">2. إدارة الباقات اليومية</CardTitle>
            <CardDescription>
            لكل يوم متاح في التقويم، قم بإنشاء وتحديد الباقات المتوفرة، أسعارها، ومميزاتها. يمكنك إضافة أو تعديل الباقات من هنا بعد اختيار التاريخ.
            </CardDescription>
        </CardHeader>
        <CardContent className="space-y-6">
            <div>
            <Label htmlFor="date-select-packages">اختر تاريخًا لعرض/إدارة باقاته:</Label>
            <Select value={selectedDateForPackages} onValueChange={(val) => {setSelectedDateForPackages(val); setEditingPackage(null); handleFeatureClick(`اختيار تاريخ لإدارة الباقات: ${val}`);}} dir="rtl">
                <SelectTrigger id="date-select-packages">
                <SelectValue placeholder="اختر تاريخاً..." />
                </SelectTrigger>
                <SelectContent>
                {Object.keys(availableDatesAndConfigs).length > 0 ? Object.keys(availableDatesAndConfigs).filter(dateKey => availableDatesAndConfigs[dateKey].status === 'available').sort((a,b) => new Date(a) - new Date(b)).map(dateString => (
                    <SelectItem key={dateString} value={dateString}>
                    {format(parseISO(dateString), 'PPP', { locale: ar })}  {availableDatesAndConfigs[dateString]?.onlineSaleActive ? '( مفعل أونلاين )' : ''}
                    </SelectItem>
                )) : <SelectItem value="no-dates" disabled>لا توجد أيام متاحة في التقويم بعد</SelectItem>}
                </SelectContent>
            </Select>
            </div>

            {selectedDateForPackages && availableDatesAndConfigs[selectedDateForPackages]?.status !== 'available' && (
                <div className="p-4 bg-yellow-50 border border-yellow-200 rounded-md flex items-center gap-2">
                <AlertTriangle className="w-5 hh-5 text-yellow-500"/>
                <p className="text-sm text-yellow-700">هذا اليوم محدد كـ"{availableDatesAndConfigs[selectedDateForPackages]?.status === 'closed' ? 'مغلق' : 'غير متاح بالكامل'}". لا يمكنك إضافة باقات له حاليًا. يرجى تعديل حالة اليوم في التقويم أولاً.</p>
            </div>
            )}

            {selectedDateForPackages && availableDatesAndConfigs[selectedDateForPackages]?.status === 'available' && (
            <>
                <Button onClick={() => {onCloseModal(selectedDateForPackages); handleFeatureClick(`إضافة باقة جديدة لليوم المحدد ${selectedDateForPackages}`);}} variant="outline" className="w-full mt-4"><PackagePlus className="w-4 h-4 ml-2" />إضافة باقة جديدة لهذا اليوم المحدد</Button>
                
                {currentPackagesForSelectedDate.length > 0 && (
                <div className="mt-6">
                    <h4 className="text-lg font-semibold mb-2">الباقات المضافة لـ <span className="text-primary">{format(parseISO(selectedDateForPackages), 'PPP', { locale: ar })}</span>:</h4>
                    <Table>
                    <TableHeader><TableRow>
                        <TableHead>اسم الباقة</TableHead><TableHead>السعر</TableHead><TableHead>العدد المتاح</TableHead><TableHead>الفترة</TableHead><TableHead>متاح أونلاين؟</TableHead><TableHead>الحالة</TableHead><TableHead>إجراءات</TableHead>
                    </TableRow></TableHeader>
                    <TableBody>
                        {currentPackagesForSelectedDate.map(pkg => (
                        <TableRow key={pkg.id}>
                            <TableCell>{pkg.name}</TableCell>
                            <TableCell>{pkg.price} ريال</TableCell>
                            <TableCell>{pkg.availableSlots}</TableCell>
                            <TableCell>{getAvailableTimeSlotsForDate(selectedDateForPackages).find(s => s.id === pkg.timeSlot)?.name || 'غير محدد'}</TableCell>
                            <TableCell>
                            <Button 
                                variant="ghost" 
                                size="sm" 
                                onClick={() => {onTogglePackageOnlineSale(selectedDateForPackages, pkg.id, !pkg.onlineBookingEnabled); handleFeatureClick(`تبديل حالة التفعيل أونلاين للباقة ${pkg.name}`);}} 
                                className={pkg.onlineBookingEnabled ? "text-green-600 hover:text-green-700" : "text-slate-500 hover:text-slate-600"} 
                                disabled={!availableDatesAndConfigs[selectedDateForPackages]?.onlineSaleActive}
                            >
                                {pkg.onlineBookingEnabled ? <Eye className="w-4 h-4 ml-1"/> : <EyeOff className="w-4 h-4 ml-1"/>}
                                {pkg.onlineBookingEnabled ? 'نعم' : 'لا'}
                            </Button>
                            {!availableDatesAndConfigs[selectedDateForPackages]?.onlineSaleActive && <span className="text-xs text-muted-foreground block">(اليوم غير مفعل أونلاين)</span>}
                            </TableCell>
                            <TableCell>
                            <span className={`px-2 py-1 text-xs font-semibold rounded-full ${pkg.status === 'منشور' && availableDatesAndConfigs[selectedDateForPackages]?.onlineSaleActive ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'}`}>
                                {availableDatesAndConfigs[selectedDateForPackages]?.onlineSaleActive ? pkg.status : 'داخلي فقط'}
                            </span>
                            </TableCell>
                            <TableCell className="space-x-1 space-x-reverse">
                            <Button variant="ghost" size="icon" onClick={() => startEditPackage(pkg, selectedDateForPackages)}><Edit3 className="w-4 h-4 text-blue-600"/></Button>
                            <Button variant="ghost" size="icon" onClick={() => handleDeletePackage(selectedDateForPackages, pkg.id)}><Trash2 className="w-4 h-4 text-red-600"/></Button>
                            </TableCell>
                        </TableRow>
                        ))}
                    </TableBody>
                    </Table>
                </div>
                )}
            </>
            )}
        </CardContent>
        </Card>
    </>
  );
});

export default DailyPackageManagement;