import React from 'react';
import { Ticket } from 'lucide-react';
import { motion } from 'framer-motion';

const Sidebar = ({ activeTab, setActiveTab, dashboardItems, isSidebarOpen }) => {
    const sidebarVariants = {
        open: { x: 0, transition: { type: "spring", stiffness: 300, damping: 30 } },
        closed: { x: "100%", transition: { type: "spring", stiffness: 300, damping: 30 } } 
    };

    return (
        <motion.aside 
            variants={sidebarVariants}
            initial="closed" 
            animate={isSidebarOpen ? "open" : "closed"}
            className="fixed top-0 right-0 w-72 xl:w-80 bg-white p-6 flex flex-col shrink-0 border-l border-slate-200 h-screen z-40"
        >
            <div className="flex items-center gap-3 mb-8">
                <div className="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                     <img 
                        alt="شعار ليلة الليليوم"
                        className="w-6 h-6 invert" src="https://lilium-night.com/wp-content/uploads/2024/07/logo-1-1.png" />
                </div>
                <h1 className="text-xl font-bold text-slate-800">ليلة الليليوم</h1>
            </div>
            <div className="flex-1 overflow-y-auto -mr-3 pr-3">
              <nav className="flex flex-col gap-1.5">
                  {dashboardItems.map(item => {
                      if (item.isTitle) {
                          return (
                              <h3 key={item.id} className="text-xs font-semibold text-slate-400 uppercase tracking-wider px-4 pt-6 pb-2">
                                  {item.title}
                              </h3>
                          );
                      }
                      const IconComponent = item.icon || Ticket;
                      return (
                          <button
                              key={item.id}
                              onClick={() => setActiveTab(item.id)}
                              className={`flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 ease-in-out w-full text-right ${
                                  activeTab === item.id
                                      ? 'bg-primary text-white shadow-md hover:bg-primary/90'
                                      : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800'
                              }`}
                          >
                              <IconComponent className="w-5 h-5" />
                              <span>{item.title}</span>
                          </button>
                      );
                  })}
              </nav>
            </div>
        </motion.aside>
    );
};

export default React.memo(Sidebar);