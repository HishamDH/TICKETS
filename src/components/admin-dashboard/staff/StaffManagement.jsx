import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { MoreHorizontal, UserPlus, Edit, Trash2, Shield, Search } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Checkbox } from "@/components/ui/checkbox";

const allPermissions = [
    { id: 'all', label: 'كل الصلاحيات (مدير نظام)'},
    { id: 'dashboard_view', label: 'عرض لوحة التحكم الرئيسية' },
    { id: 'merchant_management', label: 'إدارة مزودي الخدمات' },
    { id: 'booking_management', label: 'إدارة الحجوزات' },
    { id: 'financial_reports', label: 'عرض التقارير المالية' },
    { id: 'payout_approval', label: 'الموافقة على طلبات السحب' },
    { id: 'support_tickets', label: 'إدارة تذاكر الدعم' },
    { id: 'content_management', label: 'إدارة المحتوى والسياسات' },
    { id: 'staff_management', label: 'إدارة فريق العمل (صلاحيات محدودة)' },
    { id: 'system_settings', label: 'تعديل إعدادات النظام (صلاحيات محدودة)' },
];

const StaffManagement = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [staffList, setStaffList] = useState([]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingStaff, setEditingStaff] = useState(null);
    const [newStaffData, setNewStaffData] = useState({ name: '', email: '', role: '', status: 'نشط', password: '', permissions: [] });
    const [searchTerm, setSearchTerm] = useState('');

    useEffect(() => {
        const savedStaff = localStorage.getItem('lilium_staff_admin');
        if (savedStaff) {
            setStaffList(JSON.parse(savedStaff));
        } else {
            setStaffList([
                { id: 'staff1', name: 'أحمد عبدالله', email: 'ahmad@lilium.sa', role: 'مدير نظام', status: 'نشط', lastLogin: '2025-06-26 10:00', permissions: ['all'] },
                { id: 'staff2', name: 'فاطمة علي', email: 'fatima@lilium.sa', role: 'دعم فني', status: 'نشط', lastLogin: '2025-06-26 09:30', permissions: ['support_tickets', 'view_bookings'] },
                { id: 'staff3', name: 'خالد محمد', email: 'khalid@lilium.sa', role: 'مراجعة محتوى', status: 'غير نشط', lastLogin: '2025-06-20 15:00', permissions: ['content_management', 'merchant_approval'] },
            ]);
        }
    }, []);

    useEffect(() => {
        localStorage.setItem('lilium_staff_admin', JSON.stringify(staffList));
    }, [staffList]);

    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick && typeof propHandleFeatureClick === 'function') {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    const filteredStaff = staffList.filter(staff => 
        staff.name.toLowerCase().includes(searchTerm.toLowerCase()) || staff.email.toLowerCase().includes(searchTerm.toLowerCase())
    );

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        if (editingStaff) {
            setEditingStaff(prev => ({ ...prev, [name]: value }));
        } else {
            setNewStaffData(prev => ({ ...prev, [name]: value }));
        }
    };
    
    const handlePermissionChange = (permissionId) => {
        const currentPermissions = editingStaff ? editingStaff.permissions : newStaffData.permissions;
        let updatedPermissions;
        if (permissionId === 'all') {
             updatedPermissions = currentPermissions.includes('all') ? [] : ['all'];
        } else {
            updatedPermissions = currentPermissions.includes(permissionId)
                ? currentPermissions.filter(p => p !== permissionId && p !== 'all')
                : [...currentPermissions.filter(p => p !== 'all'), permissionId];
        }

        if (editingStaff) {
            setEditingStaff(prev => ({ ...prev, permissions: updatedPermissions }));
        } else {
            setNewStaffData(prev => ({ ...prev, permissions: updatedPermissions }));
        }
    };

    const handleSubmit = () => {
        const dataToSave = editingStaff || newStaffData;
        if (!dataToSave.name || !dataToSave.email || !dataToSave.role) {
            toast({ title: "خطأ", description: "الاسم، البريد الإلكتروني، والدور مطلوبون.", variant: "destructive" });
            return;
        }
        if (!editingStaff && !dataToSave.password) {
            toast({ title: "خطأ", description: "كلمة المرور مطلوبة للموظف الجديد.", variant: "destructive" });
            return;
        }

        if (editingStaff) {
            setStaffList(staffList.map(s => s.id === editingStaff.id ? editingStaff : s));
            handleFeatureClick(`تحديث بيانات الموظف ${editingStaff.name}`);
        } else {
            const newId = `staff${Date.now()}`;
            setStaffList([...staffList, { ...newStaffData, id: newId, lastLogin: 'لم يسجل دخول بعد' }]);
            handleFeatureClick(`إضافة موظف جديد: ${newStaffData.name}`);
        }
        closeModal();
    };

    const openModalForEdit = (staffMember) => {
        setEditingStaff({ ...staffMember });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة تعديل الموظف ${staffMember.name}`);
    };
    
    const openModalForNew = () => {
        setEditingStaff(null);
        setNewStaffData({ name: '', email: '', role: '', status: 'نشط', password: '', permissions: [] });
        setIsModalOpen(true);
        handleFeatureClick("فتح نافذة إضافة موظف جديد");
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setEditingStaff(null);
    };

    const handleDeleteStaff = (staffId) => {
        const staffToDelete = staffList.find(s => s.id === staffId);
        setStaffList(staffList.filter(s => s.id !== staffId));
        handleFeatureClick(`حذف الموظف ${staffToDelete?.name}`);
    };
    
    const renderStaffForm = () => {
        const currentData = editingStaff || newStaffData;
        const currentPermissions = currentData.permissions || [];
        return (
            <div className="space-y-4 max-h-[70vh] overflow-y-auto p-1">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><Label htmlFor="staffName">الاسم الكامل</Label><Input id="staffName" name="name" value={currentData.name} onChange={handleInputChange} /></div>
                    <div><Label htmlFor="staffEmail">البريد الإلكتروني</Label><Input id="staffEmail" name="email" type="email" value={currentData.email} onChange={handleInputChange} /></div>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><Label htmlFor="staffRole">الدور الوظيفي</Label><Input id="staffRole" name="role" value={currentData.role} onChange={handleInputChange} /></div>
                    <div>
                        <Label htmlFor="staffStatus">الحالة</Label>
                        <Select dir="rtl" name="status" value={currentData.status} onValueChange={(val) => handleInputChange({target:{name:'status', value:val}})}>
                            <SelectTrigger><SelectValue /></SelectTrigger>
                            <SelectContent><SelectItem value="نشط">نشط</SelectItem><SelectItem value="غير نشط">غير نشط</SelectItem></SelectContent>
                        </Select>
                    </div>
                </div>
                {!editingStaff && <div><Label htmlFor="staffPassword">كلمة المرور</Label><Input id="staffPassword" name="password" type="password" value={currentData.password} onChange={handleInputChange} /></div>}
                {editingStaff && <div><Label htmlFor="staffNewPassword">كلمة المرور الجديدة (اختياري)</Label><Input id="staffNewPassword" name="password" type="password" placeholder="اتركها فارغة لعدم التغيير" onChange={handleInputChange} /></div>}
                
                <div className="space-y-2 pt-2 border-t">
                    <Label>الصلاحيات الممنوحة:</Label>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    {allPermissions.map(perm => (
                        <div key={perm.id} className="flex items-center space-x-2 space-x-reverse">
                            <Checkbox 
                                id={`perm-${perm.id}`} 
                                checked={currentPermissions.includes(perm.id) || (perm.id !== 'all' && currentPermissions.includes('all'))} 
                                onCheckedChange={() => handlePermissionChange(perm.id)}
                                disabled={perm.id !== 'all' && currentPermissions.includes('all')}
                            />
                            <label htmlFor={`perm-${perm.id}`} className="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">{perm.label}</label>
                        </div>
                    ))}
                    </div>
                </div>
            </div>
        );
    };

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">إدارة فريق العمل</h1>
                    <p className="text-slate-500 mt-1">إضافة وتعديل صلاحيات موظفي الدعم والعمليات في المنصة.</p>
                </div>
                 <Button className="gradient-bg text-white" onClick={openModalForNew}><UserPlus className="w-4 h-4 ml-2"/>إضافة موظف</Button>
            </div>
            <Card>
                 <CardHeader>
                    <div className="flex justify-between items-center">
                        <CardTitle>قائمة الموظفين ({filteredStaff.length})</CardTitle>
                        <div className="relative w-64">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                            <Input placeholder="بحث بالاسم أو البريد..." className="pl-10" value={searchTerm} onChange={(e) => {setSearchTerm(e.target.value); handleFeatureClick(`البحث عن موظف: ${e.target.value}`);}} />
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>الاسم</TableHead>
                                <TableHead>البريد الإلكتروني</TableHead>
                                <TableHead>الدور</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead>آخر تسجيل دخول</TableHead>
                                <TableHead className="text-left">إجراءات</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredStaff.map((staff) => (
                                <TableRow key={staff.id}>
                                    <TableCell className="font-medium">{staff.name}</TableCell>
                                    <TableCell>{staff.email}</TableCell>
                                    <TableCell>{staff.role}</TableCell>
                                    <TableCell><Badge variant={staff.status === 'نشط' ? 'default' : 'destructive'}>{staff.status}</Badge></TableCell>
                                    <TableCell className="text-xs text-slate-500">{staff.lastLogin}</TableCell>
                                    <TableCell className="text-left">
                                        <Button variant="ghost" size="icon" onClick={() => openModalForEdit(staff)} title="تعديل الصلاحيات والبيانات"><Shield className="w-4 h-4 text-blue-500"/></Button>
                                        <Button variant="ghost" size="icon" onClick={() => handleDeleteStaff(staff.id)} title="حذف الموظف"><Trash2 className="w-4 h-4 text-red-500"/></Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                             {filteredStaff.length === 0 && <TableRow><TableCell colSpan={6} className="h-24 text-center">لا يوجد موظفون يطابقون البحث.</TableCell></TableRow>}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
             <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
                <DialogContent dir="rtl" className="sm:max-w-2xl">
                    <DialogHeader>
                        <DialogTitle>{editingStaff ? 'تعديل بيانات وصلاحيات موظف' : 'إضافة موظف جديد'}</DialogTitle>
                        <DialogDescription>
                            {editingStaff ? `تعديل بيانات ${editingStaff.name}` : 'أدخل بيانات الموظف الجديد وحدد صلاحياته.'}
                        </DialogDescription>
                    </DialogHeader>
                    <div className="py-4">{renderStaffForm()}</div>
                    <DialogFooter className="gap-2">
                        <Button variant="ghost" onClick={closeModal}>إلغاء</Button>
                        <Button onClick={handleSubmit}>{editingStaff ? 'حفظ التعديلات' : 'إضافة الموظف'}</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
};

export default StaffManagement;