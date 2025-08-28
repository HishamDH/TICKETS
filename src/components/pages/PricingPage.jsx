import React from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Check, Star, Zap, Building } from 'lucide-react';

const PricingCard = ({ plan, isPopular, handleNavigation }) => (
    <motion.div
        initial={{ opacity: 0, y: 30 }}
        whileInView={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.6 }}
        viewport={{ once: true, amount: 0.5 }}
        className={`relative bg-white rounded-3xl p-8 shadow-xl border ${isPopular ? 'border-primary' : 'border-slate-200'}`}
    >
        {isPopular && (
            <div className="absolute top-0 right-8 -translate-y-1/2 bg-primary text-white px-4 py-1.5 rounded-full text-sm font-semibold flex items-center gap-2">
                <Star className="h-4 w-4" />
                الأكثر شيوعاً
            </div>
        )}
        <div className="text-center">
            <div className={`w-16 h-16 ${plan.iconBg} rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md`}>
                <plan.icon className="h-8 w-8 text-white" />
            </div>
            <h3 className="text-2xl font-bold text-slate-800 mb-2">{plan.name}</h3>
            <p className="text-slate-500 mb-6">{plan.description}</p>
            <div className="mb-8">
                <span className="text-4xl font-extrabold text-slate-900">{plan.price}</span>
                <span className="text-slate-500 ml-1">{plan.period}</span>
            </div>
        </div>
        
        <ul className="space-y-4 mb-10">
            {plan.features.map((feature, index) => (
                <li key={index} className="flex items-center">
                    <div className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0">
                        <Check className="h-3.5 w-3.5 text-green-600" />
                    </div>
                    <span className="text-slate-600">{feature}</span>
                </li>
            ))}
        </ul>

        <Button
            size="lg"
            className={`w-full py-6 text-lg font-bold ${isPopular ? 'gradient-bg text-white' : 'bg-primary/10 text-primary hover:bg-primary/20'}`}
            onClick={() => handleNavigation('merchant-register')}
        >
            {plan.cta}
        </Button>
    </motion.div>
);

const PricingPage = ({ handleNavigation, handleFeatureClick }) => {
    const plans = [
        {
            name: "الأساسية",
            price: "5%",
            period: "+ 1 ريال / تذكرة",
            description: "مثالية للبدايات والفعاليات الصغيرة.",
            icon: Zap,
            iconBg: "bg-blue-500",
            features: [
                "موقع فرعي جاهز",
                "دعم 3 فعاليات نشطة",
                "نظام حجز أساسي",
                "سحب الأرباح خلال 48 ساعة",
                "دعم فني عبر البريد الإلكتروني"
            ],
            cta: "ابدأ الآن"
        },
        {
            name: "الاحترافية",
            price: "3.5%",
            period: "+ 0.5 ريال / تذكرة",
            description: "للتجار المتمرسين والشركات النامية.",
            icon: Star,
            iconBg: "gradient-bg",
            features: [
                "كل مميزات الخطة الأساسية",
                "عدد فعاليات غير محدود",
                "تخصيص كامل للموقع الفرعي",
                "إدارة فريق العمل بصلاحيات",
                "تقارير وتحليلات متقدمة",
                "دعم فني فوري (شات وهاتف)"
            ],
            cta: "اختر الخطة الاحترافية",
            isPopular: true
        },
        {
            name: "المؤسسات",
            price: "مخصص",
            period: "حلول متكاملة",
            description: "للمعارض الكبرى والشركات الرائدة.",
            icon: Building,
            iconBg: "bg-slate-800",
            features: [
                "كل مميزات الخطة الاحترافية",
                "مدير حساب مخصص",
                "حلول دفع مخصصة",
                "ربط API مع أنظمة خارجية",
                "دعم فني على مدار الساعة"
            ],
            cta: "تواصل مع المبيعات"
        }
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
                    <h1 className="text-4xl md:text-5xl font-extrabold gradient-text mb-4">أسعار شفافة تناسب الجميع</h1>
                    <p className="text-lg text-slate-600 max-w-3xl mx-auto">
                        اختر الخطة التي تناسب حجم أعمالك وطموحاتك، بلا عقود طويلة الأمد أو رسوم خفية.
                    </p>
                </motion.div>

                <div className="grid lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    {plans.map((plan, index) => (
                        <PricingCard key={index} plan={plan} isPopular={plan.isPopular || false} handleNavigation={handleNavigation} />
                    ))}
                </div>
            </div>
        </div>
    );
};

export default PricingPage;