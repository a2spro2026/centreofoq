<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EtudiantController extends Controller
{
    public function store(Request $request)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $validated = $this->validatedPayload($request);
        $validated['reference'] = Etudiant::generateReference();
        $validated['date_inscription'] = $validated['date_etudiant'];
        $validated['photo'] = $this->storePhoto($request);

        Etudiant::query()->create($validated);

        return redirect()->route('admin.dashboard', ['section' => 'etudiants']);
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $validated = $this->validatedPayload($request);
        $validated['date_inscription'] = $validated['date_etudiant'];

        if ($request->hasFile('photo')) {
            $path = $this->storePhoto($request);
            if ($path) {
                if ($etudiant->photo) {
                    Storage::disk('public')->delete($etudiant->photo);
                }
                $validated['photo'] = $path;
            }
        }

        $etudiant->fill($validated);
        $etudiant->save();

        return redirect()->route('admin.dashboard', ['section' => 'etudiants']);
    }

    public function destroy(Etudiant $etudiant)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        if ($etudiant->photo) {
            Storage::disk('public')->delete($etudiant->photo);
        }

        $etudiant->delete();

        return redirect()->route('admin.dashboard', ['section' => 'etudiants']);
    }

    private function storePhoto(Request $request): ?string
    {
        if (! $request->hasFile('photo')) {
            return null;
        }

        $file = $request->file('photo');

        if (! $file || ! $file->isValid()) {
            throw ValidationException::withMessages([
                'photo' => 'Le téléchargement de la photo a échoué. Réessayez avec une image JPG ou PNG (max 2 Mo).',
            ]);
        }

        Storage::disk('public')->makeDirectory('etudiants');

        return $file->store('etudiants', 'public');
    }

    private function validatedPayload(Request $request): array
    {
        $validated = $request->validate([
            'date_etudiant' => ['required', 'date'],
            'nom_complet' => ['required', 'string', 'max:255'],
            'niveau_scolaire' => ['required', 'string', 'max:120'],
            'matiere' => ['required', 'string', 'max:255'],
            'type_paie' => ['required', 'string', Rule::in(array_keys(Etudiant::typePaieLabels()))],
            'mode_paie' => ['required', 'string', Rule::in(array_keys(Etudiant::modePaieLabels()))],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'revenu' => ['nullable', 'numeric', 'min:0'],
            'solde' => ['nullable', 'numeric'],
        ], [
            'nom_complet.required' => 'Le nom complet est obligatoire.',
            'niveau_scolaire.required' => 'Le niveau scolaire est obligatoire.',
            'matiere.required' => 'La matière est obligatoire.',
            'type_paie.required' => 'Le type de paiement est obligatoire.',
            'mode_paie.required' => 'Le mode de paiement est obligatoire.',
            'date_etudiant.required' => 'La date est obligatoire.',
            'photo.uploaded' => 'Échec du téléchargement de la photo. Utilisez une image JPG/PNG de moins de 5 Mo.',
            'photo.file' => 'Le fichier photo est invalide.',
            'photo.mimes' => 'La photo doit être une image JPG, PNG, WEBP ou GIF.',
            'photo.max' => 'La photo ne doit pas dépasser 5 Mo.',
        ]);

        foreach (['nom_complet', 'niveau_scolaire', 'matiere'] as $field) {
            if (array_key_exists($field, $validated) && $validated[$field] !== null) {
                $validated[$field] = Str::upper(trim((string) $validated[$field]));
            }
        }

        unset($validated['photo']);
        $validated['revenu'] = $validated['revenu'] ?? 0;
        $validated['solde'] = $validated['solde'] ?? 0;

        return $validated;
    }
}
