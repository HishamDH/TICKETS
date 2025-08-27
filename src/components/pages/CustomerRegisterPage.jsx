import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { useToast } from "@/components/ui/use-toast";
import { Card, CardContent, CardHeader, CardTitle, CardDescription, CardFooter } from '@/components/ui/card';
import { UserPlus, ArrowLeft, CheckCircle, User, Mail, Phone, Lock } from 'lucide-react';

const CustomerRegisterPage = ({ handleNavigation }) => {
  const { toast } = useToast();
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    password: '',
    confirmPassword: '',
    agreedToTerms: false,
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleCheckboxChange = (checked) => {
    setFormData(prev => ({ ...prev, agreedToTerms: checked }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (formData.password !== formData.confirmPassword) {
      toast({ title: "خطأ", description: "كلمة المرور وتأكيدها غير متطابقين.", variant: "destructive" });
      return;
    }
    if (!formData.agreedToTerms) {
      toast({ title: "خطأ", description: "يجب الموافقة على الشروط والأحكام.", variant: "destructive" });
      return;
    }
    
    toast({
        title: (
            <div className="flex items-center gap-2 font-bold">
                <CheckCircle className="text-green-500" />
                <span>تم إنشاء حسابك بنجاح!</span>
            </div>
        ),
        description: `أهلاً بك ${formData.name} في ليلة الليليوم! سيتم توجيهك لصفحة تسجيل الدخول.`,
        className: "bg-green-50 border-green-200",
    });

    localStorage.setItem('lilium_night_registered_customer', JSON.stringify({ email: formData.email, name: formData.name }));
    
    setTimeout(() => {
        handleNavigation('login');
    }, 2000);
  };

  return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center py-12 px-4" dir="rtl">
        <div className="absolute top-6 left-6">
            <Button variant="outline" onClick={() => handleNavigation('home')}>
                <ArrowLeft className="w-4 h-4 ml-2" /> العودة للرئيسية
            </Button>
        </div>
        <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            className="max-w-lg w-full"
        >
            <Card className="shadow-2xl rounded-2xl">
                <CardHeader className="text-center p-8">
                     <img src="https://lilium-night.com/wp-content/uploads/2024/07/logo-1-1.png" alt="شعار ليلة الليليوم" className="w-20 h-20 mx-auto mb-4" />
                    <CardTitle className="text-3xl font-bold gradient-text">إنشاء حساب جديد</CardTitle>
                    <CardDescription>انضم إلينا وابدأ بتخطيط مناسباتك القادمة بكل سهولة.</CardDescription>
                </CardHeader>
                <CardContent className="p-8 pt-0">
                    <form className="space-y-4" onSubmit={handleSubmit}>
                        <div className="relative">
                            <Label htmlFor="name">الاسم الكامل</Label>
                            <User className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                            <Input required id="name" name="name" placeholder="أدخل اسمك الكامل" value={formData.name} onChange={handleInputChange} className="pr-10" />
                        </div>
                        <div className="relative">
                            <Label htmlFor="email">البريد الإلكتروني</Label>
                            <Mail className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                            <Input required id="email" name="email" type="email" placeholder="example@domain.com" value={formData.email} onChange={handleInputChange} className="pr-10" />
                        </div>
                        <div className="relative">
                            <Label htmlFor="phone">رقم الجوال (اختياري)</Label>
                            <Phone className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                            <Input id="phone" name="phone" type="tel" placeholder="+966 5X XXX XXXX" value={formData.phone} onChange={handleInputChange} className="pr-10" />
                        </div>
                        <div className="grid md:grid-cols-2 gap-4">
                            <div className="relative">
                                <Label htmlFor="password">كلمة المرور</Label>
                                <Lock className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                                <Input required id="password" name="password" type="password" placeholder="••••••••" value={formData.password} onChange={handleInputChange} className="pr-10" />
                            </div>
                            <div className="relative">
                                <Label htmlFor="confirmPassword">تأكيد كلمة المرور</Label>
                                <Lock className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                                <Input required id="confirmPassword" name="confirmPassword" type="password" placeholder="••••••••" value={formData.confirmPassword} onChange={handleInputChange} className="pr-10" />
                            </div>
                        </div>
                        <div className="flex items-center space-x-2 space-x-reverse pt-2">
                            <Checkbox id="terms" checked={formData.agreedToTerms} onCheckedChange={handleCheckboxChange} />
                            <Label htmlFor="terms" className="text-sm font-normal text-slate-600 mb-0">
                                أوافق على <Button variant="link" className="p-0 h-auto" onClick={() => handleNavigation('legal')}>الشروط والأحكام</Button> وسياسة الخصوصية.
                            </Label>
                        </div>
                        <Button type="submit" size="lg" className="w-full gradient-bg text-white py-6 text-lg font-semibold mt-4">
                            <UserPlus className="w-5 h-5 ml-2" />
                            إنشاء الحساب
                        </Button>
                    </form>
                </CardContent>
                <CardFooter className="p-8 pt-0 text-center text-sm">
                    <p>لديك حساب بالفعل؟ <Button variant="link" className="p-0 h-auto" onClick={() => handleNavigation('login')}>سجل دخولك من هنا</Button></p>
                </CardFooter>
            </Card>
        </motion.div>
    </div>
  );
};

export default CustomerRegisterPage;