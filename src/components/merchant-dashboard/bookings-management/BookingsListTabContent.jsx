import React, { useState, useMemo, memo, useRef, useEffect } from 'react';
import { motion } from 'framer-motion';
import { format, isAfter, isBefore, parseISO } from "date-fns";
import { ar } from "date-fns/locale";
import { Search, Download, MoreHorizontal, ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight, ClipboardList, Trash2, SlidersHorizontal, ArrowUpDown, Calendar as CalendarIcon, Eye, EyeOff } from 'lucide-react';
import { Card, CardContent, CardHeader } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Tabs, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Checkbox } from "@/components/ui/checkbox";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { SheetTrigger } from "@/components/ui/sheet";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { DropdownMenu, DropdownMenuContent, DropdownMenuCheckboxItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger, DialogClose } from "@/components/ui/dialog";
import { cn } from "@/lib/utils";
import { useVirtualizer } from '@tanstack/react-virtual';


const serviceTypes = {
    venue: 'قاعة مناسبات',
    catering: 'إعاشة وبوفيه',
    photography: 'تصوير فوتوغرافي وفيديو',
    beauty: 'تجميل ومكياج',
    entertainment: 'عروض ترفيهية',
    transportation: 'نقل ومواصلات',
    security: 'حراسة وأمن',
    flowers_invitations: 'ورود ودعوات'
};


