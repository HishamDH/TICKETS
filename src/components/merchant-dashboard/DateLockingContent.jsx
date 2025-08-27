import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Calendar } from "@/components/ui/calendar";
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { XCircle, Lock, Trash2 } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { format } from "date-fns";
import { ar } from "date-fns/locale";

const DateLockingContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [lockedDates, setLockedDates] = useState(JSON.parse(localStorage.getItem('lilium_night_locked_dates_v1')) || []);
    const [selectedDates, setSelectedDates] = useState([]);
    const [lockReason, setLockReason] = useState('');

    useEffect(() => {
        localStorage.setItem('lilium_night_locked_dates_v1', JSON.stringify(lockedDates));
    }, [lockedDates]);

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

    const handleLockDates = () => {
        if (selectedDates.length === 0) {
            toast({ title: "خطأ", description: "الرجاء تحديد تاريخ واحد على الأقل.", variant: "destructive" });
            return;
        }
        if (!lockReason.trim()) {
            toast({ title: "خطأ", description: "الرجاء إدخال سبب لإغلاق التاريخ.", variant: "destructive" });
            return;
        }

        const newLockedDates = selectedDates.map(date => ({
            date: date.toISOString(),
            reason: lockReason
        }));

        const updatedLockedDates = [...lockedDates];
        newLockedDates.forEach(newLock => {
            if (!updatedLockedDates.some(existing => new Date(existing.date).toDateString() === new Date(newLock.date).toDateString())) {
                updatedLockedDates.push(newLock);
            }
        });
        
        setLockedDates(updatedLockedDates);
        setSelectedDates([]);
        setLockReason('');
        handleFeatureClick(`إغلاق ${selectedDates.length} يوم بسبب: ${lockReason}`);
    };

    const handleUnlockDate = (dateToUnlock) => {
        setLockedDates(lockedDates.filter(d => d.date !== dateToUnlock));
        handleFeatureClick(`فتح تاريخ: ${format(new Date(dateToUnlock), 'PPP', { locale: ar })}`);
    };

    const disabledDays = lockedDates.map(d => new Date(d.date));

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">إغلاق تاريخ/فترة زمنية</h2>
            <div className="grid lg:grid-cols-3 gap-8">
                <div className="lg:col-span-1 space-y-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>إغلاق تواريخ جديدة</CardTitle>
                            <CardDescription>حدد التواريخ التي ترغب بإغلاقها ومنع الحجز فيها.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <Calendar
                                mode="multiple"
                                selected={selectedDates}
                                onSelect={setSelectedDates}
                                disabled={disabledDays}
                                locale={ar}
                            />
                            <div>
                                <Label htmlFor="lockReason">سبب الإغلاق</Label>
                                <Input id="lockReason" value={lockReason} onChange={(e) => setLockReason(e.target.value)} placeholder="مثال: صيانة، إجازة سنوية" />
                            </div>
                            <Button className="w-full gradient-bg text-white" onClick={handleLockDates}>
                                <Lock className="w-4 h-4 ml-2"/> إغلاق التواريخ المحددة
                            </Button>
                        </CardContent>
                    </Card>
                </div>
                <div className="lg:col-span-2">
                    <Card>
                        <CardHeader>
                            <CardTitle>التواريخ المغلقة حالياً ({lockedDates.length})</CardTitle>
                            <CardDescription>قائمة بالتواريخ التي تم إغلاقها ولن تكون متاحة للحجز.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            {lockedDates.length > 0 ? (
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>التاريخ</TableHead>
                                            <TableHead>السبب</TableHead>
                                            <TableHead>إجراء</TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {lockedDates.map((lock) => (
                                            <TableRow key={lock.date}>
                                                <TableCell>{format(new Date(lock.date), 'PPP', { locale: ar })}</TableCell>
                                                <TableCell>{lock.reason}</TableCell>
                                                <TableCell>
                                                    <Button variant="ghost" size="icon" onClick={() => handleUnlockDate(lock.date)}>
                                                        <Trash2 className="w-4 h-4 text-red-500" />
                                                    </Button>
                                                </TableCell>
                                            </TableRow>
                                        ))}
                                    </TableBody>
                                </Table>
                            ) : (
                                <div className="text-center py-12 text-slate-500">
                                    <XCircle className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                                    <p className="text-xl font-semibold">لا توجد تواريخ مغلقة.</p>
                                    <p>يمكنك تحديد التواريخ من التقويم لإغلاقها.</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    );
});

export default DateLockingContent;