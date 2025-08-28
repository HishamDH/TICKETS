
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Shield, History, KeyRound, Ban } from 'lucide-react';

const auditLogs = [
    { user: 'عبدالله القحطاني', action: 'وافق على طلب سحب', details: 'مطعم الذواقة - 2,500 ريال', ip: '192.168.1.1', time: 'قبل 5 دقائق' },
    { user: 'تاجر: مطعم الذواقة', action: 'تحديث سياسة الإلغاء', details: '', ip: '10.0.0.5', time: 'قبل ساعة' },
    { user: 'نظام', action: 'فشل عملية دفع', details: 'حجز #1238 - بطاقة مرفوضة', ip: 'N/A', time: 'قبل 3 ساعات' },
];

const SecurityMonitoring = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">الحماية والمراقبة الأمنية</h1>
                <p className="text-slate-500 mt-1">مراقبة الأنشطة الحساسة وتأمين المنصة.</p>
            </div>

            <Tabs defaultValue="audit">
                <TabsList className="grid w-full grid-cols-3">
                    <TabsTrigger value="audit"><History className="w-4 h-4 ml-2"/>سجل الأنشطة</TabsTrigger>
                    <TabsTrigger value="logins"><KeyRound className="w-4 h-4 ml-2"/>محاولات الدخول</TabsTrigger>
                    <TabsTrigger value="blocklist"><Ban className="w-4 h-4 ml-2"/>قائمة الحظر</TabsTrigger>
                </TabsList>
                <TabsContent value="audit">
                    <Card>
                        <CardHeader>
                            <CardTitle>سجل الأنشطة (Audit Trail)</CardTitle>
                            <CardDescription>آخر العمليات الحساسة التي تمت في النظام.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>المستخدم</TableHead>
                                        <TableHead>الإجراء</TableHead>
                                        <TableHead>التفاصيل</TableHead>
                                        <TableHead>IP Address</TableHead>
                                        <TableHead>الوقت</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {auditLogs.map((log, index) => (
                                        <TableRow key={index}>
                                            <TableCell className="font-medium">{log.user}</TableCell>
                                            <TableCell>{log.action}</TableCell>
                                            <TableCell>{log.details}</TableCell>
                                            <TableCell>{log.ip}</TableCell>
                                            <TableCell>{log.time}</TableCell>
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

export default SecurityMonitoring;
