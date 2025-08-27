import React, { useState, useMemo, useEffect, memo } from 'react';
import { motion } from 'framer-motion';
import { ClipboardList, Settings2, Package as PackageIcon, BarChartHorizontalBig } from 'lucide-react';
import { Tabs, TabsList, TabsTrigger, TabsContent } from "@/components/ui/tabs";
import { Sheet, SheetContent, SheetHeader, SheetTitle } from "@/components/ui/sheet";
import { useToast } from "@/components/ui/use-toast";

import BookingDetails from '@/components/merchant-dashboard/BookingDetails';
import TermsAndConditionsModal from '@/components/merchant-dashboard/TermsAndConditionsModal';

import BookingsListTabContent from '@/components/merchant-dashboard/bookings-management/BookingsListTabContent';
import CalendarSettingsTabContent from '@/components/merchant-dashboard/bookings-management/CalendarSettingsTabContent';
import PackagesManagementTabContent from '@/components/merchant-dashboard/bookings-management/PackagesManagementTabContent';
import SalesReportTabContent from '@/components/merchant-dashboard/bookings-management/SalesReportTabContent';

import { format, parseISO } from "date-fns";
import { ar } from "date-fns/locale";


const sampleBookingsData = [
    { id: 'BK-8462', customer: 'أحمد الغامدي', email: 'ahmed@example.com', avatar: '-', event: 'الباقة الذهبية', serviceType: 'قاعة الأفراح الملكية', status: 'paid', date: '2025-06-20', amount: 10000.00, type: 'venue', online: true, packageStatus: 'منشور' },
    { id: 'BK-7654', customer: 'فاطمة الزهراني', email: 'fatima@example.com', avatar: '-', event: 'الباقة الفضية', serviceType: 'قاعة الأفراح الملكية', status: 'awaiting_confirmation', date: '2025-06-21', amount: 7500.00, type: 'venue', online: false, packageStatus: 'داخلي فقط' },
    { id: 'BK-6831', customer: 'خالد المصري', email: 'khaled@example.com', avatar: '-', event: 'تصوير زفاف كامل', serviceType: 'استوديو الإبداع للتصوير', status: 'used', date: '2025-06-10', amount: 4500.00, type: 'photography', online: true, packageStatus: 'منشور' },
];

const bookingCategories = {
    all: { title: 'كل الحجوزات' },
    active: { title: 'النشطة', statuses: ['paid', 'approved', 'awaiting_confirmation'] },
    cancelled: { title: 'الملغاة', statuses: ['cancelled_by_user', 'cancelled_by_merchant', 'refunded_full'] },
    finished: { title: 'المنتهية', statuses: ['expired', 'no_show', 'used'] },
};


