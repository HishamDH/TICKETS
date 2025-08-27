import React from 'react';
import { motion } from 'framer-motion';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Copy, QrCode, Mail, MessageSquare, Twitter } from 'lucide-react';
import { useToast } from '@/components/ui/use-toast';

const PromoTools = () => {
    const { toast } = useToast();
    const referralLink = "https://shobak.sa/join?ref=partner123";

    const copyToClipboard = () => {
        navigator.clipboard.writeText(referralLink);
        toast({
            title: "تم النسخ!",
            description: "تم نسخ رابط الإحالة بنجاح.",
            className: "bg-green-500 text-white",
        });
    };

    return (
        <motion.div 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
            className="space-y-8"
        >
            <Card className="shadow-lg">
                <CardHeader>
                    <CardTitle>رابط الإحالة الخاص بك</CardTitle>
                    <CardDescription>
                        شارك هذا الرابط مع التجار لتسجيلهم تحت حسابك وكسب العمولات.
                    </CardDescription>
                </CardHeader>
                <CardContent className="flex items-center gap-4">
                    <Input readOnly value={referralLink} className="text-lg"/>
                    <Button size="lg" onClick={copyToClipboard}>
                        <Copy className="w-5 h-5 ml-2" />
                        نسخ
                    </Button>
                </CardContent>
            </Card>

            <div className="grid md:grid-cols-2 gap-8">
                <Card className="shadow-lg">
                    <CardHeader>
                        <CardTitle>رمز الاستجابة السريعة (QR Code)</CardTitle>
                        <CardDescription>
                            مثالي للمشاركة في الفعاليات أو المواد المطبوعة.
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="flex flex-col items-center justify-center">
                        <div className="p-4 bg-white rounded-lg border">
                           <img  class="w-48 h-48" alt="QR Code for referral link" src="https://images.unsplash.com/photo-1626682561113-d1db402cc866" />
                        </div>
                        <Button variant="outline" className="mt-4">
                            <QrCode className="w-5 h-5 ml-2" />
                            تحميل الرمز
                        </Button>
                    </CardContent>
                </Card>
                <Card className="shadow-lg">
                    <CardHeader>
                        <CardTitle>مشاركة سريعة</CardTitle>
                        <CardDescription>
                            شارك رابطك مباشرة عبر المنصات المختلفة.
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <Button className="w-full justify-start" size="lg" variant="outline">
                            <Mail className="w-5 h-5 ml-4" />
                            مشاركة عبر البريد الإلكتروني
                        </Button>
                         <Button className="w-full justify-start" size="lg" variant="outline">
                            <MessageSquare className="w-5 h-5 ml-4" />
                            مشاركة عبر واتساب
                        </Button>
                         <Button className="w-full justify-start" size="lg" variant="outline">
                            <Twitter className="w-5 h-5 ml-4" />
                            مشاركة عبر تويتر (X)
                        </Button>
                    </CardContent>
                </Card>
            </div>
        </motion.div>
    );
};

export default PromoTools;