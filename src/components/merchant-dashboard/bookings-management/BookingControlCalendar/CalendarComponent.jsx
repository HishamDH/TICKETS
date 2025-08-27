import React, { memo } from 'react';
import { Calendar } from "@/components/ui/calendar";
import { startOfDay, parseISO, format } from 'date-fns';
import { ar } from "date-fns/locale";

const CalendarComponent = memo(({ selectedDate, onDateSelect, dailyConfigs }) => {
    const getDayModifiers = () => {
        const modifiers = {};
        Object.keys(dailyConfigs).forEach(dateStr => {
            const config = dailyConfigs[dateStr];
            let className = '';
            if (config.status === 'available') className = 'bg-green-100 text-green-700 rounded-md';
            else if (config.status === 'closed') className = 'bg-red-100 text-red-700 rounded-md line-through';
            else if (config.status === 'locked') className = 'bg-slate-300 text-slate-600 rounded-md line-through';
            
            if (config.onlineSaleActive) className = `${className} border-2 border-blue-500`.trim();
            if (config.isLocked) className = `${className} ring-1 ring-slate-700`.trim();

            if (className) {
                const dateObj = parseISO(dateStr);
                if (!isNaN(dateObj.valueOf())) modifiers[dateStr] = { className: className.trim() };
            }
        });
        if (selectedDate) {
            const selectedDateStr = format(selectedDate, 'yyyy-MM-dd');
            modifiers[selectedDateStr] = { 
                ...(modifiers[selectedDateStr] || {}), 
                className: `${modifiers[selectedDateStr]?.className || ''} ring-2 ring-primary ring-offset-2`.trim()
            };
        }
        return modifiers;
    };

    return (
        <Calendar
            mode="single"
            selected={selectedDate}
            onSelect={onDateSelect}
            className="rounded-md border p-4 bg-white shadow-sm w-full"
            locale={ar}
            modifiers={getDayModifiers()}
            modifiersClassNames={{
                selected: 'bg-primary text-primary-foreground hover:bg-primary/90 focus:bg-primary/90',
            }}
            disabled={(date) => date < startOfDay(new Date())}
        />
    );
});

export default CalendarComponent;