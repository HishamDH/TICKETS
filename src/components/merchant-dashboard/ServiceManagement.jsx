import React, { useState, Suspense, lazy, memo } from 'react';
import { motion } from 'framer-motion';
import { Ticket, PlusCircle, Star, Building2, UtensilsCrossed, Camera, Music, Palette as PaletteIcon, Truck, Shield as ShieldIcon, Flower2 } from 'lucide-react';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { useToast } from "@/components/ui/use-toast";
import { Skeleton } from '@/components/ui/skeleton';

const AddServiceDialog = lazy(() => import('@/components/merchant-dashboard/AddServiceDialog'));

const servicesData = {
  venues: {
    title: "القاعات والقصور",
    icon: Building2,
    supportedTypes: [
      "قاعة زفاف", "قصر أفراح", "استراحة للمناسبات", "منتجع خاص", "صالة متعددة الأغراض"
    ],
    features: [
      "تحديد السعة والمساحة", "إدارة المرافق (صوتيات، إضاءة، مواقف)", "تقويم حجوزات متقدم", "إمكانية إضافة صور وفيديوهات للقاعة"
    ]
  },
  catering: {
    title: "الإعاشة والبوفيه",
    icon: UtensilsCrossed,
    supportedTypes: [
      "بوفيه مفتوح (غداء/عشاء)", "قوائم طعام مخصصة", "خدمات ضيافة (قهوة وشاي)", "كيك وحلويات للمناسبات"
    ],
    features: [
      "تحديد عدد الأفراد", "اختيار أنواع الأطباق والمشروبات", "إدارة الحساسية الغذائية", "تنسيق طاولات الطعام والديكور"
    ]
  },
  photography: {
    title: "التصوير والفيديو",
    icon: Camera,
    supportedTypes: [
      "تصوير فوتوغرافي (زفاف، خطوبة، تخرج)", "تصوير فيديو احترافي", "تصوير جوي (درون)", "ألبوم صور فاخر"
    ],
    features: [
      "تحديد عدد ساعات التغطية", "اختيار المصور/المصورة", "معرض أعمال سابق", "تسليم المواد بجودة عالية"
    ]
  },
  beauty: {
    title: "التجميل والمكياج",
    icon: PaletteIcon,
    supportedTypes: [
      "مكياج عروس", "تسريحات شعر", "خدمات تجميل شاملة (مانيكير، باديكير)", "باكجات عناية بالبشرة"
    ],
    features: [
      "اختيار خبيرة التجميل", "تحديد نوع المكياج والتسريحة", "إمكانية الحجز في الصالون أو المنزل", "استخدام منتجات عالية الجودة"
    ]
  },
  entertainment: {
    title: "العروض الترفيهية",
    icon: Music,
    supportedTypes: [
      "فرق موسيقية (DJ, فرقة شعبية)", "عروض ضوئية وصوتية", "فقرات ترفيهية (ألعاب نارية، عروض بهلوانية)", "تأجير معدات صوت وإضاءة"
    ],
    features: [
      "تحديد نوع العرض ومدته", "اختيار الفنانين أو الفرقة", "تنسيق مع متطلبات المكان", "توفير المعدات اللازمة"
    ]
  },
  transportation: {
    title: "النقل والمواصلات",
    icon: Truck,
    supportedTypes: [
      "سيارات فاخرة للعروسين", "حافلات لنقل الضيوف", "خدمات صف السيارات (Valet Parking)"
    ],
    features: [
      "تحديد نوع وعدد السيارات", "تحديد مسار الرحلة والمواعيد", "سائقين محترفين", "تأمين شامل للركاب"
    ]
  },
  security: {
    title: "الحراسة والأمن",
    icon: ShieldIcon,
    supportedTypes: [
      "حراس أمن للمناسبات", "تأمين مداخل ومخارج القاعة", "كاميرات مراقبة"
    ],
    features: [
      "تحديد عدد الحراس المطلوبين", "تنسيق خطة أمنية للمكان", "فرق مدربة ومؤهلة"
    ]
  },
  flowers_invitations: {
    title: "الورود والدعوات",
    icon: Flower2,
    supportedTypes: [
      "تنسيق زهور (كوشة، طاولات)", "باقات ورد للعروس", "تصميم وطباعة بطاقات دعوة"
    ],
    features: [
      "اختيار أنواع الزهور والألوان", "تصاميم مبتكرة للدعوات", "توصيل في الوقت المحدد"
    ]
  }
};

