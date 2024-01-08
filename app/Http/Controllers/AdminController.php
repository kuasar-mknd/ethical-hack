<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        if (auth()->user()->role === 'admin') {
            //mettre à jour le rôle de l'utilisateur
        $user->update(['role' => $validatedData['role']]);
                return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
        Log::info('Le rôle de l\'utilisateur ' . $user->id . ' a été mis à jour par l\'utilisateur ' . auth()->user()->id);
        } else {
            //si l'utilisateur n'est pas un admin, on retourne une erreur
            return redirect()->back()->with('error', 'Vous n\'avez pas les droits pour effectuer cette action.');
            //log erreur
            Log::error('L\'utilisateur ' . auth()->user()->id . ' a tenté de mettre à jour le rôle de l\'utilisateur ' . $user->id . ' sans avoir les droits.');
        }

    }

    //fonction pour recherche un utilisateur par son mail ou son nom
    public function search(Request $request)
     {
        $search = $request->input('search');

        // Récupérer les utilisateurs en fonction de la recherche
        $users = User::when($search, function ($query) use ($search) {
            $query->where(DB::raw('name'), 'like', '%' . $search . '%')
                  ->orWhere(DB::raw('email'), 'like', '%' . $search . '%');
        })->get();

        return view('admin_dashboard', ['users' => $users]);
    }

}
