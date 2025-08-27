import React from 'react';
import { motion } from 'framer-motion';
import { LogOut, Ticket } from 'lucide-react';
import { Button } from '@/components/ui/button';

const CustomerSidebar = ({ sections, activeSection, setActiveSection, isSidebarOpen, handleNavigation, setSidebarOpen }) => {
    
    const handleItemClick = (section) => {
        if (section.isLink) {
            handleNavigation(section.path);
        } else {
            setActiveSection(section.id);
        }
        if (window.innerWidth < 768) { 
            setSidebarOpen(false);
        }
    };
    
    return (
        <motion.div
            initial={{ right: isSidebarOpen ? 0 : "-100%" }}
            animate={{ right: isSidebarOpen ? 0 : "-100%", width: isSidebarOpen ? '256px' : '0px' }}
            transition={{ type: "tween", duration: 0.3 }}
            className="fixed top-0 right-0 h-full bg-white shadow-lg z-40 flex flex-col"
        >
            <div className="flex items-center justify-center p-4 border-b shrink-0">
                 <img 
                    alt="شعار ليلة الليليوم"
                    className="w-8 h-8 ml-2"
                    src="https://images.unsplash.com/photo-1557845767-9cc6526890f7" 
                />
                <h1 className="text-2xl font-bold text-primary">ليلة الليليوم</h1>
            </div>

            <nav className="flex-1 mt-4 space-y-1 overflow-y-auto px-4">
                {sections.map(section => {
                    if (section.isTitle) {
                        return (
                            <h3 key={section.id} className="text-xs font-semibold text-slate-400 uppercase tracking-wider px-4 pt-6 pb-2">
                                {section.title}
                            </h3>
                        );
                    }
                    const IconComponent = section.icon || Ticket;
                    return (
                        <Button
                            key={section.id}
                            variant={activeSection === section.id && !section.isLink ? 'secondary' : 'ghost'}
                            className="w-full justify-start text-base py-6"
                            onClick={() => handleItemClick(section)}
                        >
                            <IconComponent className="w-5 h-5 ml-3" />
                            {section.title}
                        </Button>
                    );
                })}
            </nav>

            <div className="mt-auto p-4 border-t shrink-0">
                <Button variant="ghost" className="w-full justify-start text-base text-red-500 hover:text-red-600 hover:bg-red-50" onClick={() => handleNavigation('home')}>
                    <LogOut className="w-5 h-5 ml-3" />
                    تسجيل الخروج
                </Button>
            </div>
        </motion.div>
    );
};

export default CustomerSidebar;