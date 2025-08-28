import React from 'react';
import { motion } from 'framer-motion';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Users, Store, ShieldCheck, QrCode, Ticket, CreditCard, Languages, Star, Settings, Briefcase, FileText, Percent, Headphones, Users2, CheckCircle, UserCog, Calculator, Headphones as Headset, UserCheck as UserCheckIcon, Activity, UserPlus } from 'lucide-react';

const FeatureCard = ({ icon: Icon, title, description, delay, iconBgColor = 'gradient-bg' }) => (
    <motion.div
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5, delay }}
        viewport={{ once: true, amount: 0.5 }}
        className="bg-white p-6 rounded-2xl shadow-lg card-hover h-full text-center"
    >
        <div className={`w-16 h-16 ${iconBgColor} rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md`}>
            <Icon className="h-8 w-8 text-white" />
        </div>
        <h3 className="text-lg font-bold text-gray-800 mb-2">{title}</h3>
        <p className="text-gray-600 text-sm leading-relaxed">{description}</p>
    </motion.div>
);

const PlatformStaffCard = ({ icon: Icon, role, features, delay }) => (
    <motion.div
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5, delay }}
        viewport={{ once: true, amount: 0.5 }}
        className="bg-white p-6 rounded-2xl shadow-lg h-full border-t-4 border-primary"
    >
        <div className="flex items-center mb-4">
            <div className="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center ml-4 shadow-md">
                <Icon className="h-6 w-6 text-white" />
            </div>
            <h3 className="text-lg font-bold text-gray-800">{role}</h3>
        </div>
        <p className="text-gray-600 text-sm leading-relaxed">{features}</p>
    </motion.div>
);


