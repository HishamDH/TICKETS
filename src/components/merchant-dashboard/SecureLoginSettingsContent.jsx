import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from "@/components/ui/dialog";
import { Shield, KeyRound, Smartphone, Copy, RefreshCw, Save } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const generateRecoveryCodes = () => {
    const codes = [];
    for (let i = 0; i < 8; i++) {
        codes.push(Math.random().toString(36).substring(2, 8).toUpperCase());
    }
    return codes;
};

const SecureLoginSettingsContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [passwordData, setPasswordData] = useState({ current: '', new: '', confirm: '' });
    const [is2faEnabled, setIs2faEnabled] = useState(false);
    const [recoveryCodes, setRecoveryCodes] = useState([]);
    const [is2faModalOpen, setIs2faModalOpen] = useState(false);
    const [verificationCode, setVerificationCode] = useState('');

    useEffect(() => {
        const saved2fa = localStorage.getItem('lilium_merchant_2fa_enabled_v1');
        const savedCodes = localStorage.getItem('lilium_merchant_recovery_codes_v1');
        setIs2faEnabled(saved2fa === 'true');
        if (savedCodes) {
            setRecoveryCodes(JSON.parse(savedCodes));
        } else if (saved2fa === 'true') {
            const newCodes = generateRecoveryCodes();
            setRecoveryCodes(newCodes);
            localStorage.setItem('lilium_merchant_recovery_codes_v1', JSON.stringify(newCodes));
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

    const handlePasswordChange = (e) => {
        const { name, value } = e.target;
        setPasswordData(prev => ({ ...prev, [name]: value }));
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

    const handle2faToggle = (checked) => {
        if (checked) {
            setIs2faModalOpen(true);
            handleFeatureClick("فتح نافذة إعداد المصادقة الثنائية");
        } else {
            setIs2faEnabled(false);
            localStorage.setItem('lilium_merchant_2fa_enabled_v1', 'false');
            localStorage.removeItem('lilium_merchant_recovery_codes_v1');
            setRecoveryCodes([]);
            toast({ title: "تم التعطيل", description: "تم تعطيل المصادقة الثنائية." });
            handleFeatureClick("تعطيل المصادقة الثنائية");
        }
    };

    const handleVerifyAndEnable2fa = () => {
        if (verificationCode === '123456') {
            const newCodes = generateRecoveryCodes();
            setIs2faEnabled(true);
            setRecoveryCodes(newCodes);
            localStorage.setItem('lilium_merchant_2fa_enabled_v1', 'true');
            localStorage.setItem('lilium_merchant_recovery_codes_v1', JSON.stringify(newCodes));
            setIs2faModalOpen(false);
            setVerificationCode('');
            toast({ title: "تم التفعيل بنجاح!", description: "تم تفعيل المصادقة الثنائية لحسابك." });
            handleFeatureClick("تفعيل المصادقة الثنائية بنجاح");
        } else {
            toast({ title: "خطأ", description: "رمز التحقق غير صحيح. حاول مرة أخرى.", variant: "destructive" });
            handleFeatureClick("فشل التحقق من رمز المصادقة الثنائية");
        }
    };

    const handleCopyCodes = () => {
        navigator.clipboard.writeText(recoveryCodes.join('\n'));
        toast({ title: "تم النسخ", description: "تم نسخ رموز الاسترداد إلى الحافظة." });
        handleFeatureClick("نسخ رموز الاسترداد");
    };

    const handleRegenerateCodes = () => {
        const newCodes = generateRecoveryCodes();
        setRecoveryCodes(newCodes);
        localStorage.setItem('lilium_merchant_recovery_codes_v1', JSON.stringify(newCodes));
        toast({ title: "تم التحديث", description: "تم إنشاء رموز استرداد جديدة." });
        handleFeatureClick("إعادة إنشاء رموز الاسترداد");
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">إعدادات تسجيل الدخول الآمن</h2>
            
            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><KeyRound/> تغيير كلمة المرور</CardTitle>
                    <CardDescription>للحفاظ على أمان حسابك، نوصي بتغيير كلمة المرور بشكل دوري.</CardDescription>
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
                    <CardTitle className="flex items-center gap-2"><Shield/> المصادقة الثنائية (2FA)</CardTitle>
                    <CardDescription>أضف طبقة حماية إضافية لحسابك عن طريق طلب رمز تحقق عند تسجيل الدخول.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <Label htmlFor="2fa-switch" className="text-lg font-semibold">تفعيل المصادقة الثنائية</Label>
                        <Switch id="2fa-switch" checked={is2faEnabled} onCheckedChange={handle2faToggle} />
                    </div>
                    {is2faEnabled && (
                        <div className="mt-6 space-y-4">
                            <h3 className="font-semibold text-slate-800">رموز الاسترداد</h3>
                            <p className="text-sm text-slate-500">احفظ هذه الرموز في مكان آمن. يمكنك استخدامها للوصول إلى حسابك في حال فقدان الوصول إلى تطبيق المصادقة.</p>
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-3 p-4 border rounded-md bg-slate-50 font-mono text-center">
                                {recoveryCodes.map(code => <div key={code}>{code}</div>)}
                            </div>
                            <div className="flex gap-2">
                                <Button variant="outline" onClick={handleCopyCodes}><Copy className="w-4 h-4 ml-2"/>نسخ الرموز</Button>
                                <Button variant="outline" onClick={handleRegenerateCodes}><RefreshCw className="w-4 h-4 ml-2"/>إعادة إنشاء</Button>
                            </div>
                        </div>
                    )}
                </CardContent>
            </Card>

            <Dialog open={is2faModalOpen} onOpenChange={setIs2faModalOpen}>
                <DialogContent dir="rtl" className="sm:max-w-md">
                    <DialogHeader>
                        <DialogTitle>إعداد المصادقة الثنائية</DialogTitle>
                        <DialogDescription>
                            امسح رمز QR باستخدام تطبيق المصادقة (مثل Google Authenticator) ثم أدخل الرمز للتحقق.
                        </DialogDescription>
                    </DialogHeader>
                    <div className="flex flex-col items-center gap-4 py-4">
                        <div className="p-4 bg-white rounded-lg">
                            <img  alt="QR Code for 2FA setup" src="https://images.unsplash.com/photo-1626682561113-d1db402cc866" />
                        </div>
                        <div className="w-full space-y-2">
                            <Label htmlFor="verificationCode">رمز التحقق</Label>
                            <Input 
                                id="verificationCode" 
                                placeholder="أدخل الرمز المكون من 6 أرقام" 
                                value={verificationCode}
                                onChange={(e) => setVerificationCode(e.target.value)}
                            />
                        </div>
                    </div>
                    <DialogFooter className="gap-2">
                        <Button variant="ghost" onClick={() => setIs2faModalOpen(false)}>إلغاء</Button>
                        <Button onClick={handleVerifyAndEnable2fa}>تحقق وتفعيل</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
});

export default SecureLoginSettingsContent;