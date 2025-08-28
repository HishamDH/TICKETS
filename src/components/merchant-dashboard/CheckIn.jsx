
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { QrCode, Ticket, CheckCircle, XCircle } from 'lucide-react';
import { motion } from 'framer-motion';

const CheckInContent = ({ handleFeatureClick }) => {
    const [ticketNumber, setTicketNumber] = React.useState('');
    const [validationResult, setValidationResult] = React.useState(null);

    const handleValidate = () => {
        if (ticketNumber === '123456') {
            setValidationResult({ valid: true, name: 'نورة عبدالله', event: 'فعالية الشتاء' });
        } else if (ticketNumber === '') {
             setValidationResult(null);
        }
        else {
            setValidationResult({ valid: false, reason: 'التذكرة غير صالحة أو مستخدمة مسبقاً.' });
        }
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">التحقق من التذاكر</h2>
            </div>
            <div className="grid lg:grid-cols-2 gap-8">
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Ticket /> التحقق اليدوي</CardTitle>
                        <CardDescription>أدخل رقم التذكرة أو الحجز للتحقق من صلاحيته.</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <Input 
                            placeholder="أدخل رقم التذكرة..." 
                            value={ticketNumber}
                            onChange={(e) => setTicketNumber(e.target.value)}
                        />
                        <Button className="w-full gradient-bg text-white" onClick={handleValidate}>
                            تحقق الآن
                        </Button>
                    </CardContent>
                </Card>
                <Card className="flex flex-col items-center justify-center bg-slate-50 border-dashed">
                    <CardHeader>
                         <CardTitle className="flex items-center gap-2"><QrCode /> مسح الكود</CardTitle>
                    </CardHeader>
                    <CardContent className="text-center">
                       <img  alt="QR Code Scanner" className="w-32 h-32 mx-auto mb-4" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example" />
                        <Button variant="outline" onClick={() => handleFeatureClick("Scan QR")}>
                           فتح كاميرا المسح
                        </Button>
                    </CardContent>
                </Card>
            </div>

            {validationResult && (
                <motion.div
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                >
                    <Card className={validationResult.valid ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50'}>
                        <CardHeader>
                            <CardTitle className={`flex items-center gap-3 ${validationResult.valid ? 'text-green-800' : 'text-red-800'}`}>
                                {validationResult.valid ? <CheckCircle /> : <XCircle />}
                                {validationResult.valid ? 'التذكرة صالحة' : 'التذكرة غير صالحة'}
                            </CardTitle>
                        </CardHeader>
                        <CardContent className={validationResult.valid ? 'text-green-700' : 'text-red-700'}>
                            {validationResult.valid ? (
                                <div className="space-y-2">
                                    <p><strong>حامل التذكرة:</strong> {validationResult.name}</p>
                                    <p><strong>الفعالية:</strong> {validationResult.event}</p>
                                    <p>تم تسجيل الدخول بنجاح.</p>
                                </div>
                            ) : (
                                <p>{validationResult.reason}</p>
                            )}
                        </CardContent>
                    </Card>
                </motion.div>
            )}
        </div>
    );
};

export default CheckInContent;
