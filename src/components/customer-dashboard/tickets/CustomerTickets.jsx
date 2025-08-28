
import React from 'react';
import { Card, CardContent } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Download, PlusCircle } from 'lucide-react';
import { Badge } from '@/components/ui/badge';

const TicketCard = ({ event, type, status, handleFeatureClick }) => (
    <Card className="overflow-hidden">
        <div className="p-4 bg-slate-50 border-b">
            <h3 className="font-bold text-lg">{event}</h3>
            <p className="text-sm text-slate-500">{type}</p>
        </div>
        <CardContent className="p-4 space-y-4">
            <div className="flex justify-center">
                 <img  alt="QR Code" class="w-32 h-32" src="https://images.unsplash.com/photo-1698230179591-7ed9924832f6" />
            </div>
            <Badge variant={status === 'صالحة' ? 'default' : 'destructive'} className="w-full justify-center">{status}</Badge>
            <div className="flex gap-2">
                <Button variant="outline" className="w-full" onClick={() => handleFeatureClick("Download")}><Download className="w-4 h-4 ml-2" /> تحميل</Button>
                <Button className="w-full" onClick={() => handleFeatureClick("Add to Wallet")}><PlusCircle className="w-4 h-4 ml-2" /> إضافة للمحفظة</Button>
            </div>
        </CardContent>
    </Card>
);

const CustomerTickets = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">تذاكري وبادجاتي</h1>
                <p className="text-slate-500 mt-1">عرض وتحميل جميع تذاكرك الصالحة.</p>
            </div>
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <TicketCard event="فعالية الشتاء" type="تذكرة دخول" status="صالحة" handleFeatureClick={handleFeatureClick}/>
                <TicketCard event="مؤتمر TechCon" type="Badge - وصول كامل" status="مستخدمة" handleFeatureClick={handleFeatureClick}/>
                <TicketCard event="مطعم الذواقة" type="تأكيد حجز طاولة" status="صالحة" handleFeatureClick={handleFeatureClick}/>
            </div>
        </div>
    );
};

export default CustomerTickets;
