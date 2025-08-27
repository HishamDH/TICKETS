import React, { useState, useEffect, useMemo, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Menu, X, UserCircle, LogOut, LayoutDashboard, Users, Banknote, MessageCircle, Settings, Share2, BarChart3 } from 'lucide-react';
import PartnerSidebar from '@/components/partner-dashboard/PartnerSidebar';
import Overview from '@/components/partner-dashboard/Overview';
import MyReferrals from '@/components/partner-dashboard/MyReferrals';
import Payouts from '@/components/partner-dashboard/Payouts';
import PromoTools from '@/components/partner-dashboard/PromoTools';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Button } from '@/components/ui/button';
import { useToast } from "@/components/ui/use-toast";

const PartnerDashboard = ({ handleNavigation }) => {
    const [activeSection, setActiveSection] = useState('partner_overview');
    const [isSidebarOpen, setSidebarOpen] = useState(window.innerWidth >= 768);
    const { toast } = useToast();

    const handleFeatureClick = useCallback((featureName, source = "غير محدد") => {
        toast({
            title: "تم بنجاح",
            description: `تم تنفيذ الإجراء: ${featureName} من ${source}.`,
        });
    }, [toast]);

    useEffect(() => {
        const handleResize = () => {
            if (window.innerWidth < 768) {
                setSidebarOpen(false);
            } else {
                setSidebarOpen(true);
            }
        };
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    const sections = useMemo(() => [
        { id: 'partner_overview', title: 'لوحة التحكم الرئيسية', icon: LayoutDashboard, component: Overview },
        { id: 'referrals', title: 'إحالاتي والتجار', icon: Users, component: MyReferrals },
        { id: 'payouts', title: 'المدفوعات والعمولات', icon: Banknote, component: Payouts },
        { id: 'promo_tools', title: 'الأدوات الترويجية', icon: Share2, component: PromoTools },
        { id: 'partner_reports', title: 'التقارير والإحصائيات', icon: BarChart3, component: Payouts },
        { id: 'partner_support', title: 'الدعم الفني للشركاء', icon: MessageCircle, component: PromoTools },
        { id: 'partner_settings', title: 'إعدادات الحساب', icon: Settings, component: MyReferrals },
    ], []);
    
    const currentActiveSectionItem = useMemo(() => sections.find(s => s.id === activeSection), [sections, activeSection]);
    const ActiveComponent = useMemo(() => currentActiveSectionItem?.component, [currentActiveSectionItem]);

    return (
        <div className="flex h-screen bg-slate-100" dir="rtl">
            <PartnerSidebar 
                sections={sections} 
                activeSection={activeSection} 
                setActiveSection={setActiveSection} 
                isSidebarOpen={isSidebarOpen}
                setSidebarOpen={setSidebarOpen}
            />
            <div className={`flex-1 flex flex-col transition-all duration-300 ${isSidebarOpen ? 'mr-0 md:mr-64' : 'mr-0'}`}>
                <header className="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                    <Button variant="ghost" onClick={() => setSidebarOpen(!isSidebarOpen)} className="text-slate-600">
                        {isSidebarOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
                    </Button>
                    <div className="flex items-center gap-4">
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Avatar className="cursor-pointer h-9 w-9">
                                    <AvatarImage src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200" alt="Partner" />
                                    <AvatarFallback>ش</AvatarFallback>
                                </Avatar>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuLabel>حساب الشريك</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem onClick={() => { setActiveSection('partner_settings'); handleFeatureClick('الانتقال لملف الشريك', 'قائمة الشريك'); }}>الملف الشخصي</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => { handleNavigation('home'); handleFeatureClick('تسجيل الخروج من لوحة الشريك', 'قائمة الشريك'); }}>
                                  <LogOut className="w-4 h-4 ml-2 text-red-500" />
                                  تسجيل الخروج
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </header>
                <main className="flex-1 overflow-y-auto p-6 lg:p-8">
                    <AnimatePresence mode="wait">
                        <motion.div
                            key={activeSection}
                            initial={{ opacity: 0, y: 20 }}
                            animate={{ opacity: 1, y: 0 }}
                            exit={{ opacity: 0, y: -20 }}
                            transition={{ duration: 0.2 }}
                        >
                           {ActiveComponent && <ActiveComponent 
                                handleNavigation={handleNavigation} 
                                handleFeatureClick={(featureName) => handleFeatureClick(featureName, currentActiveSectionItem?.title || activeSection)} 
                           />}
                        </motion.div>
                    </AnimatePresence>
                </main>
            </div>
        </div>
    );
};

export default React.memo(PartnerDashboard);