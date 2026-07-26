<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CentreController extends Controller
{
    public function update(Request $request)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'photo' => ['nullable', 'image', 'max:2048'],
            'nom_centre' => ['required', 'string', 'max:255'],
            'nom_gerant' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
        ], [
            'nom_centre.required' => 'Le nom du centre est obligatoire.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
        ]);

        $centre = Centre::query()->first() ?? new Centre;

        if ($request->hasFile('photo')) {
            if ($centre->photo) {
                Storage::disk('public')->delete($centre->photo);
            }

            $validated['photo'] = $request->file('photo')->store('centres', 'public');
        } else {
            unset($validated['photo']);
        }

        $centre->fill($validated);
        $centre->save();

        return redirect()
            ->route('admin.dashboard', ['section' => 'fiche-centre'])
            ->with('success', 'Fiche centre enregistrée avec succès.');
    }
}