const AddServiceDialogFallback = () => (
  <div className="p-4">
    <Skeleton className="h-8 w-1/2" />
    <Skeleton className="h-4 w-3/4 mt-2" />
  </div>
);


const ServiceManagementContent = memo(({ handleNavigation, onFeatureClick }) => {
    const { toast } = useToast();
    const [isAddServiceDialogOpen, setIsAddServiceDialogOpen] = useState(false);
    const [currentServiceCategory, setCurrentServiceCategory] = useState(null);
    const [suggestedServiceNameForDialog, setSuggestedServiceNameForDialog] = useState('');


    const openDialogForNewService = () => {
        setCurrentServiceCategory(null);
        setSuggestedServiceNameForDialog('');
        setIsAddServiceDialogOpen(true);
    };

    const openDialogForCategoryService = (categoryKey, categoryTitle) => {
        setCurrentServiceCategory(categoryKey);
        setSuggestedServiceNameForDialog(`خدمة جديدة في ${categoryTitle}`);
        setIsAddServiceDialogOpen(true);
    };
    
    const handleInternalClick = (featureName, categoryKey = null, categoryTitle = null) => {
        if (featureName === "إضافة خدمة جديدة") {
            openDialogForNewService();
        } else if (featureName.startsWith("إنشاء خدمة جديدة في مجال")) {
            openDialogForCategoryService(categoryKey, categoryTitle);
        } else {
             if (typeof onFeatureClick === 'function') {
                onFeatureClick(featureName);
             } else {
                toast({
                    title: "🚧 ميزة قيد التطوير (Fallback)",
                    description: `من "ServiceManagementContent (Fallback)": ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
                    variant: "default",
                });
            }
        }
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center flex-wrap gap-4">
                <h1 className="text-3xl font-bold text-slate-800">إدارة الخدمات والباقات</h1>
                <Button className="gradient-bg text-white" onClick={() => handleInternalClick("إضافة خدمة جديدة")}>
                    <PlusCircle className="w-5 h-5 ml-2" />
                    إضافة باقة أو خدمة جديدة
                </Button>
            </div>

            <Tabs defaultValue="venues" className="w-full" dir="rtl">
                <TabsList className="grid w-full grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-2 h-auto p-2 bg-primary/10 rounded-xl mb-6">
                    {Object.entries(servicesData).map(([key, { title, icon: Icon }]) => (
                        <TabsTrigger 
                            key={key} 
                            value={key} 
                            className="flex-col sm:flex-row items-center justify-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-primary data-[state=active]:text-white data-[state=active]:shadow-lg h-16 sm:h-auto"
                        >
                            <Icon className="h-5 w-5 mb-1 sm:mb-0"/><span>{title}</span>
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
                                        <h2 className="font-bold text-lg text-slate-700 mb-4 border-b pb-2">🧩 الأنواع المدعومة</h2>
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
                                        <h2 className="font-bold text-lg text-slate-700 mb-4 border-b pb-2">⭐ المميزات الخاصة</h2>
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
                                    <Button variant="outline" onClick={() => handleInternalClick(`إنشاء خدمة جديدة في مجال ${title}`, key, title)}>
                                        <PlusCircle className="w-4 h-4 ml-2" />
                                        إنشاء باقة/خدمة جديدة في هذا المجال
                                    </Button>
                                </CardFooter>
                            </Card>
                        </motion.div>
                    </TabsContent>
                ))}
            </Tabs>
            <Suspense fallback={<AddServiceDialogFallback />}>
                <AddServiceDialog 
                    isOpen={isAddServiceDialogOpen} 
                    onOpenChange={setIsAddServiceDialogOpen}
                    serviceCategory={currentServiceCategory}
                    suggestedServiceName={suggestedServiceNameForDialog}
                />
            </Suspense>
        </div>
    );
});

export default ServiceManagementContent;