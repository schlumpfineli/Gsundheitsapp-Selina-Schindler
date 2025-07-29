<?php

namespace App\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilesController
{
  function index(Request $request)
  {
    $id = $request->input('id');
    $userId = $request->input('user_id');
    $category = $request->input('category');
    $orderBy = $request->input('order_by', 'created_at');
    $orderDir = $request->input('order_dir', 'desc');
    $limit = $request->input('limit', 1000);
    $offset = $request->input('offset', 0);

    $query = File::query();
    if ($id) return $query->where('id', $id)->firstOrFail();
    if ($userId) $query->where('user_id', $userId);
    if ($category) $query->where('category', $category);

    $query->orderBy($orderBy, $orderDir);
    $query->limit($limit);
    $query->offset($offset);

    return $query->get();
  }

  function create(Request $request)
  {
    $payload = $request->validate([
      'file' => 'required|file|mimes:pdf,jpg,png,docx|max:10240',
      'category' => File::$rules['category'],
      'comment' => File::$rules['comment'],
    ]);

    $uploadedFile = $request->file('file');
    $path = $uploadedFile->store('files/' . Auth::id(), 'public');

    $file = Auth::user()->files()->create([
      'file_path' => $path,
      'original_name' => $uploadedFile->getClientOriginalName(), // Originaldateiname speichern
      'category' => $payload['category'],
      'comment' => $payload['comment'] ?? null,
      'mime_type' => $uploadedFile->getMimeType(),
      'size' => $uploadedFile->getSize(),
    ]);

    return $file;
  }

  function update(Request $request)
  {
    $id = $request->input('id');
    $file = Auth::user()->files()->findOrFail($id);

    $payload = $request->validate([
      'category' => File::$rules['category'],
      'comment' => File::$rules['comment'],
    ]);

    $file->update($payload);
    return $file;
  }

  function destroy(Request $request)
  {
    $id = $request->input('id');
    $file = Auth::user()->files()->findOrFail($id);

    Storage::disk('public')->delete($file->file_path);
    $file->delete();

    return $file;
  }
}
