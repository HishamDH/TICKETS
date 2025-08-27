import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { Download, Filter, Search, CreditCard, PlusCircle } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Label } from '@/components/ui/label';
import { format, parseISO } from 'date-fns';
import { ar } from 'date-fns/locale';

const initialPaymentsData = [
    { id: 'pay1', bookingId: '#حجز1234', amount: '15,000 ريال', method: 'Visa **** 1234', date: '2025-06-15', status: 'مكتمل', type: 'payment' },
    { id: 'pay2', bookingId: '#حجز1235', amount: '2,500 ريال', method: 'Apple Pay', date: '2025-06-10', status: 'مكتمل', type: 'payment' },
    { id: 'pay3', bookingId: '#حجز1236', amount: '8,000 ريال', method: 'Visa **** 1234', date: '2025-05-20', status: 'مسترد', type: 'refund' },
    { id: 'pay4', bookingId: '#حجز1237', amount: '500 ريال', method: 'STC Pay', date: '2025-05-15', status: 'مكتمل', type: 'payment' },
];

const initialPaymentMethodsData = [
    { id: 'pm1', type: 'Visa', last4: '1234', expiry: '12/26', isDefault: true },
    { id: 'pm2', type: 'Mastercard', last4: '5678', expiry: '08/25', isDefault: false },
];

