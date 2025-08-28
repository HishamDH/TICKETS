
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { MoreHorizontal, Search, FileCheck, FileX, UserPlus } from 'lucide-react';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const merchants = [
    { name: 'مطعم الذواقة', type: 'مطعم', status: 'مفعل', joined: '2023-05-12', avatar: 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=200' },
    { name: 'فعالية الشتاء', type: 'فعالية', status: 'مفعل', joined: '2023-08-01', avatar: 'https://images.unsplash.com/photo-1607004468138-3deaf2e7f2b8?q=80&w=200' },
    { name: 'مؤتمر TechCon', type: 'معرض', status: 'طلب جديد', joined: '2023-10-20', avatar: 'https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=200' },
    { name: 'تجربة الغوص', type: 'تجربة', status: 'موقوف', joined: '2023-02-15', avatar: 'https://images.unsplash.com/photo-1530541930197-58e36e846473?q=80&w=200' },
];

const statusBadges = {
    'مفعل': 'bg-emerald-100 text-emerald-800',
    'طلب جديد': 'bg-amber-100 text-amber-800',
    'موقوف': 'bg-red-100 text-red-800',
};

const MerchantsControl = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">إدارة التجار</h1>
                    <p className="text-slate-500 mt-1">مراجعة وتفعيل وإدارة حسابات التجار.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("إضافة تاجر جديد")}><UserPlus className="w-4 h-4 ml-2"/>إضافة تاجر</Button>
            </div>

            <Card>
                <CardHeader>
                    <div className="flex justify-between items-center">
                        <CardTitle>قائمة التجار</CardTitle>
                        <div className="flex items-center gap-2">
                            <div className="relative w-64">
                                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input placeholder="بحث عن تاجر..." className="pl-10" />
                            </div>
                            <Select>
                                <SelectTrigger className="w-[180px]">
                                    <SelectValue placeholder="فلترة حسب الحالة" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">الكل</SelectItem>
                                    <SelectItem value="active">مفعل</SelectItem>
                                    <SelectItem value="new">طلب جديد</SelectItem>
                                    <SelectItem value="suspended">موقوف</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>التاجر</TableHead>
                                <TableHead>النوع</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead>تاريخ الانضمام</TableHead>
                                <TableHead className="text-left">إجراءات</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {merchants.map((merchant) => (
                                <TableRow key={merchant.name}>
                                    <TableCell className="font-medium">{merchant.name}</TableCell>
                                    <TableCell>{merchant.type}</TableCell>
                                    <TableCell><Badge className={statusBadges[merchant.status]}>{merchant.status}</Badge></TableCell>
                                    <TableCell>{merchant.joined}</TableCell>
                                    <TableCell className="text-left">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger asChild>
                                                <Button variant="ghost" size="icon"><MoreHorizontal className="w-5 h-5"/></Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="start">
                                                <DropdownMenuItem onClick={() => handleFeatureClick(`مراجعة ${merchant.name}`)}><FileCheck className="w-4 h-4 ml-2"/>مراجعة الطلب</DropdownMenuItem>
                                                <DropdownMenuItem className="text-red-500" onClick={() => handleFeatureClick(`إيقاف ${merchant.name}`)}><FileX className="w-4 h-4 ml-2"/>إيقاف الحساب</DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
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

export default MerchantsControl;
