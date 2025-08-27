import React, { useState, Suspense, lazy, useMemo, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Routes, Route, useLocation, useNavigate } from 'react-router-dom';

import { Toaster } from '@/components/ui/toaster';
import Navbar from '@/components/layout/Navbar';
import Footer from '@/components/layout/Footer';
import PageHelmet from '@/components/layout/PageHelmet';
import { Skeleton } from '@/components/ui/skeleton';

const ServicesShowcasePage = lazy(() => import('@/components/pages/ServicesShowcasePage'));
const MerchantRegister = lazy(() => import('@/components/pages/MerchantRegister'));
const MerchantDashboard = lazy(() => import('@/components/pages/MerchantDashboard'));
const AdminDashboard = lazy(() => import('@/components/pages/AdminDashboard'));
const FeaturesPage = lazy(() => import('@/components/pages/FeaturesPage'));
const PricingPage = lazy(() => import('@/components/pages/PricingPage'));
const RolesAndJourneysPage = lazy(() => import('@/components/pages/RolesAndJourneysPage'));
const CustomerDashboard = lazy(() => import('@/components/pages/CustomerDashboard'));
const UnifiedView = lazy(() => import('@/components/pages/UnifiedView'));
const CheckInSystem = lazy(() => import('@/components/pages/CheckInSystem'));
const MerchantJourneyPage = lazy(() => import('@/components/pages/MerchantJourneyPage'));
const PartnersSystemPage = lazy(() => import('@/components/pages/PartnersSystemPage'));
const WalletAndFraudSystemPage = lazy(() => import('@/components/pages/WalletAndFraudSystemPage'));
const PartnerDashboard = lazy(() => import('@/components/pages/PartnerDashboard'));
const LegalPage = lazy(() => import('@/components/pages/LegalPage'));
const HomePage = lazy(() => import('@/components/pages/HomePage'));
const CustomerBookingsPage = lazy(() => import('@/components/pages/CustomerBookingsPage'));
const PublicBookingPage = lazy(() => import('@/components/pages/PublicBookingPage'));
const LoginPage = lazy(() => import('@/components/pages/LoginPage'));
const CustomerRegisterPage = lazy(() => import('@/components/pages/CustomerRegisterPage'));


const LoadingFallback = React.memo(() => (
  <div className="p-8">
    <div className="space-y-4">
      <Skeleton className="h-12 w-1/2 bg-slate-200" />
      <Skeleton className="h-8 w-3/4 bg-slate-200" />
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4 pt-8">
        <Skeleton className="h-48 w-full bg-slate-200" />
        <Skeleton className="h-48 w-full bg-slate-200" />
        <Skeleton className="h-48 w-full bg-slate-200" />
      </div>
    </div>
  </div>
));

