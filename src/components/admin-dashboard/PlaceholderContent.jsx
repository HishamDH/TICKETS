import React from 'react';
import { motion } from 'framer-motion';
import { Wrench } from 'lucide-react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

const PlaceholderContent = ({ title, icon: Icon }) => {
    return (
        <motion.div
            className="flex flex-col items-center justify-center h-full text-center"
            initial={{ opacity: 0, scale: 0.95 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.5 }}
        >
            <Card className="w-full max-w-lg shadow-xl">
                <CardHeader>
                    <div className="mx-auto w-16 h-16 mb-4 bg-primary/10 rounded-full flex items-center justify-center">
                        {Icon ? <Icon className="w-8 h-8 text-primary" /> : <Wrench className="w-8 h-8 text-primary" />}
                    </div>
                    <CardTitle className="text-2xl font-bold text-slate-800">{title}</CardTitle>
                </CardHeader>
                <CardContent>
                    <p className="text-slate-500 mb-6">
                        هذه الميزة قيد التطوير حاليًا. فريقنا يعمل بجد لإطلاقها قريبًا!
                    </p>
                    <p className="text-sm text-slate-400">
                        يمكنك طلب تسريع تطوير هذه الميزة في رسالتك التالية. 🚀
                    </p>
                </CardContent>
            </Card>
        </motion.div>
    );
};

export default PlaceholderContent;