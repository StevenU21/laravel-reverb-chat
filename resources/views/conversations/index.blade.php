<x-app-layout>
    <div class="py-12 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full flex flex-col md:flex-row">

                @if ($conversations->isNotEmpty())
                    <!-- Sidebar de Conversaciones -->
                    <div class="w-full md:w-1/3 bg-gray-100 p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Conversations</h2>
                        <div class="space-y-4 overflow-y-auto max-h-96">
                            <ul>
                                @foreach ($conversations as $conversation)
                                    <a href="{{ route('conversations.show', $conversation) }}">
                                        <li class="flex items-center justify-between p-3 bg-white hover:bg-gray-200 rounded-lg transition cursor-pointer">
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
                                                        @if ($conversation->messages->first())
                                                            @if ($conversation->messages->first()->user_id == auth()->id())
                                                                Tú: {{ $conversation->messages->first()->content }}
                                                            @else
                                                                {{ $conversation->messages->first()->user->name }}: {{ $conversation->messages->first()->content }}
                                                            @endif
                                                        @else
                                                            No hay mensajes aún
                                                        @endif
                                                        &bull; {{ $conversation->updated_at->format('h:i A') }}
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
                @endif

                <!-- Caja de Bienvenida (ocupa todo el ancho si no hay conversaciones) -->
                <div
                    class="{{ $conversations->isEmpty() ? 'w-full' : 'w-full md:w-2/3' }} bg-white p-6 border-l border-gray-200 flex-col hidden md:flex">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">Bienvenido</h1>
                    <!-- Contenedor de bienvenida -->
                    <div class="flex-grow bg-gray-50 p-4 rounded-lg overflow-y-auto flex items-center justify-center">
                        <p class="text-lg text-gray-600 text-center">
                            @if ($conversations->isEmpty())
                                No tienes conversaciones aún. Navega y crea Conversaciones con otros Usuarios.
                            @else
                                Selecciona una conversación de la lista para empezar a chatear.
                                <br>
                                Haz clic en cualquier usuario a la izquierda.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
