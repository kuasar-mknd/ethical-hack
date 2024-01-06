<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Fichiers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @can('create', App\Models\File::class)
                {{-- Carte pour l'Upload de Fichiers --}}
                <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-6">
                    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex space-x-4 items-center">
                            <x-input-label for="file" value="{{ __('Choisir un fichier') }}" />
                            <x-text-input id="file" class="block mt-1 w-full" type="file" name="file" />
                            <x-primary-button class="ml-4">
                                {{ __('Upload') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            @endcan

            {{-- Affichage des Fichiers sous forme de Grille --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($files as $file)
                    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-4 flex flex-col space-y-4">
                        <div class="text-lg font-medium text-gray-900 dark:text-white truncate text-center">
                            {{ $file->name }}
                        </div>
                        <div class="flex-1 flex flex-col justify-between text-center">
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    {{ $file->user->name }}
                                </p>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                {{ $file->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between">
                            @can('download', $file)
                                <a href="{{ route('files.download', $file) }}"
                                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Télécharger') }}
                                </a>
                            @endcan
                            @can('delete', $file)
                                <form action="{{ route('files.delete', $file) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>
                                        {{ __('Supprimer') }}
                                    </x-danger-button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
