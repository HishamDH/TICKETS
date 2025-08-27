import React, { useState, useEffect, memo } from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Star, MessageSquare, SlidersHorizontal, ArrowUpDown } from 'lucide-react';
import { Progress } from "@/components/ui/progress";
import { Separator } from "@/components/ui/separator";
import { Textarea } from "@/components/ui/textarea";
import { useToast } from "@/components/ui/use-toast";

const initialReviews = [
    { id: 1, customer: 'نورة القحطاني', avatar: 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?q=80&w=200', rating: 5, comment: 'تجربة رائعة ومنظمة! كل شيء كان مثالياً. فريق العمل كان متعاوناً جداً والمكان نظيف ومرتب. سأعود بالتأكيد.', date: '2025-06-11', event: 'معرض التقنية', reply: '' },
    { id: 2, customer: 'محمد علي', avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200', rating: 4, comment: 'المكان جميل لكن كان مزدحمًا بعض الشيء. أقترح تحسين إدارة الحشود في المرات القادمة.', date: '2025-06-10', event: 'تجربة الغوص', reply: 'شكراً لملاحظتك أستاذ محمد، سنأخذها بعين الاعتبار لتحسين تجربتكم مستقبلاً.' },
    { id: 3, customer: 'خالد المصري', avatar: 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?q=80&w=200', rating: 2, comment: 'للأسف، الخدمة كانت بطيئة ولم تكن الطاولة جاهزة في الوقت المحدد. انتظرنا طويلاً.', date: '2025-06-09', event: 'حجز طاولة عشاء', reply: '' },
    { id: 4, customer: 'سارة عبدالله', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200', rating: 5, comment: 'فريق عمل محترف وودود، استمتعت كثيراً.', date: '2025-06-08', event: 'ورشة عمل فنية', reply: '' },
];

const ratingDistribution = [
    { stars: 5, count: 125, color: "bg-green-500" },
    { stars: 4, count: 68, color: "bg-lime-500" },
    { stars: 3, count: 22, color: "bg-yellow-500" },
    { stars: 2, count: 5, color: "bg-orange-500" },
    { stars: 1, count: 2, color: "bg-red-500" },
];
const totalReviews = ratingDistribution.reduce((acc, item) => acc + item.count, 0);

const StarRating = ({ rating }) => (
    <div className="flex items-center gap-1">
        {[...Array(5)].map((_, i) => (
            <Star key={i} className={`w-5 h-5 ${i < rating ? 'text-amber-400 fill-amber-400' : 'text-slate-300'}`} />
        ))}
    </div>
);

const ReviewsManagementContent = memo(({ handleFeatureClick: propHandleFeatureClick }) => {
    const { toast } = useToast();
    const [reviews, setReviews] = useState(JSON.parse(localStorage.getItem('lilium_night_reviews_v1')) || initialReviews);
    const [replyTexts, setReplyTexts] = useState({});

    useEffect(() => {
        localStorage.setItem('lilium_night_reviews_v1', JSON.stringify(reviews));
    }, [reviews]);

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

    const handleReplyChange = (reviewId, text) => {
        setReplyTexts(prev => ({ ...prev, [reviewId]: text }));
    };

    const handleSendReply = (reviewId) => {
        const replyText = replyTexts[reviewId];
        if (!replyText || !replyText.trim()) {
            toast({ title: "خطأ", description: "لا يمكن إرسال رد فارغ.", variant: "destructive" });
            return;
        }
        setReviews(prevReviews => prevReviews.map(review => 
            review.id === reviewId ? { ...review, reply: replyText } : review
        ));
        setReplyTexts(prev => ({ ...prev, [reviewId]: '' })); 
        handleFeatureClick(`إرسال رد على تقييم العميل ${reviewId}`);
    };
    
    const handleSortFilterClick = (featureName) => {
         handleFeatureClick(featureName);
    };


    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">مراجعات العملاء</h2>
            
            <div className="grid lg:grid-cols-3 gap-8">
                <Card className="lg:col-span-1">
                    <CardHeader>
                        <CardTitle>ملخص التقييمات</CardTitle>
                        <CardDescription>نظرة سريعة على آراء عملائك.</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-6">
                        <div className="flex flex-col items-center justify-center gap-2">
                           <p className="text-5xl font-bold text-slate-800">4.4</p>
                           <StarRating rating={4} />
                           <p className="text-sm text-slate-500">بناءً على {totalReviews} تقييم</p>
                        </div>
                        <Separator />
                        <div className="space-y-3">
                            {ratingDistribution.map(item => (
                                <div key={item.stars} className="flex items-center gap-3">
                                    <span className="text-sm font-medium text-slate-500">{item.stars} نجوم</span>
                                    <Progress value={(item.count / totalReviews) * 100} className={`h-2 ${item.color}`} />
                                    <span className="text-sm font-semibold text-slate-700 w-10 text-left">{item.count}</span>
                                </div>
                            ))}
                        </div>
                    </CardContent>
                </Card>

                <div className="lg:col-span-2 space-y-6">
                    <Card>
                         <CardHeader>
                            <div className="flex justify-between items-center">
                                <CardTitle>قائمة المراجعات ({reviews.length})</CardTitle>
                                <div className="flex gap-2">
                                    <Button variant="outline" size="sm" onClick={() => handleSortFilterClick("فرز التقييمات")}><ArrowUpDown className="w-4 h-4 ml-2"/>الأحدث أولاً</Button>
                                    <Button variant="outline" size="sm" onClick={() => handleSortFilterClick("فلترة التقييمات")}><SlidersHorizontal className="w-4 h-4 ml-2"/>فلترة</Button>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent className="space-y-6">
                            {reviews.map(review => (
                                <div key={review.id} className="space-y-4 border-b pb-4 last:border-0 last:pb-0">
                                    <div className="flex items-start gap-4">
                                        <Avatar>
                                            <AvatarImage src={review.avatar} />
                                            <AvatarFallback>{review.customer.charAt(0)}</AvatarFallback>
                                        </Avatar>
                                        <div className="flex-1">
                                            <div className="flex justify-between items-start">
                                                <div>
                                                    <p className="font-semibold text-slate-800">{review.customer}</p>
                                                    <p className="text-xs text-slate-500">{review.date} • على خدمة "{review.event}"</p>
                                                </div>
                                                <StarRating rating={review.rating} />
                                            </div>
                                            <p className="mt-2 text-slate-600 leading-relaxed">{review.comment}</p>
                                            
                                            {review.reply && (
                                                <div className="mt-3 p-3 bg-slate-100 rounded-md">
                                                    <p className="text-sm font-semibold text-primary">ردك:</p>
                                                    <p className="text-sm text-slate-700">{review.reply}</p>
                                                </div>
                                            )}

                                            {!review.reply && (
                                                <div className="mt-4 space-y-3">
                                                    <Textarea 
                                                        placeholder={`اكتب ردك على ${review.customer}...`}
                                                        value={replyTexts[review.id] || ''}
                                                        onChange={(e) => handleReplyChange(review.id, e.target.value)}
                                                    />
                                                    <Button size="sm" onClick={() => handleSendReply(review.id)}>
                                                        <MessageSquare className="w-4 h-4 ml-2" />
                                                        إرسال الرد
                                                    </Button>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    );
});

export default ReviewsManagementContent;