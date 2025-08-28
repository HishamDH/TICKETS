
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { Tag, PlusCircle, List, Calendar as CalendarIcon, Edit, Trash2, RefreshCw } from 'lucide-react';
import { format } from "date-fns";
import { ar } from "date-fns/locale";

const promoCodes = [
    { id: 'CODE-001', code: 'RAMADAN24', discount: '15%', status: 'نشط', usage: '45/100', expiry: '2025-04-10' },
    { id: 'CODE-002', code: 'EIDJOY', discount: '50 ريال', status: 'نشط', usage: '88/200', expiry: '2025-04-15' },
    { id: 'CODE-003', code: 'NEWBIE', discount: '10%', status: 'منتهي', usage: '50/50', expiry: '2025-03-01' },
];

const PromotionsContent = ({ handleFeatureClick }) => {
    const [date, setDate] = React.useState(null);

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">العروض الترويجية والأكواد</h2>
            </div>
            
            <Tabs defaultValue="create" dir="rtl">
                <TabsList className="grid w-full grid-cols-2">
                    <TabsTrigger value="create" className="flex items-center gap-2"><PlusCircle className="h-4 w-4"/> إنشاء كود جديد</TabsTrigger>
                    <TabsTrigger value="list" className="flex items-center gap-2"><List className="h-4 w-4"/> قائمة الأكواد</TabsTrigger>
                </TabsList>

                <TabsContent value="create" className="pt-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>إنشاء كود خصم جديد</CardTitle>
                            <CardDescription>قم بإعداد كود خصم جديد لجذب المزيد من العملاء.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-6">
                             <div className="grid md:grid-cols-2 gap-6">
                                <div className="space-y-2">
                                    <Label htmlFor="promoName">اسم العرض (داخلي)</Label>
                                    <Input id="promoName" placeholder="مثال: خصم اليوم الوطني" />
                                </div>
                                <div className="space-y-2">
                                    <Label htmlFor="promoCode">كود الخصم</Label>
                                    <div className="flex gap-2">
                                        <Input id="promoCode" placeholder="NATIONAL94" />
                                        <Button variant="outline" size="icon" onClick={() => handleFeatureClick("توليد كود عشوائي")}>
                                            <RefreshCw className="h-4 w-4"/>
                                        </Button>
                                    </div>
                                </div>
                            </div>
                            
                            <div className="grid md:grid-cols-2 gap-6">
                                <div className="space-y-2">
                                    <Label>نوع الخصم</Label>
                                    <Select dir="rtl">
                                        <SelectTrigger>
                                            <SelectValue placeholder="اختر نوع الخصم..." />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="percentage">نسبة مئوية (%)</SelectItem>
                                            <SelectItem value="fixed">مبلغ ثابت (ريال)</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                                <div className="space-y-2">
                                    <Label htmlFor="discountValue">قيمة الخصم</Label>
                                    <Input id="discountValue" type="number" placeholder="مثال: 15 أو 50" />
                                </div>
                            </div>

                             <div className="grid md:grid-cols-2 gap-6">
                                <div className="space-y-2">
                                    <Label htmlFor="usageLimit">الحد الأقصى للاستخدام</Label>
                                    <Input id="usageLimit" type="number" placeholder="مثال: 100" />
                                </div>
                                <div className="space-y-2">
                                    <Label>تاريخ الانتهاء</Label>
                                     <Popover>
                                        <PopoverTrigger asChild>
                                        <Button
                                            variant={"outline"}
                                            className="w-full justify-start text-right font-normal"
                                        >
                                            <CalendarIcon className="ml-2 h-4 w-4" />
                                            {date ? format(date, "PPP", { locale: ar }) : <span>اختر تاريخاً</span>}
                                        </Button>
                                        </PopoverTrigger>
                                        <PopoverContent className="w-auto p-0">
                                            <Calendar
                                                mode="single"
                                                selected={date}
                                                onSelect={setDate}
                                                initialFocus
                                                locale={ar}
                                            />
                                        </PopoverContent>
                                    </Popover>
                                </div>
                            </div>

                            <div className="space-y-4">
                               <div className="space-y-2">
                                    <Label>تطبيق على</Label>
                                    <Select dir="rtl">
                                        <SelectTrigger>
                                            <SelectValue placeholder="اختر الخدمات المستهدفة..." />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">كل الخدمات</SelectItem>
                                            <SelectItem value="event1">معرض التقنية 2025</SelectItem>
                                            <SelectItem value="event2">تجربة الغوص</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                            </div>
                            
                            <Button className="w-full gradient-bg text-white" size="lg" onClick={() => handleFeatureClick("إنشاء كود خصم")}>
                                <Tag className="w-5 h-5 ml-2"/>
                                إنشاء كود الخصم
                            </Button>
                        </CardContent>
                    </Card>
                </TabsContent>

                <TabsContent value="list" className="pt-6">
                     <Card>
                        <CardHeader>
                            <CardTitle>قائمة أكواد الخصم</CardTitle>
                            <CardDescription>إدارة وتتبع جميع أكواد الخصم الخاصة بك.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>الكود</TableHead>
                                        <TableHead>الخصم</TableHead>
                                        <TableHead>الحالة</TableHead>
                                        <TableHead>الاستخدام</TableHead>
                                        <TableHead>تاريخ الانتهاء</TableHead>
                                        <TableHead>إجراءات</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {promoCodes.map((promo) => (
                                        <TableRow key={promo.id}>
                                            <TableCell className="font-mono">{promo.code}</TableCell>
                                            <TableCell>{promo.discount}</TableCell>
                                             <TableCell>
                                                <span className={`px-2 py-1 text-xs font-semibold rounded-full ${promo.status === 'نشط' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`}>
                                                    {promo.status}
                                                </span>
                                            </TableCell>
                                            <TableCell>{promo.usage}</TableCell>
                                            <TableCell>{promo.expiry}</TableCell>
                                            <TableCell className="space-x-1 space-x-reverse">
                                                <Button variant="ghost" size="icon" onClick={() => handleFeatureClick("تعديل الكود")}>
                                                    <Edit className="w-4 h-4 text-slate-500"/>
                                                </Button>
                                                <Button variant="ghost" size="icon" onClick={() => handleFeatureClick("إلغاء الكود")}>
                                                    <Trash2 className="w-4 h-4 text-red-500"/>
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </TabsContent>
            </Tabs>
        </div>
    );
};

export default PromotionsContent;
