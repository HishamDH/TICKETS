
import React from 'react';
import { Button } from '@/components/ui/button';

const PlaceholderContent = ({ title, description, icon: Icon, handleFeatureClick }) => (
    <div className="flex flex-col items-center justify-center h-full text-center p-8 bg-slate-50 rounded-2xl">
        <div className="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mb-6">
            <Icon className="w-12 h-12 text-primary"/>
        </div>
        <h2 className="text-3xl font-bold text-slate-800">{title}</h2>
        <p className="mt-2 max-w-lg text-slate-500">{description}</p>
        <Button className="mt-8 gradient-bg text-white" onClick={() => handleFeatureClick(title)}>
            اطلب هذه الميزة
        </Button>
    </div>
);

export default PlaceholderContent;
