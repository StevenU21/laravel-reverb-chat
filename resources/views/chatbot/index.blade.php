<x-app-layout>
    <style>
        #chatbot-message-container {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        /* Estilo para el contenedor del indicador de escritura */
        #chatbot-typing-indicator {
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
                            <div id="chatbot-typing-indicator" class="text-gray-600 mt-2"></div>
                        </div>
                    </div>

                    <!-- Contenedor de mensajes -->
                    <div id="chatbot-message-container"
                        class="bg-gray-100 p-4 rounded-lg shadow-md h-96 overflow-y-scroll flex-grow">
                    </div>

                    <!-- Caja de texto -->
                    <form id="chatbot-message-form" class="mt-4">
                        <div class="flex">
                            <input type="text" name="content" id="chatbot-message-content"
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

    <!-- Incluir el token CSRF para las solicitudes Fetch -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</x-app-layout>
