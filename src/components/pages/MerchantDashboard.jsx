import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    LayoutDashboard, Ticket, ClipboardList, Wallet, Palette, Users, BarChart3, FileCog, MessageSquare, History, QrCode, Printer, Building, Tag, GitBranch, Bell, Star, Code, Globe, BrainCircuit
} from 'lucide-react';

import Sidebar from '@/components/merchant-dashboard/Sidebar';
import OverviewContent from '@/components/merchant-dashboard/Overview';
import ServiceManagementContent from '@/components/merchant-dashboard/ServiceManagement';
import BookingsManagementContent from '@/components/merchant-dashboard/BookingsManagement';
import WalletContent from '@/components/merchant-dashboard/Wallet';
import TeamManagementContent from '@/components/merchant-dashboard/TeamManagement';
import AppearanceContent from '@/components/merchant-dashboard/Appearance';
import ReportsContent from '@/components/merchant-dashboard/Reports';
import PoliciesContent from '@/components/merchant-dashboard/Policies';
import MessagesContent from '@/components/merchant-dashboard/Messages';
import AuditLogContent from '@/components/merchant-dashboard/AuditLog';
import CheckInContent from '@/components/merchant-dashboard/CheckIn';
import PosContent from '@/components/merchant-dashboard/PosContent';
import GroupBookingContent from '@/components/merchant-dashboard/GroupBookingContent';
import PromotionsContent from '@/components/merchant-dashboard/PromotionsContent';
import BranchManagementContent from '@/components/merchant-dashboard/BranchManagementContent';
import NotificationsManagementContent from '@/components/merchant-dashboard/NotificationsManagementContent';
import ReviewsManagementContent from '@/components/merchant-dashboard/ReviewsManagementContent';
import ApiIntegrationsContent from '@/components/merchant-dashboard/ApiIntegrationsContent';
import LocalizationContent from '@/components/merchant-dashboard/LocalizationContent';
import AdvancedAnalyticsContent from '@/components/merchant-dashboard/AdvancedAnalyticsContent';

import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Button } from '@/components/ui/button';

const dashboardItems = [
    // Core Operations
    { id: 'overview', title: 'نظرة عامة', icon: LayoutDashboard, component: OverviewContent },
    { id: 'services', title: 'إدارة الخدمات', icon: Ticket, component: ServiceManagementContent },
    { id: 'bookings', title: 'إدارة الحجوزات', icon: ClipboardList, component: BookingsManagementContent },
    { id: 'checkin', title: 'التحقق', icon: QrCode, component: CheckInContent },
    { id: 'pos', title: 'البيع الداخلي (POS)', icon: Printer, component: PosContent },
    // Growth & Marketing
    { id: 'group-booking', title: 'نظام الحجز الجماعي', icon: Building, component: GroupBookingContent },
    { id: 'promotions', title: 'العروض والأكواد', icon: Tag, component: PromotionsContent },
    { id: 'reviews', title: 'مراجعات العملاء', icon: Star, component: ReviewsManagementContent },
    { id: 'reports', title: 'التقارير والتحليلات', icon: BarChart3, component: ReportsContent },
    { id: 'ai-analytics', title: 'الذكاء والتحليلات', icon: BrainCircuit, component: AdvancedAnalyticsContent },
    // Communication
    { id: 'notifications', title: 'إدارة الإشعارات', icon: Bell, component: NotificationsManagementContent },
    { id: 'messages', title: 'مركز الرسائل', icon: MessageSquare, component: MessagesContent },
    // Finance
    { id: 'wallet', title: 'المحفظة والسحب', icon: Wallet, component: WalletContent },
    // Setup & Configuration
    { id: 'branches', title: 'إدارة الفروع', icon: GitBranch, component: BranchManagementContent },
    { id: 'team', title: 'إدارة الفريق', icon: Users, component: TeamManagementContent },
    { id: 'appearance', title: 'إعداد الصفحة', icon: Palette, component: AppearanceContent },
    { id: 'policies', title: 'السياسات والإعدادات', icon: FileCog, component: PoliciesContent },
    { id: 'localization', title: 'اللغات والترجمة', icon: Globe, component: LocalizationContent },
    // Advanced
    { id: 'api', title: 'API والتكاملات', icon: Code, component: ApiIntegrationsContent },
    { id: 'audit', title: 'سجل الأنشطة', icon: History, component: AuditLogContent },
];

const branches = [
    { id: 'all', name: 'كل الفروع' },
    { id: 'riyadh', name: 'مطعم الرياض' },
    { id: 'jeddah', name: 'مطعم جدة' },
    { id: 'dammam', name: 'معرض الدمام' },
];

const MerchantDashboard = ({ handleFeatureClick }) => {
    const [activeTab, setActiveTab] = useState('overview');
    const [selectedBranch, setSelectedBranch] = useState('all');

    const ActiveComponent = dashboardItems.find(item => item.id === activeTab)?.component || OverviewContent;

    return (
        <div className="min-h-screen bg-slate-100 flex" dir="rtl">
            <Sidebar activeTab={activeTab} setActiveTab={setActiveTab} dashboardItems={dashboardItems} />
            <main className="flex-1 overflow-y-auto flex flex-col">
                <header className="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                    <div className="flex-1 min-w-0">
                         <div className="w-64">
                             <Select defaultValue="all" onValueChange={setSelectedBranch} dir="rtl">
                                <SelectTrigger className="w-full">
                                    <GitBranch className="h-4 w-4 ml-2" />
                                    <SelectValue placeholder="اختر الفرع..." />
                                </SelectTrigger>
                                <SelectContent>
                                    {branches.map(branch => (
                                        <SelectItem key={branch.id} value={branch.id}>{branch.name}</SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                     <div className="flex items-center gap-4">
                        <Button variant="ghost" size="icon" className="relative text-slate-600" onClick={() => handleFeatureClick("الإشعارات")}>
                            <Bell className="w-5 h-5" />
                            <span className="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </Button>
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Avatar className="cursor-pointer h-9 w-9">
                                    <AvatarImage src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?q=80&w=200" alt="Merchant" />
                                    <AvatarFallback>ت</AvatarFallback>
                                </Avatar>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuLabel>حساب التاجر</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem onClick={() => handleFeatureClick("Profile")}>الملف الشخصي</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => setActiveTab('appearance')}>الإعدادات</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem className="text-red-500">تسجيل الخروج</DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </header>
                <div className="flex-1 p-8">
                    <AnimatePresence mode="wait">
                        <motion.div
                            key={`${activeTab}-${selectedBranch}`}
                            initial={{ opacity: 0, y: 20 }}
                            animate={{ opacity: 1, y: 0 }}
                            exit={{ opacity: 0, y: -20 }}
                            transition={{ duration: 0.3 }}
                        >
                            <ActiveComponent handleFeatureClick={handleFeatureClick} selectedBranch={selectedBranch} />
                        </motion.div>
                    </AnimatePresence>
                </div>
            </main>
        </div>
    );
};

export default MerchantDashboard;