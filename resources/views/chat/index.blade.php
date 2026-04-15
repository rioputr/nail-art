@extends('layouts.app')

@section('title', 'Live Chat')

@section('content')
<div class="container py-5" style="max-width: 800px;">
    <div class="card border-0 shadow rounded-4 overflow-hidden d-flex flex-column mb-5" style="height: 650px;">
        <!-- Header -->
        <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center z-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-chat-dots fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Konsultasi Live Chat</h5>
                    <small class="text-muted">Admin akan merespons pesan Anda</small>
                </div>
            </div>
            <div>
                <span id="connection-status" class="badge bg-light text-dark border px-3 py-2 rounded-pill d-flex align-items-center gap-2">
                    <span class="bg-secondary rounded-circle d-inline-block" style="width: 8px; height: 8px;" id="status-indicator"></span>
                    <span id="status-text" class="fw-normal">Siap Menerima Pesan</span>
                </span>
            </div>
        </div>

        <!-- Chat Area Container -->
        <div class="d-flex flex-column flex-grow-1 overflow-hidden position-relative" style="background-color: #fafafa;">
            
            <div id="closed-alert" class="d-none position-absolute top-0 start-0 w-100 z-3 alert alert-danger rounded-0 border-0 border-bottom text-center mb-0 p-2 shadow-sm">
                <small class="fw-medium">Sesi obrolan ini telah ditutup oleh admin.</small>
                <button onclick="window.location.reload()" class="btn btn-link btn-sm text-danger fw-bold text-decoration-none p-0 ms-2">Mulai Sesi Baru</button>
            </div>

            <!-- Messages List -->
            <div id="messages-container" class="flex-grow-1 overflow-auto p-4 d-flex flex-column gap-3" style="scrollbar-width: thin;">
                <div class="d-flex align-items-center justify-content-center h-100 text-muted small fw-medium">
                    <span class="placeholder-glow"><span class="placeholder col-12">Memuat percakapan...</span></span>
                </div>
            </div>

            <!-- Input Area -->
            <div id="input-area" class="card-footer bg-white p-3 border-top flex-shrink-0 opacity-50 pe-none" style="transition: all 0.3s;">
                <form id="send-message-form" class="d-flex gap-2">
                    <input type="text" id="message-input" autocomplete="off" placeholder="Tulis pesan Anda..." class="form-control bg-light border-0 rounded-pill px-4" style="height: 50px;">
                    <button type="submit" class="btn btn-primary-custom rounded-pill px-4 shadow-sm d-flex align-items-center gap-2" disabled>
                        <span>Kirim</span>
                        <i class="bi bi-send-fill fs-5"></i>
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (tokenMeta) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');
    }
    const isAuth = {{ Auth::check() ? 'true' : 'false' }};
    const inputArea = document.getElementById('input-area');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.querySelector('#send-message-form button');
    const messagesContainer = document.getElementById('messages-container');
    const statusText = document.getElementById('status-text');
    const statusIndicator = document.getElementById('status-indicator');
    const closedAlert = document.getElementById('closed-alert');
    
    let hasActiveSession = false;
    let pollInterval = null;
    let lastMessageCount = 0;

    // Check if we have an active session
    initChat();

    function initChat() {
        fetchMessages(true);
    }

    function fetchMessages(isInit = false) {
        axios.get('{{ route('chat.messages') }}')
            .then(response => {
                const messages = response.data.messages;
                const status = response.data.session_status;
                
                if (messages && messages.length > 0 || status === 'open') {
                    hasActiveSession = true;
                    if (status === 'open') {
                        enableInput();
                    } else if (status === 'closed') {
                        disableInput('Sesi telah ditutup');
                        closedAlert.classList.remove('d-none');
                    }
                    
                    if (isInit) startPolling();
                    renderMessages(messages);
                } else if (isInit) {
                    // Start offline messaging mode
                    enableInput();
                    statusText.innerText = 'Siap Menerima Pesan';
                    statusIndicator.className = 'bg-secondary rounded-circle d-inline-block';
                    messagesContainer.innerHTML = '<div class="text-center py-5 text-muted small">Ketik pesan Anda di bawah. Pesan akan disimpan dan admin akan segera membalasnya.</div>';
                }
            })
            .catch(error => {
                console.error('Error fetching messages:', error);
            });
    }

    function renderMessages(messages) {
        if (!messages || messages.length === 0) {
            messagesContainer.innerHTML = '<div class="text-center py-5 text-muted small">Belum ada pesan. Ketik pesan Anda di bawah.</div>';
            return;
        }

        if (messages.length === lastMessageCount) return; // No new messages

        let html = '';
        messages.forEach(msg => {
            const isMe = msg.sender_type !== 'admin';
            
            if (isMe) {
                html += `
                <div class="d-flex justify-content-end mb-1">
                    <div class="text-white py-2 px-3 shadow-sm rounded-4 rounded-bottom-end-0" style="background-color: #E91E63; max-width: 75%;">
                        <p class="mb-0" style="font-size:0.95rem;">${msg.message}</p>
                        <span class="d-block text-end mt-1 text-white-50" style="font-size: 0.70rem;">${formatTime(msg.created_at)}</span>
                    </div>
                </div>`;
            } else {
                html += `
                <div class="d-flex justify-content-start mb-1">
                    <div class="bg-white border text-dark py-2 px-3 shadow-sm rounded-4 rounded-bottom-start-0" style="max-width: 75%;">
                        <p class="fw-bold small text-primary-custom mb-1" style="color: #E91E63;">Admin</p>
                        <p class="mb-0" style="font-size:0.95rem;">${msg.message}</p>
                        <span class="d-block text-start text-muted mt-1" style="font-size: 0.70rem;">${formatTime(msg.created_at)}</span>
                    </div>
                </div>`;
            }
        });

        messagesContainer.innerHTML = html;
        scrollToBottom();
        lastMessageCount = messages.length;
    }

    document.getElementById('send-message-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const msg = messageInput.value.trim();
        if (!msg) return;

        messageInput.disabled = true;
        sendButton.disabled = true;

        if (!hasActiveSession) {
            // Optimistically start session since they typed a message
            axios.post('{{ route('chat.start') }}', {})
                .then(response => {
                    hasActiveSession = true;
                    startPolling();
                    sendMessage(msg);
                })
                .catch(error => {
                    console.error('Error starting session:', error);
                    alert('Gagal memulai sesi pesan.');
                    messageInput.disabled = false;
                    sendButton.disabled = false;
                });
        } else {
            sendMessage(msg);
        }
    });

    function sendMessage(msg) {
        messageInput.value = '';
        messageInput.disabled = false;
        sendButton.disabled = false;
        messageInput.focus();
        
        axios.post('{{ route('chat.send') }}', { message: msg })
            .then(response => {
                fetchMessages(); // refresh to get DB ID and real timestamp
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Gagal mengirim pesan.');
                messageInput.disabled = false;
                sendButton.disabled = false;
            });
    }

    function startPolling() {
        statusText.innerText = 'Online';
        statusIndicator.className = 'bg-success rounded-circle d-inline-block';

        if (pollInterval) clearInterval(pollInterval);
        
        fetchMessages(); // initial fetch
        
        pollInterval = setInterval(() => {
            fetchMessages();
        }, 3000); // Poll every 3 seconds
    }

    function formatTime(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute:'2-digit' });
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function enableInput() {
        inputArea.classList.remove('opacity-50', 'pe-none');
        messageInput.disabled = false;
        sendButton.disabled = false;
    }

    function disableInput(reason = null) {
        inputArea.classList.add('opacity-50', 'pe-none');
        messageInput.disabled = true;
        sendButton.disabled = true;
        if(reason) messageInput.placeholder = reason;
        
        if (pollInterval) {
            clearInterval(pollInterval); // stop polling if closed
            statusText.innerText = 'Sesi Berakhir';
            statusIndicator.className = 'bg-secondary rounded-circle d-inline-block';
        }
    }
});
</script>
@endsection
