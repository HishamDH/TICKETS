
import React from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid } from 'recharts';
import { Button } from '@/components/ui/button';
import { Download } from 'lucide-react';

const data = [
    { name: 'يناير', revenue: 4000 },
    { name: 'فبراير', revenue: 3000 },
    { name: 'مارس', revenue: 5000 },
    { name: 'أبريل', revenue: 4500 },
    { name: 'مايو', revenue: 6000 },
    { name: 'يونيو', revenue: 5500 },
];

const CustomTooltip = ({ active, payload, label }) => {
  if (active && payload && payload.length) {
    return (
      <div className="bg-white p-2 border rounded-lg shadow-lg">
        <p className="font-bold">{label}</p>
        <p className="text-emerald-500">{`الإيرادات: ${payload[0].value.toLocaleString()} ريال`}</p>
      </div>
    );
  }

  return null;
};

const RevenueChart = ({ handleFeatureClick }) => {
    return (
        <Card>
            <CardHeader className="flex flex-row items-center justify-between">
                <div>
                    <CardTitle>نظرة على الإيرادات</CardTitle>
                    <CardDescription>آخر 6 أشهر</CardDescription>
                </div>
                <Button variant="outline" size="sm" onClick={() => handleFeatureClick("Download Report")}>
                    <Download className="h-4 w-4 ml-2" />
                    تصدير التقرير
                </Button>
            </CardHeader>
            <CardContent>
                <div className="h-80 w-full">
                    <ResponsiveContainer width="100%" height="100%">
                        <BarChart data={data} margin={{ top: 5, right: 20, left: -10, bottom: 5 }}>
                            <CartesianGrid strokeDasharray="3 3" vertical={false} />
                            <XAxis dataKey="name" stroke="#888888" fontSize={12} tickLine={false} axisLine={false} />
                            <YAxis stroke="#888888" fontSize={12} tickLine={false} axisLine={false} tickFormatter={(value) => `${value / 1000} ألف`} />
                            <Tooltip content={<CustomTooltip />} cursor={{ fill: 'rgba(16, 185, 129, 0.1)' }} />
                            <Bar dataKey="revenue" fill="var(--color-primary)" radius={[4, 4, 0, 0]} />
                        </BarChart>
                    </ResponsiveContainer>
                </div>
            </CardContent>
        </Card>
    );
};

export default RevenueChart;
