
import React from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Star, MessageSquare, SlidersHorizontal, ArrowUpDown } from 'lucide-react';
import { Progress } from "@/components/ui/progress";
import { Separator } from "@/components/ui/separator";
import { Textarea } from "@/components/ui/textarea";

const reviews = [
    { id: 1, customer: 'نورة القحطاني', avatar: 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?q=80&w=200', rating: 5, comment: 'تجربة رائعة ومنظمة! كل شيء كان مثالياً. فريق العمل كان متعاوناً جداً والمكان نظيف ومرتب. سأعود بالتأكيد.', date: '2025-06-11', event: 'معرض التقنية' },
    { id: 2, customer: 'محمد علي', avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200', rating: 4, comment: 'المكان جميل لكن كان مزدحمًا بعض الشيء. أقترح تحسين إدارة الحشود في المرات القادمة.', date: '2025-06-10', event: 'تجربة الغوص' },
    { id: 3, customer: 'خالد المصري', avatar: 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?q=80&w=200', rating: 2, comment: 'للأسف، الخدمة كانت بطيئة ولم تكن الطاولة جاهزة في الوقت المحدد. انتظرنا طويلاً.', date: '2025-06-09', event: 'حجز طاولة عشاء' },
    { id: 4, customer: 'سارة عبدالله', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200', rating: 5, comment: 'فريق عمل محترف وودود، استمتعت كثيراً.', date: '2025-06-08', event: 'ورشة عمل فنية' },
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

const ReviewsManagementContent = ({ handleFeatureClick }) => {
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
                                    <Button variant="outline" size="sm" onClick={() => handleFeatureClick("فرز")}><ArrowUpDown className="w-4 h-4 ml-2"/>الأحدث أولاً</Button>
                                    <Button variant="outline" size="sm" onClick={() => handleFeatureClick("فلترة")}><SlidersHorizontal className="w-4 h-4 ml-2"/>فلترة</Button>
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
                                            
                                            <div className="mt-4 space-y-3">
                                                 <Textarea placeholder={`اكتب ردك على ${review.customer}...`}/>
                                                 <Button size="sm" onClick={() => handleFeatureClick(`الرد على ${review.customer}`)}>
                                                    <MessageSquare className="w-4 h-4 ml-2" />
                                                    إرسال الرد
                                                 </Button>
                                            </div>
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
};

export default ReviewsManagementContent;
