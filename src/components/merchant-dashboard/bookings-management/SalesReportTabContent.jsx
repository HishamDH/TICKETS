import React, { memo } from 'react';
import { motion } from 'framer-motion';
import SalesReport from '@/components/merchant-dashboard/SalesReport';
import { useToast } from "@/components/ui/use-toast";

const SalesReportTabContent = memo(({ bookings, handleFeatureClick: propHandleFeatureClick }) => {
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
        >
            <SalesReport bookings={bookings} handleFeatureClick={handleFeatureClick} />
        </motion.div>
    );
});

export default SalesReportTabContent;