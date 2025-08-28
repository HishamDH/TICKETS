
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from "@/components/ui/accordion";

const CustomerSupport = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">الدعم والمساعدة</h1>
                <p className="text-slate-500 mt-1">نحن هنا لمساعدتك. أرسل استفسارك أو تصفح الأسئلة الشائعة.</p>
            </div>
            <div className="grid lg:grid-cols-3 gap-6">
                <Card className="lg:col-span-2">
                    <CardHeader><CardTitle>إرسال طلب دعم فني</CardTitle></CardHeader>
                    <CardContent className="space-y-4">
                        <div>
                            <Label htmlFor="subject">الموضوع</Label>
                            <Input id="subject" placeholder="مثال: مشكلة في الدفع"/>
                        </div>
                        <div>
                            <Label htmlFor="category">التصنيف</Label>
                             <Select><SelectTrigger><SelectValue placeholder="اختر التصنيف"/></SelectTrigger><SelectContent><SelectItem value="payment">دفع</SelectItem><SelectItem value="booking">حجز</SelectItem><SelectItem value="technical">تقني</SelectItem></SelectContent></Select>
                        </div>
                        <div>
                            <Label htmlFor="message">الرسالة</Label>
                            <Textarea id="message" placeholder="اشرح مشكلتك بالتفصيل..." className="min-h-[120px]"/>
                        </div>
                        <Button className="w-full" onClick={() => handleFeatureClick("Send Ticket")}>إرسال</Button>
                    </CardContent>
                </Card>
                 <Card>
                    <CardHeader><CardTitle>الأسئلة الشائعة</CardTitle></CardHeader>
                    <CardContent>
                        <Accordion type="single" collapsible>
                            <AccordionItem value="item-1">
                                <AccordionTrigger>كيف يمكنني إلغاء حجزي؟</AccordionTrigger>
                                <AccordionContent>يمكنك إلغاء حجزك من صفحة "حجوزاتي" إذا كانت سياسة الإلغاء الخاصة بالتاجر تسمح بذلك.</AccordionContent>
                            </AccordionItem>
                             <AccordionItem value="item-2">
                                <AccordionTrigger>متى يتم استرداد المبلغ؟</AccordionTrigger>
                                <AccordionContent>تستغرق عملية استرداد المبلغ من 5 إلى 10 أيام عمل حسب البنك الخاص بك.</AccordionContent>
                            </AccordionItem>
                        </Accordion>
                    </CardContent>
                </Card>
            </div>
        </div>
    );
};

export default CustomerSupport;