const PaymentHistory = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [payments, setPayments] = useState(() => {
        const savedPayments = localStorage.getItem('lilium_customer_payments_v1');
        return savedPayments ? JSON.parse(savedPayments) : initialPaymentsData;
    });
    const [methods, setMethods] = useState(() => {
        const savedMethods = localStorage.getItem('lilium_customer_payment_methods_v1');
        return savedMethods ? JSON.parse(savedMethods) : initialPaymentMethodsData;
    });

    const [searchTerm, setSearchTerm] = useState('');
    const [statusFilter, setStatusFilter] = useState('all');
    const [isAddMethodModalOpen, setIsAddMethodModalOpen] = useState(false);
    const [newMethodData, setNewMethodData] = useState({ type: 'Visa', cardNumber: '', expiry: '', cvv: '' });

    useEffect(() => {
        localStorage.setItem('lilium_customer_payments_v1', JSON.stringify(payments));
    }, [payments]);

    useEffect(() => {
        localStorage.setItem('lilium_customer_payment_methods_v1', JSON.stringify(methods));
    }, [methods]);

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


    const filteredPayments = payments.filter(p => 
        (p.bookingId.toLowerCase().includes(searchTerm.toLowerCase()) || p.method.toLowerCase().includes(searchTerm.toLowerCase())) &&
        (statusFilter === 'all' || p.status === statusFilter)
    );

    const handleAddMethod = () => {
        if(!newMethodData.cardNumber || !newMethodData.expiry || !newMethodData.cvv) {
            toast({title: "خطأ", description: "يرجى ملء جميع حقول البطاقة.", variant: "destructive"});
            return;
        }
        const newId = `pm${Date.now()}`;
        setMethods(prev => [...prev, {id: newId, type: newMethodData.type, last4: newMethodData.cardNumber.slice(-4), expiry: newMethodData.expiry, isDefault: false}]);
        toast({title: "تم إضافة البطاقة", description: `تم إضافة بطاقة ${newMethodData.type} بنجاح.`});
        handleFeatureClick(`إضافة بطاقة ${newMethodData.type}`);
        setIsAddMethodModalOpen(false);
        setNewMethodData({ type: 'Visa', cardNumber: '', expiry: '', cvv: '' });
    };
    
    const handleSetDefaultMethod = (methodId) => {
        setMethods(prev => prev.map(m => ({...m, isDefault: m.id === methodId})));
        toast({title: "تم تحديث البطاقة الافتراضية"});
        const methodType = methods.find(m => m.id === methodId)?.type || 'البطاقة';
        handleFeatureClick(`تعيين ${methodType} كافتراضية`);
    };

    const handleDeleteMethod = (methodId) => {
        setMethods(prev => prev.filter(m => m.id !== methodId));
        toast({title: "تم حذف البطاقة", variant: "destructive"});
        const methodType = methods.find(m => m.id === methodId)?.type || 'البطاقة';
        handleFeatureClick(`حذف ${methodType}`);
    };

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">السجل المالي وطرق الدفع</h1>
                <p className="text-slate-500 mt-1">جميع عمليات الدفع والاسترداد الخاصة بحجوزات مناسباتك، وإدارة طرق الدفع المحفوظة.</p>
            </div>
            <Card>
                <CardHeader className="flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                    <CardTitle>سجل العمليات</CardTitle>
                    <div className="flex flex-wrap gap-2 w-full md:w-auto">
                        <div className="relative flex-grow md:flex-grow-0">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                            <Input placeholder="بحث برقم الحجز أو الوسيلة..." className="pl-10 w-full" value={searchTerm} onChange={(e) => setSearchTerm(e.target.value)} />
                        </div>
                        <Select value={statusFilter} onValueChange={(val) => {setStatusFilter(val); handleFeatureClick(`فلترة السجل المالي بـ ${val}`) }}>
                            <SelectTrigger className="w-full md:w-[150px]"><SelectValue /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">كل الحالات</SelectItem>
                                <SelectItem value="مكتمل">مكتمل</SelectItem>
                                <SelectItem value="مسترد">مسترد</SelectItem>
                                <SelectItem value="معلق">معلق</SelectItem>
                            </SelectContent>
                        </Select>
                        <Button variant="outline" onClick={() => handleFeatureClick("تصدير سجل العمليات")}><Download className="w-4 h-4 ml-2"/>تصدير</Button>
                    </div>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>رقم الحجز</TableHead>
                                <TableHead>المبلغ</TableHead>
                                <TableHead>وسيلة الدفع</TableHead>
                                <TableHead>التاريخ</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead className="text-left">الفاتورة</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredPayments.map((payment) => (
                                <TableRow key={payment.id}>
                                    <TableCell className="font-medium">{payment.bookingId}</TableCell>
                                    <TableCell>{payment.amount}</TableCell>
                                    <TableCell>{payment.method}</TableCell>
                                    <TableCell>{format(parseISO(payment.date), 'PPP', { locale: ar })}</TableCell>
                                    <TableCell><Badge variant={payment.status === 'مسترد' ? 'destructive' : (payment.status === 'مكتمل' ? 'default' : 'outline')}>{payment.status}</Badge></TableCell>
                                    <TableCell className="text-left">
                                        <Button variant="outline" size="sm" onClick={() => handleFeatureClick(`تحميل فاتورة ${payment.bookingId}`)}><Download className="w-4 h-4 ml-2"/> تحميل</Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                            {filteredPayments.length === 0 && <TableRow><TableCell colSpan={6} className="h-24 text-center">لا توجد عمليات تطابق البحث.</TableCell></TableRow>}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>

            <Card>
                <CardHeader className="flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                    <CardTitle>طرق الدفع المحفوظة</CardTitle>
                    <Button onClick={() => setIsAddMethodModalOpen(true)}><PlusCircle className="w-4 h-4 ml-2"/>إضافة طريقة دفع جديدة</Button>
                </CardHeader>
                <CardContent className="space-y-3">
                    {methods.map(method => (
                        <div key={method.id} className="flex justify-between items-center p-3 border rounded-md bg-slate-50">
                            <div className="flex items-center gap-3">
                                <CreditCard className="w-6 h-6 text-primary"/>
                                <div>
                                    <p className="font-semibold">{method.type} تنتهي بـ {method.last4}</p>
                                    <p className="text-xs text-slate-500">تنتهي في: {method.expiry}</p>
                                </div>
                                {method.isDefault && <Badge>افتراضية</Badge>}
                            </div>
                            <div className="flex gap-2">
                                {!method.isDefault && <Button variant="outline" size="sm" onClick={() => handleSetDefaultMethod(method.id)}>تعيين كافتراضية</Button>}
                                <Button variant="ghost" size="sm" className="text-red-500" onClick={() => handleDeleteMethod(method.id)}>حذف</Button>
                            </div>
                        </div>
                    ))}
                    {methods.length === 0 && <p className="text-sm text-slate-500 text-center py-4">لا توجد طرق دفع محفوظة.</p>}
                </CardContent>
            </Card>

            <Dialog open={isAddMethodModalOpen} onOpenChange={setIsAddMethodModalOpen}>
                <DialogContent dir="rtl">
                    <DialogHeader>
                        <DialogTitle>إضافة طريقة دفع جديدة</DialogTitle>
                        <DialogDescription>أدخل تفاصيل بطاقتك الائتمانية الجديدة.</DialogDescription>
                    </DialogHeader>
                    <div className="py-4 space-y-3">
                        <div>
                            <Label htmlFor="cardType">نوع البطاقة</Label>
                            <Select value={newMethodData.type} onValueChange={(val) => setNewMethodData(p => ({...p, type: val}))}>
                                <SelectTrigger><SelectValue/></SelectTrigger>
                                <SelectContent><SelectItem value="Visa">Visa</SelectItem><SelectItem value="Mastercard">Mastercard</SelectItem><SelectItem value="Amex">American Express</SelectItem></SelectContent>
                            </Select>
                        </div>
                        <div><Label htmlFor="cardNumber">رقم البطاقة</Label><Input id="cardNumber" value={newMethodData.cardNumber} onChange={(e) => setNewMethodData(p => ({...p, cardNumber: e.target.value}))} placeholder="xxxx xxxx xxxx xxxx"/></div>
                        <div className="grid grid-cols-2 gap-3">
                            <div><Label htmlFor="cardExpiry">تاريخ الانتهاء (MM/YY)</Label><Input id="cardExpiry" value={newMethodData.expiry} onChange={(e) => setNewMethodData(p => ({...p, expiry: e.target.value}))} placeholder="MM/YY"/></div>
                            <div><Label htmlFor="cardCvv">CVV</Label><Input id="cardCvv" value={newMethodData.cvv} onChange={(e) => setNewMethodData(p => ({...p, cvv: e.target.value}))} placeholder="123"/></div>
                        </div>
                    </div>
                    <DialogFooter className="gap-2">
                        <DialogClose asChild><Button variant="ghost">إلغاء</Button></DialogClose>
                        <Button onClick={handleAddMethod}>إضافة البطاقة</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
};

export default PaymentHistory;