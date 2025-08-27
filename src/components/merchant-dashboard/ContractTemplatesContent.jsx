import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from "@/components/ui/dialog";
import { Textarea } from '@/components/ui/textarea';
import { PlusCircle, Edit, Trash2, Edit3, Eye } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { format } from "date-fns";
import { ar } from "date-fns/locale";

const ContractTemplatesContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [templates, setTemplates] = useState(JSON.parse(localStorage.getItem('lilium_night_contract_templates_v1')) || [
        { id: 'TPL-001', name: 'عقد تأجير قاعة زفاف', lastUpdated: new Date().toISOString(), content: 'هذا عقد لتأجير قاعة زفاف بتاريخ {{event_date}}...' },
        { id: 'TPL-002', name: 'عقد خدمة تصوير فوتوغرافي', lastUpdated: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000).toISOString(), content: 'عقد لتقديم خدمات التصوير لـ {{customer_name}}...' },
    ]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingTemplate, setEditingTemplate] = useState(null);
    const [newTemplateData, setNewTemplateData] = useState({ name: '', content: '' });

    useEffect(() => {
        localStorage.setItem('lilium_night_contract_templates_v1', JSON.stringify(templates));
    }, [templates]);

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
        const targetData = editingTemplate ? editingTemplate : newTemplateData;
        const setTargetData = editingTemplate ? setEditingTemplate : setNewTemplateData;
        setTargetData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = () => {
        const dataToSave = editingTemplate || newTemplateData;
        if (!dataToSave.name || !dataToSave.content) {
            toast({ title: "خطأ", description: "اسم القالب والمحتوى مطلوبان.", variant: "destructive" });
            return;
        }

        if (editingTemplate) {
            setTemplates(templates.map(t => t.id === editingTemplate.id ? { ...editingTemplate, lastUpdated: new Date().toISOString() } : t));
            handleFeatureClick(`تحديث قالب العقد: ${editingTemplate.name}`);
        } else {
            const newId = `TPL-${Date.now().toString().slice(-5)}`;
            setTemplates([...templates, { ...newTemplateData, id: newId, lastUpdated: new Date().toISOString() }]);
            handleFeatureClick(`إنشاء قالب عقد جديد: ${newTemplateData.name}`);
        }
        closeModal();
    };

    const openModalForEdit = (template) => {
        setEditingTemplate({ ...template });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة تعديل قالب: ${template.name}`);
    };
    
    const openModalForNew = () => {
        setEditingTemplate(null);
        setNewTemplateData({ name: '', content: '' });
        setIsModalOpen(true);
        handleFeatureClick("فتح نافذة إنشاء قالب جديد");
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setEditingTemplate(null);
    };

    const handleDeleteTemplate = (templateId) => {
        const templateToDelete = templates.find(t => t.id === templateId);
        setTemplates(templates.filter(t => t.id !== templateId));
        handleFeatureClick(`حذف قالب العقد: ${templateToDelete?.name}`);
    };

    const renderTemplateForm = () => {
        const currentData = editingTemplate || newTemplateData;
        return (
            <div className="space-y-4">
                <div>
                    <Label htmlFor="templateName">اسم القالب (داخلي، لك فقط)</Label>
                    <Input id="templateName" name="name" value={currentData.name} onChange={handleInputChange} placeholder="مثال: عقد تأجير قاعة" />
                </div>
                <div>
                    <Label htmlFor="templateContent">محتوى القالب</Label>
                    <Textarea id="templateContent" name="content" value={currentData.content} onChange={handleInputChange} placeholder="اكتب محتوى العقد هنا. يمكنك استخدام متغيرات مثل {{customer_name}} و {{event_date}}." className="min-h-[200px]" />
                    <p className="text-xs text-slate-500 mt-1">المتغيرات المتاحة: {"{{customer_name}}, {{event_date}}, {{service_name}}, {{total_amount}}"}</p>
                </div>
            </div>
        );
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">قوالب العقود المخصصة</h2>
                <Button className="gradient-bg text-white" onClick={openModalForNew}>
                    <PlusCircle className="w-5 h-5 ml-2"/> إنشاء قالب جديد
                </Button>
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>قوالب العقود ({templates.length})</CardTitle>
                    <CardDescription>إدارة قوالب العقود التي يتم إنشاؤها تلقائياً للحجوزات الجديدة.</CardDescription>
                </CardHeader>
                <CardContent>
                    {templates.length > 0 ? (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>اسم القالب</TableHead>
                                    <TableHead>آخر تحديث</TableHead>
                                    <TableHead>إجراءات</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {templates.map((template) => (
                                    <TableRow key={template.id}>
                                        <TableCell className="font-semibold">{template.name}</TableCell>
                                        <TableCell>{format(new Date(template.lastUpdated), 'PPP p', { locale: ar })}</TableCell>
                                        <TableCell className="space-x-1 space-x-reverse">
                                            <Button variant="ghost" size="icon" onClick={() => openModalForEdit(template)}><Edit3 className="w-4 h-4 text-blue-600"/></Button>
                                            <Button variant="ghost" size="icon" onClick={() => handleDeleteTemplate(template.id)}><Trash2 className="w-4 h-4 text-red-600"/></Button>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    ) : (
                        <div className="text-center py-12 text-slate-500">
                            <Edit3 className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                            <p className="text-xl font-semibold">لا توجد قوالب عقود مضافة بعد.</p>
                            <p>ابدأ بإنشاء قالب جديد لتسهيل عملية التعاقد.</p>
                        </div>
                    )}
                </CardContent>
            </Card>

            <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
                <DialogContent className="sm:max-w-[625px]" dir="rtl">
                    <DialogHeader>
                        <DialogTitle>{editingTemplate ? 'تعديل قالب العقد' : 'إنشاء قالب عقد جديد'}</DialogTitle>
                        <DialogDescription>
                           {editingTemplate ? 'قم بتحديث تفاصيل القالب.' : 'أدخل تفاصيل القالب الجديد.'}
                        </DialogDescription>
                    </DialogHeader>
                    <div className="py-4">{renderTemplateForm()}</div>
                    <DialogFooter className="gap-2">
                        <Button variant="ghost" onClick={closeModal}>إلغاء</Button>
                        <Button onClick={handleSubmit} className="gradient-bg text-white">
                            {editingTemplate ? 'حفظ التعديلات' : 'إنشاء القالب'}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
});

export default ContractTemplatesContent;