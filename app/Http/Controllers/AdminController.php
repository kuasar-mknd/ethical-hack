<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');
    }

    //fonction pour aller chercher les utilisateurs
    public function index()
    {
        $users = User::all();
        return view('admin_dashboard', compact('users'));
    }
    //fonction pour mettre à jour un utilisateur
    public function updateRole(Request $request, User $user)
    {
        $this->authorize('updateRole', User::class);

        //validation des données
        $validatedData = $request->validate([
            'role' => 'required|in:Administrateur,Editeur,Lecteur,Invité,Désactivé',
        ]);

        // Mettre à jour le rôle de l'utilisateur
        $user->update(['role' => $validatedData['role']]);
        Log::info('Le rôle de l\'utilisateur ' . $user->id . ' a été mis à jour par l\'utilisateur ' . Auth::id());

        return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
    }

    //fonction pour recherche un utilisateur par son mail ou son nom
    public function search(Request $request)
    {
        $this->authorize('updateRole', User::class);

        $search = $request->input('search');

        // Récupérer les utilisateurs en fonction de la recherche
        $users = User::where('email', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->get();


        Log::info('Recherche effectuée par l\'utilisateur ' . Auth::id() . ' avec le terme ' . $search);

        return view('admin_dashboard', ['users' => $users]);
    }
}
