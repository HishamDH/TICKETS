import React, { memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { LogIn, CheckCircle, XCircle, Monitor, Smartphone, Tablet } from 'lucide-react';
import { format } from "date-fns";
import { ar } from "date-fns/locale";

const loginHistoryData = [
    { id: 'lh1', deviceType: 'desktop', browser: 'Chrome', ip: '192.168.1.1', location: 'الرياض, السعودية', time: new Date().toISOString(), status: 'success' },
    { id: 'lh2', deviceType: 'mobile', browser: 'Safari', ip: '10.0.0.5', location: 'جدة, السعودية', time: new Date(Date.now() - 2 * 60 * 60 * 1000).toISOString(), status: 'success' },
    { id: 'lh3', deviceType: 'desktop', browser: 'Firefox', ip: '88.201.55.90', location: 'القاهرة, مصر', time: new Date(Date.now() - 5 * 60 * 60 * 1000).toISOString(), status: 'failure' },
    { id: 'lh4', deviceType: 'tablet', browser: 'Chrome', ip: '192.168.1.1', location: 'الرياض, السعودية', time: new Date(Date.now() - 24 * 60 * 60 * 1000).toISOString(), status: 'success' },
];

const deviceIcons = {
    desktop: <Monitor className="w-5 h-5" />,
    mobile: <Smartphone className="w-5 h-5" />,
    tablet: <Tablet className="w-5 h-5" />,
};

const LoginHistoryContent = memo(() => {
    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">سجل الدخول للحساب</h2>
            
            <Card>
                <CardHeader>
                    <CardTitle>قائمة عمليات تسجيل الدخول الأخيرة</CardTitle>
                    <CardDescription>هذا سجل بعمليات الدخول لحسابك. إذا لاحظت أي نشاط مشبوه، نوصي بتغيير كلمة المرور فوراً.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>الجهاز والمتصفح</TableHead>
                                <TableHead>الموقع (عنوان IP)</TableHead>
                                <TableHead>التاريخ والوقت</TableHead>
                                <TableHead>الحالة</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {loginHistoryData.map((log) => (
                                <TableRow key={log.id}>
                                    <TableCell>
                                        <div className="flex items-center gap-2">
                                            {deviceIcons[log.deviceType]}
                                            <span>{log.browser}</span>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <div>
                                            <p>{log.location}</p>
                                            <p className="text-xs text-slate-500 font-mono">{log.ip}</p>
                                        </div>
                                    </TableCell>
                                    <TableCell>{format(new Date(log.time), 'PPP p', { locale: ar })}</TableCell>
                                    <TableCell>
                                        <span className={`flex items-center gap-1 font-semibold ${log.status === 'success' ? 'text-green-600' : 'text-red-600'}`}>
                                            {log.status === 'success' ? <CheckCircle className="w-4 h-4"/> : <XCircle className="w-4 h-4"/>}
                                            {log.status === 'success' ? 'نجاح' : 'فشل'}
                                        </span>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    );
});

export default LoginHistoryContent;