const BookingsListTabContent = memo(({ 
    bookings, 
    onSelectBooking, 
    onFeatureClick,
    activeBookingsTab,
    onActiveBookingsTabChange,
    categoryCounts,
    bookingCategories
}) => {
    const [selectedRows, setSelectedRows] = useState([]);
    const [searchTerm, setSearchTerm] = useState('');
    const [typeFilter, setTypeFilter] = useState(Object.keys(serviceTypes).reduce((acc, key) => ({ ...acc, [key]: true }), {}));
    const [sortConfig, setSortConfig] = useState({ key: 'date', direction: 'desc' });
    const [dateRange, setDateRange] = useState({ from: undefined, to: undefined });

    const filteredAndSortedBookings = useMemo(() => {
        const categoryStatuses = bookingCategories[activeBookingsTab]?.statuses;
        const activeTypes = Object.keys(typeFilter).filter(key => typeFilter[key]);
        
        let filtered = bookings
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
    }, [activeBookingsTab, searchTerm, typeFilter, sortConfig, dateRange, bookings, bookingCategories]);

    const tableContainerRef = useRef(null);
    const rowVirtualizer = useVirtualizer({
        count: filteredAndSortedBookings.length,
        getScrollElement: () => tableContainerRef.current,
        estimateSize: () => 73, // Estimate row height
        overscan: 5,
    });
    
    const handleSort = (key) => {
        setSortConfig(prev => ({
            key,
            direction: prev.key === key && prev.direction === 'asc' ? 'desc' : 'asc'
        }));
        onFeatureClick(`ترتيب الحجوزات حسب ${key} ${sortConfig.direction === 'asc' ? 'تصاعدياً' : 'تنازلياً'}`);
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
        if (checked) setSelectedRows(filteredAndSortedBookings.map(b => b.id));
        else setSelectedRows([]);
        onFeatureClick(`تحديد/إلغاء تحديد كل الحجوزات`);
    };
    
    const handleRowSelect = (id, checked) => {
        setSelectedRows(prev => checked ? [...prev, id] : prev.filter(rowId => rowId !== id));
        onFeatureClick(`تحديد/إلغاء تحديد الحجز ${id}`);
    };
    
    const isAllOnPageSelected = filteredAndSortedBookings.length > 0 && selectedRows.length === filteredAndSortedBookings.length;

    const handleDelete = () => {
        onFeatureClick(`حذف ${selectedRows.length} حجز`);
        setSelectedRows([]);
    };

    return (
        <motion.div
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
        >
            <Tabs value={activeBookingsTab} className="w-full" dir="rtl" onValueChange={(val) => {onActiveBookingsTabChange(val); setSelectedRows([]);}}>
                <TabsList className="grid w-full grid-cols-2 md:grid-cols-4 gap-2 h-auto p-2 bg-primary/10 rounded-xl mb-6">
                    {Object.entries(bookingCategories).map(([key, { title }]) => (
                        <TabsTrigger key={key} value={key} className="text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg">
                            {title} <span className="mr-2 bg-white/20 text-xs font-bold px-2 py-0.5 rounded-full">{categoryCounts[key] || 0}</span>
                        </TabsTrigger>
                    ))}
                </TabsList>
                
                <Card>
                    <CardHeader className="border-b border-slate-200 p-4">
                        <div className="flex justify-between items-center flex-wrap gap-4">
                            <div className="flex items-center gap-2 flex-wrap">
                                <div className="relative flex-1 min-w-[200px]">
                                    <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-500" />
                                    <Input placeholder="ابحث بالعميل، الخدمة، أو رقم الحجز..." className="pl-10" value={searchTerm} onChange={e => { setSearchTerm(e.target.value); onFeatureClick(`البحث عن: ${e.target.value}`);}}/>
                                </div>
                                <Popover>
                                    <PopoverTrigger asChild>
                                      <Button id="date" variant={"outline"} className={cn("w-[250px] justify-start text-left font-normal", !dateRange.from && "text-muted-foreground")} onClick={() => onFeatureClick("فتح محدد نطاق التاريخ")}>
                                        <CalendarIcon className="ml-2 h-4 w-4" />
                                        {dateRange.from ? (
                                          dateRange.to ? (
                                            <>{format(dateRange.from, "LLL dd, y", { locale: ar })} - {format(dateRange.to, "LLL dd, y", { locale: ar })}</>
                                          ) : (
                                            format(dateRange.from, "LLL dd, y", { locale: ar })
                                          )
                                        ) : (
                                          <span>اختر نطاق زمني للحجز</span>
                                        )}
                                      </Button>
                                    </PopoverTrigger>
                                    <PopoverContent className="w-auto p-0" align="start">
                                        <Calendar initialFocus mode="range" defaultMonth={dateRange?.from} selected={dateRange} onSelect={(range) => {setDateRange(range); onFeatureClick("تغيير نطاق التاريخ");}} numberOfMonths={2} locale={ar}/>
                                    </PopoverContent>
                                </Popover>
                                <DropdownMenu>
                                    <DropdownMenuTrigger asChild>
                                        <Button variant="outline" className="flex gap-2" onClick={() => onFeatureClick("فتح قائمة فلترة نوع الخدمة")}><SlidersHorizontal className="w-4 h-4" /><span>نوع الخدمة</span></Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end" className="w-56">
                                        <DropdownMenuLabel>فلترة حسب نوع الخدمة</DropdownMenuLabel>
                                        <DropdownMenuSeparator />
                                        {Object.entries(serviceTypes).map(([key, text]) => (
                                            <DropdownMenuCheckboxItem key={key} checked={typeFilter[key]} onCheckedChange={(checked) => {setTypeFilter(prev => ({ ...prev, [key]: checked })); onFeatureClick(`فلترة بنوع الخدمة: ${text} - ${checked}`);}}>
                                                {text}
                                            </DropdownMenuCheckboxItem>
                                        ))}
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                            <div className="flex items-center gap-2">
                                {selectedRows.length > 0 ? (
                                    <Dialog>
                                        <DialogTrigger asChild><Button variant="destructive" onClick={() => onFeatureClick("فتح نافذة تأكيد الحذف")}><Trash2 className="w-4 h-4 ml-2" />حذف ({selectedRows.length})</Button></DialogTrigger>
                                        <DialogContent>
                                            <DialogHeader><DialogTitle>تأكيد الحذف</DialogTitle><DialogDescription>هل أنت متأكد من رغبتك في حذف {selectedRows.length} حجز محدد؟</DialogDescription></DialogHeader>
                                            <div className="flex justify-end gap-2 pt-4">
                                                <DialogClose asChild><Button variant="outline" onClick={() => onFeatureClick("إلغاء الحذف")}>إلغاء</Button></DialogClose>
                                                <DialogClose asChild><Button variant="destructive" onClick={handleDelete}>تأكيد</Button></DialogClose>
                                            </div>
                                        </DialogContent>
                                    </Dialog>
                                ) : (
                                    <Button variant="outline" onClick={() => onFeatureClick("تصدير الحجوزات")}><Download className="w-4 h-4 ml-2" />تصدير</Button>
                                )}
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent className="p-0">
                        <div ref={tableContainerRef} className="h-[60vh] overflow-auto">
                            <Table style={{ height: `${rowVirtualizer.getTotalSize()}px` }}>
                                <TableHeader className="sticky top-0 bg-white z-10">
                                    <TableRow>
                                        <TableHead className="w-[50px] px-4"><Checkbox checked={isAllOnPageSelected} onCheckedChange={handleSelectAll} /></TableHead>
                                        <SortableHeader sortKey="customer">العميل</SortableHeader>
                                        <TableHead>الباقة/الخدمة</TableHead>
                                        <TableHead>متاح أونلاين؟</TableHead>
                                        <SortableHeader sortKey="packageStatus">حالة الباقة</SortableHeader>
                                        <SortableHeader sortKey="amount">المبلغ</SortableHeader>
                                        <SortableHeader sortKey="date">تاريخ المناسبة</SortableHeader>
                                        <TableHead className="text-center">إجراءات</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody className="relative">
                                    {rowVirtualizer.getVirtualItems().length > 0 ? rowVirtualizer.getVirtualItems().map((virtualRow) => {
                                        const booking = filteredAndSortedBookings[virtualRow.index];
                                        return (
                                        <TableRow 
                                            key={booking.id}
                                            data-state={selectedRows.includes(booking.id) && "selected"}
                                            style={{
                                                position: 'absolute',
                                                top: 0,
                                                left: 0,
                                                width: '100%',
                                                height: `${virtualRow.size}px`,
                                                transform: `translateY(${virtualRow.start}px)`,
                                            }}
                                        >
                                            <TableCell className="px-4"><Checkbox checked={selectedRows.includes(booking.id)} onCheckedChange={checked => handleRowSelect(booking.id, checked)} /></TableCell>
                                            <TableCell className="font-medium text-slate-900">
                                                <div className="flex items-center gap-3">
                                                    <Avatar>
                                                        <AvatarImage src={booking.avatar === '-' ? `https://source.unsplash.com/random/200x200?sig=${booking.id}` : booking.avatar} alt={booking.customer} />
                                                        <AvatarFallback>{booking.customer.charAt(0)}</AvatarFallback>
                                                    </Avatar>
                                                    <div><div className="font-semibold">{booking.customer}</div><div className="text-xs text-slate-500 font-mono">{booking.id.startsWith('PKG-') ? 'باقة منصة' : booking.id}</div></div>
                                                </div>
                                            </TableCell>
                                            <TableCell><div>{booking.event}</div><div className="text-xs text-muted-foreground">{booking.serviceType}</div></TableCell>
                                            <TableCell>
                                                <span className={`p-1.5 rounded-full inline-block ${booking.online ? 'bg-green-500' : 'bg-slate-300'}`}>
                                                    {booking.online ? <Eye className="w-4 h-4 text-white"/> : <EyeOff className="w-4 h-4 text-slate-600"/>}
                                                </span>
                                            </TableCell>
                                            <TableCell><span className={`px-2.5 py-1 text-xs font-semibold rounded-full ${booking.packageStatus === 'منشور' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600'}`}>{booking.packageStatus}</span></TableCell>
                                            <TableCell className="font-mono">{booking.amount.toFixed(2)} ريال</TableCell>
                                            <TableCell>{format(parseISO(booking.date), 'PPP', { locale: ar })}</TableCell>
                                            <TableCell className="text-center">
                                                <SheetTrigger asChild><Button variant="ghost" size="icon" onClick={() => onSelectBooking(booking)}><MoreHorizontal className="h-5 w-5 text-slate-500" /></Button></SheetTrigger>
                                            </TableCell>
                                        </TableRow>
                                    )}) : (
                                        <TableRow>
                                            <TableCell colSpan="8" className="h-[50vh] text-center text-slate-500">
                                            <div className="flex flex-col items-center gap-4"><ClipboardList className="w-16 h-16 text-slate-300" /><p className="font-semibold text-lg">لا توجد حجوزات</p><p>لا توجد حجوزات تطابق بحثك أو الفلاتر المطبقة.</p></div>
                                        </TableCell>
                                        </TableRow>
                                    )}
                                </TableBody>
                            </Table>
                        </div>
                    </CardContent>
                </Card>
            </Tabs>
        </motion.div>
    );
});

export default BookingsListTabContent;