const pageConfig = {
    'home': { Component: HomePage, helmet: { title: "عن المنصة", description: "تعرف على منصة ليلة الليليوم التي تحدث ثورة في عالم تنظيم المناسبات." }},
    'services-showcase': { Component: ServicesShowcasePage, helmet: { title: "الخدمات", description: "اكتشف مجموعة واسعة من خدمات تنظيم المناسبات من أفضل المزودين في المملكة." }},
    'features': { Component: FeaturesPage, helmet: { title: "مميزاتنا", description: "تعرف على الميزات المبتكرة التي تجعل منصة ليلة الليليوم الخيار الأول لتنظيم مناسباتك." }},
    'roles': { Component: RolesAndJourneysPage, helmet: { title: "الأدوار والرحلات", description: "استكشف رحلة كل من العميل، مزود الخدمة، والمدير في منصتنا المتكاملة." }},
    'merchant-journey': { Component: MerchantJourneyPage, helmet: { title: "رحلة مزود الخدمة", description: "دليلك خطوة بخطوة للانضمام والنجاح كشريك في منصة ليلة الليليوم." }},
    'partners-system': { Component: PartnersSystemPage, helmet: { title: "نظام الشركاء", description: "انضم لبرنامج شركاء ليلة الليليوم وساهم في نمو المنصة وحقق عوائد مجزية." }},
    'wallet-fraud-system': { Component: WalletAndFraudSystemPage, helmet: { title: "المحفظة ومنع الاحتيال", description: "تعرف على نظام المحفظة الآمن ونظام كشف الاحتيال المتقدم في ليلة الليليوم." }},
    'pricing': { Component: PricingPage, helmet: { title: "الأسعار", description: "باقات أسعار مرنة وشفافة تناسب جميع احتياجات مزودي الخدمات." }},
    'merchant-register': { Component: MerchantRegister, helmet: { title: "انضم كمزود خدمة", description: "ابدأ رحلتك نحو النجاح. سجل الآن كمزود خدمة في منصة ليلة الليليوم." }},
    'customer-register': { Component: CustomerRegisterPage, helmet: { title: "إنشاء حساب عميل", description: "سجل حسابك كعميل في ليلة الليليوم وابدأ في حجز مناسباتك." }},
    'login': { Component: LoginPage, helmet: { title: "تسجيل الدخول", description: "سجل دخولك إلى حسابك في منصة ليلة الليليوم." }},
    'merchant-dashboard': { Component: MerchantDashboard, helmet: { title: "لوحة تحكم مزود الخدمة", description: "إدارة حجوزاتك، خدماتك، وأموالك بكل سهولة وأمان." }},
    'admin': { Component: AdminDashboard, helmet: { title: "لوحة تحكم الإدارة", description: "نظرة شاملة وإدارة كاملة لجميع عمليات المنصة." }},
    'customer-dashboard': { Component: CustomerDashboard, helmet: { title: "لوحة تحكم العميل", description: "تتبع حجوزاتك، تقييماتك، ومكافآتك في مكان واحد." }},
    'customer-bookings-page': { Component: CustomerBookingsPage, helmet: { title: "صفحة حجوزاتي", description: "عرض وتفاصيل حجوزاتك القادمة والسابقة." }},
    'partner-dashboard': { Component: PartnerDashboard, helmet: { title: "لوحة تحكم الشريك", description: "تابع إحالاتك، عمولاتك، وأدائك كشريك نجاح." }},
    'legal': { Component: LegalPage, helmet: { title: "المركز القانوني", description: "اطلع على شروط الاستخدام وسياسة الخصوصية لمنصة ليلة الليليوم." }},
    'unified-view': { Component: UnifiedView, helmet: { title: "لوحات التحكم الموحدة", description: "تجربة شاملة لكل الأدوار في المنصة. تنقل بين لوحات التحكم بسهولة." }},
    'checkin': { Component: CheckInSystem, helmet: { title: "نظام التحقق من الحضور", description: "تحقق من حجوزات العملاء بسرعة وأمان." }},
    'public-booking': { Component: PublicBookingPage, helmet: { title: `احجز لدى مزود الخدمة`, description: `استعرض الباقات والتواريخ المتاحة وقم بالحجز مباشرة.` } },
};

function App() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const location = useLocation();
  const navigate = useNavigate();
  
  const handleNavigation = useCallback((path, context = null) => {
    navigate(`/${path}`, { state: context });
    setMobileMenuOpen(false);
    window.scrollTo(0, 0);
  }, [navigate]);
  
  const currentPath = location.pathname.substring(1) || 'home';
  const { state: publicPageContext } = location;

  const fullScreenViews = ['admin', 'merchant-dashboard', 'customer-dashboard', 'unified-view', 'checkin', 'partner-dashboard', 'customer-bookings-page', 'public-booking', 'login', 'merchant-register', 'customer-register'];

  const Layout = ({ children }) => {
    if (fullScreenViews.includes(currentPath)) {
        return <>{children}</>;
    }
    return (
        <>
            <Navbar
                currentView={currentPath}
                handleNavigation={handleNavigation}
                mobileMenuOpen={mobileMenuOpen}
                setMobileMenuOpen={setMobileMenuOpen}
                appName="ليلة الليليوم"
            />
            <main className="pt-16">{children}</main>
            <Footer handleNavigation={handleNavigation} appName="ليلة الليليوم" />
        </>
    );
  };

  return (
    <div className="min-h-screen bg-background font-cairo" dir="rtl">
        <Layout>
            <Suspense fallback={<LoadingFallback />}>
              <AnimatePresence mode="wait">
                 <Routes location={location} key={location.pathname}>
                     {Object.entries(pageConfig).map(([path, {Component, helmet}]) => (
                        <Route key={path} path={`/${path === 'home' ? '' : path}`} element={
                            <motion.div
                              initial={{ opacity: 0 }}
                              animate={{ opacity: 1 }}
                              exit={{ opacity: 0 }}
                              transition={{ duration: 0.2 }}
                            >
                              <PageHelmet title={helmet.title} description={helmet.description} />
                              <Component handleNavigation={handleNavigation} context={publicPageContext} />
                            </motion.div>
                        }/>
                     ))}
                 </Routes>
              </AnimatePresence>
            </Suspense>
        </Layout>
        <Toaster />
    </div>
  );
}

export default App;