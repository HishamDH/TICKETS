import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { QrCode, Ticket, CheckCircle, XCircle, User, Calendar, Package } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { format } from "date-fns";
import { ar } from "date-fns/locale";

const mockBookings = {
    'BK-12345': { name: 'عبدالله الأحمد', date: new Date(), service: 'الباقة الذهبية', status: 'valid' },
    'BK-67890': { name: 'فاطمة الزهراني', date: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000), service: 'باقة تصوير', status: 'expired' },
    'BK-54321': { name: 'محمد الغامدي', date: new Date(), service: 'الباقة الفضية', status: 'used' },
};

const CheckInContent = ({ handleFeatureClick }) => {
    const { toast } = useToast();
    const [bookingCode, setBookingCode] = useState('');
    const [bookingResult, setBookingResult] = useState(null);

    const handleCheckIn = () => {
        const result = mockBookings[bookingCode];
        setBookingResult(result || { status: 'not_found' });
        
        if (result) {
            handleFeatureClick(`تحقق من حجز: ${bookingCode} - ${result.status}`);
        } else {
            handleFeatureClick(`تحقق من حجز: ${bookingCode} - لم يوجد`);
        }
    };

    const renderResult = () => {
        if (!bookingResult) return null;

        if (bookingResult.status === 'not_found') {
            return (
                <div className="mt-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <div className="flex items-center gap-2">
                        <XCircle />
                        <p className="font-bold">الحجز غير موجود</p>
                    </div>
                    <p>الرجاء التأكد من الرمز المدخل.</p>
                </div>
            );
        }

        const statusInfo = {
            valid: { text: 'صالح للاستخدام', icon: <CheckCircle className="text-green-500" />, color: 'green' },
            expired: { text: 'منتهي الصلاحية', icon: <XCircle className="text-red-500" />, color: 'red' },
            used: { text: 'تم استخدامه مسبقاً', icon: <XCircle className="text-yellow-500" />, color: 'yellow' },
        };

        const currentStatus = statusInfo[bookingResult.status];

        return (
            <Card className={`mt-6 border-${currentStatus.color}-500`}>
                <CardHeader>
                    <CardTitle className={`flex items-center gap-2 text-${currentStatus.color}-600`}>
                        {currentStatus.icon}
                        نتيجة التحقق: {currentStatus.text}
                    </CardTitle>
                </CardHeader>
                <CardContent className="space-y-2">
                    <div className="flex items-center gap-2"><User className="w-5 h-5 text-slate-500" /><strong>العميل:</strong> {bookingResult.name}</div>
                    <div className="flex items-center gap-2"><Package className="w-5 h-5 text-slate-500" /><strong>الخدمة:</strong> {bookingResult.service}</div>
                    <div className="flex items-center gap-2"><Calendar className="w-5 h-5 text-slate-500" /><strong>التاريخ:</strong> {format(new Date(bookingResult.date), 'PPP', { locale: ar })}</div>
                </CardContent>
            </Card>
        );
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">التحقق من الحضور (Check-in)</h2>
            <Card>
                <CardHeader>
                    <CardTitle>التحقق من الحجوزات</CardTitle>
                    <CardDescription>أدخل رمز الحجز للتحقق من صلاحيته وتسجيل حضور العميل.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="flex items-center gap-2">
                        <div className="relative flex-grow">
                            <Ticket className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" />
                            <Input 
                                placeholder="أدخل رمز الحجز هنا..." 
                                className="pl-10"
                                value={bookingCode}
                                onChange={(e) => setBookingCode(e.target.value.toUpperCase())}
                            />
                        </div>
                        <Button onClick={handleCheckIn}>تحقق الآن</Button>
                    </div>
                    {renderResult()}
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle>استخدام كاميرا الجوال</CardTitle>
                </CardHeader>
                <CardContent className="text-center">
                    <QrCode className="w-24 h-24 mx-auto text-slate-300 mb-4" />
                    <Button variant="outline" onClick={() => handleFeatureClick("فتح كاميرا QR")}>
                        فتح الكاميرا لمسح QR Code
                    </Button>
                    <p className="text-xs text-slate-500 mt-2">هذه الميزة تتطلب موافقة على استخدام الكاميرا.</p>
                </CardContent>
            </Card>
        </div>
    );
};

export default CheckInContent;