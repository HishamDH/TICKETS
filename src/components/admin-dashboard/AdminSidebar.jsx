
import React from 'react';
import { motion } from 'framer-motion';
import { Ticket } from 'lucide-react';

const AdminSidebar = ({ sections, activeSection, setActiveSection, isSidebarOpen, setSidebarOpen }) => {
    
    const sidebarVariants = {
        open: { x: 0 },
        closed: { x: "100%" },
    };

    return (
        <motion.div
            initial={false}
            animate={isSidebarOpen ? "open" : "closed"}
            variants={sidebarVariants}
            transition={{ type: 'spring', stiffness: 300, damping: 30 }}
            className="fixed top-0 right-0 h-full bg-slate-800 text-white w-64 z-40 flex flex-col"
        >
            <div className="p-6 mb-4 flex items-center justify-center border-b border-slate-700">
                <Ticket className="w-8 h-8 text-primary" />
                <h1 className="text-2xl font-bold mr-2">شباك التذاكر</h1>
            </div>
            <nav className="flex-1 px-4 space-y-2">
                {sections.map(section => (
                    <button
                        key={section.id}
                        onClick={() => setActiveSection(section.id)}
                        className={`w-full flex items-center p-3 rounded-lg transition-colors text-right ${activeSection === section.id ? 'bg-primary text-white' : 'hover:bg-slate-700'}`}
                    >
                        <section.icon className="w-5 h-5 ml-4" />
                        <span>{section.title}</span>
                    </button>
                ))}
            </nav>
            <div className="p-4 border-t border-slate-700">
                <p className="text-xs text-slate-400 text-center">
                    &copy; {new Date().getFullYear()} شباك التذاكر. جميع الحقوق محفوظة.
                </p>
            </div>
        </motion.div>
    );
};

export default AdminSidebar;
