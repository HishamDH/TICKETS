import React, { useState, useEffect, Suspense, lazy, useMemo, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    LayoutDashboard, Ticket, Wallet, Palette, Users as UsersIcon, BarChart3, MessageSquare, History, 
    QrCode, Printer, Building, Tag, GitBranch, Bell, Star, Code, Globe, BrainCircuit, Settings, 
    PackageSearch, FileSignature, Users2 as TeamIcon, CalendarClock, CreditCard, ShoppingBag, 
    Newspaper, Menu, X, Shield, BookOpen, LifeBuoy, Image as ImageIcon, ListOrdered, Info,
    PlusCircle, XCircle, PackagePlus, FileText, Share2, Edit3, UserCheck, Mail, HeartHandshake,
    LogIn, AlertTriangle, HelpCircle, Clock
} from 'lucide-react';

import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Button } from '@/components/ui/button';
import { useToast } from "@/components/ui/use-toast";
import PageHelmet from '@/components/layout/PageHelmet';
import { Skeleton } from '@/components/ui/skeleton';

const Sidebar = lazy(() => import('@/components/merchant-dashboard/Sidebar'));
const OverviewContent = lazy(() => import('@/components/merchant-dashboard/Overview'));
const ServiceManagementContent = lazy(() => import('@/components/merchant-dashboard/ServiceManagement'));
const BookingsManagementContent = lazy(() => import('@/components/merchant-dashboard/BookingsManagement'));
const WalletContent = lazy(() => import('@/components/merchant-dashboard/Wallet'));
const TeamManagementContent = lazy(() => import('@/components/merchant-dashboard/TeamManagement'));
const AppearanceContent = lazy(() => import('@/components/merchant-dashboard/Appearance'));
const ReportsContent = lazy(() => import('@/components/merchant-dashboard/Reports'));
const PoliciesContent = lazy(() => import('@/components/merchant-dashboard/Policies'));
const MessagesContent = lazy(() => import('@/components/merchant-dashboard/Messages'));
const AuditLogContent = lazy(() => import('@/components/merchant-dashboard/AuditLog'));
const CheckInContent = lazy(() => import('@/components/merchant-dashboard/CheckIn'));
const PosContent = lazy(() => import('@/components/merchant-dashboard/PosContent'));
const GroupBookingContent = lazy(() => import('@/components/merchant-dashboard/GroupBookingContent'));
const PromotionsContent = lazy(() => import('@/components/merchant-dashboard/PromotionsContent'));
const TimedPromotionsContent = lazy(() => import('@/components/merchant-dashboard/TimedPromotionsContent'));
const BranchManagementContent = lazy(() => import('@/components/merchant-dashboard/BranchManagementContent'));
const NotificationsManagementContent = lazy(() => import('@/components/merchant-dashboard/NotificationsManagementContent'));
const ReviewsManagementContent = lazy(() => import('@/components/merchant-dashboard/ReviewsManagementContent'));
const ApiIntegrationsContent = lazy(() => import('@/components/merchant-dashboard/ApiIntegrationsContent'));
const LocalizationContent = lazy(() => import('@/components/merchant-dashboard/LocalizationContent'));
const AdvancedAnalyticsContent = lazy(() => import('@/components/merchant-dashboard/AdvancedAnalyticsContent'));
const ContractsManagementContent = lazy(() => import('@/components/merchant-dashboard/ContractsManagement')); 
const MerchantProfileContent = lazy(() => import('@/components/merchant-dashboard/MerchantProfileContent'));
const PaymentHistoryContent = lazy(() => import('@/components/merchant-dashboard/PaymentHistoryContent'));
const BankAccountSetupContent = lazy(() => import('@/components/merchant-dashboard/BankAccountSetupContent'));
const SecureLoginSettingsContent = lazy(() => import('@/components/merchant-dashboard/SecureLoginSettingsContent'));
const ManualBookingContent = lazy(() => import('@/components/merchant-dashboard/ManualBookingContent'));
const IndividualServicesContent = lazy(() => import('@/components/merchant-dashboard/IndividualServicesContent'));
const ServiceAddonsContent = lazy(() => import('@/components/merchant-dashboard/ServiceAddonsContent'));
const LoyaltyProgramContent = lazy(() => import('@/components/merchant-dashboard/LoyaltyProgramContent'));
const HelpCenterContent = lazy(() => import('@/components/merchant-dashboard/HelpCenterContent'));
const SupportTicketContent = lazy(() => import('@/components/merchant-dashboard/SupportTicketContent'));
const DateLockingContent = lazy(() => import('@/components/merchant-dashboard/DateLockingContent'));
const ContractTemplatesContent = lazy(() => import('@/components/merchant-dashboard/ContractTemplatesContent'));
const SocialMediaIntegrationContent = lazy(() => import('@/components/merchant-dashboard/SocialMediaIntegrationContent'));
const LoginHistoryContent = lazy(() => import('@/components/merchant-dashboard/LoginHistoryContent'));
const ServicesOrderContent = lazy(() => import('@/components/merchant-dashboard/ServicesOrderContent'));
const AboutUsSectionContent = lazy(() => import('@/components/merchant-dashboard/AboutUsSectionContent'));
const OnlineSalesToggleContent = lazy(() => import('@/components/merchant-dashboard/OnlineSalesToggleContent'));
const SharePackageLinkContent = lazy(() => import('@/components/merchant-dashboard/SharePackageLinkContent'));
const InternalCustomerRatingContent = lazy(() => import('@/components/merchant-dashboard/InternalCustomerRatingContent'));
const EmailCampaignsContent = lazy(() => import('@/components/merchant-dashboard/EmailCampaignsContent'));
const ErrorReviewContent = lazy(() => import('@/components/merchant-dashboard/ErrorReviewContent'));
const SmartPricingContent = lazy(() => import('@/components/merchant-dashboard/SmartPricingContent'));

