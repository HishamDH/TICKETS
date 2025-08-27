import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Send, Paperclip, Search } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const initialConversations = [
    { id: 1, name: 'فهد صالح (حجز #BK-8462)', lastMessage: 'مرحباً، هل يمكن تغيير موعد حجز قاعة الأفراح؟', time: '10:30ص', avatar: 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?q=80&w=200', unread: 2, messages: [
        { sender: 'other', text: 'مرحباً، هل يمكن تغيير موعد حجز قاعة الأفراح؟ لدي ظرف طارئ.', time: '10:30ص' },
        { sender: 'me', text: 'أهلاً بك أستاذ فهد، يؤسفني سماع ذلك. بالتأكيد، يمكننا محاولة تغيير الموعد. ما هو الموعد الجديد الذي ترغب به؟ وهل لديك رقم الحجز؟', time: '10:31ص' },
    ]},
    { id: 2, name: 'مجموعة شركات النمو (حجز #GRP-001)', lastMessage: 'شكرًا على الخدمة الممتازة في تنظيم مناسبتنا!', time: '9:15ص', avatar: 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=200', unread: 0, messages: [
        { sender: 'other', text: 'شكرًا على الخدمة الممتازة في تنظيم مناسبتنا!', time: '9:15ص' },
    ]},
    { id: 3, name: 'سارة علي (حجز #BK-5987)', lastMessage: 'لدي استفسار بخصوص فاتورة خدمة المكياج.', time: 'أمس', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200', unread: 0, messages: [
        { sender: 'other', text: 'لدي استفسار بخصوص فاتورة خدمة المكياج.', time: 'أمس 3:20م' },
    ]},
];

const MessagesContent = ({ handleNavigation, handleFeatureClick: propHandleFeatureClick }) => {
    const [conversations, setConversations] = useState(JSON.parse(localStorage.getItem('lilium_night_conversations_v1')) || initialConversations);
    const [selectedConversationId, setSelectedConversationId] = useState(conversations[0]?.id);
    const [newMessage, setNewMessage] = useState('');
    const [searchTerm, setSearchTerm] = useState('');
    const { toast } = useToast();

    useEffect(() => {
        localStorage.setItem('lilium_night_conversations_v1', JSON.stringify(conversations));
    }, [conversations]);

    const selectedConversation = conversations.find(c => c.id === selectedConversationId);

    const handleFeatureClick = (featureName) => {
        if (propHandleFeatureClick && typeof propHandleFeatureClick === 'function') {
            propHandleFeatureClick(featureName);
        } else {
            toast({
                title: "🚧 ميزة قيد التطوير",
                description: `ميزة "${featureName}" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
            });
        }
    };

    const handleSendMessage = () => {
        if (!newMessage.trim() || !selectedConversation) return;
        const updatedConversations = conversations.map(conv => {
            if (conv.id === selectedConversationId) {
                return {
                    ...conv,
                    messages: [...conv.messages, { sender: 'me', text: newMessage, time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' }) }],
                    lastMessage: newMessage,
                    time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' })
                };
            }
            return conv;
        });
        setConversations(updatedConversations);
        setNewMessage('');
        handleFeatureClick(`إرسال رسالة إلى ${selectedConversation.name}`);
    };
    
    const handleFileUpload = () => {
         handleFeatureClick("إرفاق ملف في الرسائل");
    };

    const filteredConversations = conversations.filter(conv => 
        conv.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
        conv.lastMessage.toLowerCase().includes(searchTerm.toLowerCase())
    );

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">مركز رسائل العملاء</h2>
            <Card className="h-[calc(100vh-12rem)] flex">
                <div className="w-1/3 border-l p-4 flex flex-col">
                    <div className="relative mb-4">
                        <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                        <Input 
                            placeholder="بحث في المحادثات..." 
                            className="pl-10" 
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                        />
                    </div>
                    <div className="flex-grow overflow-y-auto space-y-2">
                        {filteredConversations.map(conv => (
                            <div key={conv.id} onClick={() => setSelectedConversationId(conv.id)} className={`p-3 rounded-lg cursor-pointer flex items-start gap-3 ${selectedConversationId === conv.id ? 'bg-primary/10' : 'hover:bg-slate-50'}`}>
                                <Avatar>
                                    <AvatarImage src={conv.avatar} />
                                    <AvatarFallback>{conv.name.charAt(0)}</AvatarFallback>
                                </Avatar>
                                <div className="flex-grow">
                                    <div className="flex justify-between items-center">
                                        <p className="font-semibold text-sm">{conv.name}</p>
                                        <p className="text-xs text-slate-400">{conv.time}</p>
                                    </div>
                                    <div className="flex justify-between items-center mt-1">
                                        <p className="text-xs text-slate-500 truncate">{conv.lastMessage}</p>
                                        {conv.unread > 0 && <div className="w-5 h-5 bg-primary text-white text-xs rounded-full flex items-center justify-center">{conv.unread}</div>}
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
                <div className="w-2/3 flex flex-col">
                    {selectedConversation ? (
                        <>
                            <div className="p-4 border-b flex items-center gap-3">
                                <Avatar>
                                    <AvatarImage src={selectedConversation.avatar} />
                                    <AvatarFallback>{selectedConversation.name.charAt(0)}</AvatarFallback>
                                </Avatar>
                                <div>
                                    <p className="font-bold">{selectedConversation.name}</p>
                                    <p className="text-xs text-green-500">متصل الآن</p>
                                </div>
                            </div>
                            <div className="flex-grow p-6 overflow-y-auto bg-slate-50 space-y-6">
                                {selectedConversation.messages.map((msg, index) => (
                                    <div key={index} className={`flex ${msg.sender === 'me' ? 'justify-end' : 'justify-start'}`}>
                                        <div className={`max-w-xs lg:max-w-md p-3 rounded-2xl ${msg.sender === 'me' ? 'bg-primary text-white rounded-br-none' : 'bg-white rounded-bl-none shadow-sm'}`}>
                                            <p>{msg.text}</p>
                                            <p className={`text-xs mt-1 ${msg.sender === 'me' ? 'text-white/70' : 'text-slate-400'}`}>{msg.time}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            <div className="p-4 border-t bg-white flex items-center gap-2">
                                <Input 
                                    placeholder="اكتب رسالتك هنا..." 
                                    className="flex-grow"
                                    value={newMessage}
                                    onChange={(e) => setNewMessage(e.target.value)}
                                    onKeyPress={(e) => e.key === 'Enter' && handleSendMessage()}
                                />
                                <Button variant="ghost" size="icon" onClick={handleFileUpload}><Paperclip className="w-5 h-5"/></Button>
                                <Button className="gradient-bg text-white" onClick={handleSendMessage}><Send className="w-5 h-5"/></Button>
                            </div>
                        </>
                    ) : (
                        <div className="flex items-center justify-center h-full text-slate-400">اختر محادثة لعرضها</div>
                    )}
                </div>
            </Card>
        </div>
    );
};

export default MessagesContent;