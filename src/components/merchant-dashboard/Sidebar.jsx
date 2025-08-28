
import React from 'react';
import { Ticket } from 'lucide-react';

const Sidebar = ({ activeTab, setActiveTab, dashboardItems }) => {
    return (
        <aside className="w-64 bg-white p-6 flex flex-col shrink-0 border-l border-slate-200">
            <div className="flex items-center gap-3 mb-10">
                <div className="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                    <Ticket className="w-6 h-6 text-white" />
                </div>
                <h1 className="text-xl font-bold text-slate-800">شباك التذاكر</h1>
            </div>
            <nav className="flex flex-col gap-2">
                {dashboardItems.map(item => (
                    <button
                        key={item.id}
                        onClick={() => setActiveTab(item.id)}
                        className={`flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all ${
                            activeTab === item.id
                                ? 'bg-primary text-white shadow-md'
                                : 'text-slate-600 hover:bg-slate-100'
                        }`}
                    >
                        <item.icon className="w-5 h-5" />
                        <span>{item.title}</span>
                    </button>
                ))}
            </nav>
        </aside>
    );
};

export default Sidebar;
