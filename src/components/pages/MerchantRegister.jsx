
import React from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Users, CheckCircle } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const MerchantRegister = ({ handleFeatureClick, handleNavigation }) => {
  const { toast } = useToast();

  const handleSubmit = (e) => {
    e.preventDefault();
    toast({
        title: (
            <div className="flex items-center gap-2 font-bold">
                <CheckCircle className="text-green-500" />
                <span>تم استلام طلبك بنجاح!</span>
            </div>
        ),
        description: "سيقوم فريقنا بمراجعة طلبك والتواصل معك خلال 24 ساعة. شكراً لانضمامك!",
        className: "bg-green-50 border-green-200",
    });
    setTimeout(() => {
        handleNavigation('home');
    }, 3000);
  }
  
  return (
    <div className="min-h-screen bg-primary/5 py-12">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="max-w-2xl mx-auto"
        >
          <div className="bg-white/70 backdrop-blur-xl rounded-2xl shadow-xl p-8 md:p-10 border">
            <div className="text-center mb-8">
              <div className="w-20 h-20 gradient-bg rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <Users className="h-10 w-10 text-white" />
              </div>
              <h1 className="text-3xl md:text-4xl font-bold gradient-text mb-2">انضم كتاجر</h1>
              <p className="text-gray-600">ابدأ رحلتك في إدارة أعمالك بكفاءة واحترافية.</p>
            </div>

            <form className="space-y-6" onSubmit={handleSubmit}>
              <div className="grid md:grid-cols-2 gap-6">
                <div>
                    <Label htmlFor="firstName">الاسم الأول</Label>
                    <Input required id="firstName" placeholder="أدخل اسمك الأول" />
                </div>
                <div>
                    <Label htmlFor="lastName">اسم العائلة</Label>
                    <Input required id="lastName" placeholder="أدخل اسم العائلة" />
                </div>
              </div>

              <div>
                <Label htmlFor="email">البريد الإلكتروني</Label>
                <Input required id="email" type="email" placeholder="example@domain.com" />
              </div>

              <div>
                <Label htmlFor="phone">رقم الهاتف</Label>
                <Input required id="phone" type="tel" placeholder="+966 5X XXX XXXX" />
              </div>

              <div>
                <Label htmlFor="activityType">نوع النشاط</Label>
                <select required id="activityType" className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all bg-white">
                  <option value="">اختر نوع النشاط</option>
                  <option value="events">تنظيم الفعاليات</option>
                  <option value="restaurant">مطعم</option>
                  <option value="exhibition">معارض</option>
                  <option value="other">أخرى</option>
                </select>
              </div>
              
              <div>
                <Label htmlFor="businessName">اسم النشاط التجاري</Label>
                <Input required id="businessName" placeholder="أدخل اسم نشاطك التجاري" />
              </div>

              <Button
                type="submit"
                size="lg"
                className="w-full gradient-bg text-white py-6 text-lg font-semibold transform hover:scale-105 transition-transform"
              >
                إرسال طلب التسجيل
              </Button>
            </form>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default MerchantRegister;
