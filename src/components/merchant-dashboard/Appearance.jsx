import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Paintbrush, Image as ImageIcon, Save } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const AppearanceContent = ({ handleNavigation, handleFeatureClick }) => {
    const { toast } = useToast();
    const [logoPreview, setLogoPreview] = useState(null);
    const [bannerPreview, setBannerPreview] = useState(null);
    const [primaryColor, setPrimaryColor] = useState("#D946EF"); 
    const [selectedTheme, setSelectedTheme] = useState("Theme1");

     const internalHandleFeatureClick = (featureName) => {
        if (handleFeatureClick && typeof handleFeatureClick === 'function') {
            handleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    const handleFileChange = (event, setImagePreview, type) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onloadend = () => {
                setImagePreview(reader.result);
            };
            reader.readAsDataURL(file);
            internalHandleFeatureClick(`رفع ${type}: ${file.name}`);
        }
    };

    const handleSaveAppearance = () => {
        localStorage.setItem('lilium_night_appearance_logo_v1', logoPreview || '');
        localStorage.setItem('lilium_night_appearance_banner_v1', bannerPreview || '');
        localStorage.setItem('lilium_night_appearance_color_v1', primaryColor);
        localStorage.setItem('lilium_night_appearance_theme_v1', selectedTheme);
        internalHandleFeatureClick("حفظ إعدادات المظهر");
    };
    
    useEffect(() => {
        setLogoPreview(localStorage.getItem('lilium_night_appearance_logo_v1'));
        setBannerPreview(localStorage.getItem('lilium_night_appearance_banner_v1'));
        setPrimaryColor(localStorage.getItem('lilium_night_appearance_color_v1') || "#D946EF");
        setSelectedTheme(localStorage.getItem('lilium_night_appearance_theme_v1') || "Theme1");
    }, []);


    const themes = [
        { name: 'Theme1', preview: 'bg-slate-200', title: 'الافتراضي (ليليوم)' },
        { name: 'Theme2', preview: 'bg-gray-800', title: 'المظلم الأنيق' },
        { name: 'Theme3', preview: 'bg-rose-200', title: 'الوردي الناعم' },
        { name: 'Theme4', preview: 'bg-sky-200', title: 'السماوي المنعش' },
    ];

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">إعداد صفحة مزوّد الخدمة</h2>
                <Button className="gradient-bg text-white" onClick={handleSaveAppearance}><Save className="w-4 h-4 ml-2"/>حفظ التغييرات</Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>الشعار والبنرات</CardTitle>
                    <CardDescription>ارفع شعار علامتك التجارية والبنر الرئيسي لصفحتك التعريفية في منصة ليلة الليليوم.</CardDescription>
                </CardHeader>
                <CardContent className="grid md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                        <Label htmlFor="logo-upload">الشعار (Logo)</Label>
                        <div className="flex items-center gap-4">
                            <div className="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden">
                                {logoPreview ? <img src={logoPreview} alt="شعار" className="w-full h-full object-cover" /> : <ImageIcon className="w-8 h-8 text-slate-400"/>}
                            </div>
                            <Input id="logo-upload" type="file" accept="image/*" onChange={(e) => handleFileChange(e, setLogoPreview, "شعار")} className="hidden" />
                            <Button variant="outline" onClick={() => { document.getElementById('logo-upload').click(); internalHandleFeatureClick("اختيار ملف شعار"); }}>رفع صورة</Button>
                        </div>
                        <p className="text-xs text-slate-500">الأبعاد الموصى بها: 200x200 بكسل، PNG أو JPG.</p>
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="banner-upload">البنر الرئيسي</Label>
                         <div className="flex items-center gap-4">
                            <div className="w-full h-20 rounded-lg bg-slate-100 flex items-center justify-center overflow-hidden">
                                {bannerPreview ? <img src={bannerPreview} alt="بنر" className="w-full h-full object-cover" /> : <ImageIcon className="w-8 h-8 text-slate-400"/>}
                            </div>
                            <Input id="banner-upload" type="file" accept="image/*" onChange={(e) => handleFileChange(e, setBannerPreview, "بنر")} className="hidden" />
                            <Button variant="outline" onClick={() => { document.getElementById('banner-upload').click(); internalHandleFeatureClick("اختيار ملف بنر"); }}>رفع صورة</Button>
                        </div>
                        <p className="text-xs text-slate-500">الأبعاد الموصى بها: 1200x400 بكسل، JPG أو PNG.</p>
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>الألوان والقوالب</CardTitle>
                    <CardDescription>اختر القالب والألوان التي تناسب هويتك البصرية لصفحتك على منصة ليلة الليليوم.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div>
                        <Label>اللون الرئيسي لصفحتك</Label>
                        <div className="flex items-center gap-2 mt-2">
                            {["#D946EF", "#f43f5e", "#f59e0b", "#334155"].map(color => (
                                <div 
                                    key={color}
                                    className={`w-10 h-10 rounded-lg cursor-pointer border-4 ${primaryColor === color ? 'border-white ring-2 ring-primary' : 'border-transparent'}`} 
                                    style={{ backgroundColor: color }}
                                    onClick={() => {setPrimaryColor(color); internalHandleFeatureClick(`تغيير اللون الأساسي إلى ${color}`)}}
                                ></div>
                            ))}
                            <Input type="color" value={primaryColor} className="w-12 h-10 p-1" onChange={(e) => {setPrimaryColor(e.target.value); internalHandleFeatureClick(`تغيير اللون الأساسي إلى ${e.target.value}`)}}/>
                        </div>
                    </div>
                    <div>
                        <Label>اختر قالب الصفحة</Label>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                            {themes.map(theme => (
                                <div key={theme.name} className={`cursor-pointer group ${selectedTheme === theme.name ? 'ring-2 ring-primary ring-offset-2 rounded-lg' : ''}`} onClick={() => {setSelectedTheme(theme.name); internalHandleFeatureClick(`تغيير القالب إلى ${theme.title}`)}}>
                                    <div className={`h-24 rounded-lg ${theme.preview} flex items-center justify-center group-hover:opacity-80 transition-all`}>
                                        <Paintbrush className="w-8 h-8 text-white/50"/>
                                    </div>
                                    <p className="text-center mt-2 font-semibold text-sm">{theme.title}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default AppearanceContent;