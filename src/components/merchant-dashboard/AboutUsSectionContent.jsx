import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { Info, Save } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const AboutUsSectionContent = ({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [aboutText, setAboutText] = useState('');

    useEffect(() => {
        setAboutText(localStorage.getItem('lilium_night_about_us_v1') || 'مؤسستنا هي الرائدة في مجال تنظيم المناسبات منذ عام 2010. نقدم خدمات متكاملة تشمل تأجير القاعات، خدمات الضيافة، والتصوير الاحترافي. فريقنا متخصص في تحويل أحلامكم إلى واقع ملموس.');
    }, []);

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
    
    const handleSaveChanges = () => {
        localStorage.setItem('lilium_night_about_us_v1', aboutText);
        toast({ title: "تم الحفظ!", description: "تم حفظ قسم 'نبذة عنا' بنجاح." });
        handleFeatureClick("حفظ قسم 'نبذة عنا'");
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">إضافة قسم "نبذة عنا"</h2>
            
            <Card>
                <CardHeader>
                    <CardTitle>تحرير محتوى "نبذة عنا"</CardTitle>
                    <CardDescription>اكتب وصفاً جذاباً عن نشاطك التجاري، خبراتك، وما يميزك عن الآخرين. سيظهر هذا النص في صفحتك العامة.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Textarea 
                        placeholder="اكتب هنا نبذة عن نشاطك..." 
                        className="min-h-[250px] text-base leading-relaxed"
                        value={aboutText}
                        onChange={(e) => setAboutText(e.target.value)}
                    />
                </CardContent>
                <CardFooter>
                    <Button className="gradient-bg text-white" onClick={handleSaveChanges}>
                        <Save className="w-4 h-4 ml-2" /> حفظ التغييرات
                    </Button>
                </CardFooter>
            </Card>
        </div>
    );
};

export default AboutUsSectionContent;