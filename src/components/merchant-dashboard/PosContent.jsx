import React, { useState, useEffect, memo } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { PlusCircle, Trash2, ShoppingCart, CreditCard, DollarSign } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const availableProducts = [
    { id: 'prod1', name: 'الباقة الذهبية', price: 15000 },
    { id: 'prod2', name: 'الباقة الفضية', price: 10000 },
    { id: 'prod3', name: 'خدمة تصوير إضافية', price: 1500 },
    { id: 'prod4', name: 'ضيافة قهوة', price: 500 },
];

const PosContent = memo(({ handleFeatureClick }) => {
    const { toast } = useToast();
    const [cart, setCart] = useState([]);
    const [selectedProduct, setSelectedProduct] = useState('');

    const addToCart = () => {
        if (!selectedProduct) {
            toast({ title: "خطأ", description: "الرجاء اختيار خدمة لإضافتها.", variant: "destructive" });
            return;
        }
        const productToAdd = availableProducts.find(p => p.id === selectedProduct);
        setCart([...cart, { ...productToAdd, cartId: Date.now() }]);
        setSelectedProduct('');
        handleFeatureClick(`إضافة للسلة: ${productToAdd.name}`);
    };

    const removeFromCart = (cartId) => {
        const productToRemove = cart.find(p => p.cartId === cartId);
        setCart(cart.filter(item => item.cartId !== cartId));
        handleFeatureClick(`إزالة من السلة: ${productToRemove.name}`);
    };

    const total = cart.reduce((sum, item) => sum + item.price, 0);

    const completeSale = (paymentMethod) => {
        if (cart.length === 0) {
            toast({ title: "خطأ", description: "السلة فارغة.", variant: "destructive" });
            return;
        }
        toast({
            title: "تمت العملية بنجاح!",
            description: `تم تسجيل عملية بيع بمبلغ ${total.toLocaleString()} ريال عبر ${paymentMethod}.`,
        });
        handleFeatureClick(`إتمام بيع بـ ${total} ريال عبر ${paymentMethod}`);
        setCart([]);
    };

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">نظام البيع الداخلي (POS)</h2>
            <div className="grid lg:grid-cols-3 gap-8">
                <div className="lg:col-span-2">
                    <Card>
                        <CardHeader>
                            <CardTitle>إضافة خدمات للسلة</CardTitle>
                        </CardHeader>
                        <CardContent className="flex items-end gap-2">
                            <div className="flex-grow">
                                <label className="text-sm font-medium">اختر خدمة أو باقة</label>
                                <Select value={selectedProduct} onValueChange={setSelectedProduct}>
                                    <SelectTrigger><SelectValue placeholder="اختر..." /></SelectTrigger>
                                    <SelectContent>
                                        {availableProducts.map(p => (
                                            <SelectItem key={p.id} value={p.id}>{p.name} - {p.price.toLocaleString()} ريال</SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </div>
                            <Button onClick={addToCart}><PlusCircle className="w-4 h-4 ml-2" /> إضافة</Button>
                        </CardContent>
                    </Card>
                </div>
                <div className="lg:col-span-1 row-start-1 lg:row-start-auto">
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2"><ShoppingCart /> سلة المبيعات</CardTitle>
                        </CardHeader>
                        <CardContent>
                            {cart.length > 0 ? (
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>الخدمة</TableHead>
                                            <TableHead>السعر</TableHead>
                                            <TableHead></TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {cart.map(item => (
                                            <TableRow key={item.cartId}>
                                                <TableCell>{item.name}</TableCell>
                                                <TableCell>{item.price.toLocaleString()}</TableCell>
                                                <TableCell>
                                                    <Button variant="ghost" size="icon" onClick={() => removeFromCart(item.cartId)}>
                                                        <Trash2 className="w-4 h-4 text-red-500" />
                                                    </Button>
                                                </TableCell>
                                            </TableRow>
                                        ))}
                                    </TableBody>
                                </Table>
                            ) : (
                                <p className="text-center text-slate-500 py-4">السلة فارغة.</p>
                            )}
                            <div className="mt-4 pt-4 border-t">
                                <div className="flex justify-between font-bold text-lg">
                                    <span>الإجمالي:</span>
                                    <span>{total.toLocaleString()} ريال</span>
                                </div>
                                <div className="mt-4 grid grid-cols-2 gap-2">
                                    <Button onClick={() => completeSale('نقدي')}><DollarSign className="w-4 h-4 ml-2" /> دفع نقدي</Button>
                                    <Button onClick={() => completeSale('بطاقة')}><CreditCard className="w-4 h-4 ml-2" /> دفع بطاقة</Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    );
});

export default PosContent;