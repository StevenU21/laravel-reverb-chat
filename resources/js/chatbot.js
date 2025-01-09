document.addEventListener('DOMContentLoaded', function () {
    const chatbotMessageForm = document.getElementById('chatbot-message-form');
    const chatbotMessageContentInput = document.getElementById('chatbot-message-content');
    const chatbotMessageContainer = document.getElementById('chatbot-message-container');
    const chatbotTypingIndicator = document.getElementById('chatbot-typing-indicator');

    if (!chatbotMessageForm || !chatbotMessageContentInput || !chatbotMessageContainer || !chatbotTypingIndicator) {
        console.error('One or more required elements are missing from the DOM.');
        return;
    }

    chatbotMessageForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const messageContent = chatbotMessageContentInput.value.trim();

        if (!validateMessage(messageContent)) {
            alert('Por favor, escribe un mensaje.');
            return;
        }

        displayUserMessage(messageContent);
        chatbotMessageContentInput.value = '';
        scrollToBottom(chatbotMessageContainer);

        chatbotTypingIndicator.textContent = 'Chatbot is typing...';

        try {
            const response = await sendMessageToServer(messageContent);
            displayBotMessage(response.data.bot_message);

            // Imprimir los tokens en la consola
            console.log(`Input Tokens: ${response.data.input_tokens}`);
            console.log(`Output Tokens: ${response.data.output_tokens}`);
            console.log('Total tokens:', response.data.input_tokens + response.data.output_tokens);
        } catch (error) {
            console.error('Error:', error);
            displayErrorMessage();
        } finally {
            chatbotTypingIndicator.textContent = '';
            scrollToBottom(chatbotMessageContainer);
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
        chatbotMessageContainer.insertAdjacentHTML('beforeend', userMessageHtml);
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
        chatbotMessageContainer.insertAdjacentHTML('beforeend', botMessageHtml);
    }

    function displayErrorMessage() {
        const errorMessageHtml = `
            <div class="mb-4 text-left">
                <div class="inline-block bg-red-500 text-gray p-2 rounded-lg max-w-full break-words">
                    <div>Error: No se pudo procesar tu mensaje. Inténtalo más tarde.</div>
                </div>
            </div>
        `;
        chatbotMessageContainer.insertAdjacentHTML('beforeend', errorMessageHtml);
    }

    function scrollToBottom(container) {
        container.scrollTop = container.scrollHeight;
    }

    async function sendMessageToServer(message) {
        return axios.post('/chatbot/post',
            { message },
            {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        );
    }
});
