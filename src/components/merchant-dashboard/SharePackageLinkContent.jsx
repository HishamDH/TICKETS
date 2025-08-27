import React, { useState, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Share2, Copy, Link as LinkIcon } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const packages = [
    { id: 'pkg1', name: 'الباقة الذهبية - زفاف', price: '15,000 ريال' },
    { id: 'pkg2', name: 'الباقة الفضية - زفاف', price: '10,000 ريال' },
    { id: 'pkg3', name: 'باقة تصوير العروسين', price: '3,500 ريال' },
    { id: 'pkg4', name: 'باقة الضيافة الكاملة', price: '5,000 ريال' },
];

const SharePackageLinkContent = memo(({ handleFeatureClick }) => {
    const { toast } = useToast();
    const [customAmount, setCustomAmount] = useState('');

    const copyToClipboard = (text, message) => {
        navigator.clipboard.writeText(text).then(() => {
            toast({
                title: "تم النسخ!",
                description: message,
            });
        });
        handleFeatureClick(message);
    };

    const shareOnWhatsApp = (text, featureMessage) => {
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
        window.open(whatsappUrl, '_blank');
        handleFeatureClick(featureMessage);
    };

    const handleSharePackage = (pkg, method) => {
        const link = `https://lilium-night.com/booking/${pkg.id}`;
        const message = `مرحباً، هذه هي باقة "${pkg.name}" التي تحدثنا عنها. يمكنك مراجعة التفاصيل والحجز من خلال الرابط التالي: ${link}`;
        if (method === 'copy') {
            copyToClipboard(link, `تم نسخ رابط الباقة: ${pkg.name}`);
        } else {
            shareOnWhatsApp(message, `مشاركة رابط باقة ${pkg.name} عبر واتساب`);
        }
    };

    const handleShareCustomLink = (method) => {
        if (!customAmount || isNaN(parseFloat(customAmount))) {
            toast({ title: "خطأ", description: "الرجاء إدخال مبلغ صحيح.", variant: "destructive" });
            return;
        }
        const link = `https://lilium-night.com/pay?amount=${customAmount}`;
        const message = `مرحباً، يمكنك إتمام عملية الدفع للمبلغ المتفق عليه (${customAmount} ريال) عبر الرابط الآمن التالي: ${link}`;
        if (method === 'copy') {
            copyToClipboard(link, `تم نسخ رابط دفع مخصص بمبلغ ${customAmount} ريال.`);
        } else {
            shareOnWhatsApp(message, `مشاركة رابط دفع مخصص بمبلغ ${customAmount} ريال عبر واتساب`);
        }
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">مشاركة رابط باقة/دفع</h2>
            <div className="grid lg:grid-cols-2 gap-8">
                <Card>
                    <CardHeader>
                        <CardTitle>مشاركة روابط الباقات</CardTitle>
                        <CardDescription>انسخ رابط مباشر لأي باقة وشاركه مع عملائك عبر واتساب أو أي منصة أخرى.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>الباقة</TableHead>
                                    <TableHead>السعر</TableHead>
                                    <TableHead>إجراء</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {packages.map(pkg => (
                                    <TableRow key={pkg.id}>
                                        <TableCell className="font-semibold">{pkg.name}</TableCell>
                                        <TableCell>{pkg.price}</TableCell>
                                        <TableCell className="flex gap-1">
                                            <Button variant="outline" size="sm" onClick={() => handleSharePackage(pkg, 'copy')}>
                                                <Copy className="w-4 h-4 ml-2" /> نسخ
                                            </Button>
                                            <Button variant="outline" size="sm" onClick={() => handleSharePackage(pkg, 'whatsapp')} className="bg-green-50 hover:bg-green-100 text-green-700">
                                                <svg className="w-4 h-4 ml-2" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>WhatsApp</title><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52s-.67-.816-.917-1.107-.513-.25-.712-.254-.428-.025-.629-.025-.513.075-.767.372c-.254.297-1.013.99-1.013 2.415s1.037 2.806 1.187 3.004c.15.198 2.013 3.06 4.887 4.33.618.302 1.109.482 1.493.623.585.217 1.12.188 1.542.115.463-.08 1.442-.584 1.637-1.15.195-.565.195-1.037.145-1.15-.05-.112-.195-.162-.442-.308zM12.031 2.182A9.855 9.855 0 0 0 2.183 12.03c0 5.435 4.418 9.855 9.848 9.855 5.438 0 9.855-4.42 9.855-9.855s-4.417-9.85-9.855-9.85z" fill="currentColor"/></svg>
                                                واتساب
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>إنشاء رابط دفع مخصص</CardTitle>
                        <CardDescription>أنشئ رابط دفع مباشر بمبلغ معين لعميل محدد (مثلاً لدفعة مقدمة أو خدمة خاصة).</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div>
                            <label htmlFor="customAmount" className="font-semibold text-slate-700">المبلغ (بالريال)</label>
                            <Input 
                                id="customAmount"
                                type="number"
                                placeholder="مثال: 500"
                                value={customAmount}
                                onChange={(e) => setCustomAmount(e.target.value)}
                            />
                        </div>
                        <div className="flex gap-2">
                            <Button className="w-full" variant="outline" onClick={() => handleShareCustomLink('copy')}>
                                <Copy className="w-4 h-4 ml-2" /> نسخ الرابط
                            </Button>
                            <Button className="w-full bg-green-600 hover:bg-green-700 text-white" onClick={() => handleShareCustomLink('whatsapp')}>
                                 <svg className="w-4 h-4 ml-2" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>WhatsApp</title><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52s-.67-.816-.917-1.107-.513-.25-.712-.254-.428-.025-.629-.025-.513.075-.767.372c-.254.297-1.013.99-1.013 2.415s1.037 2.806 1.187 3.004c.15.198 2.013 3.06 4.887 4.33.618.302 1.109.482 1.493.623.585.217 1.12.188 1.542.115.463-.08 1.442-.584 1.637-1.15.195-.565.195-1.037.145-1.15-.05-.112-.195-.162-.442-.308zM12.031 2.182A9.855 9.855 0 0 0 2.183 12.03c0 5.435 4.418 9.855 9.848 9.855 5.438 0 9.855-4.42 9.855-9.855s-4.417-9.85-9.855-9.85z" fill="currentColor"/></svg>
                                مشاركة عبر واتساب
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    );
});

export default SharePackageLinkContent;