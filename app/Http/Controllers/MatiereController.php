<?php

namespace App\Http\Controllers;

use App\Models\MatiereCarte;
use App\Models\MatiereCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatiereController extends Controller
{
    public function store(Request $request)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'cartes' => ['required', 'array', 'min:1'],
            'cartes.*' => ['nullable', 'string', 'max:255'],
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'cartes.required' => 'Ajoutez au moins une carte.',
            'cartes.min' => 'Ajoutez au moins une carte.',
        ]);

        $titre = Str::upper(trim($validated['titre']));
        $noms = collect($validated['cartes'])
            ->map(fn ($nom) => Str::upper(trim((string) $nom)))
            ->filter(fn ($nom) => $nom !== '')
            ->unique()
            ->values();

        if ($noms->isEmpty()) {
            return redirect()
                ->route('admin.dashboard', ['section' => 'matieres'])
                ->withErrors(['cartes' => 'Ajoutez au moins une carte.']);
        }

        $categorie = MatiereCategorie::query()
            ->whereRaw('UPPER(titre) = ?', [$titre])
            ->first();

        if (! $categorie) {
            $maxOrdre = (int) MatiereCategorie::query()->max('ordre');
            $categorie = MatiereCategorie::query()->create([
                'titre' => $titre,
                'ordre' => $maxOrdre + 1,
            ]);
        }

        $nextOrdre = (int) $categorie->cartes()->max('ordre');

        foreach ($noms as $nom) {
            $exists = $categorie->cartes()
                ->whereRaw('UPPER(nom) = ?', [$nom])
                ->exists();

            if ($exists) {
                continue;
            }

            $nextOrdre++;
            MatiereCarte::query()->create([
                'matiere_categorie_id' => $categorie->id,
                'nom' => $nom,
                'ordre' => $nextOrdre,
            ]);
        }

        return redirect()
            ->route('admin.dashboard', ['section' => 'matieres']);
    }
}
