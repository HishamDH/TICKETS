import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { QrCode, Eye, CheckCircle, XCircle, Ticket } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";

const CheckInSystem = () => {
  const { toast } = useToast();
  const [ticketNumber, setTicketNumber] = useState('');
  const [validationResult, setValidationResult] = useState(null);

  const handleFeatureClick = (featureName) => {
      toast({
          title: "🚧 ميزة قيد التطوير",
          description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
          variant: "default",
      });
  };

  const handleManualCheck = () => {
    if (!ticketNumber) {
        toast({
            title: "🤔 رقم الحجز فارغ",
            description: "الرجاء إدخال رقم الحجز أولاً للتحقق منه.",
            variant: "destructive",
        });
        setValidationResult(null);
        return;
    }
    // Mock validation logic
    if (ticketNumber === 'BK-12345') {
        setValidationResult({ 
            valid: true, 
            name: 'عبدالله الراجحي', 
            event: 'حفل زفاف (قاعة اللؤلؤة)', 
            date: '2025-07-10',
            guests: 2
        });
    } else if (ticketNumber === 'BK-USED') {
         setValidationResult({ 
            valid: false, 
            reason: 'التذكرة مستخدمة سابقًا.', 
            name: 'فاطمة الخالد', 
            event: 'معرض الفنون الحديثة'
        });
    } else {
        setValidationResult({ valid: false, reason: 'رقم الحجز غير صالح أو منتهي الصلاحية.' });
    }
    handleFeatureClick(`التحقق اليدوي من تذكرة: ${ticketNumber}`);
  };

  return (
    <div className="min-h-screen bg-primary/5 py-12">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="max-w-3xl mx-auto"
        >
          <div className="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-8 text-center border">
            <div className="w-24 h-24 gradient-bg rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
              <QrCode className="h-12 w-12 text-white" />
            </div>
            
            <h1 className="text-4xl font-bold gradient-text mb-4">نظام التحقق من الحجوزات</h1>
            <p className="text-gray-600 text-lg mb-8">امسح رمز QR أو أدخل رقم الحجز يدويًا للتحقق من صلاحية التذكرة بسرعة وأمان.</p>

            <div className="grid md:grid-cols-2 gap-8 mb-8">
                <Card className="text-right">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Ticket className="text-primary"/> التحقق اليدوي</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <Input 
                            placeholder="أدخل رقم الحجز (مثال: BK-12345)" 
                            value={ticketNumber}
                            onChange={(e) => setTicketNumber(e.target.value)}
                            className="text-lg p-3"
                        />
                        <Button className="w-full py-3 text-md" onClick={handleManualCheck}>تحقق الآن</Button>
                    </CardContent>
                </Card>
                <Card className="text-right">
                     <CardHeader>
                        <CardTitle className="flex items-center gap-2"><QrCode className="text-primary"/> مسح كود الحجز (QR)</CardTitle>
                    </CardHeader>
                    <CardContent className="flex flex-col items-center justify-center">
                        <div className="w-full h-40 bg-slate-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center mx-auto mb-4 overflow-hidden relative">
                            <div className="absolute top-0 left-0 w-full h-0.5 bg-primary animate-[scan_2s_ease-in-out_infinite]"></div>
                            <div className="text-center">
                                <QrCode className="h-16 w-16 text-gray-300 mx-auto mb-2" />
                                <p className="text-gray-500 text-sm">منطقة مسح الرمز</p>
                            </div>
                        </div>
                         <Button 
                            variant="outline"
                            className="w-full py-3 text-md"
                            onClick={() => handleFeatureClick('تفعيل الكاميرا لمسح QR')}
                          >
                            <Eye className="ml-2 h-5 w-5" />
                            تفعيل الكاميرا للمسح
                          </Button>
                    </CardContent>
                </Card>
            </div>
            
            {validationResult && (
                <motion.div
                    initial={{ opacity: 0, scale: 0.9 }}
                    animate={{ opacity: 1, scale: 1 }}
                    transition={{ duration: 0.3 }}
                    className={`mt-8 p-6 rounded-xl border-2 ${validationResult.valid ? 'bg-green-50 border-green-500' : 'bg-red-50 border-red-500'}`}
                >
                    <div className="flex items-center gap-3 mb-3">
                        {validationResult.valid ? 
                            <CheckCircle className="w-8 h-8 text-green-600" /> : 
                            <XCircle className="w-8 h-8 text-red-600" />
                        }
                        <h2 className={`text-2xl font-bold ${validationResult.valid ? 'text-green-700' : 'text-red-700'}`}>
                            {validationResult.valid ? 'الحجز صالح' : 'الحجز غير صالح'}
                        </h2>
                    </div>
                    {validationResult.valid ? (
                        <div className="text-green-800 space-y-1 text-right">
                            <p><strong>صاحب الحجز:</strong> {validationResult.name}</p>
                            <p><strong>الخدمة:</strong> {validationResult.event}</p>
                            <p><strong>التاريخ:</strong> {validationResult.date}</p>
                            <p><strong>عدد الأفراد:</strong> {validationResult.guests}</p>
                            <p className="font-semibold mt-2">تم تسجيل الحضور بنجاح!</p>
                        </div>
                    ) : (
                         <div className="text-red-800 space-y-1 text-right">
                            <p>{validationResult.reason}</p>
                            {validationResult.name && <p><strong>صاحب الحجز المحتمل:</strong> {validationResult.name}</p>}
                            {validationResult.event && <p><strong>الخدمة المحتملة:</strong> {validationResult.event}</p>}
                        </div>
                    )}
                </motion.div>
            )}


            <style>
              {`
                @keyframes scan {
                  0% { top: 0; }
                  100% { top: 100%; }
                }
              `}
            </style>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default CheckInSystem;