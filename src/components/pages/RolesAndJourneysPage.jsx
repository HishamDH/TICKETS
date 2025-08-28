import React from 'react';
import { motion } from 'framer-motion';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Users, Store, ShieldCheck, TrendingUp, Eye, CreditCard, Edit, EyeOff, FileText, Star as StarIcon, Gem, Palette, Ticket, QrCode, Users2, DollarSign, GitBranch, BarChart3 } from 'lucide-react';

const PermissionsTable = ({ permissions }) => (
    <div className="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">
        <div className="overflow-x-auto">
            <table className="w-full text-right">
                <thead className="bg-slate-50">
                    <tr>
                        <th className="p-4 font-semibold text-sm text-slate-600">الصلاحية</th>
                        <th className="p-4 font-semibold text-sm text-slate-600">التوضيح</th>
                    </tr>
                </thead>
                <tbody>
                    {permissions.map((perm, index) => (
                        <motion.tr 
                            key={index} 
                            className="border-t border-slate-100"
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ duration: 0.5, delay: index * 0.1 }}
                        >
                            <td className="p-4 font-bold text-primary align-top flex items-center gap-2">{perm.icon}{perm.permission}</td>
                            <td className="p-4 text-slate-700 text-sm">{perm.description}</td>
                        </motion.tr>
                    ))}
                </tbody>
            </table>
        </div>
    </div>
);

const JourneyTimeline = ({ steps }) => (
    <div className="relative pr-8 border-r-2 border-primary/20">
        {steps.map((step, index) => (
            <motion.div
                key={index}
                className="mb-8 relative"
                initial={{ opacity: 0, x: -20 }}
                whileInView={{ opacity: 1, x: 0 }}
                transition={{ duration: 0.5, delay: index * 0.2 }}
                viewport={{ once: true, amount: 0.5 }}
            >
                <div className="absolute -right-[1.1rem] top-1 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                    {index + 1}
                </div>
                <div className="bg-white p-6 rounded-2xl shadow-lg ml-4">
                    <h4 className="font-bold text-slate-800 mb-2">{step.title}</h4>
                    <p className="text-sm text-slate-600">{step.description}</p>
                </div>
            </motion.div>
        ))}
    </div>
);


