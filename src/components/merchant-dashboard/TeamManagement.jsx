import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { UserPlus, MoreVertical, Trash2, Edit, Shield, Eye } from 'lucide-react';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Badge } from "@/components/ui/badge";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Checkbox } from '@/components/ui/checkbox';
import { useToast } from "@/components/ui/use-toast";

const initialTeamMembers = [
    { id: 'tm1', name: 'علياء حسن', email: 'aliaa@example.com', role: 'مشرف', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200', lastActivity: 'قبل 10 دقائق', permissions: ['all'] },
    { id: 'tm2', name: 'يوسف خالد', email: 'youssef@example.com', role: 'دعم فني', avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200', lastActivity: 'قبل ساعة', permissions: ['bookings_view', 'customer_communication'] },
    { id: 'tm3', name: 'نور أحمد', email: 'nour@example.com', role: 'مدير فرع الرياض', avatar: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=200', lastActivity: 'أمس', permissions: ['branch_riyadh_manage', 'pos_access'] },
];

const roleBadges = {
    'مشرف': 'bg-primary/20 text-primary',
    'دعم فني': 'bg-sky-100 text-sky-800',
    'مدير فرع الرياض': 'bg-amber-100 text-amber-800',
    'مدقق حجوزات': 'bg-purple-100 text-purple-800',
};

const allPermissionsList = [
    { id: 'all', label: 'وصول كامل (مشرف عام)' },
    { id: 'bookings_view', label: 'عرض الحجوزات' },
    { id: 'bookings_manage', label: 'إدارة الحجوزات (تأكيد/إلغاء)' },
    { id: 'calendar_manage', label: 'إدارة التقويم والتوفر' },
    { id: 'packages_manage', label: 'إدارة الباقات والخدمات' },
    { id: 'customer_communication', label: 'التواصل مع العملاء' },
    { id: 'pos_access', label: 'الوصول لنقطة البيع (POS)' },
    { id: 'reports_view', label: 'عرض التقارير' },
    { id: 'branch_riyadh_manage', label: 'إدارة فرع الرياض (خاص)' },
    { id: 'promotions_manage', label: 'إدارة العروض والخصومات' },
];

const TeamManagementContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [teamMembers, setTeamMembers] = useState(JSON.parse(localStorage.getItem('lilium_night_team_v1')) || initialTeamMembers);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingMember, setEditingMember] = useState(null);
    const [newMemberData, setNewMemberData] = useState({ name: '', email: '', role: 'دعم فني', permissions: [] });

    useEffect(() => {
        localStorage.setItem('lilium_night_team_v1', JSON.stringify(teamMembers));
    }, [teamMembers]);
    
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

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        if (editingMember) {
            setEditingMember(prev => ({ ...prev, [name]: value }));
        } else {
            setNewMemberData(prev => ({ ...prev, [name]: value }));
        }
    };
    
    const handlePermissionsChange = (permissionId, checked) => {
        const targetData = editingMember ? editingMember : newMemberData;
        const setTargetData = editingMember ? setEditingMember : setNewMemberData;
        let updatedPermissions;
        if (checked) {
            updatedPermissions = [...targetData.permissions, permissionId];
        } else {
            updatedPermissions = targetData.permissions.filter(p => p !== permissionId);
        }
        setTargetData(prev => ({ ...prev, permissions: updatedPermissions }));
        handleFeatureClick(`تغيير صلاحية ${permissionId} لـ ${targetData.name}`);
    };

    const handleSubmit = () => {
        const dataToSave = editingMember || newMemberData;
        if (!dataToSave.name || !dataToSave.email || !dataToSave.role) {
            toast({ title: "خطأ", description: "الاسم، البريد الإلكتروني، والدور مطلوبون.", variant: "destructive" });
            return;
        }

        if (editingMember) {
            setTeamMembers(teamMembers.map(m => m.id === editingMember.id ? editingMember : m));
            handleFeatureClick(`تحديث بيانات الموظف: ${editingMember.name}`);
        } else {
            const newId = `tm${Date.now()}`;
            setTeamMembers([...teamMembers, { ...newMemberData, id: newId, avatar: `https://source.unsplash.com/random/200x200?sig=${newId}`, lastActivity: 'الآن' }]);
            handleFeatureClick(`إضافة موظف جديد: ${newMemberData.name}`);
        }
        closeModal();
    };

    const openModalForEdit = (member) => {
        setEditingMember({ ...member });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة تعديل الموظف: ${member.name}`);
    };
    
    const openModalForNew = () => {
        setEditingMember(null);
        setNewMemberData({ name: '', email: '', role: 'دعم فني', permissions: [] });
        setIsModalOpen(true);
        handleFeatureClick("فتح نافذة إضافة موظف جديد");
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setEditingMember(null);
        handleFeatureClick("إغلاق نافذة إضافة/تعديل موظف");
    };

    const handleDeleteMember = (memberId) => {
        const memberToDelete = teamMembers.find(m => m.id === memberId);
        setTeamMembers(teamMembers.filter(m => m.id !== memberId));
        handleFeatureClick(`حذف الموظف: ${memberToDelete?.name}`);
    };

    const renderMemberForm = () => {
        const currentData = editingMember || newMemberData;
        return (
            <div className="space-y-4" dir="rtl">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <Label htmlFor="memberName">اسم الموظف</Label>
                        <Input id="memberName" name="name" value={currentData.name} onChange={handleInputChange} />
                    </div>
                    <div>
                        <Label htmlFor="memberEmail">البريد الإلكتروني</Label>
                        <Input id="memberEmail" name="email" type="email" value={currentData.email} onChange={handleInputChange} />
                    </div>
                </div>
                <div>
                    <Label htmlFor="memberRole">الدور الوظيفي</Label>
                    <Select name="role" value={currentData.role} onValueChange={(val) => handleInputChange({target: {name: 'role', value: val}})}>
                        <SelectTrigger><SelectValue /></SelectTrigger>
                        <SelectContent>
                            {Object.keys(roleBadges).map(r => <SelectItem key={r} value={r}>{r}</SelectItem>)}
                            <SelectItem value="مدقق حجوزات">مدقق حجوزات</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
                <div>
                    <Label>الصلاحيات</Label>
                    <div className="grid grid-cols-2 md:grid-cols-3 gap-2 p-3 border rounded-md max-h-60 overflow-y-auto">
                        {allPermissionsList.map(p => (
                            <div key={p.id} className="flex items-center space-x-2 space-x-reverse">
                                <Checkbox 
                                    id={`perm-${p.id}-${currentData.id || 'new'}`} 
                                    checked={currentData.permissions.includes(p.id) || (currentData.permissions.includes('all') && p.id !== 'all')}
                                    onCheckedChange={(checked) => handlePermissionsChange(p.id, checked)}
                                    disabled={currentData.permissions.includes('all') && p.id !== 'all'}
                                />
                                <Label htmlFor={`perm-${p.id}-${currentData.id || 'new'}`} className="text-sm font-normal">{p.label}</Label>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        );
    };

    return (
    <div className="space-y-8">
        <div className="flex justify-between items-center">
            <h2 className="text-3xl font-bold text-slate-800">إدارة الفريق</h2>
            <Button className="gradient-bg text-white" onClick={openModalForNew}><UserPlus className="w-4 h-4 ml-2"/>إضافة موظف</Button>
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
                            <TableHead>الصلاحيات (عدد)</TableHead>
                            <TableHead>آخر نشاط</TableHead>
                            <TableHead className="text-left">إجراءات</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {teamMembers.map((member) => (
                            <TableRow key={member.id}>
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
                                    <Badge className={roleBadges[member.role] || 'bg-slate-100 text-slate-800'}>{member.role}</Badge>
                                </TableCell>
                                <TableCell>{member.permissions.includes('all') ? 'كاملة' : member.permissions.length}</TableCell>
                                <TableCell className="text-slate-500">{member.lastActivity}</TableCell>
                                <TableCell className="text-left">
                                    <DropdownMenu>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="ghost" size="icon"><MoreVertical className="w-5 h-5"/></Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="start">
                                            <DropdownMenuItem onClick={() => openModalForEdit(member)}><Edit className="w-4 h-4 ml-2"/>تعديل البيانات والصلاحيات</DropdownMenuItem>
                                            <DropdownMenuItem className="text-red-500" onClick={() => handleDeleteMember(member.id)}><Trash2 className="w-4 h-4 ml-2"/>حذف الموظف</DropdownMenuItem>
                                            <DropdownMenuItem onClick={() => handleFeatureClick(`عرض سجل نشاط ${member.name}`)}><Eye className="w-4 h-4 ml-2"/>عرض سجل النشاط</DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
        </Card>
        <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
            <DialogContent dir="rtl" className="sm:max-w-[625px]">
                <DialogHeader>
                    <DialogTitle>{editingMember ? 'تعديل بيانات موظف' : 'إضافة موظف جديد'}</DialogTitle>
                    <DialogDescription>
                        {editingMember ? `تعديل بيانات وصلاحيات ${editingMember.name}` : 'أدخل بيانات الموظف الجديد وحدد صلاحياته.'}
                    </DialogDescription>
                </DialogHeader>
                <div className="py-4">{renderMemberForm()}</div>
                <DialogFooter className="gap-2">
                    <Button variant="ghost" onClick={closeModal}>إلغاء</Button>
                    <Button onClick={handleSubmit}>{editingMember ? 'حفظ التعديلات' : 'إضافة الموظف'}</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </div>
    );
});

export default TeamManagementContent;