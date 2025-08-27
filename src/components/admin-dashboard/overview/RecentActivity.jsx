import React, { useState, useEffect } from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";

const allActivities = [
    { name: "علياء حسن", email: "aliaa@example.com", amount: "+3,150.00 ريال", action: "حجز جديد", category: 'venues' },
    { name: "يوسف خالد", email: "youssef@example.com", amount: "+1,200.00 ريال", action: "حجز جديد", category: 'catering' },
    { name: "نور أحمد", email: "nour@example.com", amount: "+500.00 ريال", action: "تجديد اشتراك", category: 'venues' },
    { name: "أحمد الغامدي", email: "ahmed@example.com", amount: "-250.00 ريال", action: "إلغاء حجز", category: 'catering' },
    { name: "سارة عبدالله", email: "sara@example.com", amount: "+8,500.00 ريال", action: "حجز جديد", category: 'venues' },
    { name: "محمد علي", email: "mohammed@example.com", amount: "+2,000.00 ريال", action: "حجز جديد", category: 'photography' },
];

const RecentActivity = ({ filters }) => {
    const [activities, setActivities] = useState(allActivities);

    useEffect(() => {
        setActivities(
            allActivities.filter(activity => 
                filters.category === 'all' || activity.category === filters.category
            ).slice(0, 5)
        );
    }, [filters]);

    return (
        <Card>
            <CardHeader>
                <CardTitle>الأنشطة الأخيرة</CardTitle>
                <CardDescription>تم تسجيل {activities.length} عملية جديدة هذا اليوم.</CardDescription>
            </CardHeader>
            <CardContent>
                <div className="space-y-8">
                    {activities.map((activity, index) => (
                        <div key={index} className="flex items-center">
                            <Avatar className="h-9 w-9">
                                <AvatarImage src={`https://source.unsplash.com/random/200x200?sig=${index}`} alt="Avatar" />
                                <AvatarFallback>{activity.name.charAt(0)}</AvatarFallback>
                            </Avatar>
                            <div className="ml-4 space-y-1">
                                <p className="text-sm font-medium leading-none">{activity.name}</p>
                                <p className="text-sm text-muted-foreground">{activity.email}</p>
                            </div>
                            <div className="ml-auto font-medium text-right">
                                <p className={activity.amount.startsWith('+') ? 'text-green-500' : 'text-red-500'}>{activity.amount}</p>
                                <p className="text-xs text-muted-foreground">{activity.action}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </CardContent>
        </Card>
    );
};

export default React.memo(RecentActivity);