<?php

namespace App\Http\Controllers;

use App\Models\DocumentAdministratif;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DocumentAdministratifController extends Controller
{
    public function store(Request $request)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $validated = $this->validatedPayload($request);
        $validated['reference'] = DocumentAdministratif::generateReference($validated['type']);

        DocumentAdministratif::query()->create($validated);

        return redirect()
            ->route('admin.dashboard', [
                'section' => 'documents-administratifs',
                'doc' => $validated['type'],
            ])
            ->with('success', 'Document administratif enregistré avec succès.');
    }

    public function update(Request $request, DocumentAdministratif $document)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $request->merge(['type' => $document->type]);
        $validated = $this->validatedPayload($request);

        $document->fill($validated);
        $document->save();

        return redirect()
            ->route('admin.dashboard', [
                'section' => 'documents-administratifs',
                'doc' => $document->type,
            ])
            ->with('success', 'Document administratif modifié avec succès.');
    }

    public function destroy(DocumentAdministratif $document)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        $type = $document->type;
        $document->delete();

        return redirect()
            ->route('admin.dashboard', [
                'section' => 'documents-administratifs',
                'doc' => $type,
            ])
            ->with('success', 'Document administratif supprimé avec succès.');
    }

    public function pdf(DocumentAdministratif $document)
    {
        if (session('auth.role') !== 'administration') {
            return redirect()->route('login');
        }

        return view('admin.document-pdf', [
            'document' => $document,
            'typeLabel' => DocumentAdministratif::typeLabels()[$document->type] ?? $document->type,
            'statutLabel' => DocumentAdministratif::statutLabels()[$document->statut] ?? $document->statut,
        ]);
    }

    private function validatedPayload(Request $request): array
    {
        $validated = $request->validate([
            'type' => ['required', 'string', Rule::in(array_keys(DocumentAdministratif::typeLabels()))],
            'titre' => ['required', 'string', 'max:255'],
            'beneficiaire' => ['required', 'string', 'max:255'],
            'id_beneficiaire' => ['nullable', 'string', 'max:255'],
            'famille' => ['nullable', 'string', 'max:255'],
            'categorie' => ['nullable', 'string', 'max:255'],
            'statut' => ['required', 'string', Rule::in(array_keys(DocumentAdministratif::statutLabels()))],
            'date_document' => ['required', 'date'],
            'remarque' => ['nullable', 'string', 'max:5000'],
        ], [
            'titre.required' => 'Le titre du document est obligatoire.',
            'beneficiaire.required' => 'Le bénéficiaire est obligatoire.',
            'type.required' => 'Le type de document est obligatoire.',
            'statut.required' => 'Le statut est obligatoire.',
            'date_document.required' => 'La date est obligatoire.',
        ]);

        foreach (['titre', 'beneficiaire', 'id_beneficiaire', 'famille', 'categorie', 'remarque'] as $field) {
            if (array_key_exists($field, $validated) && $validated[$field] !== null) {
                $validated[$field] = Str::upper(trim((string) $validated[$field]));
            }
        }

        return $validated;
    }
}
