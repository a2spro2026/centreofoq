<?php

use App\Http\Controllers\CentreController;
use App\Http\Controllers\DocumentAdministratifController;
use App\Http\Controllers\FraisFinancierController;
use App\Models\Centre;
use App\Models\DocumentAdministratif;
use App\Models\FraisFinancier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (session('auth.role') === 'administration') {
        return redirect()->route('admin.dashboard');
    }

    return view('welcome');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'role' => ['required', 'string'],
        'email' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $isAdmin =
        $credentials['role'] === 'administration'
        && strcasecmp(trim($credentials['email']), 'admin@horizon.com') === 0
        && $credentials['password'] === 'password';

    if (! $isAdmin) {
        return back()
            ->withInput($request->only('email', 'role'))
            ->withErrors(['email' => 'Identifiants incorrects. Vérifiez le statut, l’e-mail et le mot de passe.']);
    }

    $request->session()->regenerate();
    $request->session()->put('auth', [
        'role' => 'administration',
        'email' => 'admin@horizon.com',
        'name' => 'Directeur général',
        'title' => 'Administration',
    ]);

    return redirect()->route('admin.dashboard');
})->name('login.attempt');

Route::post('/logout', function (Request $request) {
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

Route::get('/admin', function (Request $request) {
    if (session('auth.role') !== 'administration') {
        return redirect()->route('login');
    }

    $documents = DocumentAdministratif::query()
        ->orderByDesc('date_document')
        ->orderByDesc('id')
        ->get();

    $documentsIndex = $documents->keyBy('id')->map(function (DocumentAdministratif $doc) {
        return [
            'id' => $doc->id,
            'type' => $doc->type,
            'type_label' => $doc->type_label,
            'titre' => $doc->titre,
            'reference' => $doc->reference,
            'beneficiaire' => $doc->beneficiaire,
            'id_beneficiaire' => $doc->id_beneficiaire,
            'famille' => $doc->famille,
            'categorie' => $doc->categorie,
            'statut' => $doc->statut,
            'statut_label' => $doc->statut_label,
            'date_document' => optional($doc->date_document)->format('Y-m-d'),
            'date_label' => optional($doc->date_document)->format('d/m/Y'),
            'remarque' => $doc->remarque,
            'pdf_url' => route('admin.documents.pdf', $doc),
            'update_url' => route('admin.documents.update', $doc),
            'delete_url' => route('admin.documents.destroy', $doc),
        ];
    });

    $fraisList = FraisFinancier::query()
        ->orderByDesc('date_frais')
        ->orderByDesc('id')
        ->get();

    $fraisIndex = $fraisList->keyBy('id')->map(function (FraisFinancier $frais) {
        return [
            'id' => $frais->id,
            'categorie' => $frais->categorie,
            'categorie_label' => $frais->categorie_label,
            'reference' => $frais->reference,
            'date_frais' => optional($frais->date_frais)->format('Y-m-d'),
            'date_label' => optional($frais->date_frais)->format('d/m/Y'),
            'designation' => $frais->designation,
            'beneficiaire' => $frais->beneficiaire,
            'type_frais' => $frais->type_frais,
            'montant' => (float) $frais->montant,
            'solde' => (float) $frais->solde,
            'remarque' => $frais->remarque,
            'pdf_url' => route('admin.frais.pdf', $frais),
            'update_url' => route('admin.frais.update', $frais),
            'delete_url' => route('admin.frais.destroy', $frais),
        ];
    });

    return view('admin.dashboard', [
        'user' => session('auth'),
        'centre' => Centre::query()->first(),
        'documents' => $documents,
        'documentsIndex' => $documentsIndex,
        'documentsByType' => $documents->groupBy('type'),
        'documentTypes' => DocumentAdministratif::typeLabels(),
        'documentStatuts' => DocumentAdministratif::statutLabels(),
        'nextDocumentRefs' => DocumentAdministratif::nextReferences(),
        'fraisList' => $fraisList,
        'fraisIndex' => $fraisIndex,
        'fraisCategories' => FraisFinancier::categorieLabels(),
        'nextFraisRefs' => FraisFinancier::nextReferences(),
        'activeSection' => $request->query('section', 'administration'),
        'activeDocType' => $request->query('doc'),
        'activeFraisType' => $request->query('frais'),
    ]);
})->name('admin.dashboard');

Route::post('/admin/centre', [CentreController::class, 'update'])->name('admin.centre.update');
Route::post('/admin/documents', [DocumentAdministratifController::class, 'store'])->name('admin.documents.store');
Route::put('/admin/documents/{document}', [DocumentAdministratifController::class, 'update'])->name('admin.documents.update');
Route::delete('/admin/documents/{document}', [DocumentAdministratifController::class, 'destroy'])->name('admin.documents.destroy');
Route::get('/admin/documents/{document}/pdf', [DocumentAdministratifController::class, 'pdf'])->name('admin.documents.pdf');

Route::post('/admin/frais', [FraisFinancierController::class, 'store'])->name('admin.frais.store');
Route::put('/admin/frais/{frais}', [FraisFinancierController::class, 'update'])->name('admin.frais.update');
Route::delete('/admin/frais/{frais}', [FraisFinancierController::class, 'destroy'])->name('admin.frais.destroy');
Route::get('/admin/frais/{frais}/pdf', [FraisFinancierController::class, 'pdf'])->name('admin.frais.pdf');
