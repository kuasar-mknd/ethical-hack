<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    // Tout le monde peut voir la liste des fichiers
    public function viewAny(User $user)
    {
        return in_array($user->role, ['Lecteur', 'Editeur', 'Administrateur']);
    }

    // Lecteurs, éditeurs, administrateurs peuvent télécharger les fichiers
    public function write(User $user)
    {
        return in_array($user->role, ['Editeur', 'Administrateur']);
    }

    public function delete(User $user, Message $message)
    {
        return in_array($user->role, ['Administrateur']);
    }
}
