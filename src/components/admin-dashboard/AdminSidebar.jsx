import React from 'react';
import { motion } from 'framer-motion';
import { Ticket } from 'lucide-react';

const AdminSidebar = ({ sections, activeSection, setActiveSection, isSidebarOpen, setSidebarOpen }) => {
    
    const sidebarVariants = {
        open: { x: 0, transition: { type: 'spring', stiffness: 300, damping: 30 } },
        closed: { x: "100%", transition: { type: 'spring', stiffness: 300, damping: 30 } },
    };

    const handleSectionClick = (sectionId) => {
        setActiveSection(sectionId);
        if (window.innerWidth < 768 && setSidebarOpen) { 
            setSidebarOpen(false);
        }
    };

    return (
        <motion.div
            initial={false}
            animate={isSidebarOpen ? "open" : "closed"}
            variants={sidebarVariants}
            className="fixed top-0 right-0 h-full bg-slate-800 text-white w-72 xl:w-80 z-40 flex flex-col shadow-2xl"
        >
            <div className="p-6 mb-4 flex items-center justify-center border-b border-slate-700">
                <img 
                    alt="شعار ليلة الليليوم"
                    className="w-8 h-8 ml-2 filter drop-shadow-lg"
                    src="https://images.unsplash.com/photo-1557845767-9cc6526890f7" 
                />
                <h1 className="text-xl xl:text-2xl font-bold">ليلة الليليوم</h1>
            </div>
            <div className="flex-1 overflow-y-auto">
                <nav className="px-3 xl:px-4 space-y-1.5">
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
                            <button
                                key={section.id}
                                onClick={() => handleSectionClick(section.id)}
                                className={`w-full flex items-center gap-3 p-3 rounded-lg transition-all duration-200 ease-in-out text-right transform hover:scale-105 hover:bg-slate-700 hover:shadow-md ${activeSection === section.id ? 'bg-primary text-white shadow-lg' : ''}`}
                            >
                                <IconComponent className="w-5 h-5 ml-3" />
                                <span className="text-sm">{section.title}</span>
                            </button>
                        );
                    })}
                </nav>
            </div>
            <div className="p-4 border-t border-slate-700 mt-auto">
                <p className="text-xs text-slate-400 text-center">
                    &copy; {new Date().getFullYear()} ليلة الليليوم. جميع الحقوق محفوظة.
                </p>
            </div>
        </motion.div>
    );
};

export default React.memo(AdminSidebar);