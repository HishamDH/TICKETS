import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { Globe, Link, PlusCircle, Edit, Trash2, RefreshCw } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const statusBadges = {
    'مفعل': 'bg-emerald-100 text-emerald-800',
    'بانتظار الربط': 'bg-amber-100 text-amber-800',
    'معطل': 'bg-red-100 text-red-800',
};

const sslBadges = {
    'صالح': 'bg-green-100 text-green-800',
    'معلق': 'bg-yellow-100 text-yellow-800',
    'منتهي': 'bg-red-100 text-red-800',
};

const DomainManagement = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [domains, setDomains] = useState([]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingDomain, setEditingDomain] = useState(null);
    const [newDomainData, setNewDomainData] = useState({ domain: '', merchant: '', status: 'بانتظار الربط', ssl: 'معلق' });

    useEffect(() => {
        const savedDomains = localStorage.getItem('lilium_domains_admin');
        if (savedDomains) {
            setDomains(JSON.parse(savedDomains));
        } else {
            setDomains([
                { id: 'dom1', domain: 'qasr-alafrah.liliumnight.com', merchant: 'قصر الأفراح الملكية', status: 'مفعل', ssl: 'صالح' },
                { id: 'dom2', domain: 'studio-alibdaa.liliumnight.com', merchant: 'استوديو الإبداع للتصوير', status: 'مفعل', ssl: 'صالح' },
                { id: 'dom3', domain: 'buffet-alkaram.liliumnight.com', merchant: 'بوفيه الكرم للضيافة', status: 'بانتظار الربط', ssl: 'معلق' },
            ]);
        }
    }, []);

    useEffect(() => {
        localStorage.setItem('lilium_domains_admin', JSON.stringify(domains));
    }, [domains]);

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

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        if (editingDomain) {
            setEditingDomain(prev => ({ ...prev, [name]: value }));
        } else {
            setNewDomainData(prev => ({ ...prev, [name]: value }));
        }
    };

    const handleSelectChange = (name, value) => {
        if (editingDomain) {
            setEditingDomain(prev => ({ ...prev, [name]: value }));
        } else {
            setNewDomainData(prev => ({ ...prev, [name]: value }));
        }
    };

    const handleSubmit = () => {
        const dataToSave = editingDomain || newDomainData;
        if (!dataToSave.domain || !dataToSave.merchant) {
            toast({ title: "خطأ", description: "النطاق واسم التاجر مطلوبان.", variant: "destructive" });
            return;
        }

        if (editingDomain) {
            setDomains(domains.map(d => d.id === editingDomain.id ? editingDomain : d));
            handleFeatureClick(`تحديث نطاق "${editingDomain.domain}"`);
        } else {
            const newId = `dom${Date.now()}`;
            setDomains([...domains, { ...newDomainData, id: newId }]);
            handleFeatureClick(`إضافة نطاق "${newDomainData.domain}"`);
        }
        closeModal();
    };

    const openModalForEdit = (domain) => {
        setEditingDomain({ ...domain });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة تعديل النطاق ${domain.domain}`);
    };
    
    const openModalForNew = () => {
        setEditingDomain(null);
        setNewDomainData({ domain: '', merchant: '', status: 'بانتظار الربط', ssl: 'معلق' });
        setIsModalOpen(true);
        handleFeatureClick("فتح نافذة إضافة نطاق جديد");
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setEditingDomain(null);
    };

    const handleDeleteDomain = (domainId) => {
        const domainToDelete = domains.find(d => d.id === domainId);
        setDomains(domains.filter(d => d.id !== domainId));
        handleFeatureClick(`حذف النطاق ${domainToDelete?.domain}`);
    };

    const handleRefreshStatus = (domainId) => {
        const domainToRefresh = domains.find(d => d.id === domainId);
        setDomains(prevDomains => prevDomains.map(d => {
            if (d.id === domainId) {
                return { ...d, status: Math.random() > 0.5 ? 'مفعل' : 'بانتظار الربط', ssl: Math.random() > 0.3 ? 'صالح' : 'معلق' };
            }
            return d;
        }));
        handleFeatureClick(`تحديث حالة النطاق ${domainToRefresh?.domain}`);
    };

    const renderDomainForm = () => {
        const currentData = editingDomain || newDomainData;
        return (
            <div className="space-y-4">
                <div>
                    <Label htmlFor="domainName">النطاق (مثال: merchant.liliumnight.com)</Label>
                    <Input id="domainName" name="domain" value={currentData.domain} onChange={handleInputChange} />
                </div>
                <div>
                    <Label htmlFor="merchantName">اسم مزوّد الخدمة</Label>
                    <Input id="merchantName" name="merchant" value={currentData.merchant} onChange={handleInputChange} />
                </div>
                <div>
                    <Label htmlFor="domainStatus">حالة الربط</Label>
                    <Select dir="rtl" id="domainStatus" name="status" value={currentData.status} onValueChange={(val) => handleSelectChange('status', val)}>
                        <SelectTrigger><SelectValue /></SelectTrigger>
                        <SelectContent>
                            <SelectItem value="مفعل">مفعل</SelectItem>
                            <SelectItem value="بانتظار الربط">بانتظار الربط</SelectItem>
                            <SelectItem value="معطل">معطل</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
                <div>
                    <Label htmlFor="sslStatus">حالة شهادة SSL</Label>
                    <Select dir="rtl" id="sslStatus" name="ssl" value={currentData.ssl} onValueChange={(val) => handleSelectChange('ssl', val)}>
                        <SelectTrigger><SelectValue /></SelectTrigger>
                        <SelectContent>
                            <SelectItem value="صالح">صالح</SelectItem>
                            <SelectItem value="معلق">معلق</SelectItem>
                            <SelectItem value="منتهي">منتهي</SelectItem>
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
                    <h1 className="text-3xl font-bold text-slate-800">إدارة النطاقات المخصصة</h1>
                    <p className="text-slate-500 mt-1">مراقبة وإدارة النطاقات الفرعية المخصصة لمزوّدي الخدمات.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={openModalForNew}><PlusCircle className="w-4 h-4 ml-2"/>إضافة نطاق</Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>النطاقات المربوطة ({domains.length})</CardTitle>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>النطاق</TableHead>
                                <TableHead>مزوّد الخدمة</TableHead>
                                <TableHead>حالة الربط</TableHead>
                                <TableHead>شهادة SSL</TableHead>
                                <TableHead className="text-left">إجراء</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {domains.map((d) => (
                                <TableRow key={d.id}>
                                    <TableCell className="font-medium">{d.domain}</TableCell>
                                    <TableCell>{d.merchant}</TableCell>
                                    <TableCell><Badge className={statusBadges[d.status] || 'bg-slate-100 text-slate-800'}>{d.status}</Badge></TableCell>
                                    <TableCell><Badge className={sslBadges[d.ssl] || 'bg-slate-100 text-slate-800'}>{d.ssl}</Badge></TableCell>
                                    <TableCell className="text-left space-x-1 space-x-reverse">
                                        <Button variant="ghost" size="icon" onClick={() => handleRefreshStatus(d.id)} title="تحديث الحالة"><RefreshCw className="w-4 h-4 text-blue-500"/></Button>
                                        <Button variant="ghost" size="icon" onClick={() => openModalForEdit(d)} title="تعديل"><Edit className="w-4 h-4 text-slate-600"/></Button>
                                        <Button variant="ghost" size="icon" onClick={() => handleDeleteDomain(d.id)} title="حذف"><Trash2 className="w-4 h-4 text-red-500"/></Button>
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
                        <DialogTitle>{editingDomain ? 'تعديل النطاق' : 'إضافة نطاق جديد'}</DialogTitle>
                        <DialogDescription>
                            {editingDomain ? `تعديل بيانات النطاق ${editingDomain.domain}` : 'أدخل بيانات النطاق الجديد.'}
                        </DialogDescription>
                    </DialogHeader>
                    <div className="py-4">{renderDomainForm()}</div>
                    <DialogFooter className="gap-2">
                        <Button variant="ghost" onClick={closeModal}>إلغاء</Button>
                        <Button onClick={handleSubmit}>{editingDomain ? 'حفظ التعديلات' : 'إضافة النطاق'}</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
};

export default React.memo(DomainManagement);