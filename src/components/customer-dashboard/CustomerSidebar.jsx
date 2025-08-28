
import React from 'react';
import { motion } from 'framer-motion';
import { LogOut } from 'lucide-react';
import { Button } from '@/components/ui/button';

const CustomerSidebar = ({ sections, activeSection, setActiveSection, isSidebarOpen, handleNavigation }) => {
    return (
        <motion.div
            initial={{ right: 0 }}
            animate={{ width: isSidebarOpen ? '256px' : '0px', padding: isSidebarOpen ? '1rem' : '0' }}
            className="fixed top-0 right-0 h-full bg-white shadow-lg z-40 overflow-hidden"
        >
            <div className="flex flex-col h-full">
                <div className="flex items-center justify-center p-4 border-b">
                    <h1 className="text-2xl font-bold text-primary">شباك التذاكر</h1>
                </div>

                <nav className="flex-1 mt-6 space-y-2">
                    {sections.map(section => (
                        <Button
                            key={section.id}
                            variant={activeSection === section.id ? 'secondary' : 'ghost'}
                            className="w-full justify-start text-base"
                            onClick={() => setActiveSection(section.id)}
                        >
                            <section.icon className="w-5 h-5 ml-3" />
                            {section.title}
                        </Button>
                    ))}
                </nav>

                <div className="mt-auto p-4 border-t">
                    <Button variant="ghost" className="w-full justify-start text-base text-red-500 hover:text-red-600 hover:bg-red-50" onClick={() => handleNavigation('home')}>
                        <LogOut className="w-5 h-5 ml-3" />
                        تسجيل الخروج
                    </Button>
                </div>
            </div>
        </motion.div>
    );
};

export default CustomerSidebar;
