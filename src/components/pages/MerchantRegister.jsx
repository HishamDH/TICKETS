import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { CheckCircle, ArrowLeft, Briefcase, FileText, MapPin, User, Mail, Phone, Lock, Info } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Card, CardContent, CardHeader, CardTitle, CardDescription, CardFooter } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';

const MerchantRegister = ({ handleNavigation }) => {
  const { toast } = useToast();
  const [step, setStep] = useState(1);
  const [formData, setFormData] = useState({
    businessName: '',
    serviceType: '',
    crNumber: '',
    contactPerson: '',
    email: '',
    phone: '',
    city: '',
    password: '',
    confirmPassword: '',
    notes: '',
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSelectChange = (name, value) => {
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const validateStep1 = () => {
    return formData.businessName && formData.serviceType && formData.crNumber && formData.city;
  };

  const nextStep = () => {
    if (step === 1 && !validateStep1()) {
      toast({
        title: "بيانات غير مكتملة",
        description: "يرجى ملء جميع الحقول المطلوبة في هذه الخطوة.",
        variant: "destructive",
      });
      return;
    }
    setStep(s => s + 1);
  };
  const prevStep = () => setStep(s => s - 1);

  const handleSubmit = (e) => {
    e.preventDefault();
    if (formData.password !== formData.confirmPassword) {
      toast({
        title: "خطأ في كلمة المرور",
        description: "كلمة المرور وتأكيدها غير متطابقين.",
        variant: "destructive",
      });
      return;
    }
    if (!formData.contactPerson || !formData.email || !formData.phone || !formData.password) {
        toast({
            title: "بيانات غير مكتملة",
            description: "يرجى ملء جميع الحقول المطلوبة.",
            variant: "destructive",
        });
        return;
    }

    toast({
        title: (
            <div className="flex items-center gap-2 font-bold">
                <CheckCircle className="text-green-500" />
                <span>تم استلام طلبك بنجاح!</span>
            </div>
        ),
        description: "سيقوم فريقنا بمراجعة طلبك والتواصل معك خلال 24 ساعة. شكراً لانضمامك إلى ليلة الليليوم!",
        className: "bg-green-50 border-green-200",
    });
    
    localStorage.setItem('lilium_night_registered_merchant', JSON.stringify({ email: formData.email, businessName: formData.businessName }));

    setTimeout(() => {
        handleNavigation('login');
    }, 2000);
  }
  
  return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center py-12 px-4" dir="rtl">
        <div className="absolute top-6 left-6">
            <Button variant="outline" onClick={() => handleNavigation('home')}>
                <ArrowLeft className="w-4 h-4 ml-2" /> العودة للرئيسية
            </Button>
        </div>
      <motion.div
        initial={{ opacity: 0, scale: 0.95 }}
        animate={{ opacity: 1, scale: 1 }}
        transition={{ duration: 0.5 }}
        className="max-w-2xl w-full"
      >
        <Card className="shadow-2xl rounded-2xl">
          <CardHeader className="text-center p-8">
             <img  alt="شعار ليلة الليليوم" className="w-20 h-20 mx-auto mb-4" src="https://images.unsplash.com/photo-1672771642190-007f7d27a5b2" />
            <CardTitle className="text-3xl font-bold gradient-text">انضم كمزود خدمة</CardTitle>
            <CardDescription className="text-slate-600">ابدأ رحلتك في تقديم خدماتك عبر منصة ليلة الليليوم.</CardDescription>
             <div className="w-full bg-slate-200 h-2 rounded-full mt-4 overflow-hidden">
                <motion.div 
                  className="bg-primary h-2 rounded-full"
                  initial={{ width: '0%' }}
                  animate={{ width: step === 1 ? '50%' : '100%' }}
                  transition={{ type: 'spring', stiffness: 100, damping: 20 }}
                />
            </div>
          </CardHeader>

          <CardContent className="px-8 pb-4">
            <form id="registration-form" onSubmit={handleSubmit}>
              <AnimatePresence mode="wait">
              {step === 1 && (
                  <motion.div
                      key="step1"
                      initial={{ opacity: 0, x: 50 }}
                      animate={{ opacity: 1, x: 0 }}
                      exit={{ opacity: 0, x: -50 }}
                      transition={{ duration: 0.3 }}
                      className="space-y-4"
                  >
                      <div className="grid md:grid-cols-2 gap-4">
                          <div className="relative">
                              <Label htmlFor="businessName">اسم النشاط التجاري</Label>
                              <Briefcase className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                              <Input required name="businessName" value={formData.businessName} onChange={handleInputChange} placeholder="مثال: قاعة الأفراح الملكية" className="pr-10" />
                          </div>
                          <div>
                              <Label htmlFor="serviceType">نوع الخدمة المقدمة</Label>
                              <Select required onValueChange={(val) => handleSelectChange('serviceType', val)} name="serviceType" value={formData.serviceType}>
                                  <SelectTrigger><SelectValue placeholder="اختر نوع خدمتك" /></SelectTrigger>
                                  <SelectContent>
                                      <SelectItem value="venue">قاعات وقصور</SelectItem>
                                      <SelectItem value="catering">إعاشة وبوفيه</SelectItem>
                                      <SelectItem value="photography">تصوير وفيديو</SelectItem>
                                      <SelectItem value="other">أخرى</SelectItem>
                                  </SelectContent>
                              </Select>
                          </div>
                      </div>
                      <div className="relative">
                          <Label htmlFor="crNumber">رقم السجل التجاري</Label>
                          <FileText className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                          <Input required name="crNumber" value={formData.crNumber} onChange={handleInputChange} placeholder="1010XXXXXX" className="pr-10" />
                      </div>
                      <div>
                          <Label htmlFor="city">المدينة</Label>
                           <Select required onValueChange={(val) => handleSelectChange('city', val)} name="city" value={formData.city}>
                              <SelectTrigger><MapPin className="inline-block w-4 h-4 ml-2" /> <SelectValue placeholder="اختر المدينة" /></SelectTrigger>
                              <SelectContent>
                                  <SelectItem value="riyadh">الرياض</SelectItem>
                                  <SelectItem value="jeddah">جدة</SelectItem>
                                  <SelectItem value="dammam">الدمام</SelectItem>
                                  <SelectItem value="other_city">مدينة أخرى</SelectItem>
                              </SelectContent>
                          </Select>
                      </div>
                  </motion.div>
              )}

              {step === 2 && (
                  <motion.div
                      key="step2"
                      initial={{ opacity: 0, x: 50 }}
                      animate={{ opacity: 1, x: 0 }}
                      exit={{ opacity: 0, x: -50 }}
                      transition={{ duration: 0.3 }}
                      className="space-y-4"
                  >
                       <div className="relative">
                          <Label htmlFor="contactPerson">اسم مسؤول التواصل</Label>
                          <User className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                          <Input required name="contactPerson" value={formData.contactPerson} onChange={handleInputChange} placeholder="أدخل اسم المسؤول" className="pr-10" />
                      </div>
                      <div className="grid md:grid-cols-2 gap-4">
                           <div className="relative">
                              <Label htmlFor="email">البريد الإلكتروني</Label>
                              <Mail className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                              <Input required name="email" type="email" value={formData.email} onChange={handleInputChange} placeholder="example@domain.com" className="pr-10" />
                          </div>
                          <div className="relative">
                              <Label htmlFor="phone">رقم الجوال</Label>
                              <Phone className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                              <Input required name="phone" type="tel" value={formData.phone} onChange={handleInputChange} placeholder="+966 5X XXX XXXX" className="pr-10" />
                          </div>
                      </div>
                      <div className="grid md:grid-cols-2 gap-4">
                          <div className="relative">
                              <Label htmlFor="password">كلمة المرور</Label>
                              <Lock className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                              <Input required name="password" type="password" value={formData.password} onChange={handleInputChange} placeholder="••••••••" className="pr-10" />
                          </div>
                          <div className="relative">
                              <Label htmlFor="confirmPassword">تأكيد كلمة المرور</Label>
                              <Lock className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                              <Input required name="confirmPassword" type="password" value={formData.confirmPassword} onChange={handleInputChange} placeholder="••••••••" className="pr-10" />
                          </div>
                      </div>
                      <div className="relative">
                        <Label htmlFor="notes">نبذة عن النشاط (اختياري)</Label>
                        <Info className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                        <Textarea name="notes" value={formData.notes} onChange={handleInputChange} placeholder="صف نشاطك التجاري وما يميز خدماتك..." className="pr-10" />
                      </div>
                  </motion.div>
              )}
              </AnimatePresence>
            </form>
          </CardContent>
          <CardFooter className="p-8 flex justify-between">
              {step > 1 && (
                  <Button variant="outline" onClick={prevStep}>
                      السابق
                  </Button>
              )}
              {step < 2 ? (
                  <Button onClick={nextStep} className="gradient-bg text-white ml-auto">
                      التالي
                  </Button>
              ) : (
                  <Button type="submit" form="registration-form" className="gradient-bg text-white">
                      إرسال طلب التسجيل
                  </Button>
              )}
          </CardFooter>
          <div className="text-center text-sm pb-8">
            <p>لديك حساب بالفعل؟ <Button variant="link" className="p-0 h-auto" onClick={() => handleNavigation('login')}>سجل دخولك</Button></p>
          </div>
        </Card>
      </motion.div>
    </div>
  );
};

export default MerchantRegister;