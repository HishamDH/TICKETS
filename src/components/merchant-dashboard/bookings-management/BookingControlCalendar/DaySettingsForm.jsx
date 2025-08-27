import React from 'react';
import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Label } from "@/components/ui/label";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { format } from 'date-fns';
import { ar } from "date-fns/locale";
import { AlertTriangle, Save, Trash2, XCircle, PackagePlus, Globe, Copy, Lock } from 'lucide-react';

const DaySettingsForm = ({
    editModeDate,
    currentDayLocalConfig,
    onDayStatusChange,
    onTimeSlotChange,
    onAddCustomTime,
    onCustomTimeChange,
    onRemoveCustomTime,
    onAddPackageToDate,
    onToggleDateOnlineSale,
    onSaveSettings,
    onCancelEdit,
    onOpenCopyModal,
    onLockDay,
    dailyConfigs, 
}) => {
    if (!editModeDate) return null;

    return (
        <Card className="p-6 bg-slate-50 shadow-inner">
            <h3 className="text-xl font-semibold mb-4">
                إعدادات يوم: <span className="text-primary">{format(editModeDate, 'PPP', { locale: ar })}</span>
                {currentDayLocalConfig.isLocked && <span className="text-sm text-red-500 mr-2">(مقفل نهائياً)</span>}
            </h3>
            
            <RadioGroup value={currentDayLocalConfig.status} onValueChange={onDayStatusChange} className="mb-4 space-y-2" disabled={currentDayLocalConfig.isLocked}>
                <div className="flex items-center space-x-2 space-x-reverse">
                    <RadioGroupItem value="available" id={`status-available-${format(editModeDate, 'yyyyMMdd')}`} />
                    <Label htmlFor={`status-available-${format(editModeDate, 'yyyyMMdd')}`}>متاح للحجز</Label>
                </div>
                <div className="flex items-center space-x-2 space-x-reverse">
                    <RadioGroupItem value="closed" id={`status-closed-${format(editModeDate, 'yyyyMMdd')}`} />
                    <Label htmlFor={`status-closed-${format(editModeDate, 'yyyyMMdd')}`}>مغلق</Label>
                </div>
            </RadioGroup>

            {currentDayLocalConfig.status === 'available' && !currentDayLocalConfig.isLocked && (
                <div className="space-y-4 pl-6 border-r-2 border-primary pr-4">
                    <p className="text-sm text-muted-foreground">اختر الأوقات المتاحة في هذا اليوم:</p>
                    <div className="flex items-center space-x-2 space-x-reverse">
                        <Checkbox id={`morning-${format(editModeDate, 'yyyyMMdd')}`} checked={currentDayLocalConfig.morningAvailable} onCheckedChange={(checked) => onTimeSlotChange('morningAvailable', checked)} />
                        <Label htmlFor={`morning-${format(editModeDate, 'yyyyMMdd')}`}>الفترة الصباحية (9ص - 3م)</Label>
                    </div>
                    <div className="flex items-center space-x-2 space-x-reverse">
                        <Checkbox id={`evening-${format(editModeDate, 'yyyyMMdd')}`} checked={currentDayLocalConfig.eveningAvailable} onCheckedChange={(checked) => onTimeSlotChange('eveningAvailable', checked)} />
                        <Label htmlFor={`evening-${format(editModeDate, 'yyyyMMdd')}`}>الفترة المسائية (5م - 11م)</Label>
                    </div>
                    
                    <h4 className="text-md font-semibold pt-2">أو أضف أوقات مخصصة:</h4>
                    {(currentDayLocalConfig.customTimes || []).map((customTime, index) => (
                        <div key={index} className="space-y-2 p-3 border rounded-md bg-white">
                            <Label htmlFor={`customName-${index}-${format(editModeDate, 'yyyyMMdd')}`}>اسم الفترة المخصصة</Label>
                            <Input id={`customName-${index}-${format(editModeDate, 'yyyyMMdd')}`} type="text" placeholder="مثال: حجز خاص" value={customTime.name} onChange={(e) => onCustomTimeChange(index, 'name', e.target.value)} />
                            <div className="grid grid-cols-2 gap-2">
                                <div>
                                    <Label htmlFor={`startTime-${index}-${format(editModeDate, 'yyyyMMdd')}`}>وقت البدء</Label>
                                    <Input id={`startTime-${index}-${format(editModeDate, 'yyyyMMdd')}`} type="time" value={customTime.startTime} onChange={(e) => onCustomTimeChange(index, 'startTime', e.target.value)} />
                                </div>
                                <div>
                                    <Label htmlFor={`endTime-${index}-${format(editModeDate, 'yyyyMMdd')}`}>وقت الإنتهاء</Label>
                                    <Input id={`endTime-${index}-${format(editModeDate, 'yyyyMMdd')}`} type="time" value={customTime.endTime} onChange={(e) => onCustomTimeChange(index, 'endTime', e.target.value)} />
                                </div>
                            </div>
                            <Button variant="destructive" size="sm" onClick={() => onRemoveCustomTime(index)} className="mt-1">
                                <Trash2 className="w-3 h-3 ml-1" /> حذف الفترة المخصصة
                            </Button>
                        </div>
                    ))}
                    <Button variant="outline" onClick={onAddCustomTime} className="w-full">إضافة وقت مخصص جديد</Button>
                    <Button 
                        variant="outline" 
                        className="w-full mt-2" 
                        onClick={() => onAddPackageToDate(format(editModeDate, 'yyyy-MM-dd'))}
                        disabled={currentDayLocalConfig.status !== 'available'}
                    >
                        <PackagePlus className="w-4 h-4 ml-2" /> إضافة باقة لهذا اليوم
                    </Button>
                    <Button 
                        variant={currentDayLocalConfig.onlineSaleActive ? "destructive" : "default"}
                        className={`w-full mt-2 text-white ${currentDayLocalConfig.onlineSaleActive ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600'}`}
                        onClick={onToggleDateOnlineSale}
                        disabled={currentDayLocalConfig.status !== 'available'}
                    >
                        <Globe className="w-4 h-4 ml-2" /> 
                        {currentDayLocalConfig.onlineSaleActive ? "إلغاء تفعيل البيع أونلاين لليوم" : "تفعيل البيع أونلاين لليوم"}
                    </Button>
                </div>
            )}
            
            {(currentDayLocalConfig.status === 'closed' || currentDayLocalConfig.status === 'locked') && !currentDayLocalConfig.isLocked && (
                <div className="p-4 bg-red-50 border border-red-200 rounded-md flex items-center gap-2">
                    <AlertTriangle className="w-5 h-5 text-red-500"/>
                    <p className="text-sm text-red-700">هذا اليوم محدد كـ "{currentDayLocalConfig.status === 'closed' ? 'مغلق' : 'مقفل'}". لن يكون متاحًا للحجوزات.</p>
                </div>
            )}

            <div className="flex justify-between items-center gap-2 mt-6">
                <div className="flex gap-2">
                    <Button variant="ghost" onClick={onCancelEdit}><XCircle className="w-4 h-4 ml-2" />إلغاء</Button>
                    <Button onClick={onSaveSettings} className="gradient-bg text-white" disabled={currentDayLocalConfig.isLocked}><Save className="w-4 h-4 ml-2" />حفظ</Button>
                </div>
                <div className="flex gap-2">
                    <Button variant="outline" onClick={onOpenCopyModal} disabled={currentDayLocalConfig.isLocked || !dailyConfigs[format(editModeDate, 'yyyy-MM-dd')]}><Copy className="w-4 h-4 ml-2"/>نسخ الإعدادات</Button>
                    <Button variant="destructive" onClick={onLockDay} disabled={currentDayLocalConfig.isLocked}><Lock className="w-4 h-4 ml-2"/>قفل اليوم نهائياً</Button>
                </div>
            </div>
        </Card>
    );
};

export default DaySettingsForm;