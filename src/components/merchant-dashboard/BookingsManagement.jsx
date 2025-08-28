
import React, { useState, useMemo } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { addDays, format, isAfter, isBefore } from "date-fns";
import { ar } from "date-fns/locale";
import { Search, Download, MoreHorizontal, ChevronDown, ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight, ClipboardList, Trash2, SlidersHorizontal, ArrowUpDown, Calendar as CalendarIcon } from 'lucide-react';
import { Card, CardContent, CardHeader } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Tabs, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Checkbox } from "@/components/ui/checkbox";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from "@/components/ui/sheet";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { DropdownMenu, DropdownMenuContent, DropdownMenuCheckboxItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger, DialogClose } from "@/components/ui/dialog";

import BookingDetails from '@/components/merchant-dashboard/BookingDetails';
import { cn } from "@/lib/utils";

const bookingStatuses = {
    pending: { text: 'قيد الانتظار', color: 'bg-yellow-100 text-yellow-800' },
    paid: { text: 'مدفوع', color: 'bg-green-100 text-green-800' },
    approved: { text: 'مقبول يدويًا', color: 'bg-sky-100 text-sky-800' },
    rejected: { text: 'مرفوض يدويًا', color: 'bg-red-100 text-red-800' },
    used: { text: 'مستخدم', color: 'bg-indigo-100 text-indigo-800' },
    expired: { text: 'منتهية الصلاحية', color: 'bg-slate-100 text-slate-800' },
    cancelled_by_user: { text: 'ملغي من العميل', color: 'bg-orange-100 text-orange-800' },
    cancelled_by_merchant: { text: 'ملغي من التاجر', color: 'bg-orange-200 text-orange-900' },
    refunded_full: { text: 'مسترد بالكامل', color: 'bg-purple-100 text-purple-800' },
    awaiting_confirmation: { text: 'بانتظار الموافقة', color: 'bg-cyan-100 text-cyan-800' },
    no_show: { text: 'لم يحضر', color: 'bg-gray-200 text-gray-700' },
};

const serviceTypes = {
    event: 'فعالية',
    exhibition: 'معرض',
    restaurant: 'مطعم',
    experience: 'تجربة'
};

const sampleBookings = [
    { id: 'BK-8462', customer: 'أحمد الغامدي', email: 'ahmed@example.com', avatar: 'man with glasses', event: 'معرض التقنية', status: 'paid', date: '2025-06-12', amount: 150.00, type: 'exhibition' },
    { id: 'BK-7654', customer: 'فاطمة الزهراني', email: 'fatima@example.com', avatar: 'woman with headscarf', event: 'حجز طاولة عشاء', status: 'awaiting_confirmation', date: '2025-06-13', amount: 300.00, type: 'restaurant' },
    { id: 'BK-6831', customer: 'خالد المصري', email: 'khaled@example.com', avatar: 'smiling man', event: 'تجربة الغوص', status: 'used', date: '2025-06-10', amount: 450.00, type: 'experience' },
    { id: 'BK-5987', customer: 'سارة عبدالله', email: 'sara@example.com', avatar: 'woman with curly hair', event: 'ورشة عمل فنية', status: 'cancelled_by_user', date: '2025-06-15', amount: 200.00, type: 'event' },
    { id: 'BK-4123', customer: 'محمد علي', email: 'mohammed@example.com', avatar: 'man in a suit', event: 'مؤتمر صحي', status: 'refunded_full', date: '2025-06-09', amount: 100.00, type: 'exhibition' },
    { id: 'BK-3456', customer: 'نورة القحطاني', email: 'noura@example.com', avatar: 'woman smiling', event: 'فعالية يوم واحد', status: 'expired', date: '2025-06-01', amount: 75.00, type: 'event' },
    { id: 'BK-2789', customer: 'عبدالرحمن الشهري', email: 'abdul@example.com', avatar: 'man with beard', event: 'حجز طاولة VIP', status: 'approved', date: '2025-06-14', amount: 800.00, type: 'restaurant' },
    { id: 'BK-1902', customer: 'ريم العتيبي', email: 'reem@example.com', avatar: 'woman with long hair', event: 'معرض تجاري', status: 'no_show', date: '2025-06-11', amount: 50.00, type: 'exhibition' },
    { id: 'BK-1122', customer: 'بدر الحربي', email: 'badr@example.com', avatar: 'young man', event: 'معرض التقنية', status: 'paid', date: '2025-06-12', amount: 150.00, type: 'exhibition' },
    { id: 'BK-1123', customer: 'لمى خالد', email: 'lama@example.com', avatar: 'young woman', event: 'حجز طاولة عشاء', status: 'paid', date: '2025-06-13', amount: 250.00, type: 'restaurant' },
    { id: 'BK-1124', customer: 'عمر ياسر', email: 'omar@example.com', avatar: 'man smiling', event: 'تجربة الغوص', status: 'cancelled_by_merchant', date: '2025-06-10', amount: 450.00, type: 'experience' },
    { id: 'BK-1125', customer: 'هند المطيري', email: 'hind@example.com', avatar: 'woman wearing glasses', event: 'ورشة عمل فنية', status: 'paid', date: '2025-06-15', amount: 200.00, type: 'event' },
];