const LoadingFallback = React.memo(() => (
  <div className="p-4 sm:p-6 lg:p-8">
    <div className="space-y-4">
      <Skeleton className="h-10 w-1/3 bg-slate-200" />
      <Skeleton className="h-6 w-1/2 bg-slate-200" />
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
        <Skeleton className="h-24 w-full bg-slate-200" />
        <Skeleton className="h-24 w-full bg-slate-200" />
        <Skeleton className="h-24 w-full bg-slate-200" />
        <Skeleton className="h-24 w-full bg-slate-200" />
      </div>
      <Skeleton className="h-64 w-full bg-slate-200" />
    </div>
  </div>
));

const dashboardItems = [
    { id: 'general_basics_title', title: 'الأساسيات العامة', isTitle: true },
    { id: 'overview', title: 'نظرة عامة', icon: LayoutDashboard, component: OverviewContent, category: 'general_basics' },
    { id: 'notifications_settings', title: 'الإشعارات الذكية', icon: Bell, component: NotificationsManagementContent, category: 'general_basics' },
    { id: 'merchant_profile', title: 'الملف الشخصي للتاجر', icon: UsersIcon, component: MerchantProfileContent, category: 'general_basics' },

    { id: 'bookings_calendar_title', title: 'إدارة الحجوزات والتقويم', isTitle: true },
    { id: 'bookings_management', title: 'تقويم الحجوزات والتوفر', icon: CalendarClock, component: BookingsManagementContent, category: 'bookings_calendar' },
    { id: 'manual_booking', title: 'إضافة حجز يدوي', icon: PlusCircle, component: ManualBookingContent, category: 'bookings_calendar' },
    { id: 'date_locking', title: 'إغلاق تاريخ/فترة', icon: XCircle, component: DateLockingContent, category: 'bookings_calendar' },

    { id: 'packages_services_title', title: 'إدارة الباقات والخدمات', isTitle: true },
    { id: 'services_management', title: 'إدارة الخدمات والباقات', icon: Ticket, component: ServiceManagementContent, category: 'packages_services' },
    { id: 'individual_services', title: 'إدارة الخدمات الفردية', icon: PackageSearch, component: IndividualServicesContent, category: 'packages_services' },
    { id: 'service_addons', title: 'إدارة الإضافات (Add-ons)', icon: PackagePlus, component: ServiceAddonsContent, category: 'packages_services' },

    { id: 'ecommerce_system_title', title: 'نظام البيع الإلكتروني', isTitle: true },
    { id: 'online_sales_toggle', title: 'تفعيل البيع أونلاين', icon: Globe, component: OnlineSalesToggleContent, category: 'ecommerce_system' },
    { id: 'sales_terms_conditions', title: 'شروط وأحكام البيع', icon: FileText, component: PoliciesContent, category: 'ecommerce_system' }, 
    { id: 'bookings_comparison', title: 'مقارنة الحجوزات', icon: BarChart3, component: ReportsContent, category: 'ecommerce_system' }, 
    { id: 'share_package_link', title: 'مشاركة رابط باقة/دفع', icon: Share2, component: SharePackageLinkContent, category: 'ecommerce_system' },

    { id: 'finance_wallet_title', title: 'النظام المالي والمحفظة', isTitle: true },
    { id: 'wallet_management', title: 'عرض المحفظة والسحب', icon: Wallet, component: WalletContent, category: 'finance_wallet' },
    { id: 'payment_history', title: 'سجل المدفوعات والعمولات', icon: History, component: PaymentHistoryContent, category: 'finance_wallet' },
    { id: 'bank_account_setup', title: 'ربط الحساب البنكي', icon: CreditCard, component: BankAccountSetupContent, category: 'finance_wallet' },

    { id: 'contracts_signatures_title', title: 'العقود والتواقيع', isTitle: true },
    { id: 'contracts_management', title: 'إدارة العقود الإلكترونية', icon: FileSignature, component: ContractsManagementContent, category: 'contracts_signatures' },
    { id: 'contract_templates', title: 'قوالب عقود مخصصة', icon: Edit3, component: ContractTemplatesContent, category: 'contracts_signatures' },

    { id: 'reviews_reports_title', title: 'التقييمات والتقارير', isTitle: true },
    { id: 'customer_reviews', title: 'تقييمات العملاء والردود', icon: Star, component: ReviewsManagementContent, category: 'reviews_reports' },
    { id: 'internal_customer_rating', title: 'تقييم داخلي للعملاء', icon: UserCheck, component: InternalCustomerRatingContent, category: 'reviews_reports' },
    { id: 'performance_reports', title: 'تقارير الأداء والتحليلات', icon: BarChart3, component: ReportsContent, category: 'reviews_reports' }, 
    { id: 'advanced_analytics', title: 'التحليلات المتقدمة والذكاء الاصطناعي', icon: BrainCircuit, component: AdvancedAnalyticsContent, category: 'reviews_reports' },

    { id: 'team_management_title', title: 'إدارة الفريق والصلاحيات', isTitle: true },
    { id: 'staff_management', title: 'إدارة الموظفين والمساعدين', icon: TeamIcon, component: TeamManagementContent, category: 'team_management' },
    { id: 'audit_log', title: 'سجل نشاط الفريق', icon: History, component: AuditLogContent, category: 'team_management' },

    { id: 'marketing_promotions_title', title: 'التسويق والعروض', isTitle: true },
    { id: 'timed_promotions', title: 'العروض المؤقتة', icon: Clock, component: TimedPromotionsContent, category: 'marketing_promotions' },
    { id: 'promotions_management', title: 'إنشاء كوبونات وعروض', icon: Tag, component: PromotionsContent, category: 'marketing_promotions' },
    { id: 'smart_pricing', title: 'التسعير الديناميكي (تجريبي)', icon: BrainCircuit, component: SmartPricingContent, category: 'marketing_promotions' },
    { id: 'social_media_integration', title: 'ربط ومشاركة عبر السوشيال ميديا', icon: Share2, component: SocialMediaIntegrationContent, category: 'marketing_promotions' },
    { id: 'email_campaigns', title: 'حملات بريدية للعملاء', icon: Mail, component: EmailCampaignsContent, category: 'marketing_promotions' },
    { id: 'loyalty_program', title: 'برنامج ولاء العملاء', icon: HeartHandshake, component: LoyaltyProgramContent, category: 'marketing_promotions' },
    
    { id: 'security_control_title', title: 'الأمان والتحكم', isTitle: true },
    { id: 'secure_login_settings', title: 'إعدادات تسجيل الدخول الآمن', icon: Shield, component: SecureLoginSettingsContent, category: 'security_control' },
    { id: 'login_history', title: 'سجل الدخول للحساب', icon: LogIn, component: LoginHistoryContent, category: 'security_control' },
    { id: 'error_review', title: 'مراجعة الأخطاء والمشاكل', icon: AlertTriangle, component: ErrorReviewContent, category: 'security_control' },

    { id: 'support_help_title', title: 'الدعم الفني والمساعدة', isTitle: true },
    { id: 'help_center', title: 'مركز المساعدة وقاعدة المعرفة', icon: BookOpen, component: HelpCenterContent, category: 'support_help' },
    { id: 'support_ticket', title: 'فتح تذكرة دعم فني', icon: LifeBuoy, component: SupportTicketContent, category: 'support_help' },
    { id: 'faq', title: 'الأسئلة الشائعة', icon: HelpCircle, component: HelpCenterContent, category: 'support_help' },

    { id: 'appearance_customization_title', title: 'تخصيص مظهر الصفحة العامة', isTitle: true },
    { id: 'public_page_appearance', title: 'الألوان، الشعار، والغلاف', icon: Palette, component: AppearanceContent, category: 'appearance_customization' },
    { id: 'services_order', title: 'ترتيب عرض الخدمات والباقات', icon: ListOrdered, component: ServicesOrderContent, category: 'appearance_customization' },
    { id: 'about_us_section', title: 'إضافة قسم "نبذة عنا"', icon: Info, component: AboutUsSectionContent, category: 'appearance_customization' },
    
    { id: 'additional_features_title', title: 'إعدادات وميزات إضافية', isTitle: true },
    { id: 'branch_management', title: 'إدارة الفروع (إذا متعددة)', icon: GitBranch, component: BranchManagementContent, category: 'additional_features' },
    { id: 'check_in_pos', title: 'التحقق من الحضور (Check-in)', icon: QrCode, component: CheckInContent, category: 'additional_features' }, 
    { id: 'pos_system', title: 'نظام البيع الداخلي (POS)', icon: Printer, component: PosContent, category: 'additional_features' },
    { id: 'group_booking_system', title: 'نظام حجز الشركات', icon: Building, component: GroupBookingContent, category: 'additional_features' },
    { id: 'policies_settings', title: 'السياسات العامة للمنصة', icon: Settings, component: PoliciesContent, category: 'additional_features' },
    { id: 'localization_settings', title: 'اللغات والترجمة للمحتوى', icon: Globe, component: LocalizationContent, category: 'additional_features' },
    { id: 'api_integrations', title: 'الربط البرمجي (API)', icon: Code, component: ApiIntegrationsContent, category: 'additional_features' },
    { id: 'messages', title: 'مركز الرسائل مع العملاء', icon: MessageSquare, component: MessagesContent, category: 'additional_features' },
];

