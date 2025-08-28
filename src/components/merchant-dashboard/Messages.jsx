import React, { useState } from 'react';
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Send, Paperclip, Search } from 'lucide-react';

const conversations = [
    { id: 1, name: 'فهد صالح', lastMessage: 'مرحباً، هل يمكن تغيير موعد الحجز؟', time: '10:30ص', avatar: 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?q=80&w=200', unread: 2 },
    { id: 2, name: 'مجموعة شركات النمو', lastMessage: 'شكرًا على الخدمة الممتازة!', time: '9:15ص', avatar: 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=200', unread: 0 },
    { id: 3, name: 'سارة علي', lastMessage: 'لدي استفسار بخصوص الفاتورة.', time: 'أمس', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200', unread: 0 },
];

const messages = [
    { sender: 'other', text: 'مرحباً، هل يمكن تغيير موعد الحجز؟', time: '10:30ص' },
    { sender: 'me', text: 'أهلاً بك، بالتأكيد. ما هو الموعد الجديد الذي ترغب به؟', time: '10:31ص' },
];

const MessagesContent = ({ handleFeatureClick }) => {
    const [selectedConversation, setSelectedConversation] = useState(conversations[0]);

    return (
        <div className="space-y-8">
            <h2 className="text-3xl font-bold text-slate-800">مركز الرسائل</h2>
            <Card className="h-[calc(100vh-12rem)] flex">
                <div className="w-1/3 border-l p-4 flex flex-col">
                    <div className="relative mb-4">
                        <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                        <Input placeholder="بحث في المحادثات..." className="pl-10" />
                    </div>
                    <div className="flex-grow overflow-y-auto space-y-2">
                        {conversations.map(conv => (
                            <div key={conv.id} onClick={() => setSelectedConversation(conv)} className={`p-3 rounded-lg cursor-pointer flex items-start gap-3 ${selectedConversation.id === conv.id ? 'bg-primary/10' : 'hover:bg-slate-50'}`}>
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
                                {messages.map((msg, index) => (
                                    <div key={index} className={`flex ${msg.sender === 'me' ? 'justify-end' : 'justify-start'}`}>
                                        <div className={`max-w-xs lg:max-w-md p-3 rounded-2xl ${msg.sender === 'me' ? 'bg-primary text-white rounded-br-none' : 'bg-white rounded-bl-none shadow-sm'}`}>
                                            <p>{msg.text}</p>
                                            <p className={`text-xs mt-1 ${msg.sender === 'me' ? 'text-white/70' : 'text-slate-400'}`}>{msg.time}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            <div className="p-4 border-t bg-white flex items-center gap-2">
                                <Input placeholder="اكتب رسالتك هنا..." className="flex-grow"/>
                                <Button variant="ghost" size="icon" onClick={() => handleFeatureClick("إرفاق ملف")}><Paperclip className="w-5 h-5"/></Button>
                                <Button className="gradient-bg text-white" onClick={() => handleFeatureClick("إرسال رسالة")}><Send className="w-5 h-5"/></Button>
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