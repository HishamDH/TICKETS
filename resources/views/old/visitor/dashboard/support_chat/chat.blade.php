@extends('visitor.layouts.app')
@section('title', 'الدردشة مع الدعم')

<style>
.chat-container {
 max-width: 700px;
 margin: 20px auto;
 background: #fff;
 border-radius: 10px;
 border: 1px solid #ccc;
 display: flex;
 flex-direction: column;
 height: 500px;
 overflow: hidden;
}

.chat-messages {
 flex: 1;
 padding: 15px;
 overflow-y: auto;
 background: #f9fafb;
}

.message {
 display: flex;
 align-items: center;
 gap: 10px;
 margin-bottom: 12px;
 max-width: 80%;
 word-wrap: break-word;
}

.message img {
 width: 40px;
 height: 40px;
 border-radius: 50%;
 object-fit: cover;
}

.message.sent {
 justify-content: flex-end;
 align-self: flex-end;
 text-align: right;
}

.message.received {
 justify-content: flex-start;
 align-self: flex-start;
 text-align: left;
}

.message .text {
 background-color: #e2e8f0;
 padding: 10px 15px;
 border-radius: 12px;
}

.message.sent .text {
 background-color: #d1e7dd;
}
.chat-input {
 display: flex;
 padding: 10px;
 border-top: 1px solid #ccc;
 background: #fff;
}
.chat-input input {
 flex: 1;
 padding: 10px;
 border: 1px solid #aaa;
 border-radius: 5px;
 margin-right: 10px;
}
.chat-input button {
 padding: 10px 20px;
 background: #0d6efd;
 color: white;
 border: none;
 border-radius: 5px;
 cursor: pointer;
}
</style>

@section('sub_content')
<div class="chat-container">
    <div class="chat-messages" id="chatMessages"></div>
    <div class="chat-input">
        <input type="text" id="messageInput" placeholder="اكتب رسالتك...">
        <button onclick="sendMessage()">إرسال</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const ticketId = {{ $chat->id }};
    const currentUserId = {{ auth()->id() }};

    function loadMessages() {
        $.get(`/visitor/support_chat/messages/${ticketId}`, function (data) {
            $('#chatMessages').html('');
            data.forEach(msg => {
                const isSent = msg.user_id == currentUserId;
                const className = isSent ? 'sent' : 'received';
                const image = msg.sender_image ? `/storage/${msg.sender_image}` : '/images/default-avatar.png';

                $('#chatMessages').append(`
                    <div class="message ${className}">
                        <img src="${image}" alt="img">
                        <div class="text">${msg.message}</div>
                    </div>
                `);
            });
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
        });
    }

    function sendMessage() {
        const msg = $('#messageInput').val().trim();
        if (msg === '') return;

        $.post(`/visitor/support_chat/send/${ticketId}`, {
            _token: '{{ csrf_token() }}',
            message: msg
        }, function () {
            $('#messageInput').val('');
            loadMessages();
        });
    }

    setInterval(loadMessages, 3000); // تحديث كل 3 ثوانٍ
    loadMessages(); // تحميل أولي
</script>
@endsection
