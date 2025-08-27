import React, { useState, useEffect, useMemo, useRef, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from '@/components/ui/badge';
import { FileText, Filter, Search, Download, Eye, Edit, CheckCircle2, AlertTriangle, ShieldCheck, PlusCircle, Trash2 } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { format, parseISO } from 'date-fns';
import { ar } from 'date-fns/locale';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from "@/components/ui/dialog";
import { ScrollArea } from '@/components/ui/scroll-area';
import SignatureCanvas from 'react-signature-canvas';

const initialContracts = [
    { id: 'CTR-001', customerName: 'شركة ألفا للتكنولوجيا', serviceName: 'قاعة المؤتمرات الكبرى', bookingId: 'BK-8450', status: 'pending_merchant_signature', date: '2025-07-15T10:00:00.000Z', amount: 12000, version: 1, merchantSignature: null, customerSignature: null },
    { id: 'CTR-002', customerName: 'فهد الغامدي', serviceName: 'باقة الزفاف الملكية', bookingId: 'BK-8451', status: 'pending_customer_signature', date: '2025-08-01T14:30:00.000Z', amount: 25000, version: 1, merchantSignature: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=', customerSignature: null },
    { id: 'CTR-003', customerName: 'مؤسسة النجاح للمعارض', serviceName: 'تجهيز جناح المعرض الكامل', bookingId: 'BK-8452', status: 'active', date: '2025-06-20T09:00:00.000Z', amount: 8500, version: 2, merchantSignature: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=', customerSignature: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=' },
    { id: 'CTR-004', customerName: 'سارة العتيبي', serviceName: 'تصوير حفل تخرج', bookingId: 'BK-8453', status: 'completed', date: '2025-05-10T18:00:00.000Z', amount: 3500, version: 1, merchantSignature: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=', customerSignature: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=' },
    { id: 'CTR-005', customerName: 'نادي الابتكار الرياضي', serviceName: 'استئجار ملعب كرة القدم', bookingId: 'BK-8454', status: 'cancelled', date: '2025-07-01T16:00:00.000Z', amount: 1500, version: 1, merchantSignature: null, customerSignature: null },
];

const contractStatusDetails = {
    pending_merchant_signature: { text: 'بانتظار توقيعك', color: 'bg-yellow-100 text-yellow-700', icon: Edit },
    pending_customer_signature: { text: 'بانتظار توقيع العميل', color: 'bg-sky-100 text-sky-700', icon: AlertTriangle },
    active: { text: 'ساري وموقع', color: 'bg-green-100 text-green-700', icon: ShieldCheck },
    completed: { text: 'مكتمل', color: 'bg-slate-100 text-slate-700', icon: CheckCircle2 },
    cancelled: { text: 'ملغي', color: 'bg-red-100 text-red-700', icon: AlertTriangle },
};

const ITEMS_PER_PAGE = 10;

const ContractsManagementContent = memo(({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [contracts, setContracts] = useState(() => {
        try {
            const savedContracts = localStorage.getItem('lilium_night_contracts_v2');
            return savedContracts ? JSON.parse(savedContracts) : initialContracts;
        } catch (error) {
            return initialContracts;
        }
    });

    const [searchTerm, setSearchTerm] = useState('');
    const [statusFilter, setStatusFilter] = useState('all');
    const [currentPage, setCurrentPage] = useState(1);
    const [selectedContract, setSelectedContract] = useState(null);
    const [isViewModalOpen, setIsViewModalOpen] = useState(false);
    const [isSignModalOpen, setIsSignModalOpen] = useState(false);
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [newContractData, setNewContractData] = useState({ customerName: '', serviceName: '', amount: '', date: '' });

    const signaturePadRef = useRef(null);

    useEffect(() => {
        localStorage.setItem('lilium_night_contracts_v2', JSON.stringify(contracts));
    }, [contracts]);
    
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

    const filteredContracts = useMemo(() => {
        return contracts
            .filter(contract => 
                statusFilter === 'all' || contract.status === statusFilter
            )
            .filter(contract => 
                contract.customerName.toLowerCase().includes(searchTerm.toLowerCase()) ||
                contract.serviceName.toLowerCase().includes(searchTerm.toLowerCase()) ||
                contract.id.toLowerCase().includes(searchTerm.toLowerCase()) ||
                (contract.bookingId && contract.bookingId.toLowerCase().includes(searchTerm.toLowerCase()))
            )
            .sort((a, b) => new Date(b.date) - new Date(a.date));
    }, [contracts, searchTerm, statusFilter]);

    const totalPages = Math.ceil(filteredContracts.length / ITEMS_PER_PAGE);
    const paginatedContracts = filteredContracts.slice((currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE);
    
    const handleViewContract = (contract) => {
        setSelectedContract(contract);
        setIsViewModalOpen(true);
        handleFeatureClick(`عرض تفاصيل العقد ${contract.id}`);
    };

    const handleOpenSignModal = (contract) => {
        setSelectedContract(contract);
        setIsSignModalOpen(true);
        handleFeatureClick(`فتح نافذة توقيع العقد ${contract.id}`);
    };

    const handleSignContract = () => {
        if (!selectedContract || signaturePadRef.current.isEmpty()) {
            toast({ title: "خطأ", description: "يرجى التوقيع في المساحة المخصصة.", variant: "destructive" });
            return;
        }
        const signatureData = signaturePadRef.current.toDataURL();
        setContracts(prevContracts => prevContracts.map(c => 
            c.id === selectedContract.id ? { ...c, status: 'pending_customer_signature', merchantSignature: signatureData } : c
        ));
        setIsSignModalOpen(false);
        signaturePadRef.current.clear();
        toast({ title: "تم التوقيع بنجاح!", description: `تم توقيع العقد ${selectedContract.id} من طرفك. بانتظار توقيع العميل.` });
        handleFeatureClick(`توقيع العقد ${selectedContract.id} من طرف التاجر`);
    };

    const handleCreateContract = () => {
        if(!newContractData.customerName || !newContractData.serviceName || !newContractData.amount || !newContractData.date) {
            toast({ title: "خطأ", description: "يرجى تعبئة جميع الحقول المطلوبة.", variant: "destructive" });
            return;
        }
        const newId = `CTR-${String(Date.now()).slice(-5)}`;
        const newBookingId = `BK-${String(Date.now()).slice(-4)}`;
        const newContract = {
            id: newId,
            customerName: newContractData.customerName,
            serviceName: newContractData.serviceName,
            bookingId: newBookingId,
            status: 'pending_merchant_signature',
            date: new Date(newContractData.date).toISOString(),
            amount: parseFloat(newContractData.amount),
            version: 1,
            merchantSignature: null,
            customerSignature: null,
        };
        setContracts(prev => [newContract, ...prev]);
        setIsCreateModalOpen(false);
        setNewContractData({ customerName: '', serviceName: '', amount: '', date: '' });
        toast({ title: "تم إنشاء العقد بنجاح!", description: `تم إنشاء عقد جديد برقم ${newId}.` });
        handleFeatureClick('إنشاء عقد جديد');
    };

    return (
        <div className="space-y-8">
            <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 className="text-3xl font-bold text-slate-800">إدارة العقود الإلكترونية</h2>
                    <p className="text-slate-500 mt-2">أنشئ وتابع حالة جميع عقود خدماتك الموقعة والمنتظرة عبر منصة ليلة الليليوم.</p>
                </div>
                <Button onClick={() => setIsCreateModalOpen(true)} className="gradient-bg text-white"><PlusCircle className="w-4 h-4 ml-2"/> إنشاء عقد جديد</Button>
            </div>
            
            <Card>
                <CardHeader>
                    <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <CardTitle>قائمة العقود ({filteredContracts.length})</CardTitle>
                        <div className="flex items-center gap-2 w-full md:w-auto">
                            <div className="relative flex-grow">
                                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                <Input
                                    placeholder="ابحث بالعميل، الخدمة، رقم العقد أو الحجز..."
                                    className="pl-10"
                                    value={searchTerm}
                                    onChange={(e) => { setSearchTerm(e.target.value); setCurrentPage(1); handleFeatureClick(`البحث عن عقد: ${e.target.value}`);}}
                                />
                            </div>
                            <Select value={statusFilter} onValueChange={(value) => { setStatusFilter(value); setCurrentPage(1); handleFeatureClick(`فلترة العقود بالحالة: ${value}`);}} dir="rtl">
                                <SelectTrigger className="w-full md:w-[180px]">
                                    <Filter className="h-4 w-4 ml-2 text-slate-500"/>
                                    <SelectValue placeholder="فلترة بالحالة" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">كل الحالات</SelectItem>
                                    {Object.entries(contractStatusDetails).map(([key, details]) => (
                                        <SelectItem key={key} value={key}>{details.text}</SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                             <Button variant="outline" onClick={() => handleFeatureClick("تصدير قائمة العقود")}><Download className="w-4 h-4 ml-2"/>تصدير</Button>
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    {paginatedContracts.length > 0 ? (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>رقم العقد</TableHead>
                                    <TableHead>العميل</TableHead>
                                    <TableHead>الخدمة</TableHead>
                                    <TableHead>تاريخ الحدث</TableHead>
                                    <TableHead>المبلغ</TableHead>
                                    <TableHead>الحالة</TableHead>
                                    <TableHead>الإجراءات</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {paginatedContracts.map((contract) => {
                                    const statusInfo = contractStatusDetails[contract.status] || { text: contract.status, color: 'bg-slate-200 text-slate-800', icon: FileText };
                                    const StatusIcon = statusInfo.icon;
                                    return (
                                        <TableRow key={contract.id}>
                                            <TableCell className="font-mono">{contract.id}</TableCell>
                                            <TableCell>{contract.customerName}</TableCell>
                                            <TableCell>{contract.serviceName}</TableCell>
                                            <TableCell>{format(parseISO(contract.date), 'PPP', { locale: ar })}</TableCell>
                                            <TableCell>{contract.amount.toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'})}</TableCell>
                                            <TableCell>
                                                <Badge variant="outline" className={`px-2 py-1 text-xs font-semibold rounded-full flex items-center gap-1 w-fit ${statusInfo.color}`}>
                                                    <StatusIcon className="w-3 h-3"/> {statusInfo.text}
                                                </Badge>
                                            </TableCell>
                                            <TableCell className="space-x-1 space-x-reverse">
                                                <Button variant="ghost" size="icon" onClick={() => handleViewContract(contract)} title="عرض العقد">
                                                    <Eye className="w-4 h-4 text-blue-600"/>
                                                </Button>
                                                {contract.status === 'pending_merchant_signature' && (
                                                    <Button variant="ghost" size="icon" onClick={() => handleOpenSignModal(contract)} title="توقيع العقد">
                                                        <Edit className="w-4 h-4 text-green-600"/>
                                                    </Button>
                                                )}
                                            </TableCell>
                                        </TableRow>
                                    );
                                })}
                            </TableBody>
                        </Table>
                    ) : (
                         <div className="text-center py-12 text-slate-500">
                            <FileText className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                            <p className="text-xl font-semibold">لا توجد عقود تطابق بحثك.</p>
                            <p>تأكد من فلاتر البحث أو قم بإنشاء عقد جديد.</p>
                        </div>
                    )}
                </CardContent>
                {totalPages > 1 && (
                    <CardFooter className="flex items-center justify-center pt-6 gap-2">
                        <Button variant="outline" size="sm" onClick={() => { setCurrentPage(p => Math.max(1, p - 1)); handleFeatureClick("الانتقال للصفحة السابقة في العقود"); }} disabled={currentPage === 1}>السابق</Button>
                        <span className="text-sm text-slate-600">صفحة {currentPage} من {totalPages}</span>
                        <Button variant="outline" size="sm" onClick={() => { setCurrentPage(p => Math.min(totalPages, p + 1)); handleFeatureClick("الانتقال للصفحة التالية في العقود"); }} disabled={currentPage === totalPages}>التالي</Button>
                    </CardFooter>
                )}
            </Card>

            <Dialog open={isViewModalOpen} onOpenChange={(isOpen) => { setIsViewModalOpen(isOpen); if(!isOpen) handleFeatureClick("إغلاق نافذة عرض العقد"); }} dir="rtl">
                <DialogContent className="sm:max-w-3xl">
                    <DialogHeader>
                        <DialogTitle className="text-2xl">تفاصيل العقد: {selectedContract?.id}</DialogTitle>
                        <DialogDescription>
                            عرض تفاصيل العقد بينك وبين "{selectedContract?.customerName}" لخدمة "{selectedContract?.serviceName}".
                        </DialogDescription>
                    </DialogHeader>
                    <ScrollArea className="max-h-[70vh] my-4">
                        <div className="p-4 space-y-3 bg-slate-50 rounded-md">
                            <p><strong>رقم الحجز المرتبط:</strong> {selectedContract?.bookingId}</p>
                            <p><strong>مبلغ العقد:</strong> {selectedContract?.amount.toLocaleString('ar-SA', {style: 'currency', currency: 'SAR'})}</p>
                            <p><strong>تاريخ الحدث:</strong> {selectedContract?.date ? format(parseISO(selectedContract.date), 'PPP p', { locale: ar }) : '-'}</p>
                            <p><strong>إصدار العقد:</strong> {selectedContract?.version}</p>
                             <p><strong>حالة العقد:</strong> <span className={`font-semibold p-1 rounded-sm ${contractStatusDetails[selectedContract?.status]?.color}`}>{contractStatusDetails[selectedContract?.status]?.text}</span></p>
                            
                             <div className="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t mt-4">
                                <div>
                                    <h4 className="font-semibold mb-2">توقيع مزود الخدمة:</h4>
                                    {selectedContract?.merchantSignature ? <img src={selectedContract.merchantSignature} alt="توقيع مزود الخدمة" className="w-full h-24 bg-white border rounded-md object-contain"/> : <p className="text-sm text-slate-500">لم يوقع بعد</p>}
                                </div>
                                <div>
                                    <h4 className="font-semibold mb-2">توقيع العميل:</h4>
                                    {selectedContract?.customerSignature ? <img src={selectedContract.customerSignature} alt="توقيع العميل" className="w-full h-24 bg-white border rounded-md object-contain"/> : <p className="text-sm text-slate-500">لم يوقع بعد</p>}
                                </div>
                            </div>

                            <h4 className="font-semibold pt-3 text-lg border-t mt-3">محتوى العقد (مثال):</h4>
                            <p className="text-sm leading-relaxed whitespace-pre-line">
                                هذا عقد اتفاق بين الطرف الأول (مزود الخدمة) والطرف الثاني (العميل: {selectedContract?.customerName}) بخصوص تقديم خدمة "{selectedContract?.serviceName}" في تاريخ {selectedContract?.date ? format(parseISO(selectedContract.date), 'PPP', { locale: ar }) : '-'} مقابل مبلغ وقدره {selectedContract?.amount.toLocaleString()} ريال سعودي.
                                {"\n\n"}يلتزم الطرف الأول بتقديم الخدمة حسب المواصفات المتفق عليها.
                                {"\n"}يلتزم الطرف الثاني بدفع المبلغ كاملاً قبل موعد الخدمة.
                                {"\n"}تطبق سياسة الإلغاء الموضحة في صفحة الخدمة.
                            </p>
                        </div>
                    </ScrollArea>
                    <DialogFooter>
                        <Button variant="outline" onClick={() => { setIsViewModalOpen(false); handleFeatureClick("إغلاق نافذة عرض العقد"); }}>إغلاق</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

            <Dialog open={isSignModalOpen} onOpenChange={(isOpen) => { setIsSignModalOpen(isOpen); if(!isOpen) signaturePadRef.current?.clear(); handleFeatureClick("إغلاق نافذة توقيع العقد"); }} dir="rtl">
                <DialogContent className="sm:max-w-lg">
                    <DialogHeader>
                        <DialogTitle className="text-2xl">توقيع العقد: {selectedContract?.id}</DialogTitle>
                        <DialogDescription>
                           بالنقر على "أوافق وأوقع العقد"، فإنك توافق على جميع البنود وتعتبر هذه موافقة إلكترونية ملزمة.
                        </DialogDescription>
                    </DialogHeader>
                    <div className="py-4 space-y-2">
                        <Label htmlFor="signature">يرجى التوقيع أدناه:</Label>
                        <div className="w-full h-48 bg-slate-100 border-2 border-dashed rounded-md">
                           <SignatureCanvas ref={signaturePadRef} penColor='black' canvasProps={{className: 'w-full h-full'}} />
                        </div>
                        <div className="text-right">
                           <Button variant="ghost" size="sm" onClick={() => signaturePadRef.current.clear()}><Trash2 className="w-3 h-3 ml-1"/> مسح</Button>
                        </div>
                    </div>
                    <DialogFooter className="gap-2">
                        <Button variant="outline" onClick={() => { setIsSignModalOpen(false); handleFeatureClick("إلغاء توقيع العقد"); }}>إلغاء</Button>
                        <Button onClick={handleSignContract} className="gradient-bg text-white">
                            <CheckCircle2 className="w-4 h-4 ml-2"/> أوافق وأوقع العقد
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

            <Dialog open={isCreateModalOpen} onOpenChange={setIsCreateModalOpen} dir="rtl">
                <DialogContent className="sm:max-w-md">
                    <DialogHeader>
                        <DialogTitle>إنشاء عقد جديد</DialogTitle>
                        <DialogDescription>أدخل تفاصيل العقد الجديد ليتم إنشاؤه في النظام.</DialogDescription>
                    </DialogHeader>
                    <div className="grid gap-4 py-4">
                        <div className="grid grid-cols-4 items-center gap-4">
                            <Label htmlFor="customerName" className="text-right">اسم العميل</Label>
                            <Input id="customerName" value={newContractData.customerName} onChange={e => setNewContractData({...newContractData, customerName: e.target.value})} className="col-span-3" />
                        </div>
                        <div className="grid grid-cols-4 items-center gap-4">
                            <Label htmlFor="serviceName" className="text-right">اسم الخدمة</Label>
                            <Input id="serviceName" value={newContractData.serviceName} onChange={e => setNewContractData({...newContractData, serviceName: e.target.value})} className="col-span-3" />
                        </div>
                         <div className="grid grid-cols-4 items-center gap-4">
                            <Label htmlFor="amount" className="text-right">المبلغ (ر.س)</Label>
                            <Input id="amount" type="number" value={newContractData.amount} onChange={e => setNewContractData({...newContractData, amount: e.target.value})} className="col-span-3" />
                        </div>
                        <div className="grid grid-cols-4 items-center gap-4">
                            <Label htmlFor="date" className="text-right">تاريخ الحدث</Label>
                            <Input id="date" type="date" value={newContractData.date} onChange={e => setNewContractData({...newContractData, date: e.target.value})} className="col-span-3" />
                        </div>
                    </div>
                    <DialogFooter>
                        <Button type="button" variant="outline" onClick={() => setIsCreateModalOpen(false)}>إلغاء</Button>
                        <Button type="button" onClick={handleCreateContract} className="gradient-bg text-white">إنشاء العقد</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

        </div>
    );
});

export default ContractsManagementContent;