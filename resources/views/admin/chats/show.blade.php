@extends('layouts.admin')

@section('title', 'Ruang Obrolan')

@section('content')
<div class="container-fluid px-4 py-4 d-flex flex-column" style="height: calc(100vh - 100px);">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-shrink-0">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.chats.index') }}" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <h3 class="text-dark fw-bold mb-0">Obrolan dengan {{ $session->user_id ? optional($session->user)->name : $session->guest_name }}</h3>
        </div>
        <div>
            @if($session->status === 'open')
                <form action="{{ route('admin.chats.close', $session->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menutup sesi ini? Pengguna tidak akan bisa membalas lagi.')">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i> Tutup Sesi
                    </button>
                </form>
            @else
                <span class="badge bg-secondary p-2 shadow-sm">Sesi Ditutup</span>
            @endif
        </div>
    </div>

    <!-- Chat Interface -->
    <div class="card shadow-sm border-0 d-flex flex-column flex-grow-1 overflow-hidden rounded-3">
        
        <!-- Messages Area -->
        <div class="card-body overflow-auto p-4 bg-light d-flex flex-column gap-3" id="messages-container" style="scrollbar-width: thin;">
            <div class="text-center py-2">
                <span class="badge bg-white text-muted border px-3 py-2 rounded-pill shadow-sm">
                    Awal Obrolan
                </span>
            </div>
            
            <!-- Messages will be loaded here via JS if polling, but we also render initial state -->
        </div>

        <!-- Input Area -->
        <div class="card-footer bg-white border-top p-3 flex-shrink-0 {{ $session->status === 'closed' ? 'opacity-50 pointer-events-none' : '' }}">
            <form id="reply-form" class="d-flex gap-2" onsubmit="sendReply(event)">
                @csrf
                <input type="text" id="message-input" autocomplete="off" placeholder="{{ $session->status === 'closed' ? 'Sesi ini telah ditutup.' : 'Ketik balasan Anda...' }}" class="form-control p-3 bg-light border-0" {{ $session->status === 'closed' ? 'disabled' : '' }}>
                <button type="submit" class="btn btn-primary px-4 fw-bold" {{ $session->status === 'closed' ? 'disabled' : '' }}>
                    <i class="bi bi-send-fill me-1"></i> Kirim
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const messagesContainer = document.getElementById('messages-container');
    const sessionId = {{ $session->id }};
    const fetchUrl = `{{ route('admin.chats.messages', $session->id) }}`;
    const replyUrl = `{{ route('admin.chats.reply', $session->id) }}`;
    let lastMessageCount = 0;

    function fetchMessages() {
        axios.get(fetchUrl)
            .then(response => {
                const messages = response.data.messages;
                renderMessages(messages);
            })
            .catch(error => console.error("Error fetching messages:", error));
    }

    function renderMessages(messages) {
        if (!messages || messages.length === 0) return;
        if (messages.length === lastMessageCount) return;

        let html = `
            <div class="text-center py-2">
                <span class="badge bg-white text-muted border px-3 py-2 rounded-pill shadow-sm">
                    Awal Obrolan
                </span>
            </div>
        `;

        messages.forEach(msg => {
            const isAdmin = msg.sender_type === 'admin';
            
            if (isAdmin) {
                html += `
                <div class="d-flex justify-content-end mb-1">
                    <div class="bg-primary text-white rounded-4 rounded-end-0 py-2 px-3 shadow-sm" style="max-width: 75%;">
                        <p class="mb-0" style="font-size: 0.95rem;">${msg.message}</p>
                        <span class="text-white-50 d-block text-end mt-1" style="font-size: 0.7rem;">${formatTime(msg.created_at)}</span>
                    </div>
                </div>`;
            } else {
                html += `
                <div class="d-flex justify-content-start mb-1">
                    <div class="bg-white border text-dark rounded-4 rounded-start-0 py-2 px-3 shadow-sm" style="max-width: 75%;">
                        <div class="d-flex justify-content-between align-items-baseline mb-1">
                            <span class="small fw-bold text-primary">Pelanggan</span>
                            <span class="text-muted ms-3" style="font-size: 0.7rem;">${formatTime(msg.created_at)}</span>
                        </div>
                        <p class="mb-0" style="font-size: 0.95rem;">${msg.message}</p>
                    </div>
                </div>`;
            }
        });

        messagesContainer.innerHTML = html;
        scrollToBottom();
        lastMessageCount = messages.length;
    }

    function sendReply(e) {
        e.preventDefault();
        const input = document.getElementById('message-input');
        const msg = input.value.trim();
        
        if (!msg) return;

        input.value = '';
        
        axios.post(replyUrl, { message: msg, _token: '{{ csrf_token() }}' })
            .then(() => {
                fetchMessages();
            })
            .catch(error => alert('Gagal mengirim pesan'));
    }

    function formatTime(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute:'2-digit' });
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Initial fetch and set interval for polling
    fetchMessages();
    setInterval(fetchMessages, 3000);
</script>
@endsection
