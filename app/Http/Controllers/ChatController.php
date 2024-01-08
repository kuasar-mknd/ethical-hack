<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('viewAny', Message::class);

        $messages = Message::orderBy('created_at', 'desc')->get();
        return view('chat', compact('messages'));
    }

    public function store(Request $request)
    {
        $this->authorize('write', Message::class);

        $this->validate($request, [
            'message' => 'required',
        ]);

        Message::create([
            'content' => $request->input('message'),
            'user_id' => Auth::id(),
        ]);

        Log::info('Message posté', ['user_id' => Auth::id(), 'message' => $request->input('message')]);

        return redirect(route('chat.index'));
    }




    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $this->authorize('delete', $message);

        $message->delete();

        Log::info('Message supprimé', ['user_id' => Auth::id(), 'message_id' => $id]);

        return redirect()->route('chat.index');
    }
}
