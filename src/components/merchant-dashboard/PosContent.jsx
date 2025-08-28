
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Printer, User, Phone, Mail, Ticket, UtensilsCrossed, Sparkles, Building2, PlusCircle, List, Trash2 } from 'lucide-react';

const posBookings = [
    { id: 'POS-001', customer: 'عميل نقدي', service: 'تذكرة فعالية', createdBy: 'علياء حسن', payment: 'نقدًا', status: 'مدفوع' },
    { id: 'POS-002', customer: 'أحمد علي', service: 'حجز طاولة', createdBy: 'علياء حسن', payment: 'بطاقة', status: 'مدفوع' },
    { id: 'POS-003', customer: 'دعوة VIP', service: 'تسجيل معرض', createdBy: 'أنت', payment: 'مجاناً', status: 'مدفوع' },
];

const PosContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">البيع الداخلي (POS)</h2>
            </div>
            
            <Tabs defaultValue="create" dir="rtl">
                <TabsList className="grid w-full grid-cols-2">
                    <TabsTrigger value="create" className="flex items-center gap-2"><PlusCircle className="h-4 w-4"/> إنشاء حجز يدوي</TabsTrigger>
                    <TabsTrigger value="list" className="flex items-center gap-2"><List className="h-4 w-4"/> قائمة الحجوزات الداخلية</TabsTrigger>
                </TabsList>

                <TabsContent value="create" className="pt-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>إنشاء حجز جديد</CardTitle>
                            <CardDescription>أدخل تفاصيل الحجز للعميل الذي يقوم بالدفع من المقر.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-6">
                            <div className="grid md:grid-cols-2 gap-6">
                                <div className="space-y-2">
                                    <Label>نوع الخدمة</Label>
                                    <Select dir="rtl">
                                        <SelectTrigger>
                                            <SelectValue placeholder="اختر نوع الخدمة..." />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="event"><Ticket className="w-4 h-4 ml-2 inline"/>تذكرة فعالية</SelectItem>
                                            <SelectItem value="restaurant"><UtensilsCrossed className="w-4 h-4 ml-2 inline"/>طاولة مطعم</SelectItem>
                                            <SelectItem value="experience"><Sparkles className="w-4 h-4 ml-2 inline"/>تجربة</SelectItem>
                                            <SelectItem value="exhibition"><Building2 className="w-4 h-4 ml-2 inline"/>تسجيل معرض</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                                 <div className="space-y-2">
                                    <Label>العنصر المحدد</Label>
                                    <Select dir="rtl">
                                        <SelectTrigger>
                                            <SelectValue placeholder="اختر العنصر..." />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="item1">معرض التقنية 2025</SelectItem>
                                            <SelectItem value="item2">حجز طاولة عشاء</SelectItem>
                                            <SelectItem value="item3">تجربة الغوص</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                            </div>

                             <div className="space-y-2">
                                <Label htmlFor="tickets">عدد التذاكر / الأشخاص</Label>
                                <Input id="tickets" type="number" placeholder="1" defaultValue="1" />
                            </div>

                            <div className="grid md:grid-cols-2 gap-6">
                                <div className="space-y-2">
                                    <Label htmlFor="customerName">اسم العميل (اختياري)</Label>
                                    <div className="relative">
                                        <User className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                        <Input id="customerName" placeholder="مثال: خالد محمد" className="pr-10" />
                                    </div>
                                </div>
                                <div className="space-y-2">
                                    <Label htmlFor="customerPhone">رقم الجوال</Label>
                                    <div className="relative">
                                        <Phone className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                        <Input id="customerPhone" placeholder="05xxxxxxxx" className="pr-10" />
                                    </div>
                                </div>
                            </div>
                            
                            <div className="space-y-2">
                                <Label htmlFor="customerEmail">البريد الإلكتروني (اختياري)</Label>
                                <div className="relative">
                                    <Mail className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                    <Input id="customerEmail" type="email" placeholder="email@example.com" className="pr-10" />
                                </div>
                            </div>

                             <div className="space-y-2">
                                <Label>وسيلة الدفع</Label>
                                <Select dir="rtl" defaultValue="cash">
                                    <SelectTrigger>
                                        <SelectValue placeholder="اختر وسيلة الدفع..." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="cash">💵 نقدًا</SelectItem>
                                        <SelectItem value="card">💳 بطاقة (جهاز نقاط)</SelectItem>
                                        <SelectItem value="free">🧾 مجانًا (دعوة أو VIP)</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>

                            <Button className="w-full gradient-bg text-white" size="lg" onClick={() => handleFeatureClick("إنشاء حجز وطباعة")}>
                                <Printer className="w-5 h-5 ml-2"/>
                                إنشاء الحجز وطباعة التذكرة
                            </Button>
                        </CardContent>
                    </Card>
                </TabsContent>

                <TabsContent value="list" className="pt-6">
                     <Card>
                        <CardHeader>
                            <CardTitle>سجل الحجوزات الداخلية</CardTitle>
                            <CardDescription>عرض جميع الحجوزات التي تم إنشاؤها عبر نظام البيع الداخلي.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>رقم الحجز</TableHead>
                                        <TableHead>العميل</TableHead>
                                        <TableHead>الخدمة</TableHead>
                                        <TableHead>أنشئ بواسطة</TableHead>
                                        <TableHead>وسيلة الدفع</TableHead>
                                        <TableHead>إجراءات</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {posBookings.map((booking) => (
                                        <TableRow key={booking.id}>
                                            <TableCell className="font-mono">{booking.id}</TableCell>
                                            <TableCell>{booking.customer}</TableCell>
                                            <TableCell>{booking.service}</TableCell>
                                            <TableCell>{booking.createdBy}</TableCell>
                                            <TableCell>{booking.payment}</TableCell>
                                            <TableCell className="space-x-2 space-x-reverse">
                                                <Button variant="outline" size="sm" onClick={() => handleFeatureClick("طباعة تذكرة")}>
                                                    <Printer className="w-4 h-4 ml-1"/> طباعة
                                                </Button>
                                                <Button variant="ghost" size="sm" className="text-red-500 hover:text-red-600" onClick={() => handleFeatureClick("إلغاء حجز")}>
                                                    <Trash2 className="w-4 h-4 ml-1"/> إلغاء
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

export default PosContent;
