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
                    <!-- Botón de "Regresar a Conversaciones" (visible solo en móviles) -->
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 leading-tight">Nombre del Receptor</h1>
                            <!-- Indicador de escritura -->
                            <div id="typing-indicator" class="text-gray-600 mt-2"></div>
                        </div>
                        <select
                            class="bg-white border border-gray-300 text-gray-700 py-2 px-8 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" disabled selected>Modelo del Bot</option>
                            <option value="modelo1">GPT 3.5</option>
                            <option value="modelo2">GPT 4o</option>
                            <option value="modelo3">GTP 4</option>
                        </select>
                    </div>
                    <!-- Contenedor de mensajes -->
                    <div id="message-container"
                        class="bg-gray-100 p-4 rounded-lg shadow-md h-96 overflow-y-scroll flex-grow">
                        <div class="mb-4">
                            <!-- Mensaje enviado por el usuario -->
                            <div class="text-right">
                                <div
                                    class="inline-block bg-blue-500 text-white p-2 rounded-lg max-w-full break-words fade-in">
                                    <div>Contenido del mensaje enviado</div>
                                    <div class="text-xs text-gray-200 mt-1 flex items-center justify-end space-x-1">
                                        <span>Fecha y hora</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <!-- Mensaje recibido -->
                            <div class="text-left">
                                <div
                                    class="inline-block bg-gray-300 text-gray-900 p-2 rounded-lg max-w-full break-words">
                                    <div class="font-bold">Nombre del remitente</div>
                                    <div>Contenido del mensaje recibido</div>
                                    <div class="text-xs text-gray-600 mt-1">Fecha y hora</div>
                                </div>
                            </div>
                        </div>
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
    {{-- @include('components.message_js') --}}
</x-app-layout>
