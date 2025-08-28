import React from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Menu, X } from 'lucide-react';

const NavItem = ({ view, currentView, handleNavigation, children }) => (
  <button
    onClick={() => handleNavigation(view)}
    className={`px-4 py-2 rounded-lg transition-all duration-300 relative font-medium ${
      currentView === view
        ? 'text-primary'
        : 'text-gray-600 hover:text-primary'
    }`}
  >
    {children}
    {currentView === view && (
      <motion.div
        className="absolute bottom-0 left-0 right-0 h-0.5 bg-primary"
        layoutId="underline"
        initial={false}
        transition={{ type: 'spring', stiffness: 500, damping: 30 }}
      />
    )}
  </button>
);

const Navbar = ({ currentView, handleNavigation, mobileMenuOpen, setMobileMenuOpen }) => {
  const navLinks = [
    { view: 'home', label: 'الرئيسية' },
    { view: 'features', label: 'المميزات' },
    { view: 'merchant-journey', label: 'رحلة التاجر' },
    { view: 'partners-system', label: 'نظام الشركاء' },
    { view: 'wallet-fraud-system', label: 'المحفظة والحماية' },
    { view: 'roles', label: 'الأدوار والرحلات' },
    { view: 'pricing', label: 'الأسعار' },
    { view: 'unified-view', label: 'لوحات التحكم' },
  ];

  return (
    <nav className="fixed top-0 w-full bg-white/80 backdrop-blur-lg border-b border-gray-200/80 z-50">
      <div className="container mx-auto px-4">
        <div className="flex items-center justify-between h-16">
          <div className="flex items-center cursor-pointer" onClick={() => handleNavigation('home')}>
            <img 
              alt="شعار شباك التذاكر"
              className="w-10 h-10 ml-3"
             src="https://images.unsplash.com/photo-1674634044801-de885454a7c2" />
            <span className="text-xl font-bold gradient-text">شباك التذاكر</span>
          </div>

          <div className="hidden md:flex items-center space-x-2 space-x-reverse">
            {navLinks.map(link => (
              <NavItem key={link.view} view={link.view} currentView={currentView} handleNavigation={handleNavigation}>
                {link.label}
              </NavItem>
            ))}
          </div>

          <button
            className="md:hidden p-2 text-gray-700"
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
          >
            {mobileMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
          </button>
        </div>

        <AnimatePresence>
          {mobileMenuOpen && (
            <motion.div
              initial={{ opacity: 0, height: 0 }}
              animate={{ opacity: 1, height: 'auto' }}
              exit={{ opacity: 0, height: 0 }}
              className="md:hidden border-t border-gray-200/80"
            >
              <div className="flex flex-col space-y-2 py-4">
                {navLinks.map(link => (
                  <button
                    key={link.view}
                    onClick={() => handleNavigation(link.view)}
                    className={`block w-full text-right px-4 py-3 rounded-lg transition-colors ${
                      currentView === link.view ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600'
                    }`}
                  >
                    {link.label}
                  </button>
                ))}
              </div>
            </motion.div>
          )}
        </AnimatePresence>
      </div>
    </nav>
  );
};

export default Navbar;