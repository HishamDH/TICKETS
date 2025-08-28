
import React from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import {
  Ticket,
  Users,
  Calendar,
  MapPin,
  Shield,
  CheckCircle,
  Globe,
  Smartphone,
  Lock,
  Zap,
  TrendingUp,
  Award,
  Building
} from 'lucide-react';
import Partners from '@/components/layout/Partners';

const HomePage = ({ handleNavigation, handleFeatureClick }) => {
  const features = [
    {
      icon: Globe,
      title: "موقع مستقل لكل تاجر",
      description: "احصل على موقعك الخاص بتصميم مخصص وهوية بصرية فريدة تعكس علامتك التجارية."
    },
    {
      icon: Smartphone,
      title: "واجهة سهلة الاستخدام",
      description: "تصميم عصري ومتجاوب يعمل على جميع الأجهزة بسلاسة، ليضمن تجربة رائعة لعملائك."
    },
    {
      icon: Lock,
      title: "أمان متقدم",
      description: "نظام حماية عالي المستوى لبياناتك وبيانات عملائك، مع تشفير متطور للمدفوعات."
    },
    {
      icon: Zap,
      title: "سرعة في الأداء",
      description: "بنية تحتية قوية تضمن نظاماً سريعاً وموثوقاً لضمان تجربة مستخدم لا مثيل لها."
    },
    {
      icon: TrendingUp,
      title: "تقارير تفصيلية",
      description: "احصل على إحصائيات شاملة ولوحات بيانات تفاعلية لمتابعة أداء أعمالك بدقة."
    },
    {
      icon: Award,
      title: "دعم فني متميز",
      description: "فريق دعم متخصص متاح لمساعدتك في كل خطوة، لضمان تحقيق أقصى استفادة من المنصة."
    }
  ];

  const services = [
    {
      icon: Calendar,
      title: "إدارة الفعاليات",
      description: "نظام متكامل لإدارة جميع أنواع الفعاليات مع خرائط مقاعد تفاعلية.",
      features: ["خرائط مقاعد تفاعلية", "إدارة الأسعار المرنة", "تقارير المبيعات الحية", "نظام إشعارات ذكي"]
    },
    {
      icon: MapPin,
      title: "حجوزات المطاعم",
      description: "إدارة طاولات المطاعم وأوقات العمل مع نظام حجز متطور.",
      features: ["إدارة الطاولات الذكية", "جدولة المواعيد بسهولة", "قوائم طعام رقمية", "نظام تقييمات العملاء"]
    },
    {
      icon: Building,
      title: "تنظيم المعارض",
      description: "حلول متخصصة للمعارض مع إصدار بادجات ونظام تسجيل متقدم.",
      features: ["إصدار بادجات احترافية", "نظام تسجيل مرن", "إدارة العارضين والرعاة", "تقارير الحضور والتفاعل"]
    }
  ];
  
  return (
    <div className="min-h-screen">
      <section className="relative min-h-screen flex items-center justify-center overflow-hidden hero-pattern">
        <div className="absolute inset-0 bg-primary/5"></div>
        <div className="container mx-auto px-4 relative z-10">
          <motion.div
            initial={{ opacity: 0, y: 50 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            className="text-center max-w-4xl mx-auto"
          >
             <motion.div
              initial={{ scale: 0.8, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              transition={{ duration: 0.6, delay: 0.2 }}
              className="mb-8"
            >
                <img  class="w-32 h-32 mx-auto mb-6 floating-animation" alt="شعار شباك التذاكر" src="https://images.unsplash.com/photo-1691405167344-c3bbc9710ad2" />
            </motion.div>

            <h1 className="text-5xl md:text-7xl font-extrabold mb-6 gradient-text">
              شباك التذاكر
            </h1>
            
            <p className="text-xl md:text-2xl text-slate-700 mb-8 leading-relaxed">
              بوابتك الذكية لإدارة وبيع تذاكر الفعاليات والحجوزات
            </p>
            
            <p className="text-lg text-slate-500 mb-12 max-w-2xl mx-auto">
              منصة متكاملة تمكّن التجار من إدارة حجوزاتهم وبيع التذاكر بكل سهولة وأمان عبر مواقعهم الخاصة، مع توفير تجربة فريدة للعملاء.
            </p>

            <motion.div
              initial={{ opacity: 0, y: 30 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.4 }}
              className="flex flex-col sm:flex-row gap-4 justify-center items-center"
            >
              <Button
                size="lg"
                className="gradient-bg text-white px-10 py-6 text-lg font-semibold pulse-glow shadow-lg"
                onClick={() => handleNavigation('merchant-register')}
              >
                <Users className="ml-2 h-5 w-5" />
                انضم كتاجر الآن
              </Button>
              
              <Button
                variant="outline"
                size="lg"
                className="border-2 border-primary text-primary hover:bg-primary hover:text-white px-10 py-6 text-lg font-semibold"
                onClick={() => handleNavigation('unified-view')}
              >
                <Shield className="ml-2 h-5 w-5" />
                استعراض لوحات التحكم
              </Button>
            </motion.div>
          </motion.div>
        </div>
      </section>

      <section className="py-24 bg-slate-50">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true, amount: 0.5 }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl md:text-5xl font-bold mb-6 gradient-text">
              لماذا شباك التذاكر؟
            </h2>
            <p className="text-xl text-slate-600 max-w-3xl mx-auto">
              نوفر لك كل ما تحتاجه لإدارة أعمالك بكفاءة واحترافية، مع التركيز على نموك ونجاحك.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {features.map((feature, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5, delay: index * 0.1 }}
                viewport={{ once: true, amount: 0.5 }}
                className="bg-white p-8 rounded-2xl shadow-lg card-hover cursor-pointer text-center"
                onClick={() => handleFeatureClick(feature.title)}
              >
                <div className="w-20 h-20 gradient-bg rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-md">
                  <feature.icon className="h-10 w-10 text-white" />
                </div>
                <h3 className="text-xl font-bold mb-4 text-slate-800">{feature.title}</h3>
                <p className="text-slate-600 leading-relaxed">{feature.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      <section className="py-24 bg-white">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true, amount: 0.5 }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl md:text-5xl font-bold mb-6 gradient-text">
              خدماتنا المتكاملة
            </h2>
            <p className="text-xl text-slate-600 max-w-3xl mx-auto">
              حلول شاملة ومصممة خصيصاً لتلبية جميع احتياجاتك في إدارة الفعاليات والحجوزات.
            </p>
          </motion.div>

          <div className="grid lg:grid-cols-3 gap-8">
            {services.map((service, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.15 }}
                viewport={{ once: true, amount: 0.3 }}
                className="bg-primary/5 p-8 rounded-3xl border border-primary/10 card-hover cursor-pointer"
                onClick={() => handleFeatureClick(service.title)}
              >
                <div className="w-20 h-20 gradient-bg rounded-3xl flex items-center justify-center mb-6 shadow-lg">
                  <service.icon className="h-10 w-10 text-white" />
                </div>
                <h3 className="text-2xl font-bold mb-4 text-slate-800">{service.title}</h3>
                <p className="text-slate-600 mb-6 leading-relaxed">{service.description}</p>
                <ul className="space-y-3">
                  {service.features.map((feature, idx) => (
                    <li key={idx} className="flex items-center text-slate-700 font-medium">
                      <CheckCircle className="h-5 w-5 text-green-500 ml-3 flex-shrink-0" />
                      {feature}
                    </li>
                  ))}
                </ul>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      <Partners />

      <section className="py-24 gradient-bg text-white">
        <div className="container mx-auto px-4 text-center">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true, amount: 0.8 }}
          >
            <h2 className="text-4xl font-bold mb-6">
              هل أنت جاهز لبدء رحلتك معنا؟
            </h2>
            <p className="text-xl mb-10 max-w-2xl mx-auto opacity-90">
              انضم إلى آلاف التجار الذين يثقون في شباك التذاكر لتحويل أفكارهم إلى واقع ناجح.
            </p>
            <Button
              size="lg"
              className="bg-white text-primary hover:bg-gray-100 px-10 py-6 text-lg font-bold shadow-2xl transform hover:scale-105 transition-transform"
              onClick={() => handleNavigation('merchant-register')}
            >
              <Ticket className="ml-2 h-5 w-5" />
              ابدأ الآن مجاناً
            </Button>
          </motion.div>
        </div>
      </section>
    </div>
  );
};

export default HomePage;
