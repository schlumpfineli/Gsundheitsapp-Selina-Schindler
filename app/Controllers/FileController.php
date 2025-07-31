<?php

namespace App\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FilesController
{
  function index(Request $request)
  {
    $id = $request->input('id');
    $userId = $request->input('user_id');
    $title = $request->input('title');
    $orderBy = $request->input('order_by', 'created_at');
    $orderDir = $request->input('order_dir', 'asc');
    $limit = $request->input('limit', 1000);
    $offset = $request->input('offset', 0);


    $query = File::query();
    if ($id) return $query->where('id', $id)->firstOrFail();
    if ($userId) $query->where('user_id', $userId);
    if ($title) $query->where('title', 'like', "%$title%");

    $query->orderBy($orderBy, $orderDir);
    $query->limit($limit);
    $query->offset($offset);

    // return $query->toSql(); // for debugging
    return $query->get();
  }

  function search(Request $request)
  {
    $title = $request->input('title');
    return File::select('id', 'title')
      ->get()
      ->map(fn($a) => [
        'id' => $a->id,
        'title' => $a->title,
        'distance' => levenshtein($title, $a->title),
        'similarity' => similar_text($title, $a->title),
      ])
      ->sortBy('distance')
      ->values();
  }

  function create(Request $request)
  {
    $payload = $request->validate(File::$rules);
    // $article = Article::create($payload);
    $file = Auth::user()->files()->create($payload);
    return $file;
  }

  function update(Request $request)
  {
    $id = $request->input('id');
    // $article = Article::findOrFail($id);
    $file = Auth::user()->files()->findOrFail($id);
    $payload = $request->validate(File::$rules);
    $file->update($payload);
    return $file;
  }

  function destroy(Request $request)
  {
    $id = $request->input('id');
    // $article = Article::findOrFail($id);
    $file = Auth::user()->files()->findOrFail($id);
    $file->delete();
    return $file;
  }
}
