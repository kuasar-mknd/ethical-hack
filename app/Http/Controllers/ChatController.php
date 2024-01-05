<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ChatController extends Controller
{
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

        Message::create([
            'content' => $request->input('message'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('chat.index');
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
