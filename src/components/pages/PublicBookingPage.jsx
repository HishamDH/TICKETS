import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle, CardDescription, CardFooter } from '@/components/ui/card';
import { Calendar } from '@/components/ui/calendar';
import { useToast } from '@/components/ui/use-toast';
import { format, parseISO, startOfDay } from 'date-fns';
import { ar } from 'date-fns/locale';
import { ChevronRight, ArrowLeft, Calendar as CalendarIcon, Tag, Users, Package, ShoppingCart } from 'lucide-react';

const PublicBookingPage = ({ context, handleNavigation }) => {
    const { toast } = useToast();
    const { merchantName } = context || { merchantName: 'مزود الخدمة' };
    
    const [dailyConfigs, setDailyConfigs] = useState({});
    const [packagesByDate, setPackagesByDate] = useState({});
    const [selectedDate, setSelectedDate] = useState(null);
    const [selectedPackage, setSelectedPackage] = useState(null);
    
    useEffect(() => {
        const configs = JSON.parse(localStorage.getItem('lilium_night_daily_configs_v3')) || {};
        const packages = JSON.parse(localStorage.getItem('lilium_night_packages_by_date_v3')) || {};
        setDailyConfigs(configs);
        setPackagesByDate(packages);
    }, []);

    const availablePackagesForDate = selectedDate ? 
        (packagesByDate[format(selectedDate, 'yyyy-MM-dd')] || [])
        .filter(pkg => pkg.onlineBookingEnabled && dailyConfigs[format(selectedDate, 'yyyy-MM-dd')]?.onlineSaleActive) 
        : [];
        
    const handleBookNow = (pkg) => {
        toast({
            title: `تم اختيار باقة "${pkg.name}"`,
            description: "سيتم نقلك قريباً إلى صفحة الدفع لإتمام الحجز.",
        });
    };

    const getDayModifiers = () => {
        const modifiers = {};
        Object.keys(dailyConfigs).forEach(dateStr => {
            const config = dailyConfigs[dateStr];
            if (config.onlineSaleActive) {
                const dateObj = parseISO(dateStr);
                if (!isNaN(dateObj.valueOf())) {
                    modifiers[dateStr] = { className: 'bg-primary/10 text-primary rounded-md font-bold' };
                }
            }
        });
        if (selectedDate) {
            const selectedDateStr = format(selectedDate, 'yyyy-MM-dd');
            modifiers[selectedDateStr] = { 
                ...modifiers[selectedDateStr], 
                className: `${modifiers[selectedDateStr]?.className || ''} ring-2 ring-primary ring-offset-2 bg-primary text-primary-foreground`.trim()
            };
        }
        return modifiers;
    };
    
    return (
        <div className="min-h-screen bg-slate-50 font-cairo" dir="rtl">
            <header className="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 className="text-xl md:text-2xl font-bold text-slate-800">
                    صفحة الحجز لدى <span className="text-primary">{merchantName}</span>
                </h1>
                <Button variant="outline" onClick={() => handleNavigation('home')}>
                    <ArrowLeft className="w-4 h-4 ml-2" /> العودة للرئيسية
                </Button>
            </header>

            <main className="container mx-auto p-4 md:p-8">
                <motion.div 
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.5 }}
                    className="grid lg:grid-cols-3 gap-8"
                >
                    <div className="lg:col-span-1">
                        <Card className="shadow-lg sticky top-24">
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2"><CalendarIcon /> اختر تاريخ المناسبة</CardTitle>
                                <CardDescription>الأيام المظللة باللون الأزرق متاحة للحجز أونلاين.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <Calendar
                                    mode="single"
                                    selected={selectedDate}
                                    onSelect={setSelectedDate}
                                    className="rounded-md border p-4 bg-white w-full"
                                    locale={ar}
                                    modifiers={getDayModifiers()}
                                    modifiersClassNames={{
                                        selected: 'bg-primary text-primary-foreground hover:bg-primary/90 focus:bg-primary/90',
                                    }}
                                    disabled={(date) => {
                                        const dateStr = format(date, 'yyyy-MM-dd');
                                        return date < startOfDay(new Date()) || !dailyConfigs[dateStr]?.onlineSaleActive;
                                    }}
                                />
                            </CardContent>
                        </Card>
                    </div>

                    <div className="lg:col-span-2">
                        {selectedDate ? (
                            <div className="space-y-6">
                                <h2 className="text-2xl font-bold text-slate-800">
                                    الباقات المتاحة ليوم: <span className="text-primary">{format(selectedDate, 'PPP', { locale: ar })}</span>
                                </h2>
                                {availablePackagesForDate.length > 0 ? availablePackagesForDate.map(pkg => (
                                    <motion.div key={pkg.id} layout initial={{ opacity: 0, scale: 0.9 }} animate={{ opacity: 1, scale: 1 }}>
                                        <Card className={`shadow-lg transition-all duration-300 ${selectedPackage?.id === pkg.id ? 'ring-2 ring-primary' : 'hover:shadow-xl'}`}>
                                            <CardHeader>
                                                <div className="flex justify-between items-start">
                                                    <div>
                                                        <CardTitle className="text-xl flex items-center gap-2"><Package/> {pkg.name}</CardTitle>
                                                        <CardDescription className="mt-1">{pkg.features}</CardDescription>
                                                    </div>
                                                     <div className="text-2xl font-bold text-primary whitespace-nowrap">
                                                        {parseFloat(pkg.price).toLocaleString('ar-SA')} <span className="text-sm">ريال</span>
                                                    </div>
                                                </div>
                                            </CardHeader>
                                            <CardFooter className="flex justify-between items-center bg-slate-50 p-4">
                                                <div className="flex items-center gap-4 text-sm text-slate-600">
                                                    <div className="flex items-center gap-1"><Users className="w-4 h-4"/>{pkg.availableSlots} حجوزات متاحة</div>
                                                </div>
                                                <Button size="lg" onClick={() => handleBookNow(pkg)}>
                                                    <ShoppingCart className="w-5 h-5 ml-2"/> احجز الآن
                                                </Button>
                                            </CardFooter>
                                        </Card>
                                    </motion.div>
                                )) : (
                                     <Card className="text-center py-12">
                                        <CardContent>
                                            <Package className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                                            <h3 className="text-xl font-semibold">لا توجد باقات متاحة</h3>
                                            <p className="text-slate-500">لا توجد باقات مفعلة للبيع أونلاين في هذا اليوم. الرجاء اختيار يوم آخر.</p>
                                        </CardContent>
                                    </Card>
                                )}
                            </div>
                        ) : (
                            <Card className="text-center py-20 flex flex-col items-center justify-center h-full">
                                <CardContent>
                                    <CalendarIcon className="w-24 h-24 mx-auto text-slate-300 mb-6" />
                                    <h3 className="text-2xl font-bold text-slate-700">ابدأ رحلة الحجز</h3>
                                    <p className="text-slate-500 mt-2 text-lg">الرجاء اختيار يوم من التقويم على اليمين لعرض الباقات المتاحة.</p>
                                </CardContent>
                            </Card>
                        )}
                    </div>
                </motion.div>
            </main>
        </div>
    );
};

export default PublicBookingPage;