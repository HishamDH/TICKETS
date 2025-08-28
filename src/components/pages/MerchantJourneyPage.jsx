import React from 'react';
import { motion } from 'framer-motion';
import { UserPlus, Settings2, ShoppingCart, Users, Printer, Wallet, ShieldCheck, BarChart3, HeartHandshake as Handshake, FileText, Palette, CheckCircle, Ticket, ChevronLeft,  } from 'lucide-react';
import { Button } from '@/components/ui/button';

const JourneyStep = ({ icon: Icon, title, description, items, index }) => (
  <motion.div
    className="flex items-start mb-12"
    initial={{ opacity: 0, x: -50 }}
    whileInView={{ opacity: 1, x: 0 }}
    transition={{ duration: 0.6, delay: index * 0.15 }}
    viewport={{ once: true, amount: 0.3 }}
  >
    <div className="flex flex-col items-center mr-6">
      <div className="w-16 h-16 rounded-full gradient-bg flex items-center justify-center text-white shadow-lg">
        <Icon className="w-8 h-8" />
      </div>
      <div className="w-1 flex-grow bg-primary/20 mt-2"></div>
    </div>
    <div className="flex-1 bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
      <h3 className="text-2xl font-bold text-slate-800 mb-4">{title}</h3>
      <p className="text-slate-600 mb-6">{description}</p>
      <ul className="space-y-3">
        {items.map((item, idx) => (
          <li key={idx} className="flex items-start">
            <CheckCircle className="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" />
            <span className="text-slate-700">{item}</span>
          </li>
        ))}
      </ul>
    </div>
  </motion.div>
);

