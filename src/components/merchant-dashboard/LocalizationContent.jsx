
import React from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Textarea } from '@/components/ui/textarea';
import { Globe, PlusCircle, Save } from 'lucide-react';

const languages = [
    { code: 'ar', name: 'العربية', default: true },
    { code: 'en', name: 'English', default: false },
];

const translatableContent = {
    services: [
        { key: 'event_name_1', original: 'معرض التقنية 2025', translation: 'Tech Expo 2025' },
        { key: 'event_name_2', original: 'تجربة الغوص', translation: 'Diving Experience' },
        { key: 'event_name_3', original: 'حجز طاولة عشاء', translation: 'Dinner Table Reservation' },
    ],
    descriptions: [
        { key: 'event_desc_1', original: 'أكبر معرض تقني في المنطقة يستعرض آخر الابتكارات.', translation: 'The largest tech expo in the region, showcasing the latest innovations.' },
        { key: 'event_desc_2', original: 'استكشف أعماق البحر الأحمر في تجربة غوص لا تنسى.', translation: 'Explore the depths of the Red Sea in an unforgettable diving experience.' },
    ],
    policies: [
        { key: 'cancellation_policy', original: 'لا يمكن استرجاع المبلغ قبل 24 ساعة من موعد الفعالية. في حال الإلغاء قبل ذلك، يتم استرجاع 50% من المبلغ.', translation: 'Refunds are not possible within 24 hours of the event. If cancelled before that, 50% of the amount will be refunded.' },
    ]
};

const LocalizationContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <div className="flex justify-between items-start">
                <div>
                    <h2 className="text-3xl font-bold text-slate-800">اللغات والترجمة</h2>
                    <p className="text-slate-500 mt-2">قم بإدارة اللغات المتاحة في صفحتك وأضف ترجمات للمحتوى.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("حفظ جميع الترجمات")}>
                    <Save className="w-4 h-4 ml-2" />
                    حفظ التغييرات
                </Button>
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>إدارة اللغات</CardTitle>
                    <CardDescription>اختر اللغات التي تريد دعمها في موقعك.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    {languages.map(lang => (
                        <div key={lang.code} className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <div>
                                <span className="font-semibold">{lang.name}</span>
                                {lang.default && <span className="text-xs text-primary font-medium mr-2">(اللغة الأساسية)</span>}
                            </div>
                            <Switch defaultChecked={lang.code === 'ar' || lang.code === 'en'} disabled={lang.default} onCheckedChange={() => handleFeatureClick(`تفعيل/تعطيل ${lang.name}`)}/>
                        </div>
                    ))}
                    <Button variant="outline" className="w-full" onClick={() => handleFeatureClick("إضافة لغة جديدة")}>
                        <PlusCircle className="w-4 h-4 ml-2" />
                        إضافة لغة جديدة
                    </Button>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>إدارة الترجمات</CardTitle>
                    <CardDescription>أدخل الترجمات للمحتوى الخاص بك باللغات التي قمت بتفعيلها.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Tabs defaultValue="services" dir="rtl">
                        <TabsList className="grid w-full grid-cols-3">
                            <TabsTrigger value="services">أسماء الخدمات</TabsTrigger>
                            <TabsTrigger value="descriptions">وصف الخدمات</TabsTrigger>
                            <TabsTrigger value="policies">السياسات</TabsTrigger>
                        </TabsList>
                        
                        <TabsContent value="services" className="pt-6">
                            <div className="space-y-6">
                                {translatableContent.services.map(item => (
                                    <div key={item.key} className="grid grid-cols-1 md:grid-cols-2 gap-4 items-end p-4 border rounded-lg">
                                        <div>
                                            <Label className="text-slate-500">النص الأصلي (العربية)</Label>
                                            <p className="p-2 bg-slate-100 rounded-md mt-1 text-slate-800 font-medium">{item.original}</p>
                                        </div>
                                        <div>
                                            <Label htmlFor={`trans-${item.key}`}>الترجمة (English)</Label>
                                            <Input id={`trans-${item.key}`} defaultValue={item.translation} className="mt-1" />
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </TabsContent>

                        <TabsContent value="descriptions" className="pt-6">
                             <div className="space-y-6">
                                {translatableContent.descriptions.map(item => (
                                    <div key={item.key} className="grid grid-cols-1 md:grid-cols-2 gap-4 items-start p-4 border rounded-lg">
                                        <div>
                                            <Label className="text-slate-500">النص الأصلي (العربية)</Label>
                                            <p className="p-2 bg-slate-100 rounded-md mt-1 min-h-[80px] text-slate-800 font-medium">{item.original}</p>
                                        </div>
                                        <div>
                                            <Label htmlFor={`trans-${item.key}`}>الترجمة (English)</Label>
                                            <Textarea id={`trans-${item.key}`} defaultValue={item.translation} className="mt-1 min-h-[80px]" />
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </TabsContent>

                        <TabsContent value="policies" className="pt-6">
                            <div className="space-y-6">
                                {translatableContent.policies.map(item => (
                                    <div key={item.key} className="grid grid-cols-1 md:grid-cols-2 gap-4 items-start p-4 border rounded-lg">
                                        <div>
                                            <Label className="text-slate-500">النص الأصلي (العربية)</Label>
                                            <p className="p-2 bg-slate-100 rounded-md mt-1 min-h-[120px] text-slate-800 font-medium">{item.original}</p>
                                        </div>
                                        <div>
                                            <Label htmlFor={`trans-${item.key}`}>الترجمة (English)</Label>
                                            <Textarea id={`trans-${item.key}`} defaultValue={item.translation} className="mt-1 min-h-[120px]" />
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </TabsContent>
                    </Tabs>
                </CardContent>
            </Card>

        </div>
    );
};

export default LocalizationContent;
