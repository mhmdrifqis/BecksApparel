import React, { useState, useEffect } from 'react';
import { Plus, Trash2, Save, RefreshCw, ChevronDown, ChevronUp, MessageCircle } from 'lucide-react';
import axios from 'axios';

const IntentManager = () => {
    const [intents, setIntents] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [retraining, setRetraining] = useState(false);
    const [expandedIntent, setExpandedIntent] = useState(null);

    // FastAPI URL
    const FASTAPI_URL = 'http://localhost:8000';

    useEffect(() => {
        fetchIntents();
    }, []);

    const fetchIntents = async () => {
        setIsLoading(true);
        try {
            const response = await axios.get(`${FASTAPI_URL}/admin/intents`);
            setIntents(response.data);
        } catch (error) {
            console.error('Error fetching intents:', error);
        } finally {
            setIsLoading(false);
        }
    };

    const handleSave = async (intentData) => {
        try {
            await axios.post(`${FASTAPI_URL}/admin/intents`, intentData);
            alert('Intent saved successfully!');
            fetchIntents();
        } catch (error) {
            console.error('Error saving intent:', error);
            alert('Error saving intent.');
        }
    };

    const handleDelete = async (intentName) => {
        if (!confirm(`Are you sure you want to delete intent "${intentName}"?`)) return;
        try {
            await axios.delete(`${FASTAPI_URL}/admin/intents/${intentName}`);
            fetchIntents();
        } catch (error) {
            console.error('Error deleting intent:', error);
        }
    };

    const handleRetrain = async () => {
        setRetraining(true);
        try {
            const response = await axios.post(`${FASTAPI_URL}/admin/retrain`);
            alert(response.data.message);
        } catch (error) {
            console.error('Error retraining model:', error);
            alert('Error retraining model.');
        } finally {
            setRetraining(false);
        }
    };

    const addNewIntent = () => {
        const newIntentName = prompt("Enter new intent name (e.g., promo_ramadan):");
        if (!newIntentName) return;
        
        const newIntent = {
            intent: newIntentName,
            patterns: [],
            response: "Default response"
        };
        setIntents([newIntent, ...intents]);
        setExpandedIntent(newIntentName);
    };

    return (
        <div className="bg-slate-900 rounded-3xl overflow-hidden border border-white/10 shadow-3xl p-8 text-slate-200">
            <div className="flex justify-between items-center mb-8">
                <div>
                    <h2 className="text-2xl font-black text-white">Chatbot Intelligence</h2>
                    <p className="text-slate-400 mt-1">Kelola intent, pattern pertanyaan, dan jawaban otomatis asisten AI.</p>
                </div>
                <div className="flex gap-4">
                    <button 
                        onClick={addNewIntent}
                        className="bg-slate-800 hover:bg-slate-700 text-white px-5 py-2.5 rounded-xl border border-white/10 transition flex items-center gap-2 text-sm font-bold"
                    >
                        <Plus size={18} /> Tambah Intent
                    </button>
                    <button 
                        onClick={handleRetrain}
                        disabled={retraining}
                        className="bg-lime-400 hover:bg-lime-500 text-navy-950 px-5 py-2.5 rounded-xl transition flex items-center gap-2 text-sm font-black disabled:opacity-50 shadow-[0_0_20px_rgba(163,230,53,0.3)]"
                    >
                        <RefreshCw size={18} className={retraining ? 'animate-spin' : ''} />
                        {retraining ? 'Latih Ulang...' : 'Latih AI Sekarang'}
                    </button>
                </div>
            </div>

            {isLoading ? (
                <div className="text-center py-20 text-slate-500">Memuat data intent...</div>
            ) : (
                <div className="space-y-4">
                    {intents.map((item) => (
                        <div key={item.intent} className="bg-navy-950/50 border border-white/5 rounded-2xl overflow-hidden transition-all">
                            <div 
                                onClick={() => setExpandedIntent(expandedIntent === item.intent ? null : item.intent)}
                                className="p-5 flex justify-between items-center cursor-pointer hover:bg-white/[0.02]"
                            >
                                <div className="flex items-center gap-4">
                                    <div className="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-lime-400 border border-white/5">
                                        <MessageCircle size={20} />
                                    </div>
                                    <div>
                                        <h4 className="font-bold text-white text-lg">{item.intent}</h4>
                                        <p className="text-xs text-slate-500 uppercase tracking-widest font-bold mt-0.5">
                                            {item.patterns.length} Patterns &bull; 1 Response
                                        </p>
                                    </div>
                                </div>
                                {expandedIntent === item.intent ? <ChevronUp className="text-slate-500" /> : <ChevronDown className="text-slate-500" />}
                            </div>

                            {expandedIntent === item.intent && (
                                <div className="p-6 border-t border-white/5 bg-navy-900/20">
                                    <div className="grid lg:grid-cols-2 gap-8">
                                        {/* Patterns */}
                                        <div>
                                            <div className="flex justify-between items-center mb-4">
                                                <label className="text-sm font-bold text-slate-300 uppercase tracking-widest">Training Patterns (Pertanyaan)</label>
                                                <button 
                                                    onClick={() => {
                                                        const p = prompt("Enter new pattern:");
                                                        if (p) {
                                                            const newIntents = [...intents];
                                                            const idx = newIntents.findIndex(i => i.intent === item.intent);
                                                            newIntents[idx].patterns.push(p);
                                                            setIntents(newIntents);
                                                        }
                                                    }}
                                                    className="text-xs text-lime-400 font-bold hover:underline"
                                                >
                                                    + Tambah Pattern
                                                </button>
                                            </div>
                                            <div className="bg-slate-800/50 rounded-xl border border-white/5 p-4 min-h-[150px] max-h-[300px] overflow-y-auto space-y-2">
                                                {item.patterns.map((p, pIdx) => (
                                                    <div key={pIdx} className="group flex justify-between items-center bg-navy-950 px-3 py-2 rounded-lg border border-white/5 text-sm">
                                                        <span>{p}</span>
                                                        <button 
                                                            onClick={() => {
                                                                const newIntents = [...intents];
                                                                const idx = newIntents.findIndex(i => i.intent === item.intent);
                                                                newIntents[idx].patterns.splice(pIdx, 1);
                                                                setIntents(newIntents);
                                                            }}
                                                            className="text-slate-600 hover:text-red-400 opacity-0 group-hover:opacity-100 transition"
                                                        >
                                                            <Trash2 size={14} />
                                                        </button>
                                                    </div>
                                                ))}
                                                {item.patterns.length === 0 && <p className="text-slate-600 text-center py-10 italic">Belum ada training data.</p>}
                                            </div>
                                        </div>

                                        {/* Response */}
                                        <div>
                                            <label className="block text-sm font-bold text-slate-300 uppercase tracking-widest mb-4">Chatbot Response (Jawaban)</label>
                                            <textarea 
                                                className="w-full bg-slate-800 rounded-xl p-4 text-sm border border-white/5 focus:ring-2 focus:ring-lime-400/50 outline-none min-h-[150px]"
                                                value={item.response}
                                                onChange={(e) => {
                                                    const newIntents = [...intents];
                                                    const idx = newIntents.findIndex(i => i.intent === item.intent);
                                                    newIntents[idx].response = e.target.value;
                                                    setIntents(newIntents);
                                                }}
                                            />
                                        </div>
                                    </div>

                                    <div className="mt-8 pt-6 border-t border-white/5 flex justify-end gap-3">
                                        <button 
                                            onClick={() => handleDelete(item.intent)}
                                            className="px-6 py-2.5 text-red-400 text-sm font-bold hover:text-red-300 transition"
                                        >
                                            Hapus Intent
                                        </button>
                                        <button 
                                            onClick={() => handleSave(item)}
                                            className="bg-lime-400 hover:bg-lime-500 text-navy-950 px-8 py-2.5 rounded-xl font-black text-sm flex items-center gap-2 transition"
                                        >
                                            <Save size={18} /> Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            )}
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};

export default IntentManager;
