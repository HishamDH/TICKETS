import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Badge } from "@/components/ui/badge";
import { UserCheck, Star } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const initialCustomers = [
    { id: 'cust1', name: 'عبدالله الأحمد', lastBooking: 'الباقة الذهبية', rating: 'vip' },
    { id: 'cust2', name: 'فاطمة الزهراني', lastBooking: 'باقة تصوير', rating: 'regular' },
    { id: 'cust3', name: 'محمد الغامدي', lastBooking: 'الباقة الفضية', rating: 'problematic' },
    { id: 'cust4', name: 'سارة العتيبي', lastBooking: 'الباقة الذهبية', rating: 'none' },
];

const ratingOptions = {
    none: { label: 'بدون تقييم', color: 'bg-slate-200 text-slate-800' },
    vip: { label: 'عميل مميز (VIP)', color: 'bg-yellow-400 text-yellow-900' },
    regular: { label: 'عميل عادي', color: 'bg-blue-400 text-blue-900' },
    problematic: { label: 'يتطلب متابعة', color: 'bg-red-400 text-red-900' },
};

const InternalCustomerRatingContent = memo(({ handleFeatureClick }) => {
    const { toast } = useToast();
    const [customers, setCustomers] = useState(JSON.parse(localStorage.getItem('lilium_night_customer_ratings_v1')) || initialCustomers);

    useEffect(() => {
        localStorage.setItem('lilium_night_customer_ratings_v1', JSON.stringify(customers));
    }, [customers]);

    const handleRatingChange = (customerId, newRating) => {
        setCustomers(customers.map(c => c.id === customerId ? { ...c, rating: newRating } : c));
        const customerName = customers.find(c => c.id === customerId)?.name;
        toast({
            title: "تم تحديث التقييم",
            description: `تم تحديث تقييم العميل "${customerName}" إلى "${ratingOptions[newRating].label}".`,
        });
        handleFeatureClick(`تغيير تقييم العميل ${customerName}`);
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">تقييم داخلي للعملاء</h2>
            <Card>
                <CardHeader>
                    <CardTitle>إدارة تقييمات العملاء الداخلية</CardTitle>
                    <CardDescription>صنّف عملائك داخلياً لمساعدتك وفريقك على تقديم خدمة أفضل. هذه التقييمات لا تظهر للعملاء.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>العميل</TableHead>
                                <TableHead>آخر حجز</TableHead>
                                <TableHead>التقييم الداخلي</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {customers.map(customer => (
                                <TableRow key={customer.id}>
                                    <TableCell className="font-semibold">{customer.name}</TableCell>
                                    <TableCell>{customer.lastBooking}</TableCell>
                                    <TableCell>
                                        <Select value={customer.rating} onValueChange={(value) => handleRatingChange(customer.id, value)}>
                                            <SelectTrigger className="w-[200px]">
                                                <SelectValue>
                                                    <Badge className={`${ratingOptions[customer.rating].color} hover:${ratingOptions[customer.rating].color}`}>
                                                        {ratingOptions[customer.rating].label}
                                                    </Badge>
                                                </SelectValue>
                                            </SelectTrigger>
                                            <SelectContent>
                                                {Object.entries(ratingOptions).map(([key, value]) => (
                                                    <SelectItem key={key} value={key}>
                                                        <Badge className={`${value.color} hover:${value.color}`}>{value.label}</Badge>
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    );
});

export default InternalCustomerRatingContent;