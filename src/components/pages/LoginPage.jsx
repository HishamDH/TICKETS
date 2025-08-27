import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useToast } from "@/components/ui/use-toast";
import { Card, CardContent, CardHeader, CardTitle, CardDescription, CardFooter } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { ArrowLeft, User, Store, LogIn, KeyRound, Mail, Lock } from 'lucide-react';

const LoginPage = ({ handleNavigation }) => {
    const { toast } = useToast();
    const [userEmail, setUserEmail] = useState('');
    const [userPassword, setUserPassword] = useState('');
    const [merchantEmail, setMerchantEmail] = useState('');
    const [merchantPassword, setMerchantPassword] = useState('');

    const handleLogin = (userType) => {
        if (userType === 'customer') {
            if (!userEmail || !userPassword) {
                toast({ title: "خطأ", description: "يرجى إدخال البريد الإلكتروني وكلمة المرور.", variant: "destructive" });
                return;
            }
            toast({ title: "تسجيل الدخول ناجح", description: "أهلاً بك مجدداً في ليلة الليليوم!" });
            handleNavigation('customer-dashboard');
        } else if (userType === 'merchant') {
            if (!merchantEmail || !merchantPassword) {
                toast({ title: "خطأ", description: "يرجى إدخال البريد الإلكتروني وكلمة المرور.", variant: "destructive" });
                return;
            }
            toast({ title: "تسجيل الدخول ناجح", description: "مرحباً بعودتك، شريكنا العزيز!" });
            handleNavigation('merchant-dashboard');
        }
    };

    return (
        <div className="min-h-screen bg-slate-50 flex items-center justify-center py-12 px-4 relative" dir="rtl">
            <div className="absolute top-6 left-6">
                <Button variant="outline" onClick={() => handleNavigation('home')}>
                    <ArrowLeft className="w-4 h-4 ml-2" /> العودة للرئيسية
                </Button>
            </div>
            <motion.div
                initial={{ opacity: 0, y: 30 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6 }}
                className="max-w-md w-full"
            >
                <Card className="shadow-2xl rounded-2xl">
                    <CardHeader className="text-center p-8">
                        <img src="https://lilium-night.com/wp-content/uploads/2024/07/logo-1-1.png" alt="شعار ليلة الليليوم" className="w-20 h-20 mx-auto mb-4" />
                        <CardTitle className="text-3xl font-bold gradient-text">تسجيل الدخول</CardTitle>
                        <CardDescription>مرحباً بعودتك! اختر نوع حسابك وسجل دخولك.</CardDescription>
                    </CardHeader>
                    <CardContent className="p-8 pt-0">
                        <Tabs defaultValue="customer" className="w-full">
                            <TabsList className="grid w-full grid-cols-2">
                                <TabsTrigger value="customer"><User className="w-4 h-4 ml-2" /> عميل</TabsTrigger>
                                <TabsTrigger value="merchant"><Store className="w-4 h-4 ml-2" /> مزود خدمة</TabsTrigger>
                            </TabsList>
                            <TabsContent value="customer" className="mt-6">
                                <form className="space-y-4" onSubmit={(e) => { e.preventDefault(); handleLogin('customer'); }}>
                                    <div className="relative">
                                        <Label htmlFor="customer-email">البريد الإلكتروني</Label>
                                        <Mail className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                                        <Input id="customer-email" type="email" placeholder="example@domain.com" value={userEmail} onChange={(e) => setUserEmail(e.target.value)} className="pr-10" />
                                    </div>
                                    <div className="relative">
                                        <Label htmlFor="customer-password">كلمة المرور</Label>
                                        <Lock className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                                        <Input id="customer-password" type="password" placeholder="••••••••" value={userPassword} onChange={(e) => setUserPassword(e.target.value)} className="pr-10" />
                                    </div>
                                    <Button type="submit" className="w-full gradient-bg text-white"><LogIn className="w-4 h-4 ml-2" />تسجيل دخول العميل</Button>
                                </form>
                            </TabsContent>
                            <TabsContent value="merchant" className="mt-6">
                                <form className="space-y-4" onSubmit={(e) => { e.preventDefault(); handleLogin('merchant'); }}>
                                    <div className="relative">
                                        <Label htmlFor="merchant-email">البريد الإلكتروني للنشاط</Label>
                                        <Mail className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                                        <Input id="merchant-email" type="email" placeholder="business@domain.com" value={merchantEmail} onChange={(e) => setMerchantEmail(e.target.value)} className="pr-10" />
                                    </div>
                                    <div className="relative">
                                        <Label htmlFor="merchant-password">كلمة المرور</Label>
                                        <Lock className="absolute top-9 right-3 h-5 w-5 text-slate-400" />
                                        <Input id="merchant-password" type="password" placeholder="••••••••" value={merchantPassword} onChange={(e) => setMerchantPassword(e.target.value)} className="pr-10" />
                                    </div>
                                    <Button type="submit" className="w-full gradient-bg text-white"><LogIn className="w-4 h-4 ml-2" />تسجيل دخول مزود الخدمة</Button>
                                </form>
                            </TabsContent>
                        </Tabs>
                    </CardContent>
                    <CardFooter className="flex-col p-8 pt-0 text-center text-sm gap-2">
                        <Button variant="link" className="p-0 h-auto" onClick={() => toast({ title: "سيتم توجيهك لصفحة استعادة كلمة المرور" })}>
                            <KeyRound className="w-4 h-4 ml-1" /> هل نسيت كلمة المرور؟
                        </Button>
                        <p>ليس لديك حساب؟ <Button variant="link" className="p-0 h-auto" onClick={() => handleNavigation('customer-register')}>أنشئ حساب عميل</Button> أو <Button variant="link" className="p-0 h-auto" onClick={() => handleNavigation('merchant-register')}>سجل كمزود خدمة</Button></p>
                    </CardFooter>
                </Card>
            </motion.div>
        </div>
    );
};

export default LoginPage;