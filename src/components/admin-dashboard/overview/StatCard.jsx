import React, { useState, useEffect } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { DollarSign, Users, Ticket, BarChart } from 'lucide-react';

const StatCard = ({ title, iconType, filters }) => {
    const [value, setValue] = useState(0);
    const [change, setChange] = useState(0);

    useEffect(() => {
        const baseValue = {
            revenue: 125000,
            bookings: 350,
            users: 1500,
            avg_booking: 357
        }[iconType];

        const filterMultiplier = 
            (filters.category === 'all' ? 1 : 0.4) *
            (filters.branch === 'all' ? 1 : 0.6) *
            (filters.provider === 'all' ? 1 : 0.3);

        const newValue = Math.floor(baseValue * filterMultiplier * (Math.random() * 0.4 + 0.8));
        const newChange = (Math.random() * 10 - 3).toFixed(1);

        setValue(newValue);
        setChange(newChange);
    }, [filters, iconType]);

    const icons = {
        revenue: <DollarSign className="h-4 w-4 text-muted-foreground" />,
        bookings: <Ticket className="h-4 w-4 text-muted-foreground" />,
        users: <Users className="h-4 w-4 text-muted-foreground" />,
        avg_booking: <BarChart className="h-4 w-4 text-muted-foreground" />
    };

    const formatValue = (val) => {
        if (iconType === 'revenue' || iconType === 'avg_booking') {
            return val.toLocaleString('ar-SA', { style: 'currency', currency: 'SAR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }
        return val.toLocaleString('ar-SA');
    };

    return (
        <Card>
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle className="text-sm font-medium">{title}</CardTitle>
                {icons[iconType]}
            </CardHeader>
            <CardContent>
                <div className="text-2xl font-bold">{formatValue(value)}</div>
                <p className={`text-xs ${change >= 0 ? 'text-green-500' : 'text-red-500'}`}>
                    {change >= 0 ? `+${change}` : change}% عن الشهر الماضي
                </p>
            </CardContent>
        </Card>
    );
};

export default React.memo(StatCard);