const FeaturesPage = ({ handleFeatureClick }) => {

    const clientFeatures = [
        { icon: Ticket, title: "مرونة الحجز", description: "احجز كزائر أو بحساب، اختر مقعدك من مخطط تفاعلي، أو حدد طاولتك ووقتها في المطاعم بكل سهولة.", iconBgColor: "bg-sky-500" },
        { icon: CreditCard, title: "دفع إلكتروني آمن", description: "ندعم كافة طرق الدفع: بطاقات ائتمan، Apple Pay، والتحويل البنكي، لتجربة دفع سلسة وموثوقة.", iconBgColor: "bg-emerald-500" },
        { icon: QrCode, title: "استلام فوري للتذاكر", description: "استلم تذاكرك فوراً بعد الدفع عبر الإيميل، مع دعم إضافتها إلى محافظ Apple و Google.", iconBgColor: "bg-indigo-500" },
        { icon: Settings, title: "إدارة الحجوزات", description: "ألغِ أو عدّل حجزك (حسب سياسة التاجر)، واطلع على سجل حجوزاتك السابقة في أي وقت.", iconBgColor: "bg-slate-600" },
        { icon: Languages, title: "واجهة ثنائية اللغة", description: "استخدم المنصة باللغة العربية أو الإنجليزية لتجربة مريحة ومخصصة لك.", iconBgColor: "bg-amber-500" },
        { icon: Star, title: "برنامج النقاط والمكافآت", description: "اجمع نقاطاً مع كل حجز واستبدلها بمكافآت وخصومات حصرية من التجار المشاركين.", iconBgColor: "bg-rose-500" }
    ];

    const merchantFeatures = [
        { icon: Store, title: "موقع خاص (Subdomain)", description: "امتلك نطاقاً فرعياً خاصاً وهوية بصرية كاملة تعكس علامتك التجارية.", iconBgColor: "bg-blue-500" },
        { icon: Briefcase, title: "إدارة متكاملة للخدمات", description: "أضف فعالياتك، مطاعمك، أو معارضك، وحدد الأسعار والأوقات، مع دعم للمخططات التفاعلية.", iconBgColor: "bg-green-500" },
        { icon: FileText, title: "إدارة الحجوزات والدخل", description: "تحكم كامل في حجوزاتك، وتابع دخلك، واسحب أرباحك بسهولة وأمان.", iconBgColor: "bg-purple-500" },
        { icon: Users2, title: "إدارة الفريق والصلاحيات", description: "ادعُ فريق عملك وحدد صلاحيات كل فرد (مشرف، مدقق، دعم فني) بكفاءة.", iconBgColor: "bg-cyan-500" },
        { icon: Percent, title: "أنظمة الترويج والتسويق", description: "أنشئ روابط تسويق خاصة واربط حساباتك على الشبكات الاجتماعية لزيادة مبيعاتك.", iconBgColor: "bg-pink-500" },
        { icon: Headphones, title: "POS – البيع من المقر", description: "أصدر تذاكر وسجل عمليات الدفع اليدوي مباشرة من مقر عملك بكل سلاسة.", iconBgColor: "bg-orange-500" }
    ];

    const platformStaff = [
        { role: "مدير المنصة", icon: UserCog, features: "صلاحيات كاملة لإدارة كل جوانب المنصة: التجار، العمولات، التقارير، والنطاقات." },
        { role: "مشرف", icon: UserCheckIcon, features: "يدير الموظفين، يراقب أداء وحسابات التجار، ويتابع تذاكر الدعم الفني." },
        { role: "أخصائي حسابات", icon: FileText, features: "يراجع وثائق وبيانات التجار البنكية ويقوم بتنفيذ عمليات سحب الأرباح." },
        { role: "محاسب", icon: Calculator, features: "ينفذ عمليات الدفع للتجار، يعد التقارير المالية، ويتتبع التحصيلات والعمولات." },
        { role: "أخصائي دعم", icon: Headset, features: "يجيب على استفسارات العملاء والتجار، مع صلاحيات محدودة لا تشمل البيانات المالية." },
        { role: "أخصائي عمليات", icon: Activity, features: "يتابع الفعاليات والطلبات وعمليات الإلغاء والاسترجاع لضمان سلاسة العمل." },
        { role: "مندوب مبيعات", icon: UserPlus, features: "يركز على جلب تجار جدد ويحصل على عمولة من العمليات التي تتم عن طريقه." }
    ];

    return (
        <div className="min-h-screen bg-slate-50 py-16">
            <div className="container mx-auto px-4">
                <motion.div
                    initial={{ opacity: 0, y: 30 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6 }}
                    className="text-center mb-12"
                >
                    <h1 className="text-4xl md:text-5xl font-extrabold gradient-text mb-4">مميزات لكل مستخدم</h1>
                    <p className="text-lg text-slate-600 max-w-3xl mx-auto">
                        نقدم مجموعة أدوات ومميزات مخصصة لكل دور في المنصة، لضمان تجربة سلسة ومتكاملة للجميع.
                    </p>
                </motion.div>

                <Tabs defaultValue="client" className="w-full" dir="rtl">
                    <TabsList className="grid w-full grid-cols-1 sm:grid-cols-3 gap-2 h-auto p-2 bg-primary/10 rounded-xl">
                        <TabsTrigger value="client" className="flex items-center gap-2 text-sm md:text-base py-2.5"><Users className="h-5 w-5"/>العميل</TabsTrigger>
                        <TabsTrigger value="merchant" className="flex items-center gap-2 text-sm md:text-base py-2.5"><Store className="h-5 w-5"/>التاجر</TabsTrigger>
                        <TabsTrigger value="platform_staff" className="flex items-center gap-2 text-sm md:text-base py-2.5"><ShieldCheck className="h-5 w-5"/>إدارة المنصة</TabsTrigger>
                    </TabsList>
                    
                    <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} transition={{ duration: 0.5 }}>
                        <TabsContent value="client" className="mt-10">
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {clientFeatures.map((feature, index) => (
                                    <FeatureCard key={index} {...feature} delay={index * 0.1} />
                                ))}
                            </div>
                        </TabsContent>
                        <TabsContent value="merchant" className="mt-10">
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {merchantFeatures.map((feature, index) => (
                                    <FeatureCard key={index} {...feature} delay={index * 0.1} />
                                ))}
                            </div>
                        </TabsContent>
                        <TabsContent value="platform_staff" className="mt-10">
                             <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {platformStaff.map((staffMember, index) => (
                                    <PlatformStaffCard key={index} {...staffMember} delay={index * 0.1} />
                                ))}
                            </div>
                        </TabsContent>
                    </motion.div>
                </Tabs>
            </div>
        </div>
    );
};

export default FeaturesPage;