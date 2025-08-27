import React from 'react';
import { motion } from 'framer-motion';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Wallet, ShieldCheck, Hourglass, Lock, FileText, Bell, Bot, Download, CreditCard, Send } from 'lucide-react';

const InfoCard = ({ icon, title, children }) => {
    const IconComponent = icon;
    return (
        <motion.div whileHover={{ y: -5 }} className="h-full">
            <Card className="h-full bg-white/50 border-2 border-primary/10 shadow-lg transition-all hover:shadow-primary/20">
                <CardHeader className="flex flex-row items-center gap-4 pb-4">
                    <div className="p-3 bg-primary/10 rounded-lg">
                        <IconComponent className="w-8 h-8 text-primary" />
                    </div>
                    <CardTitle className="text-xl font-bold text-gray-800">{title}</CardTitle>
                </CardHeader>
                <CardContent className="text-gray-600 space-y-3">
                    {children}
                </CardContent>
            </Card>
        </motion.div>
    );
};

const WorkflowStep = ({ icon, title, description, index }) => {
    const IconComponent = icon;
    return(
        <motion.div
            className="flex items-start space-x-4 space-x-reverse"
            initial={{ opacity: 0, x: -50 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.5, delay: index * 0.15 }}
        >
            <div className="flex flex-col items-center self-stretch">
                <div className="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 ring-4 ring-green-50">
                    <IconComponent className="w-8 h-8" />
                </div>
                {index < 3 && <div className="w-0.5 flex-grow bg-green-200 my-2"></div>}
            </div>
            <div className="pt-3 flex-1">
                <h3 className="font-bold text-lg text-gray-800">{title}</h3>
                <p className="text-gray-600">{description}</p>
            </div>
        </motion.div>
    );
};

