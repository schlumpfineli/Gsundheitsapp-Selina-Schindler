<?php

namespace App\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentsController
{
  use AuthorizesRequests;
  function index(Request $request)
  {
    return $request->user()->documents()->latest()->get();
  }

  function create(Request $request)
  {
    $payload = $request->validate(Document::$rules);
    $file = $request->file('file');
    $payload['file_path'] = $file->store('documents/' . $request->user()->id, 'public');
    $document = $request->user()->documents()->create($payload);
    return $document;
  }

  function update(Request $request)
  {
    $id = $request->input('id');
    $document = Document::findOrFail($id);
    $this->authorize('update', $document);
    $payload = $request->validate(Document::$updateRules);
    $document->update($payload);
    return $document;
  }

  function destroy(Request $request)
  {
    $id = $request->input('id');
    $document = Document::findOrFail($id);
    $this->authorize('delete', $document);
    Storage::delete('public/' . $document->file_path);
    $document->delete();
    return $document;
  }
}
