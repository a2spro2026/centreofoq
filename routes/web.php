<?php

use App\Http\Controllers\CentreController;
use App\Http\Controllers\DocumentAdministratifController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\FraisFinancierController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ProfesseurController;
use App\Models\Centre;
use App\Models\DocumentAdministratif;
use App\Models\Etudiant;
use App\Models\FraisFinancier;
use App\Models\MatiereCarte;
use App\Models\MatiereCategorie;
use App\Models\Professeur;
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

    $role = strtolower(trim($credentials['role']));
    $email = strtolower(trim($credentials['email']));
    $password = trim($credentials['password']);

    $isAdmin =
        $role === 'administration'
        && $email === 'admin@horizon.com'
        && strcasecmp($password, 'password') === 0;

    if (! $isAdmin) {
        return back()
            ->withInput($request->only('email', 'role'))
            ->withErrors(['email' => 'Identifiants incorrects. Vérifiez le statut, l’e-mail et le mot de passe.']);
    }

    $request->session()->regenerate();
    $request->session()->put('auth', [
        'role' => 'administration',
        'email' => 'admin@horizon.com',
        'name' => 'SAMIR JADI',
        'title' => 'DIRECTEUR GENERAL',
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

    $request->session()->put('auth.name', 'SAMIR JADI');
    $request->session()->put('auth.title', 'DIRECTEUR GENERAL');

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

    $profsList = Professeur::query()
        ->orderByDesc('date_prof')
        ->orderByDesc('id')
        ->get();

    $profsIndex = $profsList->keyBy('id')->map(function (Professeur $prof) {
        return [
            'id' => $prof->id,
            'reference' => $prof->reference,
            'date_prof' => optional($prof->date_prof)->format('Y-m-d'),
            'date_label' => optional($prof->date_prof)->format('d/m/Y'),
            'nom_complet' => $prof->nom_complet,
            'matiere' => $prof->matiere,
            'statut' => $prof->statut,
            'statut_label' => $prof->statut_label,
            'etablissement' => $prof->etablissement,
            'niveau' => $prof->niveau,
            'niveau_label' => $prof->niveau_label,
            'type' => $prof->type,
            'type_label' => $prof->type_label,
            'paiement' => $prof->paiement,
            'paiement_label' => $prof->paiement_label,
            'pdf_url' => route('admin.profs.pdf', $prof),
            'update_url' => route('admin.profs.update', $prof),
            'delete_url' => route('admin.profs.destroy', $prof),
        ];
    });

    $matiereCategories = MatiereCategorie::query()
        ->with('cartes')
        ->orderBy('ordre')
        ->orderBy('id')
        ->get();

    $profCountsByMatiere = Professeur::query()
        ->get(['matiere'])
        ->groupBy(fn ($prof) => mb_strtoupper(trim((string) $prof->matiere)))
        ->map->count();

    $matieresIndex = [];
    foreach ($matiereCategories as $categorie) {
        foreach ($categorie->cartes as $carte) {
            $key = mb_strtoupper((string) $carte->nom);
            $liveProfs = (int) ($profCountsByMatiere[$key] ?? 0);
            $matieresIndex[$carte->id] = [
                'id' => $carte->id,
                'nom' => $carte->nom,
                'titre' => $categorie->titre,
                'nb_etudiants' => (int) $carte->nb_etudiants,
                'nb_profs' => max((int) $carte->nb_profs, $liveProfs),
                'revenu_mensuel' => (float) $carte->revenu_mensuel,
            ];
        }
    }

    $etudiantsList = Etudiant::query()
        ->orderByDesc('date_etudiant')
        ->orderByDesc('id')
        ->get();

    $etudiantsIndex = $etudiantsList->keyBy('id')->map(function (Etudiant $etudiant) {
        return [
            'id' => $etudiant->id,
            'reference' => $etudiant->reference,
            'date_etudiant' => optional($etudiant->date_etudiant)->format('Y-m-d'),
            'date_label' => optional($etudiant->date_etudiant)->format('d/m/Y'),
            'date_inscription' => optional($etudiant->date_inscription)->format('Y-m-d'),
            'date_inscription_label' => optional($etudiant->date_inscription)->format('d/m/Y'),
            'nom_complet' => $etudiant->nom_complet,
            'niveau_scolaire' => $etudiant->niveau_scolaire,
            'matiere' => $etudiant->matiere,
            'type_paie' => $etudiant->type_paie,
            'type_paie_label' => $etudiant->type_paie_label,
            'mode_paie' => $etudiant->mode_paie,
            'mode_paie_label' => $etudiant->mode_paie_label,
            'photo_url' => $etudiant->photo ? asset('storage/'.$etudiant->photo) : null,
            'revenu' => (float) $etudiant->revenu,
            'solde' => (float) $etudiant->solde,
            'update_url' => route('admin.etudiants.update', $etudiant),
            'delete_url' => route('admin.etudiants.destroy', $etudiant),
        ];
    });

    $etudiantsStats = [
        'effectifs' => $etudiantsList->count(),
        'revenu' => (float) $etudiantsList->sum('revenu'),
        'solde' => (float) $etudiantsList->sum('solde'),
    ];

    $matiereOptions = MatiereCarte::query()
        ->orderBy('nom')
        ->pluck('nom')
        ->unique()
        ->values();

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
        'profsList' => $profsList,
        'profsIndex' => $profsIndex,
        'profStatuts' => Professeur::statutLabels(),
        'profNiveaux' => Professeur::niveauLabels(),
        'profTypes' => Professeur::typeLabels(),
        'profPaiements' => Professeur::paiementLabels(),
        'nextProfRef' => Professeur::nextReference(),
        'matiereCategories' => $matiereCategories,
        'matieresIndex' => $matieresIndex,
        'matiereOptions' => $matiereOptions,
        'etudiantsList' => $etudiantsList,
        'etudiantsIndex' => $etudiantsIndex,
        'etudiantsStats' => $etudiantsStats,
        'etudiantTypePaies' => Etudiant::typePaieLabels(),
        'etudiantModePaies' => Etudiant::modePaieLabels(),
        'nextEtudiantRef' => Etudiant::nextReference(),
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

Route::post('/admin/profs', [ProfesseurController::class, 'store'])->name('admin.profs.store');
Route::put('/admin/profs/{professeur}', [ProfesseurController::class, 'update'])->name('admin.profs.update');
Route::delete('/admin/profs/{professeur}', [ProfesseurController::class, 'destroy'])->name('admin.profs.destroy');
Route::get('/admin/profs/{professeur}/pdf', [ProfesseurController::class, 'pdf'])->name('admin.profs.pdf');

Route::post('/admin/matieres', [MatiereController::class, 'store'])->name('admin.matieres.store');

Route::post('/admin/etudiants', [EtudiantController::class, 'store'])->name('admin.etudiants.store');
Route::post('/admin/etudiants/{etudiant}', [EtudiantController::class, 'update'])->name('admin.etudiants.update');
Route::delete('/admin/etudiants/{etudiant}', [EtudiantController::class, 'destroy'])->name('admin.etudiants.destroy');
