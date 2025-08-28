
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Globe, Link, PlusCircle } from 'lucide-react';

const domains = [
    { domain: 'tickets.al-thawaqa.com', merchant: 'مطعم الذواقة', status: 'مفعل', ssl: 'صالح' },
    { domain: 'events.winterfest.sa', merchant: 'فعالية الشتاء', status: 'مفعل', ssl: 'صالح' },
    { domain: 'register.techcon.io', merchant: 'مؤتمر TechCon', status: 'بانتظار الربط', ssl: 'معلق' },
];

const statusBadges = {
    'مفعل': 'bg-emerald-100 text-emerald-800',
    'بانتظار الربط': 'bg-amber-100 text-amber-800',
};

const DomainManagement = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">إدارة النطاقات والروابط</h1>
                    <p className="text-slate-500 mt-1">مراقبة وإدارة النطاقات المخصصة للتجار.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("إضافة نطاق جديد")}><PlusCircle className="w-4 h-4 ml-2"/>إضافة نطاق</Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>النطاقات المربوطة</CardTitle>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>النطاق</TableHead>
                                <TableHead>التاجر</TableHead>
                                <TableHead>حالة الربط</TableHead>
                                <TableHead>شهادة SSL</TableHead>
                                <TableHead className="text-left">إجراء</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {domains.map((d) => (
                                <TableRow key={d.domain}>
                                    <TableCell className="font-medium">{d.domain}</TableCell>
                                    <TableCell>{d.merchant}</TableCell>
                                    <TableCell><Badge className={statusBadges[d.status]}>{d.status}</Badge></TableCell>
                                    <TableCell><Badge variant={d.ssl === 'صالح' ? 'default' : 'destructive'}>{d.ssl}</Badge></TableCell>
                                    <TableCell className="text-left">
                                        <Button variant="outline" size="sm" onClick={() => handleFeatureClick(`إدارة نطاق ${d.domain}`)}>إدارة</Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    );
};

export default DomainManagement;
