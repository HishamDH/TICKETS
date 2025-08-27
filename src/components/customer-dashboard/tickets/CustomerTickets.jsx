import React, { useState, useEffect } from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Download, PlusCircle, QrCode, Search, Filter, CalendarDays, Ticket } from 'lucide-react';
import { Badge } from '@/components/ui/badge';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { format, parseISO } from 'date-fns';
import { ar } from 'date-fns/locale';

const initialTicketsData = [
    { id: 'tkt1', event: 'حجز قاعة الأفراح الملكية', type: 'تذكرة دخول رئيسية', status: 'صالحة', date: '2025-12-16', qrValue: 'LiliumNightTicket-RoyalHall-20251216' },
    { id: 'tkt2', event: 'تصوير فوتوغرافي (استوديو الإبداع)', type: 'تأكيد حجز خدمة', status: 'صالحة', date: '2025-12-20', qrValue: 'LiliumNightService-CreativeStudio-20251220' },
    { id: 'tkt3', event: 'بوفيه الكرم للضيافة', type: 'تأكيد حجز خدمة', status: 'مستخدمة', date: '2025-05-05', qrValue: 'LiliumNightService-KaramBuffet-20250505' },
    { id: 'tkt4', event: 'ورشة عمل فنية', type: 'تذكرة ورشة عمل', status: 'صالحة', date: '2025-07-10', qrValue: 'LiliumNightWorkshop-ArtFun-20250710' },
];

const TicketCard = ({ ticket, onAction }) => {
    const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(ticket.qrValue)}`;
    return (
    <Card className="overflow-hidden shadow-md hover:shadow-lg transition-shadow">
        <div className="p-4 bg-slate-50 border-b">
            <h3 className="font-bold text-lg text-slate-800">{ticket.event}</h3>
            <p className="text-sm text-slate-500">{ticket.type} - {format(parseISO(ticket.date), 'PPP', { locale: ar })}</p>
        </div>
        <CardContent className="p-4 space-y-4">
            <div className="flex justify-center">
                 <img  alt={`QR Code for ${ticket.event}`} className="w-36 h-36 rounded-md border p-1" src={qrApiUrl} />
            </div>
            <Badge variant={ticket.status === 'صالحة' ? 'default' : 'destructive'} className="w-full justify-center py-1.5 text-sm">{ticket.status}</Badge>
            <div className="flex gap-2">
                <Button variant="outline" className="w-full" onClick={() => onAction("تحميل التذكرة", ticket)}><Download className="w-4 h-4 ml-2" /> تحميل</Button>
                <Button className="w-full gradient-bg text-white" onClick={() => onAction("إضافة للمحفظة", ticket)}><PlusCircle className="w-4 h-4 ml-2" /> إضافة للمحفظة</Button>
            </div>
        </CardContent>
    </Card>
    )
};

const CustomerTickets = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [tickets, setTickets] = useState(() => {
        const savedTickets = localStorage.getItem('lilium_customer_tickets_v1');
        return savedTickets ? JSON.parse(savedTickets) : initialTicketsData;
    });
    const [searchTerm, setSearchTerm] = useState('');
    const [statusFilter, setStatusFilter] = useState('all');

    useEffect(() => {
        localStorage.setItem('lilium_customer_tickets_v1', JSON.stringify(tickets));
    }, [tickets]);

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


    const handleTicketAction = (actionName, ticket) => {
        toast({
            title: `تم ${actionName}`,
            description: `تم تنفيذ الإجراء على تذكرة "${ticket.event}".`,
        });
        handleFeatureClick(`${actionName} لتذكرة ${ticket.event}`);
    };

    const filteredTickets = tickets.filter(t => 
        (t.event.toLowerCase().includes(searchTerm.toLowerCase()) || t.type.toLowerCase().includes(searchTerm.toLowerCase())) &&
        (statusFilter === 'all' || t.status === statusFilter)
    ).sort((a,b) => new Date(b.date) - new Date(a.date));


    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">تذاكر حجوزاتي (الإشعارات)</h1>
                <p className="text-slate-500 mt-1">عرض وتحميل جميع تذاكر حجوزاتك الصالحة لمناسباتك مع ليلة الليليوم. تعمل هذه الصفحة كبديل لقسم الإشعارات حالياً.</p>
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>فلترة التذاكر</CardTitle>
                    <div className="flex flex-wrap gap-2 pt-2">
                        <div className="relative flex-grow">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                            <Input placeholder="بحث باسم المناسبة أو نوع التذكرة..." className="pl-10 w-full" value={searchTerm} onChange={(e) => setSearchTerm(e.target.value)} />
                        </div>
                        <Select value={statusFilter} onValueChange={(val) => {setStatusFilter(val); handleFeatureClick(`فلترة التذاكر بـ ${val}`) }}>
                            <SelectTrigger className="w-full sm:w-[180px]"><SelectValue /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">كل الحالات</SelectItem>
                                <SelectItem value="صالحة">صالحة</SelectItem>
                                <SelectItem value="مستخدمة">مستخدمة</SelectItem>
                                <SelectItem value="ملغاة">ملغاة</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </CardHeader>
            </Card>
            {filteredTickets.length > 0 ? (
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {filteredTickets.map(ticket => <TicketCard key={ticket.id} ticket={ticket} onAction={handleTicketAction}/>)}
                </div>
            ) : (
                <Card className="text-center py-12">
                    <CardContent>
                        <Ticket className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                        <p className="text-xl font-semibold text-slate-600">لا توجد تذاكر تطابق بحثك.</p>
                        <p className="text-slate-500">حاول تغيير فلاتر البحث أو تأكد من حجوزاتك.</p>
                    </CardContent>
                </Card>
            )}
        </div>
    );
};

export default CustomerTickets;