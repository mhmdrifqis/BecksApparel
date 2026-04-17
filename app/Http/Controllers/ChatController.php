<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Get or Create a chat session
     */
    private function getSession(Request $request)
    {
        $token = $request->header('X-Chat-Token') ?: $request->session()->get('chat_token');
        
        if (!$token) {
            $token = (string) Str::uuid();
            $request->session()->put('chat_token', $token);
        }

        return ChatSession::firstOrCreate(
            ['session_token' => $token],
            [
                'user_id' => Auth::id(),
                'mode' => 'bot',
                'is_active' => true,
                'last_message_at' => now()
            ]
        );
    }

    /**
     * User sends a message
     */
    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        
        $session = $this->getSession($request);
        $messageText = $request->message;

        // 1. Save User Message
        $userMsg = ChatMessage::create([
            'session_id' => $session->id,
            'sender' => 'user',
            'message' => $messageText
        ]);

        $session->update(['last_message_at' => now()]);

        // 2. If in BOT mode, call FastAPI
        if ($session->mode === 'bot') {
            try {
                $response = Http::post('http://localhost:8000/chatbot', [
                    'message' => $messageText,
                    'user_id' => $session->id
                ]);

                if ($response->successful()) {
                    $botReply = $response->json('message');
                    
                    // Save Bot Reply
                    ChatMessage::create([
                        'session_id' => $session->id,
                        'sender' => 'bot',
                        'message' => $botReply
                    ]);

                    // Check if FastAPI triggered "handover"
                    if ($response->json('status') === 'handover') {
                        $session->update(['mode' => 'admin']);
                    }
                }
            } catch (\Exception $e) {
                // Fallback if FastAPI is down
                ChatMessage::create([
                    'session_id' => $session->id,
                    'sender' => 'bot',
                    'message' => 'Maaf, sistem asisten kami sedang mengalami gangguan. Mohon tunggu sejenak atau hubungi admin kami.'
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'session_token' => $session->session_token,
            'mode' => $session->mode
        ]);
    }

    /**
     * Get messages for polling
     */
    public function getMessages(Request $request)
    {
        $session = $this->getSession($request);
        $lastId = $request->query('last_id', 0);

        $messages = ChatMessage::where('session_id', $session->id)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
            'mode' => $session->mode
        ]);
    }

    /**
     * Admin: List all sessions
     */
    public function adminSessions()
    {
        $sessions = ChatSession::with(['user', 'messages' => function($q) {
                $q->latest()->limit(1);
            }])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return response()->json($sessions);
    }

    /**
     * Admin: Get specific session chat
     */
    public function adminShowChat(ChatSession $session)
    {
        return response()->json([
            'session' => $session->load('user'),
            'messages' => $session->messages()->orderBy('created_at', 'asc')->get()
        ]);
    }

    /**
     * Admin: Send manual reply
     */
    public function adminReply(Request $request, ChatSession $session)
    {
        $request->validate(['message' => 'required|string']);

        $message = ChatMessage::create([
            'session_id' => $session->id,
            'sender' => 'admin',
            'message' => $request->message
        ]);

        $session->update([
            'last_message_at' => now(),
            'mode' => 'admin' // Force admin mode when admin replies
        ]);

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    /**
     * Admin: Toggle Mode
     */
    public function toggleMode(Request $request, ChatSession $session)
    {
        $request->validate(['mode' => 'required|in:bot,admin']);
        
        $session->update(['mode' => $request->mode]);

        // Always send follow-up message when reverting to bot mode
        if ($request->mode === 'bot') {
            ChatMessage::create([
                'session_id' => $session->id,
                'sender' => 'bot',
                'message' => 'Ada lagi yang bisa kami bantu? 😊'
            ]);
            $session->update(['last_message_at' => now()]);
        }

        return response()->json(['status' => 'success', 'mode' => $session->mode]);
    }

    /**
     * Admin: Get notification count (active admin sessions)
     */
    public function adminNotificationCount()
    {
        $count = \App\Models\ChatSession::where('mode', 'admin')->where('is_active', true)->count();
        return response()->json(['count' => $count]);
    }

    /**
     * User: Clear chat history
     */
    public function clearChat(Request $request)
    {
        $session = $this->getSession($request);
        
        // Delete all messages
        $session->messages()->delete();

        // Optionally reset state to bot and update timestamp
        $session->update([
            'mode' => 'bot',
            'last_message_at' => now(),
            'is_active' => true
        ]);

        return response()->json(['status' => 'success', 'message' => 'Chat cleared']);
    }
}
