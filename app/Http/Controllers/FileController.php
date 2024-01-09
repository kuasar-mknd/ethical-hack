<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('viewAny', File::class);

        $files = File::all();
        return view('files', compact('files'));
    }

    public function upload(Request $request)
    {
        $this->authorize('create', File::class);

        $request->validate([
            'file' => 'required|file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = (string) Str::uuid() . '.' . $extension;

        $path = $file->storeAs('files', $filename, 'private');

        File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'user_id' => Auth::id(),
        ]);

        Log::info('Fichier uploadé', ['user_id' => Auth::id(), 'file_name' => $file->getClientOriginalName()]);

        return back()->with('success', 'Fichier uploadé avec succès.');
    }


    public function download(Request $request, $fileId)
    {
        $file = File::findOrFail($fileId);
        $this->authorize('download', File::class);

        if (! Storage::disk('private')->exists($file->path)) {
            abort(404);
        }

        Log::info('Fichier téléchargé', ['user_id' => Auth::id(), 'file_name' => $file->name]);

        return Storage::disk('private')->download($file->path, $file->name);
    }

    public function delete(Request $request, $fileId)
    {
        $file = File::findOrFail($fileId);
        $this->authorize('delete', $file);

        if (! Storage::disk('private')->exists($file->path)) {
            abort(404);
        }

        Storage::disk('private')->delete($file->path, $file->name);
        $file->delete();

        Log::info('Fichier supprimé', ['user_id' => Auth::id(), 'file_name' => $file->name]);

        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
