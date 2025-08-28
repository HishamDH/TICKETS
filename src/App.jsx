
import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Toaster } from '@/components/ui/toaster';
import { useToast } from '@/components/ui/use-toast';
import Navbar from '@/components/layout/Navbar';
import Footer from '@/components/layout/Footer';
import HomePage from '@/components/pages/HomePage';
import MerchantRegister from '@/components/pages/MerchantRegister';
import MerchantDashboard from '@/components/pages/MerchantDashboard';
import AdminDashboard from '@/components/pages/AdminDashboard';
import FeaturesPage from '@/components/pages/FeaturesPage';
import PricingPage from '@/components/pages/PricingPage';
import RolesAndJourneysPage from '@/components/pages/RolesAndJourneysPage';
import CustomerDashboard from '@/components/pages/CustomerDashboard';
import UnifiedView from '@/components/pages/UnifiedView';
import CheckInSystem from '@/components/pages/CheckInSystem';
import MerchantJourneyPage from '@/components/pages/MerchantJourneyPage';
import PartnersSystemPage from '@/components/pages/PartnersSystemPage';
import WalletAndFraudSystemPage from '@/components/pages/WalletAndFraudSystemPage';
import PartnerDashboard from '@/components/pages/PartnerDashboard';
import LegalPage from '@/components/pages/LegalPage';

function App() {
  const [currentView, setCurrentView] = useState('home');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const { toast } = useToast();

  const handleFeatureClick = (feature) => {
    toast({
      title: "🚧 هذه الميزة قيد التطوير",
      description: "لا تقلق! يمكنك طلبها في رسالتك التالية! 🚀",
    });
  };

  const handleNavigation = (view) => {
    setCurrentView(view);
    setMobileMenuOpen(false);
    window.scrollTo(0, 0);
  };

  const renderContent = () => {
    switch (currentView) {
      case 'home':
        return <HomePage handleNavigation={handleNavigation} handleFeatureClick={handleFeatureClick} />;
      case 'features':
        return <FeaturesPage handleFeatureClick={handleFeatureClick} />;
      case 'roles':
        return <RolesAndJourneysPage />;
      case 'merchant-journey':
        return <MerchantJourneyPage handleNavigation={handleNavigation} />;
      case 'partners-system':
        return <PartnersSystemPage />;
      case 'wallet-fraud-system':
        return <WalletAndFraudSystemPage />;
      case 'pricing':
        return <PricingPage handleNavigation={handleNavigation} handleFeatureClick={handleFeatureClick} />;
      case 'merchant-register':
        return <MerchantRegister handleFeatureClick={handleFeatureClick} handleNavigation={handleNavigation}/>;
      case 'merchant-dashboard':
        return <MerchantDashboard handleFeatureClick={handleFeatureClick} />;
      case 'admin':
        return <AdminDashboard handleFeatureClick={handleFeatureClick} />;
      case 'customer-dashboard':
        return <CustomerDashboard handleFeatureClick={handleFeatureClick} handleNavigation={handleNavigation} />;
      case 'partner-dashboard':
        return <PartnerDashboard handleFeatureClick={handleFeatureClick} />;
      case 'legal':
        return <LegalPage />;
      case 'unified-view':
        return <UnifiedView handleFeatureClick={handleFeatureClick} handleNavigation={handleNavigation} />;
       case 'checkin':
        return <CheckInSystem handleNavigation={handleNavigation} />;
      default:
        return <HomePage handleNavigation={handleNavigation} handleFeatureClick={handleFeatureClick} />;
    }
  };

  if (['admin', 'merchant-dashboard', 'customer-dashboard', 'unified-view', 'checkin', 'partner-dashboard'].includes(currentView)) {
     return (
        <div className="min-h-screen bg-background font-cairo">
            <AnimatePresence mode="wait">
              <motion.div
                key={currentView}
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                exit={{ opacity: 0 }}
                transition={{ duration: 0.3 }}
              >
                {renderContent()}
              </motion.div>
            </AnimatePresence>
          <Toaster />
        </div>
     )
  }

  return (
    <div className="min-h-screen bg-background font-cairo">
      <Navbar
        currentView={currentView}
        handleNavigation={handleNavigation}
        mobileMenuOpen={mobileMenuOpen}
        setMobileMenuOpen={setMobileMenuOpen}
      />
      <main className="pt-16">
        <AnimatePresence mode="wait">
          <motion.div
            key={currentView}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -20 }}
            transition={{ duration: 0.3 }}
          >
            {renderContent()}
          </motion.div>
        </AnimatePresence>
      </main>
      <Footer handleNavigation={handleNavigation} />
      <Toaster />
    </div>
  );
}

export default App;
