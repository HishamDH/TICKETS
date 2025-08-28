
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { GitBranch, PlusCircle, List, MapPin, Edit, Trash2 } from 'lucide-react';

const branches = [
    { id: 'BR-RYD', name: 'مطعم الرياض', location: 'الرياض، حي الياسمين', status: 'نشط' },
    { id: 'BR-JED', name: 'مطعم جدة', location: 'جدة، حي الشاطئ', status: 'نشط' },
    { id: 'BR-DMM', name: 'معرض الدمام', location: 'الدمام، مركز المعارض', status: 'مؤقت' },
    { id: 'BR-KHBR', name: 'كافيه الخبر', location: 'الخبر، الكورنيش', status: 'قريباً' },
];

const BranchManagementContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">إدارة الفروع</h2>
            </div>
            
            <Tabs defaultValue="list" dir="rtl">
                <TabsList className="grid w-full grid-cols-2">
                    <TabsTrigger value="list" className="flex items-center gap-2"><List className="h-4 w-4"/> قائمة الفروع</TabsTrigger>
                    <TabsTrigger value="create" className="flex items-center gap-2"><PlusCircle className="h-4 w-4"/> إضافة فرع جديد</TabsTrigger>
                </TabsList>

                <TabsContent value="list" className="pt-6">
                     <Card>
                        <CardHeader>
                            <CardTitle>قائمة الفروع</CardTitle>
                            <CardDescription>عرض وإدارة جميع فروعك من مكان واحد.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>اسم الفرع</TableHead>
                                        <TableHead>الموقع</TableHead>
                                        <TableHead>الحالة</TableHead>
                                        <TableHead>إجراءات</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {branches.map((branch) => (
                                        <TableRow key={branch.id}>
                                            <TableCell className="font-semibold">{branch.name}</TableCell>
                                            <TableCell>{branch.location}</TableCell>
                                            <TableCell>
                                                <span className={`px-2 py-1 text-xs font-semibold rounded-full ${
                                                    branch.status === 'نشط' ? 'bg-green-100 text-green-700' : 
                                                    branch.status === 'مؤقت' ? 'bg-yellow-100 text-yellow-700' :
                                                    'bg-slate-100 text-slate-600'
                                                }`}>
                                                    {branch.status}
                                                </span>
                                            </TableCell>
                                            <TableCell className="space-x-1 space-x-reverse">
                                                <Button variant="ghost" size="icon" onClick={() => handleFeatureClick("تعديل الفرع")}>
                                                    <Edit className="w-4 h-4 text-slate-500"/>
                                                </Button>
                                                <Button variant="ghost" size="icon" onClick={() => handleFeatureClick("حذف الفرع")}>
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

                <TabsContent value="create" className="pt-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>إضافة فرع جديد</CardTitle>
                            <CardDescription>أدخل بيانات الفرع الجديد لتبدأ بإدارته.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-6">
                            <div className="space-y-2">
                                <Label htmlFor="branchName">اسم الفرع</Label>
                                <div className="relative">
                                    <GitBranch className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                    <Input id="branchName" placeholder="مثال: مطعم فرع العليا" className="pr-10" />
                                </div>
                            </div>
                             <div className="space-y-2">
                                <Label htmlFor="branchLocation">موقع الفرع</Label>
                                <div className="relative">
                                    <MapPin className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                                    <Input id="branchLocation" placeholder="مثال: الرياض، شارع التحلية" className="pr-10" />
                                </div>
                            </div>
                            
                            <Button className="w-full gradient-bg text-white" size="lg" onClick={() => handleFeatureClick("حفظ الفرع الجديد")}>
                                <PlusCircle className="w-5 h-5 ml-2"/>
                                إضافة الفرع
                            </Button>
                        </CardContent>
                    </Card>
                </TabsContent>
            </Tabs>
        </div>
    );
};

export default BranchManagementContent;
