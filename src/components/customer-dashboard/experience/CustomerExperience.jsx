import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Star, Repeat, Send, Edit, Trash2 } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';

const initialExperiencesData = [
    { id: 'exp1', title: 'حفل زفاف الأحلام في قاعة الأفراح الملكية', date: 'ديسمبر 2025', image: 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?q=80&w=300', rating: 5, review: 'كان كل شيء مثالياً! فريق العمل رائع والقاعة فاخرة.' },
    { id: 'exp2', title: 'تغطية تصوير مميزة لحفل التخرج', date: 'أكتوبر 2025', image: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=300', rating: 4, review: 'المصور كان محترفاً والصور جميلة، لكن التسليم تأخر قليلاً.' },
    { id: 'exp3', title: 'بوفيه عشاء فاخر لمناسبة عائلية', date: 'سبتمبر 2025', image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=300', rating: 0, review: '' },
];

const StarRatingInput = ({ rating, setRating }) => (
    <div className="flex gap-1">
        {[1,2,3,4,5].map(star => (
            <Star key={star} className={`w-7 h-7 cursor-pointer ${star <= rating ? 'text-amber-400 fill-amber-400' : 'text-slate-300'}`} onClick={() => setRating(star)} />
        ))}
    </div>
);

const ExperienceCard = ({ exp, onEditReview, onDeleteReview, handleFeatureClick }) => {
    const { toast } = useToast();
    const handleShare = () => {
        navigator.clipboard.writeText(`لقد استمتعت بـ ${exp.title} مع ليلة الليليوم!`);
        toast({title: "تم نسخ الرابط", description: "يمكنك الآن مشاركة تجربتك."});
        handleFeatureClick(`مشاركة تجربة ${exp.title}`);
    };
    const handleRebook = () => {
        toast({title: "إعادة الحجز", description: `سيتم توجيهك لإعادة حجز ${exp.title}.`});
        handleFeatureClick(`إعادة حجز ${exp.title}`);
    };

    return (
    <Card>
        <div className="relative">
            <img src={exp.image} alt={exp.title} className="w-full h-48 object-cover rounded-t-lg"/>
            <div className="absolute inset-0 bg-black/40 rounded-t-lg"></div>
            <div className="absolute bottom-2 right-2 text-white p-2">
                <h3 className="font-bold text-lg">{exp.title}</h3>
                <p className="text-sm">{exp.date}</p>
            </div>
        </div>
        <CardContent className="p-4 space-y-3">
            {exp.rating > 0 && (
                <div className="flex items-center gap-2">
                    <StarRatingInput rating={exp.rating} setRating={() => {}} /> 
                    <span className="text-sm text-slate-600">({exp.rating} نجوم)</span>
                </div>
            )}
            {exp.review && <p className="text-sm text-slate-700 italic">"{exp.review}"</p>}
            
            <div className="flex gap-2 pt-2 border-t">
                <Button className="flex-1" variant={exp.rating > 0 ? "outline" : "default"} onClick={() => onEditReview(exp)}>
                    {exp.rating > 0 ? <Edit className="w-4 h-4 ml-2"/> : <Star className="w-4 h-4 ml-2"/>}
                    {exp.rating > 0 ? 'تعديل المراجعة' : 'إضافة مراجعة'}
                </Button>
                <Button variant="outline" size="icon" onClick={handleRebook} title="إعادة الحجز"><Repeat className="w-4 h-4"/></Button>
                <Button variant="outline" size="icon" onClick={handleShare} title="مشاركة التجربة"><Send className="w-4 h-4"/></Button>
                {exp.rating > 0 && <Button variant="ghost" size="icon" className="text-red-500" onClick={() => onDeleteReview(exp.id)} title="حذف المراجعة"><Trash2 className="w-4 h-4"/></Button>}
            </div>
        </CardContent>
    </Card>
    );
};

const CustomerExperience = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [experiences, setExperiences] = useState(() => {
        const savedExperiences = localStorage.getItem('lilium_customer_experiences_v1');
        return savedExperiences ? JSON.parse(savedExperiences) : initialExperiencesData;
    });
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [currentExperience, setCurrentExperience] = useState(null);
    const [reviewText, setReviewText] = useState('');
    const [reviewRating, setReviewRating] = useState(0);

    useEffect(() => {
        localStorage.setItem('lilium_customer_experiences_v1', JSON.stringify(experiences));
    }, [experiences]);
    
    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick) {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };


    const openReviewModal = (exp) => {
        setCurrentExperience(exp);
        setReviewRating(exp.rating || 0);
        setReviewText(exp.review || '');
        setIsModalOpen(true);
        handleFeatureClick(`فتح نافذة مراجعة لـ ${exp.title}`);
    };

    const handleSubmitReview = () => {
        if (!currentExperience || reviewRating === 0) {
            toast({title: "خطأ", description: "الرجاء اختيار تقييم (عدد النجوم).", variant: "destructive"});
            return;
        }
        setExperiences(prev => prev.map(exp => 
            exp.id === currentExperience.id ? {...exp, rating: reviewRating, review: reviewText} : exp
        ));
        toast({title: "تم حفظ المراجعة", description: `تم ${currentExperience.rating > 0 ? 'تحديث' : 'إضافة'} مراجعتك لـ ${currentExperience.title}.`});
        handleFeatureClick(`حفظ مراجعة لـ ${currentExperience.title}`);
        setIsModalOpen(false);
    };

    const handleDeleteReview = (expId) => {
         setExperiences(prev => prev.map(exp => 
            exp.id === expId ? {...exp, rating: 0, review: ''} : exp
        ));
        toast({title: "تم حذف المراجعة", description: `تم حذف مراجعتك.`});
        const expTitle = experiences.find(e => e.id === expId)?.title || 'المراجعة';
        handleFeatureClick(`حذف مراجعة لـ ${expTitle}`);
    };

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">تجربتي مع ليلة الليليوم</h1>
                <p className="text-slate-500 mt-1">استعرض تجاربك السابقة في تنظيم مناسباتك وشاركها مع الآخرين.</p>
            </div>
            {experiences.length > 0 ? (
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {experiences.map(exp => <ExperienceCard key={exp.id} exp={exp} onEditReview={openReviewModal} onDeleteReview={handleDeleteReview} handleFeatureClick={handleFeatureClick} />)}
                </div>
            ) : (
                <Card className="text-center py-12">
                    <CardContent>
                        <Star className="w-16 h-16 mx-auto text-slate-300 mb-4" />
                        <p className="text-xl font-semibold text-slate-600">لا توجد تجارب سابقة بعد.</p>
                        <p className="text-slate-500">بعد إتمام حجوزاتك، ستظهر هنا لتتمكن من تقييمها.</p>
                    </CardContent>
                </Card>
            )}

            {currentExperience && (
                <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
                    <DialogContent dir="rtl">
                        <DialogHeader>
                            <DialogTitle>{currentExperience.rating > 0 ? 'تعديل مراجعة' : 'إضافة مراجعة'} لـ "{currentExperience.title}"</DialogTitle>
                            <DialogDescription>شاركنا رأيك حول تجربتك.</DialogDescription>
                        </DialogHeader>
                        <div className="py-4 space-y-3">
                            <div>
                                <Label>تقييمك (عدد النجوم):</Label>
                                <StarRatingInput rating={reviewRating} setRating={setReviewRating} />
                            </div>
                            <div>
                                <Label htmlFor="reviewTextModal">ملاحظاتك (اختياري):</Label>
                                <Textarea id="reviewTextModal" value={reviewText} onChange={(e) => setReviewText(e.target.value)} placeholder="صف تجربتك مع الخدمة..." className="min-h-[100px]" />
                            </div>
                        </div>
                        <DialogFooter className="gap-2">
                            <DialogClose asChild><Button variant="ghost">إلغاء</Button></DialogClose>
                            <Button onClick={handleSubmitReview} disabled={reviewRating === 0}>حفظ المراجعة</Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>
            )}
        </div>
    );
};

export default CustomerExperience;