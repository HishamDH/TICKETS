
import React from 'react';
import { motion } from 'framer-motion';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

const StatCard = ({ title, value, icon: Icon, color, bgColor, handleFeatureClick }) => {
    return (
        <motion.div
            whileHover={{ y: -5, boxShadow: "0px 10px 20px rgba(0,0,0,0.08)" }}
            transition={{ type: "spring", stiffness: 300 }}
            onClick={() => handleFeatureClick(title)}
        >
            <Card className="overflow-hidden cursor-pointer">
                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle className="text-sm font-medium text-slate-600">{title}</CardTitle>
                    <div className={`p-2 rounded-md ${bgColor}`}>
                        <Icon className={`w-5 h-5 ${color}`} />
                    </div>
                </CardHeader>
                <CardContent>
                    <div className="text-3xl font-bold text-slate-800">{value}</div>
                </CardContent>
            </Card>
        </motion.div>
    );
};

export default StatCard;
