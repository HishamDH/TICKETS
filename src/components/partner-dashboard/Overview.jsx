import React from 'react';
import { motion } from 'framer-motion';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { DollarSign, Users, Activity, BarChart2 } from 'lucide-react';
import { BarChart, Bar, XAxis, YAxis, Tooltip, Legend, ResponsiveContainer, CartesianGrid } from 'recharts';

const StatCard = ({ title, value, icon, description, color }) => {
    const Icon = icon;
    return (
        <Card className="shadow-lg hover:shadow-xl transition-shadow duration-300">
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle className="text-sm font-medium text-gray-500">{title}</CardTitle>
                <Icon className={`h-5 w-5 ${color}`} />
            </CardHeader>
            <CardContent>
                <div className="text-3xl font-bold">{value}</div>
                <p className="text-xs text-gray-500">{description}</p>
            </CardContent>
        </Card>
    );
};

const chartData = [
  { name: 'يناير', "العمولة": 2400, "التجار": 5 },
  { name: 'فبراير', "العمولة": 1398, "التجار": 3 },
  { name: 'مارس', "العمولة": 9800, "التجار": 12 },
  { name: 'أبريل', "العمولة": 3908, "التجار": 7 },
  { name: 'مايو', "العمولة": 4800, "التجار": 8 },
  { name: 'يونيو', "العمولة": 3800, "التجار": 6 },
];

const Overview = () => {
    return (
        <motion.div 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
            className="space-y-6"
        >
            <h1 className="text-3xl font-bold text-gray-800">نظرة عامة</h1>
            
            <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <StatCard 
                    title="إجمالي الأرباح" 
                    value="15,231.89 ر.س" 
                    icon={DollarSign}
                    description="+20.1% عن الشهر الماضي"
                    color="text-green-500"
                />
                <StatCard 
                    title="التجار المسجلون" 
                    value="+42" 
                    icon={Users}
                    description="إجمالي 115 تاجر"
                    color="text-blue-500"
                />
                <StatCard 
                    title="النشاط الأخير" 
                    value="5 تجار جدد" 
                    icon={Activity}
                    description="في آخر 7 أيام"
                    color="text-orange-500"
                />
            </div>

            <Card className="shadow-lg">
                <CardHeader>
                    <CardTitle className="flex items-center gap-2">
                        <BarChart2 className="w-6 h-6 text-primary"/>
                        <span>أداء الشهور الماضية</span>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div style={{ width: '100%', height: 300 }}>
                        <ResponsiveContainer>
                            <BarChart data={chartData} margin={{ top: 5, right: 20, left: -10, bottom: 5 }}>
                                <CartesianGrid strokeDasharray="3 3" />
                                <XAxis dataKey="name" />
                                <YAxis />
                                <Tooltip
                                    contentStyle={{ 
                                        borderRadius: "0.5rem",
                                        fontFamily: 'Cairo, sans-serif'
                                    }}
                                />
                                <Legend wrapperStyle={{ fontFamily: 'Cairo, sans-serif' }} />
                                <Bar dataKey="العمولة" fill="#f97316" name="العمولة (ر.س)"/>
                                <Bar dataKey="التجار" fill="#3b82f6" name="التجار الجدد"/>
                            </BarChart>
                        </ResponsiveContainer>
                    </div>
                </CardContent>
            </Card>
        </motion.div>
    );
};

export default Overview;