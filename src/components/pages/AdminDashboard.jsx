
import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Menu, X, LayoutDashboard, Store, Send, BookCopy, Users, LifeBuoy, BarChart3, Settings, Globe, Shield, BrainCircuit, Bell } from 'lucide-react';
import AdminSidebar from '@/components/admin-dashboard/AdminSidebar';
import AdminOverview from '@/components/admin-dashboard/overview/AdminOverview';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Button } from '@/components/ui/button';

import MerchantsControl from '@/components/admin-dashboard/merchants/MerchantsControl';
import PayoutsManagement from '@/components/admin-dashboard/payouts/PayoutsManagement';
import AdminBookingsManagement from '@/components/admin-dashboard/bookings/AdminBookingsManagement';
import StaffManagement from '@/components/admin-dashboard/staff/StaffManagement';
import SupportSystem from '@/components/admin-dashboard/support/SupportSystem';
import ReportsAnalytics from '@/components/admin-dashboard/reports/ReportsAnalytics';
import PlatformSettings from '@/components/admin-dashboard/settings/PlatformSettings';
import DomainManagement from '@/components/admin-dashboard/domains/DomainManagement';
import SecurityMonitoring from '@/components/admin-dashboard/security/SecurityMonitoring';
import AiSupervision from '@/components/admin-dashboard/ai/AiSupervision';

const AdminDashboard = ({ handleFeatureClick }) => {
    const [activeSection, setActiveSection] = useState('overview');
    const [isSidebarOpen, setSidebarOpen] = useState(true);

    const sections = [
        { id: 'overview', title: 'نظرة عامة', icon: LayoutDashboard, component: AdminOverview },
        { id: 'merchants', title: 'إدارة التجار', icon: Store, component: MerchantsControl },
        { id: 'payouts', title: 'إدارة طلبات السحب', icon: Send, component: PayoutsManagement },
        { id: 'bookings', title: 'الحجوزات العامة', icon: BookCopy, component: AdminBookingsManagement },
        { id: 'staff', title: 'إدارة الموظفين', icon: Users, component: StaffManagement },
        { id: 'support', title: 'الدعم الفني', icon: LifeBuoy, component: SupportSystem },
        { id: 'reports', title: 'التحليلات والتقارير', icon: BarChart3, component: ReportsAnalytics },
        { id: 'settings', title: 'إعدادات النظام', icon: Settings, component: PlatformSettings },
        { id: 'domains', title: 'إدارة النطاقات', icon: Globe, component: DomainManagement },
        { id: 'security', title: 'مراقبة الأمان', icon: Shield, component: SecurityMonitoring },
        { id: 'ai-supervision', title: 'الرقابة الذكية', icon: BrainCircuit, component: AiSupervision },
    ];

    const ActiveComponent = sections.find(s => s.id === activeSection)?.component;

    return (
        <div className="flex h-screen bg-slate-100" dir="rtl">
            <AdminSidebar 
                sections={sections} 
                activeSection={activeSection} 
                setActiveSection={setActiveSection}
                isSidebarOpen={isSidebarOpen}
                setSidebarOpen={setSidebarOpen}
            />

            <div className={`flex-1 flex flex-col transition-all duration-300 ${isSidebarOpen ? 'mr-64' : 'mr-0'}`}>
                <header className="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                     <Button variant="ghost" size="icon" onClick={() => setSidebarOpen(!isSidebarOpen)} className="text-slate-600">
                        {isSidebarOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
                    </Button>
                    <div className="flex items-center gap-4">
                        <Button variant="ghost" size="icon" className="relative text-slate-600" onClick={() => handleFeatureClick("Notifications")}>
                            <Bell className="w-5 h-5" />
                            <span className="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </Button>
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Avatar className="cursor-pointer h-9 w-9">
                                    <AvatarImage src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200" alt="Admin" />
                                    <AvatarFallback>A</AvatarFallback>
                                </Avatar>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuLabel>حساب المدير</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem onClick={() => handleFeatureClick("Profile")}>الملف الشخصي</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => handleFeatureClick("Settings")}><Settings className="w-4 h-4 ml-2" /> الإعدادات</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem className="text-red-500">تسجيل الخروج</DropdownMenuItem>
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
                            {ActiveComponent ? <ActiveComponent handleFeatureClick={handleFeatureClick} /> : <div>محتوى غير موجود</div>}
                        </motion.div>
                    </AnimatePresence>
                </main>
            </div>
        </div>
    );
};

export default AdminDashboard;
