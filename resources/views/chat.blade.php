<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>
    <div class="text-lg font-medium text-gray-900 dark:text-white truncate ml-6">
        @if (Auth::check())
            @php
                $userRole = Auth::user()->role;
            @endphp

            @if ($userRole == 'Lecteur' || $userRole == 'Editeur' || $userRole == 'Administrateur')
                <div id="chat-messages" class="max-h-[75vh] overflow-y-auto border border-gray-300 p-4 rounded">
                    <!-- Afficher les messages du chat ici -->
                    @foreach ($messages->sortBy('created_at') as $message)
                        <div class="mb-2">
                            <strong>{{ $message->user->name }}</strong> ({{ $message->created_at }}):
                            <p class=" p-2 rounded">{{ $message->content }}</p>
                            @if ($userRole == 'Administrateur')
                                <form action="{{ route('chat.delete', ['id' => $message->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 px-3 py-1 border border-red-500 hover:bg-red-100 rounded">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if ($userRole == 'Editeur' || $userRole == 'Administrateur')
                    <form action="{{ route('chat.create') }}" method="post" class="mt-4">
                        @csrf
                        <div class="flex flex-col">
                            <label for="message" class="mb-2 text-gray-600 dark:text-gray-300">Nouveau message:</label>
                            <textarea name="message" id="message" rows="3"
                                class="mr-6 resize-none border border-gray-300 p-2 rounded-md focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                required></textarea>
                        </div>
                        <button type="submit"
                            class="mt-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue active:bg-blue-700">Envoyer</button>
                    </form>
                @endif
            @else
                <p>Vous n'avez pas les autorisations nécessaires pour accéder à ce chat.</p>
            @endif
        @else
            <p>Veuillez vous connecter pour accéder au chat.</p>
        @endif
    </div>
</x-app-layout>
