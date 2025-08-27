import React, { useState, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from "@/components/ui/accordion";
import { BookOpen, Search, ExternalLink, Video, FileText, MessageCircle } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const helpArticles = [
    {
        id: 'art-001',
        title: 'كيفية إضافة خدمة جديدة',
        category: 'إدارة الخدمات',
        content: 'لإضافة خدمة جديدة، انتقل إلى قسم "إدارة الخدمات" ثم اضغط على "إضافة خدمة جديدة". املأ جميع التفاصيل المطلوبة مثل اسم الخدمة، الوصف، السعر، والصور.',
        views: 245
    },
    {
        id: 'art-002',
        title: 'إدارة التقويم والحجوزات',
        category: 'الحجوزات',
        content: 'يمكنك إدارة توفر خدماتك من خلال التقويم. اضغط على أي يوم لتحديد الباقات المتاحة، الأسعار، وحالة البيع الأونلاين.',
        views: 189
    },
    {
        id: 'art-003',
        title: 'كيفية سحب الأرباح',
        category: 'المالية',
        content: 'لسحب أرباحك، انتقل إلى قسم "المحفظة المالية" واضغط على "طلب سحب جديد". تأكد من ربط حسابك البنكي أولاً.',
        views: 312
    },
    {
        id: 'art-004',
        title: 'إعداد الإشعارات',
        category: 'الإعدادات',
        content: 'يمكنك تخصيص الإشعارات التي تصلك من قسم "الإشعارات الذكية". اختر نوع الإشعارات ووسيلة الاستلام المفضلة.',
        views: 156
    }
];

const faqData = [
    {
        question: 'كم تبلغ عمولة المنصة؟',
        answer: 'عمولة المنصة هي 3% من قيمة كل حجز مكتمل. هذه العمولة تشمل معالجة المدفوعات، الدعم الفني، والتسويق.'
    },
    {
        question: 'متى يتم تحويل الأرباح؟',
        answer: 'يتم تحويل الأرباح خلال 3-5 أيام عمل من تاريخ طلب السحب. تأكد من صحة بيانات حسابك البنكي.'
    },
    {
        question: 'كيف أتعامل مع طلبات الإلغاء؟',
        answer: 'يمكنك إدارة طلبات الإلغاء من قسم "إدارة الحجوزات". راجع سياسة الإلغاء الخاصة بك قبل الموافقة أو الرفض.'
    },
    {
        question: 'هل يمكنني تعديل الأسعار بعد النشر؟',
        answer: 'نعم، يمكنك تعديل أسعار خدماتك في أي وقت من قسم "إدارة الخدمات". التعديلات ستطبق على الحجوزات الجديدة فقط.'
    }
];

const HelpCenterContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [searchTerm, setSearchTerm] = useState('');

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

    const filteredArticles = helpArticles.filter(article => 
        article.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
        article.category.toLowerCase().includes(searchTerm.toLowerCase()) ||
        article.content.toLowerCase().includes(searchTerm.toLowerCase())
    );

    const handleArticleClick = (articleTitle) => {
        handleFeatureClick(`قراءة مقال المساعدة: ${articleTitle}`);
    };

    const handleVideoClick = (videoTitle) => {
        handleFeatureClick(`مشاهدة فيديو تعليمي: ${videoTitle}`);
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">مركز المساعدة وقاعدة المعرفة</h2>
                <Button variant="outline" onClick={() => handleFeatureClick("فتح تذكرة دعم فني")}>
                    <MessageCircle className="w-4 h-4 ml-2"/>
                    تواصل مع الدعم
                </Button>
            </div>

            <div className="relative">
                <Search className="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" />
                <Input 
                    placeholder="ابحث في مقالات المساعدة..." 
                    className="pr-12 text-lg py-6"
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                />
            </div>

            <div className="grid lg:grid-cols-3 gap-8">
                <div className="lg:col-span-2 space-y-6">
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <BookOpen className="w-5 h-5"/>
                                مقالات المساعدة ({filteredArticles.length})
                            </CardTitle>
                            <CardDescription>دليل شامل لاستخدام جميع ميزات منصة ليلة الليليوم.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {filteredArticles.map(article => (
                                    <div key={article.id} className="p-4 border rounded-lg hover:bg-slate-50 cursor-pointer transition-colors" onClick={() => handleArticleClick(article.title)}>
                                        <div className="flex justify-between items-start">
                                            <div className="flex-1">
                                                <h3 className="font-semibold text-slate-800 mb-1">{article.title}</h3>
                                                <p className="text-sm text-slate-600 mb-2">{article.content}</p>
                                                <div className="flex items-center gap-4 text-xs text-slate-500">
                                                    <span className="bg-primary/10 text-primary px-2 py-1 rounded">{article.category}</span>
                                                    <span>{article.views} مشاهدة</span>
                                                </div>
                                            </div>
                                            <ExternalLink className="w-4 h-4 text-slate-400 ml-2" />
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>الأسئلة الشائعة</CardTitle>
                            <CardDescription>إجابات سريعة على الأسئلة الأكثر تكراراً.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Accordion type="single" collapsible className="w-full">
                                {faqData.map((faq, index) => (
                                    <AccordionItem key={index} value={`item-${index}`}>
                                        <AccordionTrigger className="text-right">{faq.question}</AccordionTrigger>
                                        <AccordionContent className="text-slate-600">
                                            {faq.answer}
                                        </AccordionContent>
                                    </AccordionItem>
                                ))}
                            </Accordion>
                        </CardContent>
                    </Card>
                </div>

                <div className="space-y-6">
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <Video className="w-5 h-5"/>
                                فيديوهات تعليمية
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            <div className="p-3 border rounded-lg cursor-pointer hover:bg-slate-50" onClick={() => handleVideoClick("البدء مع ليلة الليليوم")}>
                                <h4 className="font-semibold text-sm">البدء مع ليلة الليليوم</h4>
                                <p className="text-xs text-slate-500 mt-1">5:30 دقيقة</p>
                            </div>
                            <div className="p-3 border rounded-lg cursor-pointer hover:bg-slate-50" onClick={() => handleVideoClick("إدارة الحجوزات")}>
                                <h4 className="font-semibold text-sm">إدارة الحجوزات</h4>
                                <p className="text-xs text-slate-500 mt-1">8:15 دقيقة</p>
                            </div>
                            <div className="p-3 border rounded-lg cursor-pointer hover:bg-slate-50" onClick={() => handleVideoClick("تحسين ملفك التجاري")}>
                                <h4 className="font-semibold text-sm">تحسين ملفك التجاري</h4>
                                <p className="text-xs text-slate-500 mt-1">6:45 دقيقة</p>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <FileText className="w-5 h-5"/>
                                روابط مفيدة
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            <Button variant="ghost" className="w-full justify-start" onClick={() => handleFeatureClick("عرض شروط الخدمة")}>
                                <ExternalLink className="w-4 h-4 ml-2"/>
                                شروط الخدمة
                            </Button>
                            <Button variant="ghost" className="w-full justify-start" onClick={() => handleFeatureClick("عرض سياسة الخصوصية")}>
                                <ExternalLink className="w-4 h-4 ml-2"/>
                                سياسة الخصوصية
                            </Button>
                            <Button variant="ghost" className="w-full justify-start" onClick={() => handleFeatureClick("عرض دليل أفضل الممارسات")}>
                                <ExternalLink className="w-4 h-4 ml-2"/>
                                دليل أفضل الممارسات
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    );
});

export default HelpCenterContent;