const RolesAndJourneysPage = () => {

    const clientPermissions = [
        { permission: "مشاهدة الفعاليات", description: "داخل صفحات التجار فقط، ليست في الموقع الرئيسي.", icon: <Eye className="w-4 h-4 text-sky-600"/> },
        { permission: "الحجز والدفع", description: "حجز التذاكر أو الطاولات أو التسجيل بالمعرض مع الدفع المباشر.", icon: <CreditCard className="w-4 h-4 text-emerald-600"/> },
        { permission: "التعديل / الإلغاء", description: "ممكن فقط إن أنشأ حسابًا، ووفق سياسة التاجر.", icon: <Edit className="w-4 h-4 text-amber-600"/> },
        { permission: "عرض سجل الحجوزات", description: "قائمة بجميع الحجوزات السابقة والمقبلة.", icon: <FileText className="w-4 h-4 text-indigo-600"/> },
        { permission: "تحميل التذكرة", description: "مباشرة بعد الدفع، مع دعم Apple Wallet.", icon: <Ticket className="w-4 h-4 text-primary"/> },
        { permission: "التقييم", description: "تقييم الفعالية بعد الحضور.", icon: <StarIcon className="w-4 h-4 text-yellow-500"/> },
        { permission: "جمع النقاط", description: "حسب سياسة التاجر إن فعّل نظام المكافآت.", icon: <Gem className="w-4 h-4 text-rose-500"/> }
    ];

    const clientJourney = [
        { title: "الزيارة والاستكشاف", description: "يزور الموقع الفرعي للتاجر ويستعرض الفعالية أو الخدمة المتاحة." },
        { title: "الاختيار والحجز", description: "يختار التذكرة / الطاولة / التسجيل ويقوم بالدفع إلكترونيًا." },
        { title: "استلام التذكرة", description: "يحصل على التذكرة أو البادج مباشرة بعد الدفع." },
        { title: "الحضور والمشاركة", description: "يدخل الفعالية ويُسجّل حضوره باستخدام التذكرة." },
        { title: "ما بعد الفعالية", description: "يعود لحسابه لعرض سجل الحجوزات، تقييم التجربة، وإعادة الحجز مستقبلاً." }
    ];

    const merchantPermissions = [
        { permission: "إدارة الموقع الفرعي", description: "تغيير الألوان، الشعارات، البنرات.", icon: <Palette className="w-4 h-4 text-pink-500"/> },
        { permission: "إضافة الخدمات", description: "إضافة فعاليات، مطاعم، معارض مع تحديد كافة التفاصيل.", icon: <Ticket className="w-4 h-4 text-green-500"/> },
        { permission: "إدارة الحجوزات", description: "قبول، رفض، تعديل، وإلغاء الحجوزات الواردة.", icon: <FileText className="w-4 h-4 text-indigo-500"/> },
        { permission: "التحقق من التذاكر", description: "مسح تذاكر الحضور أو التحقق منها يدويًا عند مدخل الفعالية.", icon: <QrCode className="w-4 h-4 text-slate-600"/> },
        { permission: "إدارة الفريق", description: "تعيين موظفين بصلاحيات محددة (تحقق، دعم، مشرف).", icon: <Users2 className="w-4 h-4 text-cyan-500"/> },
        { permission: "طلبات السحب", description: "سحب الأرباح بعد فترة الأمان (24 ساعة).", icon: <DollarSign className="w-4 h-4 text-emerald-600"/> },
        { permission: "إدارة الفروع", description: "إضافة فروع متعددة لنفس الحساب التجاري.", icon: <GitBranch className="w-4 h-4 text-purple-600"/> },
        { permission: "التقارير والإحصاءات", description: "متابعة المبيعات، الزوار، والحجوزات لتحليل الأداء.", icon: <BarChart3 className="w-4 h-4 text-blue-600"/> }
    ];

    const merchantJourney = [
        { title: "التسجيل والمراجعة", description: "يسجّل كتاجر جديد ويقدّم الأوراق الرسمية (سجل تجاري، حساب بنكي)." },
        { title: "التفعيل والتخصيص", description: "يتم تفعيل حسابه من قبل الإدارة، ثم يخصّص تصميم موقعه الفرعي." },
        { title: "إضافة الخدمات", description: "يضيف الفعاليات أو المطاعم أو المعارض ويبدأ في استقبال الحجوزات." },
        { title: "الإدارة والمتابعة", description: "يستقبل الحجوزات، يراقب الإيرادات، ويدير فريق عمله." },
        { title: "النمو والتطوير", description: "يسحب أرباحه ويستخدم التقارير الذكية لتطوير نشاطه التجاري." }
    ];

    const platformStaffPermissions = [
        { permission: "Super Admin", description: "تحكم كامل في النظام، إعداد السياسات، إدارة التجار، وتقارير الإيرادات.", icon: <ShieldCheck className="w-4 h-4 text-red-600"/> },
        { permission: "Admin (مشرف)", description: "مراقبة التجار والفريق، تحويل الحسابات، تتبع الأداء.", icon: <Users className="w-4 h-4 text-blue-600"/> },
        { permission: "أخصائي حسابات", description: "مراجعة الحسابات والوثائق، إدارة حسابات التجار والتحويلات البنكية.", icon: <FileText className="w-4 h-4 text-emerald-600"/> },
        { permission: "محاسب", description: "تنفيذ المدفوعات، إعداد تقارير الإيرادات.", icon: <DollarSign className="w-4 h-4 text-green-600"/> },
        { permission: "دعم فني", description: "الرد على الاستفسارات (بدون صلاحية تعديل أو مالية).", icon: <Users2 className="w-4 h-4 text-cyan-600"/> },
    ];

    const adminJourney = [
        { title: "تسجيل الدخول", description: "يسجل دخوله إلى لوحة التحكم الرئيسية للمنصة." },
        { title: "المتابعة اليومية", description: "يتابع الطلبات الجديدة، الحسابات البنكية، وتذاكر الدعم الفني." },
        { title: "اتخاذ القرارات", description: "يتخذ قرارات تشغيلية مثل تفعيل حسابات، مراجعة طلبات، أو استرجاع مبالغ." },
        { title: "حل المشكلات", description: "يُحلل المشكلات الواردة من الدعم الفني ويتخذ الإجراءات اللازمة." },
        { title: "مراقبة الأداء", description: "يراقب تقارير الأداء، التحصيل، والنمو الشهري للمنصة." }
    ];

    const renderSection = (title, permissions, journey) => (
        <div className="grid lg:grid-cols-2 gap-12 items-start">
            <div>
                <h3 className="text-2xl font-bold text-slate-800 mb-2 flex items-center gap-3"><ShieldCheck className="text-primary"/>الصلاحيات</h3>
                <p className="text-slate-500 mb-6">نظرة على الصلاحيات المتاحة لهذا الدور.</p>
                <PermissionsTable permissions={permissions} />
            </div>
            <div>
                <h3 className="text-2xl font-bold text-slate-800 mb-2 flex items-center gap-3"><TrendingUp className="text-primary"/>الرحلة</h3>
                <p className="text-slate-500 mb-6">خطوات رحلة المستخدم من البداية إلى النهاية.</p>
                <JourneyTimeline steps={journey} />
            </div>
        </div>
    );

    return (
        <div className="min-h-screen bg-slate-50 py-16">
            <div className="container mx-auto px-4">
                <motion.div
                    initial={{ opacity: 0, y: 30 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6 }}
                    className="text-center mb-12"
                >
                    <h1 className="text-4xl md:text-5xl font-extrabold gradient-text mb-4">الأدوار والرحلات</h1>
                    <p className="text-lg text-slate-600 max-w-3xl mx-auto">
                        لكل مستخدم دور فريد ورحلة مصممة بعناية لضمان تجربة سلسة وفعالة داخل منصة شباك التذاكر.
                    </p>
                </motion.div>

                <Tabs defaultValue="client" className="w-full" dir="rtl">
                    <TabsList className="grid w-full grid-cols-1 sm:grid-cols-3 gap-2 h-auto p-2 bg-primary/10 rounded-xl mb-10">
                        <TabsTrigger value="client" className="flex items-center gap-2 text-sm md:text-base py-2.5"><Users className="h-5 w-5"/>العميل</TabsTrigger>
                        <TabsTrigger value="merchant" className="flex items-center gap-2 text-sm md:text-base py-2.5"><Store className="h-5 w-5"/>التاجر</TabsTrigger>
                        <TabsTrigger value="platform_staff" className="flex items-center gap-2 text-sm md:text-base py-2.5"><ShieldCheck className="h-5 w-5"/>الإدارة</TabsTrigger>
                    </TabsList>
                    
                    <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} transition={{ duration: 0.5 }}>
                        <TabsContent value="client">
                            {renderSection("العميل", clientPermissions, clientJourney)}
                        </TabsContent>
                        <TabsContent value="merchant">
                             {renderSection("التاجر", merchantPermissions, merchantJourney)}
                        </TabsContent>
                        <TabsContent value="platform_staff">
                            {renderSection("موظفو المنصة", platformStaffPermissions, adminJourney)}
                        </TabsContent>
                    </motion.div>
                </Tabs>
            </div>
        </div>
    );
};

export default RolesAndJourneysPage;