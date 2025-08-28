import React from 'react';
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { UserPlus, MoreVertical, Trash2, Edit } from 'lucide-react';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Badge } from "@/components/ui/badge";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";

const teamMembers = [
    { name: 'علياء حسن', email: 'aliaa@example.com', role: 'مشرف', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200' },
    { name: 'يوسف خالد', email: 'youssef@example.com', role: 'دعم', avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200' },
    { name: 'نور أحمد', email: 'nour@example.com', role: 'تحقق', avatar: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=200' },
];

const roleBadges = {
    'مشرف': 'bg-primary/20 text-primary',
    'دعم': 'bg-sky-100 text-sky-800',
    'تحقق': 'bg-amber-100 text-amber-800',
};

const TeamManagementContent = ({ handleFeatureClick }) => (
    <div className="space-y-8">
        <div className="flex justify-between items-center">
            <h2 className="text-3xl font-bold text-slate-800">إدارة الفريق</h2>
            <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("إضافة موظف")}><UserPlus className="w-4 h-4 ml-2"/>إضافة موظف</Button>
        </div>
        <Card>
            <CardHeader>
                <CardTitle>أعضاء الفريق ({teamMembers.length})</CardTitle>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>العضو</TableHead>
                            <TableHead>الدور</TableHead>
                            <TableHead>آخر نشاط</TableHead>
                            <TableHead className="text-left">إجراءات</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {teamMembers.map((member) => (
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
                                <TableCell>
                                    <Badge className={roleBadges[member.role]}>{member.role}</Badge>
                                </TableCell>
                                <TableCell className="text-slate-500">قبل 3 ساعات</TableCell>
                                <TableCell className="text-left">
                                    <DropdownMenu>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="ghost" size="icon"><MoreVertical className="w-5 h-5"/></Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="start">
                                            <DropdownMenuItem onClick={() => handleFeatureClick(`تعديل ${member.name}`)}><Edit className="w-4 h-4 ml-2"/>تعديل الصلاحيات</DropdownMenuItem>
                                            <DropdownMenuItem className="text-red-500" onClick={() => handleFeatureClick(`حذف ${member.name}`)}><Trash2 className="w-4 h-4 ml-2"/>حذف الموظف</DropdownMenuItem>
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

export default TeamManagementContent;