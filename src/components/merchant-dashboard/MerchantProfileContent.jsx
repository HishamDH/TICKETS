import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Camera, Save, Shield, Globe } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const MerchantProfileContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [profileData, setProfileData] = useState({
        businessName: 'قاعة الأفراح الملكية',
        businessType: 'قاعة مناسبات',
        crNumber: '1010123456',
        email: 'royal@example.com',
        phone: '0501234567',
        address: 'الرياض، حي الياسمين، شارع الملك عبدالعزيز',
        language: 'ar',
        currency: 'SAR',
        avatar: 'https://images.unsplash.com/photo-1600486913747-55e5470d6f40?q=80&w=200',
    });
    const [passwordData, setPasswordData] = useState({ current: '', new: '', confirm: '' });

    useEffect(() => {
        const savedProfile = localStorage.getItem('lilium_merchant_profile_v1');
        if (savedProfile) {
            setProfileData(JSON.parse(savedProfile));
        }
    }, []);

    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick && typeof propHandleFeatureClick === 'function') {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    const handleProfileChange = (e) => {
        const { name, value } = e.target;
        setProfileData(prev => ({ ...prev, [name]: value }));
    };

    const handlePasswordChange = (e) => {
        const { name, value } = e.target;
        setPasswordData(prev => ({ ...prev, [name]: value }));
    };
    
    const handleSelectChange = (name, value) => {
        setProfileData(prev => ({ ...prev, [name]: value }));
    };

    const handleAvatarChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onloadend = () => {
                setProfileData(prev => ({ ...prev, avatar: reader.result }));
            };
            reader.readAsDataURL(file);
            handleFeatureClick(`تغيير صورة الملف الشخصي: ${file.name}`);
        }
    };

    const handleSaveChanges = () => {
        localStorage.setItem('lilium_merchant_profile_v1', JSON.stringify(profileData));
        handleFeatureClick("حفظ تغييرات الملف الشخصي");
        toast({ title: "تم الحفظ", description: "تم حفظ بيانات ملفك الشخصي بنجاح." });
    };

    const handleChangePassword = () => {
        if (!passwordData.new || passwordData.new !== passwordData.confirm) {
            toast({ title: "خطأ", description: "كلمة المرور الجديدة وتأكيدها غير متطابقين.", variant: "destructive" });
            return;
        }
        if (passwordData.new.length < 8) {
            toast({ title: "خطأ", description: "يجب أن تكون كلمة المرور الجديدة 8 أحرف على الأقل.", variant: "destructive" });
            return;
        }
        handleFeatureClick("تغيير كلمة المرور");
        setPasswordData({ current: '', new: '', confirm: '' });
        toast({ title: "تم التحديث", description: "تم تحديث كلمة المرور بنجاح (محاكاة)." });
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">الملف الشخصي للتاجر</h2>
            
            <Card>
                <CardHeader>
                    <CardTitle>المعلومات الأساسية</CardTitle>
                    <CardDescription>إدارة معلومات نشاطك التجاري التي تظهر للعملاء في منصة ليلة الليليوم.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div className="flex items-center gap-6">
                        <div className="relative">
                            <Avatar className="w-24 h-24 border-4 border-white shadow-md">
                                <AvatarImage src={profileData.avatar} alt={profileData.businessName} />
                                <AvatarFallback>{profileData.businessName.charAt(0)}</AvatarFallback>
                            </Avatar>
                            <Button size="icon" className="absolute bottom-0 right-0 rounded-full w-8 h-8" onClick={() => document.getElementById('avatar-upload').click()}>
                                <Camera className="w-4 h-4" />
                            </Button>
                            <Input id="avatar-upload" type="file" className="hidden" accept="image/*" onChange={handleAvatarChange} />
                        </div>
                        <div className="flex-grow grid md:grid-cols-2 gap-4">
                            <div>
                                <Label htmlFor="businessName">اسم النشاط التجاري</Label>
                                <Input id="businessName" name="businessName" value={profileData.businessName} onChange={handleProfileChange} />
                            </div>
                            <div>
                                <Label htmlFor="businessType">نوع النشاط</Label>
                                <Input id="businessType" name="businessType" value={profileData.businessType} onChange={handleProfileChange} />
                            </div>
                        </div>
                    </div>
                    <div className="grid md:grid-cols-3 gap-4">
                        <div>
                            <Label htmlFor="crNumber">رقم السجل التجاري</Label>
                            <Input id="crNumber" name="crNumber" value={profileData.crNumber} onChange={handleProfileChange} />
                        </div>
                        <div>
                            <Label htmlFor="email">البريد الإلكتروني للتواصل</Label>
                            <Input id="email" name="email" type="email" value={profileData.email} onChange={handleProfileChange} />
                        </div>
                        <div>
                            <Label htmlFor="phone">رقم الهاتف للتواصل</Label>
                            <Input id="phone" name="phone" value={profileData.phone} onChange={handleProfileChange} />
                        </div>
                    </div>
                    <div>
                        <Label htmlFor="address">عنوان النشاط الرئيسي</Label>
                        <Input id="address" name="address" value={profileData.address} onChange={handleProfileChange} />
                    </div>
                </CardContent>
                <CardFooter className="border-t pt-6">
                    <Button className="gradient-bg text-white" onClick={handleSaveChanges}><Save className="w-4 h-4 ml-2"/>حفظ التغييرات</Button>
                </CardFooter>
            </Card>

            <div className="grid lg:grid-cols-2 gap-8">
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Shield/> تغيير كلمة المرور</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div>
                            <Label htmlFor="currentPassword">كلمة المرور الحالية</Label>
                            <Input id="currentPassword" name="current" type="password" value={passwordData.current} onChange={handlePasswordChange} />
                        </div>
                        <div>
                            <Label htmlFor="newPassword">كلمة المرور الجديدة</Label>
                            <Input id="newPassword" name="new" type="password" value={passwordData.new} onChange={handlePasswordChange} />
                        </div>
                        <div>
                            <Label htmlFor="confirmPassword">تأكيد كلمة المرور الجديدة</Label>
                            <Input id="confirmPassword" name="confirm" type="password" value={passwordData.confirm} onChange={handlePasswordChange} />
                        </div>
                    </CardContent>
                    <CardFooter>
                        <Button variant="outline" onClick={handleChangePassword}>تغيير كلمة المرور</Button>
                    </CardFooter>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Globe/> إعدادات اللغة والمنطقة</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div>
                            <Label>لغة لوحة التحكم</Label>
                            <Select dir="rtl" name="language" value={profileData.language} onValueChange={(val) => handleSelectChange('language', val)}>
                                <SelectTrigger><SelectValue /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="ar">العربية</SelectItem>
                                    <SelectItem value="en">English</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <div>
                            <Label>العملة الافتراضية</Label>
                            <Select dir="rtl" name="currency" value={profileData.currency} onValueChange={(val) => handleSelectChange('currency', val)}>
                                <SelectTrigger><SelectValue /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="SAR">ريال سعودي (SAR)</SelectItem>
                                    <SelectItem value="USD">دولار أمريكي (USD)</SelectItem>
                                    <SelectItem value="AED">درهم إماراتي (AED)</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </CardContent>
                    <CardFooter>
                         <Button className="gradient-bg text-white" onClick={handleSaveChanges}><Save className="w-4 h-4 ml-2"/>حفظ الإعدادات</Button>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
});

export default MerchantProfileContent;