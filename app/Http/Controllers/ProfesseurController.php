<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfesseurController extends Controller
{
    public function store(Request $request)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $validated = $this->validatedPayload($request);
        $validated['reference'] = Professeur::generateReference();

        Professeur::query()->create($validated);

        return redirect()
            ->route('admin.dashboard', ['section' => 'fiche-prof'])
            ->with('success', 'Professeur enregistré avec succès.');
    }

    public function update(Request $request, Professeur $professeur)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $validated = $this->validatedPayload($request);
        $professeur->fill($validated);
        $professeur->save();

        return redirect()
            ->route('admin.dashboard', ['section' => 'fiche-prof'])
            ->with('success', 'Professeur modifié avec succès.');
    }

    public function destroy(Professeur $professeur)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $professeur->delete();

        return redirect()
            ->route('admin.dashboard', ['section' => 'fiche-prof'])
            ->with('success', 'Professeur supprimé avec succès.');
    }

    public function pdf(Professeur $professeur)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        return view('admin.professeur-pdf', [
            'professeur' => $professeur,
        ]);
    }

    private function validatedPayload(Request $request): array
    {
        $validated = $request->validate([
            'date_prof' => ['required', 'date'],
            'nom_complet' => ['required', 'string', 'max:255'],
            'matiere' => ['required', 'string', 'max:255'],
            'statut' => ['required', 'string', Rule::in(array_keys(Professeur::statutLabels()))],
            'etablissement' => ['nullable', 'string', 'max:255'],
            'niveau' => ['required', 'string', Rule::in(array_keys(Professeur::niveauLabels()))],
            'type' => ['required', 'string', Rule::in(array_keys(Professeur::typeLabels()))],
            'paiement' => ['required', 'string', Rule::in(array_keys(Professeur::paiementLabels()))],
        ], [
            'nom_complet.required' => 'Le nom complet est obligatoire.',
            'matiere.required' => 'La matière est obligatoire.',
            'statut.required' => 'Le statut est obligatoire.',
            'niveau.required' => 'Le niveau est obligatoire.',
            'type.required' => 'Le type est obligatoire.',
            'paiement.required' => 'Le mode de paiement est obligatoire.',
            'date_prof.required' => 'La date est obligatoire.',
        ]);

        foreach (['nom_complet', 'matiere', 'etablissement'] as $field) {
            if (array_key_exists($field, $validated) && $validated[$field] !== null) {
                $validated[$field] = Str::upper(trim((string) $validated[$field]));
            }
        }

        return $validated;
    }
}
