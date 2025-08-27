import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { LifeBuoy, PlusCircle, MessageSquare, Clock, CheckCircle, AlertTriangle } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { format } from 'date-fns';
import { ar } from 'date-fns/locale';

const SupportTicketContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [tickets, setTickets] = useState(JSON.parse(localStorage.getItem('lilium_night_support_tickets_v1')) || [
        { id: 'TKT-001', subject: 'مشكلة في استلام الإشعارات', category: 'technical', priority: 'medium', status: 'open', createdAt: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000).toISOString(), lastReply: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000).toISOString() },
        { id: 'TKT-002', subject: 'استفسار حول العمولات', category: 'billing', priority: 'low', status: 'resolved', createdAt: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toISOString(), lastReply: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000).toISOString() },
    ]);
    const [newTicket, setNewTicket] = useState({
        subject: '', category: 'general', priority: 'medium', description: ''
    });
    const [showNewTicketForm, setShowNewTicketForm] = useState(false);

    useEffect(() => {
        localStorage.setItem('lilium_night_support_tickets_v1', JSON.stringify(tickets));
    }, [tickets]);

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

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setNewTicket(prev => ({ ...prev, [name]: value }));
    };

    const handleSelectChange = (name, value) => {
        setNewTicket(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmitTicket = () => {
        if (!newTicket.subject || !newTicket.description) {
            toast({ title: "خطأ", description: "الموضوع والوصف مطلوبان.", variant: "destructive" });
            return;
        }

        const ticketToAdd = {
            id: `TKT-${Date.now().toString().slice(-5)}`,
            ...newTicket,
            status: 'open',
            createdAt: new Date().toISOString(),
            lastReply: new Date().toISOString()
        };

        setTickets([ticketToAdd, ...tickets]);
        setNewTicket({ subject: '', category: 'general', priority: 'medium', description: '' });
        setShowNewTicketForm(false);
        
        toast({ title: "تم إرسال التذكرة!", description: `تم إنشاء تذكرة الدعم ${ticketToAdd.id} بنجاح. سيتم الرد عليك قريباً.` });
        handleFeatureClick(`إنشاء تذكرة دعم جديدة: ${newTicket.subject}`);
    };

    const getStatusBadge = (status) => {
        switch(status) {
            case 'open': return { text: 'مفتوحة', color: 'bg-blue-100 text-blue-700', icon: Clock };
            case 'in_progress': return { text: 'قيد المعالجة', color: 'bg-yellow-100 text-yellow-700', icon: AlertTriangle };
            case 'resolved': return { text: 'محلولة', color: 'bg-green-100 text-green-700', icon: CheckCircle };
            case 'closed': return { text: 'مغلقة', color: 'bg-slate-100 text-slate-700', icon: CheckCircle };
            default: return { text: status, color: 'bg-slate-100 text-slate-600', icon: Clock };
        }
    };

    const getPriorityBadge = (priority) => {
        switch(priority) {
            case 'high': return { text: 'عالية', color: 'bg-red-100 text-red-700' };
            case 'medium': return { text: 'متوسطة', color: 'bg-yellow-100 text-yellow-700' };
            case 'low': return { text: 'منخفضة', color: 'bg-green-100 text-green-700' };
            default: return { text: priority, color: 'bg-slate-100 text-slate-600' };
        }
    };

    const getCategoryName = (category) => {
        const categories = {
            'general': 'عام',
            'technical': 'تقني',
            'billing': 'مالي',
            'account': 'الحساب',
            'feature': 'طلب ميزة'
        };
        return categories[category] || category;
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">تذاكر الدعم الفني</h2>
                <Button className="gradient-bg text-white" onClick={() => setShowNewTicketForm(!showNewTicketForm)}>
                    <PlusCircle className="w-5 h-5 ml-2"/>
                    تذكرة دعم جديدة
                </Button>
            </div>

            {showNewTicketForm && (
                <Card>
                    <CardHeader>
                        <CardTitle>إنشاء تذكرة دعم جديدة</CardTitle>
                        <CardDescription>صف مشكلتك أو استفسارك بالتفصيل وسيقوم فريق الدعم بالرد عليك في أقرب وقت.</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div>
                            <Label htmlFor="ticketSubject">موضوع التذكرة</Label>
                            <Input id="ticketSubject" name="subject" value={newTicket.subject} onChange={handleInputChange} placeholder="مثال: مشكلة في استلام المدفوعات" />
                        </div>
                        
                        <div className="grid md:grid-cols-2 gap-4">
                            <div>
                                <Label>فئة المشكلة</Label>
                                <Select dir="rtl" value={newTicket.category} onValueChange={(val) => handleSelectChange('category', val)}>
                                    <SelectTrigger><SelectValue /></SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="general">عام</SelectItem>
                                        <SelectItem value="technical">مشكلة تقنية</SelectItem>
                                        <SelectItem value="billing">مشكلة مالية</SelectItem>
                                        <SelectItem value="account">مشكلة في الحساب</SelectItem>
                                        <SelectItem value="feature">طلب ميزة جديدة</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            <div>
                                <Label>الأولوية</Label>
                                <Select dir="rtl" value={newTicket.priority} onValueChange={(val) => handleSelectChange('priority', val)}>
                                    <SelectTrigger><SelectValue /></SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="low">منخفضة</SelectItem>
                                        <SelectItem value="medium">متوسطة</SelectItem>
                                        <SelectItem value="high">عالية</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                        
                        <div>
                            <Label htmlFor="ticketDescription">وصف المشكلة أو الاستفسار</Label>
                            <Textarea id="ticketDescription" name="description" value={newTicket.description} onChange={handleInputChange} placeholder="اشرح مشكلتك بالتفصيل..." className="min-h-[120px]" />
                        </div>
                        
                        <div className="flex gap-2">
                            <Button onClick={handleSubmitTicket} className="gradient-bg text-white">
                                <LifeBuoy className="w-4 h-4 ml-2"/>
                                إرسال التذكرة
                            </Button>
                            <Button variant="outline" onClick={() => setShowNewTicketForm(false)}>
                                إلغاء
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            )}
            
            <Card>
                <CardHeader>
                    <CardTitle>تذاكر الدعم الخاصة بك ({tickets.length})</CardTitle>
                    <CardDescription>تتبع حالة جميع تذاكر الدعم التي أرسلتها لفريق ليلة الليليوم.</CardDescription>
                </CardHeader>
                <CardContent>
                    {tickets.length > 0 ? (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>رقم التذكرة</TableHead>
                                    <TableHead>الموضوع</TableHead>
                                    <TableHead>الفئة</TableHead>
                                    <TableHead>الأولوية</TableHead>
                                    <TableHead>الحالة</TableHead>
                                    <TableHead>تاريخ الإنشاء</TableHead>
                                    <TableHead>إجراءات</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {tickets.map((ticket) => {
                                    const statusInfo = getStatusBadge(ticket.status);
                                    const priorityInfo = getPriorityBadge(ticket.priority);
                                    const StatusIcon = statusInfo.icon;
                                    return (
                                        <TableRow key={ticket.id}>
                                            <TableCell className="font-mono">{ticket.id}</TableCell>
                                            <TableCell className="font-semibold">{ticket.subject}</TableCell>
                                            <TableCell>{getCategoryName(ticket.category)}</TableCell>
                                            <TableCell>
                                                <Badge className={priorityInfo.color}>{priorityInfo.text}</Badge>
                                            </TableCell>
                                            <TableCell>
                                                <Badge className={`${statusInfo.color} flex items-center gap-1 w-fit`}>
                                                    <StatusIcon className="w-3 h-3"/> {statusInfo.text}
                                                </Badge>
                                            </TableCell>
                                            <TableCell>{format(new Date(ticket.createdAt), 'PPP', { locale: ar })}</TableCell>
                                            <TableCell>
                                                <Button variant="ghost" size="sm" onClick={() => handleFeatureClick(`عرض تفاصيل التذكرة ${ticket.id}`)}>
                                                    <MessageSquare className="w-4 h-4 ml-1"/>
                                                    عرض
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    );
                                })}
                            </TableBody>
                        </Table>
                    ) : (
                        <div className="text-center py-12 text-slate-500">
                            <LifeBuoy className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                            <p className="text-xl font-semibold">لا توجد تذاكر دعم بعد.</p>
                            <p>إذا كان لديك أي استفسار أو مشكلة، لا تتردد في إنشاء تذكرة دعم.</p>
                        </div>
                    )}
                </CardContent>
            </Card>
        </div>
    );
});

export default SupportTicketContent;