const BookingsManagementContent = memo(({ handleNavigation, handleFeatureClick }) => {
    const { toast } = useToast();
    
    const internalHandleFeatureClick = (featureName) => {
        if (handleFeatureClick && typeof handleFeatureClick === 'function') {
            handleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
                variant: "default",
            });
        }
    };

    const [activeManagementTab, setActiveManagementTab] = useState('bookings_list');
    const [activeBookingsTab, setActiveBookingsTab] = useState('all');
    const [selectedBooking, setSelectedBooking] = useState(null);
    
    const [dailyConfigs, setDailyConfigs] = useState(JSON.parse(localStorage.getItem('lilium_night_daily_configs_v4')) || {});
    const [packagesByDate, setPackagesByDate] = useState(JSON.parse(localStorage.getItem('lilium_night_packages_by_date_v4')) || {});
    
    const [showAddOrEditPackageModalFor, setShowAddOrEditPackageModalFor] = useState(null); 
    const [termsAgreed, setTermsAgreed] = useState(localStorage.getItem('lilium_night_terms_agreed_v1') === 'true');
    const [isTermsModalOpen, setIsTermsModalOpen] = useState(false);
    const [pendingActionData, setPendingActionData] = useState(null); 

    useEffect(() => {
        localStorage.setItem('lilium_night_daily_configs_v4', JSON.stringify(dailyConfigs));
    }, [dailyConfigs]);

    useEffect(() => {
        localStorage.setItem('lilium_night_packages_by_date_v4', JSON.stringify(packagesByDate));
    }, [packagesByDate]);

    const handleDayConfigUpdate = (dateString, newDayConfig) => {
        setDailyConfigs(prevConfigs => ({
            ...prevConfigs,
            [dateString]: newDayConfig
        }));
        internalHandleFeatureClick(`تحديث إعدادات يوم ${format(parseISO(dateString), 'PPP', {locale: ar})}`);
    };

    const handlePackageAdd = (dateString, newPackage) => {
        setPackagesByDate(prevPackages => ({
            ...prevPackages,
            [dateString]: [...(prevPackages[dateString] || []), newPackage]
        }));
        internalHandleFeatureClick(`إضافة باقة "${newPackage.name}" ليوم ${format(parseISO(dateString), 'PPP', {locale: ar})}`);
    };
    
    const handlePackageUpdate = (dateString, packageId, updatedPackage) => {
        setPackagesByDate(prevPackages => ({
            ...prevPackages,
            [dateString]: (prevPackages[dateString] || []).map(pkg => pkg.id === packageId ? updatedPackage : pkg)
        }));
        internalHandleFeatureClick(`تحديث باقة "${updatedPackage.name}" ليوم ${format(parseISO(dateString), 'PPP', {locale: ar})}`);
    };

    const handlePackageDelete = (dateString, packageId) => {
        const pkgToDelete = packagesByDate[dateString]?.find(p => p.id === packageId);
        setPackagesByDate(prevPackages => ({
            ...prevPackages,
            [dateString]: (prevPackages[dateString] || []).filter(pkg => pkg.id !== packageId)
        }));
        toast({title: "تم الحذف", description: `تم حذف الباقة "${pkgToDelete?.name || 'المحددة'}" بنجاح.`, variant: "destructive"});
        internalHandleFeatureClick(`حذف باقة "${pkgToDelete?.name || 'المحددة'}" من يوم ${format(parseISO(dateString), 'PPP', {locale: ar})}`);
    };

    const handleOpenPackageModal = (data) => { 
        setShowAddOrEditPackageModalFor(data);
        internalHandleFeatureClick(`فتح نافذة إضافة/تعديل باقة لـ ${typeof data === 'string' ? format(parseISO(data), 'PPP', {locale: ar}) : format(parseISO(data.date), 'PPP', {locale: ar})}`);
    };
    
    const executeToggleDateOnlineSale = (dateString, activate) => {
        const currentConfig = dailyConfigs[dateString] || {};
        const newConfig = {
            ...currentConfig,
            status: currentConfig.status || 'available', 
            onlineSaleActive: activate,
        };

        setDailyConfigs(prev => ({ ...prev, [dateString]: newConfig }));

        if (!activate) { 
            setPackagesByDate(prevPkgs => {
                const dayPackages = (prevPkgs[dateString] || []).map(p => ({...p, onlineBookingEnabled: false, status: 'داخلي فقط'}));
                return {...prevPkgs, [dateString]: dayPackages};
            });
        }
        toast({title: `تم ${activate ? 'تفعيل' : 'إلغاء تفعيل'} البيع أونلاين ليوم ${format(parseISO(dateString), 'PPP', {locale: ar})}`});
        internalHandleFeatureClick(`${activate ? 'تفعيل' : 'إلغاء تفعيل'} البيع أونلاين ليوم ${format(parseISO(dateString), 'PPP', {locale: ar})}`);
    };

    const handleToggleDateOnlineSale = (dateString, activate, callback) => {
        if (activate && !termsAgreed) {
            setPendingActionData({ type: 'dateToggle', dateString, activate, callback });
            setIsTermsModalOpen(true);
            internalHandleFeatureClick(`محاولة تفعيل البيع أونلاين ليوم ${format(parseISO(dateString), 'PPP', {locale: ar})} (يتطلب موافقة الشروط)`);
            return;
        }
        executeToggleDateOnlineSale(dateString, activate);
        if(callback) callback(true);
    };
    
    const executeTogglePackageOnlineSale = (dateString, packageId, activate) => {
        const dayConfig = dailyConfigs[dateString];
        if (activate && (!dayConfig || !dayConfig.onlineSaleActive)) {
             toast({ title: "تنبيه", description: "يجب تفعيل البيع أونلاين لليوم بأكمله أولاً من إعدادات التقويم.", variant: "warning"});
             return;
        }

         setPackagesByDate(prevPackages => {
            const dayPackages = prevPackages[dateString] || [];
            const updatedPackages = dayPackages.map(pkg => {
                if (pkg.id === packageId) {
                    return { ...pkg, onlineBookingEnabled: activate, status: activate ? 'منشور' : 'داخلي فقط' };
                }
                return pkg;
            });
            return { ...prevPackages, [dateString]: updatedPackages };
        });
        const pkgToggled = packagesByDate[dateString]?.find(p => p.id === packageId);
        toast({title: `تم ${activate ? 'تفعيل' : 'إلغاء تفعيل'} البيع أونلاين للباقة "${pkgToggled?.name || 'المحددة'}".`});
        internalHandleFeatureClick(`${activate ? 'تفعيل' : 'إلغاء تفعيل'} البيع أونلاين للباقة "${pkgToggled?.name || 'المحددة'}"`);
    };

    const handleTogglePackageOnlineSale = (dateString, packageId, activate) => {
         if (activate && !termsAgreed) {
            setPendingActionData({ type: 'packageToggle', dateString, packageId, activate });
            setIsTermsModalOpen(true);
            const pkgToggled = packagesByDate[dateString]?.find(p => p.id === packageId);
            internalHandleFeatureClick(`محاولة تفعيل البيع أونلاين للباقة "${pkgToggled?.name || 'المحددة'}" (يتطلب موافقة الشروط)`);
            return;
        }
        executeTogglePackageOnlineSale(dateString, packageId, activate);
    };

    const handleAcceptTerms = () => {
        setTermsAgreed(true);
        localStorage.setItem('lilium_night_terms_agreed_v1', 'true');
        setIsTermsModalOpen(false);
        toast({title: "تمت الموافقة", description: "تمت الموافقة على شروط وأحكام البيع الإلكتروني."});
        if (pendingActionData) {
            if (pendingActionData.type === 'dateToggle') {
                executeToggleDateOnlineSale(pendingActionData.dateString, pendingActionData.activate);
                if(pendingActionData.callback) pendingActionData.callback(true);
            } else if (pendingActionData.type === 'packageToggle') {
                executeTogglePackageOnlineSale(pendingActionData.dateString, pendingActionData.packageId, pendingActionData.activate);
            }
            setPendingActionData(null);
        }
        internalHandleFeatureClick("الموافقة على الشروط والأحكام");
    };
    
    const allPackagesWithDate = useMemo(() => { 
        let packages = [];
        Object.entries(packagesByDate).forEach(([dateString, pkgsOnDate]) => {
          pkgsOnDate.forEach(pkg => {
            packages.push({ ...pkg, date: dateString, online: pkg.onlineBookingEnabled && dailyConfigs[dateString]?.onlineSaleActive, amount: parseFloat(pkg.price) || 0 });
          });
        });
        return packages;
    }, [packagesByDate, dailyConfigs]);

    const allConfiguredBookings = useMemo(() => {
        const bookingsFromPackages = [];
        const packageIds = new Set();

        Object.entries(packagesByDate).forEach(([dateString, pkgsOnDate]) => {
            const dayConfig = dailyConfigs[dateString];
            pkgsOnDate.forEach(pkg => {
                const packageBookingId = `PKG-${dateString}-${pkg.id.slice(-4)}`;
                packageIds.add(packageBookingId);
                const isPackageEffectivelyOnline = pkg.onlineBookingEnabled && dayConfig?.onlineSaleActive;
                bookingsFromPackages.push({
                    id: packageBookingId, 
                    customer: '-', 
                    email: '-',
                    avatar: '-',
                    event: pkg.name,
                    serviceType: 'باقة خاصة', 
                    status: isPackageEffectivelyOnline ? 'awaiting_confirmation' : 'pending', 
                    date: dateString,
                    amount: parseFloat(pkg.price) || 0,
                    type: 'venue', 
                    online: isPackageEffectivelyOnline,
                    packageStatus: isPackageEffectivelyOnline ? 'منشور' : 'داخلي فقط'
                });
            });
        });
        
        const uniqueSampleBookings = sampleBookingsData.filter(b => !packageIds.has(b.id));
        const combinedBookings = [...uniqueSampleBookings, ...bookingsFromPackages];
        localStorage.setItem('lilium_night_all_bookings_v1', JSON.stringify(combinedBookings));
        return combinedBookings;
    }, [packagesByDate, dailyConfigs]);


    const categoryCounts = useMemo(() => {
        const counts = { all: allConfiguredBookings.length };
        Object.entries(bookingCategories).forEach(([key, value]) => {
            if(key !== 'all') {
                counts[key] = allConfiguredBookings.filter(b => value.statuses.includes(b.status)).length;
            }
        });
        return counts;
    }, [allConfiguredBookings]);

    const handleBookPackage = (dateString, packageId) => {
        const pkg = packagesByDate[dateString]?.find(p => p.id === packageId);
        if (!pkg) return;

        // 1. Update the package status to 'booked'
        const updatedPackages = (packagesByDate[dateString] || []).map(p => 
            p.id === packageId ? { ...p, status: 'booked', bookingDetails: { customer: 'عميل محاكاة', bookedAt: new Date().toISOString() } } : p
        );
        setPackagesByDate(prev => ({ ...prev, [dateString]: updatedPackages }));

        // 2. Lock the day
        const currentConfig = dailyConfigs[dateString] || {};
        const newDayConfig = { 
            ...currentConfig, 
            status: 'locked', 
            isLocked: true, 
            lockReason: `محجوز بالكامل عبر باقة "${pkg.name}"` 
        };
        setDailyConfigs(prev => ({ ...prev, [dateString]: newDayConfig }));

        toast({
            title: "🎉 تم الحجز بنجاح!",
            description: `تم حجز باقة "${pkg.name}" وتم إغلاق يوم ${format(parseISO(dateString), 'PPP', {locale: ar})} بالكامل.`,
        });
        internalHandleFeatureClick(`محاكاة حجز باقة ${pkg.name}`);
    };


    return (
        <Sheet onOpenChange={(isOpen) => { if(!isOpen) setSelectedBooking(null); }}>
            <div className="space-y-6">
                <h2 className="text-3xl font-bold text-slate-800">إدارة حجوزات المناسبات والتوفر</h2>
                
                 <Tabs value={activeManagementTab} className="w-full" dir="rtl" onValueChange={(newTab) => { setActiveManagementTab(newTab); internalHandleFeatureClick(`تغيير التبويب إلى ${newTab}`);}}>
                    <TabsList className="grid w-full grid-cols-2 md:grid-cols-4 gap-2 h-auto p-2 bg-primary/5 rounded-xl mb-6">
                         <TabsTrigger value="bookings_list" className="text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg flex items-center gap-2">
                            <ClipboardList className="w-5 h-5"/> قائمة الحجوزات
                        </TabsTrigger>
                        <TabsTrigger value="calendar_settings" className="text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg flex items-center gap-2">
                           <Settings2 className="w-5 h-5"/> إعداد التقويم والباقات
                        </TabsTrigger>
                        <TabsTrigger value="packages_management_tab" className="text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg flex items-center gap-2">
                           <PackageIcon className="w-5 h-5"/> كل الباقات
                        </TabsTrigger>
                        <TabsTrigger value="sales_report" className="text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg flex items-center gap-2">
                           <BarChartHorizontalBig className="w-5 h-5"/> تقرير المبيعات
                        </TabsTrigger>
                    </TabsList>

                    <TabsContent value="bookings_list">
                        <BookingsListTabContent 
                            bookings={allConfiguredBookings}
                            onSelectBooking={setSelectedBooking}
                            onFeatureClick={internalHandleFeatureClick}
                            activeBookingsTab={activeBookingsTab}
                            onActiveBookingsTabChange={setActiveBookingsTab}
                            categoryCounts={categoryCounts}
                            bookingCategories={bookingCategories}
                        />
                    </TabsContent>
                    <TabsContent value="calendar_settings">
                         <CalendarSettingsTabContent
                            dailyConfigs={dailyConfigs}
                            onDayConfigUpdate={handleDayConfigUpdate} 
                            onAddPackageToDate={handleOpenPackageModal} 
                            onToggleDateOnlineSale={handleToggleDateOnlineSale}
                            packagesByDate={packagesByDate}
                            onPackageAdd={handlePackageAdd}
                            onPackageUpdate={handlePackageUpdate}
                            onPackageDelete={handlePackageDelete}
                            showModalForDate={showAddOrEditPackageModalFor} 
                            onCloseModal={() => setShowAddOrEditPackageModalFor(null)} 
                            onTogglePackageOnlineSale={handleTogglePackageOnlineSale}
                            handleFeatureClick={internalHandleFeatureClick}
                         />
                    </TabsContent>
                     <TabsContent value="packages_management_tab">
                        <PackagesManagementTabContent
                            packagesByDate={packagesByDate}
                            dailyConfigs={dailyConfigs}
                            onPackageUpdate={handlePackageUpdate}
                            onPackageDelete={handlePackageDelete}
                            onTogglePackageOnlineSale={handleTogglePackageOnlineSale}
                            onEditPackageRequest={handleOpenPackageModal} 
                            handleFeatureClick={internalHandleFeatureClick}
                            onBookPackage={handleBookPackage}
                        />
                    </TabsContent>
                     <TabsContent value="sales_report">
                        <SalesReportTabContent bookings={allPackagesWithDate} handleFeatureClick={internalHandleFeatureClick} />
                    </TabsContent>
                </Tabs>
            </div>
            <SheetContent className="w-[400px] sm:w-[440px] p-0 flex flex-col" side="left">
                <SheetHeader className="p-6 border-b"><SheetTitle>تفاصيل الحجز/الباقة</SheetTitle></SheetHeader>
                <BookingDetails booking={selectedBooking} handleFeatureClick={internalHandleFeatureClick} />
            </SheetContent>
            <TermsAndConditionsModal 
                isOpen={isTermsModalOpen} 
                onClose={() => { setIsTermsModalOpen(false); setPendingActionData(null); internalHandleFeatureClick("إغلاق نافذة الشروط والأحكام");}}
                onAccept={handleAcceptTerms}
            />
        </Sheet>
    );
});

export default BookingsManagementContent;