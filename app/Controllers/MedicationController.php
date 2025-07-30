<?php

namespace App\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicationController
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


    $query = Medication::query();
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
    return Medication::select('id', 'title')
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
    $payload = $request->validate(Medication::$rules);
    // $medication = Medication::create($payload);
    $medication = Auth::user()->medications()->create($payload);
    return $medication;
  }

  function update(Request $request)
  {
    $id = $request->input('id');
    // $medication = Medication::findOrFail($id);
    $medication = Auth::user()->medications()->findOrFail($id);
    $payload = $request->validate(Medication::$rules);
    $medication->update($payload);
    return $medication;
  }

  function destroy(Request $request)
  {
    $id = $request->input('id');
    // $article = Article::findOrFail($id);
    $medication = Auth::user()->medications()->findOrFail($id);
    $medication->delete();
    return $medication;
  }
}
