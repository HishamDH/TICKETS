import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { MessageSquare, Filter, Search, Download, SlidersHorizontal, Eye, CheckCircle, Archive, Send } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Textarea } from '@/components/ui/textarea';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Label } from '@/components/ui/label';

const initialSupportTickets = [
    { id: '#تذكرة789', user: 'أحمد عبدالله (عميل)', subject: 'مشكلة في الدفع لحجز #حجز5678', status: 'مفتوحة', priority: 'عالية', assignedTo: 'فاطمة (دعم)', lastUpdate: '2025-06-26 11:00', type: 'customer' },
    { id: '#تذكرة790', user: 'قصر الأفراح الملكية (تاجر)', subject: 'استفسار عن نظام العمولات', status: 'قيد المعالجة', priority: 'متوسطة', assignedTo: 'علي (مالية)', lastUpdate: '2025-06-25 16:30', type: 'merchant' },
    { id: '#تذكرة791', user: 'سارة محمد (عميل)', subject: 'لم أستلم تأكيد الحجز', status: 'مغلقة', priority: 'منخفضة', assignedTo: 'فاطمة (دعم)', lastUpdate: '2025-06-24 10:15', type: 'customer' },
    { id: '#تذكرة792', user: 'مصور الأعراس (شريك)', subject: 'مشكلة في رابط الإحالة', status: 'مفتوحة', priority: 'عالية', assignedTo: 'فريق الشراكات', lastUpdate: '2025-06-26 09:00', type: 'partner' },
];

const statusBadges = {
    'مفتوحة': 'bg-red-100 text-red-800',
    'قيد المعالجة': 'bg-amber-100 text-amber-800',
    'مغلقة': 'bg-emerald-100 text-emerald-800',
    'بانتظار الرد': 'bg-sky-100 text-sky-800',
};

const priorityBadges = {
    'عالية': 'border-red-500 text-red-500',
    'متوسطة': 'border-amber-500 text-amber-500',
    'منخفضة': 'border-green-500 text-green-500',
};

