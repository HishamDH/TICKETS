
import React from 'react';
import { motion } from 'framer-motion';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Users, Target, ShieldCheck, Briefcase, Link as LinkIcon, PieChart, DollarSign, QrCode, ClipboardList } from 'lucide-react';

const PartnerRoleCard = ({ icon, title, description, details }) => {
  const IconComponent = icon;
  return (
    <motion.div whileHover={{ y: -5 }} className="h-full">
      <Card className="h-full bg-white/50 border-2 border-primary/10 shadow-lg transition-all hover:shadow-primary/20">
        <CardHeader className="flex flex-row items-center gap-4">
          <div className="p-3 bg-primary/10 rounded-lg">
            <IconComponent className="w-8 h-8 text-primary" />
          </div>
          <div>
            <CardTitle className="text-2xl font-bold text-gray-800">{title}</CardTitle>
            <CardDescription className="text-gray-500">{description}</CardDescription>
          </div>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead className="w-[120px]">الوظيفة</TableHead>
                <TableHead>التفاصيل</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {details.map((item, index) => (
                <TableRow key={index}>
                  <TableCell className="font-semibold">{item.job}</TableCell>
                  <TableCell>{item.detail}</TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>
    </motion.div>
  );
};

const InfoCard = ({ icon, title, children }) => {
    const IconComponent = icon;
    return (
        <Card className="bg-white/50 border-2 border-blue-500/10 shadow-lg">
            <CardHeader className="flex flex-row items-center gap-4 pb-4">
                <div className="p-3 bg-blue-500/10 rounded-lg">
                    <IconComponent className="w-6 h-6 text-blue-500" />
                </div>
                <CardTitle className="text-xl font-bold text-gray-800">{title}</CardTitle>
            </CardHeader>
            <CardContent className="text-gray-600 space-y-2">
                {children}
            </CardContent>
        </Card>
    );
};

const WorkflowStep = ({ stage, action, index }) => (
    <motion.div 
        className="flex items-start space-x-4 space-x-reverse"
        initial={{ opacity: 0, x: -50 }}
        animate={{ opacity: 1, x: 0 }}
        transition={{ duration: 0.5, delay: index * 0.1 }}
    >
        <div className="flex flex-col items-center">
            <div className="flex items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white font-bold text-xl">
                {stage}
            </div>
            {stage < 6 && <div className="w-0.5 h-16 bg-green-500/30"></div>}
        </div>
        <div className="pt-2">
            <p className="font-bold text-lg text-gray-800">{action.title}</p>
            <p className="text-gray-600">{action.description}</p>
        </div>
    </motion.div>
);


const PartnersSystemPage = () => {
    
  const systemComponents = {
    representative: {
      icon: Briefcase,
      title: 'المندوب',
      description: 'شخص يقوم بتسجيل تجار جدد على المنصة.',
      details: [
        { job: 'دوره', detail: 'شخص يقوم بتسجيل تجار جدد على المنصة' },
        { job: 'العمولة', detail: 'يحصل على نسبة ثابتة أو مخصصة من مبيعات التاجر الذي قام بتسجيله' },
        { job: 'آلية الربط', detail: 'كل مندوب لديه رابط إحالة (Referral Link)' },
        { job: 'صلاحياته', detail: 'يرى التجار الذين سجّلهم، إيراداتهم، عمولته، سجل السحب' },
      ],
    },
    affiliate: {
      icon: Users,
      title: 'الشريك التسويقي',
      description: 'مسوق يروّج لفعاليات أو خدمات على المنصة.',
      details: [
        { job: 'دوره', detail: 'مسوق يروّج لفعاليات أو خدمات على المنصة' },
        { job: 'العمولة', detail: 'يحصل على نسبة من قيمة الحجوزات التي تأتي من خلاله' },
        { job: 'آلية الربط', detail: 'رابط تتبع فريد (UTM / Tracking ID)' },
        { job: 'صلاحياته', detail: 'لوحة تحكم تعرض عدد الزيارات، الحجوزات، الإيرادات، والمكافآت' },
      ],
    },
    accountManager: {
      icon: ClipboardList,
      title: 'أخصائي الحسابات',
      description: 'موظف من إدارة المنصة لمتابعة تاجر معين.',
      details: [
        { job: 'دوره', detail: 'موظف من إدارة المنصة يتولى متابعة تاجر معين' },
        { job: 'المهام', detail: 'التحقق من الحسابات البنكية، المرفقات، العقود، الدعم، تفعيل الحسابات' },
        { job: 'صلاحياته', detail: 'صلاحيات محدودة على التجار المرتبطين به فقط' },
      ],
    },
  };

  const dashboardFeatures = [
      { icon: PieChart, title: "الصفحة الرئيسية", content: ["عدد التجار الذين سجلوا عبره", "إجمالي الإيرادات الناتجة من التجار", "العمولة المكتسبة", "حالة كل تاجر (مفعل – موقوف – معلّق)"] },
      { icon: DollarSign, title: "صفحة السحب", content: ["الرصيد الحالي القابل للسحب", "سجل السحوبات السابقة", "زر “طلب سحب”", "حالة كل طلب (بانتظار – مكتمل – مرفوض)"] },
      { icon: LinkIcon, title: "الروابط", content: ["رابط الإحالة الخاص به", "QR قابل للطباعة أو المشاركة", "أدوات ترويجية (نصوص، بنرات، قوالب رسائل)"] },
  ];

  const workflowSteps = [
    { title: "إنشاء حساب مندوب", description: "عبر إدارة المنصة أو تسجيل ذاتي بعد الموافقة" },
    { title: "استلام رابط الإحالة", description: "يظهر تلقائيًا في لوحة التحكم" },
    { title: "مشاركة الرابط", description: "مع تجار أو عملاء عبر أي وسيلة" },
    { title: "تسجيل تاجر عبر الرابط", description: "يُربط تلقائيًا بالمندوب" },
    { title: "التاجر يبدأ بالحجز والبيع", description: "يُحسب للمندوب نسبة من الأرباح" },
    { title: "المندوب يطلب السحب", description: "يتم مراجعته وتحويله له عبر النظام" }
  ];


  return (
    <div className="bg-gradient-to-b from-gray-50 to-blue-50 py-12 px-4 font-cairo" dir="rtl">
      <div className="container mx-auto">
        
        <motion.header 
          className="text-center mb-16"
          initial={{ opacity: 0, y: -50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7 }}
        >
          <div className="inline-block p-4 bg-primary/10 rounded-2xl mb-4">
              <Users className="w-16 h-16 text-primary" />
          </div>
          <h1 className="text-4xl md:text-6xl font-extrabold gradient-text mb-4">
            نظام الشركاء والمندوبين
          </h1>
          <p className="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
            في منصة شباك التذاكر
          </p>
        </motion.header>

        <section className="mb-16">
            <Card className="max-w-4xl mx-auto bg-white/60 backdrop-blur-sm border-2 border-green-500/20 shadow-xl p-8 text-center">
                <Target className="w-12 h-12 text-green-500 mx-auto mb-4" />
                <h2 className="text-3xl font-bold text-gray-800 mb-2">🎯 الهدف من النظام</h2>
                <p className="text-lg text-gray-600">
                    تمكين المنصة من التوسع، وجذب تجار جدد أو عملاء، بدون الحاجة إلى فريق مبيعات داخلي دائم، من خلال ربط كل تاجر أو عميل بمندوب أو شريك، ومنحهم عمولة مقابل النتائج.
                </p>
            </Card>
        </section>

        <section className="mb-16">
          <h2 className="text-3xl font-bold text-center mb-8 text-gray-800">🧩 مكونات النظام</h2>
          <Tabs defaultValue="representative" className="w-full max-w-6xl mx-auto">
            <TabsList className="grid w-full grid-cols-1 md:grid-cols-3 gap-2">
              <TabsTrigger value="representative">المندوب</TabsTrigger>
              <TabsTrigger value="affiliate">الشريك التسويقي</TabsTrigger>
              <TabsTrigger value="accountManager">أخصائي الحسابات</TabsTrigger>
            </TabsList>
            <TabsContent value="representative" className="mt-6">
              <PartnerRoleCard {...systemComponents.representative} />
            </TabsContent>
            <TabsContent value="affiliate" className="mt-6">
              <PartnerRoleCard {...systemComponents.affiliate} />
            </TabsContent>
            <TabsContent value="accountManager" className="mt-6">
              <PartnerRoleCard {...systemComponents.accountManager} />
            </TabsContent>
          </Tabs>
        </section>

        <section className="mb-16">
          <h2 className="text-3xl font-bold text-center mb-8 text-gray-800">🖥️ لوحة تحكم المندوب / الشريك</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {dashboardFeatures.map((feature, index) => (
                <motion.div key={index} initial={{ opacity: 0, scale: 0.9 }} animate={{ opacity: 1, scale: 1 }} transition={{ duration: 0.5, delay: index * 0.1 }}>
                    <InfoCard icon={feature.icon} title={feature.title}>
                        <ul className="list-disc list-inside space-y-2">
                            {feature.content.map((item, i) => <li key={i}>{item}</li>)}
                        </ul>
                    </InfoCard>
                </motion.div>
            ))}
          </div>
        </section>

        <section className="mb-16">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                 <InfoCard icon={LinkIcon} title="🔐 نظام ربط الشركاء بالتجار والعملاء">
                    <h3 className="font-bold text-lg text-blue-600">الربط التلقائي:</h3>
                    <p>أي تاجر يسجّل عبر رابط مندوب يتم ربطه تلقائيًا بذلك المندوب. يمكن أيضًا للإدارة ربط تاجر يدويًا بمندوب محدد.</p>
                     <h3 className="font-bold text-lg text-blue-600 mt-4">الشفافية:</h3>
                    <p>لا يستطيع المندوب التعديل على بيانات التاجر. يرى فقط الإحصائيات العامة (عدد الحجوزات، حجم المبيعات، نسبة العمولة) ولا يرى بيانات العملاء أو معلومات مالية حساسة.</p>
                </InfoCard>
                 <InfoCard icon={ShieldCheck} title="🛡️ نظام الحماية والمراجعة">
                    <ul className="list-disc list-inside space-y-2">
                        <li>لا يمكن للمندوب تغيير التاجر بعد ربطه.</li>
                        <li>أي تلاعب بالرابط (مثلاً IP مكرر، تسجيل مزيف) يُراجَع تلقائيًا.</li>
                        <li>الإدارة تملك حق تعليق المندوب في حال وجود تجاوزات.</li>
                    </ul>
                </InfoCard>
            </div>
        </section>

         <section>
            <h2 className="text-3xl font-bold text-center mb-8 text-gray-800">💼 سير العمل الكامل لنظام المندوب</h2>
            <div className="max-w-2xl mx-auto">
                {workflowSteps.map((step, index) => (
                    <WorkflowStep key={index} stage={index + 1} action={step} index={index} />
                ))}
            </div>
         </section>

      </div>
    </div>
  );
};

export default PartnersSystemPage;
