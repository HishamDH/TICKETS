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
  Building,
  PartyPopper,
  Camera,
  Briefcase,
  Gift,
  ChevronLeft
} from 'lucide-react';
import Partners from '@/components/layout/Partners';
import { useToast } from "@/components/ui/use-toast";

const HomePage = ({ handleNavigation }) => {
  const { toast } = useToast();
  const handleFeatureClick = (featureName) => {
    toast({
        title: "🚧 ميزة قيد التطوير",
        description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
        variant: "default",
    });
  };
  
  const features = [
    {
      icon: Globe,
      title: "منصة شاملة ومتكاملة",
      description: "كل ما تحتاجه لتنظيم مناسبتك في مكان واحد، من الحجز إلى التقييم."
    },
    {
      icon: Smartphone,
      title: "تجربة رقمية عصرية",
      description: "تصميم سهل الاستخدام ومتجاوب مع جميع الأجهزة لتجربة حجز سلسة."
    },
    {
      icon: Lock,
      title: "أمان وموثوقية عالية",
      description: "نظام حماية متقدم لبياناتك ومدفوعاتك، مع عقود إلكترونية آمنة."
    },
    {
      icon: Zap,
      title: "حلول تقنية ذكية",
      description: "أدوات للحجز، الدفع، التمويل، إدارة المخزون، والتسويق بذكاء."
    },
    {
      icon: TrendingUp,
      title: "تقارير وتحليلات",
      description: "إحصائيات دقيقة لمزوّدي الخدمات لمتابعة الأداء واتخاذ قرارات أفضل."
    },
    {
      icon: Award,
      title: "دعم لكافة المناسبات",
      description: "من حفلات الزفاف إلى فعاليات الشركات، نلبي جميع احتياجاتك."
    }
  ];

  const services = [
    {
      icon: PartyPopper,
      title: "حفلات الزفاف والمناسبات",
      description: "قاعات، تصوير، تجميل، ضيافة، وكل ما يلزم لليلة العمر.",
      features: ["حجز قاعات وقصور", "خدمات تصوير وتجميل", "تنسيق زهور ودعوات", "ضيافة وبوفيهات فاخرة"]
    },
    {
      icon: Briefcase,
      title: "فعاليات الشركات",
      description: "تنظيم احترافي لفعاليات الشركات، عشاء العمل، واحتفالات الموظفين.",
      features: ["حجز قاعات اجتماعات", "خدمات إعاشة متكاملة", "تنظيم لوجستي وترفيهي", "تغطية إعلامية وتصوير"]
    },
    {
      icon: Gift,
      title: "المناسبات الخاصة",
      description: "تخطيط وتنفيذ حفلات التخرج، أعياد الميلاد، وغيرها من المناسبات السعيدة.",
      features: ["تنسيق ديكورات وثيمات", "خدمات ترفيهية متنوعة", "تأجير مستلزمات الحفلات", "حلويات وكيكات مخصصة"]
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
                <img  class="w-32 h-32 mx-auto mb-6 floating-animation" alt="شعار ليلة الليليوم المتألق" src="https://images.unsplash.com/photo-1557845767-9cc6526890f7" />
            </motion.div>

            <h1 className="text-5xl md:text-7xl font-extrabold mb-6 gradient-text">
              ليلة الليليوم
            </h1>
            
            <p className="text-xl md:text-2xl text-slate-700 mb-8 leading-relaxed">
              منصتك الرقمية الشاملة لتنظيم أروع المناسبات
            </p>
            
            <p className="text-lg text-slate-500 mb-12 max-w-2xl mx-auto">
              نجمع بين العملاء ومزوّدي الخدمات بأسلوب عصري، سهل، وآمن. نهدف إلى تبسيط كل ما يتعلق بالحفلات والفعاليات، من الحجز وحتى التقييم، عبر تجربة رقمية متكاملة.
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
                onClick={() => handleNavigation('services-showcase')}
              >
                <ChevronLeft className="mr-2 h-5 w-5" />
                اكتشف الخدمات الآن
              </Button>
              
              <Button
                variant="outline"
                size="lg"
                className="border-2 border-primary text-primary hover:bg-primary hover:text-white px-10 py-6 text-lg font-semibold"
                onClick={() => handleNavigation('merchant-register')}
              >
                <Users className="ml-2 h-5 w-5" />
                انضم كمزوّد خدمة
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
              لماذا ليلة الليليوم؟
            </h2>
            <p className="text-xl text-slate-600 max-w-3xl mx-auto">
              نوفر لك كل ما تحتاجه لتنظيم مناسبات لا تُنسى، مع التركيز على الجودة والابتكار.
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
                onClick={() => { handleFeatureClick(feature.title); handleNavigation('features');}}
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
              خدماتنا المتكاملة للمناسبات
            </h2>
            <p className="text-xl text-slate-600 max-w-3xl mx-auto">
              حلول شاملة ومصممة خصيصاً لتلبية جميع احتياجاتك في تنظيم وإدارة مناسباتك السعيدة.
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
                onClick={() => { handleFeatureClick(service.title); handleNavigation('services-showcase');}}
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
              هل أنت جاهز لتنظيم مناسبتك القادمة؟
            </h2>
            <p className="text-xl mb-10 max-w-2xl mx-auto opacity-90">
              انضم إلى عملائنا السعداء ومزوّدي الخدمات المتميزين الذين يثقون في ليلة الليليوم.
            </p>
            <Button
              size="lg"
              className="bg-white text-primary hover:bg-gray-100 px-10 py-6 text-lg font-bold shadow-2xl transform hover:scale-105 transition-transform"
              onClick={() => { handleFeatureClick('ابدأ الآن'); handleNavigation('services-showcase');}}
            >
              <Ticket className="ml-2 h-5 w-5" />
              ابدأ الآن
            </Button>
          </motion.div>
        </div>
      </section>
    </div>
  );
};

export default HomePage;