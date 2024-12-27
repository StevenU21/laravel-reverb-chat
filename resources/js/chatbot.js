$(document).ready(function () {
    // Capturar el evento de envío del formulario
    $('#message-form').on('submit', function (e) {
        e.preventDefault(); // Prevenir el envío predeterminado del formulario

        const messageContent = $('#message-content').val().trim();
        const messageContainer = $('#message-container');

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
        messageContainer.append(userMessageHtml);

        // Limpiar el input
        $('#message-content').val('');

        // Scroll al final
        messageContainer.scrollTop(messageContainer[0].scrollHeight);

        // Mostrar el indicador de "escribiendo"
        $('#typing-indicator').text('Chatbot is typing...');

        // Enviar la solicitud AJAX al servidor
        $.ajax({
            url: '/chatbot/post',
            method: 'POST',
            data: { message: messageContent },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                // Ocultar el indicador de "escribiendo"
                $('#typing-indicator').text('');

                // Mostrar la respuesta del chatbot
                const botMessageHtml = `
                    <div class="mb-4 text-left">
                        <div class="inline-block bg-gray-300 text-gray-900 p-2 rounded-lg max-w-full break-words">
                            <div class="font-bold">Chatbot</div>
                            <div>${response.message}</div>
                            <div class="text-xs text-gray-600 mt-1">${new Date().toLocaleTimeString()}</div>
                        </div>
                    </div>
                `;
                messageContainer.append(botMessageHtml);

                // Scroll al final
                messageContainer.scrollTop(messageContainer[0].scrollHeight);
            },
            error: function (xhr) {
                // Ocultar el indicador de "escribiendo"
                $('#typing-indicator').text('');

                // Manejar errores
                const errorMessageHtml = `
                    <div class="mb-4 text-left">
                        <div class="inline-block bg-red-500 text-white p-2 rounded-lg max-w-full break-words">
                            <div>Error: No se pudo procesar tu mensaje. Inténtalo más tarde.</div>
                        </div>
                    </div>
                `;
                messageContainer.append(errorMessageHtml);

                // Scroll al final
                messageContainer.scrollTop(messageContainer[0].scrollHeight);
            }
        });
    });
});
