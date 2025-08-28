
import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Menu, X, Home, Ticket, Badge, Receipt, Star, UserCircle, Settings, LifeBuoy, Sparkles, LogOut, Bell } from 'lucide-react';
import CustomerSidebar from '@/components/customer-dashboard/CustomerSidebar';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";

import CustomerOverview from '@/components/customer-dashboard/overview/CustomerOverview';
import CustomerBookings from '@/components/customer-dashboard/bookings/CustomerBookings';
import CustomerTickets from '@/components/customer-dashboard/tickets/CustomerTickets';
import PaymentHistory from '@/components/customer-dashboard/payments/PaymentHistory';
import CustomerRewards from '@/components/customer-dashboard/rewards/CustomerRewards';
import CustomerProfile from '@/components/customer-dashboard/profile/CustomerProfile';
import CustomerSettings from '@/components/customer-dashboard/settings/CustomerSettings';
import CustomerSupport from '@/components/customer-dashboard/support/CustomerSupport';
import CustomerExperience from '@/components/customer-dashboard/experience/CustomerExperience';


const CustomerDashboard = ({ handleFeatureClick, handleNavigation }) => {
    const [activeSection, setActiveSection] = useState('overview');
    const [isSidebarOpen, setSidebarOpen] = useState(true);

    const sections = [
        { id: 'overview', title: 'الرئيسية', icon: Home, component: CustomerOverview },
        { id: 'bookings', title: 'حجوزاتي', icon: Ticket, component: CustomerBookings },
        { id: 'tickets', title: 'تذاكري', icon: Badge, component: CustomerTickets },
        { id: 'payments', title: 'السجل المالي', icon: Receipt, component: PaymentHistory },
        { id: 'rewards', title: 'المكافآت', icon: Star, component: CustomerRewards },
        { id: 'profile', title: 'الملف الشخصي', icon: UserCircle, component: CustomerProfile },
        { id: 'settings', title: 'الإعدادات', icon: Settings, component: CustomerSettings },
        { id: 'support', title: 'الدعم الفني', icon: LifeBuoy, component: CustomerSupport },
        { id: 'experience', title: 'تجربتي', icon: Sparkles, component: CustomerExperience },
    ];

    const ActiveComponent = sections.find(s => s.id === activeSection)?.component;

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
                                    <AvatarImage src="https://images.unsplash.com/photo-1544723795-3fb6469f5b39?q=80&w=200" alt="Customer" />
                                    <AvatarFallback>ن</AvatarFallback>
                                </Avatar>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuLabel>مرحباً، نورة</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem onClick={() => setActiveSection('profile')}>الملف الشخصي</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => setActiveSection('settings')}>الإعدادات</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem className="text-red-500" onClick={() => handleNavigation('home')}>
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
                            {ActiveComponent ? <ActiveComponent handleFeatureClick={handleFeatureClick} /> : <div>محتوى غير موجود</div>}
                        </motion.div>
                    </AnimatePresence>
                </main>
            </div>
        </div>
    );
};

export default CustomerDashboard;
