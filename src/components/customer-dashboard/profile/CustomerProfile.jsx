import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Upload, Save, Edit2, ShieldCheck } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Textarea } from '@/components/ui/textarea';

const CustomerProfile = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [profileData, setProfileData] = useState(() => {
        const savedProfile = localStorage.getItem('lilium_customer_profile_v1');
        return savedProfile ? JSON.parse(savedProfile) : {
            name: 'نورة عبدالله',
            email: 'noura@example.com',
            phone: '966501234567',
            bio: 'مهتمة بتنظيم الفعاليات وحضور المناسبات الاجتماعية. أبحث دائماً عن تجارب فريدة.',
            avatarUrl: 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?q=80&w=200',
        };
    });
    const [notifications, setNotifications] = useState(() => {
        const savedNotifications = localStorage.getItem('lilium_customer_notifications_v1');
        return savedNotifications ? JSON.parse(savedNotifications) : {
            emailBookings: true,
            emailOffers: true,
            smsReminders: true,
            smsChanges: false,
        };
    });
    const [isEditing, setIsEditing] = useState(false);

    useEffect(() => {
        if (isEditing) {
            localStorage.setItem('lilium_customer_profile_v1', JSON.stringify(profileData));
            localStorage.setItem('lilium_customer_notifications_v1', JSON.stringify(notifications));
        }
    }, [profileData, notifications, isEditing]);
    
    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick) {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    const handleProfileChange = (e) => {
        setProfileData(prev => ({ ...prev, [e.target.name]: e.target.value }));
    };

    const handleNotificationChange = (key) => {
        setNotifications(prev => ({ ...prev, [key]: !prev[key] }));
    };

    const handleSaveProfile = () => {
        toast({
            title: "تم حفظ الملف الشخصي",
            description: "تم تحديث معلومات ملفك الشخصي وتفضيلات الإشعارات بنجاح.",
        });
        handleFeatureClick("حفظ تغييرات الملف الشخصي");
        setIsEditing(false);
    };
    
    const handleAvatarUpload = () => {
        handleFeatureClick("تغيير الصورة الشخصية");
    };

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <h1 className="text-3xl font-bold text-slate-800">الملف الشخصي</h1>
                {!isEditing ? (
                    <Button variant="outline" onClick={() => setIsEditing(true)}><Edit2 className="w-4 h-4 ml-2"/>تعديل الملف</Button>
                ) : (
                    <Button onClick={handleSaveProfile} className="gradient-bg text-white"><Save className="w-4 h-4 ml-2"/>حفظ التغييرات</Button>
                )}
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>المعلومات الأساسية</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div className="flex flex-col sm:flex-row items-center gap-6">
                        <Avatar className="w-24 h-24">
                            <AvatarImage src={profileData.avatarUrl} />
                            <AvatarFallback>{profileData.name.charAt(0)}</AvatarFallback>
                        </Avatar>
                        {isEditing && <Button variant="outline" onClick={handleAvatarUpload}><Upload className="w-4 h-4 ml-2"/>تغيير الصورة</Button>}
                    </div>
                    <div className="grid md:grid-cols-2 gap-4">
                        <div><Label htmlFor="name">الاسم</Label><Input id="name" name="name" value={profileData.name} onChange={handleProfileChange} disabled={!isEditing} /></div>
                        <div><Label htmlFor="email">البريد الإلكتروني</Label><Input id="email" name="email" value={profileData.email} disabled /></div>
                        <div><Label htmlFor="phone">رقم الجوال</Label><Input id="phone" name="phone" value={profileData.phone} onChange={handleProfileChange} disabled={!isEditing} /></div>
                        {isEditing && <div><Label htmlFor="password">كلمة المرور الجديدة</Label><Input id="password" type="password" placeholder="اتركها فارغة لعدم التغيير" onChange={()=> handleFeatureClick("تغيير كلمة المرور")} /></div>}
                    </div>
                    <div>
                        <Label htmlFor="bio">نبذة تعريفية (اختياري)</Label>
                        <Textarea id="bio" name="bio" value={profileData.bio} onChange={handleProfileChange} placeholder="صف اهتماماتك أو ما تبحث عنه..." disabled={!isEditing} />
                    </div>
                </CardContent>
            </Card>
             <Card>
                <CardHeader>
                    <CardTitle>إدارة الإشعارات</CardTitle>
                    <CardDescription>اختر كيف تريد أن تتلقى التحديثات والتنبيهات المتعلقة بحجوزاتك وعروض المنصة.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                     <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="emailBookings">إشعارات البريد الإلكتروني (تأكيدات الحجز، تحديثات)</Label>
                        <Switch id="emailBookings" checked={notifications.emailBookings} onCheckedChange={() => handleNotificationChange('emailBookings')} disabled={!isEditing} />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="emailOffers">إشعارات البريد الإلكتروني (العروض والتخفيضات)</Label>
                        <Switch id="emailOffers" checked={notifications.emailOffers} onCheckedChange={() => handleNotificationChange('emailOffers')} disabled={!isEditing} />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="smsReminders">رسائل نصية (SMS) (تذكيرات المواعيد)</Label>
                        <Switch id="smsReminders" checked={notifications.smsReminders} onCheckedChange={() => handleNotificationChange('smsReminders')} disabled={!isEditing} />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="smsChanges">رسائل نصية (SMS) (تغييرات هامة في الحجز)</Label>
                        <Switch id="smsChanges" checked={notifications.smsChanges} onCheckedChange={() => handleNotificationChange('smsChanges')} disabled={!isEditing} />
                    </div>
                </CardContent>
            </Card>
            {isEditing && (
                <Card className="border-blue-500 bg-blue-50">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2 text-blue-800"><ShieldCheck/> الأمان والخصوصية</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-3">
                        <Button variant="outline" className="border-blue-300 text-blue-700 hover:bg-blue-100" onClick={() => handleFeatureClick("تغيير كلمة المرور")}>تغيير كلمة المرور</Button>
                        <Button variant="outline" className="border-blue-300 text-blue-700 hover:bg-blue-100" onClick={() => handleFeatureClick("إدارة الأجهزة المتصلة")}>إدارة الأجهزة المتصلة</Button>
                        <Button variant="destructive" className="bg-red-500 hover:bg-red-600" onClick={() => {toast({title: "طلب حذف الحساب", variant: "destructive"}); handleFeatureClick("طلب حذف الحساب");}}>طلب حذف الحساب</Button>
                    </CardContent>
                </Card>
            )}
        </div>
    );
};

export default CustomerProfile;