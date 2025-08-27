import React from 'react';
import { motion } from 'framer-motion';
import { Users, Store, ShieldCheck, UserCog, Briefcase, Search, CalendarCheck2, CreditCard, MessageSquare, Star, FileText, Headphones, UserPlus, HeartHandshake, ArrowLeft, DollarSign } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

const RoleCard = ({ icon: Icon, title, description, features, bgColor, buttonText, onButtonClick, iconColor = "text-white" }) => (
    <motion.div 
        className={`rounded-xl shadow-lg p-6 flex flex-col h-full ${bgColor}`}
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5 }}
        viewport={{ once: true, amount: 0.3 }}
    >
        <div className="flex items-center mb-4">
            <div className={`p-3 rounded-lg mr-4 ${iconColor.startsWith('text-') ? '' : bgColor.replace('bg-', 'bg-opacity-20 ')}`}>
                 <Icon className={`w-8 h-8 ${iconColor}`} />
            </div>
            <h3 className={`text-2xl font-bold ${iconColor.startsWith('text-') ? 'text-slate-800' : 'text-white'}`}>{title}</h3>
        </div>
        <p className={`mb-4 flex-grow ${iconColor.startsWith('text-') ? 'text-slate-600' : 'text-white/80'}`}>{description}</p>
        <ul className="space-y-2 mb-6">
            {features.map((feature, index) => (
                <li key={index} className="flex items-center">
                    <UserCog className={`w-5 h-5 ml-2 shrink-0 ${iconColor.startsWith('text-') ? 'text-primary' : 'text-white/90'}`} />
                    <span className={`${iconColor.startsWith('text-') ? 'text-slate-700' : 'text-white/90'}`}>{feature}</span>
                </li>
            ))}
        </ul>
        <Button 
            className={`w-full mt-auto ${iconColor.startsWith('text-') ? 'bg-primary text-white hover:bg-primary/90' : 'bg-white/90 text-primary hover:bg-white'}`}
            onClick={onButtonClick}
        >
            {buttonText} <ArrowLeft className="w-4 h-4 mr-2"/>
        </Button>
    </motion.div>
);

const JourneyStep = ({ icon: Icon, title, description, delay }) => (
    <motion.div 
        className="flex items-start gap-4 p-4 bg-white/80 backdrop-blur-sm rounded-lg shadow-sm border"
        initial={{ opacity: 0, x: -20 }}
        whileInView={{ opacity: 1, x: 0 }}
        transition={{ duration: 0.5, delay }}
        viewport={{ once: true, amount: 0.5 }}
    >
        <div className="bg-primary/10 text-primary p-3 rounded-md shrink-0">
            <Icon className="w-6 h-6" />
        </div>
        <div>
            <h4 className="font-semibold text-slate-800">{title}</h4>
            <p className="text-sm text-slate-600">{description}</p>
        </div>
    </motion.div>
);


