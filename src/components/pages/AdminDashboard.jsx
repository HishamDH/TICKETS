import React, { useState, useEffect, useMemo, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Menu, X, UserCircle, Settings as AdminSettings, LogOut, LayoutDashboard, Users, Briefcase, Banknote, FileText, Headphones as Headset, BarChart3, Globe, ShieldCheck, Bot, PackageSearch, CheckSquare, Eye, FileSignature, Zap } from 'lucide-react';
import AdminSidebar from '@/components/admin-dashboard/AdminSidebar';
import AdminOverview from '@/components/admin-dashboard/overview/AdminOverview';
import MerchantsControl from '@/components/admin-dashboard/merchants/MerchantsControl';
import PayoutsManagement from '@/components/admin-dashboard/payouts/PayoutsManagement';
import ReportsAnalytics from '@/components/admin-dashboard/reports/ReportsAnalytics';
import SupportSystem from '@/components/admin-dashboard/support/SupportSystem';
import PlatformSettings from '@/components/admin-dashboard/settings/PlatformSettings';
import StaffManagement from '@/components/admin-dashboard/staff/StaffManagement';
import DomainManagement from '@/components/admin-dashboard/domains/DomainManagement';
import SecurityMonitoring from '@/components/admin-dashboard/security/SecurityMonitoring';
import AiSupervision from '@/components/admin-dashboard/ai/AiSupervision';
import ContentManagement from '@/components/admin-dashboard/content/ContentManagement';
import FinanceSystem from '@/components/admin-dashboard/finance/FinanceSystem';
import Integrations from '@/components/admin-dashboard/integrations/Integrations';
import ReviewTools from '@/components/admin-dashboard/tools/ReviewTools';
import AdminBookingsManagement from '@/components/admin-dashboard/bookings/AdminBookingsManagement';

import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Button } from '@/components/ui/button';
import { useToast } from "@/components/ui/use-toast";

const AdminDashboard = ({ handleNavigation }) => {
    const [activeSection, setActiveSection] = useState('overview');
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
        { id: 'main_analytics_title', title: 'الرئيسية والتحليلات', isTitle: true },
        { id: 'overview', title: 'لوحة التحكم الرئيسية', icon: LayoutDashboard, component: AdminOverview },
        { id: 'reports_analytics', title: 'التقارير والتحليلات', icon: BarChart3, component: ReportsAnalytics },
        { id: 'ai_automation', title: 'الرقابة الذكية والأتمتة', icon: Bot, component: AiSupervision },

        { id: 'management_operations_title', title: 'الإدارة والعمليات', isTitle: true },
        { id: 'approval_management', title: 'إدارة التجار والموافقة', icon: Users, component: MerchantsControl },
        { id: 'operations_management', title: 'إدارة الحجوزات والعمليات', icon: Briefcase, component: AdminBookingsManagement },
        { id: 'financial_management', title: 'النظام المالي', icon: Banknote, component: FinanceSystem },
        { id: 'payouts_settlements', title: 'إدارة المدفوعات والتسويات', icon: Banknote, component: PayoutsManagement },
        { id: 'dispute_management', title: 'إدارة النزاعات والدعم', icon: Headset, component: SupportSystem },
        
        { id: 'content_platform_title', title: 'المحتوى والمنصة', isTitle: true },
        { id: 'content_platform_management', title: 'إدارة المحتوى والخدمات', icon: FileText, component: ContentManagement },
        { id: 'review_evaluation_tools', title: 'أدوات المراجعة والتقييم', icon: PackageSearch, component: ReviewTools },
        { id: 'domain_dns_management', title: 'إدارة النطاقات و DNS', icon: Globe, component: DomainManagement },
        { id: 'integrations_api', title: 'التكاملات و API', icon: Zap, component: Integrations },

        { id: 'system_security_title', title: 'النظام والأمان', isTitle: true },
        { id: 'staff_access_management', title: 'إدارة الموظفين والصلاحيات', icon: Users, component: StaffManagement },
        { id: 'security_audit', title: 'الأمان والتدقيق', icon: ShieldCheck, component: SecurityMonitoring },
        { id: 'system_configuration', title: 'إعدادات النظام المتقدمة', icon: AdminSettings, component: PlatformSettings },
    ], []);

    const currentActiveSectionItem = useMemo(() => sections.find(s => s.id === activeSection), [sections, activeSection]);
    const ActiveComponent = useMemo(() => currentActiveSectionItem?.component, [currentActiveSectionItem]);

    return (
        <div className="flex h-screen bg-slate-100" dir="rtl">
            <AdminSidebar 
                sections={sections.filter(s => !s.hidden)} 
                activeSection={activeSection} 
                setActiveSection={setActiveSection} 
                isSidebarOpen={isSidebarOpen} 
                setSidebarOpen={setSidebarOpen} 
            />
            <div className={`flex-1 flex flex-col transition-all duration-300 ${isSidebarOpen ? 'mr-0 md:mr-72 xl:mr-80' : 'mr-0'}`}>
                <header className="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                    <Button variant="ghost" onClick={() => setSidebarOpen(!isSidebarOpen)} className="text-slate-600">
                        {isSidebarOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
                    </Button>
                    <div className="flex items-center gap-4">
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Avatar className="cursor-pointer h-9 w-9">
                                    <AvatarImage src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200" alt="Admin" />
                                    <AvatarFallback>م</AvatarFallback>
                                </Avatar>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" dir="rtl">
                                <DropdownMenuLabel>حساب المدير</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem onClick={() => { setActiveSection('staff_access_management'); handleFeatureClick('الانتقال للملف الشخصي للمدير', 'قائمة المدير'); }}>الملف الشخصي</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => { setActiveSection('system_configuration'); handleFeatureClick('الانتقال لإعدادات النظام', 'قائمة المدير'); }}>الإعدادات</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem className="text-red-500" onClick={() => { handleNavigation('home'); handleFeatureClick('تسجيل الخروج من لوحة الإدارة', 'قائمة المدير'); }}>
                                  <LogOut className="w-4 h-4 ml-2" />
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
                                handleNavigation={(sectionId) => {
                                    if(sections.find(s => s.id === sectionId)) setActiveSection(sectionId);
                                    else handleNavigation(sectionId);
                                }} 
                                handleFeatureClick={(featureName) => handleFeatureClick(featureName, currentActiveSectionItem?.title || activeSection)} 
                           />}
                        </motion.div>
                    </AnimatePresence>
                </main>
            </div>
        </div>
    );
};

export default React.memo(AdminDashboard);