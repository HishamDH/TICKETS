import React from 'react';
import { motion } from 'framer-motion';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { FileText, Shield } from 'lucide-react';

const LegalPage = () => {
    return (
        <div className="bg-gray-50 py-12 px-4 font-cairo" dir="rtl">
            <div className="container mx-auto max-w-4xl">
                <motion.header
                    className="text-center mb-12"
                    initial={{ opacity: 0, y: -30 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6 }}
                >
                    <h1 className="text-4xl md:text-5xl font-extrabold gradient-text mb-4">
                        المركز القانوني
                    </h1>
                    <p className="text-lg text-gray-600">
                        الشروط والأحكام وسياسة الخصوصية التي تحكم استخدامك لمنصة ليلة الليليوم.
                    </p>
                </motion.header>

                <Tabs defaultValue="terms" className="w-full">
                    <TabsList className="grid w-full grid-cols-2">
                        <TabsTrigger value="terms" className="py-3 text-lg">
                            <FileText className="w-5 h-5 ml-2" />
                            شروط الاستخدام
                        </TabsTrigger>
                        <TabsTrigger value="privacy" className="py-3 text-lg">
                            <Shield className="w-5 h-5 ml-2" />
                            سياسة الخصوصية
                        </TabsTrigger>
                    </TabsList>
                    
                    <motion.div
                        key="content"
                        initial={{ opacity: 0, y: 20 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.5, delay: 0.2 }}
                    >
                        <TabsContent value="terms">
                            <Card className="mt-6 shadow-lg">
                                <CardHeader>
                                    <CardTitle>شروط وأحكام استخدام منصة ليلة الليليوم</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-4 text-gray-700 leading-relaxed">
                                    <h3 className="font-bold text-xl">1. مقدمة</h3>
                                    <p>مرحباً بك في منصة "ليلة الليليوم". هذه الشروط والأحكام توضح القواعد التي تحكم استخدامك لخدماتنا في تنظيم وحجز المناسبات. باستخدامك للمنصة، فإنك توافق على هذه الشروط بالكامل.</p>
                                    
                                    <h3 className="font-bold text-xl">2. الحسابات</h3>
                                    <p>عند إنشاء حساب معنا (سواء كعميل أو مزوّد خدمة)، يجب عليك تزويدنا بمعلومات دقيقة وكاملة وحديثة دائمًا. عدم القيام بذلك يشكل خرقًا للشروط، مما قد يؤدي إلى الإنهاء الفوري لحسابك على خدمتنا.</p>
                                    
                                    <h3 className="font-bold text-xl">3. الملكية الفكرية</h3>
                                    <p>المنصة ومحتواها الأصلي وميزاتها ووظائفها هي وستظل ملكية حصرية لـ "ليلة الليليوم" ومرخصيها. خدمتنا محمية بموجب حقوق النشر والعلامات التجارية والقوانين الأخرى.</p>
                                    
                                    <h3 className="font-bold text-xl">4. إنهاء الخدمة</h3>
                                    <p>يجوز لنا إنهاء أو تعليق حسابك على الفور، دون إشعار مسبق أو مسؤولية، لأي سبب من الأسباب، بما في ذلك على سبيل المثال لا الحصر إذا خرقت الشروط.</p>
                                     <p className="text-sm text-gray-500 italic pt-4">هذا النص هو مثال توضيحي، ويجب استبداله بالشروط والأحكام القانونية الفعلية للمنصة.</p>
                                </CardContent>
                            </Card>
                        </TabsContent>
                        <TabsContent value="privacy">
                            <Card className="mt-6 shadow-lg">
                                <CardHeader>
                                    <CardTitle>سياسة الخصوصية لمنصة ليلة الليليوم</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-4 text-gray-700 leading-relaxed">
                                    <h3 className="font-bold text-xl">1. جمع المعلومات</h3>
                                    <p>نقوم بجمع أنواع مختلفة من المعلومات لأغراض متنوعة لتوفير وتحسين خدمتنا لك. قد نطلب منك تزويدنا بمعلومات تعريف شخصية معينة يمكن استخدامها للاتصال بك أو التعرف عليك عند حجز مناسبة أو التسجيل كمزوّد خدمة.</p>
                                    
                                    <h3 className="font-bold text-xl">2. استخدام البيانات</h3>
                                    <p>تستخدم "ليلة الليليوم" البيانات التي تم جمعها لأغراض مختلفة: لتوفير الخدمة وصيانتها، لإعلامك بالتغييرات التي تطرأ على خدمتنا، للسماح لك بالمشاركة في الميزات التفاعلية لخدمتنا عندما تختار القيام بذلك، ولتقديم دعم العملاء، ولتسهيل عمليات الدفع وتوقيع العقود.</p>
                                    
                                    <h3 className="font-bold text-xl">3. أمن البيانات</h3>
                                    <p>أمن بياناتك مهم بالنسبة لنا، ولكن تذكر أنه لا توجد وسيلة نقل عبر الإنترنت أو طريقة تخزين إلكتروني آمنة 100٪. بينما نسعى جاهدين لاستخدام وسائل مقبولة تجاريًا لحماية معلوماتك الشخصية، لا يمكننا ضمان أمنها المطلق.</p>
                                     <p className="text-sm text-gray-500 italic pt-4">هذا النص هو مثال توضيحي، ويجب استبداله بسياسة الخصوصية القانونية الفعلية للمنصة.</p>
                                </CardContent>
                            </Card>
                        </TabsContent>
                    </motion.div>
                </Tabs>
            </div>
        </div>
    );
};

export default LegalPage;