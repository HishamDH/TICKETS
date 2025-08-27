import React from 'react';
import { motion } from 'framer-motion';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { 
    Brain, CreditCard, FileSignature, Package, BarChart3, Users, Bell, PackageSearch, ThumbsUp, Share2, ShieldCheck, Cpu, Settings2, Smartphone, Gem,
    ChevronLeft, Store, MessageSquare, UserCog, Calculator, Headphones, UserPlus, HeartHandshake, FileText, Search, Ticket, Star
} from 'lucide-react';
import { Button } from '@/components/ui/button';
import { useToast } from "@/components/ui/use-toast";

const FeatureItem = ({ icon: Icon, title, description, iconBgColor = 'gradient-bg', onClick }) => {
    const { toast } = useToast();
    const handleClick = () => {
        if (onClick) {
            onClick();
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${title}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
                variant: "default",
            });
        }
    };

    return (
    <motion.div
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5, delay: 0.1 }}
        viewport={{ once: true, amount: 0.3 }}
        className="bg-white p-6 rounded-2xl shadow-lg card-hover h-full text-center flex flex-col items-center cursor-pointer"
        onClick={handleClick}
    >
        <div className={`w-16 h-16 ${iconBgColor} rounded-2xl flex items-center justify-center mb-5 shadow-md`}>
            <Icon className="h-8 w-8 text-white" />
        </div>
        <h3 className="text-lg font-bold text-gray-800 mb-2">{title}</h3>
        <p className="text-gray-600 text-sm leading-relaxed flex-grow">{description}</p>
        <Button variant="link" className="mt-4 text-primary">
            اعرف المزيد <ChevronLeft className="w-4 h-4 mr-1" />
        </Button>
    </motion.div>
    );
};

