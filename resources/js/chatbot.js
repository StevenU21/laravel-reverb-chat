document.addEventListener('DOMContentLoaded', function () {
    const messageForm = document.getElementById('message-form');
    const messageContentInput = document.getElementById('message-content');
    const messageContainer = document.getElementById('message-container');
    const typingIndicator = document.getElementById('typing-indicator');

    messageForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const messageContent = messageContentInput.value.trim();

        if (!validateMessage(messageContent)) {
            alert('Por favor, escribe un mensaje.');
            return;
        }

        displayUserMessage(messageContent);
        messageContentInput.value = '';
        scrollToBottom(messageContainer);

        typingIndicator.textContent = 'Chatbot is typing...';

        try {
            const response = await sendMessageToServer(messageContent);
            displayBotMessage(response.bot_message);
        } catch (error) {
            displayErrorMessage();
        } finally {
            typingIndicator.textContent = '';
            scrollToBottom(messageContainer);
        }
    });

    function validateMessage(message) {
        return message !== '';
    }

    function displayUserMessage(message) {
        const userMessageHtml = `
            <div class="mb-4 text-right">
                <div class="inline-block bg-blue-500 text-white p-2 rounded-lg max-w-full break-words">
                    <div>${message}</div>
                    <div class="text-xs text-gray-200 mt-1 flex items-center justify-end">
                        <span>${new Date().toLocaleTimeString()}</span>
                    </div>
                </div>
            </div>
        `;
        messageContainer.insertAdjacentHTML('beforeend', userMessageHtml);
    }

    function displayBotMessage(message) {
        const botMessageHtml = `
            <div class="mb-4 text-left">
                <div class="inline-block bg-gray-300 text-gray-900 p-2 rounded-lg max-w-full break-words">
                    <div class="font-bold">Chatbot</div>
                    <div>${message}</div>
                    <div class="text-xs text-gray-600 mt-1">${new Date().toLocaleTimeString()}</div>
                </div>
            </div>
        `;
        messageContainer.insertAdjacentHTML('beforeend', botMessageHtml);
    }

    function displayErrorMessage() {
        const errorMessageHtml = `
            <div class="mb-4 text-left">
                <div class="inline-block bg-red-500 text-gray p-2 rounded-lg max-w-full break-words">
                    <div>Error: No se pudo procesar tu mensaje. Inténtalo más tarde.</div>
                </div>
            </div>
        `;
        messageContainer.insertAdjacentHTML('beforeend', errorMessageHtml);
    }

    function scrollToBottom(container) {
        container.scrollTop = container.scrollHeight;
    }

    async function sendMessageToServer(message) {
        const response = await fetch('/chatbot/post', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message })
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        return response.json();
    }
});
