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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full flex flex-col md:flex-row">

                <!-- Sidebar de Conversaciones (escondido en móviles) -->
                <div class="w-full md:w-1/3 bg-gray-100 p-4 rounded-lg shadow-md hidden md:block">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Conversations</h2>
                    <div class="space-y-4 overflow-y-auto max-h-96">
                        <ul>
                            @foreach ($conversations as $conversation)
                                <a href="{{ route('conversations.show', $conversation) }}">
                                    <li
                                        class="flex items-center justify-between p-3 bg-white hover:bg-gray-200 rounded-lg transition cursor-pointer">
                                        <!-- Foto de perfil -->
                                        <div class="flex items-center">
                                            <img class="w-12 h-12 rounded-full mr-4"
                                                src="https://png.pngtree.com/png-clipart/20231019/original/pngtree-user-profile-avatar-png-image_13369988.png"
                                                alt="Profile">
                                            <div class="flex flex-col">
                                                <!-- Nombre del usuario -->
                                                <span class="text-lg font-bold text-gray-800">
                                                    {{ $conversation->users->firstWhere('id', '!=', auth()->id())->name }}
                                                </span>
                                                <!-- Último mensaje y hora -->
                                                <span class="text-sm text-gray-500">
                                                    Hola que tal? &bull;
                                                    {{ $conversation->updated_at->format('h:i A') }}
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Indicador de mensaje no leído -->
                                        <div class="bg-blue-500 h-3 w-3 rounded-full"></div>
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Chat de la Conversación -->
                <div class="w-full md:w-2/3 bg-white p-6 border-l border-gray-200 flex flex-col">
                    <!-- Botón de "Regresar a Conversaciones" (visible solo en móviles) -->
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 leading-tight">{{ $receiver->name }}</h1>
                            <!-- Indicador de escritura -->
                            <div id="typing-indicator" class="text-gray-600 mt-2"></div>
                        </div>
                        <a href="{{ route('conversations.index') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-lg">
                            ← Return Back
                        </a>
                    </div>
                    <!-- Contenedor de mensajes -->
                    <div id="message-container"
                        class="bg-gray-100 p-4 rounded-lg shadow-md h-96 overflow-y-scroll flex-grow">
                        @foreach ($messages as $message)
                            <div class="mb-4">
                                @if ($message->sender_id == auth()->id())
                                    <!-- Mensaje enviado por el usuario -->
                                    <div class="text-right">
                                        <div
                                            class="inline-block bg-blue-500 text-white p-2 rounded-lg max-w-full break-words fade-in">
                                            <div>{{ $message->content }}</div>
                                            <div
                                                class="text-xs text-gray-200 mt-1 flex items-center justify-end space-x-1">
                                                <span>{{ $message->created_at->format('d M Y, H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Mensaje recibido -->
                                    <div class="text-left">
                                        <div
                                            class="inline-block bg-gray-300 text-gray-900 p-2 rounded-lg max-w-full break-words">
                                            <div class="font-bold">{{ $message->sender_name }}</div>
                                            <div>{{ $message->content }}</div>
                                            <div class="text-xs text-gray-600 mt-1">
                                                {{ $message->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Caja de texto -->
                    <form id="message-form" class="mt-4">
                        @csrf
                        <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
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
    @include('components.message_js')
</x-app-layout>
