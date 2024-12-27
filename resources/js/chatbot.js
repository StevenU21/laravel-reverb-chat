document.addEventListener('DOMContentLoaded', function () {
    // Capturar el evento de envío del formulario
    document.getElementById('message-form').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevenir el envío predeterminado del formulario

        const messageContent = document.getElementById('message-content').value.trim();
        const messageContainer = document.getElementById('message-container');

        // Validar que el mensaje no esté vacío
        if (messageContent === '') {
            alert('Por favor, escribe un mensaje.');
            return;
        }

        // Mostrar el mensaje del usuario en el contenedor
        const userMessageHtml = `
            <div class="mb-4 text-right">
                <div class="inline-block bg-blue-500 text-white p-2 rounded-lg max-w-full break-words">
                    <div>${messageContent}</div>
                    <div class="text-xs text-gray-200 mt-1 flex items-center justify-end">
                        <span>${new Date().toLocaleTimeString()}</span>
                    </div>
                </div>
            </div>
        `;
        messageContainer.insertAdjacentHTML('beforeend', userMessageHtml);

        // Limpiar el input
        document.getElementById('message-content').value = '';

        // Scroll al final
        messageContainer.scrollTop = messageContainer.scrollHeight;

        // Mostrar el indicador de "escribiendo"
        document.getElementById('typing-indicator').textContent = 'Chatbot is typing...';

        // Enviar la solicitud Fetch al servidor
        fetch('/chatbot/post', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message: messageContent })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('typing-indicator').textContent = '';

            // Mostrar la respuesta del chatbot
            const botMessageHtml = `
                <div class="mb-4 text-left">
                    <div class="inline-block bg-gray-300 text-gray-900 p-2 rounded-lg max-w-full break-words">
                        <div class="font-bold">Chatbot</div>
                        <div>${data.bot_message}</div>
                        <div class="text-xs text-gray-600 mt-1">${new Date().toLocaleTimeString()}</div>
                    </div>
                </div>
            `;
            messageContainer.insertAdjacentHTML('beforeend', botMessageHtml);

            // Scroll al final
            messageContainer.scrollTop = messageContainer.scrollHeight;
        })
        .catch(error => {
            document.getElementById('typing-indicator').textContent = '';

            const errorMessageHtml = `
                <div class="mb-4 text-left">
                    <div class="inline-block bg-red-500 text-gray p-2 rounded-lg max-w-full break-words">
                        <div>Error: No se pudo procesar tu mensaje. Inténtalo más tarde.</div>
                    </div>
                </div>
            `;
            messageContainer.insertAdjacentHTML('beforeend', errorMessageHtml);

            // Scroll al final
            messageContainer.scrollTop = messageContainer.scrollHeight;
        });
    });
});
