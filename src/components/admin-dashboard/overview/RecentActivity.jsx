
import React from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { ArrowLeft } from 'lucide-react';

const activities = [
    { name: 'متجر الزهور', action: 'طلب سحب جديد بقيمة 500 ريال', time: 'قبل 5 دقائق', avatar: 'https://images.unsplash.com/photo-1596854307809-6e754c522f95?q=80&w=200' },
    { name: 'مطعم أكلات بحرية', action: 'تحديث بيانات الحساب البنكي', time: 'قبل 15 دقيقة', avatar: 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?q=80&w=200' },
    { name: 'فعالية إطلاق المنتج', action: 'تمت الموافقة على الفعالية', time: 'قبل ساعة', avatar: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=200' },
    { name: 'أحمد (دعم فني)', action: 'أغلق تذكرة دعم #1123', time: 'قبل 3 ساعات', avatar: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=200' },
];

const RecentActivity = ({ handleFeatureClick }) => {
    return (
        <Card className="h-full flex flex-col">
            <CardHeader>
                <CardTitle>أحدث الأنشطة</CardTitle>
                <CardDescription>آخر العمليات التي تمت في المنصة.</CardDescription>
            </CardHeader>
            <CardContent className="flex-grow">
                <div className="space-y-6">
                    {activities.map((activity, index) => (
                        <div key={index} className="flex items-start gap-4">
                            <Avatar>
                                <AvatarImage src={activity.avatar} />
                                <AvatarFallback>{activity.name.charAt(0)}</AvatarFallback>
                            </Avatar>
                            <div>
                                <p className="text-sm font-medium text-slate-800">{activity.name}</p>
                                <p className="text-sm text-slate-500">{activity.action}</p>
                                <p className="text-xs text-slate-400">{activity.time}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </CardContent>
            <div className="p-4 border-t">
                 <Button variant="ghost" className="w-full" onClick={() => handleFeatureClick("View All Activities")}>
                    عرض كل الأنشطة <ArrowLeft className="w-4 h-4 mr-2" />
                </Button>
            </div>
        </Card>
    );
};

export default RecentActivity;
