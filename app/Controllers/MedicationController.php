Hier ist der angepasste Code für eine Medikamentenverwaltung nach dem gleichen Muster wie Ihr `CommentController`. Ich habe OOP und CRUD Prinzipien beibehalten:

### MedicationController.php
```php
<?php

namespace App\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicationController {
  // Liste aller Medikamente des eingeloggten Users
  function index(Request $request) {
    return Auth::user()->medications()->get();
  }

  // Neues Medikament erstellen
  function create(Request $request) {
    $payload = $request->validate(Medication::$rules);
    $medication = Auth::user()->medications()->create($payload);
    return $medication;
  }

  // Medikament aktualisieren
  function update(Request $request) {
    $id = $request->input('id');
    $payload = $request->validate(Medication::$rules);
    $medication = Auth::user()->medications()->findOrFail($id);
    $medication->update($payload);
    return $medication;
  }

  // Medikament löschen
  function destroy(Request $request) {
    $id = $request->input('id');
    $medication
  }
}