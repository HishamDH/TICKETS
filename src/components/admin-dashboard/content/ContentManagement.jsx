import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Save, LayoutTemplate, Image, FileText, Mail } from 'lucide-react';

const ContentManagement = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">إدارة المحتوى والخدمات</h1>
                    <p className="text-slate-500 mt-1">التحكم في المحتوى العام والخدمات المتاحة في المنصة.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("حفظ التغييرات")}><Save className="w-4 h-4 ml-2"/>حفظ التغييرات</Button>
            </div>

            <div className="grid lg:grid-cols-2 gap-6">
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><LayoutTemplate /> التحكم في الخدمات</CardTitle>
                        <CardDescription>تفعيل أو تعطيل أنواع الخدمات المتاحة للتجار.</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <Label htmlFor="vip-tickets">تذاكر VIP / دعوات خاصة</Label>
                            <Switch id="vip-tickets" defaultChecked />
                        </div>
                        <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <Label htmlFor="experiences">خدمة التجارب (Experiences)</Label>
                            <Switch id="experiences" defaultChecked />
                        </div>
                        <div className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <Label htmlFor="open-buffet">حجوزات البوفيه المفتوح</Label>
                            <Switch id="open-buffet" />
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><FileText /> السياسات العامة</CardTitle>
                        <CardDescription>تعديل نصوص الشروط والأحكام وسياسة الخصوصية.</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div>
                            <Label htmlFor="terms">شروط الاستخدام</Label>
                            <Textarea id="terms" placeholder="اكتب نص شروط الاستخدام هنا..." className="mt-2 min-h-[60px]" />
                        </div>
                        <div>
                            <Label htmlFor="privacy">سياسة الخصوصية</Label>
                            <Textarea id="privacy" placeholder="اكتب نص سياسة الخصوصية هنا..." className="mt-2 min-h-[60px]" />
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    );
};

export default ContentManagement;