const branches = [
    { id: 'all', name: 'كل الفروع' },
    { id: 'riyadh', name: 'قاعة الرياض للمناسبات' },
    { id: 'jeddah', name: 'استوديو جدة للتصوير' },
    { id: 'dammam', name: 'مطبخ الدمام للضيافة' },
];

const MerchantDashboard = ({ handleNavigation }) => {
    const [activeTab, setActiveTab] = useState('overview');
    const [selectedBranch, setSelectedBranch] = useState('all');
    const [isSidebarOpen, setSidebarOpen] = useState(window.innerWidth >= 768);
    const { toast } = useToast();

    useEffect(() => {
        const handleResize = () => {
            if (window.innerWidth < 768) {
                setSidebarOpen(false);
            } else {
                setSidebarOpen(true);
            }
        };
        window.addEventListener('resize', handleResize);
        handleResize(); 
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    const handleGlobalFeatureClick = useCallback((featureName, source = "غير محدد") => {
        toast({
            title: "تم بنجاح",
            description: `تم تنفيذ الإجراء: ${featureName} من ${source}.`,
        });
    }, [toast]);

    const currentDashboardItem = useMemo(() => {
      return dashboardItems.find(item => item.id === activeTab && !item.isTitle);
    }, [activeTab]);
    
    const ActiveComponent = useMemo(() => {
        return currentDashboardItem?.component;
    }, [currentDashboardItem]);

    const { activeComponentTitle, activeComponentIcon, activeComponentDescription } = useMemo(() => {
        const item = currentDashboardItem || dashboardItems.find(i => i.id === activeTab);
        return {
            activeComponentTitle: item?.title || "صفحة غير موجودة",
            activeComponentIcon: item?.icon || Ticket,
            activeComponentDescription: item?.description || "هذه الميزة قيد التطوير حاليًا."
        };
    }, [currentDashboardItem, activeTab]);
    
    const onFeatureClickForActiveComponent = useCallback((featureName) => {
        handleGlobalFeatureClick(featureName, activeComponentTitle);
    }, [handleGlobalFeatureClick, activeComponentTitle]);
    
    return (
        <div className="min-h-screen bg-slate-100 flex" dir="rtl">
            <PageHelmet title={`لوحة تحكم مزود الخدمة: ${activeComponentTitle}`} description={`إدارة ${activeComponentTitle} في لوحة تحكم مزود الخدمة.`}/>
            
            <Suspense fallback={null}>
                <Sidebar activeTab={activeTab} setActiveTab={setActiveTab} dashboardItems={dashboardItems} isSidebarOpen={isSidebarOpen} />
            </Suspense>

            <main className={`flex-1 overflow-y-auto flex flex-col transition-all duration-300 ${isSidebarOpen ? 'mr-0 md:mr-72 xl:mr-80' : 'mr-0'}`}>
                <header className="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                    <div className="flex items-center gap-4">
                        <Button variant="ghost" size="icon" onClick={() => setSidebarOpen(!isSidebarOpen)} className="text-slate-600">
                            {isSidebarOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
                        </Button>
                        <div className="w-52 sm:w-64">
                             <Select defaultValue="all" onValueChange={(value) => { setSelectedBranch(value); handleGlobalFeatureClick(`تغيير الفرع إلى ${branches.find(b => b.id === value)?.name}`, "قائمة الفروع"); }} dir="rtl">
                                <SelectTrigger className="w-full">
                                    <GitBranch className="h-4 w-4 ml-2 text-slate-500" />
                                    <SelectValue placeholder="اختر الفرع/الخدمة..." />
                                </SelectTrigger>
                                <SelectContent>
                                    {branches.map(branch => (
                                        <SelectItem key={branch.id} value={branch.id}>{branch.name}</SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                     <div className="flex items-center gap-2 sm:gap-4">
                        <Button variant="ghost" size="icon" className="relative text-slate-600" onClick={() => { setActiveTab('notifications_settings'); handleGlobalFeatureClick('عرض الإشعارات', "زر الإشعارات"); }}>
                            <Bell className="w-5 h-5" />
                            <span className="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </Button>
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Avatar className="cursor-pointer h-9 w-9">
                                    <AvatarImage src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?q=80&w=200" alt="Merchant" />
                                    <AvatarFallback>م</AvatarFallback>
                                </Avatar>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" dir="rtl">
                                <DropdownMenuLabel>حساب مزوّد الخدمة</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem onClick={() => { setActiveTab('merchant_profile'); handleGlobalFeatureClick('الملف التعريفي للنشاط', 'قائمة المستخدم'); }}>الملف التعريفي للنشاط</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => { setActiveTab('policies_settings'); handleGlobalFeatureClick('الإعدادات', 'قائمة المستخدم'); }}><Settings className="w-4 h-4 ml-2" />الإعدادات</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem className="text-red-500" onClick={() => { handleNavigation('home'); handleGlobalFeatureClick('تسجيل الخروج', 'قائمة المستخدم'); }}>تسجيل الخروج</DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </header>
                <div className="flex-1 p-4 sm:p-6 lg:p-8">
                    <Suspense fallback={<LoadingFallback />}>
                        <AnimatePresence mode="wait">
                            <motion.div
                                key={`${activeTab}-${selectedBranch}`}
                                initial={{ opacity: 0, y: 20 }}
                                animate={{ opacity: 1, y: 0 }}
                                exit={{ opacity: 0, y: -20 }}
                                transition={{ duration: 0.3 }}
                            >
                                {ActiveComponent && <ActiveComponent 
                                    handleNavigation={handleNavigation} 
                                    onFeatureClick={onFeatureClickForActiveComponent}
                                    handleFeatureClick={onFeatureClickForActiveComponent} 
                                    selectedBranch={selectedBranch} 
                                    title={activeComponentTitle}
                                    icon={activeComponentIcon}
                                    description={activeComponentDescription}
                                />}
                            </motion.div>
                        </AnimatePresence>
                    </Suspense>
                </div>
            </main>
        </div>
    );
};

export default React.memo(MerchantDashboard);