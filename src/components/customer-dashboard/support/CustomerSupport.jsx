import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from "@/components/ui/accordion";
import { useToast } from "@/components/ui/use-toast";
import { Send, MessageCircle, HelpCircle, ListChecks } from 'lucide-react';
import { Badge } from '@/components/ui/badge';

const faqs = [
    { id: 'faq1', question: 'كيف يمكنني إلغاء حجزي لمناسبة؟', answer: 'يمكنك إلغاء حجزك من صفحة "حجوزاتي" إذا كانت سياسة الإلغاء الخاصة بمزوّد الخدمة تسمح بذلك. تختلف شروط الإلغاء والاسترداد بين مزوّدي الخدمات.' },
    { id: 'faq2', question: 'متى يتم استرداد المبلغ بعد الإلغاء؟', answer: 'تستغرق عملية استرداد المبلغ عادة من 5 إلى 10 أيام عمل حسب البنك الخاص بك وسياسات مزوّد الخدمة.' },
    { id: 'faq3', question: 'هل يمكنني تعديل تفاصيل حجزي؟', answer: 'بعض التعديلات قد تكون متاحة حسب سياسة مزود الخدمة. يمكنك محاولة التواصل مع مزود الخدمة مباشرة أو الاتصال بفريق دعم ليلة الليليوم للمساعدة.' },
    { id: 'faq4', question: 'كيف أجد معلومات الاتصال بمزود الخدمة؟', answer: 'بعد تأكيد الحجز، ستجد معلومات الاتصال بمزود الخدمة في تفاصيل الحجز بصفحة "حجوزاتي".' },
];

const CustomerSupport = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [supportTicket, setSupportTicket] = useState({ subject: '', category: '', message: '', bookingId: '' });
    const [myTickets, setMyTickets] = useState(() => {
        const savedTickets = localStorage.getItem('lilium_customer_support_tickets_v1');
        return savedTickets ? JSON.parse(savedTickets) : [
            {id: 'TKT123', subject: 'مشكلة في الدفع', status: 'مفتوحة', lastUpdate: 'أمس'},
            {id: 'TKT124', subject: 'استفسار عن خدمة', status: 'مغلقة', lastUpdate: 'منذ أسبوع'},
        ];
    });

    useEffect(() => {
        localStorage.setItem('lilium_customer_support_tickets_v1', JSON.stringify(myTickets));
    }, [myTickets]);

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


    const handleInputChange = (e) => {
        setSupportTicket(prev => ({ ...prev, [e.target.name]: e.target.value }));
    };
    
    const handleSelectChange = (value) => {
        setSupportTicket(prev => ({ ...prev, category: value }));
    };

    const handleSubmitTicket = () => {
        if (!supportTicket.subject || !supportTicket.category || !supportTicket.message) {
            toast({ title: "خطأ", description: "يرجى ملء جميع الحقول المطلوبة (الموضوع، التصنيف، الرسالة).", variant: "destructive" });
            return;
        }
        const newTicketId = `TKT${Date.now().toString().slice(-4)}`;
        setMyTickets(prev => [{id: newTicketId, subject: supportTicket.subject, status: 'مفتوحة', lastUpdate: 'الآن'}, ...prev]);
        toast({
            title: "تم إرسال طلب الدعم",
            description: `تم استلام طلبك برقم ${newTicketId}. سنتواصل معك قريباً.`,
        });
        handleFeatureClick(`إرسال طلب دعم: ${supportTicket.subject}`);
        setSupportTicket({ subject: '', category: '', message: '', bookingId: '' });
    };

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">الدعم والمساعدة</h1>
                <p className="text-slate-500 mt-1">نحن هنا لمساعدتك في كل ما يتعلق بمنصة ليلة الليليوم. أرسل استفسارك أو تصفح الأسئلة الشائعة.</p>
            </div>
            <div className="grid lg:grid-cols-3 gap-6">
                <Card className="lg:col-span-2">
                    <CardHeader><CardTitle className="flex items-center gap-2"><MessageCircle/> إرسال طلب دعم فني</CardTitle></CardHeader>
                    <CardContent className="space-y-4">
                        <div>
                            <Label htmlFor="subject">الموضوع</Label>
                            <Input id="subject" name="subject" value={supportTicket.subject} onChange={handleInputChange} placeholder="مثال: مشكلة في الدفع لحجز قاعة"/>
                        </div>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <Label htmlFor="category">التصنيف</Label>
                                <Select value={supportTicket.category} onValueChange={handleSelectChange}><SelectTrigger><SelectValue placeholder="اختر التصنيف"/></SelectTrigger><SelectContent><SelectItem value="payment">دفع وتمويل</SelectItem><SelectItem value="booking">حجز خدمة</SelectItem><SelectItem value="technical">مشكلة تقنية</SelectItem><SelectItem value="general">استفسار عام</SelectItem></SelectContent></Select>
                            </div>
                            <div>
                                <Label htmlFor="bookingId">رقم الحجز (اختياري)</Label>
                                <Input id="bookingId" name="bookingId" value={supportTicket.bookingId} onChange={handleInputChange} placeholder="مثال: #حجز1234"/>
                            </div>
                        </div>
                        <div>
                            <Label htmlFor="message">الرسالة</Label>
                            <Textarea id="message" name="message" value={supportTicket.message} onChange={handleInputChange} placeholder="اشرح مشكلتك بالتفصيل..." className="min-h-[120px]"/>
                        </div>
                        <Button className="w-full gradient-bg text-white" onClick={handleSubmitTicket}><Send className="w-4 h-4 ml-2"/>إرسال</Button>
                    </CardContent>
                </Card>
                 <div className="space-y-6">
                    <Card>
                        <CardHeader><CardTitle className="flex items-center gap-2"><ListChecks/> تذاكر الدعم الخاصة بك</CardTitle></CardHeader>
                        <CardContent className="max-h-[200px] overflow-y-auto">
                            {myTickets.length > 0 ? myTickets.map(ticket => (
                                <div key={ticket.id} className="flex justify-between items-center p-2 border-b last:border-b-0 cursor-pointer hover:bg-slate-50" onClick={() => handleFeatureClick(`عرض تذكرة الدعم ${ticket.id}`)}>
                                    <div>
                                        <p className="font-medium text-sm">{ticket.subject} <span className="text-xs text-slate-400">({ticket.id})</span></p>
                                        <p className="text-xs text-slate-500">آخر تحديث: {ticket.lastUpdate}</p>
                                    </div>
                                    <Badge variant={ticket.status === 'مغلقة' ? 'default' : 'destructive'}>{ticket.status}</Badge>
                                </div>
                            )) : <p className="text-sm text-slate-500 text-center py-4">لا توجد تذاكر دعم حالية.</p>}
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader><CardTitle className="flex items-center gap-2"><HelpCircle/> الأسئلة الشائعة</CardTitle></CardHeader>
                        <CardContent className="max-h-[280px] overflow-y-auto">
                            <Accordion type="single" collapsible>
                                {faqs.map(faq => (
                                    <AccordionItem key={faq.id} value={faq.id}>
                                        <AccordionTrigger className="text-sm text-right">{faq.question}</AccordionTrigger>
                                        <AccordionContent className="text-sm">{faq.answer}</AccordionContent>
                                    </AccordionItem>
                                ))}
                            </Accordion>
                        </CardContent>
                    </Card>
                 </div>
            </div>
        </div>
    );
};

export default CustomerSupport;