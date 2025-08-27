import React, { useState, useEffect, memo } from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { format, startOfDay, parseISO } from 'date-fns';
import { ar } from "date-fns/locale";
import { useToast } from "@/components/ui/use-toast";

import CalendarComponent from '@/components/merchant-dashboard/bookings-management/BookingControlCalendar/CalendarComponent';
import CalendarLegend from '@/components/merchant-dashboard/bookings-management/BookingControlCalendar/CalendarLegend';
import DaySettingsForm from '@/components/merchant-dashboard/bookings-management/BookingControlCalendar/DaySettingsForm';
import CopySettingsModal from '@/components/merchant-dashboard/bookings-management/BookingControlCalendar/CopySettingsModal';

const BookingControlCalendar = memo(({ 
    dailyConfigs, 
    onDayConfigUpdate, 
    onAddPackageToDate, 
    onToggleDateOnlineSale,
    handleFeatureClick: propHandleFeatureClick 
}) => {
  const { toast } = useToast();
  const [selectedDate, setSelectedDate] = useState(null);
  const [editModeDate, setEditModeDate] = useState(null);
  const [isCopySettingsModalOpen, setIsCopySettingsModalOpen] = useState(false);
  const [copyTargetDates, setCopyTargetDates] = useState([]);

  const [currentDayLocalConfig, setCurrentDayLocalConfig] = useState({
    status: "closed", 
    morningAvailable: false,
    eveningAvailable: false,
    customTimes: [], 
    onlineSaleActive: false,
    isLocked: false,
  });

  useEffect(() => {
    if (editModeDate) {
      const dateString = format(editModeDate, 'yyyy-MM-dd');
      const existingConfig = dailyConfigs[dateString];
      if (existingConfig) {
        setCurrentDayLocalConfig(existingConfig);
      } else {
        setCurrentDayLocalConfig({
          status: "closed", morningAvailable: false, eveningAvailable: false,
          customTimes: [], onlineSaleActive: false, isLocked: false,
        });
      }
    }
  }, [editModeDate, dailyConfigs]);

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

  const handleDateSelect = (date) => {
    const today = startOfDay(new Date());
    if (date && date < today) {
      toast({ title: "تاريخ غير صالح", description: "لا يمكنك تعديل إعدادات الأيام الماضية.", variant: "destructive" });
      setSelectedDate(null); setEditModeDate(null); return;
    }
    setSelectedDate(date); setEditModeDate(date); 
    handleFeatureClick(`اختيار يوم ${format(date, 'PPP', {locale: ar})} من التقويم`);
  };

  const handleDayStatusChange = (status) => {
    setCurrentDayLocalConfig(prev => ({ ...prev, status, isLocked: status === 'locked' ? true : prev.isLocked }));
    handleFeatureClick(`تغيير حالة اليوم إلى ${status}`);
  };

  const handleTimeSlotChange = (slot, checked) => {
    setCurrentDayLocalConfig(prev => ({ ...prev, [slot]: checked }));
    handleFeatureClick(`تغيير حالة الفترة ${slot} إلى ${checked}`);
  };
  
  const handleAddCustomTime = () => {
    setCurrentDayLocalConfig(prev => ({ ...prev, customTimes: [...(prev.customTimes || []), { startTime: '', endTime: '', name: `فترة ${ (prev.customTimes || []).length + 1}` }]}));
    handleFeatureClick("إضافة فترة زمنية مخصصة جديدة");
  };

  const handleCustomTimeChange = (index, field, value) => {
    setCurrentDayLocalConfig(prev => ({ ...prev, customTimes: (prev.customTimes || []).map((time, i) => i === index ? { ...time, [field]: value } : time)}));
  };

  const handleRemoveCustomTime = (index) => {
    setCurrentDayLocalConfig(prev => ({ ...prev, customTimes: (prev.customTimes || []).filter((_, i) => i !== index)}));
    handleFeatureClick(`حذف الفترة الزمنية المخصصة رقم ${index + 1}`);
  };

  const validateAndSaveDaySettings = () => {
    if (!selectedDate) { toast({ title: "خطأ", description: "الرجاء تحديد تاريخ أولاً.", variant: "destructive" }); return; }
    const dateString = format(selectedDate, 'yyyy-MM-dd');
    
    if (currentDayLocalConfig.status === 'available' && !currentDayLocalConfig.morningAvailable && !currentDayLocalConfig.eveningAvailable && (currentDayLocalConfig.customTimes || []).length === 0) {
      toast({ title: "تنبيه", description: "يجب تحديد فترة واحدة على الأقل إذا كان اليوم متاحًا.", variant: "destructive" }); return;
    }

    for (const customTime of (currentDayLocalConfig.customTimes || [])) {
      if (!customTime.startTime || !customTime.endTime || !customTime.name) {
        toast({ title: "أوقات مخصصة غير مكتملة", description: "يرجى ملء جميع حقول الأوقات المخصصة أو حذفها.", variant: "destructive" }); return;
      }
      if (customTime.startTime >= customTime.endTime) {
        toast({ title: "خطأ في الوقت المخصص", description: `في "${customTime.name}", يجب أن يكون وقت البدء قبل وقت الانتهاء.`, variant: "destructive" }); return;
      }
    }
    
    onDayConfigUpdate(dateString, currentDayLocalConfig); 
    setEditModeDate(null); 
    toast({ title: "تم الحفظ", description: `تم حفظ إعدادات يوم ${format(selectedDate, 'PPP', { locale: ar })}.` });
    handleFeatureClick(`حفظ إعدادات يوم ${format(selectedDate, 'PPP', { locale: ar })}`);
  };
  
  const cancelEdit = () => { setEditModeDate(null); setSelectedDate(null); handleFeatureClick("إلغاء تعديل إعدادات اليوم"); };

  const handleOpenCopyModal = () => { setIsCopySettingsModalOpen(true); handleFeatureClick("فتح نافذة نسخ الإعدادات"); };
  const handleCloseCopyModal = () => { setIsCopySettingsModalOpen(false); setCopyTargetDates([]); handleFeatureClick("إغلاق نافذة نسخ الإعدادات"); };
  
  const handleConfirmCopySettings = () => {
    if (!editModeDate || copyTargetDates.length === 0) {
        toast({ title: "خطأ", description: "يرجى تحديد اليوم المصدر والأيام الهدف للنسخ.", variant: "destructive" }); return;
    }
    const sourceDateString = format(editModeDate, 'yyyy-MM-dd');
    const sourceConfig = dailyConfigs[sourceDateString];

    if (sourceConfig) {
        copyTargetDates.forEach(targetDate => {
            const targetDateString = format(targetDate, 'yyyy-MM-dd');
            onDayConfigUpdate(targetDateString, { ...sourceConfig, isLocked: false, onlineSaleActive: false });
        });
        toast({ title: "تم النسخ", description: `تم نسخ الإعدادات إلى ${copyTargetDates.length} يوم بنجاح. تم إلغاء تفعيل البيع والقفل تلقائياً للأيام المنسوخة.` });
        handleFeatureClick(`نسخ إعدادات يوم إلى ${copyTargetDates.length} أيام`);
    } else {
        toast({ title: "خطأ", description: `لا توجد إعدادات محفوظة ليوم ${format(editModeDate, 'PPP', { locale: ar })} لنسخها.`, variant: "destructive" });
    }
    handleCloseCopyModal();
  };

  const handleLockDay = () => {
    if (!selectedDate) return;
    const dateString = format(selectedDate, 'yyyy-MM-dd');
    const newConfig = { ...currentDayLocalConfig, status: 'locked', isLocked: true, onlineSaleActive: false, morningAvailable: false, eveningAvailable: false, customTimes: [] };
    onDayConfigUpdate(dateString, newConfig);
    setCurrentDayLocalConfig(newConfig);
    toast({ title: "تم القفل", description: `تم قفل يوم ${format(selectedDate, 'PPP', { locale: ar })} نهائياً.` });
    handleFeatureClick(`قفل يوم ${format(selectedDate, 'PPP', { locale: ar })} نهائياً`);
  };

  const handleToggleDateOnlineSaleInForm = () => {
    if (!editModeDate) return;
    const dateString = format(editModeDate, 'yyyy-MM-dd');
    const newOnlineSaleState = !currentDayLocalConfig.onlineSaleActive;
    
    if (onToggleDateOnlineSale) {
      onToggleDateOnlineSale(dateString, newOnlineSaleState, (success) => {
        if(success) setCurrentDayLocalConfig(prev => ({...prev, onlineSaleActive: newOnlineSaleState}));
      });
    }
  };
  
  return (
    <>
      <Card className="shadow-xl border-t-4 border-primary">
        <CardHeader>
          <CardTitle className="text-2xl font-bold">1. إعداد تقويم التوفر</CardTitle>
          <CardDescription>
            حدد الأيام المتاحة للحجز والأوقات. الأيام ذات الإطار الأزرق مفعلة للبيع أونلاين. الأيام ذات الحلقة الرمادية مقفلة.
          </CardDescription>
        </CardHeader>
        <CardContent className="grid md:grid-cols-2 gap-6">
          <div>
            <CalendarComponent selectedDate={selectedDate} onDateSelect={handleDateSelect} dailyConfigs={dailyConfigs} />
            <CalendarLegend />
          </div>
          <DaySettingsForm
            editModeDate={editModeDate}
            currentDayLocalConfig={currentDayLocalConfig}
            onDayStatusChange={handleDayStatusChange}
            onTimeSlotChange={handleTimeSlotChange}
            onAddCustomTime={handleAddCustomTime}
            onCustomTimeChange={handleCustomTimeChange}
            onRemoveCustomTime={handleRemoveCustomTime}
            onAddPackageToDate={onAddPackageToDate}
            onToggleDateOnlineSale={handleToggleDateOnlineSaleInForm}
            onSaveSettings={validateAndSaveDaySettings}
            onCancelEdit={cancelEdit}
            onOpenCopyModal={handleOpenCopyModal}
            onLockDay={handleLockDay}
            dailyConfigs={dailyConfigs}
          />
        </CardContent>
      </Card>
      <CopySettingsModal 
        isOpen={isCopySettingsModalOpen}
        onClose={handleCloseCopyModal}
        editModeDate={editModeDate}
        copyTargetDates={copyTargetDates}
        onCopyTargetDatesChange={setCopyTargetDates}
        onConfirmCopy={handleConfirmCopySettings}
      />
    </>
  );
});

export default BookingControlCalendar;