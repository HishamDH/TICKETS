
import React, { useState } from 'react';
import PartnerSidebar from '@/components/partner-dashboard/PartnerSidebar';
import Overview from '@/components/partner-dashboard/Overview';
import MyReferrals from '@/components/partner-dashboard/MyReferrals';
import Payouts from '@/components/partner-dashboard/Payouts';
import PromoTools from '@/components/partner-dashboard/PromoTools';

const PartnerDashboard = ({ handleFeatureClick }) => {
  const [activeTab, setActiveTab] = useState('overview');

  const renderContent = () => {
    switch (activeTab) {
      case 'overview':
        return <Overview handleFeatureClick={handleFeatureClick}/>;
      case 'referrals':
        return <MyReferrals handleFeatureClick={handleFeatureClick}/>;
      case 'payouts':
        return <Payouts handleFeatureClick={handleFeatureClick}/>;
      case 'tools':
        return <PromoTools handleFeatureClick={handleFeatureClick}/>;
      default:
        return <Overview handleFeatureClick={handleFeatureClick}/>;
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex" dir="rtl">
      <PartnerSidebar activeTab={activeTab} setActiveTab={setActiveTab} />
      <main className="flex-1 p-4 sm:p-6 lg:p-8">
        {renderContent()}
      </main>
    </div>
  );
};

export default PartnerDashboard;
