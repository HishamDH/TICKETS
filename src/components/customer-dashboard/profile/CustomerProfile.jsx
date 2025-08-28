
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Upload } from 'lucide-react';

const CustomerProfile = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">الملف الشخصي</h1>
                <p className="text-slate-500 mt-1">إدارة معلومات حسابك وتفضيلات الإشعارات.</p>
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>المعلومات الأساسية</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div className="flex items-center gap-6">
                        <Avatar className="w-24 h-24">
                            <AvatarImage src="https://images.unsplash.com/photo-1544723795-3fb6469f5b39?q=80&w=200" />
                            <AvatarFallback>ن</AvatarFallback>
                        </Avatar>
                        <Button variant="outline" onClick={() => handleFeatureClick("Upload Image")}><Upload className="w-4 h-4 ml-2"/>تغيير الصورة</Button>
                    </div>
                    <div className="grid md:grid-cols-2 gap-4">
                        <div><Label htmlFor="name">الاسم</Label><Input id="name" defaultValue="نورة عبدالله" /></div>
                        <div><Label htmlFor="email">البريد الإلكتروني</Label><Input id="email" defaultValue="noura@example.com" disabled /></div>
                        <div><Label htmlFor="phone">رقم الجوال</Label><Input id="phone" defaultValue="966501234567" /></div>
                        <div><Label htmlFor="password">كلمة المرور</Label><Input id="password" type="password" placeholder="••••••••" /></div>
                    </div>
                </CardContent>
            </Card>
             <Card>
                <CardHeader>
                    <CardTitle>إدارة الإشعارات</CardTitle>
                    <CardDescription>اختر كيف تريد أن تتلقى التحديثات والتنبيهات.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                     <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="email-notifications">إشعارات البريد الإلكتروني</Label>
                        <Switch id="email-notifications" defaultChecked />
                    </div>
                    <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <Label htmlFor="sms-notifications">رسائل نصية (SMS)</Label>
                        <Switch id="sms-notifications" defaultChecked />
                    </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default CustomerProfile;
