import React, { useState, useEffect } from 'react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Bar, BarChart, ResponsiveContainer, XAxis, YAxis, Tooltip } from "recharts";

const initialData = [
    { name: "ينا", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "فبر", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "مار", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "ابر", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "ماي", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "يون", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "يول", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "اغس", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "سبت", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "اكت", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "نوف", total: Math.floor(Math.random() * 5000) + 1000 },
    { name: "ديس", total: Math.floor(Math.random() * 5000) + 1000 },
];

const RevenueChart = ({ filters }) => {
    const [data, setData] = useState(initialData);

    useEffect(() => {
        const filterMultiplier = 
            (filters.category === 'all' ? 1 : 0.4) *
            (filters.branch === 'all' ? 1 : 0.6) *
            (filters.provider === 'all' ? 1 : 0.3);

        setData(initialData.map(item => ({
            ...item,
            total: Math.floor(item.total * filterMultiplier * (Math.random() * 0.2 + 0.9))
        })));
    }, [filters]);

    return (
        <Card>
            <CardHeader>
                <CardTitle>الإيرادات</CardTitle>
                <CardDescription>إجمالي الإيرادات هذا العام بناءً على الفلاتر المحددة.</CardDescription>
            </CardHeader>
            <CardContent className="pl-2">
                <ResponsiveContainer width="100%" height={350}>
                    <BarChart data={data}>
                        <XAxis dataKey="name" stroke="#888888" fontSize={12} tickLine={false} axisLine={false} />
                        <YAxis stroke="#888888" fontSize={12} tickLine={false} axisLine={false} tickFormatter={(value) => `${value / 1000} ألف`} />
                        <Tooltip cursor={{ fill: 'rgba(99, 102, 241, 0.1)' }} formatter={(value) => `${value.toLocaleString('ar-SA')} ريال`} />
                        <Bar dataKey="total" fill="var(--color-primary)" radius={[4, 4, 0, 0]} />
                    </BarChart>
                </ResponsiveContainer>
            </CardContent>
        </Card>
    );
};

export default React.memo(RevenueChart);