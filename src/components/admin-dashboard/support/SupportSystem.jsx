
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { MessageSquare, Clock, CheckCircle } from 'lucide-react';

const tickets = [
    { id: '#8761', subject: 'مشكلة في الدفع', merchant: 'مطعم الذواقة', status: 'مفتوحة', assignee: 'فاطمة' },
    { id: '#8760', subject: 'استفسار عن ربط النطاق', merchant: 'فعالية الشتاء', status: 'قيد المعالجة', assignee: 'محمد' },
    { id: '#8759', subject: 'بلاغ عن حجز', merchant: 'تجربة الغوص', status: 'مغلقة', assignee: 'محمد' },
];

const statusBadges = {
    'مفتوحة': 'bg-red-100 text-red-800',
    'قيد المعالجة': 'bg-amber-100 text-amber-800',
    'مغلقة': 'bg-emerald-100 text-emerald-800',
};

const SupportSystem = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">الدعم الفني والبلاغات</h1>
                <p className="text-slate-500 mt-1">إدارة تذاكر الدعم الفني والشكاوى من العملاء والتجار.</p>
            </div>

            <Tabs defaultValue="open">
                <TabsList className="grid w-full grid-cols-3">
                    <TabsTrigger value="open"><MessageSquare className="w-4 h-4 ml-2"/>تذاكر مفتوحة (1)</TabsTrigger>
                    <TabsTrigger value="pending"><Clock className="w-4 h-4 ml-2"/>قيد المعالجة (1)</TabsTrigger>
                    <TabsTrigger value="closed"><CheckCircle className="w-4 h-4 ml-2"/>مغلقة (1)</TabsTrigger>
                </TabsList>
                <TabsContent value="open">
                    <Card>
                        <CardContent className="pt-6">
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>رقم التذكرة</TableHead>
                                        <TableHead>الموضوع</TableHead>
                                        <TableHead>التاجر</TableHead>
                                        <TableHead>الحالة</TableHead>
                                        <TableHead>المسؤول</TableHead>
                                        <TableHead className="text-left">إجراء</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {tickets.filter(t => t.status === 'مفتوحة').map((ticket) => (
                                        <TableRow key={ticket.id}>
                                            <TableCell className="font-medium">{ticket.id}</TableCell>
                                            <TableCell>{ticket.subject}</TableCell>
                                            <TableCell>{ticket.merchant}</TableCell>
                                            <TableCell><Badge className={statusBadges[ticket.status]}>{ticket.status}</Badge></TableCell>
                                            <TableCell>{ticket.assignee}</TableCell>
                                            <TableCell className="text-left">
                                                <Button variant="outline" size="sm" onClick={() => handleFeatureClick(`عرض تذكرة ${ticket.id}`)}>عرض</Button>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </TabsContent>
            </Tabs>
        </div>
    );
};

export default SupportSystem;
