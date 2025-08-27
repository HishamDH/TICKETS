import React, { useState, useEffect, memo } from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Banknote, History, PlusCircle, Download, Filter } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { format } from 'date-fns';
import { ar } from 'date-fns/locale';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from "@/components/ui/dialog";
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const initialWithdrawals = [
    { id: 'WDR-001', amount: 5000, date: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000).toISOString(), status: 'مكتملة', method: 'تحويل بنكي (الأهلي SAXX...XX1234)' },
    { id: 'WDR-002', amount: 2500, date: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toISOString(), status: 'مكتملة', method: 'تحويل بنكي (الأهلي SAXX...XX1234)' },
];

const WalletContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [walletData, setWalletData] = useState(JSON.parse(localStorage.getItem('lilium_night_wallet_v1')) || {
        currentBalance: 15300.50,
        pendingBalance: 3150.75,
        platformFee: 3, // Percentage
        withdrawals: initialWithdrawals,
    });
    const [isWithdrawModalOpen, setIsWithdrawModalOpen] = useState(false);
    const [withdrawAmount, setWithdrawAmount] = useState('');

    useEffect(() => {
        localStorage.setItem('lilium_night_wallet_v1', JSON.stringify(walletData));
    }, [walletData]);
    
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
    
    const handleRequestWithdrawal = () => {
        if (!withdrawAmount || parseFloat(withdrawAmount) <= 0) {
            toast({ title: "خطأ", description: "الرجاء إدخال مبلغ سحب صحيح.", variant: "destructive" });
            return;
        }
        if (parseFloat(withdrawAmount) > walletData.currentBalance) {
            toast({ title: "خطأ", description: "مبلغ السحب يتجاوز الرصيد المتاح.", variant: "destructive" });
            return;
        }
        
        const newWithdrawal = {
            id: `WDR-${Date.now().toString().slice(-5)}`,
            amount: parseFloat(withdrawAmount),
            date: new Date().toISOString(),
            status: 'قيد المعالجة',
            method: 'تحويل بنكي (الأهلي SAXX...XX1234)' 
        };
        setWalletData(prev => ({
            ...prev,
            currentBalance: prev.currentBalance - parseFloat(withdrawAmount),
            pendingBalance: prev.pendingBalance + parseFloat(withdrawAmount),
            withdrawals: [newWithdrawal, ...prev.withdrawals]
        }));
        setWithdrawAmount('');
        setIsWithdrawModalOpen(false);
        handleFeatureClick(`طلب سحب بمبلغ ${withdrawAmount} ريال`);
    };

    const getStatusColor = (status) => {
        if (status === 'مكتملة') return 'text-green-600 bg-green-100';
        if (status === 'قيد المعالجة') return 'text-yellow-600 bg-yellow-100';
        if (status === 'مرفوضة') return 'text-red-600 bg-red-100';
        return 'text-slate-600 bg-slate-100';
    };

    return (
    <>
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">المحفظة المالية والسحب</h2>
            <div className="grid md:grid-cols-3 gap-6">
                <Card className="shadow-lg hover:shadow-xl transition-shadow">
                    <CardHeader><CardTitle>الرصيد المتاح للسحب</CardTitle></CardHeader>
                    <CardContent className="text-4xl font-bold text-green-600">{walletData.currentBalance.toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'})}</CardContent>
                </Card>
                <Card className="shadow-lg hover:shadow-xl transition-shadow">
                    <CardHeader><CardTitle>الرصيد المعلق (قيد التصفية)</CardTitle></CardHeader>
                    <CardContent className="text-3xl font-bold text-amber-600">{walletData.pendingBalance.toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'})}</CardContent>
                </Card>
                <Card className="shadow-lg hover:shadow-xl transition-shadow">
                    <CardHeader><CardTitle>عمولة المنصة على المبيعات</CardTitle></CardHeader>
                    <CardContent className="text-3xl font-bold text-slate-700">{walletData.platformFee}%</CardContent>
                </Card>
            </div>
            <Card className="shadow-lg">
                <CardHeader className="flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <CardTitle className="flex items-center gap-2"><History className="w-5 h-5 text-primary"/>سجل عمليات السحب</CardTitle>
                        <CardDescription>تابع جميع عمليات السحب التي قمت بها من محفظتك في ليلة الليليوم.</CardDescription>
                    </div>
                    <div className="flex gap-2">
                        <Button variant="outline" onClick={() => handleFeatureClick("فلترة سجل السحوبات")}><Filter className="w-4 h-4 ml-2"/>فلترة</Button>
                        <Button variant="outline" onClick={() => handleFeatureClick("تصدير سجل السحوبات")}><Download className="w-4 h-4 ml-2"/>تصدير</Button>
                         <Button className="gradient-bg text-white" onClick={() => setIsWithdrawModalOpen(true)}><Banknote className="w-4 h-4 ml-2"/>طلب سحب جديد</Button>
                    </div>
                </CardHeader>
                <CardContent>
                    {walletData.withdrawals.length > 0 ? (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>رقم العملية</TableHead>
                                    <TableHead>المبلغ</TableHead>
                                    <TableHead>التاريخ</TableHead>
                                    <TableHead>الحالة</TableHead>
                                    <TableHead>وسيلة السحب</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {walletData.withdrawals.map((w) => (
                                    <TableRow key={w.id}>
                                        <TableCell className="font-mono">{w.id}</TableCell>
                                        <TableCell>{w.amount.toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'})}</TableCell>
                                        <TableCell>{format(new Date(w.date), 'PPP p', { locale: ar })}</TableCell>
                                        <TableCell>
                                            <span className={`px-2 py-1 text-xs font-semibold rounded-full ${getStatusColor(w.status)}`}>
                                                {w.status}
                                            </span>
                                        </TableCell>
                                        <TableCell className="text-xs">{w.method}</TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    ) : (
                        <p className="text-slate-500 p-6 text-center">لا توجد عمليات سحب سابقة لعرضها.</p>
                    )}
                </CardContent>
            </Card>
        </div>
        <Dialog open={isWithdrawModalOpen} onOpenChange={setIsWithdrawModalOpen} dir="rtl">
            <DialogContent className="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>طلب سحب جديد</DialogTitle>
                    <DialogDescription>
                        أدخل المبلغ الذي ترغب بسحبه من رصيدك المتاح. سيتم تحويل المبلغ إلى حسابك البنكي المسجل.
                        <br/>
                        الرصيد المتاح حالياً: <strong className="text-green-600">{walletData.currentBalance.toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'})}</strong>
                    </DialogDescription>
                </DialogHeader>
                <div className="py-4 space-y-4">
                    <div>
                        <Label htmlFor="withdrawAmount">المبلغ المطلوب (ريال)</Label>
                        <Input 
                            id="withdrawAmount" 
                            type="number" 
                            value={withdrawAmount} 
                            onChange={(e) => setWithdrawAmount(e.target.value)}
                            placeholder="مثال: 5000"
                        />
                    </div>
                    <p className="text-xs text-slate-500">سيتم خصم رسوم تحويل (إن وجدت) من المبلغ المسحوب. قد تستغرق العملية حتى 3 أيام عمل.</p>
                </div>
                <DialogFooter className="gap-2">
                    <Button variant="ghost" onClick={() => setIsWithdrawModalOpen(false)}>إلغاء</Button>
                    <Button onClick={handleRequestWithdrawal} className="gradient-bg text-white">تأكيد طلب السحب</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </>
    );
});

export default WalletContent;