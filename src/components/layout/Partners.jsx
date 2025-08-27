import React from 'react';
import { motion } from 'framer-motion';

const partners = [
  { name: "مبتكرون عالميون", description: "شريك استراتيجي في الابتكار التقني للمناسبات", image: "https://images.unsplash.com/photo-1639168314917-53ecd2e3135c" },
  { name: "حلول المستقبل", description: "حلول دفع آمنة وموثوقة للمناسبات", image: "https://images.unsplash.com/photo-1639168314917-53ecd2e3135c" },
  { name: "عقول إبداعية", description: "خبراء في تصميم تجارب مستخدم فريدة للمناسبات", image: "https://images.unsplash.com/photo-1639168314917-53ecd2e3135c" },
  { name: "رواد التقنية", description: "رواد في تطوير البنية التحتية لفعاليات ضخمة", image: "https://images.unsplash.com/photo-1639168314917-53ecd2e3135c" },
  { name: "فعاليات الجيل القادم", description: "شريك في تنظيم الفعاليات الكبرى والمهرجانات", image: "https://images.unsplash.com/photo-1639168314917-53ecd2e3135c" },
  { name: "رأس مال استثماري", description: "دعم استثماري لتوسيع أعمال تنظيم المناسبات", image: "https://images.unsplash.com/photo-1639168314917-53ecd2e3135c" },
];

const Partners = () => {
  return (
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
            شركاء النجاح
          </h2>
          <p className="text-xl text-slate-600 max-w-3xl mx-auto">
            نثق بشركائنا الذين يشاركوننا الرؤية في تقديم أفضل الحلول التقنية لمزوّدي الخدمات وعملائهم في عالم المناسبات.
          </p>
        </motion.div>
        <div className="relative">
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
            {partners.map((partner, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, scale: 0.8 }}
                whileInView={{ opacity: 1, scale: 1 }}
                transition={{ duration: 0.5, delay: index * 0.1 }}
                viewport={{ once: true, amount: 0.5 }}
                className="flex flex-col items-center text-center"
              >
                <div className="w-24 h-24 rounded-full bg-white shadow-lg border-2 border-primary/20 flex items-center justify-center mb-4">
                   <img  className="w-16 h-16 object-contain" alt={partner.name} src={partner.image} />
                </div>
                <h3 className="font-bold text-slate-700">{partner.name}</h3>
                <p className="text-xs text-slate-500">{partner.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
};

export default Partners;