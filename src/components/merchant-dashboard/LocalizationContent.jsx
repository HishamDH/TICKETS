import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Globe, Save } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const initialTranslations = {
    ar: {
        page_title: 'قاعة ألف ليلة للمناسبات',
        welcome_message: 'أهلاً بكم في صفحتنا! نحن متخصصون في جعل مناسباتكم لا تُنسى.',
        contact_us: 'تواصل معنا',
    },
    en: {
        page_title: 'Alf Laila Events Hall',
        welcome_message: 'Welcome to our page! We specialize in making your events unforgettable.',
        contact_us: 'Contact Us',
    },
};

const LocalizationContent = memo(({ handleFeatureClick }) => {
    const { toast } = useToast();
    const [translations, setTranslations] = useState(JSON.parse(localStorage.getItem('lilium_night_translations_v1')) || initialTranslations);

    useEffect(() => {
        localStorage.setItem('lilium_night_translations_v1', JSON.stringify(translations));
    }, [translations]);

    const handleInputChange = (lang, key, value) => {
        setTranslations(prev => ({
            ...prev,
            [lang]: {
                ...prev[lang],
                [key]: value,
            },
        }));
    };

    const saveTranslations = () => {
        toast({ title: "تم الحفظ!", description: "تم حفظ التغييرات على الترجمات بنجاح." });
        handleFeatureClick("حفظ الترجمات");
    };

    const renderLangTab = (lang) => (
        <div className="space-y-4">
            <div>
                <Label htmlFor={`title-${lang}`}>عنوان الصفحة</Label>
                <Input id={`title-${lang}`} value={translations[lang].page_title} onChange={(e) => handleInputChange(lang, 'page_title', e.target.value)} />
            </div>
            <div>
                <Label htmlFor={`welcome-${lang}`}>رسالة الترحيب</Label>
                <Textarea id={`welcome-${lang}`} value={translations[lang].welcome_message} onChange={(e) => handleInputChange(lang, 'welcome_message', e.target.value)} />
            </div>
            <div>
                <Label htmlFor={`contact-${lang}`}>نص زر "تواصل معنا"</Label>
                <Input id={`contact-${lang}`} value={translations[lang].contact_us} onChange={(e) => handleInputChange(lang, 'contact_us', e.target.value)} />
            </div>
        </div>
    );

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">اللغات والترجمة</h2>
                <Button className="gradient-bg text-white" onClick={saveTranslations}>
                    <Save className="w-5 h-5 ml-2"/> حفظ كل التغييرات
                </Button>
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>إدارة محتوى صفحتك العامة</CardTitle>
                    <CardDescription>أدخل ترجمات لنصوص صفحتك العامة لتصل إلى جمهور أوسع.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Tabs defaultValue="ar" className="w-full" dir="rtl">
                        <TabsList>
                            <TabsTrigger value="ar">العربية</TabsTrigger>
                            <TabsTrigger value="en">English</TabsTrigger>
                        </TabsList>
                        <TabsContent value="ar" className="pt-4">
                            {renderLangTab('ar')}
                        </TabsContent>
                        <TabsContent value="en" className="pt-4">
                            {renderLangTab('en')}
                        </TabsContent>
                    </Tabs>
                </CardContent>
            </Card>
        </div>
    );
});

export default LocalizationContent;