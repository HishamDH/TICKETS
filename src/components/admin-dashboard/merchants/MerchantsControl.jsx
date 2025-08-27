import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { MoreHorizontal, Search, FileCheck, FileX, UserPlus, Edit, Eye } from 'lucide-react';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { useToast } from "@/components/ui/use-toast";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Label } from '@/components/ui/label';

const initialMerchants = [
    { id: 'merch1', name: 'قصر الأفراح الملكية', type: 'قاعة مناسبات', status: 'مفعل', joined: '2024-05-12', avatar: 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=200', email: 'royal@example.com', phone: '0501234567', crNumber: '1010123456' },
    { id: 'merch2', name: 'استوديو الإبداع للتصوير', type: 'تصوير فوتوغرافي وفيديو', status: 'مفعل', joined: '2024-08-01', avatar: 'https://images.unsplash.com/photo-1607004468138-3deaf2e7f2b8?q=80&w=200', email: 'creative@example.com', phone: '0559876543', crNumber: '1010654321' },
    { id: 'merch3', name: 'بوفيه الكرم للضيافة', type: 'إعاشة وبوفيه', status: 'طلب جديد', joined: '2025-01-20', avatar: 'https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=200', email: 'karam@example.com', phone: '0531122334', crNumber: '1010789012' },
    { id: 'merch4', name: 'زهور الربيع للتنسيق', type: 'ورود ودعوات', status: 'موقوف', joined: '2024-02-15', avatar: 'https://images.unsplash.com/photo-1530541930197-58e36e846473?q=80&w=200', email: 'spring@example.com', phone: '0548877665', crNumber: '1010234567' },
];

const statusBadges = {
    'مفعل': 'bg-emerald-100 text-emerald-800',
    'طلب جديد': 'bg-amber-100 text-amber-800',
    'موقوف': 'bg-red-100 text-red-800',
    'بانتظار المراجعة': 'bg-sky-100 text-sky-800',
};

const MerchantsControl = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [merchants, setMerchants] = useState(initialMerchants);
    const [searchTerm, setSearchTerm] = useState('');
    const [statusFilter, setStatusFilter] = useState('all');
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingMerchant, setEditingMerchant] = useState(null);
    const [newMerchantData, setNewMerchantData] = useState({ name: '', type: '', email: '', phone: '', crNumber: '', status: 'طلب جديد' });

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

    const filteredMerchants = merchants.filter(merchant => 
        (merchant.name.toLowerCase().includes(searchTerm.toLowerCase()) || merchant.email.toLowerCase().includes(searchTerm.toLowerCase())) &&
        (statusFilter === 'all' || merchant.status === statusFilter)
    );

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        if (editingMerchant) {
            setEditingMerchant(prev => ({ ...prev, [name]: value }));
        } else {
            setNewMerchantData(prev => ({ ...prev, [name]: value }));
        }
        handleFeatureClick(`تغيير حقل ${name} في نموذج مزود الخدمة`);
    };
    
    const handleSelectChange = (name, value) => {
        if (editingMerchant) {
            setEditingMerchant(prev => ({ ...prev, [name]: value }));
        } else {
            setNewMerchantData(prev => ({ ...prev, [name]: value }));
        }
        handleFeatureClick(`تغيير حقل ${name} في نموذج مزود الخدمة إلى ${value}`);
    };

    const handleSubmit = () => {
        const dataToSave = editingMerchant || newMerchantData;
        if (!dataToSave.name || !dataToSave.type || !dataToSave.email) {
            toast({ title: "خطأ", description: "الاسم، النوع، والبريد الإلكتروني مطلوبون.", variant: "destructive" });
            return;
        }

        if (editingMerchant) {
            setMerchants(merchants.map(m => m.id === editingMerchant.id ? editingMerchant : m));
            handleFeatureClick(`تحديث بيانات مزود الخدمة "${editingMerchant.name}"`);
        } else {
            const newId = `merch${Date.now()}`;
            setMerchants([...merchants, { ...newMerchantData, id: newId, joined: new Date().toISOString().split('T')[0], avatar: `https://source.unsplash.com/random/200x200?sig=${newId}` }]);
            handleFeatureClick(`إضافة مزود الخدمة "${newMerchantData.name}"`);
        }
        closeModal();
    };

    const openModalForEdit = (merchant) => {
        setEditingMerchant({ ...merchant });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة تعديل مزود الخدمة ${merchant.name}`);
    };
    
    const openModalForNew = () => {
        setEditingMerchant(null);
        setNewMerchantData({ name: '', type: '', email: '', phone: '', crNumber: '', status: 'طلب جديد' });
        setIsModalOpen(true);
        handleFeatureClick("فتح نافذة إضافة مزود خدمة جديد");
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setEditingMerchant(null);
        handleFeatureClick("إغلاق نافذة مزود الخدمة");
    };

    const handleMerchantAction = (merchantId, action) => {
        let newStatus = '';
        let message = '';
        const merchant = merchants.find(m => m.id === merchantId);
        if (!merchant) return;

        if (action === 'approve') { newStatus = 'مفعل'; message = `تفعيل حساب ${merchant.name}`; }
        else if (action === 'suspend') { newStatus = 'موقوف'; message = `إيقاف حساب ${merchant.name}`; }
        else if (action === 'review') { newStatus = 'بانتظار المراجعة'; message = `وضع حساب ${merchant.name} قيد المراجعة`; }
        
        setMerchants(prev => prev.map(m => m.id === merchantId ? {...m, status: newStatus} : m));
        handleFeatureClick(message);
    };

    const handleViewPublicPage = (merchant) => {
        handleNavigation('public-booking', { merchantId: merchant.id, merchantName: merchant.name });
    };

    const renderMerchantForm = () => {
        const currentData = editingMerchant || newMerchantData;
        return (
            <div className="space-y-4">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><Label htmlFor="merchantName">اسم مزود الخدمة</Label><Input id="merchantName" name="name" value={currentData.name} onChange={handleInputChange} /></div>
                    <div><Label htmlFor="merchantType">نوع الخدمة</Label><Input id="merchantType" name="type" value={currentData.type} onChange={handleInputChange} /></div>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><Label htmlFor="merchantEmail">البريد الإلكتروني</Label><Input id="merchantEmail" name="email" type="email" value={currentData.email} onChange={handleInputChange} /></div>
                    <div><Label htmlFor="merchantPhone">رقم الهاتف</Label><Input id="merchantPhone" name="phone" value={currentData.phone} onChange={handleInputChange} /></div>
                </div>
                <div><Label htmlFor="merchantCR">رقم السجل التجاري</Label><Input id="merchantCR" name="crNumber" value={currentData.crNumber} onChange={handleInputChange} /></div>
                <div>
                    <Label htmlFor="merchantStatus">الحالة</Label>
                    <Select dir="rtl" name="status" value={currentData.status} onValueChange={(val) => handleSelectChange('status', val)}>
                        <SelectTrigger><SelectValue /></SelectTrigger>
                        <SelectContent>
                            {Object.keys(statusBadges).map(s => <SelectItem key={s} value={s}>{s}</SelectItem>)}
                        </SelectContent>
                    </Select>
                </div>
            </div>
        );
    };

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-slate-800">إدارة مزوّدي الخدمات</h1>
                    <p className="text-slate-500 mt-1">مراجعة وتفعيل وإدارة حسابات مزوّدي خدمات المناسبات.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={openModalForNew}><UserPlus className="w-4 h-4 ml-2"/>إضافة مزوّد خدمة</Button>
            </div>

            <Card>
                <CardHeader>
                    <div className="flex justify-between items-center">
                        <CardTitle>قائمة مزوّدي الخدمات ({filteredMerchants.length})</CardTitle>
                        <div className="flex items-center gap-2">
                            <div className="relative w-64">
                                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input placeholder="بحث بالاسم أو البريد..." className="pl-10" value={searchTerm} onChange={(e) => {setSearchTerm(e.target.value); handleFeatureClick(`البحث عن مزود خدمة: ${e.target.value}`);}} />
                            </div>
                            <Select value={statusFilter} onValueChange={(val) => {setStatusFilter(val); handleFeatureClick(`فلترة مزودي الخدمات بالحالة: ${val}`)}} dir="rtl">
                                <SelectTrigger className="w-[180px]">
                                    <SelectValue placeholder="فلترة حسب الحالة" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">الكل</SelectItem>
                                    {Object.keys(statusBadges).map(s => <SelectItem key={s} value={s}>{s}</SelectItem>)}
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>مزوّد الخدمة</TableHead>
                                <TableHead>النوع</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead>تاريخ الانضمام</TableHead>
                                <TableHead className="text-left">إجراءات</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredMerchants.map((merchant) => (
                                <TableRow key={merchant.id}>
                                    <TableCell className="font-medium">{merchant.name}</TableCell>
                                    <TableCell>{merchant.type}</TableCell>
                                    <TableCell><Badge className={statusBadges[merchant.status] || 'bg-slate-100 text-slate-800'}>{merchant.status}</Badge></TableCell>
                                    <TableCell>{merchant.joined}</TableCell>
                                    <TableCell className="text-left">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger asChild>
                                                <Button variant="ghost" size="icon"><MoreHorizontal className="w-5 h-5"/></Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="start">
                                                <DropdownMenuItem onClick={() => handleViewPublicPage(merchant)}><Eye className="w-4 h-4 ml-2 text-blue-500" />عرض الصفحة العامة</DropdownMenuItem>
                                                <DropdownMenuItem onClick={() => openModalForEdit(merchant)}><Edit className="w-4 h-4 ml-2"/>تعديل البيانات</DropdownMenuItem>
                                                {merchant.status === 'طلب جديد' && <DropdownMenuItem onClick={() => handleMerchantAction(merchant.id, 'approve')}><FileCheck className="w-4 h-4 ml-2 text-green-500"/>موافقة وتفعيل</DropdownMenuItem>}
                                                {merchant.status === 'مفعل' && <DropdownMenuItem className="text-red-500" onClick={() => handleMerchantAction(merchant.id, 'suspend')}><FileX className="w-4 h-4 ml-2"/>إيقاف الحساب</DropdownMenuItem>}
                                                {merchant.status === 'موقوف' && <DropdownMenuItem onClick={() => handleMerchantAction(merchant.id, 'approve')}><FileCheck className="w-4 h-4 ml-2 text-green-500"/>إعادة تفعيل</DropdownMenuItem>}
                                                <DropdownMenuItem onClick={() => handleMerchantAction(merchant.id, 'review')}><Eye className="w-4 h-4 ml-2"/>وضع قيد المراجعة</DropdownMenuItem>
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
                <DialogContent dir="rtl">
                    <DialogHeader>
                        <DialogTitle>{editingMerchant ? 'تعديل مزود خدمة' : 'إضافة مزود خدمة جديد'}</DialogTitle>
                        <DialogDescription>
                            {editingMerchant ? `تعديل بيانات ${editingMerchant.name}` : 'أدخل بيانات مزود الخدمة الجديد.'}
                        </DialogDescription>
                    </DialogHeader>
                    <div className="py-4">{renderMerchantForm()}</div>
                    <DialogFooter className="gap-2">
                        <Button variant="ghost" onClick={closeModal}>إلغاء</Button>
                        <Button onClick={handleSubmit}>{editingMerchant ? 'حفظ التعديلات' : 'إضافة مزود الخدمة'}</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
};

export default React.memo(MerchantsControl);