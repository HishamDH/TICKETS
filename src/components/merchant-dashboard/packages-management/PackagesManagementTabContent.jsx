import React, { memo, useState, useMemo } from 'react';
import { motion } from 'framer-motion';
import MerchantPackages from '@/components/merchant-dashboard/packages-management/MerchantPackages';
import { useToast } from "@/components/ui/use-toast";
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Upload } from 'lucide-react';

const PackagesManagementTabContent = memo(({
    packagesByDate,
    dailyConfigs,
    onPackageUpdate,
    onPackageDelete,
    onTogglePackageOnlineSale,
    onEditPackageRequest,
    onBookPackage,
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
           <MerchantPackages
                packagesByDate={packagesByDate}
                dailyConfigs={dailyConfigs}
                onPackageUpdate={onPackageUpdate}
                onPackageDelete={onPackageDelete}
                onTogglePackageOnlineSale={onTogglePackageOnlineSale}
                onEditPackageRequest={onEditPackageRequest} 
                onBookPackage={onBookPackage}
                handleFeatureClick={handleFeatureClick}
           />
           <Card className="mt-6 border-dashed border-primary">
                <CardHeader>
                    <CardTitle>عمليات مجمّعة (قريباً)</CardTitle>
                    <CardDescription>
                        لتسريع العمل، قريباً ستتمكن من استيراد جدول الباقات والأيام من ملف Excel.
                    </CardDescription>
                </CardHeader>
                <CardContent className="flex items-center gap-4">
                    <Button variant="outline" onClick={() => handleFeatureClick("محاولة استيراد من Excel")}>
                        <Upload className="w-4 h-4 ml-2"/>
                        استيراد من Excel
                    </Button>
                    <p className="text-sm text-slate-500">
                        هذه الميزة تحت التطوير حالياً. يمكنك طلبها لتسريع العمل عليها!
                    </p>
                </CardContent>
           </Card>
        </motion.div>
    );
});

export default PackagesManagementTabContent;