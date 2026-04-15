<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController
{
    public function index()
    {
        $sessions = ChatSession::orderBy('updated_at', 'desc')->get();
        return view('admin.chats.index', compact('sessions'));
    }

    public function show($id)
    {
        $session = ChatSession::with('messages')->findOrFail($id);
        
        // Mark unread messages from user/guest as read
        $session->messages()->whereIn('sender_type', ['user', 'guest'])->update(['is_read' => true]);

        return view('admin.chats.show', compact('session'));
    }

    public function fetchMessages($id)
    {
        $session = ChatSession::findOrFail($id);
        $messages = $session->messages()->orderBy('created_at', 'asc')->get();

        return response()->json([
            'messages' => $messages,
            'session_status' => $session->status
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $session = ChatSession::findOrFail($id);

        if ($session->status === 'closed') {
            return back()->with('error', 'Sesi obrolan ini sudah ditutup.');
        }

        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type' => 'admin',
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Touch the session to update 'updated_at' so it moves to top of list
        $session->touch();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Pesan terkirim.');
    }

    public function close($id)
    {
        $session = ChatSession::findOrFail($id);
        $session->update(['status' => 'closed']);

        return back()->with('success', 'Sesi obrolan telah ditutup.');
    }

    public function destroy($id)
    {
        $session = ChatSession::findOrFail($id);
        $session->messages()->delete();
        $session->delete();

        return redirect()->route('admin.chats.index')->with('success', 'Riwayat obrolan telah dihapus.');
    }
}