const bookingCategories = {
    all: { title: 'كل الحجوزات' },
    active: { title: 'النشطة', statuses: ['paid', 'approved', 'awaiting_confirmation'] },
    cancelled: { title: 'الملغاة', statuses: ['cancelled_by_user', 'cancelled_by_merchant', 'refunded_full'] },
    finished: { title: 'المنتهية', statuses: ['expired', 'no_show', 'used'] },
};

const ITEMS_PER_PAGE = 5;

const BookingsManagementContent = ({ handleFeatureClick }) => {
    const [activeTab, setActiveTab] = useState('all');
    const [selectedRows, setSelectedRows] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedBooking, setSelectedBooking] = useState(null);
    const [typeFilter, setTypeFilter] = useState(Object.keys(serviceTypes).reduce((acc, key) => ({ ...acc, [key]: true }), {}));
    const [sortConfig, setSortConfig] = useState({ key: 'date', direction: 'desc' });
    const [dateRange, setDateRange] = useState({ from: undefined, to: undefined });

    const categoryCounts = useMemo(() => {
        const counts = { all: sampleBookings.length };
        Object.entries(bookingCategories).forEach(([key, value]) => {
            if(key !== 'all') {
                counts[key] = sampleBookings.filter(b => value.statuses.includes(b.status)).length;
            }
        });
        return counts;
    }, []);

    const filteredAndSortedBookings = useMemo(() => {
        const categoryStatuses = bookingCategories[activeTab]?.statuses;
        const activeTypes = Object.keys(typeFilter).filter(key => typeFilter[key]);
        
        let filtered = sampleBookings
            .filter(booking => !categoryStatuses || categoryStatuses.includes(booking.status))
            .filter(booking => activeTypes.includes(booking.type))
            .filter(booking => 
                booking.customer.toLowerCase().includes(searchTerm.toLowerCase()) ||
                booking.event.toLowerCase().includes(searchTerm.toLowerCase()) ||
                booking.id.toLowerCase().includes(searchTerm.toLowerCase())
            )
            .filter(booking => {
                if (!dateRange.from && !dateRange.to) return true;
                const bookingDate = new Date(booking.date);
                if (dateRange.from && isBefore(bookingDate, dateRange.from)) return false;
                if (dateRange.to && isAfter(bookingDate, dateRange.to)) return false;
                return true;
            });
        
        return [...filtered].sort((a, b) => {
            if (a[sortConfig.key] < b[sortConfig.key]) {
                return sortConfig.direction === 'asc' ? -1 : 1;
            }
            if (a[sortConfig.key] > b[sortConfig.key]) {
                return sortConfig.direction === 'asc' ? 1 : -1;
            }
            return 0;
        });
    }, [activeTab, searchTerm, typeFilter, sortConfig, dateRange]);

    const totalPages = Math.ceil(filteredAndSortedBookings.length / ITEMS_PER_PAGE);

    const paginatedBookings = useMemo(() => {
        const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
        return filteredAndSortedBookings.slice(startIndex, startIndex + ITEMS_PER_PAGE);
    }, [filteredAndSortedBookings, currentPage]);
    
    const handleSort = (key) => {
        setSortConfig(prev => ({
            key,
            direction: prev.key === key && prev.direction === 'asc' ? 'desc' : 'asc'
        }));
    };

    const SortableHeader = ({ children, sortKey }) => (
        <TableHead>
            <Button variant="ghost" onClick={() => handleSort(sortKey)} className="px-0">
                {children}
                {sortConfig.key === sortKey ? (
                    sortConfig.direction === 'asc' ? <ArrowUpDown className="w-4 h-4 ml-2" /> : <ArrowUpDown className="w-4 h-4 ml-2 text-primary" />
                ) : <ArrowUpDown className="w-4 h-4 ml-2 opacity-30" />}
            </Button>
        </TableHead>
    );

    const handleSelectAll = (checked) => {
        if (checked) setSelectedRows(paginatedBookings.map(b => b.id));
        else setSelectedRows([]);
    };
    
    const handleRowSelect = (id, checked) => {
        setSelectedRows(prev => checked ? [...prev, id] : prev.filter(rowId => rowId !== id));
    };
    
    const isAllOnPageSelected = paginatedBookings.length > 0 && selectedRows.length === paginatedBookings.length;

    const handleTabChange = (value) => {
        setActiveTab(value);
        setCurrentPage(1);
        setSelectedRows([]);
    };

    const handleDelete = () => {
        handleFeatureClick(`حذف ${selectedRows.length} حجز`);
        setSelectedRows([]);
    };

    return (
        <Sheet>
            <div className="space-y-6">
                <h2 className="text-3xl font-bold text-slate-800">إدارة الحجوزات</h2>
                
                <Tabs value={activeTab} className="w-full" dir="rtl" onValueChange={handleTabChange}>
                    <TabsList className="grid w-full grid-cols-2 md:grid-cols-4 gap-2 h-auto p-2 bg-primary/10 rounded-xl mb-6">
                        {Object.entries(bookingCategories).map(([key, { title }]) => (
                            <TabsTrigger key={key} value={key} className="text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg">
                                {title} <span className="mr-2 bg-white/20 text-xs font-bold px-2 py-0.5 rounded-full">{categoryCounts[key]}</span>
                            </TabsTrigger>
                        ))}
                    </TabsList>
                    
                    <Card>
                        <CardHeader className="border-b border-slate-200 p-4">
                            <div className="flex justify-between items-center flex-wrap gap-4">
                                <div className="flex items-center gap-2 flex-wrap">
                                    <div className="relative flex-1 min-w-[200px]">
                                        <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-500" />
                                        <Input placeholder="ابحث..." className="pl-10" value={searchTerm} onChange={e => { setSearchTerm(e.target.value); setCurrentPage(1);}}/>
                                    </div>
                                    <Popover>
                                        <PopoverTrigger asChild>
                                          <Button id="date" variant={"outline"} className={cn("w-[250px] justify-start text-left font-normal", !dateRange.from && "text-muted-foreground")}>
                                            <CalendarIcon className="ml-2 h-4 w-4" />
                                            {dateRange.from ? (
                                              dateRange.to ? (
                                                <>{format(dateRange.from, "LLL dd, y", { locale: ar })} - {format(dateRange.to, "LLL dd, y", { locale: ar })}</>
                                              ) : (
                                                format(dateRange.from, "LLL dd, y", { locale: ar })
                                              )
                                            ) : (
                                              <span>اختر نطاق زمني</span>
                                            )}
                                          </Button>
                                        </PopoverTrigger>
                                        <PopoverContent className="w-auto p-0" align="start">
                                            <Calendar initialFocus mode="range" defaultMonth={dateRange?.from} selected={dateRange} onSelect={setDateRange} numberOfMonths={2} locale={ar}/>
                                        </PopoverContent>
                                    </Popover>
                                    <DropdownMenu>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="outline" className="flex gap-2"><SlidersHorizontal className="w-4 h-4" /><span>نوع الخدمة</span></Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="end" className="w-56">
                                            <DropdownMenuLabel>فلترة حسب نوع الخدمة</DropdownMenuLabel>
                                            <DropdownMenuSeparator />
                                            {Object.entries(serviceTypes).map(([key, text]) => (
                                                <DropdownMenuCheckboxItem key={key} checked={typeFilter[key]} onCheckedChange={(checked) => setTypeFilter(prev => ({ ...prev, [key]: checked }))}>
                                                    {text}
                                                </DropdownMenuCheckboxItem>
                                            ))}
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </div>
                                <div className="flex items-center gap-2">
                                    {selectedRows.length > 0 ? (
                                        <Dialog>
                                            <DialogTrigger asChild><Button variant="destructive"><Trash2 className="w-4 h-4 ml-2" />حذف ({selectedRows.length})</Button></DialogTrigger>
                                            <DialogContent>
                                                <DialogHeader><DialogTitle>تأكيد الحذف</DialogTitle><DialogDescription>هل أنت متأكد من رغبتك في حذف {selectedRows.length} حجز محدد؟</DialogDescription></DialogHeader>
                                                <div className="flex justify-end gap-2 pt-4">
                                                    <DialogClose asChild><Button variant="outline">إلغاء</Button></DialogClose>
                                                    <DialogClose asChild><Button variant="destructive" onClick={handleDelete}>تأكيد</Button></DialogClose>
                                                </div>
                                            </DialogContent>
                                        </Dialog>
                                    ) : (
                                        <Button variant="outline" onClick={() => handleFeatureClick("تصدير الحجوزات")}><Download className="w-4 h-4 ml-2" />تصدير</Button>
                                    )}
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent className="p-0">
                            <div className="overflow-x-auto">
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead className="w-[50px] px-4"><Checkbox checked={isAllOnPageSelected} onCheckedChange={handleSelectAll} /></TableHead>
                                            <SortableHeader sortKey="customer">العميل</SortableHeader>
                                            <TableHead>الخدمة</TableHead>
                                            <TableHead>الحالة</TableHead>
                                            <SortableHeader sortKey="amount">المبلغ</SortableHeader>
                                            <SortableHeader sortKey="date">التاريخ</SortableHeader>
                                            <TableHead className="text-center">إجراءات</TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {paginatedBookings.length > 0 ? paginatedBookings.map((booking) => (
                                            <TableRow key={booking.id} data-state={selectedRows.includes(booking.id) && "selected"}>
                                                <TableCell className="px-4"><Checkbox checked={selectedRows.includes(booking.id)} onCheckedChange={checked => handleRowSelect(booking.id, checked)} /></TableCell>
                                                <TableCell className="font-medium text-slate-900">
                                                    <div className="flex items-center gap-3">
                                                        <Avatar><AvatarFallback>{booking.customer.charAt(0)}</AvatarFallback></Avatar>
                                                        <div><div className="font-semibold">{booking.customer}</div><div className="text-xs text-slate-500 font-mono">{booking.id}</div></div>
                                                    </div>
                                                </TableCell>
                                                <TableCell><div>{booking.event}</div><div className="text-xs text-muted-foreground">{serviceTypes[booking.type]}</div></TableCell>
                                                <TableCell><span className={`px-2.5 py-1 text-xs font-semibold rounded-full ${bookingStatuses[booking.status]?.color || 'bg-gray-100 text-gray-800'}`}>{bookingStatuses[booking.status]?.text || booking.status}</span></TableCell>
                                                <TableCell className="font-mono">{booking.amount.toFixed(2)} ريال</TableCell>
                                                <TableCell>{booking.date}</TableCell>
                                                <TableCell className="text-center">
                                                    <SheetTrigger asChild><Button variant="ghost" size="icon" onClick={() => setSelectedBooking(booking)}><MoreHorizontal className="h-5 w-5 text-slate-500" /></Button></SheetTrigger>
                                                </TableCell>
                                            </TableRow>
                                        )) : (
                                            <TableRow><TableCell colSpan="7" className="h-48 text-center text-slate-500">
                                                <div className="flex flex-col items-center gap-4"><ClipboardList className="w-16 h-16 text-slate-300" /><p className="font-semibold text-lg">لا توجد حجوزات</p><p>لا توجد حجوزات تطابق بحثك أو الفلاتر المطبقة.</p></div>
                                            </TableCell></TableRow>
                                        )}
                                    </TableBody>
                                </Table>
                            </div>
                        </CardContent>
                        {totalPages > 1 && (
                            <div className="flex items-center justify-between p-4 border-t">
                                <div className="text-sm text-slate-500">صفحة {currentPage} من {totalPages}</div>
                                <div className="flex items-center gap-1">
                                    <Button variant="outline" size="icon" className="h-8 w-8" onClick={() => setCurrentPage(1)} disabled={currentPage === 1}><ChevronsRight className="h-4 w-4" /></Button>
                                    <Button variant="outline" size="icon" className="h-8 w-8" onClick={() => setCurrentPage(p => p - 1)} disabled={currentPage === 1}><ChevronRight className="h-4 w-4" /></Button>
                                    <Button variant="outline" size="icon" className="h-8 w-8" onClick={() => setCurrentPage(p => p + 1)} disabled={currentPage === totalPages}><ChevronLeft className="h-4 w-4" /></Button>
                                    <Button variant="outline" size="icon" className="h-8 w-8" onClick={() => setCurrentPage(totalPages)} disabled={currentPage === totalPages}><ChevronsLeft className="h-4 w-4" /></Button>
                                </div>
                            </div>
                        )}
                    </Card>
                </Tabs>
            </div>
            <SheetContent className="w-[400px] sm:w-[440px] p-0 flex flex-col" side="left">
                <SheetHeader className="p-6 border-b"><SheetTitle>تفاصيل الحجز</SheetTitle></SheetHeader>
                <BookingDetails booking={selectedBooking} handleFeatureClick={handleFeatureClick} />
            </SheetContent>
        </Sheet>
    );
};

export default BookingsManagementContent;
