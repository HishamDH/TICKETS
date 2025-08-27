import React from 'react';

const CalendarLegend = () => (
    <div className="mt-4 p-3 bg-slate-50 rounded-lg space-y-2 text-sm">
        <div className="flex items-center gap-2"><div className="w-3 h-3 rounded-full bg-green-500"></div> يوم متاح</div>
        <div className="flex items-center gap-2"><div className="w-3 h-3 rounded-full bg-red-500"></div> يوم مغلق</div>
        <div className="flex items-center gap-2"><div className="w-3 h-3 rounded-full bg-slate-400"></div> يوم مقفل نهائياً</div>
        <div className="flex items-center gap-2"><div className="w-3 h-3 rounded-full border-2 border-primary"></div> يوم محدد للتعديل</div>
        <div className="flex items-center gap-2"><div className="w-3 h-3 rounded-full border-2 border-blue-500"></div> يوم مفعل للبيع أونلاين</div>
    </div>
);

export default CalendarLegend;