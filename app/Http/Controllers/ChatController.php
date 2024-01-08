<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return view('chat', compact('messages'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);

        if (auth()->check()) {
            $user = auth()->user();

            $message = new Message([
                'content' => $request->input('message'),
            ]);

            // Assurez-vous que l'utilisateur est authentifié avant d'obtenir son ID
            $message->user_id = $user->id;
            $message->created_at = now();
            $message->updated_at = now();

            $message->save();

            return redirect(route('chat.index'));
        } else {
            // L'utilisateur n'est pas authentifié, gérer cette situation en conséquence.
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour envoyer un message.');
        }
    }




    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        if (auth()->user()->role == 'Administrateur') {
            $message->delete();
        }

        return redirect()->route('chat.index');
    }
}
