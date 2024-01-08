<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    //fonction pour aller chercher les utilisateurs
    public function index()
    {
        $users = User::all();
        return view('admin_dashboard', compact('users'));
    }
    //fonction pour mettre à jour un utilisateur
    public function updateRole(Request $request, User $user)
    {
        //validation des données
        $validatedData = $request->validate([
            'role' => 'required|in:Administrateur,Editeur,Lecteur,Invité,Désactivé',
        ]);

        //vérification si l'utilisateur est un admin
        if (auth()->user()->role === 'Administrateur') {
            //mettre à jour le rôle de l'utilisateur
            $user->update(['role' => $validatedData['role']]);
            Log::info('Le rôle de l\'utilisateur ' . $user->id . ' a été mis à jour par l\'utilisateur ' . auth()->user()->id);
            return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
        } else {
            //si l'utilisateur n'est pas un admin, on retourne une erreur
            Log::error('L\'utilisateur ' . auth()->user()->id . ' a tenté de mettre à jour le rôle de l\'utilisateur ' . $user->id . ' sans avoir les droits.');
            return redirect()->back()->with('error', 'Vous n\'avez pas les droits pour effectuer cette action.');
        }
    }

    //fonction pour recherche un utilisateur par son mail ou son nom
    public function search(Request $request)
    {
        $search = $request->input('search');

        // Récupérer les utilisateurs en fonction de la recherche
        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->get();

        Log::info('L\'utilisateur ' . auth()->user()->id . ' a effectué une recherche avec le terme ' . $search);

        return view('admin_dashboard', ['users' => $users]);
    }
}
