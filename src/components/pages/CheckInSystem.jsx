import React from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { QrCode, Eye } from 'lucide-react';

const CheckInSystem = ({ handleFeatureClick }) => {
  return (
    <div className="min-h-screen bg-primary/5 py-12">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="max-w-2xl mx-auto"
        >
          <div className="bg-white/70 backdrop-blur-xl rounded-2xl shadow-xl p-8 text-center border">
            <div className="w-24 h-24 gradient-bg rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
              <QrCode className="h-12 w-12 text-white" />
            </div>
            
            <h1 className="text-4xl font-bold gradient-text mb-4">نظام التحقق</h1>
            <p className="text-gray-600 text-lg mb-8">امسح رمز QR للتحقق من صحة التذكرة بسرعة وأمان</p>

            <div className="bg-slate-100 rounded-xl p-8 mb-8">
              <div className="w-full h-48 bg-white rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center mx-auto mb-4 overflow-hidden relative">
                <div className="absolute top-0 left-0 w-full h-0.5 bg-primary animate-[scan_2s_ease-in-out_infinite]"></div>
                <div className="text-center">
                  <QrCode className="h-16 w-16 text-gray-300 mx-auto mb-2" />
                  <p className="text-gray-500 text-sm">منطقة مسح الرمز</p>
                </div>
              </div>
              <p className="text-gray-600 text-sm">وجه الكاميرا نحو رمز QR الموجود على التذكرة</p>
            </div>

            <style>
              {`
                @keyframes scan {
                  0% { top: 0; }
                  100% { top: 100%; }
                }
              `}
            </style>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
              <Button 
                size="lg"
                className="bg-green-500 hover:bg-green-600 text-white w-full py-6 text-lg"
                onClick={() => handleFeatureClick('تفعيل الكاميرا')}
              >
                <Eye className="ml-2 h-5 w-5" />
                تفعيل الكاميرا
              </Button>
              <Button 
                size="lg"
                variant="outline"
                className="w-full py-6 text-lg"
                onClick={() => handleFeatureClick('إدخال يدوي')}
              >
                إدخال يدوي
              </Button>
            </div>

            <div className="bg-primary/10 border border-primary/20 rounded-lg p-4 text-right">
              <h3 className="font-semibold text-primary/90 mb-3">حالات التذكرة:</h3>
              <div className="space-y-2 text-sm">
                <div className="flex items-center justify-between p-2 rounded bg-green-100/50">
                  <span className="font-medium text-green-700">✓ صالحة</span>
                  <span className="text-gray-600">يمكن الدخول</span>
                </div>
                <div className="flex items-center justify-between p-2 rounded bg-red-100/50">
                  <span className="font-medium text-red-700">✗ مستخدمة</span>
                  <span className="text-gray-600">تم استخدامها مسبقاً</span>
                </div>
                <div className="flex items-center justify-between p-2 rounded bg-orange-100/50">
                  <span className="font-medium text-orange-700">⚠ ملغاة</span>
                  <span className="text-gray-600">تذكرة ملغاة</span>
                </div>
              </div>
            </div>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default CheckInSystem;