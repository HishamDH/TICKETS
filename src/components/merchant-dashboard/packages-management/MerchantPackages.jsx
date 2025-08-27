import React, { useState, useMemo, memo } from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Input } from "@/components/ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { format, parseISO } from 'date-fns';
import { ar } from "date-fns/locale";
import { useToast } from "@/components/ui/use-toast";
import { Package as PackageIcon, Edit3, Trash2, Globe, Eye, EyeOff, Filter, Search, SlidersHorizontal, CalendarDays, ShoppingCart, Lock } from 'lucide-react';
import { Popover, PopoverTrigger, PopoverContent } from '@/components/ui/popover';
import { Calendar } from '@/components/ui/calendar';
import { cn } from '@/lib/utils';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger, DialogClose, DialogFooter } from "@/components/ui/dialog";

const ITEMS_PER_PAGE_PACKAGES = 10;

const MerchantPackages = memo(({ 
    packagesByDate, 
    dailyConfigs, 
    onPackageUpdate, 
    onPackageDelete, 
    onTogglePackageOnlineSale,
    onEditPackageRequest,
    onBookPackage,
    handleFeatureClick: propHandleFeatureClick
}) => {
  const { toast } = useToast();
  const [searchTerm, setSearchTerm] = useState('');
  const [dateFilter, setDateFilter] = useState(null);
  const [statusFilter, setStatusFilter] = useState('all'); 
  const [currentPage, setCurrentPage] = useState(1);

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

  const allPackagesWithDate = useMemo(() => {
    let packages = [];
    Object.entries(packagesByDate).forEach(([dateString, pkgsOnDate]) => {
      pkgsOnDate.forEach(pkg => {
        const dayConfig = dailyConfigs[dateString] || {};
        packages.push({ 
            ...pkg, 
            date: dateString, 
            dayOnlineSaleActive: dayConfig.onlineSaleActive || false,
            dayIsLocked: dayConfig.isLocked || false,
            dayStatus: dayConfig.status || 'closed'
        });
      });
    });
    return packages;
  }, [packagesByDate, dailyConfigs]);

  const filteredPackages = useMemo(() => {
    return allPackagesWithDate
      .filter(pkg => {
        const searchTermLower = searchTerm.toLowerCase();
        return pkg.name.toLowerCase().includes(searchTermLower) || (pkg.features && pkg.features.toLowerCase().includes(searchTermLower));
      })
      .filter(pkg => {
        if (!dateFilter) return true;
        return pkg.date === format(dateFilter, 'yyyy-MM-dd');
      })
      .filter(pkg => {
        if (statusFilter === 'all') return true;
        const isEffectivelyOnline = pkg.onlineBookingEnabled && pkg.dayOnlineSaleActive;
        if (statusFilter === 'online') return isEffectivelyOnline;
        if (statusFilter === 'offline') return !isEffectivelyOnline;
        if (statusFilter === 'booked') return pkg.status === 'booked';
        return true;
      })
      .sort((a,b) => new Date(b.date) - new Date(a.date) || a.name.localeCompare(b.name));
  }, [allPackagesWithDate, searchTerm, dateFilter, statusFilter]);

  const totalPages = Math.ceil(filteredPackages.length / ITEMS_PER_PAGE_PACKAGES);
  const paginatedPackages = useMemo(() => {
    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE_PACKAGES;
    return filteredPackages.slice(startIndex, startIndex + ITEMS_PER_PAGE_PACKAGES);
  }, [filteredPackages, currentPage]);

  const handleEditPackage = (pkg) => {
    if (onEditPackageRequest) {
        onEditPackageRequest({ ...pkg, date: pkg.date }); 
        handleFeatureClick(`طلب تعديل الباقة: ${pkg.name}`);
    } else {
        handleFeatureClick(`طلب تعديل الباقة (لا يوجد معالج): ${pkg.name}`);
    }
  };
  
  const handleTogglePackageOnlineSaleWithToast = (dateString, packageId, activate) => {
    const pkg = packagesByDate[dateString]?.find(p => p.id === packageId);
    if(!pkg) return;

    const dayConfig = dailyConfigs[dateString];
    if (activate && (!dayConfig || !dayConfig.onlineSaleActive)) {
        toast({ title: "تنبيه", description: "يجب تفعيل البيع أونلاين لليوم بأكمله أولاً من إعدادات التقويم.", variant: "warning"});
        handleFeatureClick(`محاولة تفعيل باقة ${pkg.name} أونلاين ليوم غير مفعل`);
        return;
    }
    onTogglePackageOnlineSale(dateString, packageId, activate);
    handleFeatureClick(`تبديل حالة التفعيل أونلاين للباقة ${pkg.name} إلى ${activate}`);
  };


  return (
    <>
      <Card className="shadow-xl border-t-4 border-blue-500">
        <CardHeader>
          <CardTitle className="text-2xl font-bold flex items-center gap-2"><PackageIcon className="w-7 h-7 text-blue-500" /> إدارة جميع الباقات</CardTitle>
          <CardDescription>
            عرض وإدارة جميع الباقات التي قمت بإنشائها عبر التواريخ المختلفة. يمكنك محاكاة حجز باقة لإغلاق اليوم بالكامل.
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-6">
          <div className="flex flex-wrap items-center gap-4 p-4 bg-slate-50 rounded-lg">
            <div className="relative flex-grow min-w-[200px]">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-500" />
              <Input
                placeholder="ابحث باسم الباقة أو مميزاتها..."
                className="pl-10"
                value={searchTerm}
                onChange={(e) => { setSearchTerm(e.target.value); setCurrentPage(1); handleFeatureClick(`البحث عن باقة: ${e.target.value}`); }}
              />
            </div>
            <Popover>
              <PopoverTrigger asChild>
                <Button variant="outline" className={cn("w-[200px] justify-start text-left font-normal", !dateFilter && "text-muted-foreground")} onClick={() => handleFeatureClick("فتح فلتر التاريخ للباقات")}>
                  <CalendarDays className="ml-2 h-4 w-4" />
                  {dateFilter ? format(dateFilter, "PPP", { locale: ar }) : <span>فلترة بالتاريخ</span>}
                </Button>
              </PopoverTrigger>
              <PopoverContent className="w-auto p-0">
                <Calendar
                  mode="single"
                  selected={dateFilter}
                  onSelect={(date) => { setDateFilter(date); setCurrentPage(1); handleFeatureClick(`فلترة الباقات بتاريخ: ${date ? format(date, 'yyyy-MM-dd') : 'الكل'}`); }}
                  initialFocus
                  locale={ar}
                  disabled={(date) => date < new Date("1900-01-01")}
                />
                 <Button variant="ghost" className="w-full" onClick={() => {setDateFilter(null); setCurrentPage(1); handleFeatureClick("مسح فلتر التاريخ للباقات");}}>مسح الفلتر</Button>
              </PopoverContent>
            </Popover>
            <Select value={statusFilter} onValueChange={(value) => { setStatusFilter(value); setCurrentPage(1); handleFeatureClick(`فلترة الباقات بالحالة: ${value}`); }} dir="rtl">
              <SelectTrigger className="w-[180px]">
                <SlidersHorizontal className="h-4 w-4 ml-2"/>
                <SelectValue placeholder="فلترة بالحالة" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">كل الحالات</SelectItem>
                <SelectItem value="online">مفعلة أونلاين</SelectItem>
                <SelectItem value="offline">غير مفعلة أونلاين</SelectItem>
                <SelectItem value="booked">محجوزة</SelectItem>
              </SelectContent>
            </Select>
          </div>

          {paginatedPackages.length > 0 ? (
            <div className="overflow-x-auto">
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>اسم الباقة</TableHead>
                    <TableHead>التاريخ</TableHead>
                    <TableHead>السعر</TableHead>
                    <TableHead>الحالة</TableHead>
                    <TableHead>الإجراءات</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {paginatedPackages.map(pkg => {
                    const isEffectivelyOnline = pkg.onlineBookingEnabled && pkg.dayOnlineSaleActive;
                    const isBooked = pkg.status === 'booked';
                    const isDayLocked = pkg.dayIsLocked;
                    return (
                      <TableRow key={`${pkg.date}-${pkg.id}`} className={isBooked ? 'bg-green-50' : (isDayLocked ? 'bg-slate-100' : '')}>
                        <TableCell className="font-semibold">{pkg.name}</TableCell>
                        <TableCell>{format(parseISO(pkg.date), 'PPP', { locale: ar })}</TableCell>
                        <TableCell>{pkg.price} ريال</TableCell>
                        <TableCell>
                            {isBooked ? (
                                <span className="px-2 py-1 text-xs font-semibold rounded-full bg-green-200 text-green-800">محجوزة</span>
                            ) : isDayLocked ? (
                                <span className="px-2 py-1 text-xs font-semibold rounded-full bg-slate-200 text-slate-800">اليوم مقفل</span>
                            ) : isEffectivelyOnline ? (
                                <span className="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">متاحة أونلاين</span>
                            ) : (
                                <span className="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">متاحة داخلياً</span>
                            )}
                        </TableCell>
                        <TableCell className="space-x-1 space-x-reverse">
                          <Button variant="ghost" size="icon" onClick={() => handleEditPackage(pkg)} disabled={isDayLocked}>
                            <Edit3 className="w-4 h-4 text-blue-600" />
                          </Button>
                          <Button variant="ghost" size="icon" onClick={() => {onPackageDelete(pkg.date, pkg.id); handleFeatureClick(`حذف الباقة: ${pkg.name}`);}} disabled={isDayLocked}>
                            <Trash2 className="w-4 h-4 text-red-600" />
                          </Button>
                           <Button 
                                variant="ghost" 
                                size="icon" 
                                onClick={() => handleTogglePackageOnlineSaleWithToast(pkg.date, pkg.id, !pkg.onlineBookingEnabled)} 
                                disabled={!pkg.dayOnlineSaleActive || isDayLocked}
                                title={!pkg.dayOnlineSaleActive ? "يجب تفعيل اليوم أولاً للبيع أونلاين" : (pkg.onlineBookingEnabled ? "إلغاء تفعيل الباقة أونلاين" : "تفعيل الباقة أونلاين")}
                            >
                                <Globe className={`w-4 h-4 ${isEffectivelyOnline ? 'text-green-600' : (pkg.dayOnlineSaleActive ? 'text-slate-500' : 'text-slate-300') }`} />
                            </Button>
                            <Dialog>
                                <DialogTrigger asChild>
                                    <Button variant="ghost" size="icon" disabled={isDayLocked}>
                                        <ShoppingCart className="w-4 h-4 text-green-600" />
                                    </Button>
                                </DialogTrigger>
                                <DialogContent>
                                    <DialogHeader>
                                        <DialogTitle>محاكاة حجز الباقة</DialogTitle>
                                        <DialogDescription>
                                            هل أنت متأكد من أنك تريد محاكاة حجز باقة "{pkg.name}" ليوم {format(parseISO(pkg.date), 'PPP', { locale: ar })}؟
                                            <br/>
                                            <strong className="text-red-600">هذا الإجراء سيؤدي إلى إغلاق اليوم بالكامل أمام أي حجوزات أخرى.</strong>
                                        </DialogDescription>
                                    </DialogHeader>
                                    <DialogFooter className="gap-2 pt-4">
                                        <DialogClose asChild><Button variant="outline">إلغاء</Button></DialogClose>
                                        <DialogClose asChild><Button className="bg-green-600 hover:bg-green-700 text-white" onClick={() => onBookPackage(pkg.date, pkg.id)}>تأكيد الحجز وإغلاق اليوم</Button></DialogClose>
                                    </DialogFooter>
                                </DialogContent>
                            </Dialog>
                        </TableCell>
                      </TableRow>
                    );
                  })}
                </TableBody>
              </Table>
            </div>
          ) : (
            <div className="text-center py-12 text-slate-500">
              <PackageIcon className="w-16 h-16 mx-auto text-slate-300 mb-4" />
              <p className="text-xl font-semibold">لا توجد باقات تطابق بحثك.</p>
              <p>حاول تغيير فلاتر البحث أو إضافة باقات جديدة من تبويب "إعداد التقويم والباقات".</p>
            </div>
          )}

          {totalPages > 1 && (
            <div className="flex items-center justify-center pt-6 gap-2">
              <Button variant="outline" size="sm" onClick={() => {setCurrentPage(p => Math.max(1, p - 1)); handleFeatureClick("الانتقال للصفحة السابقة في الباقات");}} disabled={currentPage === 1}>السابق</Button>
              <span className="text-sm text-slate-600">صفحة {currentPage} من {totalPages}</span>
              <Button variant="outline" size="sm" onClick={() => {setCurrentPage(p => Math.min(totalPages, p + 1)); handleFeatureClick("الانتقال للصفحة التالية في الباقات");}} disabled={currentPage === totalPages}>التالي</Button>
            </div>
          )}
        </CardContent>
      </Card>
    </>
  );
});

export default MerchantPackages;