const MerchantJourneyPage = ({ handleNavigation }) => {
  const journeyData = [
    {
      icon: UserPlus,
      title: "أولاً: الدخول الأول – التسجيل وفتح الحساب",
      description: "بداية رحلتك كشريك نجاح في شباك التذاكر تبدأ بخطوات بسيطة وآمنة لإنشاء حسابك التجاري.",
      items: [
        "زيارة الصفحة الرئيسية والضغط على 'سجل كتاجر'.",
        "تعبئة البيانات الأساسية: الاسم التجاري، البريد الإلكتروني، رقم الجوال، ونوع النشاط.",
        "رفع المستندات القانونية: السجل التجاري، الشهادة الضريبية، وبيانات الحساب البنكي.",
        "إرسال الطلب ليراجعه فريقنا المختص.",
        "استلام بريد إلكتروني رسمي لتفعيل حسابك بعد الموافقة."
      ]
    },
    {
      icon: Settings2,
      title: "ثانيًا: إعداد الحساب والبدء",
      description: "بعد تفعيل حسابك، حان الوقت لوضع بصمتك الخاصة وإعداد واجهتك لاستقبال العملاء.",
      items: [
        "الدخول إلى لوحة التحكم الخاصة بك لأول مرة.",
        "اختيار تصميم موقعك الفرعي: الشعار، الألوان، والصور التي تعكس هويتك.",
        "تحديد النطاق الفرعي الخاص بك (مثال: myevent.shobaktickets.com).",
        "إنشاء أول فعالية، مطعم، تجربة، أو معرض وبدء رحلة البيع."
      ]
    },
    {
      icon: ShoppingCart,
      title: "ثالثًا: استقبال الحجوزات من العملاء",
      description: "شاهد أعمالك تنمو مع كل حجز جديد، وتحكم بها بكل سهولة من لوحة تحكم واحدة.",
      items: [
        "مشاركة رابط موقعك الخاص عبر قنواتك التسويقية.",
        "استقبال حجوزات العملاء المدفوعة إلكترونياً بسلاسة وأمان.",
        "متابعة الحجوزات لحظة بلحظة من لوحة التحكم.",
        "إمكانية قبول، رفض، أو طلب تعديل الحجوزات التي تتطلب موافقة مسبقة."
      ]
    },
    {
      icon: Users,
      title: "رابعًا: إدارة الفريق وموظفي التحقق",
      description: "لأن العمل الجماعي أساس النجاح، يمكنك دعوة فريقك وتحديد أدوارهم بدقة.",
      items: [
        "إضافة موظفين وتحديد صلاحياتهم (مسؤول تحقق، دعم، مدير، موظف بيع).",
        "حصول موظف التحقق على حساب خاص بصفحة التحقق من التذاكر.",
        "يوم الحدث، يتم مسح تذاكر الحضور عبر الكاميرا لتسجيل الحضور بسهولة.",
        "تحديث حالة التذاكر تلقائياً إلى 'تم استخدامها' بعد التحقق."
      ]
    },
    {
      icon: Printer,
      title: "خامسًا: البيع الداخلي (نقطة البيع - POS)",
      description: "لا تفوّت أي فرصة بيع، حتى في مقر الحدث. نظام نقاط البيع يتيح لك إصدار التذاكر فوراً.",
      items: [
        "بيع تذاكر مباشرة من داخل مقر الحدث عبر صفحة 'البيع الداخلي'.",
        "إدخال بيانات العميل وتحديد وسيلة الدفع (نقدي أو شبكة).",
        "طباعة التذكرة مباشرة أو إرسالها عبر رسالة نصية (SMS) للعميل."
      ]
    },
    {
      icon: Wallet,
      title: "سادسًا: المحفظة والسحب",
      description: "إدارة إيراداتك وسحب أرباحك أصبحت أسهل وأكثر أماناً من أي وقت مضى.",
      items: [
        "يتم حجز مبلغ كل حجز ناجح مؤقتاً لمدة 24 ساعة كفترة أمان.",
        "بعد انتهاء المهلة، يتحول المبلغ إلى رصيدك المتاح للسحب.",
        "تقديم طلب سحب الرصيد بسهولة من لوحة التحكم.",
        "مراجعة الطلب وتحويل المبلغ إلى حسابك البنكي المسجل خلال أيام عمل قليلة."
      ]
    },
    {
      icon: ShieldCheck,
      title: "سابعًا: الحماية والتأمين",
      description: "نحن نأخذ أمانك على محمل الجد. نظامنا مصمم لحماية بياناتك وأعمالك في كل خطوة.",
      items: [
        "تسجيل كل نشاط يتم على حسابك في سجل التدقيق (Audit Log).",
        "تأمين تغيير البيانات الحساسة (الحساب البنكي، الإيميل) عبر التوثيق الثنائي (2FA).",
        "مراقبة تلقائية للحجوزات المشبوهة لمنع الاحتيال.",
        "إشعارات فورية للإدارة عند رصد أي عمليات غير طبيعية."
      ]
    },
    {
      icon: BarChart3,
      title: "ثامنًا: التقييم والتقارير",
      description: "حوّل البيانات إلى قرارات ذكية. تقاريرنا تمنحك رؤية شاملة لأداء أعمالك.",
      items: [
        "تمكين العملاء من تقييم خدماتك بعد انتهاء التجربة لجمع آرائهم.",
        "مراجعة تقييمات العملاء والرد عليها من قسم 'التقييمات'.",
        "الاطلاع على تقارير مفصلة عن المبيعات، الحجوزات، أوقات الذروة، والخدمات الأكثر طلباً."
      ]
    },
     {
      icon: Handshake,
      title: "تاسعًا: الشركاء والدعم",
      description: "أنت لست وحدك في هذه الرحلة. فريقنا وشركاؤنا هنا لمساعدتك على تحقيق النجاح.",
      items: [
        "إذا تم تسجيلك عبر مندوب، سيحصل على عمولته تلقائياً تقديراً لجهوده.",
        "يمكن تعيين أخصائي حسابات مخصص من قبل الإدارة لمساعدتك وتوجيهك.",
        "إمكانية إرسال تذاكر دعم فني مباشرة للإدارة لحل أي تحديات تواجهك."
      ]
    }
  ];

  return (
    <div className="min-h-screen bg-slate-50 py-16" dir="rtl">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-center mb-16"
        >
          <h1 className="text-4xl md:text-5xl font-extrabold gradient-text mb-4">رحلة التاجر في منصة شباك التذاكر</h1>
          <p className="text-lg text-slate-600 max-w-3xl mx-auto">
            من التسجيل إلى النجاح: دليلك خطوة بخطوة للانطلاق بأعمالك نحو آفاق جديدة.
          </p>
        </motion.div>
        
        <div className="max-w-4xl mx-auto">
            {journeyData.map((step, index) => (
                <JourneyStep key={index} {...step} index={index} />
            ))}
             <motion.div
                className="flex justify-center"
                initial={{ opacity: 0 }}
                whileInView={{ opacity: 1 }}
                transition={{ duration: 0.6, delay: journeyData.length * 0.15 }}
                viewport={{ once: true }}
            >
                <div className="w-16 h-16 rounded-full bg-green-500 flex items-center justify-center text-white shadow-lg">
                    <Ticket className="w-8 h-8" />
                </div>
            </motion.div>
        </div>

        <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.5 }}
            className="text-center mt-20"
        >
          <h2 className="text-3xl font-bold text-slate-800 mb-4">
            جاهز لبدء رحلتك؟
          </h2>
          <p className="text-lg text-slate-600 max-w-2xl mx-auto mb-8">
            انضم الآن إلى شبكة التجار الناجحين وابدأ في إدارة أعمالك بكفاءة واحترافية.
          </p>
          <Button
            size="lg"
            className="gradient-bg text-white px-10 py-6 text-lg font-semibold pulse-glow shadow-lg"
            onClick={() => handleNavigation('merchant-register')}
          >
            <ChevronLeft className="mr-2 h-5 w-5" />
            سجل كتاجر الآن
          </Button>
        </motion.div>
      </div>
    </div>
  );
};

export default MerchantJourneyPage;