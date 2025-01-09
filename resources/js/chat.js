import moment from 'moment';

document.addEventListener('DOMContentLoaded', initializeChat);

function initializeChat() {
    const conversationId = window.conversationId;
    const messageForm = document.getElementById('message-form');
    const messageContent = document.getElementById('message-content');
    const messageContainer = document.getElementById('message-container');
    const typingIndicator = document.getElementById('typing-indicator');

    if (!messageForm || !messageContent || !messageContainer || !typingIndicator) {
        console.error('One or more required elements are missing from the DOM.');
        return;
    }

    let isUserScrollingUp = false;
    let typingTimer;
    const typingInterval = 1000;
    let isUserInChat = true;

    // Event listeners
    messageContainer.addEventListener('scroll', handleScroll);
    messageForm.addEventListener('submit', sendMessage);

    // Subscribe to Laravel Echo private channel
    Echo.private(`chat-channel.${conversationId}`)
        .subscribed(() => {
            console.log(`Successfully subscribed to chat-channel.${conversationId}`);
            markMessagesAsRead(); // Marcar como leídos cuando el usuario abre la conversación
        })
        .listen('MessageSentEvent', (e) => {
            try {
                handleNewMessage(e);

                if (isUserInChat) {
                    markMessagesAsRead();
                }
            } catch (error) {
                console.error('Error handling MessageSentEvent:', error);
            }
        })
        .listen('MessageReadEvent', (e) => {
            try {
                // Handle MessageReadEvent if needed
            } catch (error) {
                console.error('Error handling MessageReadEvent:', error);
            }
        })
        .listenForWhisper('typing', (e) => {
            try {
                handleUserTyping(e);
            } catch (error) {
                console.error('Error handling typing whisper:', error);
            }
        })
        .listenForWhisper('stopTyping', (e) => {
            try {
                handleUserStoppedTyping(e);
            } catch (error) {
                console.error('Error handling stopTyping whisper:', error);
            }
        });

    scrollToBottom();

    function scrollToBottom() {
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    function handleScroll() {
        const isAtBottom = messageContainer.scrollHeight - messageContainer.scrollTop <= messageContainer.clientHeight + 10;
        isUserScrollingUp = !isAtBottom;
    }

    function startTyping() {
        if (messageContent.value.trim() === '') return;
        clearTimeout(typingTimer);
        typingTimer = setTimeout(stopTyping, typingInterval);

        Echo.private(`chat-channel.${conversationId}`)
            .whisper('typing', { user_id: window.authUserId, sender_name: window.authUserName });
    }

    function stopTyping() {
        Echo.private(`chat-channel.${conversationId}`)
            .whisper('stopTyping', { user_id: window.authUserId });
    }

    messageContent.addEventListener('input', startTyping);

    async function sendMessage(event) {
        event.preventDefault();
        const formData = new FormData(messageForm);

        try {
            const response = await fetch(window.messageStoreRoute, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            });
            const data = await response.json();
            if (data.message === 'Message sent successfully') {
                messageContent.value = '';
                addMessageToContainer(data.data);
                scrollToBottom();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    function addMessageToContainer(message) {
        const newMessage = createMessageElement(message);
        newMessage.classList.add('fade-in');
        messageContainer.appendChild(newMessage);
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    function handleNewMessage(e) {
        if (e.sender_id != window.authUserId) {
            const newMessage = createMessageElement(e);
            newMessage.classList.add('slide-in-right');
            messageContainer.appendChild(newMessage);
            if (!isUserScrollingUp) {
                scrollToBottom();
            }
        }
    }

    function handleUserTyping(e) {
        if (e.user_id != window.authUserId) {
            typingIndicator.textContent = `${e.sender_name} está escribiendo...`;
            typingIndicator.classList.add('typing-indicator');
            console.log(`${e.sender_name} is typing...`);
        }
    }

    function handleUserStoppedTyping(e) {
        if (e.user_id != window.authUserId) {
            typingIndicator.textContent = '';
            typingIndicator.classList.remove('typing-indicator');
            console.log(`stopped typing...`);
        }
    }

    function createMessageElement(message) {
        const newMessage = document.createElement('div');
        newMessage.classList.add('mb-4');
        newMessage.innerHTML = `
            ${message.sender_id == window.authUserId ? `
                <div class="text-right">
                    <div class="inline-block bg-blue-500 text-white p-2 rounded-lg max-w-full break-words">
                        <div>${message.content}</div>
                        <div class="text-xs text-gray-200 mt-1 flex items-center justify-end space-x-1">
                            <span>${moment(message.created_at).format('D MMM YYYY, H:mm')}</span>
                        </div>
                    </div>
                </div>
            ` : `
                <div class="text-left">
                    <div class="inline-block bg-gray-300 text-gray-900 p-2 rounded-lg max-w-full break-words">
                        <div class="font-bold">${message.sender_name}</div>
                        <div>${message.content}</div>
                        <div class="text-xs text-gray-600 mt-1">${moment(message.created_at).format('D MMM YYYY, H:mm')}</div>
                    </div>
                </div>
            `}
        `;
        return newMessage;
    }

    async function markMessagesAsRead() {
        try {
            const markAsReadUrl = window.markAsReadRoute.replace(':conversationId', conversationId);

            await fetch(markAsReadUrl, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            });

            console.log('Messages marked as read successfully for user:', window.authUserId);
        } catch (error) {
            console.error("Failed to mark messages as read:", error);
        }
    }
}
