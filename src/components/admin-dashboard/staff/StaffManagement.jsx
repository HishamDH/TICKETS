
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { MoreHorizontal, UserPlus, Edit, ShieldOff } from 'lucide-react';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";

const staff = [
    { name: 'عبدالله القحطاني', email: 'abdullah@shubbak.com', role: 'Super Admin', avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200' },
    { name: 'فاطمة الزهراني', email: 'fatima@shubbak.com', role: 'محاسب', avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200' },
    { name: 'محمد الغامدي', email: 'mohammed@shubbak.com', role: 'دعم فني', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200' },
];

const roleBadges = {
    'Super Admin': 'bg-red-100 text-red-800',
    'محاسب': 'bg-sky-100 text-sky-800',
    'دعم فني': 'bg-amber-100 text-amber-800',
};

const StaffManagement = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">إدارة موظفي المنصة</h1>
                    <p className="text-slate-500 mt-1">إضافة وتعديل صلاحيات فريق العمل.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("إضافة موظف جديد")}><UserPlus className="w-4 h-4 ml-2"/>إضافة موظف</Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>فريق العمل</CardTitle>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>الموظف</TableHead>
                                <TableHead>الدور</TableHead>
                                <TableHead>آخر نشاط</TableHead>
                                <TableHead className="text-left">إجراءات</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {staff.map((member) => (
                                <TableRow key={member.email}>
                                    <TableCell>
                                        <div className="flex items-center gap-3">
                                            <Avatar>
                                                <AvatarImage src={member.avatar} />
                                                <AvatarFallback>{member.name.charAt(0)}</AvatarFallback>
                                            </Avatar>
                                            <div>
                                                <div className="font-semibold">{member.name}</div>
                                                <div className="text-sm text-slate-500">{member.email}</div>
                                            </div>
                                        </div>
                                    </TableCell>
                                    <TableCell><Badge className={roleBadges[member.role]}>{member.role}</Badge></TableCell>
                                    <TableCell className="text-slate-500">قبل ساعة</TableCell>
                                    <TableCell className="text-left">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger asChild>
                                                <Button variant="ghost" size="icon"><MoreHorizontal className="w-5 h-5"/></Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="start">
                                                <DropdownMenuItem onClick={() => handleFeatureClick(`تعديل ${member.name}`)}><Edit className="w-4 h-4 ml-2"/>تعديل الصلاحيات</DropdownMenuItem>
                                                <DropdownMenuItem className="text-red-500" onClick={() => handleFeatureClick(`حذف ${member.name}`)}><ShieldOff className="w-4 h-4 ml-2"/>إزالة الموظف</DropdownMenuItem>
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

export default StaffManagement;
