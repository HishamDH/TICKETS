import React, { useState, useMemo, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Users, Store, ShieldCheck, HeartHandshake as Handshake } from 'lucide-react';
import CustomerDashboard from '@/components/pages/CustomerDashboard';
import MerchantDashboard from '@/components/pages/MerchantDashboard';
import AdminDashboard from '@/components/pages/AdminDashboard';
import PartnerDashboard from '@/components/pages/PartnerDashboard';

const UnifiedView = ({ handleNavigation }) => {
    const [activeTab, setActiveTab] = useState('merchant');

    const handleTabChange = useCallback((value) => {
        setActiveTab(value);
    }, []);

    const dashboards = useMemo(() => ({
        customer: <CustomerDashboard handleNavigation={handleNavigation} />,
        merchant: <MerchantDashboard handleNavigation={handleNavigation} />,
        partner: <PartnerDashboard handleNavigation={handleNavigation} />,
        admin: <AdminDashboard handleNavigation={handleNavigation} />,
    }), [handleNavigation]);

    return (
        <div className="min-h-screen bg-slate-50 py-12 px-4 md:px-8">
            <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6 }}
                className="text-center mb-8"
            >
                <h1 className="text-4xl md:text-5xl font-extrabold gradient-text mb-4">لوحات التحكم الموحدة</h1>
                <p className="text-lg text-slate-600 max-w-3xl mx-auto">
                    تجربة شاملة لكل الأدوار في المنصة. تنقل بين لوحات تحكم العميل، مزود الخدمة، الشريك، والإدارة بسهولة.
                </p>
            </motion.div>

            <Tabs value={activeTab} onValueChange={handleTabChange} className="w-full" dir="rtl">
                <TabsList className="grid w-full grid-cols-2 md:grid-cols-4 gap-2 h-auto p-2 bg-primary/10 rounded-xl mb-6 max-w-4xl mx-auto">
                    <TabsTrigger value="customer" className="flex items-center justify-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg"><Users className="h-5 w-5"/>لوحة العميل</TabsTrigger>
                    <TabsTrigger value="merchant" className="flex items-center justify-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg"><Store className="h-5 w-5"/>لوحة مزود الخدمة</TabsTrigger>
                    <TabsTrigger value="partner" className="flex items-center justify-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg"><Handshake className="h-5 w-5"/>لوحة الشريك</TabsTrigger>
                    <TabsTrigger value="admin" className="flex items-center justify-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg"><ShieldCheck className="h-5 w-5"/>لوحة الإدارة</TabsTrigger>
                </TabsList>
                
                <motion.div 
                    initial={{ opacity: 0 }} 
                    animate={{ opacity: 1 }} 
                    transition={{ duration: 0.5 }}
                    className="mt-4"
                >
                    <div className="rounded-2xl overflow-hidden border border-slate-200/80 shadow-2xl bg-white">
                        <AnimatePresence mode="wait">
                            <motion.div
                                key={activeTab}
                                initial={{ opacity: 0, x: 50 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -50 }}
                                transition={{ duration: 0.3 }}
                            >
                                {dashboards[activeTab]}
                            </motion.div>
                        </AnimatePresence>
                    </div>
                </motion.div>
            </Tabs>
        </div>
    );
};

export default React.memo(UnifiedView);