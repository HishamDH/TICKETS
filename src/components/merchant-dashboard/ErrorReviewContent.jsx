import React, { useState, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { AlertTriangle, CheckCircle, Clock } from 'lucide-react';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { format } from "date-fns";
import { ar } from "date-fns/locale";

const initialErrors = [
    { id: 'err1', code: 'PAY-001', description: 'فشل عملية الدفع للعميل أحمد علي (بطاقة مرفوضة)', timestamp: new Date().toISOString(), severity: 'high', status: 'new' },
    { id: 'err2', code: 'API-404', description: 'فشل مزامنة التقويم مع Google Calendar', timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000).toISOString(), severity: 'medium', status: 'investigating' },
    { id: 'err3', code: 'BOOK-003', description: 'محاولة حجز مزدوج على باقة تم حجزها', timestamp: new Date(Date.now() - 5 * 60 * 60 * 1000).toISOString(), severity: 'high', status: 'resolved' },
    { id: 'err4', code: 'EMAIL-002', description: 'فشل إرسال بريد تأكيد الحجز للعميل سارة', timestamp: new Date(Date.now() - 24 * 60 * 60 * 1000).toISOString(), severity: 'low', status: 'resolved' },
];

const statusMap = {
    new: { label: 'جديد', icon: <AlertTriangle className="w-4 h-4 text-red-500" />, color: 'bg-red-100 text-red-800' },
    investigating: { label: 'قيد التحقيق', icon: <Clock className="w-4 h-4 text-yellow-500" />, color: 'bg-yellow-100 text-yellow-800' },
    resolved: { label: 'تم الحل', icon: <CheckCircle className="w-4 h-4 text-green-500" />, color: 'bg-green-100 text-green-800' },
};

const severityMap = {
    high: { label: 'عالي', color: 'bg-red-500' },
    medium: { label: 'متوسط', color: 'bg-yellow-500' },
    low: { label: 'منخفض', color: 'bg-blue-500' },
};

const ErrorReviewContent = memo(({ handleFeatureClick }) => {
    const [errors, setErrors] = useState(initialErrors);
    const [statusFilter, setStatusFilter] = useState('all');
    const [severityFilter, setSeverityFilter] = useState('all');

    const filteredErrors = errors.filter(err => 
        (statusFilter === 'all' || err.status === statusFilter) &&
        (severityFilter === 'all' || err.severity === severityFilter)
    );

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">مراجعة الأخطاء والمشاكل</h2>
            <Card>
                <CardHeader>
                    <CardTitle>سجل الأخطاء والمشاكل التقنية</CardTitle>
                    <CardDescription>هنا يمكنك متابعة أي مشاكل تقنية تحدث في حسابك، مثل عمليات الدفع الفاشلة أو أخطاء المزامنة.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="flex gap-4 mb-6">
                        <Select value={statusFilter} onValueChange={setStatusFilter}>
                            <SelectTrigger className="w-[180px]"><SelectValue placeholder="فلترة بالحالة" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">كل الحالات</SelectItem>
                                <SelectItem value="new">جديد</SelectItem>
                                <SelectItem value="investigating">قيد التحقيق</SelectItem>
                                <SelectItem value="resolved">تم الحل</SelectItem>
                            </SelectContent>
                        </Select>
                        <Select value={severityFilter} onValueChange={setSeverityFilter}>
                            <SelectTrigger className="w-[180px]"><SelectValue placeholder="فلترة بالأهمية" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">كل المستويات</SelectItem>
                                <SelectItem value="high">عالي</SelectItem>
                                <SelectItem value="medium">متوسط</SelectItem>
                                <SelectItem value="low">منخفض</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>الأهمية</TableHead>
                                <TableHead>الوصف</TableHead>
                                <TableHead>الوقت</TableHead>
                                <TableHead>الحالة</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredErrors.map(err => (
                                <TableRow key={err.id}>
                                    <TableCell>
                                        <Badge className={`${severityMap[err.severity].color} hover:${severityMap[err.severity].color} text-white`}>
                                            {severityMap[err.severity].label}
                                        </Badge>
                                    </TableCell>
                                    <TableCell>
                                        <p className="font-semibold">{err.description}</p>
                                        <p className="text-xs text-slate-500 font-mono">{err.code}</p>
                                    </TableCell>
                                    <TableCell>{format(new Date(err.timestamp), 'Pp', { locale: ar })}</TableCell>
                                    <TableCell>
                                        <span className={`flex items-center gap-2 text-sm font-semibold px-2 py-1 rounded-full ${statusMap[err.status].color}`}>
                                            {statusMap[err.status].icon}
                                            {statusMap[err.status].label}
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

export default ErrorReviewContent;