const FeaturesPage = ({ handleNavigation }) => {

    const mainFeatures = [
        { icon: Brain, title: "منصة ذكية شاملة", description: "تجمع كل خدمات المناسبات في مكان واحد: قاعات، تصوير، ورد، ضيافة، تمويل، عقود، تقييمات. تدعم مزوّدي الخدمات بمختلف أحجامهم." },
        { icon: CreditCard, title: "الدفع والتمويل المرن", description: "دعم الدفع الإلكتروني مع خصومات تلقائية وخطط تمويل من شركاء (تمارا، تابي...). تسوية تلقائية للأرباح بين المزودين." },
        { icon: FileSignature, title: "عقود إلكترونية مدمجة", description: "توقيع العقود إلكترونيًا من الطرفين داخل المنصة، مع توثيق عبر DocuSign/HelloSign وأرشفة سهلة." },
        { icon: Package, title: "نظام باقات متكامل", description: "إنشاء باقات تجمع أكثر من مزود (قاعة + تصوير + زينة…) مع توزيع أرباح تلقائي ورسوم اختيارية." },
        { icon: BarChart3, title: "لوحات تحكم متقدمة", description: "لوحة لكل نوع مستخدم (مزود – عميل – مدير) تعرض بيانات الحجوزات، التقييمات، الأرباح، وتقارير مخصصة وتحليلات ذكية." },
        { icon: Users, title: "نظام CRM وتفاعل شخصي", description: "ملف كامل لكل عميل مع سجل تفاعلاته، حملات ترويجية تلقائية، وملاحظات داخلية للمزود." },
        { icon: Bell, title: "نظام إشعارات وتنبيهات احترافي", description: "إشعارات فورية للعميل والمزود، تنبيهات بانخفاض المخزون، وتذكيرات بالمواعيد والمدفوعات." },
        { icon: PackageSearch, title: "إدارة المخزون والخدمات اللوجستية", description: "تتبع المخزون (ورود، طعام، هدايا) مع تنبيهات بإعادة الطلب، ودعم إدارة التسليم ونقل المعدات." },
        { icon: ThumbsUp, title: "تجربة مستخدم متميزة", description: "تصميم سهل وجذاب باللغة العربية، واجهات مخصصة، ودعم متكامل للجوال والكمبيوتر." },
        { icon: Share2, title: "التسويق والترويج الداخلي", description: "إنشاء عروض وخصومات ونشرها عبر المنصة أو السوشيال ميديا، مع تكامل مباشر ودعم كوبونات." },
        { icon: ShieldCheck, title: "أمان عالي وحوكمة رقمية", description: "نظام صلاحيات RBAC، حماية بيانات بتشفير HTTPS، نسخ احتياطي، ومراجعة نزاعات داخلية." },
        { icon: Cpu, title: "التحليلات والذكاء الاصطناعي", description: "تقارير مبيعات حسب الموسم، تحليل الحجوزات الرائجة، وتوصيات للمزودين بناءً على الأداء." },
        { icon: Settings2, title: "مرونة تشغيلية عالية", description: "دعم أنواع متعددة من المناسبات، تخصيص النظام حسب نوع المزود، وإدارة عدد الزوار وتكلفة إضافية تلقائية." },
        { icon: Smartphone, title: "جاهزية للتوسع مستقبلاً", description: "إمكانية تطوير تطبيق جوال (iOS/Android)، دعم التكامل مع أنظمة محاسبة خارجية أو ERP، وبنية قابلة للنمو." },
        { icon: Gem, title: "ميزات قانونية وتشغيلية احترافية", description: "مكتبة عقود قانونية جاهزة، تصعيد تلقائي للنزاعات، وتسجيل كل المعاملات بسجل قابل للتدقيق." },
    ];
    
    const platformFeatures = [
      { icon: Users, title: "للعملاء", description: "بحث سهل، حجز ذكي، دفع آمن وتمويل، توقيع عقود إلكتروني، تقييم ومراجعات، تواصل مباشر مع المزودين.", iconBgColor: "bg-sky-500", targetView: "roles" },
      { icon: Store, title: "لمزوّدي الخدمات", description: "لوحة تحكم شاملة، إدارة مخزون، باقات مشتركة، تقارير وتحليلات، أدوات تسويق، خدمات قانونية متكاملة.", iconBgColor: "bg-purple-500", targetView: "merchant-journey" },
      { icon: ShieldCheck, title: "لإدارة المنصة", description: "صلاحيات كاملة، إدارة المزودين والعملاء، مراقبة مالية، دعم فني، تسويق وشراكات، وتقارير أداء شاملة.", iconBgColor: "bg-red-500", targetView: "roles" }
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
                    <h1 className="text-4xl md:text-5xl font-extrabold gradient-text mb-4">🌟 مميزات منصة ليلة الليليوم</h1>
                    <p className="text-lg text-slate-600 max-w-3xl mx-auto">
                        اكتشف كيف تجعل "ليلة الليليوم" تنظيم مناسباتك أسهل وأكثر إبهارًا مع مجموعة من الميزات المصممة خصيصًا لك.
                    </p>
                </motion.div>

                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    {mainFeatures.map((feature, index) => (
                        <FeatureItem key={index} {...feature} />
                    ))}
                </div>

                <motion.div
                    initial={{ opacity: 0, y: 30 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6, delay: mainFeatures.length * 0.05 + 0.2 }}
                    className="text-center mb-12"
                >
                    <h2 className="text-3xl md:text-4xl font-bold text-slate-800 mb-4">ميزات مخصصة لكل دور</h2>
                    <p className="text-lg text-slate-600 max-w-2xl mx-auto">
                        نقدم أدوات وميزات مصممة لتلبية الاحتياجات الفريدة لكل من العملاء، مزوّدي الخدمات، وفريق إدارة المنصة.
                    </p>
                </motion.div>
                
                <div className="grid md:grid-cols-3 gap-8">
                    {platformFeatures.map((feature, index) => (
                       <FeatureItem key={index} {...feature} onClick={feature.targetView ? () => handleNavigation(feature.targetView) : undefined} />
                    ))}
                </div>

            </div>
        </div>
    );
};

export default FeaturesPage;