import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from "@/components/ui/dialog";
import { PlusCircle, Mail, Send, Eye } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";
import { format } from "date-fns";
import { ar } from "date-fns/locale";

const initialCampaigns = [
    { id: 'camp1', name: 'عرض نهاية الأسبوع', subject: 'خصم 20% على باقات الزفاف!', status: 'مرسلة', sentDate: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000).toISOString(), audience: 'all' },
    { id: 'camp2', name: 'تذكير عملاء VIP', subject: 'عرض حصري لعملاءنا المميزين', status: 'مسودة', sentDate: null, audience: 'vip' },
];

const EmailCampaignsContent = ({ handleFeatureClick }) => {
    const { toast } = useToast();
    const [campaigns, setCampaigns] = useState(JSON.parse(localStorage.getItem('lilium_night_email_campaigns_v1')) || initialCampaigns);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [newCampaign, setNewCampaign] = useState({ name: '', subject: '', content: '', audience: 'all' });

    useEffect(() => {
        localStorage.setItem('lilium_night_email_campaigns_v1', JSON.stringify(campaigns));
    }, [campaigns]);

    const handleCreateCampaign = () => {
        if (!newCampaign.name || !newCampaign.subject || !newCampaign.content) {
            toast({ title: "خطأ", description: "الرجاء ملء جميع الحقول.", variant: "destructive" });
            return;
        }
        const newCamp = { ...newCampaign, id: `camp${Date.now()}`, status: 'مسودة', sentDate: null };
        setCampaigns([...campaigns, newCamp]);
        setIsModalOpen(false);
        setNewCampaign({ name: '', subject: '', content: '', audience: 'all' });
        toast({ title: "تم إنشاء الحملة", description: "تم حفظ الحملة كمسودة. يمكنك إرسالها من القائمة." });
        handleFeatureClick(`إنشاء حملة بريدية: ${newCampaign.name}`);
    };

    const handleSendCampaign = (campaignId) => {
        setCampaigns(campaigns.map(c => c.id === campaignId ? { ...c, status: 'مرسلة', sentDate: new Date().toISOString() } : c));
        const campaignName = campaigns.find(c => c.id === campaignId)?.name;
        toast({ title: "جاري الإرسال...", description: `سيتم إرسال حملة "${campaignName}" خلال دقائق.` });
        handleFeatureClick(`إرسال حملة: ${campaignName}`);
    };

    return (
        <div className="space-y-8">
            <div className="flex justify-between items-center">
                <h2 className="text-3xl font-bold text-slate-800">حملات البريد الإلكتروني</h2>
                <Button className="gradient-bg text-white" onClick={() => setIsModalOpen(true)}>
                    <PlusCircle className="w-5 h-5 ml-2"/> إنشاء حملة جديدة
                </Button>
            </div>
            <Card>
                <CardHeader>
                    <CardTitle>إدارة الحملات البريدية</CardTitle>
                    <CardDescription>تواصل مع عملائك وأرسل لهم عروضاً ترويجية وتحديثات لزيادة الحجوزات.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>اسم الحملة</TableHead>
                                <TableHead>الحالة</TableHead>
                                <TableHead>تاريخ الإرسال</TableHead>
                                <TableHead>إجراءات</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {campaigns.map(camp => (
                                <TableRow key={camp.id}>
                                    <TableCell className="font-semibold">{camp.name}</TableCell>
                                    <TableCell>
                                        <span className={`px-2 py-1 text-xs rounded-full font-bold ${camp.status === 'مرسلة' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}`}>
                                            {camp.status}
                                        </span>
                                    </TableCell>
                                    <TableCell>{camp.sentDate ? format(new Date(camp.sentDate), 'PPP', { locale: ar }) : 'لم ترسل بعد'}</TableCell>
                                    <TableCell>
                                        {camp.status === 'مسودة' ? (
                                            <Button variant="outline" size="sm" onClick={() => handleSendCampaign(camp.id)}>
                                                <Send className="w-4 h-4 ml-2" /> إرسال الآن
                                            </Button>
                                        ) : (
                                            <Button variant="ghost" size="sm" onClick={() => handleFeatureClick(`عرض تقرير حملة ${camp.name}`)}>
                                                <Eye className="w-4 h-4 ml-2" /> عرض التقرير
                                            </Button>
                                        )}
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>

            <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
                <DialogContent className="sm:max-w-[625px]" dir="rtl">
                    <DialogHeader>
                        <DialogTitle>إنشاء حملة بريدية جديدة</DialogTitle>
                    </DialogHeader>
                    <div className="py-4 space-y-4">
                        <div>
                            <Label htmlFor="camp-name">اسم الحملة (داخلي)</Label>
                            <Input id="camp-name" value={newCampaign.name} onChange={(e) => setNewCampaign({...newCampaign, name: e.target.value})} />
                        </div>
                        <div>
                            <Label htmlFor="camp-subject">عنوان البريد</Label>
                            <Input id="camp-subject" value={newCampaign.subject} onChange={(e) => setNewCampaign({...newCampaign, subject: e.target.value})} />
                        </div>
                        <div>
                            <Label htmlFor="camp-audience">الجمهور المستهدف</Label>
                            <Select value={newCampaign.audience} onValueChange={(value) => setNewCampaign({...newCampaign, audience: value})}>
                                <SelectTrigger><SelectValue /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">كل العملاء</SelectItem>
                                    <SelectItem value="vip">العملاء المميزون (VIP)</SelectItem>
                                    <SelectItem value="past_bookers">من حجزوا سابقاً</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <div>
                            <Label htmlFor="camp-content">محتوى الرسالة</Label>
                            <Textarea id="camp-content" className="min-h-[150px]" value={newCampaign.content} onChange={(e) => setNewCampaign({...newCampaign, content: e.target.value})} />
                        </div>
                    </div>
                    <DialogFooter>
                        <Button variant="ghost" onClick={() => setIsModalOpen(false)}>إلغاء</Button>
                        <Button className="gradient-bg text-white" onClick={handleCreateCampaign}>حفظ كمسودة</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
};

export default EmailCampaignsContent;