const RolesAndJourneysPage = ({ handleNavigation }) => {
    const rolesData = [
        { 
            icon: Users, title: "العميل (باحث عن خدمة)", 
            description: "أنت العميل الذي يبحث عن أفضل الخدمات لمناسبته القادمة. منصة ليلة الليليوم توفر لك كل ما تحتاجه في مكان واحد.",
            features: ["بحث سهل ومقارنة بين الخدمات", "حجز ودفع آمن وموثوق", "توقيع عقود إلكترونية", "تقييم ومراجعة الخدمات", "تواصل مباشر مع مزوّدي الخدمات"],
            bgColor: "bg-sky-500", buttonText: "ابدأ رحلة البحث عن خدمة",
            onButtonClick: () => handleNavigation('services-showcase')
        },
        { 
            icon: Store, title: "مزوّد الخدمة (التاجر)", 
            description: "أنت صاحب القاعة، المصور، منسق الزهور، أو أي مزوّد خدمة آخر. انضم إلينا لتوسيع نطاق عملك والوصول لعملاء جدد.",
            features: ["لوحة تحكم شاملة لإدارة أعمالك", "نظام حجوزات وتقويم متقدم", "أدوات تسويق وترويج مدمجة", "تقارير وتحليلات أداء ذكية", "تسهيلات مالية وقانونية"],
            bgColor: "bg-purple-500", buttonText: "انضم كمزوّد خدمة",
            onButtonClick: () => handleNavigation('merchant-register')
        },
        { 
            icon: ShieldCheck, title: "مدير المنصة (الأدمن)", 
            description: "أنت المسؤول عن إدارة وتطوير منصة ليلة الليليوم. لديك الأدوات اللازمة لضمان سير العمل بسلاسة ونجاح.",
            features: ["إدارة شاملة للمستخدمين والخدمات", "مراقبة العمليات المالية والتقارير", "أدوات دعم فني وحل النزاعات", "إدارة المحتوى والتسويق للمنصة", "تطوير وتحسين مستمر للنظام"],
            bgColor: "bg-slate-700", buttonText: "دخول لوحة تحكم الأدمن",
            onButtonClick: () => handleNavigation('admin')
        },
    ];

    const customerJourney = [
        { icon: Search, title: "البحث والاكتشاف", description: "تصفح مئات الخدمات، قارن الأسعار، واقرأ التقييمات." },
        { icon: CalendarCheck2, title: "الحجز والتأكيد", description: "اختر الموعد المناسب، املأ التفاصيل، وأكد حجزك بسهولة." },
        { icon: CreditCard, title: "الدفع الآمن", description: "ادفع عبر بوابات دفع آمنة أو اختر خطط تمويل ميسرة." },
        { icon: FileText, title: "العقد الإلكتروني", description: "راجع ووقّع عقد الخدمة إلكترونيًا لحفظ حقوقك." },
        { icon: MessageSquare, title: "التواصل والتنسيق", description: "تواصل مباشرة مع مزوّد الخدمة لتنسيق كافة التفاصيل." },
        { icon: Star, title: "التقييم والمشاركة", description: "بعد انتهاء المناسبة، قيّم الخدمة وشارك تجربتك." },
    ];

    const merchantJourney = [
        { icon: UserPlus, title: "التسجيل والانضمام", description: "أنشئ حسابك كمزوّد خدمة وقدم معلومات نشاطك التجاري." },
        { icon: Briefcase, title: "إضافة وإدارة الخدمات", description: "أضف خدماتك، حدد الأسعار، وارفع صورًا جذابة." },
        { icon: CalendarCheck2, title: "استقبال وإدارة الحجوزات", description: "استقبل الحجوزات عبر لوحة التحكم، وأدر تقويم التوفر." },
        { icon: Headphones, title: "التواصل مع العملاء", description: "رد على استفسارات العملاء ونسّق معهم تفاصيل الخدمة." },
        { icon: DollarSign, title: "إدارة المدفوعات والأرباح", description: "استقبل مدفوعاتك بأمان واسحب أرباحك بسهولة." },
        { icon: HeartHandshake, title: "بناء السمعة وزيادة العملاء", description: "احصل على تقييمات إيجابية ووسع قاعدة عملائك." },
    ];

    return (
        <div className="min-h-screen bg-slate-50 py-16">
            <div className="container mx-auto px-4">
                <motion.div 
                    className="text-center mb-16"
                    initial={{ opacity: 0, y: -30 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.7 }}
                >
                    <h1 className="text-4xl md:text-5xl font-extrabold gradient-text mb-4">الأدوار ورحلات المستخدمين في ليلة الليليوم</h1>
                    <p className="text-lg text-slate-600 max-w-3xl mx-auto">
                        نفهم احتياجات كل مستخدم ونقدم تجربة مخصصة. تعرّف على دورك في المنصة والرحلة التي تنتظرك.
                    </p>
                </motion.div>

                <div className="grid lg:grid-cols-3 gap-8 mb-20">
                    {rolesData.map((role, index) => (
                        <RoleCard key={index} {...role} />
                    ))}
                </div>

                <Tabs defaultValue="customerJourney" dir="rtl">
                    <TabsList className="grid w-full grid-cols-2 md:w-1/2 mx-auto mb-10 bg-primary/10 p-1.5 rounded-lg">
                        <TabsTrigger value="customerJourney" className="py-2.5 text-base data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-md">رحلة العميل</TabsTrigger>
                        <TabsTrigger value="merchantJourney" className="py-2.5 text-base data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-md">رحلة مزوّد الخدمة</TabsTrigger>
                    </TabsList>
                    <TabsContent value="customerJourney">
                        <motion.div
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ staggerChildren: 0.1, delayChildren: 0.2 }}
                        >
                            <h2 className="text-3xl font-bold text-center text-slate-800 mb-8">خطوات بسيطة لتنظيم مناسبتك المثالية</h2>
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                {customerJourney.map((step, index) => (
                                    <JourneyStep key={index} {...step} delay={index * 0.1} />
                                ))}
                            </div>
                        </motion.div>
                    </TabsContent>
                    <TabsContent value="merchantJourney">
                         <motion.div
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ staggerChildren: 0.1, delayChildren: 0.2 }}
                        >
                            <h2 className="text-3xl font-bold text-center text-slate-800 mb-8">انطلق نحو النجاح مع منصة ليلة الليليوم</h2>
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                {merchantJourney.map((step, index) => (
                                    <JourneyStep key={index} {...step} delay={index * 0.1} />
                                ))}
                            </div>
                        </motion.div>
                    </TabsContent>
                </Tabs>
            </div>
        </div>
    );
};

export default RolesAndJourneysPage;