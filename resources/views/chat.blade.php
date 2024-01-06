<!DOCTYPE html>
<html>

<head>
    <title>Chat</title>
</head>

<body>
    <h1>Chat</h1>

    @if (Auth::check())
        @php
            $userRole = Auth::user()->role;
        @endphp

        @if ($userRole == 'Lecteur' || $userRole == 'Editeur' || $userRole == 'Administrateur')
            <div id="chat-messages">
                <!-- Afficher les messages du chat ici -->
                @foreach ($messages->sortBy('created_at') as $message)
                    <p>
                        <strong>{{ $message->user->name }}</strong> ({{ $message->created_at }}):
                        {{ $message->content }}
                        @if ($userRole == 'Administrateur')
                            <form action="{{ route('chat.delete', ['id' => $message->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        @endif
                    </p>
                @endforeach
            </div>

            @if ($userRole == 'Editeur' || $userRole == 'Administrateur')
                <form action="{{ route('chat.create') }}" method="post">
                    @csrf
                    <label for="message">Nouveau message:</label>
                    <textarea name="message" id="message" rows="3" required></textarea>
                    <button type="submit">Envoyer</button>
                </form>
            @endif
        @else
            <p>Vous n'avez pas les autorisations nécessaires pour accéder à ce chat.</p>
        @endif
    @else
        <p>Veuillez vous connecter pour accéder au chat.</p>
    @endif
</body>

</html>
