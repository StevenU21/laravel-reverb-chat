<x-app-layout>
    <style>
        #message-container {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        /* Estilo para el contenedor del indicador de escritura */
        #typing-indicator {
            height: 20px;
            /* Ajusta la altura según sea necesario */
        }
    </style>

    <div class="h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full flex flex-col">
                <!-- Chat de la Conversación -->
                <div class="w-full bg-white p-6 border-l border-gray-200 flex flex-col">
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 leading-tight">Chatbot</h1>
                            <!-- Indicador de escritura -->
                            <div id="typing-indicator" class="text-gray-600 mt-2"></div>
                        </div>
                    </div>

                    <!-- Contenedor de mensajes -->
                    <div id="message-container"
                        class="bg-gray-100 p-4 rounded-lg shadow-md h-96 overflow-y-scroll flex-grow">
                    </div>

                    <!-- Caja de texto -->
                    <form id="message-form" class="mt-4">
                        <div class="flex">
                            <input type="text" name="content" id="message-content"
                                class="w-full p-2 border border-gray-300 rounded-l-lg"
                                placeholder="Type your message here...">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-lg">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir el token CSRF para las solicitudes AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Incluir el script de jQuery y el script del chatbot -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
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
                    url: '/chatbot/post', // Ruta a la que se enviará la solicitud
                    method: 'POST',
                    data: {
                        message: messageContent
                    }, // Enviamos el mensaje del usuario
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
                    },
                    success: function (response) {
                        // Ocultar el indicador de "escribiendo"
                        $('#typing-indicator').text('');

                        // Mostrar la respuesta del chatbot
                        const botMessageHtml = `
                            <div class="mb-4 text-left">
                                <div class="inline-block bg-gray-300 text-gray-900 p-2 rounded-lg max-w-full break-words">
                                    <div class="font-bold">Chatbot</div>
                                    <div>${response.bot_message}</div>
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
                                <div class="inline-block bg-red-500 text-gray p-2 rounded-lg max-w-full break-words">
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
    </script>
</x-app-layout>
