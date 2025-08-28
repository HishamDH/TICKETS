
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Paintbrush, Image as ImageIcon, Save } from 'lucide-react';

const AppearanceContent = ({ handleFeatureClick }) => {
    const themes = [
        { name: 'Theme1', preview: 'bg-slate-200', title: 'الافتراضي' },
        { name: 'Theme2', preview: 'bg-gray-800', title: 'المظلم' },
        { name: 'Theme3', preview: 'bg-rose-200', title: 'الوردي' },
        { name: 'Theme4', preview: 'bg-sky-200', title: 'السماوي' },
    ];

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">إعداد الصفحة الخاصة</h2>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("حفظ التغييرات")}><Save className="w-4 h-4 ml-2"/>حفظ التغييرات</Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>الشعار والبنرات</CardTitle>
                    <CardDescription>ارفع شعار علامتك التجارية والبنر الرئيسي لصفحتك.</CardDescription>
                </CardHeader>
                <CardContent className="grid md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                        <Label htmlFor="logo">الشعار (Logo)</Label>
                        <div className="flex items-center gap-4">
                            <div className="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center">
                                <ImageIcon className="w-8 h-8 text-slate-400"/>
                            </div>
                            <Button variant="outline" onClick={() => handleFeatureClick("رفع شعار")}>رفع صورة</Button>
                        </div>
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="banner">البنر الرئيسي</Label>
                         <div className="flex items-center gap-4">
                            <div className="w-full h-20 rounded-lg bg-slate-100 flex items-center justify-center">
                                <ImageIcon className="w-8 h-8 text-slate-400"/>
                            </div>
                            <Button variant="outline" onClick={() => handleFeatureClick("رفع بنر")}>رفع صورة</Button>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>الألوان والقوالب</CardTitle>
                    <CardDescription>اختر القالب والألوان التي تناسب هويتك البصرية.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div>
                        <Label>اللون الرئيسي</Label>
                        <div className="flex items-center gap-2 mt-2">
                            <div className="w-10 h-10 rounded-lg bg-primary cursor-pointer border-4 border-white ring-2 ring-primary"></div>
                            <div className="w-10 h-10 rounded-lg bg-rose-500 cursor-pointer"></div>
                            <div className="w-10 h-10 rounded-lg bg-amber-500 cursor-pointer"></div>
                            <div className="w-10 h-10 rounded-lg bg-slate-800 cursor-pointer"></div>
                            <Input type="color" defaultValue="#ff7842" className="w-12 h-10 p-1"/>
                        </div>
                    </div>
                    <div>
                        <Label>اختر القالب</Label>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                            {themes.map(theme => (
                                <div key={theme.name} className="cursor-pointer group" onClick={() => handleFeatureClick(`تطبيق ${theme.title}`)}>
                                    <div className={`h-24 rounded-lg ${theme.preview} flex items-center justify-center group-hover:ring-2 ring-primary ring-offset-2 transition-all`}>
                                        <Paintbrush className="w-8 h-8 text-white/50"/>
                                    </div>
                                    <p className="text-center mt-2 font-semibold text-sm">{theme.title}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default AppearanceContent;
