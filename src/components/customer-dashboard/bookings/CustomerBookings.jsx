import React, { useState, useMemo, useEffect, useRef } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Calendar, Star, MessageSquare, FileText, Download, Ticket } from 'lucide-react';
import { format, parseISO, isFuture, isPast } from 'date-fns';
import { ar } from 'date-fns/locale';
import { Tabs, TabsList, TabsTrigger, TabsContent } from "@/components/ui/tabs";
import { useVirtualizer } from '@tanstack/react-virtual';

const statusMap = {
    paid: { label: 'مؤكد', color: 'bg-green-100 text-green-800' },
    awaiting_confirmation: { label: 'بانتظار التأكيد', color: 'bg-yellow-100 text-yellow-800' },
    used: { label: 'مكتمل', color: 'bg-blue-100 text-blue-800' },
    cancelled_by_user: { label: 'ملغي', color: 'bg-red-100 text-red-800' },
    cancelled_by_merchant: { label: 'ملغي من التاجر', color: 'bg-red-100 text-red-800' },
};

const BookingCard = React.memo(({ booking, onAction }) => (
    <Card className="shadow-md hover:shadow-lg transition-shadow">
        <CardHeader>
            <div className="flex justify-between items-start">
                <div>
                    <CardTitle className="text-lg font-bold">{booking.event}</CardTitle>
                    <CardDescription className="text-sm text-slate-500">{booking.serviceType}</CardDescription>
                </div>
                <Badge className={`${statusMap[booking.status]?.color || 'bg-gray-200'} text-xs`}>{statusMap[booking.status]?.label || booking.status}</Badge>
            </div>
        </CardHeader>
        <CardContent className="space-y-3 text-sm">
            <div className="flex items-center gap-2">
                <Calendar className="w-4 h-4 text-primary" />
                <span>{format(parseISO(booking.date), 'eeee, d MMMM yyyy', { locale: ar })}</span>
            </div>
            <div className="font-semibold text-base">
                {booking.amount.toLocaleString('ar-SA', { style: 'currency', currency: 'SAR' })}
            </div>
        </CardContent>
        <CardFooter className="flex gap-2 bg-slate-50 p-3">
            {isFuture(parseISO(booking.date)) && booking.status === 'paid' && (
                <Button variant="outline" size="sm" onClick={() => onAction('cancel', booking.id)}>إلغاء الحجز</Button>
            )}
            {isPast(parseISO(booking.date)) && booking.status === 'used' && (
                <Button variant="default" size="sm" onClick={() => onAction('review', booking.id)} className="bg-amber-500 hover:bg-amber-600 text-white">
                    <Star className="w-4 h-4 ml-2" />
                    أضف تقييم
                </Button>
            )}
            <Button variant="ghost" size="sm" onClick={() => onAction('contact', booking.id)}><MessageSquare className="w-4 h-4 ml-2" />تواصل مع المزود</Button>
            <Button variant="ghost" size="sm" onClick={() => onAction('contract', booking.id)}><FileText className="w-4 h-4 ml-2" />عرض العقد</Button>
        </CardFooter>
    </Card>
));

const BookingsGrid = ({ bookings, onAction }) => {
    const parentRef = useRef(null);

    const rowVirtualizer = useVirtualizer({
        count: Math.ceil(bookings.length / 3),
        getScrollElement: () => parentRef.current,
        estimateSize: () => 250,
        overscan: 5,
    });

    return (
        <div ref={parentRef} className="h-[600px] overflow-y-auto">
            <div
                style={{
                    height: `${rowVirtualizer.getTotalSize()}px`,
                    width: '100%',
                    position: 'relative',
                }}
            >
                {rowVirtualizer.getVirtualItems().map((virtualRow) => {
                    const startIndex = virtualRow.index * 3;
                    const endIndex = Math.min(startIndex + 3, bookings.length);
                    const rowBookings = bookings.slice(startIndex, endIndex);

                    return (
                        <div
                            key={virtualRow.index}
                            style={{
                                position: 'absolute',
                                top: 0,
                                left: 0,
                                width: '100%',
                                height: `${virtualRow.size}px`,
                                transform: `translateY(${virtualRow.start}px)`,
                                display: 'grid',
                                gridTemplateColumns: 'repeat(auto-fill, minmax(300px, 1fr))',
                                gap: '1.5rem',
                                padding: '0.5rem'
                            }}
                        >
                            {rowBookings.map(booking => (
                                <BookingCard key={booking.id} booking={booking} onAction={onAction} />
                            ))}
                        </div>
                    );
                })}
            </div>
        </div>
    );
};


const CustomerBookings = ({ handleFeatureClick }) => {
    const [allBookings, setAllBookings] = useState([]);
    const [activeTab, setActiveTab] = useState('upcoming');

    useEffect(() => {
        const storedBookings = JSON.parse(localStorage.getItem('lilium_night_all_bookings_v1')) || [];
        const customerBookings = storedBookings.filter(b => b.customer !== '-');
        setAllBookings(customerBookings);
    }, []);

    const handleAction = (action, bookingId) => {
        handleFeatureClick(`تنفيذ إجراء "${action}" للحجز ${bookingId}`);
    };

    const filteredBookings = useMemo(() => {
        if (activeTab === 'upcoming') {
            return allBookings.filter(b => isFuture(parseISO(b.date)) && (b.status === 'paid' || b.status === 'awaiting_confirmation'));
        }
        if (activeTab === 'past') {
            return allBookings.filter(b => isPast(parseISO(b.date)) || b.status === 'used' || b.status.includes('cancelled'));
        }
        return allBookings;
    }, [allBookings, activeTab]);

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800 flex items-center gap-2"><Ticket className="w-8 h-8 text-primary"/>حجوزاتي</h2>
                <Button variant="outline" onClick={() => handleFeatureClick("تنزيل كل الحجوزات")}>
                    <Download className="w-4 h-4 ml-2" />
                    تنزيل الكل
                </Button>
            </div>

            <Tabs value={activeTab} onValueChange={setActiveTab} dir="rtl">
                <TabsList className="grid w-full grid-cols-2">
                    <TabsTrigger value="upcoming">الحجوزات القادمة</TabsTrigger>
                    <TabsTrigger value="past">الحجوزات السابقة</TabsTrigger>
                </TabsList>
                <TabsContent value="upcoming" className="mt-6">
                    {filteredBookings.length > 0 ? (
                        <BookingsGrid bookings={filteredBookings} onAction={handleAction} />
                    ) : (
                        <div className="text-center py-16 text-slate-500">
                            <p>لا توجد حجوزات قادمة.</p>
                        </div>
                    )}
                </TabsContent>
                <TabsContent value="past" className="mt-6">
                    {filteredBookings.length > 0 ? (
                        <BookingsGrid bookings={filteredBookings} onAction={handleAction} />
                    ) : (
                        <div className="text-center py-16 text-slate-500">
                            <p>لا توجد حجوزات سابقة.</p>
                        </div>
                    )}
                </TabsContent>
            </Tabs>
        </div>
    );
};

export default CustomerBookings;