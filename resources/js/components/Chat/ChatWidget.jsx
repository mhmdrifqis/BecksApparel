import React, { useState, useEffect, useRef } from 'react';
import { MessageSquare, X, Send, Loader2, Bot, User, Trash2 } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';
import axios from 'axios';

const ChatWidget = () => {
    const [isOpen, setIsOpen] = useState(false);
    const [messages, setMessages] = useState([]);
    const [input, setInput] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const [lastId, setLastId] = useState(0);
    const scrollRef = useRef(null);

    // Initial load
    useEffect(() => {
        const handleOpen = () => setIsOpen(true);
        window.addEventListener('open-becks-chat', handleOpen);
        return () => window.removeEventListener('open-becks-chat', handleOpen);
    }, []);

    useEffect(() => {
        fetchMessages();
        const interval = setInterval(fetchMessages, 5000); // Polling every 5 seconds
        return () => clearInterval(interval);
    }, [lastId]);

    useEffect(() => {
        if (scrollRef.current) {
            scrollRef.current.scrollTop = scrollRef.current.scrollHeight;
        }
    }, [messages]);

    const fetchMessages = async () => {
        try {
            const response = await axios.get(`chat/messages?last_id=${lastId}`);
            if (response.data.messages.length > 0) {
                setMessages(prev => {
                    const existingIds = new Set(prev.map(m => m.id));
                    const newMessages = response.data.messages.filter(m => !existingIds.has(m.id));
                    return [...prev, ...newMessages];
                });
                const maxId = Math.max(...response.data.messages.map(m => m.id));
                setLastId(maxId);
            }
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    };

    const handleSend = async (e) => {
        e.preventDefault();
        if (!input.trim() || isLoading) return;

        const userMsg = input;
        setInput('');
        setIsLoading(true);

        try {
            await axios.post('chat/send', { message: userMsg });
            await fetchMessages();
        } catch (error) {
            console.error('Error sending message:', error);
        } finally {
            setIsLoading(false);
        }
    };

    const handleClear = async () => {
        if (!confirm("Hapus seluruh riwayat chat Anda? Tindakan ini tidak dapat dibatalkan.")) return;
        
        try {
            await axios.post('chat/clear');
            setMessages([]);
            setLastId(0);
        } catch (error) {
            console.error('Error clearing chat:', error);
        }
    };

    const quickReplies = [
        "Cara order",
        "Cek pesanan",
        "Harga jersey"
    ];

    return (
        <div className="fixed bottom-6 right-6 z-50 font-sans">
            {/* Toggle Button */}
            <motion.button
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                onClick={() => setIsOpen(!isOpen)}
                className="bg-lime-400 text-navy-950 p-4 rounded-full shadow-2xl hover:bg-lime-500 transition-colors flex items-center justify-center border-4 border-white/20"
            >
                {isOpen ? <X size={28} /> : <MessageSquare size={28} />}
            </motion.button>

            {/* Chat Window */}
            <AnimatePresence>
                {isOpen && (
                    <motion.div
                        initial={{ opacity: 0, y: 20, scale: 0.95, transformOrigin: 'bottom right' }}
                        animate={{ opacity: 1, y: 0, scale: 1 }}
                        exit={{ opacity: 0, y: 20, scale: 0.95 }}
                        className="absolute bottom-20 right-0 w-[380px] h-[550px] bg-slate-900 border border-white/10 rounded-3xl shadow-3xl overflow-hidden flex flex-col backdrop-blur-xl"
                    >
                        {/* Header */}
                        <div className="bg-gradient-to-r from-navy-950 to-slate-800 p-5 flex items-center justify-between border-b border-white/5">
                            <div className="flex items-center gap-3">
                                <div className="w-10 h-10 rounded-full bg-lime-400 flex items-center justify-center text-navy-950 shadow-[0_0_15px_rgba(163,230,53,0.3)]">
                                    <Bot size={24} />
                                </div>
                                <div>
                                    <h3 className="text-white font-bold text-lg leading-tight">Becks Assistant 🤖</h3>
                                    <p className="text-lime-400 text-xs font-medium flex items-center gap-1.5">
                                        <span className="w-1.5 h-1.5 rounded-full bg-lime-400 animate-pulse"></span>
                                        Online • Siap membantu
                                    </p>
                                </div>
                            </div>
                            
                            <button 
                                onClick={handleClear}
                                title="Hapus Riwayat Chat"
                                className="p-2 text-slate-500 hover:text-red-400 hover:bg-red-500/10 rounded-xl transition-all active:scale-95"
                            >
                                <Trash2 size={18} />
                            </button>
                        </div>

                        {/* Messages Area */}
                        <div 
                            ref={scrollRef}
                            className="flex-1 overflow-y-auto p-5 space-y-4 scrollbar-thin scrollbar-thumb-white/10"
                        >
                            {messages.length === 0 && (
                                <div className="text-center py-10">
                                    <div className="bg-slate-800/50 rounded-2xl p-6 mx-auto w-fit border border-white/5">
                                        <p className="text-slate-400 text-sm leading-relaxed">
                                            Halo! 👋 <br />
                                            Ada yang bisa saya bantu hari ini? <br />
                                            Tanya apa saja soal kustomisasi jersey tim Anda!
                                        </p>
                                    </div>
                                </div>
                            )}

                            {messages.map((msg) => (
                                <div 
                                    key={msg.id}
                                    className={`flex ${msg.sender === 'user' ? 'justify-end' : 'justify-start'}`}
                                >
                                    <div className={`
                                        max-w-[85%] p-4 rounded-2xl text-sm leading-relaxed
                                        ${msg.sender === 'user' 
                                            ? 'bg-lime-400 text-navy-950 rounded-tr-none font-medium' 
                                            : 'bg-slate-800 text-slate-200 border border-white/5 rounded-tl-none'}
                                    `}>
                                        {msg.message}
                                    </div>
                                </div>
                            ))}
                            
                            {isLoading && (
                                <div className="flex justify-start">
                                    <div className="bg-slate-800 text-slate-400 p-4 rounded-2xl rounded-tl-none border border-white/5 flex items-center gap-2">
                                        <Loader2 size={16} className="animate-spin" />
                                        <span>Bot sedang mengetik...</span>
                                    </div>
                                </div>
                            )}
                        </div>

                        {/* Input Area */}
                        <div className="p-5 bg-navy-950/50 border-t border-white/5">
                            {/* Quick Replies */}
                            {!isLoading && messages.length < 5 && (
                                <div className="flex flex-wrap gap-2 mb-4">
                                    {quickReplies.map((reply) => (
                                        <button
                                            key={reply}
                                            onClick={() => {
                                                setInput(reply);
                                            }}
                                            className="text-[10px] px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-full border border-white/10 transition-colors uppercase tracking-wider font-bold"
                                        >
                                            {reply}
                                        </button>
                                    ))}
                                </div>
                            )}

                            <form onSubmit={handleSend} className="relative">
                                <input
                                    type="text"
                                    value={input}
                                    onChange={(e) => setInput(e.target.value)}
                                    placeholder="Ketik pesan Anda..."
                                    className="w-full bg-slate-800 text-white rounded-xl px-4 py-3.5 pr-12 focus:outline-none focus:ring-2 focus:ring-lime-400/50 border border-white/10 text-sm transition-all"
                                />
                                <button
                                    type="submit"
                                    disabled={isLoading || !input.trim()}
                                    className="absolute right-2 top-2 p-2 text-lime-400 hover:text-lime-300 disabled:opacity-50 disabled:text-slate-500 transition-colors"
                                >
                                    <Send size={20} />
                                </button>
                            </form>
                            <p className="text-[10px] text-slate-600 mt-2 text-center uppercase tracking-tighter">Powered by Becks NLP AI</p>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>
        </div>
    );
};

export default ChatWidget;