const WalletAndFraudSystemPage = () => {

  const walletWorkflow = [
    { icon: Download, title: "1. استقبال الأرباح", description: "كل عملية حجز ناجحة ينتج عنها رصيد معلّق داخل محفظة التاجر. الرصيد يُجمَّع ولكن لا يمكن سحبه فورًا لحماية من الاسترجاع السريع." },
    { icon: Hourglass, title: "2. فترة الحجز المالي (مثلاً 24–48 ساعة)", description: "بعد مرور فترة الأمان، يتحوّل الرصيد إلى رصيد قابل للسحب تلقائيًا." },
    { icon: CreditCard, title: "3. طلب السحب", description: "يدخل التاجر إلى لوحة “المحفظة” ويطلب سحب المبلغ. يظهر له تفاصيل العمولة ووسيلة السحب (حساب بنكي / مدى / STC Pay)." },
    { icon: Send, title: "4. الموافقة والتحويل", description: "الطلب يُرسل إلى الإدارة، تتم مراجعته خلال 24–48 ساعة، ثم يُحوّل المبلغ إلى حساب التاجر ويُحدّث السجل تلقائيًا." },
  ];

  const fraudProtectionMechanisms = [
      { icon: Bot, title: "الرقابة التلقائية", description: "النظام يراقب سلوك الحجوزات ويكتشف التكرار، اختلافات المواقع، وروابط الإحالة المشبوهة." },
      { icon: Hourglass, title: "تأخير السحب", description: "لا يمكن سحب الأموال فورًا، مما يمنع الاحتيال المرتبط بالحجوزات الوهمية أو الاسترجاعات السريعة." },
      { icon: Lock, title: "التوثيق الثنائي (2FA)", description: "مطلوب عند تعديل البريد، تغيير الحساب البنكي، أو طلب سحب كبير ومفاجئ." },
      { icon: FileText, title: "سجل التدقيق (Audit Log)", description: "يسجل كل شيء: دخول/خروج، تعديل بيانات، إنشاء/إلغاء حجز، طلب سحب، وتغيير الإعدادات." },
      { icon: Bell, title: "تنبيهات إدارية فورية", description: "يتم إرسال تنبيه لفريق الأمان عند أي سلوك غير اعتيادي ويتم تعليق السحب مؤقتًا للمراجعة." },
  ];

  return (
    <div className="bg-gradient-to-b from-gray-50 to-blue-50 py-12 px-4 font-cairo" dir="rtl">
      <div className="container mx-auto space-y-20">

        <section>
          <motion.header
            className="text-center mb-12"
            initial={{ opacity: 0, y: -50 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.7 }}
          >
            <div className="inline-block p-4 bg-primary/10 rounded-2xl mb-4">
                <Wallet className="w-16 h-16 text-primary" />
            </div>
            <h1 className="text-4xl md:text-5xl font-extrabold gradient-text mb-4">
              نظام المحفظة والسحب
            </h1>
            <p className="text-lg text-gray-600 max-w-3xl mx-auto">
              تجربة مالية سلسة وآمنة للتجار مع آلية سحب مرنة تراعي أمان العمليات.
            </p>
          </motion.header>

          <div className="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div className="lg:col-span-3 space-y-8">
                <h2 className="text-3xl font-bold text-gray-800 border-r-4 border-primary pr-4">🧱 آلية عمل النظام</h2>
                <div className="space-y-6">
                    {walletWorkflow.map((step, index) => (
                        <WorkflowStep key={index} {...step} index={index} />
                    ))}
                </div>
            </div>
            <div className="lg:col-span-2 space-y-8">
                <InfoCard icon={FileText} title="🧾 التقارير والمعلومات للتاجر">
                    <ul className="list-disc list-inside space-y-2">
                        <li>عدد الحجوزات المربوطة بكل دفعة.</li>
                        <li>تفاصيل العمولة لكل عملية.</li>
                        <li>حالة السحب (بانتظار – مكتمل – مرفوض).</li>
                        <li>أسباب الرفض (في حال وجود مشكلة بنكية أو فنية).</li>
                    </ul>
                </InfoCard>
                 <Card className="bg-white/60 backdrop-blur-sm border-2 border-green-500/20 shadow-xl p-6">
                    <h3 className="text-xl font-bold text-gray-800 mb-2">🎯 الهدف</h3>
                    <p className="text-gray-600">
                        توفير تجربة مالية سلسة وآمنة للتجار، مع فصل واضح بين الرصيد المتاح والرصد المعلّق، ودعم آلية سحب مرنة تُراعي أمان العمليات وحماية حقوق العملاء.
                    </p>
                </Card>
            </div>
          </div>
        </section>

        <div className="relative flex py-5 items-center">
            <div className="flex-grow border-t border-gray-300"></div>
            <span className="flex-shrink mx-4 text-gray-400">
                <ShieldCheck className="w-8 h-8"/>
            </span>
            <div className="flex-grow border-t border-gray-300"></div>
        </div>

        <section>
          <motion.header
            className="text-center mb-12"
            initial={{ opacity: 0, y: -50 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.7 }}
          >
            <div className="inline-block p-4 bg-red-500/10 rounded-2xl mb-4">
                <ShieldCheck className="w-16 h-16 text-red-500" />
            </div>
            <h1 className="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-600 mb-4">
              نظام الحماية من الاحتيال
            </h1>
            <p className="text-lg text-gray-600 max-w-3xl mx-auto">
              ضمان سلامة العمليات التجارية والمالية ومنع أي تلاعب أو استخدام غير شرعي.
            </p>
          </motion.header>

          <div>
            <h2 className="text-3xl font-bold text-center mb-10 text-gray-800">🛡️ آليات الحماية الذكية في المنصة</h2>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                {fraudProtectionMechanisms.map((item, index) => (
                    <InfoCard key={index} icon={item.icon} title={item.title}>
                        <p>{item.description}</p>
                    </InfoCard>
                ))}
            </div>

            <h2 className="text-3xl font-bold text-center mb-10 text-gray-800">✅ حماية مزدوجة</h2>
            <Card className="max-w-4xl mx-auto overflow-hidden shadow-lg border-2 border-blue-500/10">
                <Table>
                    <TableHeader>
                        <TableRow className="bg-gray-100">
                            <TableHead className="w-1/2 text-lg font-bold text-gray-700 p-4">النوع</TableHead>
                            <TableHead className="text-lg font-bold text-gray-700 p-4">الحماية</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow>
                            <TableCell className="font-semibold text-lg text-red-600 p-4">ضد التاجر</TableCell>
                            <TableCell className="p-4">تجميد تلقائي عند السلوك المشبوه، مراجعة يدوية، سجل تدقيق (Audit Log).</TableCell>
                        </TableRow>
                        <TableRow className="bg-gray-50">
                            <TableCell className="font-semibold text-lg text-blue-600 p-4">ضد العميل</TableCell>
                            <TableCell className="p-4">حجز أمواله مؤقتًا، QR فريد لكل تذكرة، منع التكرار.</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </Card>
          </div>
        </section>

      </div>
    </div>
  );
};

export default WalletAndFraudSystemPage;