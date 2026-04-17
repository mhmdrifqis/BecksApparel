import React, { useState, useEffect, useRef, useMemo } from 'react';
import { User, MessageSquare, Bot, Send, Search, CheckCircle2, Loader2 } from 'lucide-react';
import axios from 'axios';

const ChatAdmin = () => {
    const [sessions, setSessions] = useState([]);
    const [selectedId, setSelectedId] = useState(null);
    const [messages, setMessages] = useState([]);
    const [input, setInput] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const [isToggling, setIsToggling] = useState(false);
    const [search, setSearch] = useState('');
    const scrollRef = useRef(null);

    // Deriving active session from the list ensures it's always the latest data
    const activeSession = useMemo(() => {
        return sessions.find(s => s.id === selectedId) || null;
    }, [sessions, selectedId]);

    useEffect(() => {
        fetchSessions();
        const interval = setInterval(fetchSessions, 3000);
        return () => clearInterval(interval);
    }, []);

    useEffect(() => {
        if (selectedId) {
            fetchMessages(selectedId);
            const interval = setInterval(() => fetchMessages(selectedId), 3000);
            return () => clearInterval(interval);
        }
    }, [selectedId]);

    // Smart Scrolling logic
    useEffect(() => {
        if (scrollRef.current) {
            const { scrollTop, scrollHeight, clientHeight } = scrollRef.current;
            const isAtBottom = scrollHeight - scrollTop <= clientHeight + 100;

            // Only snap to bottom if user is already near the bottom
            if (isAtBottom) {
                scrollRef.current.scrollTop = scrollHeight;
            }
        }
    }, [messages]);

    const fetchSessions = async () => {
        try {
            const response = await axios.get('admin/chat/sessions');
            setSessions(response.data);
        } catch (error) {
            console.error('Error fetching sessions:', error);
        }
    };

    const fetchMessages = async (sessionId) => {
        try {
            const response = await axios.get(`admin/chat/sessions/${sessionId}`);
            setMessages(response.data.messages);
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    };

    const handleSelectSession = (sessionId) => {
        setSelectedId(sessionId);
        setMessages([]); // Clear old messages immediately for better UX
        fetchMessages(sessionId);
    };

    const handleSend = async (e) => {
        e.preventDefault();
        if (!input.trim() || !selectedId || isLoading) return;

        setIsLoading(true);
        try {
            await axios.post(`admin/chat/sessions/${selectedId}/reply`, {
                message: input
            });
            setInput('');
            await fetchMessages(selectedId);
            await fetchSessions(); // Update sidebar last message
            
            // Force scroll to bottom only on manual send
            if (scrollRef.current) {
                scrollRef.current.scrollTop = scrollRef.current.scrollHeight;
            }
        } catch (error) {
            console.error('Error sending reply:', error);
        } finally {
            setIsLoading(true); // Small delay before allowing send again
            setTimeout(() => setIsLoading(false), 500);
        }
    };

    const toggleMode = async (mode) => {
        if (!selectedId || isToggling) return;
        setIsToggling(true);
        try {
            await axios.post(`admin/chat/sessions/${selectedId}/toggle`, { mode });
            await fetchSessions();
            await fetchMessages(selectedId);
        } catch (error) {
            console.error('Error toggling mode:', error);
        } finally {
            setIsToggling(false);
        }
    };

    const filteredSessions = sessions.filter(s => 
        (s.user?.name || s.session_token).toLowerCase().includes(search.toLowerCase())
    );

    return (
        <div className="flex h-[700px] bg-slate-900 rounded-3xl overflow-hidden border border-white/10 shadow-3xl text-slate-200">
            {/* Sidebar: Session List (Always Persistent) */}
            <div className="w-[350px] border-r border-white/10 flex flex-col bg-navy-950/50 shrink-0">
                <div className="p-6 border-b border-white/5">
                    <div className="flex items-center justify-between mb-4">
                        <h2 className="text-xl font-bold text-white">Chat Monitoring</h2>
                        {sessions.filter(s => s.mode === 'admin').length > 0 && (
                            <span className="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full animate-pulse shadow-[0_0_10px_rgba(239,68,68,0.5)]">
                                {sessions.filter(s => s.mode === 'admin').length} WAITING
                            </span>
                        )}
                    </div>
                    <div className="relative">
                        <Search className="absolute left-3 top-3 text-slate-500" size={18} />
                        <input
                            type="text"
                            placeholder="Cari user / ID..."
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="w-full bg-slate-800 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-lime-400/50 border border-white/5"
                        />
                    </div>
                </div>
                
                <div className="flex-1 overflow-y-auto">
                    {filteredSessions.map((session) => (
                        <div
                            key={session.id}
                            onClick={() => handleSelectSession(session.id)}
                            className={`p-4 flex items-center gap-4 cursor-pointer hover:bg-slate-800/50 transition-colors border-b border-white/5 relative group ${selectedId === session.id ? 'bg-slate-800/80 border-l-4 border-l-lime-400' : ''}`}
                        >
                            <div className="relative">
                                <div className="w-12 h-12 rounded-full bg-slate-700 flex items-center justify-center text-slate-400">
                                    <User size={24} />
                                </div>
                                {session.mode === 'admin' && (
                                    <span className="absolute -top-1 -right-1 w-4 h-4 bg-red-500 border-2 border-slate-900 rounded-full animate-bounce"></span>
                                )}
                            </div>
                            <div className="flex-1 min-w-0">
                                <div className="flex justify-between items-start">
                                    <h4 className="font-bold text-sm text-white truncate">
                                        {session.user?.name || `Guest: ${session.session_token.substring(0, 8)}`}
                                    </h4>
                                    <span className="text-[10px] text-slate-500">
                                        {new Date(session.last_message_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                    </span>
                                </div>
                                <p className="text-xs text-slate-400 truncate mt-1">
                                    {session.messages?.[0]?.message || 'No messages'}
                                </p>
                                <div className="mt-2 flex items-center gap-2">
                                    {session.mode === 'bot' ? (
                                        <span className="text-[9px] px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded-full font-bold uppercase tracking-wider flex items-center gap-1">
                                            <Bot size={10} /> AI Mode
                                        </span>
                                    ) : (
                                        <span className="text-[9px] px-2 py-0.5 bg-lime-500/20 text-lime-400 rounded-full font-bold uppercase tracking-wider flex items-center gap-1 shadow-[0_0_10px_rgba(132,204,22,0.2)]">
                                            <User size={10} /> Admin Takeover
                                        </span>
                                    )}
                                </div>
                            </div>
                        </div>
                    ))}
                    {filteredSessions.length === 0 && (
                        <div className="p-10 text-center text-slate-600 text-sm">
                            Tidak ada session ditemukan.
                        </div>
                    )}
                </div>
            </div>

            {/* Main: Chat View */}
            <div className="flex-1 flex flex-col bg-navy-900/40 relative">
                {activeSession ? (
                    <>
                        {/* Chat Header */}
                        <div className="p-5 border-b border-white/5 bg-navy-950/60 flex justify-between items-center backdrop-blur-md sticky top-0 z-10">
                            <div className="flex items-center gap-4">
                                <div className="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-slate-400 shadow-inner">
                                    <User size={20} />
                                </div>
                                <div>
                                    <h3 className="font-bold text-white leading-tight">
                                        {activeSession.user?.name || `Guest User (${activeSession.id.toString().substring(0, 8)})`}
                                    </h3>
                                    <p className="text-[10px] text-slate-500 font-mono">
                                        SESSION ID: {activeSession.id}
                                    </p>
                                </div>
                            </div>

                            <div className="flex gap-2">
                                <div className="flex bg-slate-800/80 p-1 rounded-xl border border-white/5 h-fit shadow-lg">
                                    <button
                                        onClick={() => toggleMode('bot')}
                                        disabled={isToggling}
                                        className={`flex items-center gap-2 px-4 py-1.5 rounded-lg text-xs font-bold transition-all ${activeSession.mode === 'bot' ? 'bg-blue-500 text-white shadow-lg scale-105' : 'text-slate-400 hover:text-slate-200'}`}
                                    >
                                        <Bot size={14} /> AI Bot
                                    </button>
                                    <button
                                        onClick={() => toggleMode('admin')}
                                        disabled={isToggling}
                                        className={`flex items-center gap-2 px-4 py-1.5 rounded-lg text-xs font-bold transition-all ${activeSession.mode === 'admin' ? 'bg-lime-500 text-navy-950 shadow-lg scale-105' : 'text-slate-400 hover:text-slate-200'}`}
                                    >
                                        <User size={14} /> Human
                                    </button>
                                </div>
                                
                                {activeSession.mode === 'admin' && (
                                    <button
                                        onClick={() => {
                                            if (confirm('Akhiri sesi bantuan manusia dan kembalikan ke AI Bot?')) {
                                                toggleMode('bot');
                                            }
                                        }}
                                        disabled={isToggling}
                                        className="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 px-4 py-1.5 rounded-xl text-[10px] font-black tracking-tighter transition-all flex items-center gap-1 active:scale-95"
                                    >
                                        <CheckCircle2 size={12} /> AKHIRI CHAT
                                    </button>
                                )}
                            </div>
                        </div>

                        {/* Messages Area */}
                        <div 
                            ref={scrollRef}
                            className="flex-1 overflow-y-auto p-6 space-y-4 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] bg-fixed scroll-smooth"
                        >
                            {messages.map((msg) => (
                                <div 
                                    key={msg.id}
                                    className={`flex ${msg.sender === 'user' ? 'justify-start' : 'justify-end'} animate-in fade-in slide-in-from-bottom-2 duration-300`}
                                >
                                    <div className="max-w-[75%] group">
                                        <div className="flex items-center gap-2 mb-1 px-1">
                                            <span className={`text-[10px] font-bold uppercase tracking-widest ${msg.sender === 'user' ? 'text-slate-500' : 'text-lime-400'}`}>
                                                {msg.sender === 'user' ? 'CUSTOMER' : (msg.sender === 'bot' ? 'AI BOT' : 'ADMIN')}
                                            </span>
                                            <span className="text-[9px] text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                                {new Date(msg.created_at).toLocaleTimeString()}
                                            </span>
                                        </div>
                                        <div className={`
                                            p-3.5 rounded-2xl text-sm leading-relaxed shadow-sm
                                            ${msg.sender === 'user' 
                                                ? 'bg-slate-800 text-slate-200 rounded-tl-none border border-white/5' 
                                                : (msg.sender === 'bot' 
                                                    ? 'bg-blue-900/40 text-blue-100 border border-blue-500/30' 
                                                    : 'bg-lime-500 text-navy-950 font-medium rounded-tr-none shadow-lime-500/20 shadow-md')}
                                        `}>
                                            {msg.message}
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Input Area */}
                        <div className="p-6 bg-navy-950/90 border-t border-white/10 backdrop-blur-sm">
                            {activeSession.mode === 'bot' && (
                                <div className="mb-4 p-3 bg-blue-500/10 border border-blue-500/20 rounded-xl flex items-center gap-3">
                                    <Bot size={20} className="text-blue-400 shrink-0" />
                                    <p className="text-[11px] text-blue-200">
                                        Bot sedang aktif. Balasan Anda akan otomatis mematikan Bot dan memicu <b>Admin Takeover</b>.
                                    </p>
                                </div>
                            )}
                            <form onSubmit={handleSend} className="relative">
                                <textarea
                                    value={input}
                                    onChange={(e) => setInput(e.target.value)}
                                    placeholder="Ketik balasan untuk customer..."
                                    rows="2"
                                    className="w-full bg-slate-800 text-white rounded-2xl px-5 py-4 pr-16 focus:outline-none focus:ring-2 focus:ring-lime-400/50 border border-white/10 text-sm resize-none transition-all placeholder:text-slate-600"
                                    onKeyDown={(e) => {
                                        if (e.key === 'Enter' && !e.shiftKey) {
                                            e.preventDefault();
                                            handleSend(e);
                                        }
                                    }}
                                />
                                <button
                                    type="submit"
                                    disabled={isLoading || !input.trim() || !selectedId}
                                    className="absolute right-3 bottom-3 p-3 bg-lime-400 text-navy-950 rounded-xl hover:bg-lime-500 disabled:opacity-50 transition-all shadow-lg active:scale-90"
                                >
                                    {isLoading ? <Loader2 className="animate-spin" size={20} /> : <Send size={20} />}
                                </button>
                            </form>
                        </div>
                    </>
                ) : (
                    <div className="flex-1 flex flex-col items-center justify-center text-slate-500 p-10 text-center bg-navy-900/20">
                        <div className="w-24 h-24 rounded-3xl bg-slate-800/50 flex items-center justify-center mb-8 border border-white/5 shadow-2xl">
                            <MessageSquare size={48} className="text-slate-700" />
                        </div>
                        <h3 className="text-2xl font-bold text-slate-400 mb-2">Pilih Percakapan</h3>
                        <p className="max-w-xs text-sm leading-relaxed text-slate-600">
                            Pilih salah satu percakapan di samping untuk mulai memantau atau mengambil alih chat dari AI.
                        </p>
                    </div>
                )}
            </div>
        </div>
    );
};

export default ChatAdmin;
