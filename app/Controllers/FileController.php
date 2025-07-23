<?php

namespace App\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController
{
  // Dateiliste anzeigen
  function index(Request $request)
  {
    return Auth::user()->files()->get();
  }

  // Datei hochladen
  function create(Request $request)
  {
    $request->validate([
      'file' => 'required|file|max:10240', // max 10MB
      'name' => File::$rules['name'],
      'comment' => File::$rules['comment'],
    ]);

    $uploadedFile = $request->file('file');
    $path = $uploadedFile->store('user_files/' . Auth::id());

    $file = Auth::user()->files()->create([
      'name' => $request->input('name', $uploadedFile->getClientOriginalName()),
      'path' => $path,
      'mime_type' => $uploadedFile->getMimeType(),
      'size' => $uploadedFile->getSize(),
      'comment' => $request->input('comment', ''),
    ]);

    return $file;
  }
}
