import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { PlusCircle, Edit, Trash2, FileText, Save } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const ContentManagement = ({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [serviceTypes, setServiceTypes] = useState(JSON.parse(localStorage.getItem('lilium_admin_service_types_v1')) || [
        { id: 'st1', name: 'تذاكر VIP', description: 'تذاكر خاصة لكبار الشخصيات مع مزايا حصرية.' },
        { id: 'st2', name: 'تجارب فريدة', description: 'تجارب غير تقليدية مثل رحلات السفاري أو الغوص.' },
        { id: 'st3', name: 'بوفيه مفتوح', description: 'خدمات إعاشة وبوفيهات مفتوحة للمناسبات.' },
    ]);
    const [policies, setPolicies] = useState(JSON.parse(localStorage.getItem('lilium_admin_policies_v1')) || {
        usage_terms: 'هذه هي شروط الاستخدام العامة للمنصة...',
        privacy_policy: 'هذه هي سياسة الخصوصية العامة للمنصة...',
        provider_agreement: 'هذه هي اتفاقية مزود الخدمة...',
    });
    const [blogPosts, setBlogPosts] = useState(JSON.parse(localStorage.getItem('lilium_admin_blog_posts_v1')) || [
        { id: 'bp1', title: 'أفضل 5 قاعات أفراح في الرياض لعام 2025', status: 'مسودة' },
        { id: 'bp2', title: 'كيف تختار باقة التصوير المثالية لزفافك؟', status: 'مسودة' },
    ]);
    const [legalContent, setLegalContent] = useState({
        terms: localStorage.getItem('lilium_legal_terms_v1') || 'هنا نص شروط الاستخدام الافتراضي...',
        privacy: localStorage.getItem('lilium_legal_privacy_v1') || 'هنا نص سياسة الخصوصية الافتراضي...'
    });

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

    const handleLegalContentChange = (key, value) => {
        setLegalContent(prev => ({ ...prev, [key]: value }));
    };

    const saveLegalContent = () => {
        localStorage.setItem('lilium_legal_terms_v1', legalContent.terms);
        localStorage.setItem('lilium_legal_privacy_v1', legalContent.privacy);
        toast({ title: "تم الحفظ", description: "تم حفظ المحتوى القانوني بنجاح." });
        handleFeatureClick("حفظ المحتوى القانوني");
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">إدارة المحتوى والخدمات</h2>
            
            <Card>
                <CardHeader>
                    <CardTitle>أنواع الخدمات المتاحة في المنصة</CardTitle>
                    <CardDescription>إدارة أنواع الخدمات الرئيسية التي يمكن لمزودي الخدمات إضافتها.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader><TableRow><TableHead>النوع</TableHead><TableHead>الوصف</TableHead><TableHead>إجراءات</TableHead></TableRow></TableHeader>
                        <TableBody>
                            {serviceTypes.map(type => (
                                <TableRow key={type.id}>
                                    <TableCell className="font-semibold">{type.name}</TableCell>
                                    <TableCell>{type.description}</TableCell>
                                    <TableCell><Button variant="ghost" size="icon" onClick={() => handleFeatureClick(`تعديل نوع الخدمة: ${type.name}`)}><Edit className="w-4 h-4"/></Button></TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
                <CardFooter><Button onClick={() => handleFeatureClick("إضافة نوع خدمة جديد")}><PlusCircle className="w-4 h-4 ml-2"/>إضافة نوع جديد</Button></CardFooter>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>إدارة نصوص السياسات العامة</CardTitle>
                    <CardDescription>تعديل نصوص السياسات التي تظهر في أجزاء مختلفة من المنصة.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    {Object.entries(policies).map(([key, value]) => (
                        <div key={key}>
                            <Label htmlFor={key} className="capitalize">{key.replace('_', ' ')}</Label>
                            <Textarea id={key} value={value} onChange={(e) => setPolicies(p => ({...p, [key]: e.target.value}))} />
                        </div>
                    ))}
                </CardContent>
                <CardFooter><Button onClick={() => handleFeatureClick("حفظ السياسات العامة")}>حفظ السياسات</Button></CardFooter>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>إدارة المدونة</CardTitle>
                    <CardDescription>إنشاء وإدارة المقالات التي تظهر في مدونة المنصة.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader><TableRow><TableHead>العنوان</TableHead><TableHead>الحالة</TableHead><TableHead>إجراءات</TableHead></TableRow></TableHeader>
                        <TableBody>
                            {blogPosts.map(post => (
                                <TableRow key={post.id}>
                                    <TableCell>{post.title}</TableCell>
                                    <TableCell><Badge>{post.status}</Badge></TableCell>
                                    <TableCell><Button variant="ghost" size="icon" onClick={() => handleFeatureClick(`تعديل مقال: ${post.title}`)}><Edit className="w-4 h-4"/></Button></TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
                <CardFooter><Button onClick={() => handleFeatureClick("إضافة مقال جديد")}><PlusCircle className="w-4 h-4 ml-2"/>إضافة مقال جديد</Button></CardFooter>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle className="flex items-center gap-2"><FileText /> إدارة المحتوى القانوني</CardTitle>
                    <CardDescription>تعديل شروط الاستخدام وسياسة الخصوصية التي تظهر للمستخدمين ومزودي الخدمات.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div>
                        <Label htmlFor="termsOfUse" className="text-lg font-semibold">شروط استخدام المنصة</Label>
                        <Textarea 
                            id="termsOfUse" 
                            className="mt-2 min-h-[200px]" 
                            value={legalContent.terms}
                            onChange={(e) => handleLegalContentChange('terms', e.target.value)}
                        />
                    </div>
                    <div>
                        <Label htmlFor="privacyPolicy" className="text-lg font-semibold">سياسة الخصوصية</Label>
                        <Textarea 
                            id="privacyPolicy" 
                            className="mt-2 min-h-[200px]" 
                            value={legalContent.privacy}
                            onChange={(e) => handleLegalContentChange('privacy', e.target.value)}
                        />
                    </div>
                </CardContent>
                <CardFooter>
                    <Button onClick={saveLegalContent}><Save className="w-4 h-4 ml-2" /> حفظ المحتوى القانوني</Button>
                </CardFooter>
            </Card>
        </div>
    );
};

export default React.memo(ContentManagement);