const SupportSystem = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [tickets, setTickets] = useState(initialSupportTickets);
    const [searchTerm, setSearchTerm] = useState('');
    const [statusFilter, setStatusFilter] = useState('all');
    const [priorityFilter, setPriorityFilter] = useState('all');
    const [isViewModalOpen, setIsViewModalOpen] = useState(false);
    const [selectedTicket, setSelectedTicket] = useState(null);
    const [replyText, setReplyText] = useState('');

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

    const filteredTickets = tickets.filter(ticket => 
        (ticket.user.toLowerCase().includes(searchTerm.toLowerCase()) || ticket.subject.toLowerCase().includes(searchTerm.toLowerCase()) || ticket.id.toLowerCase().includes(searchTerm.toLowerCase())) &&
        (statusFilter === 'all' || ticket.status === statusFilter) &&
        (priorityFilter === 'all' || ticket.priority === priorityFilter)
    );

    const openViewModal = (ticket) => {
        setSelectedTicket(ticket);
        setIsViewModalOpen(true);
        setReplyText('');
        handleFeatureClick(`عرض تذكرة الدعم ${ticket.id}`);
    };

    const handleSendReply = () => {
        if (!selectedTicket || !replyText) {
            toast({title: "خطأ", description: "محتوى الرد مطلوب.", variant: "destructive"});
            return;
        }
        setTickets(prev => prev.map(t => t.id === selectedTicket.id ? {...t, status: 'بانتظار الرد', lastUpdate: new Date().toLocaleString('ar-SA')} : t));
        handleFeatureClick(`إرسال رد على تذكرة ${selectedTicket.id}`);
        setIsViewModalOpen(false);
    };

    const handleTicketAction = (action) => {
        if (!selectedTicket) return;
        let newStatus = selectedTicket.status;
        if (action === 'close') newStatus = 'مغلقة';
        else if (action === 'reopen') newStatus = 'مفتوحة';
        
        setTickets(prev => prev.map(t => t.id === selectedTicket.id ? {...t, status: newStatus, lastUpdate: new Date().toLocaleString('ar-SA')} : t));
        handleFeatureClick(`${action === 'close' ? 'إغلاق' : 'إعادة فتح'} تذكرة ${selectedTicket.id}`);
        if (action === 'close' || action === 'reopen') setIsViewModalOpen(false);
    };


    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">نظام الدعم الفني وتذاكر المساعدة</h1>
                    <p className="text-slate-500 mt-1">إدارة ومتابعة طلبات الدعم من العملاء، التجار، والشركاء.</p>
                </div>
                <Button variant="outline" onClick={() => handleFeatureClick("تصدير تقرير تذاكر الدعم")}><Download className="w-4 h-4 ml-2"/>تصدير</Button>
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>قائمة تذاكر الدعم ({filteredTickets.length})</CardTitle>
                    <div className="flex flex-wrap gap-2 pt-4">
                        <div className="relative flex-grow">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                            <Input placeholder="بحث بالرقم، المستخدم، أو الموضوع..." className="pl-10" value={searchTerm} onChange={e => {setSearchTerm(e.target.value); handleFeatureClick(`البحث في تذاكر الدعم عن: ${e.target.value}`);}} />
                        </div>
                        <Select value={statusFilter} onValueChange={(val) => {setStatusFilter(val); handleFeatureClick(`فلترة التذاكر بالحالة: ${val}`)}} dir="rtl">
                            <SelectTrigger className="w-full sm:w-[180px]">
                                <SlidersHorizontal className="h-4 w-4 ml-2" />
                                <SelectValue placeholder="فلترة حسب الحالة" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">كل الحالات</SelectItem>
                                {Object.keys(statusBadges).map(s => <SelectItem key={s} value={s}>{s}</SelectItem>)}
                            </SelectContent>
                        </Select>
                         <Select value={priorityFilter} onValueChange={(val) => {setPriorityFilter(val); handleFeatureClick(`فلترة التذاكر بالأولوية: ${val}`)}} dir="rtl">
                            <SelectTrigger className="w-full sm:w-[180px]">
                                <SlidersHorizontal className="h-4 w-4 ml-2" />
                                <SelectValue placeholder="فلترة حسب الأولوية" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">كل الأولويات</SelectItem>
                                {Object.keys(priorityBadges).map(p => <SelectItem key={p} value={p}>{p}</SelectItem>)}
                            </SelectContent>
                        </Select>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>رقم التذكرة</TableHead>
                                <TableHead>المستخدم (النوع)</TableHead>
                                <TableHead>الموضوع</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead>الأولوية</TableHead>
                                <TableHead>الموظف المسؤول</TableHead>
                                <TableHead>آخر تحديث</TableHead>
                                <TableHead className="text-left">إجراء</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredTickets.map((ticket) => (
                                <TableRow key={ticket.id}>
                                    <TableCell className="font-medium">{ticket.id}</TableCell>
                                    <TableCell>{ticket.user} <Badge variant="outline" className="text-xs">{ticket.type === 'customer' ? 'عميل' : ticket.type === 'merchant' ? 'تاجر' : 'شريك'}</Badge></TableCell>
                                    <TableCell className="max-w-xs truncate">{ticket.subject}</TableCell>
                                    <TableCell><Badge className={statusBadges[ticket.status] || 'bg-slate-100 text-slate-800'}>{ticket.status}</Badge></TableCell>
                                    <TableCell><Badge variant="outline" className={priorityBadges[ticket.priority] || ''}>{ticket.priority}</Badge></TableCell>
                                    <TableCell>{ticket.assignedTo}</TableCell>
                                    <TableCell className="text-xs text-slate-500">{ticket.lastUpdate}</TableCell>
                                    <TableCell className="text-left">
                                        <Button variant="ghost" size="sm" onClick={() => openViewModal(ticket)}><Eye className="w-4 h-4 ml-2"/>عرض/رد</Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                             {filteredTickets.length === 0 && <TableRow><TableCell colSpan={8} className="h-24 text-center">لا توجد تذاكر تطابق الفلاتر.</TableCell></TableRow>}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>

            {selectedTicket && (
                <Dialog open={isViewModalOpen} onOpenChange={setIsViewModalOpen}>
                    <DialogContent dir="rtl" className="sm:max-w-lg">
                        <DialogHeader>
                            <DialogTitle>تذكرة دعم: {selectedTicket.id}</DialogTitle>
                            <DialogDescription>
                                <span className="block">المستخدم: {selectedTicket.user}</span>
                                <span className="block">الموضوع: {selectedTicket.subject}</span>
                            </DialogDescription>
                        </DialogHeader>
                        <div className="py-4 space-y-3 max-h-[50vh] overflow-y-auto">
                            <p><strong>التفاصيل (وهمي):</strong> هذا نص وهمي لتفاصيل التذكرة. يمكن عرض سجل المحادثات هنا.</p>
                            <div className="mt-4 space-y-2">
                                <Label htmlFor="replyText">إضافة رد:</Label>
                                <Textarea id="replyText" value={replyText} onChange={(e) => setReplyText(e.target.value)} placeholder="اكتب ردك هنا..." />
                                <Button onClick={handleSendReply} className="w-full"><Send className="w-4 h-4 ml-2" />إرسال الرد</Button>
                            </div>
                        </div>
                        <DialogFooter className="gap-2 flex-col sm:flex-row">
                            <Button variant="outline" onClick={() => handleTicketAction(selectedTicket.status === 'مغلقة' ? 'reopen' : 'close')}>
                                {selectedTicket.status === 'مغلقة' ? <Archive className="w-4 h-4 ml-2"/> : <CheckCircle className="w-4 h-4 ml-2"/>}
                                {selectedTicket.status === 'مغلقة' ? 'إعادة فتح التذكرة' : 'إغلاق التذكرة'}
                            </Button>
                             <Button variant="outline" onClick={() => handleFeatureClick(`إسناد تذكرة ${selectedTicket.id} لموظف آخر`)}>إسناد لموظف آخر</Button>
                            <DialogClose asChild><Button variant="ghost" onClick={() => handleFeatureClick("إغلاق نافذة عرض التذكرة")}>إغلاق النافذة</Button></DialogClose>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>
            )}
        </div>
    );
};

export default SupportSystem;