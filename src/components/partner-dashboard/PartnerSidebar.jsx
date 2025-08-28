
import React from 'react';
import { motion } from 'framer-motion';
import { Home, Users, DollarSign, Share2, LogOut } from 'lucide-react';

const NavItem = ({ icon, label, tabName, activeTab, setActiveTab }) => {
  const Icon = icon;
  const isActive = activeTab === tabName;
  return (
    <motion.button
      onClick={() => setActiveTab(tabName)}
      className={`flex items-center w-full px-4 py-3 text-right rounded-lg transition-colors duration-200 relative ${
        isActive ? 'bg-primary text-white shadow-lg' : 'text-gray-600 hover:bg-primary/10 hover:text-primary'
      }`}
      whileHover={{ x: isActive ? 0 : 5 }}
      whileTap={{ scale: 0.98 }}
    >
      <Icon className="w-6 h-6 ml-4" />
      <span className="font-semibold">{label}</span>
    </motion.button>
  );
};

const PartnerSidebar = ({ activeTab, setActiveTab }) => {
  return (
    <aside className="w-64 bg-white shadow-md p-4 flex-shrink-0 hidden md:flex flex-col">
      <div className="flex items-center mb-8 px-2">
        <img 
            alt="شعار شباك التذاكر"
            className="w-10 h-10 ml-3"
            src="https://images.unsplash.com/photo-1674634044801-de885454a7c2" 
        />
        <span className="text-xl font-bold gradient-text">لوحة تحكم الشريك</span>
      </div>
      <nav className="flex-grow space-y-2">
        <NavItem icon={Home} label="نظرة عامة" tabName="overview" activeTab={activeTab} setActiveTab={setActiveTab} />
        <NavItem icon={Users} label="التجار المسجلون" tabName="referrals" activeTab={activeTab} setActiveTab={setActiveTab} />
        <NavItem icon={DollarSign} label="الأرباح والسحب" tabName="payouts" activeTab={activeTab} setActiveTab={setActiveTab} />
        <NavItem icon={Share2} label="أدوات ترويجية" tabName="tools" activeTab={activeTab} setActiveTab={setActiveTab} />
      </nav>
      <div className="mt-auto">
         <motion.button
            onClick={() => window.location.reload()} // Simplified logout
            className="flex items-center w-full px-4 py-3 text-right rounded-lg transition-colors duration-200 text-red-500 hover:bg-red-500/10"
            whileHover={{ x: 5 }}
            whileTap={{ scale: 0.98 }}
            >
            <LogOut className="w-6 h-6 ml-4" />
            <span className="font-semibold">تسجيل الخروج</span>
        </motion.button>
      </div>
    </aside>
  );
};

export default PartnerSidebar;
