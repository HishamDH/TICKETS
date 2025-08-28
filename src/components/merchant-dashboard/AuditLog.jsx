import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { FilePlus, LogIn, UserCog, Wallet } from 'lucide-react';

const auditLogs = [
    { icon: FilePlus, action: 'إضافة فعالية جديدة', details: 'معرض التقنية 2025', user: 'علياء حسن', time: 'قبل 10 دقائق', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200' },
    { icon: Wallet, action: 'طلب سحب جديد', details: 'مبلغ 2,500 ريال', user: 'أنت', time: 'قبل ساعتين', avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200' },
    { icon: UserCog, action: 'تعديل صلاحيات موظف', details: 'يوسف خالد -> دعم', user: 'علياء حسن', time: 'أمس', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200' },
    { icon: LogIn, action: 'تسجيل دخول ناجح', details: 'من جهاز مكتبي (Chrome)', user: 'أنت', time: 'أمس', avatar: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200' },
];

const AuditLogContent = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">سجل الأنشطة</h2>
            <Card>
                <CardHeader>
                    <CardTitle>سجل العمليات</CardTitle>
                    <CardDescription>تتبع كل التغييرات والعمليات التي تمت في حسابك.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="relative">
                        <div className="absolute left-5 top-0 h-full w-0.5 bg-slate-200"></div>
                        <div className="space-y-8">
                            {auditLogs.map((log, index) => (
                                <div key={index} className="flex items-start gap-4 relative">
                                    <div className="w-11 h-11 bg-primary/10 rounded-full flex items-center justify-center z-10 ring-4 ring-slate-100">
                                        <log.icon className="w-5 h-5 text-primary" />
                                    </div>
                                    <div className="flex-1 pt-2">
                                        <div className="flex justify-between items-center">
                                            <div>
                                                <p className="font-semibold text-slate-800">{log.action}: <span className="font-normal text-slate-600">{log.details}</span></p>
                                                <div className="flex items-center gap-2 text-sm text-slate-500 mt-1">
                                                    <Avatar className="w-6 h-6">
                                                        <AvatarImage src={log.avatar} />
                                                        <AvatarFallback>{log.user.charAt(0)}</AvatarFallback>
                                                    </Avatar>
                                                    <span>{log.user}</span>
                                                </div>
                                            </div>
                                            <p className="text-sm text-slate-400">{log.time}</p>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default AuditLogContent;