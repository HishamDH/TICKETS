import React, { useState, useEffect, Suspense, lazy, useMemo, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Menu, X, UserCircle as ProfileIcon, Ticket, CreditCard as PaymentsIcon, FileSignature as ContractsIcon, Star as ReviewsIcon, Bell as NotificationsIcon, Sparkles as OffersIcon, MessageCircle as SupportIcon, Send as SentRequestsIcon, Settings, Home, CalendarDays } from 'lucide-react';
import CustomerSidebar from '@/components/customer-dashboard/CustomerSidebar';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Button } from '@/components/ui/button';
import { useToast } from "@/components/ui/use-toast";
import { Skeleton } from '@/components/ui/skeleton';

const CustomerOverview = lazy(() => import('@/components/customer-dashboard/overview/CustomerOverview'));
const CustomerBookings = lazy(() => import('@/components/customer-dashboard/bookings/CustomerBookings'));
const PaymentHistory = lazy(() => import('@/components/customer-dashboard/payments/PaymentHistory'));
const CustomerRewards = lazy(() => import('@/components/customer-dashboard/rewards/CustomerRewards'));
const CustomerProfile = lazy(() => import('@/components/customer-dashboard/profile/CustomerProfile'));
const CustomerSettings = lazy(() => import('@/components/customer-dashboard/settings/CustomerSettings'));
const CustomerSupport = lazy(() => import('@/components/customer-dashboard/support/CustomerSupport'));
const CustomerExperience = lazy(() => import('@/components/customer-dashboard/experience/CustomerExperience'));
const CustomerTickets = lazy(() => import('@/components/customer-dashboard/tickets/CustomerTickets'));

const LoadingFallback = () => (
  <div className="p-4">
    <div className="space-y-3">
      <Skeleton className="h-8 w-1/2" />
      <Skeleton className="h-4 w-3/4" />
      <Skeleton className="h-20 w-full" />
      <Skeleton className="h-20 w-full" />
    </div>
  </div>
);

const CustomerDashboard = ({ handleNavigation }) => {
    const [activeSection, setActiveSection] = useState('overview_section');
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
        { id: 'account_title', title: 'حسابي', isTitle: true },
        { id: 'overview_section', title: 'نظرة عامة', icon: Home, component: CustomerOverview },
        { id: 'profile_section', title: 'ملفي الشخصي', icon: ProfileIcon, component: CustomerProfile },
        
        { id: 'bookings_title', title: 'الحجوزات والتذاكر', isTitle: true },
        { id: 'bookings_section', title: 'حجوزاتي', icon: Ticket, component: CustomerBookings }, 
        { id: 'customer_bookings_page_link', title: 'عرض التواريخ المحجوزة', icon: CalendarDays, isLink: true, path: 'customer-bookings-page' },
        { id: 'notifications_section', title: 'الإشعارات وتذاكري', icon: NotificationsIcon, component: CustomerTickets }, 
        
        { id: 'finance_rewards_title', title: 'المالية والمكافآت', isTitle: true },
        { id: 'payments_section', title: 'السجل المالي', icon: PaymentsIcon, component: PaymentHistory }, 
        { id: 'offers_section', title: 'المكافآت والنقاط', icon: OffersIcon, component: CustomerRewards }, 
        
        { id: 'interaction_title', title: 'التفاعل والمساعدة', isTitle: true },
        { id: 'reviews_section', title: 'التقييمات وتجربتي', icon: ReviewsIcon, component: CustomerExperience }, 
        { id: 'support_section', title: 'الدعم والمساعدة', icon: SupportIcon, component: CustomerSupport },
        { id: 'contracts_section', title: 'العقود', icon: ContractsIcon, component: CustomerSupport }, 
        { id: 'sent_requests_section', title: 'الطلبات المرسلة', icon: SentRequestsIcon, component: CustomerSupport },
        
        { id: 'settings_title', title: 'الإعدادات', isTitle: true },
        { id: 'settings_section', title: 'الإعدادات العامة', icon: Settings, component: CustomerSettings }, 
    ], []);

    const currentActiveSectionItem = useMemo(() => sections.find(s => s.id === activeSection && !s.isLink), [sections, activeSection]);
    const ActiveComponent = useMemo(() => currentActiveSectionItem?.component, [currentActiveSectionItem]);


    return (
        <div className="flex h-screen bg-slate-100" dir="rtl">
            <CustomerSidebar 
                sections={sections} 
                activeSection={activeSection} 
                setActiveSection={setActiveSection}
                isSidebarOpen={isSidebarOpen}
                setSidebarOpen={setSidebarOpen}
                handleNavigation={handleNavigation}
            />

            <div className={`flex-1 flex flex-col transition-all duration-300 ${isSidebarOpen ? 'mr-0 md:mr-64' : 'mr-0'}`}>
                <header className="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                     <Button variant="ghost" size="icon" onClick={() => setSidebarOpen(!isSidebarOpen)} className="text-slate-600">
                        {isSidebarOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
                    </Button>
                    <div className="flex items-center gap-4">
                        <Button variant="ghost" size="icon" className="relative text-slate-600" onClick={() => { setActiveSection('notifications_section'); handleFeatureClick('عرض الإشعارات', "زر الإشعارات"); }}>
                            <NotificationsIcon className="w-5 h-5" />
                            <span className="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </Button>
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Avatar className="cursor-pointer h-9 w-9">
                                    <AvatarImage src="https://images.unsplash.com/photo-1544723795-3fb6469f5b39?q=80&w=200" alt="Customer" />
                                    <AvatarFallback>ع</AvatarFallback>
                                </Avatar>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" dir="rtl">
                                <DropdownMenuLabel>حساب العميل</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem onClick={() => { setActiveSection('profile_section'); handleFeatureClick('الانتقال للملف الشخصي', "قائمة المستخدم"); }}>الملف الشخصي</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => { setActiveSection('settings_section'); handleFeatureClick('الانتقال للإعدادات', "قائمة المستخدم"); }}>الإعدادات</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem className="text-red-500" onClick={() => { handleNavigation('home'); handleFeatureClick('تسجيل الخروج', "قائمة المستخدم"); }}>
                                  تسجيل الخروج
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </header>

                <main className="flex-1 overflow-y-auto p-6 lg:p-8">
                    <Suspense fallback={<LoadingFallback />}>
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
                                    setActiveSection={setActiveSection} 
                                    title={currentActiveSectionItem?.title} 
                                    icon={currentActiveSectionItem?.icon} 
                                />}
                            </motion.div>
                        </AnimatePresence>
                    </Suspense>
                </main>
            </div>
        </div>
    );
};

export default React.memo(CustomerDashboard);