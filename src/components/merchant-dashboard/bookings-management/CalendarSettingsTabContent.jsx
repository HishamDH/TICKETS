import React, { memo } from 'react';
import { motion } from 'framer-motion';
import BookingControlCalendar from '@/components/merchant-dashboard/BookingControlCalendar';
import DailyPackageManagement from '@/components/merchant-dashboard/DailyPackageManagement';
import { useToast } from "@/components/ui/use-toast";

const CalendarSettingsTabContent = memo(({
    dailyConfigs,
    onDayConfigUpdate,
    onAddPackageToDate,
    onToggleDateOnlineSale,
    packagesByDate,
    onPackageAdd,
    onPackageUpdate,
    onPackageDelete,
    showModalForDate,
    onCloseModal,
    onTogglePackageOnlineSale,
    handleFeatureClick: propHandleFeatureClick
}) => {
    const { toast } = useToast();

    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick) {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    return (
        <motion.div
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
            className="space-y-6"
        >
            <BookingControlCalendar 
                dailyConfigs={dailyConfigs}
                onDayConfigUpdate={onDayConfigUpdate} 
                onAddPackageToDate={onAddPackageToDate}
                onToggleDateOnlineSale={onToggleDateOnlineSale}
                handleFeatureClick={handleFeatureClick}
            />
            <DailyPackageManagement 
                availableDatesAndConfigs={dailyConfigs} 
                packagesByDate={packagesByDate}
                onPackageAdd={onPackageAdd}
                onPackageUpdate={onPackageUpdate}
                onPackageDelete={onPackageDelete}
                showModalForDate={showModalForDate}
                onCloseModal={onCloseModal}
                onTogglePackageOnlineSale={onTogglePackageOnlineSale}
                handleFeatureClick={handleFeatureClick}
            />
        </motion.div>
    );
});

export default CalendarSettingsTabContent;