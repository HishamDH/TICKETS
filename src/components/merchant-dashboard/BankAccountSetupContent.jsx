import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { PlusCircle, Edit, Trash2, Banknote, CheckCircle, Shield } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from "@/components/ui/dialog";
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const saudiBanks = [
    "البنك الأهلي السعودي", "بنك الرياض", "مصرف الراجحي", "البنك السعودي الفرنسي", "بنك ساب", 
    "البنك العربي الوطني", "بنك البلاد", "بنك الجزيرة", "مصرف الإنماء", "البنك السعودي للاستثمار"
];

const BankAccountSetupContent = ({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [accounts, setAccounts] = useState([]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingAccount, setEditingAccount] = useState(null);
    const [newAccountData, setNewAccountData] = useState({ bankName: '', holderName: '', iban: '' });

    useEffect(() => {
        const savedAccounts = localStorage.getItem('lilium_merchant_bank_accounts_v1');
        if (savedAccounts) {
            setAccounts(JSON.parse(savedAccounts));
        } else {
            setAccounts([
                { id: 'acc1', bankName: 'البنك الأهلي السعودي', holderName: 'مؤسسة قاعة الأفراح الملكية', iban: 'SA...XXXX', isPrimary: true },
            ]);
        }
    }, []);

    useEffect(() => {
        localStorage.setItem('lilium_merchant_bank_accounts_v1', JSON.stringify(accounts));
    }, [accounts]);

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
        const targetData = editingAccount ? editingAccount : newAccountData;
        const setTargetData = editingAccount ? setEditingAccount : setNewAccountData;
        setTargetData(prev => ({ ...prev, [name]: value }));
    };

    const handleSelectChange = (name, value) => {
        const targetData = editingAccount ? editingAccount : newAccountData;
        const setTargetData = editingAccount ? setEditingAccount : setNewAccountData;
        setTargetData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = () => {
        const dataToSave = editingAccount || newAccountData;
        if (!dataToSave.bankName || !dataToSave.holderName || !dataToSave.iban) {
            toast({ title: "خطأ", description: "جميع الحقول مطلوبة.", variant: "destructive" });
            return;
        }
        if (!dataToSave.iban.startsWith('SA') || dataToSave.iban.length < 10) {
            toast({ title: "خطأ", description: "الرجاء إدخال رقم آيبان صحيح يبدأ بـ SA.", variant: "destructive" });
            return;
        }

        if (editingAccount) {
            setAccounts(accounts.map(acc => acc.id === editingAccount.id ? editingAccount : acc));
            handleFeatureClick(`تحديث الحساب البنكي: ${editingAccount.bankName}`);
        } else {
            const newId = `acc${Date.now()}`;
            const newAccountWithId = { ...newAccountData, id: newId, isPrimary: accounts.length === 0 };
            setAccounts([...accounts, newAccountWithId]);
            handleFeatureClick(`إضافة حساب بنكي جديد: ${newAccountData.bankName}`);
        }
        closeModal();
    };

    const openModalForEdit = (account) => {
        setEditingAccount({ ...account });
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة تعديل الحساب البنكي: ${account.bankName}`);
    };

    const openModalForNew = () => {
        setEditingAccount(null);
        setNewAccountData({ bankName: '', holderName: '', iban: '' });
        setIsModalOpen(true);
        handleFeatureClick("فتح نافذة إضافة حساب بنكي جديد");
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setEditingAccount(null);
    };

    const handleDeleteAccount = (accountId) => {
        const accountToDelete = accounts.find(acc => acc.id === accountId);
        if (accountToDelete.isPrimary && accounts.length > 1) {
            toast({ title: "تنبيه", description: "لا يمكن حذف الحساب الأساسي. يرجى تحديد حساب آخر كأساسي أولاً.", variant: "destructive" });
            return;
        }
        setAccounts(accounts.filter(acc => acc.id !== accountId));
        handleFeatureClick(`حذف الحساب البنكي: ${accountToDelete?.bankName}`);
    };

    const setPrimaryAccount = (accountId) => {
        setAccounts(accounts.map(acc => ({ ...acc, isPrimary: acc.id === accountId })));
        const primaryAcc = accounts.find(acc => acc.id === accountId);
        handleFeatureClick(`تحديد حساب ${primaryAcc?.bankName} كأساسي`);
    };

    const renderAccountForm = () => {
        const currentData = editingAccount || newAccountData;
        return (
            <div className="space-y-4">
                <div>
                    <Label htmlFor="bankName">اسم البنك</Label>
                    <Select dir="rtl" name="bankName" value={currentData.bankName} onValueChange={(val) => handleSelectChange('bankName', val)}>
                        <SelectTrigger><SelectValue placeholder="اختر البنك" /></SelectTrigger>
                        <SelectContent>
                            {saudiBanks.map(bank => <SelectItem key={bank} value={bank}>{bank}</SelectItem>)}
                        </SelectContent>
                    </Select>
                </div>
                <div>
                    <Label htmlFor="holderName">اسم صاحب الحساب (مطابق للمستندات الرسمية)</Label>
                    <Input id="holderName" name="holderName" value={currentData.holderName} onChange={handleInputChange} />
                </div>
                <div>
                    <Label htmlFor="iban">رقم الآيبان (IBAN)</Label>
                    <Input id="iban" name="iban" value={currentData.iban} onChange={handleInputChange} placeholder="SAXXXXXXXXXXXXXXXXXXXXXX" />
                </div>
            </div>
        );
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <div>
                    <h2 className="text-3xl font-bold text-slate-800">إعدادات الحسابات البنكية</h2>
                    <p className="text-slate-500 mt-1">إدارة الحسابات البنكية التي سيتم تحويل مستحقاتك المالية إليها.</p>
                </div>
                <Button className="gradient-bg text-white" onClick={openModalForNew}><PlusCircle className="w-4 h-4 ml-2"/>إضافة حساب بنكي</Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>الحسابات البنكية المربوطة ({accounts.length})</CardTitle>
                    <CardDescription>هذه هي الحسابات التي يمكنك استخدامها لسحب رصيدك من المنصة.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>اسم البنك</TableHead>
                                <TableHead>اسم صاحب الحساب</TableHead>
                                <TableHead>رقم الآيبان</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead className="text-left">إجراءات</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {accounts.map((acc) => (
                                <TableRow key={acc.id}>
                                    <TableCell className="font-medium">{acc.bankName}</TableCell>
                                    <TableCell>{acc.holderName}</TableCell>
                                    <TableCell className="font-mono text-sm">{acc.iban}</TableCell>
                                    <TableCell>
                                        {acc.isPrimary && <Badge className="bg-green-100 text-green-700"><CheckCircle className="w-3 h-3 ml-1"/>أساسي</Badge>}
                                    </TableCell>
                                    <TableCell className="text-left space-x-1 space-x-reverse">
                                        {!acc.isPrimary && <Button variant="outline" size="sm" onClick={() => setPrimaryAccount(acc.id)}>جعله أساسياً</Button>}
                                        <Button variant="ghost" size="icon" onClick={() => openModalForEdit(acc)} title="تعديل"><Edit className="w-4 h-4 text-slate-600"/></Button>
                                        <Button variant="ghost" size="icon" onClick={() => handleDeleteAccount(acc.id)} title="حذف"><Trash2 className="w-4 h-4 text-red-500"/></Button>
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
                        <DialogTitle>{editingAccount ? 'تعديل الحساب البنكي' : 'إضافة حساب بنكي جديد'}</DialogTitle>
                        <DialogDescription>
                            {editingAccount ? `تعديل بيانات حساب ${editingAccount.bankName}` : 'أدخل بيانات الحساب البنكي الجديد.'}
                        </DialogDescription>
                    </DialogHeader>
                    <div className="py-4">{renderAccountForm()}</div>
                    <DialogFooter className="gap-2">
                        <Button variant="ghost" onClick={closeModal}>إلغاء</Button>
                        <Button onClick={handleSubmit}>{editingAccount ? 'حفظ التعديلات' : 'إضافة الحساب'}</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
};

export default BankAccountSetupContent;