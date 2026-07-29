<?php

namespace App\Http\Controllers;

use App\Models\FraisFinancier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FraisFinancierController extends Controller
{
    public function store(Request $request)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $validated = $this->validatedPayload($request);
        $validated['reference'] = FraisFinancier::generateReference($validated['categorie']);

        FraisFinancier::query()->create($validated);

        return redirect()
            ->route('admin.dashboard', [
                'section' => 'parametres-financiers',
                'frais' => $validated['categorie'],
            ])
            ->with('success', 'Frais enregistré avec succès.');
    }

    public function update(Request $request, FraisFinancier $frais)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $request->merge(['categorie' => $frais->categorie]);
        $validated = $this->validatedPayload($request);

        $frais->fill($validated);
        $frais->save();

        return redirect()
            ->route('admin.dashboard', [
                'section' => 'parametres-financiers',
                'frais' => $frais->categorie,
            ])
            ->with('success', 'Frais modifié avec succès.');
    }

    public function destroy(FraisFinancier $frais)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $categorie = $frais->categorie;
        $frais->delete();

        return redirect()
            ->route('admin.dashboard', [
                'section' => 'parametres-financiers',
                'frais' => $categorie,
            ])
            ->with('success', 'Frais supprimé avec succès.');
    }

    public function pdf(FraisFinancier $frais)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        return view('admin.frais-pdf', [
            'frais' => $frais,
            'categorieLabel' => FraisFinancier::categorieLabels()[$frais->categorie] ?? $frais->categorie,
        ]);
    }

    private function validatedPayload(Request $request): array
    {
        $validated = $request->validate([
            'categorie' => ['required', 'string', Rule::in(array_keys(FraisFinancier::categorieLabels()))],
            'date_frais' => ['required', 'date'],
            'designation' => ['required', 'string', 'max:255'],
            'beneficiaire' => ['nullable', 'string', 'max:255'],
            'type_frais' => ['nullable', 'string', 'max:120'],
            'montant' => ['required', 'numeric', 'min:0'],
            'solde' => ['nullable', 'numeric'],
            'remarque' => ['nullable', 'string', 'max:5000'],
        ], [
            'designation.required' => 'La désignation est obligatoire.',
            'categorie.required' => 'La catégorie est obligatoire.',
            'date_frais.required' => 'La date est obligatoire.',
            'montant.required' => 'Le montant est obligatoire.',
        ]);

        foreach (['designation', 'beneficiaire', 'type_frais', 'remarque'] as $field) {
            if (array_key_exists($field, $validated) && $validated[$field] !== null) {
                $validated[$field] = Str::upper(trim((string) $validated[$field]));
            }
        }

        $validated['solde'] = $validated['solde'] ?? 0;

        return $validated;
    }
}
