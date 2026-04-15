<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController 
{
    public function index()
    {
        return view('chat.index');
    }

    public function startSession(Request $request)
    {
        $session = $this->getCurrentSession($request);
        if (!$session) {
            if (Auth::check()) {
                $session = ChatSession::create([
                    'user_id' => Auth::id(),
                    'guest_name' => Auth::user()->name,
                    'guest_email' => Auth::user()->email,
                    'status' => 'open'
                ]);
            } else {
                $token = Str::random(40);
                $session = ChatSession::create([
                    'guest_token' => $token,
                    'guest_name' => 'Guest_' . substr($token, 0, 5),
                    'guest_email' => null,
                    'status' => 'open'
                ]);
                $request->session()->put('chat_guest_token', $token);
            }
        }
        return response()->json([
            'session' => $session
        ]);
    }

    public function fetchMessages(Request $request)
    {
        $session = $this->getCurrentSession($request);

        if (!$session) {
            return response()->json(['messages' => []]);
        }

        $messages = $session->messages()->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages, 'session_status' => $session->status]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $session = $this->getCurrentSession($request);

        if (!$session) {
            return response()->json(['error' => 'No active session'], 400);
        }

        if ($session->status === 'closed') {
            return response()->json(['error' => 'Session is closed'], 400);
        }

        $message = ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type' => Auth::check() ? 'user' : 'guest',
            'sender_id' => Auth::id(), // null for guest
            'message' => $request->message,
        ]);

        return response()->json(['message' => $message]);
    }

    private function getCurrentSession(Request $request)
    {
        if (Auth::check()) {
            return ChatSession::where('user_id', Auth::id())
                              ->orderBy('created_at', 'desc')
                              ->first();
        }

        $token = $request->session()->get('chat_guest_token');
        if ($token) {
            return ChatSession::where('guest_token', $token)
                              ->orderBy('created_at', 'desc')
                              ->first();
        }

        return null;
    }
}
