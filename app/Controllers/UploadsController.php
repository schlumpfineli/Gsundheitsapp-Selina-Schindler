<?php

namespace App\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadsController
{
  function index(Request $request)
  {
    $category = $request->input('category');

    $query = Auth::user()->uploads();

    if ($category) {
      $query->where('category', $category);
    }
    return $query->get();
  }

  function show(Request $request, $id)
  {
    $upload = Upload::findOrFail($id);

    if (!$upload->is_public) {
      $user = Auth::user();
      if (!$user) {
        return abort(401, 'Authentication required');
      }
      if ($upload->user_id !== $user->id) {
        return abort(403, 'Not owned by user');
      }
    }

    return Storage::response($upload->file_path);
  }

  function create(Request $request)
  {
    $payload = $request->validate(Upload::$rules);
    $file = $payload['file'];

    $upload = Auth::user()->uploads()->make([
      'file_path' => Storage::putFile('uploads', $payload['file']),
      'original_name' => $file->getClientOriginalName(),
      'display_name' => $payload['display_name'],
      'category' => $payload['category'],
      'comment' => $payload['comment'] ?? null,
      'mime_type' => $file->getMimeType(),
      'size' => $file->getSize(),
      'is_public' => $payload['is_public'] ?? false
    ]);
    $upload->save();
    return $upload;
  }

  function update(Request $request)
  {
    $id = $request->input('id');
    $upload = Auth::user()->uploads()->findOrFail($id);

    // Datei kann nicht per PUT aktualisiert werden (PHP-Limitierung)
    $payload = $request->validate([
      'display_name' => Upload::$rules['display_name'],
      'category' => Upload::$rules['category'],
      'comment' => Upload::$rules['comment'],
      'is_public' => Upload::$rules['is_public']
    ]);

    $upload->update($payload);
    return $upload;
  }

  function destroy(Request $request)
  {
    $id = $request->input('id');
    $upload = Auth::user()->uploads()->findOrFail($id);
    Storage::delete($upload->file_path);
    $upload->delete();
    return $upload;
  }
}
