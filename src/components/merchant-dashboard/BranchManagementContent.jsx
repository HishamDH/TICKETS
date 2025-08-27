import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { GitBranch, PlusCircle, Edit, Trash2, CheckCircle, XCircle, Clock } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogDescription } from "@/components/ui/dialog";

const BranchManagementContent = memo(({ handleNavigation, handleFeatureClick }) => {
    const { toast } = useToast();
    const [branches, setBranches] = useState(JSON.parse(localStorage.getItem('lilium_night_branches_v1')) || [
        { id: 'BR-RYD-MAIN', name: 'قاعة الرياض الرئيسية', location: 'الرياض، حي الياسمين، شارع الملك عبدالعزيز', status: 'active', services: ['قاعات', 'بوفيه'], manager: 'أحمد عبدالله', phone: '0501234567' },
        { id: 'BR-JED-STUDIO', name: 'استوديو جدة للتصوير', location: 'جدة، حي الشاطئ، طريق الكورنيش', status: 'active', services: ['تصوير'], manager: 'سارة خالد', phone: '0557654321' },
    ]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingBranch, setEditingBranch] = useState(null);
    const [newBranchData, setNewBranchData] = useState({ name: '', location: '', status: 'active', services: [], manager: '', phone: '' });

    useEffect(() => {
        localStorage.setItem('lilium_night_branches_v1', JSON.stringify(branches));
    }, [branches]);

     const internalHandleFeatureClick = (featureName) => {
        if (handleFeatureClick && typeof handleFeatureClick === 'function') {
            handleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        if (editingBranch) {
            setEditingBranch(prev => ({ ...prev, [name]: value }));
        } else {
            setNewBranchData(prev => ({ ...prev, [name]: value }));
        }
    };
    
    const handleServicesChange = (service, checked) => {
        const currentServices = editingBranch ? editingBranch.services : newBranchData.services;
        let updatedServices;
        if (checked) {
            updatedServices = [...currentServices, service];
        } else {
            updatedServices = currentServices.filter(s => s !== service);
        }
        if (editingBranch) {
            setEditingBranch(prev => ({ ...prev, services: updatedServices }));
        } else {
            setNewBranchData(prev => ({ ...prev, services: updatedServices }));
        }
        internalHandleFeatureClick(`تغيير خدمة "${service}" في الفرع`);
    };

    const availableServices = ['قاعات', 'بوفيه', 'تصوير', 'تجميل', 'ترفيه', 'نقل', 'أمن', 'زهور ودعوات'];

    const handleSubmit = () => {
        const dataToSave = editingBranch || newBranchData;
        if (!dataToSave.name || !dataToSave.location) {
            toast({ title: "خطأ", description: "اسم الفرع والموقع مطلوبان.", variant: "destructive" });
            return;
        }

        if (editingBranch) {
            setBranches(branches.map(b => b.id === editingBranch.id ? editingBranch : b));
            internalHandleFeatureClick(`تحديث بيانات فرع: ${editingBranch.name}`);
        } else {
            const newId = `BR-${Date.now().toString().slice(-5)}`;
            setBranches([...branches, { ...newBranchData, id: newId }]);
            internalHandleFeatureClick(`إضافة فرع جديد: ${newBranchData.name}`);
        }
        closeModal();
    };

    const openModalForEdit = (branch) => {
        setEditingBranch({ ...branch });
        setIsModalOpen(true);
        internalHandleFeatureClick(`فتح نافذة تعديل فرع: ${branch.name}`);
    };
    
    const openModalForNew = () => {
        setEditingBranch(null);
        setNewBranchData({ name: '', location: '', status: 'active', services: [], manager: '', phone: '' });
        setIsModalOpen(true);
        internalHandleFeatureClick("فتح نافذة إضافة فرع جديد");
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setEditingBranch(null);
        internalHandleFeatureClick("إغلاق نافذة إضافة/تعديل فرع");
    };

    const handleDeleteBranch = (branchId) => {
        const branchToDelete = branches.find(b => b.id === branchId);
        setBranches(branches.filter(b => b.id !== branchId));
        internalHandleFeatureClick(`حذف فرع: ${branchToDelete?.name}`);
    };
    
    const renderBranchForm = () => {
        const currentData = editingBranch || newBranchData;
        return (
            <div className="space-y-4">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <Label htmlFor="branchName">اسم الفرع/الموقع</Label>
                        <Input id="branchName" name="name" value={currentData.name} onChange={handleInputChange} placeholder="مثال: قاعة الياسمين للاحتفالات" />
                    </div>
                    <div>
                        <Label htmlFor="branchLocation">عنوان الفرع/الموقع</Label>
                        <Input id="branchLocation" name="location" value={currentData.location} onChange={handleInputChange} placeholder="مثال: الرياض، شارع العليا" />
                    </div>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <Label htmlFor="branchManager">اسم المدير المسؤول</Label>
                        <Input id="branchManager" name="manager" value={currentData.manager} onChange={handleInputChange} placeholder="مثال: عبدالله السالم" />
                    </div>
                    <div>
                        <Label htmlFor="branchPhone">رقم هاتف الفرع</Label>
                        <Input id="branchPhone" name="phone" value={currentData.phone} onChange={handleInputChange} placeholder="05xxxxxxxx" />
                    </div>
                </div>
                <div>
                    <Label>الخدمات المقدمة في هذا الفرع</Label>
                    <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 mt-2 p-3 border rounded-md">
                        {availableServices.map(service => (
                            <div key={service} className="flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    id={`service-${service}-${currentData.id || 'new'}`} 
                                    checked={(currentData.services || []).includes(service)} 
                                    onChange={(e) => handleServicesChange(service, e.target.checked)}
                                    className="form-checkbox h-4 w-4 text-primary border-slate-300 rounded focus:ring-primary"
                                />
                                <Label htmlFor={`service-${service}-${currentData.id || 'new'}`} className="text-sm">{service}</Label>
                            </div>
                        ))}
                    </div>
                </div>
                <div>
                    <Label htmlFor="branchStatus">حالة الفرع</Label>
                    <select 
                        id="branchStatus" 
                        name="status" 
                        value={currentData.status} 
                        onChange={(e) => { handleInputChange(e); internalHandleFeatureClick(`تغيير حالة الفرع إلى ${e.target.value}`); }}
                        className="w-full p-2 border border-slate-300 rounded-md focus:ring-primary focus:border-primary"
                    >
                        <option value="active">نشط</option>
                        <option value="inactive">غير نشط</option>
                        <option value="maintenance">تحت الصيانة</option>
                        <option value="soon">قريباً</option>
                    </select>
                </div>
            </div>
        );
    };


    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">إدارة الفروع والمواقع</h2>
                <Button className="gradient-bg text-white" onClick={openModalForNew}>
                    <PlusCircle className="w-5 h-5 ml-2"/> إضافة فرع جديد
                </Button>
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>قائمة الفروع والمواقع ({branches.length})</CardTitle>
                    <CardDescription>عرض وإدارة جميع فروعك ومواقع تقديم خدماتك من مكان واحد.</CardDescription>
                </CardHeader>
                <CardContent>
                    {branches.length > 0 ? (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>اسم الفرع</TableHead>
                                    <TableHead>الموقع</TableHead>
                                    <TableHead>المدير</TableHead>
                                    <TableHead>الهاتف</TableHead>
                                    <TableHead>الخدمات</TableHead>
                                    <TableHead>الحالة</TableHead>
                                    <TableHead>إجراءات</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {branches.map((branch) => (
                                    <TableRow key={branch.id}>
                                        <TableCell className="font-semibold">{branch.name}</TableCell>
                                        <TableCell>{branch.location}</TableCell>
                                        <TableCell>{branch.manager || '-'}</TableCell>
                                        <TableCell>{branch.phone || '-'}</TableCell>
                                        <TableCell className="text-xs">{(branch.services || []).join(', ') || '-'}</TableCell>
                                        <TableCell>
                                            <span className={`px-2 py-1 text-xs font-semibold rounded-full flex items-center gap-1 w-fit ${
                                                branch.status === 'active' ? 'bg-green-100 text-green-700' : 
                                                branch.status === 'inactive' ? 'bg-red-100 text-red-700' :
                                                branch.status === 'maintenance' ? 'bg-yellow-100 text-yellow-700' :
                                                'bg-slate-100 text-slate-600'
                                            }`}>
                                                {branch.status === 'active' && <CheckCircle className="w-3 h-3"/>}
                                                {branch.status === 'inactive' && <XCircle className="w-3 h-3"/>}
                                                {(branch.status === 'maintenance' || branch.status === 'soon') && <Clock className="w-3 h-3"/>}
                                                {
                                                    {active: 'نشط', inactive: 'غير نشط', maintenance: 'صيانة', soon: 'قريباً'}[branch.status]
                                                }
                                            </span>
                                        </TableCell>
                                        <TableCell className="space-x-1 space-x-reverse">
                                            <Button variant="ghost" size="icon" onClick={() => openModalForEdit(branch)}>
                                                <Edit className="w-4 h-4 text-blue-600"/>
                                            </Button>
                                            <Button variant="ghost" size="icon" onClick={() => handleDeleteBranch(branch.id)}>
                                                <Trash2 className="w-4 h-4 text-red-600"/>
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    ) : (
                        <div className="text-center py-12 text-slate-500">
                            <GitBranch className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                            <p className="text-xl font-semibold">لا توجد فروع مضافة بعد.</p>
                            <p>ابدأ بإضافة فرعك الأول لإدارة خدماتك بشكل أفضل.</p>
                        </div>
                    )}
                </CardContent>
            </Card>

            <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
                <DialogContent className="sm:max-w-[625px]" dir="rtl">
                    <DialogHeader>
                        <DialogTitle className="text-xl font-semibold mb-1">
                            {editingBranch ? 'تعديل بيانات الفرع' : 'إضافة فرع أو موقع جديد'}
                        </DialogTitle>
                        <DialogDescription>
                            {editingBranch ? 'قم بتحديث معلومات الفرع.' : 'أدخل بيانات الفرع أو الموقع الجديد لتبدأ بإدارته وربطه بخدماتك.'}
                        </DialogDescription>
                    </DialogHeader>
                    <div className="py-4 max-h-[60vh] overflow-y-auto pr-2">
                        {renderBranchForm()}
                    </div>
                    <DialogFooter className="gap-2 pt-4 border-t">
                        <Button variant="ghost" onClick={closeModal}><XCircle className="w-4 h-4 ml-2" />إلغاء</Button>
                        <Button onClick={handleSubmit} className="gradient-bg text-white">
                            {editingBranch ? <Edit className="w-4 h-4 ml-2" /> : <PlusCircle className="w-4 h-4 ml-2" />}
                            {editingBranch ? 'حفظ التعديلات' : 'إضافة الفرع'}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
});

export default BranchManagementContent;