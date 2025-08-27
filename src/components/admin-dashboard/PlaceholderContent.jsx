import React from 'react';
import { motion } from 'framer-motion';
import { Wrench, Construction } from 'lucide-react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { useToast } from "@/components/ui/use-toast";
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

const PlaceholderContent = ({ title, icon: Icon, children, handleFeatureClick: propHandleFeatureClick, description }) => {
    const { toast } = useToast();

    const internalHandleFeatureClick = (featureDetail) => {
        if (propHandleFeatureClick && typeof propHandleFeatureClick === 'function') {
            propHandleFeatureClick(featureDetail);
        } else {
             toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureDetail}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
                variant: "default",
            });
        }
    };
    
    const handleMockSubmit = () => {
        internalHandleFeatureClick(`إرسال بيانات وهمية لـ "${title || 'الميزة المطلوبة'}"`);
    };

    return (
        <motion.div
            className="flex flex-col items-center justify-center h-full text-center p-4"
            initial={{ opacity: 0, scale: 0.95 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.5 }}
        >
            <Card className="w-full max-w-2xl shadow-xl bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900">
                <CardHeader className="pb-4">
                    <div className="mx-auto w-20 h-20 mb-6 bg-primary/10 rounded-full flex items-center justify-center ring-4 ring-primary/20">
                        {Icon ? <Icon className="w-10 h-10 text-primary" /> : <Construction className="w-10 h-10 text-primary" />}
                    </div>
                    <CardTitle className="text-3xl font-bold text-slate-800 dark:text-slate-100">{title || "ميزة تحت الإنشاء"}</CardTitle>
                    <CardDescription className="text-slate-600 dark:text-slate-400 text-lg">
                        {description || "هذه الميزة قيد التطوير حاليًا. فريقنا يعمل بجد لإطلاقها قريبًا لتوفير أفضل تجربة لك!"}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    {children ? (
                        <div className="text-left space-y-4 p-4 border-t border-slate-200 dark:border-slate-700 mt-4">
                            {children}
                        </div>
                    ) : (
                        <div className="text-left space-y-4 p-4 border-t border-slate-200 dark:border-slate-700 mt-4">
                            <p className="text-slate-700 dark:text-slate-300 font-semibold">نموذج تفاعلي وهمي:</p>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <Label htmlFor="fakeInput1" className="text-slate-700 dark:text-slate-300">إدخال بيانات وهمية</Label>
                                    <Input id="fakeInput1" placeholder="مثال: اسم المستخدم" className="bg-white dark:bg-slate-700" onChange={() => {}}/>
                                </div>
                                <div>
                                    <Label htmlFor="fakeInput2" className="text-slate-700 dark:text-slate-300">خيار وهمي آخر</Label>
                                    <Input id="fakeInput2" placeholder="مثال: رقم الهاتف" className="bg-white dark:bg-slate-700" onChange={() => {}}/>
                                </div>
                            </div>
                            <div>
                                <Label htmlFor="fakeTextarea" className="text-slate-700 dark:text-slate-300">ملاحظات وهمية</Label>
                                <Textarea id="fakeTextarea" placeholder="اكتب ملاحظاتك هنا..." className="bg-white dark:bg-slate-700" onChange={() => {}}/>
                            </div>
                            <Button className="w-full mt-2 gradient-bg text-white" onClick={handleMockSubmit}>
                                إرسال بيانات وهمية
                            </Button>
                        </div>
                    )}
                </CardContent>
            </Card>
        </motion.div>
    );
};

export default React.memo(PlaceholderContent);