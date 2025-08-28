
import React from 'react';
import { motion } from 'framer-motion';
import { Ticket, PlusCircle, Star, PartyPopper, Building2, UtensilsCrossed, Sparkles } from 'lucide-react';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

const servicesData = {
  events: {
    title: "الفعاليات",
    icon: PartyPopper,
    supportedTypes: [
      "فعالية يوم واحد", "فعالية على عدة أيام", "فعالية متكررة شهريًا",
      "فعالية بمقاعد مرقمة (مسرح/سينما)", "فعالية مفتوحة بدون مقاعد", "فعالية VIP / دعوات خاصة"
    ],
    features: [
      "مخطط مقاعد تفاعلي (Seat Map)", "تذاكر قابلة للتصميم المخصص", "دعم QR للتحقق من الدخول",
      "تحديد الفئة (عامة - نسائية - أطفال…)", "إمكانية ربط الفعالية بموقع محدد في الخريطة"
    ]
  },
  exhibitions: {
    title: "المعارض والمؤتمرات",
    icon: Building2,
    supportedTypes: [
      "معرض تقني / تجاري", "معرض تعليمي / وظيفي", "مؤتمر علمي / صحي",
      "دورة أو ورشة عمل (training)", "معرض بيع تجزئة", "حدث مخصص للتسجيل المسبق (مغلق)"
    ],
    features: [
      "نظام إصدار Badge مخصص لكل مشارك", "تخصيص الحقول المطلوبة (شركة، منصب، الخ…)", "دعم QR للتحقق من البادج",
      "إرسال البادج إلكترونيًا للطباعة أو التخزين", "طباعة البادجات يدويًا من لوحة التحكم"
    ]
  },
  restaurants: {
    title: "المطاعم واللاونجات",
    icon: UtensilsCrossed,
    supportedTypes: [
      "حجز طاولة داخلية", "حجز طاولة خارجية", "طاولة مع حد أدنى للطلب (Minimum Charge)",
      "طاولة VIP / كبار الزوار", "ردهة خاصة / مناسبة خاصة", "بوفيه مفتوح مع توقيت"
    ],
    features: [
      "تقويم زمني تفاعلي لحجز الوقت والموقع", "اختيار عدد الأشخاص", "دعم عربون أو الدفع الكامل",
      "قبول / رفض الحجز يدويًا", "دعم ملاحظات خاصة بالحجز", "دعم طباعة تأكيد الحجز"
    ]
  },
  experiences: {
    title: "التجارب (Experiences)",
    icon: Sparkles,
    supportedTypes: [
      "تجربة سياحية محلية", "تجربة مغامرات (غوص، صحراء، طيران… إلخ)", "تجربة تعليمية أو ورشة فنية",
      "تجربة ترفيهية/عائلية (مزرعة، ألعاب، بيك نيك…)", "تجارب موسمية أو مناسبات خاصة"
    ],
    features: [
      "تحديد موعد وتفاصيل التجربة", "عدد محدود من المشاركين لكل موعد", "إدخال معلومات إضافية قبل الحجز (مثل الحالة الصحية)",
      "إصدار تذكرة خاصة بالتجربة", "عرض المدة، موقع التجربة، مستوى الصعوبة", "إمكانية التقييم بعد التجربة"
    ]
  }
};

const ServiceManagementContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center flex-wrap gap-4">
                <h2 className="text-3xl font-bold text-slate-800">إدارة الخدمات</h2>
                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("إضافة خدمة جديدة")}>
                    <PlusCircle className="w-5 h-5 ml-2" />
                    إضافة خدمة جديدة
                </Button>
            </div>

            <Tabs defaultValue="events" className="w-full" dir="rtl">
                <TabsList className="grid w-full grid-cols-2 md:grid-cols-4 gap-2 h-auto p-2 bg-primary/10 rounded-xl mb-6">
                    {Object.entries(servicesData).map(([key, { title, icon: Icon }]) => (
                        <TabsTrigger key={key} value={key} className="flex items-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg">
                            <Icon className="h-5 w-5"/>{title}
                        </TabsTrigger>
                    ))}
                </TabsList>

                {Object.entries(servicesData).map(([key, { title, supportedTypes, features }]) => (
                    <TabsContent key={key} value={key}>
                        <motion.div
                            initial={{ opacity: 0, y: 10 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.5 }}
                        >
                            <Card className="overflow-hidden shadow-lg border-t-4 border-primary">
                                <CardHeader className="bg-slate-50">
                                    <CardTitle className="text-2xl">{`تفاصيل مجال ${title}`}</CardTitle>
                                    <CardDescription>استعرض الأنواع المدعومة والمميزات الخاصة بهذا المجال.</CardDescription>
                                </CardHeader>
                                <CardContent className="grid md:grid-cols-2 gap-x-8 gap-y-6 p-6">
                                    <div className="space-y-4">
                                        <h3 className="font-bold text-lg text-slate-700 mb-4 border-b pb-2">🧩 الأنواع المدعومة</h3>
                                        <ul className="space-y-3">
                                            {supportedTypes.map((type, index) => (
                                                <li key={index} className="flex items-center gap-3 text-slate-600">
                                                    <div className="w-5 h-5 bg-primary/20 rounded-md flex items-center justify-center shrink-0">
                                                        <Ticket className="w-3 h-3 text-primary" />
                                                    </div>
                                                    <span>{type}</span>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                    <div className="space-y-4 md:border-r md:border-slate-200 md:pr-8">
                                        <h3 className="font-bold text-lg text-slate-700 mb-4 border-b pb-2">⭐ المميزات الخاصة</h3>
                                        <ul className="space-y-3">
                                            {features.map((feature, index) => (
                                                <li key={index} className="flex items-start gap-3 text-slate-600">
                                                    <Star className="w-5 h-5 text-amber-400 mt-0.5 shrink-0" />
                                                    <span>{feature}</span>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                </CardContent>
                                <CardFooter className="bg-slate-50 p-4 flex justify-start">
                                    <Button variant="outline" onClick={() => handleFeatureClick(`إنشاء خدمة في مجال ${title}`)}>
                                        <PlusCircle className="w-4 h-4 ml-2" />
                                        إنشاء خدمة جديدة في هذا المجال
                                    </Button>
                                </CardFooter>
                            </Card>
                        </motion.div>
                    </TabsContent>
                ))}
            </Tabs>
        </div>
    );
};

export default ServiceManagementContent;
