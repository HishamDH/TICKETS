
import React from 'react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import { Star, Repeat, Send } from 'lucide-react';

const experiences = [
    { title: 'تجربة الغوص في أعماق البحر الأحمر', date: 'نوفمبر 2025', image: 'https://images.unsplash.com/photo-1530541930197-58e36e846473?q=80&w=300' },
    { title: 'جولة تاريخية في البلد', date: 'أكتوبر 2025', image: 'https://images.unsplash.com/photo-1569429459383-1132f8349277?q=80&w=300' },
];

const ExperienceCard = ({ exp, handleFeatureClick }) => (
    <Card>
        <div className="relative">
            <img src={exp.image} alt={exp.title} className="w-full h-40 object-cover rounded-t-lg"/>
            <div className="absolute inset-0 bg-black/40 rounded-t-lg"></div>
            <div className="absolute bottom-2 right-2 text-white">
                <h3 className="font-bold">{exp.title}</h3>
                <p className="text-sm">{exp.date}</p>
            </div>
        </div>
        <CardContent className="p-4 flex gap-2">
            <Button className="w-full" onClick={() => handleFeatureClick("Add Review")}><Star className="w-4 h-4 ml-2"/>إضافة مراجعة</Button>
            <Button variant="outline" size="icon" onClick={() => handleFeatureClick("Repeat")}><Repeat className="w-4 h-4"/></Button>
            <Button variant="outline" size="icon" onClick={() => handleFeatureClick("Send to Friend")}><Send className="w-4 h-4"/></Button>
        </CardContent>
    </Card>
);

const CustomerExperience = ({ handleFeatureClick }) => {
    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-3xl font-bold text-slate-800">تجربتي</h1>
                <p className="text-slate-500 mt-1">استعرض تجاربك السابقة وشاركها مع الآخرين.</p>
            </div>
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                {experiences.map(exp => <ExperienceCard key={exp.title} exp={exp} handleFeatureClick={handleFeatureClick}/>)}
            </div>
        </div>
    );
};

export default CustomerExperience;
